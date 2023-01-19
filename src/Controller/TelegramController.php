<?php

namespace App\Controller;

use App\Telegram\Api;
use GingTeam\Telegram\Type\Update;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TelegramController extends AbstractController
{
    #[Route(path: '/setWebhook', name: 'app_setWebhook')]
    public function setWebhook(Api $api, UrlGeneratorInterface $url)
    {
        $api->setWebhook($url->generate('app_webhook', [], UrlGeneratorInterface::ABSOLUTE_URL));

        return new Response();
    }

    #[Route(path: '/webhook', name: 'app_webhook', methods: 'POST')]
    public function webhook(Request $request, Api $api)
    {
        /** @var Update */
        $update = $api->getSerializer()->deserialize($request->getContent(), Update::class, 'json');

        if (null !== $message = $update->getMessage()) {
            $chatId = $message->getChat()->getId();
            $api->sendMessage(
                chat_id: $chatId,
                text: 'chat ID: '.$chatId,
                reply_to_message_id: $message->getMessageId(),
            );
        }

        return new Response();
    }
}
