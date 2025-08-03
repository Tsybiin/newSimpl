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

    private  $pathNew;
    private  $pathSend;



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
         $this->Finder->files()->in($this->pathNew);
         foreach ($this->Finder as $arFile) {
             $arNewKeys[] = [
                 'name' => $arFile->getFilename(),
                 'path' => $this->pathNew .$arFile->getRelativePathname(),
             ];
         }
         dump($arNewKeys);
         $this->arNewKeys = $arNewKeys;
     }

     public function getOneKeyTG() : object
     {
         if($this->arNewKeys){
             return (object) $this->arNewKeys[0];
         } else{
             return false;
         }
     }

     public function keyTransferSend($obKey): void
     {
        $this->copy($obKey->path, $this->pathSend.$obKey->name);
        $this->remove($obKey->path);
     }


 }