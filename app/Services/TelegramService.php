<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramService
{
    protected $client;
    protected $token;
    protected $chatId;

    public function __construct()
    {
        $this->client = new Client();
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    public function sendMessage($message)
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";
        $response = $this->client->post($url, [
            'form_params' => [
                'chat_id' => $this->chatId,
                'text' => $message,
            ],
        ]);

        return $response->getStatusCode() == 200;
    }
}
