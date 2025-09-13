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
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use TelegramBot\Api\BaseType;

class TelegramController extends AbstractController
{

    private BotApi $obBot;
    private mixed $idChat;
    private mixed $textMenu;
    private object $obUser;

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function sendSms(
        ManagerRegistry $doctrine, ValidatorInterface $validator, UserTGRepository $obUserTGRepository,
        loggerInterface $logger, KeyFileService $obKeyFileService, KeyVpnRepository $obKeyVpnRepository
    ): Response {
        $this->setTextMenu();
        $this->obBot = new BotApi('8239986885:AAHdg_R1RPw6TgG82KvgKeDQHee_1TZPoKA');
     //   $res =    $this->obBot->setWebhook('https://www.land-vpn.store/telegram');
        $arResponse['status'] = false;
        $obContent = $this->getDatacontent();
        if ($obContent) {
            if (property_exists($obContent, 'callback_query')) {
                $commandBot = $obContent->data;
                $this->idChat = $obContent->message['chat']['id'];
                $this->callback_query = $obContent->id;
               $this->obBot->answerCallbackQuery($this->callback_query);
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
            $array_keyboard = [];
            switch ($commandBot) {
                case '/get_key_user';
                    $arKeyUser = $obKeyVpnRepository->getUserKeyById($this->idChat);
                    if (count($arKeyUser) >= 4) {
                        throw new \Exception('Key user > 3');
                    }
                    $this->obBot->sendMessage($this->idChat, 'Ваши активные ключи', 'html');
                    foreach ($arKeyUser as $obKeyUser) {
                        $path = $obKeyFileService->getPathSend() . $obKeyUser->getName();
                        $this->sendKey($path);
                    }
                    break;
                case '/get_key';
                    $arUserKey = $obKeyVpnRepository->getUserKeyById($this->idChat);
                    if (count($arUserKey) < 3) {
                        $obKey = $obKeyFileService->getOneKeyTG();
                        if ($obKey) {
                            $this->sendKey($obKey->path);
                            $obKeyFileService->keyTransferSend($obKey);
                            $obKeyVpnRepository->setKey($obKey, $this->obUser->getIdTelegram());
                        } else {
                            $array_keyboard[] = [
                                [
                                    "url" => "https://t.me/J_planet_old/",
                                    "text" => "Техподдержка",
                                ],
                            ];
                            $inline_keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($array_keyboard);
                            $this->obBot->sendMessage($this->idChat, 'Ключи закончились 🙃', 'html',null,null,$inline_keyboard);
                        }
                    } else {
                        $array_keyboard[] = [
                            ["callback_data" => "/get_key_user", "text" => "Посмотреть мои ключи"],
                            [
                                "url" => "https://t.me/J_planet_old/",
                                "text" => "Техподдержка",
                            ],
                        ];
                        $inline_keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($array_keyboard);
                        $this->obBot->sendMessage(
                            $this->idChat,
                            'Не больше 3 ключей на один аккаунт',
                            'html',
                            null,
                            null,
                            $inline_keyboard
                        );
                    }
                    break;
                case '/start';
                    $array_keyboard = [];
                    // $this->obBot->sendPhoto($this->idChat,'https://s3m.tjcollection.ru/images/category/for_her_shoes.jpg');
                    $array_keyboard[] = [
                        ["callback_data" => "/get_key", "text" => "🗝 Получить ключ 🗝"],
                        ["callback_data" => "/instruction", "text" => "📗 Инструкция 📗"],
                    ];
                      $array_keyboard[] = [
                          ["url" => "https://www.land-vpn.store/agreement", "text" => "📖 Правила 📖"],
                          ["url" => "https://t.me/share/url?url=t.me/lands_vpn_store_bot&text=Бесплатный VPN", "text" => "🔗 Поделиться 🔗"]
                      ];

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
                // case '/exit';
                //
                //         $this->obBot->editMessageReplyMarkup($this->idChat,   $this->idMessage,'remove_keyboard' => true);
                //     break;

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
        $text = '▪️Установите OpenVPN Connect (<a href="https://play.google.com/store/apps/details?id=net.openvpn.openvpn">ANDROID</a>,  <a href="https://itunes.apple.com/us/app/openvpn-connect/id590379981">IOS</a>)
▪️👆Скачайте ключ конфигурации👆 Выше
▪️Импортируйте его в программу и подключитесь.';
        $array_keyboard[] = [
            [
                "url" => "https://www.land-vpn.store/instruction/",
                "text" => "Более подробная инструкция",
            ],
        ];
        $inline_keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($array_keyboard);

        $this->obBot->sendMessage($this->idChat, $text, 'html',true,null,$inline_keyboard);
    }

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    private function sendKey($path, string $status = '')
    {
        $array_keyboard[] = [
            ["callback_data" => "/instruction", "text" => "📗 Инструкция по установке 📗"]
        ];
        $inline_keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($array_keyboard);
        $obDocument = new \CURLFile($path);
        $obDocument->postname = 'land-vpn.ovpn';
        $this->obBot->sendDocument($this->idChat, $obDocument,$status?:'🟢 active',null, $inline_keyboard  );
    }

    /**
     * @return object|bool
     */
    private function setTextMenu()
    {
        $textMenu = '&#173; <b> 🌍 Получите бесплатный VPN! 🌍 </b>
<pre></pre>
Обойдите онлайн ограничения - безопасный, быстрый, безлимитный и удобный VPN. Наш бесплатный VPN поможет вам ускорить игру и защитить безопасность вашей сети в Интернете
Предпочтительный способ для Android и iOS, также работает на компьютерах под любой ОС и маршрутизаторах.
    <pre></pre>
  
<b>Навигация:</b>';
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