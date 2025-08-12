<?php

namespace App\Command;

use App\Repository\OpenVpnStatusRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(name: 'APP:OpenVpnStatusCron', description: 'Add a short description for your command',)]
class APPOpenVpnStatusCronCommand extends Command
{
    public function __construct(OpenVpnStatusRepository $repository, LoggerInterface $logger, Filesystem $filesystem)
    {
        $this->openVpnStatusRepository = $repository;
        $this->logger = $logger;
        $this->filesystem = $filesystem;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $startTime = new \DateTime();
        $startTime->setTimezone(new \DateTimeZone('Europe/Moscow'));
        $startTime->setTime(0,00,00);

        $stopTime = new \DateTime();
        $stopTime->setTimezone(new \DateTimeZone('Europe/Moscow'));
        $stopTime->setTime(00,10,00);

        $current = new \DateTime();
        $current->setTimezone(new \DateTimeZone('Europe/Moscow'));

        if ($startTime < $current && $current < $stopTime) {
            return Command::FAILURE;
        }

        $url = '/usr/share/nginx/html/exchange/log/';
        $nameLog = 'openvpn-status.log';
        $this->logger->info("OpenVPN status cron command");
        $vpnStatusLog = file_get_contents($url . $nameLog);
        $vpnStatusLog = preg_replace('#ROUTING.+||.+Since\n#s', '', $vpnStatusLog);
        $arVpnStatusLog = explode("\n", $vpnStatusLog);
        $arKeyUserStatus = [
            'name',
            'ip',
            'bytes_received',
            'bytes_sent',
            'connected_since',
        ];
        $arInStatusList = [];
        foreach ($arVpnStatusLog as $stringUserStatus) {
            if ($stringUserStatus) {
                $arValueList = explode(',', $stringUserStatus);

                $arValue = array_combine($arKeyUserStatus, $arValueList);
                $arInStatusList [] = $this->openVpnStatusRepository->setUserTest($arValue);

            }
        }

        $keyToVpnCheck = array_keys($arInStatusList);
        $arDbKey = $this->openVpnStatusRepository->getList($keyToVpnCheck);
        $arKeyUpdateList = [];
        $arKeyAdd = [];
        foreach ($arInStatusList as $key => $arInStatus) {
            $isKeyExist = array_key_exists($arInStatus->getName(), $arDbKey);
            $isDate = $isKeyExist
                && $arInStatus->getConnectedSince() == $arDbKey[$arInStatus->getName()]->getConnectedSince();
            if ($isKeyExist && $isDate) {
                $id = $arDbKey[$arInStatus->getName()]->getId();
                $arInStatus->setId($id);
                $arKeyUpdateList[] = $arInStatus;
            } else {
                $arKeyAdd [] = $arInStatus;
            }
        }

        // update
        foreach ($arKeyUpdateList as $arKeyUpdate) {
            $this->openVpnStatusRepository->updateUser($arKeyUpdate);
        }
        // add
        foreach ($arKeyAdd as $arValue) {
            $this->openVpnStatusRepository->addUser($arValue);
        }
        return Command::SUCCESS;
    }
}
