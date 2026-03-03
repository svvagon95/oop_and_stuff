<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$user = new App\Models\User("Анна");
echo $user->getName() . PHP_EOL;

$service = new App\Services\UserService();
echo $service->getUserGreeting("Олег") . PHP_EOL;
echo $service->getUserGreeting("Мария") . PHP_EOL;

$order = new App\Models\Order();
$order->log("Заказ создан");