<?php

namespace App\Http\Controllers\Admin\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipPayment;
use App\Models\InternshipAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = InternshipPayment::with(['application', 'attempt'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        $payments = $query->paginate(20)->withQueryString();

        $stats = [
            'total_collected' => InternshipPayment::where('status', 'success')->sum('amount'),
            'pending'         => InternshipPayment::where('status', 'pending')->count(),
            'success'         => InternshipPayment::where('status', 'success')->count(),
            'bkash_pending'   => InternshipPayment::where('payment_method', 'bkash')->where('status', 'pending')->count(),
        ];

        return view('admin.internship.payments.index', compact('payments', 'stats'));
    }

    /**
     * Manually verify a bKash payment.
     */
    public function verify(Request $request, InternshipPayment $payment)
    {
        if ($payment->payment_method !== 'bkash') {
            return back()->with('error', 'Only bKash payments need manual verification.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($request->action === 'approve') {
            $payment->update([
                'status'  => 'success',
                'paid_at' => now(),
            ]);

            // Activate after payment
            $application = $payment->application;
            $application->update(['status' => 'paid']);

            // Create or update intern account
            $account = InternshipAccount::firstOrCreate(
                ['application_id' => $application->id],
                [
                    'user_id'            => null,
                    'category_id'        => $application->preferred_category_id,
                    'registration_token' => Str::uuid()->toString(),
                    'start_date'         => now()->toDateString(),
                    'end_date'           => now()->addMonths(3)->toDateString(),
                    'status'             => 'active',
                ]
            );

            $link = route('internship.register', $account->registration_token);

            // Send Email to the intern
            \Illuminate\Support\Facades\Mail::to($application->email)->send(new \App\Mail\InternPaymentApprovedMail($application, $link));

            return back()->with('success', 'bKash payment approved. Intern account activated. Link for user to register: ' . $link);
        }

        $payment->update(['status' => 'failed']);
        return back()->with('success', 'Payment rejected.');
    }
}
