<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function createPayment(Scan $scan)
    {
        $typeofwork = $scan->typeofwork;

        if (!$typeofwork) {
            return back()->with('error', 'Type of work not found for the scan.');
        }

        $amount = $typeofwork->my_price * 100; // Amount in cents (or the smallest unit of the currency)

        $client = new Client();
        $merchantId = config('sogecommerce.merchant_id');
        $apiKey = config('sogecommerce.api_key');
        $apiUrl = rtrim(config('sogecommerce.endpoint'), '/'); // Ensure no trailing slash

        // Generate the Base64 encoded credentials
        $username = $merchantId;
        $password = $apiKey;
        $encodedCredentials = base64_encode("$username:$password");

        try {
            $url = $apiUrl . '/api-payment/V4/Charge/CreatePayment';
            Log::info('Payment creation URL: ' . $url); // Log the full URL

            $response = $client->post($url, [
                'json' => [
                    'merchantId' => $merchantId,
                    'amount' => $amount,
                    'currency' => 'EUR', // Use the same format as your Postman test
                    'orderId' => (string)$scan->id,
                    'customer' => [
                        'email' => $scan->doctor->email, // Assuming Scan model has patient relationship
                    ],
                    'normalReturnUrl' => route('doctor.payment.callback'), // URL to handle the payment result
                    'cancelReturnUrl' => route('doctor.orders.index'), // URL if the payment is canceled
                    'automaticResponseUrl' => route('doctor.payment.callback'), // URL for automatic response
                ],
                'headers' => [
                    'Authorization' => 'Basic ' . $encodedCredentials,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Save the payment details
            Payment::create([
                'scan_id' => $scan->id,
                'amount' => $amount,
                'response_data' => json_encode($data),
            ]);

            if (isset($data['answer']) && isset($data['answer']['formToken'])) {
                $formToken = $data['answer']['formToken'];
                return view('doctor.payment.form', compact('formToken'));
            } else {
                Log::error('Payment creation response does not contain formToken.', ['response' => $data]);
                return back()->with('error', 'Failed to create payment.');
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            Log::error('Payment creation failed: ' . $e->getMessage(), [
                'response' => $responseBody,
                'request' => $e->getRequest(),
                'response_code' => $e->getResponse()->getStatusCode(),
                'response_reason' => $e->getResponse()->getReasonPhrase(),
            ]);
            return back()->with('error', 'Failed to create payment. ' . $e->getMessage() . ' Response: ' . $responseBody);
        } catch (\Exception $e) {
            Log::error('Payment creation failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create payment. ' . $e->getMessage());
        }
    }

    public function paymentCallback(Request $request)
    {
        // Log the entire request for debugging
        Log::info('Payment callback received', ['data' => $request->all()]);

        // Extract the JSON payload from 'kr-answer'
        $krAnswer = $request->input('kr-answer');

        // Decode the JSON payload
        $data = json_decode($krAnswer, true);

        // Log the decoded data for debugging
        Log::info('Decoded callback data', ['data' => $data]);

        // Extract the necessary information
        $status = $data['orderStatus'] ?? null;
        $scanId = $data['orderDetails']['orderId'] ?? null;

        Log::info('Status', ['status' => $status]);
        Log::info('Order ID', ['order_id' => $scanId]);

        // Example for debugging purpose
        if ($status && $scanId) {
            $scan = Scan::find($scanId);
            if ($scan) {
                // Update payment status in the payments table
                $payment = Payment::where('scan_id', $scanId)->first();
                if ($payment) {
                    $payment->update([
                        'status' => $status,
                        'response_data' => json_encode($data),
                    ]);

                    // Update the scan's payment status
                    $scan->payment_status = $status;
                    $scan->save();
                }

                return redirect()->route('doctor.orders.show', $scanId);
            }
        } else {
            // Log error if necessary keys are missing
            Log::error('Missing status or order_id in callback data', ['data' => $data]);
        }
    }

    // public function paymentCallback(Request $request)
    // {
    //     dd($request->all());
    //     // Handle the callback from Sogecommerce
    //     $status = $request->input('status');
    //     $scanId = $request->input('order_id');

    //     $scan = Scan::find($scanId);
    //     if ($scan) {
    //         $scan->payment_status = $status;
    //         $scan->save();
    //     }

    //     return redirect()->route('doctor.orders.show', $scanId);
    // }

    public function pay($scanId)
    {
        $scan = Scan::findOrFail($scanId);
        return $this->createPayment($scan);
    }
}
