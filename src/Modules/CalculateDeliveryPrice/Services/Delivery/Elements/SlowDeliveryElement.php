<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements;

use Exception;
use DateTime;
use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Exceptions\DeliveryServiceException;

class SlowDeliveryElement extends AbstractDeliveryElement
{
    /**
     * Коэфициент для медленной доставки
     * @var float
     */
    public float $coefficient = 1.4;

    /**
     * Цена медленной доставки по умолчанию
     * @var float
     */
    public float $price = 150;

    /**
     * @param string $date
     * @return void
     * @throws Exception
     */
    public function setDateDelivery(string $date): void
    {
        if ($date_instance = DateTime::createFromFormat('Y-m-d', $date)) {
            $this->delivery_date = $date_instance->format('Y-m-d');
        } else {
            throw new DeliveryServiceException("Unvalidated \"date\" format \"{$date}\", valid format is \"Y-m-d\"", 1000);
        }
    }

    /**
     * Расширение параметров по умолчанию (как пример коэфициент)
     * и значение по умолчанию
     * @param float|int $price
     * @return void
     */
    public function setPrice(float|int $price): void
    {
        if ($price) {
            $coefficient_price = $price * $this->coefficient;
        } else {
            $coefficient_price = $this->price * $this->coefficient;
        }

        parent::setPrice($coefficient_price);
    }
}