<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements;

interface DeliveryElement
{
    public function setDateDelivery(string $date): void;
}