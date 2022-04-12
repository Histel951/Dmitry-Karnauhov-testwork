<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery;

use Src\Database\Models\Model;
use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements\AbstractDeliveryElement;
use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements\DeliveryElement;
use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Exceptions\DeliveryServiceException;
use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Models\DeliveryElementModel;
use Exception;

abstract class AbstractDelivery implements Delivery
{
    /**
     * Класс элемента доставки
     * @var string
     */
    protected string $element_class = AbstractDeliveryElement::class;

    /**
     * Класс модельки для автоинициализации в классе
     * @var string
     */
    protected string $model_class = DeliveryElementModel::class;

    /**
     * Модель для работы с БД
     * @var Model|mixed
     */
    protected DeliveryElementModel $model;

    /**
     * Массив элементов
     * @var AbstractDeliveryElement[]
     */
    protected array $elements = [];

    /**
     * Массив критерий выборки для where
     * @var array
     */
    protected array $params = [];

    /**
     * Откуда везём
     * @var string
     */
    public string $sourceKladr;

    /**
     * Куда везём
     * @var string
     */
    public string $targetKladr;

    /**
     * Вес отправления в кг
     * @var float
     */
    public float $weight;

    public function __construct()
    {
        $this->model = new $this->model_class();
    }

    /**
     * Формирует массив возвращаемых данных
     * @param AbstractDeliveryElement $element
     * @return array
     */
    abstract protected function formatJson(AbstractDeliveryElement $element): array;

    /**
     * Эмуляция получения ID компании которой принадлежит элемент доставки
     * @return int
     */
    abstract protected function getCompanyId(): int;

    /**
     * Устанавливает "WHERE" параметры для подтягивания из базы
     * @param array $params
     * @return void
     */
    public function setWhere(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Возвращает сформированный JSON
     * @return string
     * @throws DeliveryServiceException
     */
    public function json(): string
    {
        $this->getElements();

        $result = [];
        foreach ($this->elements as $element)
        {
            $result[] = $this->formatJson($element);
        }
        return json_encode($result);
    }

    /**
     * @param string $sourceKladr
     */
    public function setSourceKladr(string $sourceKladr): void
    {
        $this->sourceKladr = $sourceKladr;
    }

    /**
     * @param string $targetKladr
     */
    public function setTargetKladr(string $targetKladr): void
    {
        $this->targetKladr = $targetKladr;
    }

    /**
     * @param float $weight
     * @return void
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return void
     * @throws DeliveryServiceException
     */
    private function getElements(): void
    {
        $this->validateDependencies();
        $this->setWhere(['company_id' => $this->getCompanyId()]);
        $fetch_result = $this->model->findWhereEquals($this->params)->fetch_all(MYSQLI_ASSOC);
        foreach ($fetch_result as $item)
        {
            $new_element = new $this->element_class();
            $new_element->setPrice($item['price']);
            try {
                $new_element->setDateDelivery($item['date']);
            } catch (Exception $exception) {
                $new_element->setError($exception->getMessage());
            }

            $this->elements[] = $new_element;
        }
    }

    /**
     * Проверяет все переданные зависимости
     * @return void
     * @throws DeliveryServiceException
     */
    private function validateDependencies(): void
    {
        if (!$this->element_class) {
            $interface = DeliveryElement::class;
            throw new DeliveryServiceException("Dependency \"{$interface}\" class is null.");
        }
    }
}