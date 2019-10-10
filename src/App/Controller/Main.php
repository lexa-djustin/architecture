<?php

namespace App\Controller;

use Core\HttpHandler\AbstractHttpHandler;
use Zend\Diactoros\Response\HtmlResponse;

class Main extends AbstractHttpHandler
{
    public function index()
    {
        var_dump($this->request->getAttribute('blog'));
        exit();

        exit(__CLASS__ . ':' . __FUNCTION__);
    }
}