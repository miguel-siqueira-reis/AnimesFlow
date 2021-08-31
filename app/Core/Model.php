<?php

namespace App\Core;

use PDO;
use \PDOException;

class Model
{

  use CrudTrait;

  protected string $table;

  protected string $primary = 'id';

  protected array $required = [];

  protected bool $timestamps = true;

  protected string $statament;

  protected $params = null;

  protected string $group = '';

  protected string $order = '';

  protected string $limit = '';

  protected string $offset = '';

  protected ?PDOException $error;

  protected  ?object $data;

  public function __set($name, $value) {
    if (empty($this->data)) {
      $this->data = new \stdClass();
    }
    $this->data->$name = $value;
  }

  public function __isset($name)
  {
    return isset($this->data->$name);
  }

  public function __get($name)
  {
    $method = $this->toCamelCase($name);
    if (method_exists($this, $method)) {
      return $this->$method();
    }

    if (method_exists($this, $name)) {
      return $this->$name();
    }

    return ($this->data->$name ?? null);
  }

  public function columns($mode = PDO::FETCH_OBJ) {
    $stmt = Connection::getInstance()->prepare("DESCRIBE {$this->table}");
    $stmt->execute($this->params);
    return $stmt->fetchAll($mode);
  }

  public function data(): ?object {
    return $this->data;
  }

  public function error() {
    return $this->error;
  }

  public function select(array $columns = ["*"]): Model
  {
    $this->statament = "SELECT ".implode(",", $columns)." FROM $this->table";
    return $this;
  }


  public function find(?string $terms = '', ?string $params = null, string $columns = "*"): Model {
    if (!empty($terms)) {
      $this->statament = "SELECT {$columns} FROM {$this->table} where {$terms}";
      parse_str($params, $this->params);
      return $this;
    }

    $this->statament = "SELECT {$columns} from {$this->table}";
    return $this;
  }

  public function findById(int $id, string $columns = "*"): ?Model
  {
    return $this->find("{$this->primary} = :id", "id={$id}", $columns)->fetch();
  }

  public function group(string $column): ?Model
  {
    $this->group = " GROUP BY {$column}";
    return $this;
  }

  public function order(string $columnOrder): ?Model
  {
    $this->order = " ORDER BY {$columnOrder}";
    return $this;
  }

  public function limit(int $limit): Model {
    $this->limit = " LIMIT {$limit}";
    return $this;
  }

  public function offset(int $offset): Model
  {
    $this->offset = " OFFSET {$offset}";
    return $this;
  }

  public function fetch(bool $all = false)
  {

    try {
      $stmt = Connection::getInstance()->prepare($this->statament . $this->group . $this->order . $this->limit . $this->offset);

      $stmt->execute($this->params);

      if (!$stmt->rowCount()) {
        return null;
      }

      if ($all) {
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
      }

      return $stmt->fetchObject(static::class);

    } catch (PDOException $e) {
      $this->error = $e;
      return null;
    }
  }

  public function count(): int
  {
    $stmt = Connection::getInstance()->prepare($this->statament);
    $stmt->execute($this->params);
    return $stmt->rowCount();
  }

  public function save()
  {
    $primary = $this->primary;
    $id = null;

    try {
      if (!$this->required()) {
        throw new \Exception("preencha os campos necessarios");
      }

      if (!empty($this->data->$primary)) {
        $id = $this->data->$primary;
        $this->update($this->safe(), "{$this->primary} = :id", "id={$id}");
      }

      if (empty($this->data->$primary)) {
        $id = $this->create($this->safe());
      }

      if (!$id) {
        return false;
      }

      $this->data = $this->findById($id)->data();

      return true;
    } catch (PDOException $e) {
      $this->error = $e;
      return false;
    }
  }

  public function destroy(): bool
  {
    $primary = $this->primary;
    $id = $this->data->$primary;

    if (empty($id)) {
      return false;
    }

    return $this->delete("{$this->primary} = :id", "id={$id}");
  }

  public function required(): bool
  {
    $data = (array)$this->data();
    foreach ($this->required as $field) {
      if (empty($data[$field])) {
        if (!is_int($data[$field])) {
          return false;
        }
      }
    }
    return true;
  }

  public function safe()
  {
    $safe = (array)$this->data;
    unset($safe[$this->primary]);
    return $safe;
  }

  protected function toCamelCase($string) {
    $camelcase = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    $camelcase[0] = strtolower($camelcase[0]);
    return $camelcase;
  }
}