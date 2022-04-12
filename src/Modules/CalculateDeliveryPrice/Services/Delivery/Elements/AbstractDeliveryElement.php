<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements;

abstract class AbstractDeliveryElement implements DeliveryElement
{
    /**
     * Цена доставки
     * @var float
     */
    public float $price = 0;

    /**
     * Ошибка в случае неккоректной работы сервиса (возвращается с JSON ответом)
     * @var string
     */
    public string $error = '';

    /**
     * Идентификатор транспортной компании
     * @var int
     */
    public int $company_id;

    /**
     * Дата доставки
     * @var int|string
     */
    public int|string $delivery_date;

    /**
     * Устанавливает дату доставки
     * @param string $date
     * @return void
     */
    abstract public function setDateDelivery(string $date): void;

    /**
     * @param float|int $price
     */
    public function setPrice(float|int $price): void
    {
        $this->price = $price;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }
}