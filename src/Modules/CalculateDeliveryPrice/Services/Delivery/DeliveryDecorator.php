<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery;

use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Exceptions\DeliveryServiceException;
use DateTime;

final class DeliveryDecorator implements Delivery
{
    /**
     * Объект доставки
     * @var AbstractDelivery
     */
    private AbstractDelivery $delivery;

    public function __construct(AbstractDelivery $delivery)
    {
        $this->delivery = $delivery;
    }

    /**
     * Форматирование данных JSON в зависимости от объекта
     * Слишком разные поля (в том числе и по типу данных), форматирую вручную.
     * @return string
     * @throws DeliveryServiceException
     */
    public function json(): string
    {
        $delivery_result_data = json_decode($this->delivery->json(), true);
        $result = [];
        if ($this->delivery instanceof SlowDelivery) {
            foreach ($delivery_result_data as $item)
            {
                $result[] = $this->standardizedItemData($item['coefficient'], $item['date'], $item['error']);
            }
            return json_encode($result);
        }

        if ($this->delivery instanceof FastDelivery) {
            foreach ($delivery_result_data as $item)
            {
                $delivery_date = (new DateTime)->modify("+{$item['period']} day")->format('Y-m-d');
                $result[] = $this->standardizedItemData($item['price'], $delivery_date, $item['error']);
            }
            return json_encode($result);
        }

        return json_encode([]);
    }

    public function setWhere(array $params): void
    {
        $this->delivery->setWhere($params);
    }

    /**
     * Возвращает отформатированный элемент массива под стандарт данных
     * @param float $price
     * @param string $date
     * @param string $error
     * @return array
     */
    private function standardizedItemData(float $price, string $date, string $error): array
    {
        return [
            'price' => round($price, PHP_ROUND_HALF_ODD),
            'date' => $date,
            'error' => $error
        ];
    }
}