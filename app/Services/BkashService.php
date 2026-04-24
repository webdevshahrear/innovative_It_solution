<?php

namespace App\Services;

use App\Models\SiteSetting;

class BkashService
{
    protected string $bkashNumber;
    protected string $accountType;

    public function __construct()
    {
        $this->bkashNumber = SiteSetting::getValue('bkash_number', env('BKASH_NUMBER', ''));
        $this->accountType = SiteSetting::getValue('bkash_account_type', env('BKASH_ACCOUNT_TYPE', 'Personal'));
    }

    /**
     * Get payment instructions for manual bKash payment.
     */
    public function getPaymentInstructions(string $tranId, float $amount): array
    {
        return [
            'bkash_number'  => $this->bkashNumber,
            'account_type'  => $this->accountType,
            'amount'        => $amount,
            'tran_id'       => $tranId,
            'reference'     => 'INT-' . $tranId,
            'steps' => [
                'Open your bKash app',
                'Go to "Send Money"',
                'Enter number: ' . $this->bkashNumber,
                'Amount: ৳' . number_format($amount, 0),
                'Reference: INT-' . $tranId,
                'Complete the transaction',
                'Note your bKash Transaction ID (TrxID)',
                'Enter the TrxID below to confirm your payment',
            ],
        ];
    }

    public function isConfigured(): bool
    {
        return !empty($this->bkashNumber);
    }

    public function getBkashNumber(): string
    {
        return $this->bkashNumber;
    }
}
