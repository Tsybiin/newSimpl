<?php

namespace App\Controller;

use App\Repository\KeyVpnRepository;
use App\Repository\UserTGRepository;
use App\Service\KeyFileService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;
use Psr\Log\LoggerInterface;

class TelegramController extends AbstractController
{

    private \TelegramBot\Api\BotApi $obBot;
    private mixed $idChat;
    private mixed $textMenu;
    private object $obUser;

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function sendSms(
        ManagerRegistry $doctrine, ValidatorInterface $validator, UserTGRepository $obUserTGRepository,
        loggerInterface $logger, KeyFileService $obKeyFileService, KeyVpnRepository $obKeyVpnRepository
    ): Response {
        $this->setTextMenu();
        $this->obBot = new \TelegramBot\Api\BotApi('7629831918:AAENHMwO8xBsBQSXF0Sfbh6eCeNsUBGgPG4');
    //    $res =    $this->obBot->setWebhook('https://www.vpnlands.ru/telegram');
        $arResponse['status'] = false;
        $obContent = $this->getDatacontent();
        if ($obContent) {
            if (property_exists($obContent, 'callback_query')) {
                $commandBot = $obContent->data;
                $this->idChat = $obContent->message['chat']['id'];
            } else {
                $commandBot = $obContent->text;
                $this->idChat = $obContent->chat['id'];

            }
            $obUser = $obUserTGRepository->getUser($this->idChat);
            if ($obUser) {
                $this->obUser = $obUser;
            } else {
                $this->obUser = $obUserTGRepository->setUser((object)($obContent->from));
                $this->obUser->setAuthDate();
            }

            $obUserTGRepository->updateUser($this->obUser);

            switch ($commandBot) {
                case '/get_key';
                    $obKey = $obKeyFileService->getOneKeyTG();
                    if($obKey){
                       $this->sendKey($obKey->path);
                       $obKeyFileService->keyTransferSend($obKey);
                        $obKeyVpnRepository->setKey($obKey,$this->obUser->getIdTelegram());
                    }else{
                        $this->obBot->sendMessage($this->idChat, 'Ключи закончились 🙃', 'html');
                    }

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
            $obUserTGRepository->updateUser($this->obUser);
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
        $this->obBot->sendMessage($this->idChat, 'sendInstruction', 'html');
    }

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    private function sendKey($path)
    {
        $obDocument = new \CURLFile($path);
        $this->obBot->sendDocument($this->idChat, $obDocument);
    }

    /**
     * @return object|bool
     */
    private function setTextMenu()
    {
        $textMenu = '&#173; <b> 🌍Получите бесплатный VPN!🌍</b>
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
    private function getDataContent( bool $fake = false): object|bool
    {
        $obRequest = Request::createFromGlobals();
        if(!$fake){
            file_put_contents('/usr/share/nginx/html/var/log/call.json', print_r($obRequest->getContent(), true));
        }
        $content = $fake ? file_get_contents('/usr/share/nginx/html/var/log/call.json') : $obRequest->getContent();
     //   dump($content);
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