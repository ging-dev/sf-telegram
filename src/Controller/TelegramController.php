<?php

namespace App\Controller;

use App\Telegram\Api;
use GingTeam\Telegram\Type\Update;
use Psr\Log\LoggerInterface;
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
        $api->setWebhook(
            url: $url->generate('app_webhook', [], UrlGeneratorInterface::ABSOLUTE_URL),
            drop_pending_updates: true
        );

        return new Response();
    }

    #[Route(path: '/webhook', name: 'app_webhook', methods: 'POST')]
    public function webhook(Request $request, Api $api, LoggerInterface $logger)
    {
        /** @var Update */
        $update = $api->getSerializer()->deserialize($request->getContent(), Update::class, 'json');

        // to something with $update

        return new Response();
    }

    #[Route(path: '/deleteWebhook', name: 'app_deletewebhook')]
    public function deleteWebhook(Api $api)
    {
        $api->deleteWebhook();

        return new Response();
    }
}
