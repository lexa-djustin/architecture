<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 20:45
 */

namespace Core\Config;

use Symfony\Component\Yaml\Parser;

class YmlReader implements Reader
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function read(): array
    {
        $data = file_get_contents($this->path);

        return (new Parser())->parse($data);
    }
}