<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery;

interface Delivery
{
    public function json(): string;
    public function setWhere(array $params): void;
}