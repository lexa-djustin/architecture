<?php

namespace App\Controller;

use Core\HttpHandler\AbstractHttpHandler;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class Main extends AbstractHttpHandler
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->twig->render('main.html'));
    }
}