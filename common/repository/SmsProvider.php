<?php

namespace common\repository;

use yii\base\Exception;
use yii\httpclient\Client;

class SmsProvider
{
    protected string $token;
    public string $email;
    public string $key;
    private string $baseUrl = 'https://notify.eskiz.uz/api';
    public Client $client;
    public function __construct()
    {
        $this->client = new Client([
            'baseUrl' => $this->baseUrl,
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);
        $this->token = $this->getToken();
    }

    public function getToken()
    {
        try {
            $response = $this->client
                ->post('/auth/login', [
                'email' => \Yii::$app->params['eskiz_email'],
                'password' => \Yii::$app->params['eskiz_key'],
            ])->send();
            return $response->getData()['data']['token'];
        } catch (Exception $exception){
            return [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ];
        }
    }

    public function sendSMS(string $phone_number, $text): bool|array
    {
        $phone_number = $this->sanitizePhone($phone_number);
        try {
            $response = $this->client->createRequest()
                ->setHeaders([
                    'Authorization' => "Bearer {$this->token}"
                ])
                ->setData([
                    'mobile_phone' => $phone_number,
                    'message' => $text,
                    'from' => \Yii::$app->params['nick']
                ])->send();
            return $response->getData();
        } catch (Exception $exception){
            return [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ];
        }
    }

    public function sanitizePhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
}