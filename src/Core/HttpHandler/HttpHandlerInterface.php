<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 13:44
 */

namespace Core\HttpHandler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     */
    public function setRequest(ServerRequestInterface $request): void;

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response): void;
}