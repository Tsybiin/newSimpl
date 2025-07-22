<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Cassandra\Date;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TelegramController extends AbstractController
{


    public function sertif(ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        // 1. Определите путь к файлу.  Замените этот путь на реальный путь к вашему файлу.
        $filePath = '/usr/share/nginx/html/serf/public.pem';

        // 2. Проверьте существование файла.
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Файл не найден.');
        }

        // 3. Создайте объект Response с файлом.
        $response = new Response(file_get_contents($filePath));

        // 4. Установите заголовки для скачивания файла.
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . 'public.pem' . '"');
        $response->headers->set('Content-Length', filesize($filePath));

        // 5. Верните ответ.
        return $response;
    }

    public function sendSms(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $bot = new \TelegramBot\Api\BotApi('7629831918:AAENHMwO8xBsBQSXF0Sfbh6eCeNsUBGgPG4');
   // $res =    $bot->setWebhook('https://c765e833289b.ngrok-free.app/telegram');
        $request = Request::createFromGlobals();
        $bot->sendMessage('5507845867', $request->getContent());

        $arResponse['status'] = true;
        $arResponse['data']['user_id'] = '776';
        $arResponse['data']['email'] = 'tjtj@eg.ru';
        return new Response($this->json($arResponse));
    }

}