<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Cassandra\Date;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class TelegramController extends AbstractController
{

    private \TelegramBot\Api\BotApi $obBot;
    private mixed $idChat;
    private mixed $textMenu;

    public function sertif(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
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

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function sendSms(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $this->setTextMenu();
        $this->obBot = new \TelegramBot\Api\BotApi('7629831918:AAENHMwO8xBsBQSXF0Sfbh6eCeNsUBGgPG4');
        $arResponse['status'] = false;

        $obContent = $this->getDatacontent();

        if ($obContent) {
            if (property_exists($obContent, 'callback_query')) {
                $commandBot = $obContent->data;
                $this->idChat = $obContent->message['chat']['id'];
            } else {

                $commandBot = $obContent->text;
                $this->idChat = $obContent->chat['id'];;
            }

            file_put_contents('/usr/share/nginx/html/var/log/telegram.php', print_r($obContent, true));
            switch ($commandBot) {
                case '/get_key';
                    $this->sendKey();
                    break;
                case '/start';
                    $array_keyboard = [];
                    // $this->obBot->sendPhoto($this->idChat,'https://s3m.tjcollection.ru/images/category/for_her_shoes.jpg');
                    $array_keyboard[] = [
                        ["callback_data" => "/get_key", "text" => "🗝 Получить ключ 🗝"],
                        ["callback_data" => "/instruction", "text" => "📗 Инструкция 📗"],
                    ];
                    //  $array_keyboard[] = [["callback_data" => "/instruction", "text" => "📗 Инструкция 📗"]];

                    $inline_keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($array_keyboard);
                    $this->obBot->sendMessage(
                        $this->idChat,
                        $this->textMenu,
                        'html',
                        null,
                        null,
                        $inline_keyboard,

                    );
                    break;
                case '/instruction';
                    $this->sendInstruction();
                    break;

            }
            $arResponse['status'] = true;
        }

        return new Response($this->json($arResponse));
    }

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    private function sendInstruction()
    {
        $urlKey = '/usr/share/nginx/html/key/testKey.txt';
        $obDocument = new \CURLFile($urlKey);
        $this->obBot->sendMessage($this->idChat, 'sendInstruction', 'html');
    }

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    private function sendKey()
    {
        $urlKey = '/usr/share/nginx/html/key/testKey.txt';
        $obDocument = new \CURLFile($urlKey);
        $this->obBot->sendDocument($this->idChat, $obDocument);
    }

    /**
     * @return object|bool
     */
    private function setTextMenu()
    {
        $textMenu = '&#173;                        <b> 🌍Получите бесплатный VPN!🌍</b>
<pre></pre>
    Обойдите онлайн ограничения - безопасный, быстрый, безлимитный и удобный VPN. Наш бесплатный VPN поможет вам ускорить игру и защитить безопасность вашей сети в Интернете
    <pre></pre>
<b>Навигация:</b>';
        $textMenu .= '                                                                                  <a href="'
            . $_ENV['SITE_DOMAIN'] . '">сайт</a>';
        $this->textMenu = $textMenu;
        return true;
    }

    /**
     * @param false $fake
     *
     * @return object|bool
     */
    private function getDataContent($fake = false): object|bool
    {
        $obRequest = Request::createFromGlobals();
        //  file_put_contents('/usr/share/nginx/html/var/log/call.json', print_r($obRequest->getContent(), true));
        $content = $fake ? file_get_contents('/usr/share/nginx/html/var/log/call.json') : $obRequest->getContent();
        $arContent = json_decode($content, true);
        foreach (['callback_query', 'message'] as $v) {
            if (array_key_exists($v, $arContent)) {
                if ($v == 'callback_query') {
                    $arContent[$v][$v] = true;
                }
                return (object)$arContent[$v];
            }
        }
        return false;
    }

}