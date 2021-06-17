<?php

namespace App\Domain\WalletProduct\DataTransfer\Stock;

use App\Core\DataTransfer\DataTransferAbstract;
use App\Domain\WalletProduct\Rules\WalletBelongsUser;
use DateTimeImmutable;

class InsertStockDataTransfer extends DataTransferAbstract
{ 
    protected int $wallet_id;
    protected int $product_id;
    protected float $price;
    protected int $quantity;
    protected float $amount;
    protected DateTimeImmutable $date;
    protected float $rates;

    protected function configureValidatorRules(): array
    {
        return [
            "wallet_id"=> ['bail','required', 'integer', 'exists:wallets,id', new WalletBelongsUser()],
            "product_id"=> ['bail', 'required', 'integer', 'exists:products,id'],
            "price" => ['bail', 'required', 'gt:0', 'numeric'],
            "quantity" => ['bail', 'required', 'gt:0', 'integer'],
            "date" => ['bail', 'required', 'string', 'date'],
            "rates" => ['nullable', 'numeric', 'gt:0'],
        ];
    }

    public static function fromRequest(array $data): self
    {
        return new self($data);
    }

    protected function map(array $data): bool
    {
        $this->wallet_id = $data['wallet_id'];
        $this->product_id = $data['product_id'];
        $this->price = $data['price'];
        $this->quantity = $data['quantity'];
        $this->date = new DateTimeImmutable($data['date']);
        $this->rates = $data['rates'] ?? 0;
        $this->amount = $this->calculateAmount();

        return true;
    }

    private function calculateAmount(): float
    {
        return $this->price * $this->quantity;
    }

    public function fromCreateMoviment(): array
    {
        return [
            'price' => $this->price,
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'date' => $this->date,
            'rates' => $this->rates ,
            'type' => 1
        ];
    }

    public function fromCreateProduct(): array 
    {
        return [
            'wallet_id' => $this->wallet_id,
            'product_id' => $this->product_id,
            'start_date' => $this->date
        ];
    }

}
