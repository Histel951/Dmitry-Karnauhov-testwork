<?php
namespace Src\Config;

abstract class AbstractConfig implements Config
{
    /**
     * Название директории с конфигами из рут директории проекта
     * @var string
     */
    protected string $config_dir = 'configs';

    protected string $config_file_name = '';

    /**
     * Возвращает массив указанный в файлах с выбранными конфигами
     * @return array
     */
    public function getConfigs(): array
    {
        if (stristr($this->config_file_name, '.php')) {
            $this->config_file_name = substr($this->config_file_name, 0, -4);
        }

        return require "{$this->config_dir}/{$this->config_file_name}.php";
    }
}