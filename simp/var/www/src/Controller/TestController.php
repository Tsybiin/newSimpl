<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
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
    public function test(ManagerRegistry $doctrine, ValidatorInterface $validator,LoggerInterface $logger,KeyFileService $obKeyFileService ): Response
    {

     //   $path = '/usr/share/nginx/html/config';


        // найти все файлы текущего каталога
 //    $res =   $finder->files()->in($path);

     $res =   $obKeyFileService->getKey();
dump($res);
// dump($_ENV);
        $arResponse['status'] = false;
        return new Response($this->json($arResponse));


        return new Response($this->json(['$arResponse']));

    }
}