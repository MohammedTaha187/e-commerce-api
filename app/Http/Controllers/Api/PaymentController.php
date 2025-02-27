<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function payment()
    {
        $data = [];

        $data['items'] = [
            [
                'name' => 'Product A',
                'price' => 1000,
                'desc' => 'Subscription to Product A',
                'qty' => 2
            ],
            [
                'name' => 'Product B',
                'price' => 300,
                'desc' => 'Subscription to Product B',
                'qty' => 2
            ]
        ];

        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = 2600;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => $data['total']
                ]
            ]],
            "application_context" => [
                "return_url" => $data['return_url'],
                "cancel_url" => $data['cancel_url']
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
        }

        return response()->json(['error' => __('lang.Something went wrong!')], 500);
    }


    public function cancel()
    {
        return response()->json(['message' => __('lang.Payment was cancelled!')], 200);
    }



    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            return response()->json(['message' => __('lang.Payment successful!')], 200);
        }

        return response()->json(['error' => __('lang.Something went wrong!')], 500);
    }
}
