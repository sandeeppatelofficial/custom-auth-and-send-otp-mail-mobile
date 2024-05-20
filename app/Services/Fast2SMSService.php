<?php

namespace App\Services;

use GuzzleHttp\Client;

class Fast2SMSService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('FAST2SMS_API_KEY');
    }

    public function sendOtp($phoneNumber, $message)
    {
        $url = "https://www.fast2sms.com/dev/bulkV2";

        $response = $this->client->post($url, [
            'headers' => [
                'authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'route' => 'q',
                'message' => $message,
                'language' => 'english',
                'flash' => 0,
                'numbers' => $phoneNumber,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
