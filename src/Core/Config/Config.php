<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.10.2019
 * Time: 18:10
 */

namespace Core\Config;


class Config
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $config;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->load();
    }

    /**
     * @throws ConfigFileWasNotFound
     */
    private function load(): void
    {
        if (!file_exists($this->path)) {
            throw new ConfigFileWasNotFound(sprintf(
                'Config on path "%s" was not found.',
                $this->path
            ));
        }

        $this->config = include $this->path;
    }

    public function get(string $path)
    {
        $keys = explode('.', $path);
        $deep = [];
        $config = $this->config;

        while ($keys) {
            $deep[] = $key = array_shift($keys);

            if (!array_key_exists($key, $config)) {
                throw new ConfigKeyWasNotFound(sprintf(
                    'Path "%s" does not exist',
                    implode('.', $deep)
                ));
            }

            $config = $config[$key];
        }

        return $config;
    }
}