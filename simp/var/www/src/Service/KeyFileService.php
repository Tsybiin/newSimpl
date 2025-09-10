<?php

namespace App\Service;

use AllowDynamicProperties;
use RecursiveIteratorIterator;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Finder\Finder;

class KeyFileService extends Filesystem
{

    private $pathNew;
    private $pathSend;
    private array $arNewKeys;
    private array $arSendKeys;

    public function getPathSend(): string
    {
        return $this->pathSend;
    }

     public function __construct()
     {
         $this->Finder = new Finder();
         $this->pathNew = $_ENV['PWD'] . '/keys/new/';
         $this->pathSend = $_ENV['PWD'] . '/keys/send/';
         $this->setKeys();
     }

    private function setKeys(): void
    {
        $arNewKeys = [];
        $arSendKeys = [];
        $this->Finder->files()
            ->in($this->pathNew);
        foreach ($this->Finder as $arFile) {
            $arNewKeys[] = [
                'name' => $arFile->getFilename(),
                'path' => $this->pathNew . $arFile->getRelativePathname(),
            ];
        }
        $this->arNewKeys = $arNewKeys;

        $this->Finder->files()
            ->in($this->pathSend);
        foreach ($this->Finder as $arFile) {
            $arSendKeys[] = [
                'name' => $arFile->getFilename(),
                'path' => $this->pathNew . $arFile->getRelativePathname(),
            ];
        }

        $this->arSendKeys = $arSendKeys;


    }

    public function getOneKeyTG(): object|bool
    {
        if ($this->arNewKeys) {
            return (object)$this->arNewKeys[0];
        } else {
            return false;
        }
    }

    public function keyTransferSend($obKey): void
    {
        $this->copy($obKey->path, $this->pathSend . $obKey->name);
        $this->remove($obKey->path);
    }

}