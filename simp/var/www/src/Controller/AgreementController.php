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

class AgreementController extends AbstractController
{
    public function agreement(ManagerRegistry $doctrine, ValidatorInterface $validator,LoggerInterface $logger ): Response
    {
            return $this->render('/agreement.html.twig', [
            ]);
    }
}