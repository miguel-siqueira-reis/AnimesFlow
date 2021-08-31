<?php

namespace App\Http;

class Request {
  protected string $uri;
  protected Dispatch $router;
  protected string $httpMethod;
  protected array $queryParams;
  protected array $postVars;
  protected array $headers;

  public function __construct(Dispatch $router)
  {
    $this->setUri();
    $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->router = $router;
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->headers = getallheaders() ?? [];
  }


  /**
   * @return Router
   */
  public function getRouter(): Router
  {
    return $this->router;
  }

  public function setUri()
  {
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    $xUri = explode('?', $this->uri);
    $this->uri = $xUri[0];
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