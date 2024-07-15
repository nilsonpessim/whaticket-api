<?php

namespace Nilsonpessim\ApiConnect;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

class WhatsApp
{
    private $client;
    private $token;
    private $url;
    private $method;
    private $headers;

    public function __construct(string $url, string $token, string $method = "POST")
    {
        $this->client  = new Client();
        $this->url     = $url;
        $this->token   = $token;
        $this->method  = $method;
        $this->headers = $this->setHeaders();
    }

    private function setHeaders(): array
    {
        return [
            "Authorization" => "Bearer {$this->token}",
            "Content-Type"  => "application/json"
        ];
    }

    public function sendMessage(array $body): ?string
    {
        try {
            $response = $this->client->request($this->method, $this->url, [
                'headers' => $this->headers,
                'json'    => $body
            ]);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    private function handleResponse(Response $response): string
    {
        return $response->getBody()->getContents();
    }

    private function handleException(RequestException $e): string
    {
        if ($e->hasResponse()) {
            return $e->getResponse()->getBody()->getContents();
        }
        return $e->getMessage();
    }
}