<?php
declare(strict_types=1);

interface Payable
{
    public function pay(int $amount): void;
}

class BankAccount implements Payable
{
    private int $balance;

    public function __construct(int $initialBalance = 0)
    {
        if ($initialBalance < 0) {
            throw new InvalidArgumentException("Начальный баланс не может быть отрицательным");
        }
        $this->balance = $initialBalance;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function deposit(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Сумма пополнения должна быть больше 0");
        }
        $this->balance += $amount;
    }

    public function withdraw(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Сумма снятия должна быть больше 0");
        }

        if ($amount > $this->balance) {
            throw new RuntimeException("Ошибка: недостаточно средств");
        }

        $this->balance -= $amount;
    }

    public function pay(int $amount): void
    {
        $this->withdraw($amount);
    }


    protected function addToBalance(int $delta): void
    {
        $this->balance += $delta;
    }

    protected function setBalance(int $newBalance): void
    {
        $this->balance = $newBalance;
    }
}


class SavingsAccount extends BankAccount
{
    private float $interestRate; // например 5 = 5%

    public function __construct(int $initialBalance, float $interestRate)
    {
        parent::__construct($initialBalance);

        if ($interestRate < 0) {
            throw new InvalidArgumentException("Процентная ставка не может быть отрицательной");
        }
        $this->interestRate = $interestRate;
    }

    public function applyInterest(): void
    {
        $balance = $this->getBalance();
        $interest = (int) round($balance * ($this->interestRate / 100));
        $this->addToBalance($interest);
    }
}

class CreditAccount extends BankAccount
{
    public function withdraw(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Сумма снятия должна быть больше 0");
        }

        // Разрешаем уходить в минус:
        $this->addToBalance(-$amount);
    }
}

//проверки//

// Задание 1
$account = new BankAccount(1000);
$account->deposit(500);
echo $account->getBalance() . PHP_EOL; // ✅ 1500

$account->withdraw(300);
echo $account->getBalance() . PHP_EOL; //  1200

try {
    $account->withdraw(5000);
} catch (RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL; //  Ошибка: недостаточно средств
}

// Задание 2
$savings = new SavingsAccount(1000, 5);
$savings->applyInterest();
echo $savings->getBalance() . PHP_EOL; //  1050

// Задание 3
$credit = new CreditAccount(1000);
$credit->withdraw(1500);
echo $credit->getBalance() . PHP_EOL; //  -500

// Задание 4
$bank = new BankAccount(500);
$credit2 = new CreditAccount(500);

$bank->pay(200);
echo $bank->getBalance() . PHP_EOL; //  300

$credit2->pay(700);
echo $credit2->getBalance() . PHP_EOL; //  -200