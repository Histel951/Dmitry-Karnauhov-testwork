<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements;

use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Exceptions\DeliveryServiceException;
use DateTime;
use Exception;

class FastDeliveryElement extends AbstractDeliveryElement
{
    /**
     * @param string $date
     * @return void
     * @throws Exception
     */
    public function setDateDelivery(string $date): void
    {
        if ($date = DateTime::createFromFormat('Y-m-d', $date)) {
            $now = new DateTime();
            $interval = $now->diff($date);
            $interval_d = ($this->isMore6Pm()) ? --$interval->d : $interval->d;
            $this->delivery_date = $interval_d;
        } else {
            throw new DeliveryServiceException("Unvalidated \"date\" format \"{$date}\", valid format is \"Y-m-d\"", 1000);
        }
    }

    /**
     * Проверяет считать ли день, если после 18:00 заявки не принимаются
     * @return bool
     */
    private function isMore6Pm(): bool
    {
        $now_timestamp = (new DateTime)->getTimestamp();
        $pm6_timestamp = (new DateTime())->setTime(18, 0)->getTimestamp();

        return $now_timestamp < $pm6_timestamp;
    }
}