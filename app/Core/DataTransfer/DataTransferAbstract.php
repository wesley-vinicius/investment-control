<?php

declare(strict_types=1);

namespace App\Core\DataTransfer;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class DataTransferAbstract
{
    public function __construct(array $data)
    {
        $this->validator($data);

        $this->map($data);
    }

    public function __get($key)
    {
        if (method_exists($this, 'get' . Str::camel($key))) {
            return $this->{'get'. Str::camel($key)}();
        }
        return $this->{$key};
    }

    protected function validator(array $data)
    {
        $rules = $this->configureValidatorRules();
        return Validator::make($data, $rules)->validate();
    }

    abstract protected function configureValidatorRules(): array;

    abstract protected function map(array $data): bool;
}
