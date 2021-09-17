<?php

namespace App\Jobs;

use GuzzleHttp\Client;

class notificationsJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function sendNotification(int $idUser, string $message) {
        $notification = new Client([
            'base_uri' => 'http://o4d9z.mocklab.io',
            'verify' => false
        ]);
        $response = $notification->get('/notify');
        $message = json_decode($response->getBody());
        return ['status' => $response['statusCode'], 'message' => $message->message];
    }
}
