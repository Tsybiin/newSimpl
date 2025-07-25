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

class TestController extends AbstractController
{
    public function test(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {


        dump($_ENV['TELEGRAM_BOT']);


        return new Response($this->json(['$arResponse']));

    }
}