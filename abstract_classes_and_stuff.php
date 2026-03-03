<?php
declare(strict_types=1);

abstract class Shape
{
    abstract public function getArea(): float;
}

interface Drawable
{
    public function draw(): void;
}

class Rectangle extends Shape implements Drawable
{
    private float $width;
    private float $height;

    public function __construct(float $width, float $height)
    {
        if ($width <= 0 || $height <= 0) {
            throw new InvalidArgumentException("Ширина и высота должны быть больше 0");
        }
        $this->width = $width;
        $this->height = $height;
    }

    public function getArea(): float
    {
        return $this->width * $this->height;
    }

    public function draw(): void
    {
        echo "Рисую прямоугольник шириной {$this->width} и высотой {$this->height}" . PHP_EOL;
    }
}

class Circle extends Shape implements Drawable
{
    private float $radius;

    public function __construct(float $radius)
    {
        if ($radius <= 0) {
            throw new InvalidArgumentException("Радиус должен быть больше 0");
        }
        $this->radius = $radius;
    }

    public function getArea(): float
    {
        return M_PI * $this->radius * $this->radius;
    }

    public function draw(): void
    {
        echo "Рисую круг радиусом {$this->radius}" . PHP_EOL;
    }
}

function renderShape(Shape $shape): void
{
    if ($shape instanceof Drawable) {
        $shape->draw();
    }

    $area = $shape->getArea();
    echo "Площадь: " . round($area, 2) . PHP_EOL;
}

abstract class Vehicle
{
    abstract public function move(): void;
}

interface Fuelable
{
    public function refuel(): void;
}

class Car extends Vehicle implements Fuelable
{
    public function move(): void
    {
        echo "Машина едет" . PHP_EOL;
    }

    public function refuel(): void
    {
        echo "Машина заправлена" . PHP_EOL;
    }
}

class Bike extends Vehicle
{
    public function move(): void
    {
        echo "Велосипед едет" . PHP_EOL;
    }
}

//Проверки//


$rect = new Rectangle(10, 5);
echo $rect->getArea() . PHP_EOL;

$circle = new Circle(7);
echo round($circle->getArea(), 2) . PHP_EOL;


$rect->draw();
$circle->draw();

renderShape(new Rectangle(5, 5));

renderShape(new Circle(3));


$car = new Car();
$car->move();
$car->refuel();

$bike = new Bike();
$bike->move();