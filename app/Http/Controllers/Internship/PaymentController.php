<?php

namespace App\Http\Controllers\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipExamAttempt;
use App\Models\InternshipPayment;
use App\Services\SSLCommerzService;
use App\Services\BkashService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct(
        protected SSLCommerzService $sslcommerz,
        protected BkashService $bkash
    ) {}

    /**
     * Show the payment selection page.
     */
    public function show(InternshipExamAttempt $attempt)
    {
        if (!$attempt->isPassed()) {
            return redirect()->route('internship.result', $attempt)
                ->with('error', 'You must pass the exam to proceed to payment.');
        }

        // Check if already paid
        $existingPayment = InternshipPayment::where('attempt_id', $attempt->id)
            ->where('status', 'success')
            ->first();

        if ($existingPayment) {
            // Already paid — redirect to registration or dashboard
            if ($attempt->application->account) {
                return redirect()->route('intern.dashboard')
                    ->with('info', 'Payment already completed.');
            }
            $token = $attempt->application->account->registration_token ?? null;
            if ($token) {
                return redirect()->route('internship.register', $token);
            }
        }

        $amount        = (float) env('INTERNSHIP_SECURITY_FEE', 1000);
        $bkashInfo     = $this->bkash->getPaymentInstructions('', $amount);
        $sslConfigured = $this->sslcommerz->isConfigured();
        $bkashConfigured = $this->bkash->isConfigured();

        return view('internship.payment', compact(
            'attempt', 'amount', 'bkashInfo', 'sslConfigured', 'bkashConfigured'
        ));
    }

    /**
     * Initiate SSLCommerz payment.
     */
    public function processSSL(Request $request, InternshipExamAttempt $attempt)
    {
        if (!$attempt->isPassed()) abort(403);

        $application = $attempt->application;
        $amount      = (float) env('INTERNSHIP_SECURITY_FEE', 1000);
        $tranId      = 'INT-' . strtoupper(Str::random(10)) . '-' . $attempt->id;

        // Create pending payment record
        $payment = InternshipPayment::create([
            'application_id' => $application->id,
            'attempt_id'     => $attempt->id,
            'amount'         => $amount,
            'tran_id'        => $tranId,
            'payment_method' => 'sslcommerz',
            'status'         => 'pending',
        ]);

        $result = $this->sslcommerz->initiatePayment([
            'total_amount' => $amount,
            'tran_id'      => $tranId,
            'success_url'  => route('internship.payment.success'),
            'fail_url'     => route('internship.payment.fail'),
            'cancel_url'   => route('internship.payment.cancel'),
            'cus_name'     => $application->full_name,
            'cus_email'    => $application->email,
            'cus_phone'    => $application->phone,
            'cus_add1'     => $application->address,
        ]);

        if (!$result['success']) {
            $payment->update(['status' => 'failed']);
            return back()->with('error', 'Payment gateway error: ' . $result['error']);
        }

        // Store tran_id in session for verification
        session(['payment_tran_id' => $tranId]);

        return redirect($result['gateway_url']);
    }

    /**
     * Process bKash manual payment submission.
     */
    public function processBkash(Request $request, InternshipExamAttempt $attempt)
    {
        if (!$attempt->isPassed()) abort(403);

        $request->validate([
            'bkash_number'         => 'required|string|regex:/^01[3-9]\d{8}$/',
            'bkash_transaction_id' => 'required|string|min:6|max:20',
        ], [
            'bkash_number.regex'   => 'Please enter a valid Bangladesh mobile number.',
        ]);

        $application = $attempt->application;
        $amount      = (float) env('INTERNSHIP_SECURITY_FEE', 1000);
        $tranId      = 'BKS-' . strtoupper(Str::random(8)) . '-' . $attempt->id;

        // Check for duplicate bKash TrxID
        $duplicate = InternshipPayment::where('bkash_transaction_id', $request->bkash_transaction_id)
            ->exists();
        if ($duplicate) {
            return back()->with('error', 'This bKash Transaction ID has already been submitted.');
        }

        InternshipPayment::create([
            'application_id'       => $application->id,
            'attempt_id'           => $attempt->id,
            'amount'               => $amount,
            'tran_id'              => $tranId,
            'payment_method'       => 'bkash',
            'status'               => 'pending', // Admin verifies manually
            'bkash_number'         => $request->bkash_number,
            'bkash_transaction_id' => $request->bkash_transaction_id,
        ]);

        return redirect()->route('internship.payment.bkash-pending')
            ->with('success', 'bKash payment submitted! An admin will verify your payment shortly (usually within 24 hours). You will receive confirmation via email.');
    }

    /**
     * SSLCommerz success callback (POST).
     */
    public function success(Request $request)
    {
        $valId  = $request->input('val_id');
        $tranId = $request->input('tran_id');

        $payment = InternshipPayment::where('tran_id', $tranId)->first();

        if (!$payment) {
            return redirect()->route('internship.landing')->with('error', 'Payment record not found.');
        }

        // Validate with SSLCommerz
        $isValid = $this->sslcommerz->validatePayment($valId);

        if ($isValid) {
            $payment->update([
                'val_id'           => $valId,
                'status'           => 'success',
                'paid_at'          => now(),
                'gateway_response' => $request->all(),
            ]);

            $this->activateAfterPayment($payment);

            return redirect()->route('internship.register', $payment->application->account->registration_token)
                ->with('success', '🎉 Payment successful! Please create your intern account.');
        }

        $payment->update(['status' => 'failed', 'gateway_response' => $request->all()]);
        return view('internship.payment-fail', ['message' => 'Payment validation failed.']);
    }

    /**
     * SSLCommerz fail callback.
     */
    public function fail(Request $request)
    {
        $tranId = $request->input('tran_id');
        InternshipPayment::where('tran_id', $tranId)->update([
            'status'           => 'failed',
            'gateway_response' => $request->all(),
        ]);

        return view('internship.payment-fail', ['message' => 'Payment was unsuccessful. Please try again.']);
    }

    /**
     * SSLCommerz cancel callback.
     */
    public function cancel(Request $request)
    {
        $tranId = $request->input('tran_id');
        InternshipPayment::where('tran_id', $tranId)->update([
            'status'           => 'cancelled',
            'gateway_response' => $request->all(),
        ]);

        return view('internship.payment-cancel');
    }

    public function bkashPending()
    {
        return view('internship.payment-bkash-pending');
    }

    protected function activateAfterPayment(InternshipPayment $payment): void
    {
        $application = $payment->application;
        
        // Skip if account already exists
        if ($application->account) {
            return;
        }

        $token = Str::uuid()->toString();

        $application->update(['status' => 'paid']);

        \App\Models\InternshipAccount::create([
            'application_id'     => $application->id,
            'user_id'            => null, // Corrected: make nullable to allow creation before user registration
            'category_id'        => $application->preferred_category_id,
            'registration_token' => $token,
            'start_date'         => now()->toDateString(),
            'end_date'           => now()->addMonths(3)->toDateString(),
            'status'             => 'active',
        ]);
    }
}
