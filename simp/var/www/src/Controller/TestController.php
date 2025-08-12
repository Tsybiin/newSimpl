<?php

namespace App\Controller;

use App\Cron\OpenVpnStatusCron;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OpenVpnStatusRepository;
use App\Repository\UserTGRepository;
use Cassandra\Date;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\KeyVpn;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\KeyFileService;
use Symfony\Component\Finder\Finder;

class TestController extends AbstractController
{
    public function test(ManagerRegistry $doctrine, ValidatorInterface $validator,LoggerInterface $logger ): Response
    {

        $url = '/usr/share/nginx/html/exchange/log/openvpn-status.log';


        $dataNow =  new \DateTime('Mon Aug  4 19:44:34 2025');
        $date = $dataNow->setTimezone(new \DateTimeZone('Europe/Moscow'));

        return new Response($this->json(['$arResponse']));

    }
}