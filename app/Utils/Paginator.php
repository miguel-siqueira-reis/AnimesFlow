<?php

namespace App\Utils;

class Paginator
{
  private int $limit;

  private int $results;

  private int $pages;

  private int $currentPage;

  public function __construct($results, int $currentPage = 1, int $limit = 10)
  {
    $this->results = $results;
    $this->limit = $limit;
    $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
    $this->calculate();
  }

  public function calculate(): void
  {
    $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;
    $this->currentPage = $this->currentPage <= $this->pages ?  $this->currentPage : $this->pages;
  }

  public function limit(): int
  {
    return $this->limit;
  }

  public function offset(): int
  {
    return ($this->limit * ($this->currentPage - 1));
  }

  /**
   * @return int
   */
  public function results(): int
  {
    return $this->results;
  }

  /**
   * @return int|string
   */
  public function currentPage()
  {
    return $this->currentPage;
  }

  public function pages()
  {
    return $this->pages;
  }
}
