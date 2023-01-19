<?php

namespace App\Telegram;

use GingTeam\Telegram\TelegramTrait;
use GingTeam\Telegram\Type\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Api
{
    use TelegramTrait;

    public function __construct(private HttpClientInterface $client, private SerializerInterface $serializer)
    {
    }

    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    public function sendRequest(string $name, array $data = [])
    {
        $data = $this->getSerializer()->normalize((object) $data);

        $endpoint = sprintf('%s/bot%s/%s', self::BOT_API_URL, $_ENV['BOT_TOKEN'], $name);

        $content = $this->client->request('POST', $endpoint, [
            'json' => $data,
        ])->getContent(false);

        /** @var Response */
        $response = $this->getSerializer()->deserialize($content, Response::class, 'json');

        if ($response->getErrorCode()) {
            throw new \RuntimeException($response->getDescription());
        }

        return $response->getResult();
    }
}
