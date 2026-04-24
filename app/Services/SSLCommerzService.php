<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SiteSetting;

class SSLCommerzService
{
    protected string $storeId;
    protected string $storePassword;
    protected bool   $isSandbox;
    protected string $initUrl;
    protected string $validationUrl;

    public function __construct()
    {
        // Pull from SiteSettings (admin-configurable) with .env fallback
        $this->storeId       = SiteSetting::getValue('sslcommerz_store_id', env('SSLCOMMERZ_STORE_ID', ''));
        $this->storePassword = SiteSetting::getValue('sslcommerz_store_password', env('SSLCOMMERZ_STORE_PASSWORD', ''));
        $this->isSandbox     = (bool) env('SSLCOMMERZ_SANDBOX', true);

        $this->initUrl       = $this->isSandbox
            ? env('SSLCOMMERZ_SANDBOX_URL', 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php')
            : env('SSLCOMMERZ_LIVE_URL', 'https://securepay.sslcommerz.com/gwprocess/v4/api.php');

        $this->validationUrl = $this->isSandbox
            ? 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php'
            : 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php';
    }

    /**
     * Initiate a payment session and return the gateway URL.
     */
    public function initiatePayment(array $params): array
    {
        $postData = array_merge([
            'store_id'      => $this->storeId,
            'store_passwd'  => $this->storePassword,
            'currency'      => 'BDT',
            'cus_country'   => 'Bangladesh',
            'shipping_method' => 'NO',
            'num_of_item'   => 1,
            'product_name'  => 'Internship Security Fee',
            'product_category' => 'Digital Service',
            'product_profile' => 'general',
        ], $params);

        try {
            $response = Http::asForm()->timeout(30)->post($this->initUrl, $postData);

            $data = $response->json();

            if (isset($data['status']) && $data['status'] === 'SUCCESS') {
                return [
                    'success'     => true,
                    'gateway_url' => $data['GatewayPageURL'],
                    'session_key' => $data['sessionkey'] ?? null,
                ];
            }

            Log::error('SSLCommerz init failed', ['response' => $data]);
            return ['success' => false, 'error' => $data['failedreason'] ?? 'Payment gateway error.'];

        } catch (\Exception $e) {
            Log::error('SSLCommerz exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'error' => 'Could not connect to payment gateway.'];
        }
    }

    /**
     * Validate a payment after SSLCommerz redirects back.
     */
    public function validatePayment(string $valId): bool
    {
        try {
            $response = Http::get($this->validationUrl, [
                'val_id'       => $valId,
                'store_id'     => $this->storeId,
                'store_passwd' => $this->storePassword,
                'format'       => 'json',
            ]);

            $data = $response->json();

            return isset($data['status']) && $data['status'] === 'VALID';

        } catch (\Exception $e) {
            Log::error('SSLCommerz validation exception', ['message' => $e->getMessage()]);
            return false;
        }
    }

    public function isConfigured(): bool
    {
        return !empty($this->storeId) && !empty($this->storePassword);
    }
}
