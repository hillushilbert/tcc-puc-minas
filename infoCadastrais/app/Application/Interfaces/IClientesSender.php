<?php 

namespace App\Application\Interfaces;

interface IClientesSender {

    public function createQueue();

    public function createChannel();

    public function sendMensage(string $mensage);
}