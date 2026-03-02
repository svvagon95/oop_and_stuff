<?php

declare(strict_types=1);

trait Loggable
{
    public function log(string $message): void
    {
        echo "[LOG]: {$message}\n";
    }
}

interface Movable
{
    public function move(): string;
}

class Car implements Movable
{
    use Loggable;

    private string $brand;
    private string $model;
    private int $year;

    public function __construct(string $brand, string $model, int $year)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->setYear($year);
    }

    public function getCarInfo(): string
    {
        return "{$this->brand} {$this->model}, {$this->year}";
    }


    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        // простая валидация (можешь менять правила как хочешь)
        if ($year < 1886 || $year > (int)date('Y') + 1) {
            throw new InvalidArgumentException("Некорректный год выпуска: {$year}");
        }
        $this->year = $year;
    }


    public function move(): string
    {
        return "Машина едет";
    }
}

class ElectricCar extends Car
{
    private int $batteryCapacity; // kWh

    public function __construct(string $brand, string $model, int $year, int $batteryCapacity)
    {
        parent::__construct($brand, $model, $year);
        $this->batteryCapacity = $batteryCapacity;
    }

    public function getBatteryInfo(): string
    {
        return "Батарея: {$this->batteryCapacity} kWh";
    }
}

class Bicycle implements Movable
{
    public function move(): string
    {
        return "Велосипед движется";
    }
}

// Проверки//


$car = new Car("Toyota", "Camry", 2020);
echo $car->getCarInfo() . "\n";
// ✅ "Toyota Camry, 2020"


$car->setYear(2022);
echo $car->getYear() . "\n";
// ✅ 2022


$tesla = new ElectricCar("Tesla", "Model S", 2021, 100);
echo $tesla->getBatteryInfo() . "\n";



$car2 = new Car("Ford", "Focus", 2019);
echo $car2->move() . "\n";


$bike = new Bicycle();
echo $bike->move() . "\n";



$car2->log("Запущен двигатель");
