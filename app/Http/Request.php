<?php

namespace App\Http;

class Request {
    protected string $uri;
    protected string $httpMethod;
    protected array $queryParams;
    protected array $postVars;
    protected array $headers;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders() ?? [];
    }


    /**
     * @return array|false
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @return mixed|string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return mixed|string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

}