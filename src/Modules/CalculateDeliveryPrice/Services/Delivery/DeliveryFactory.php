<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery;

final class DeliveryFactory
{
    /**
     * Инициализирует службу быстрой доставки
     * @return Delivery
     */
    public function fast(): Delivery
    {
        return new DeliveryDecorator(new FastDelivery);
    }

    /**
     * Инициализирует службу медленной доставки
     * @return Delivery
     */
    public function slow(): Delivery
    {
        return new DeliveryDecorator(new SlowDelivery);
    }
}