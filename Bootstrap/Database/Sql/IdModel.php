<?php

namespace Bootstrap\Database\Sql;

use App\Models\ErrorLog;
use App\Wrappers\MongoWrapper;
use Bootstrap\Database\Sql\IdConnection as Connection;
use Bootstrap\Database\ModelInterface;
use \Exception;
use \PDO;
use \PDOException;

abstract class IdModel implements ModelInterface
{
    private $db;
    protected $table;
    protected $fillables;
    protected $timestamps = false;

    /**
     * Conexão com o Banco
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    /**
     * Retorna todos os registros de uma tabela
     */
    public function fetchAll($stmt)
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Consultar um único registro por ID
     */
    public function fetch($stmt)
    {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna todos os registros de uma tabela
     */
    public function prepare($query)
    {
        return $this->db->prepare($query);
    }

    /**
     * Retorna todos os registros de uma tabela
     */
    public function execute($stmt)
    {
        return $stmt->execute();
    }

    public function lastInsertedId()
    {
        try {
            return $this->db->lastInsertId();
        } catch (PDOException $error) {
            return $error;
        }
    }

    /**
     * Retorna todos os registros de uma tabela
     */
    public function select()
    {
        $columns = "*";

        if (!empty($this->fillables)) {
            if ($this->timestamps) {
                $this->fillables[] = 'created_at';
                $this->fillables[] = 'updated_at';
            }
            $columns = implode(',', $this->fillables);
        }
        $query = "Select {$columns} from $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna todos os registros de uma tabela
     */
    public function paginatedSelect($offset, $limit, $order = null)
    {
        $columns = "*";

        if (!empty($this->fillables)) {
            if ($this->timestamps) {
                $this->fillables[] = 'created_at';
                $this->fillables[] = 'updated_at';
            }
            $columns = implode(',', $this->fillables);
        }
        $query = "Select {$columns}, count(*) OVER() AS full_count from $this->table OFFSET $offset LIMIT $limit";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $data
     * @return string
     * @throws Exception
     */
    public function insert($data)
    {
        if (!empty($this->fillables)) {
            $columnsArray = array_intersect($this->fillables, array_keys($data));
        }
        $columns = implode(', ', $columnsArray);

        $values = ':' . implode(', :', $columnsArray);

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($values)";

        $stmt = $this->db->prepare($query);
        foreach ($columnsArray as $value) {
            $stmt->bindValue(':' . $value, $data[$value]);
        }
        try {
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Atualiza um registro na tabela por ID
     */
    public function update($id, $data)
    {
        if (!empty($this->fillables)) {
            $data = array_filter($data, function ($value, $key) {
                return in_array($key, $this->fillables);
            }, ARRAY_FILTER_USE_BOTH);
        }

        if (!empty($data)) {
            $valuesArray = [];
            foreach ($data as $key => $value) {
                $valuesArray[] = "$key=:$key";
            }

            $values = implode(',', $valuesArray);
            $query = "UPDATE {$this->table} SET $values WHERE id=:id";

            $stmt = $this->db->prepare($query);

            try {
                $data['id'] = $id;
                $stmt->execute($data);

                return true;
            } catch (PDOException $e) {
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }
    }

    /**
     * Consultar um único registro por ID
     */
    public function find($id, $withSoftDelete = false)
    {
        $query = "Select *  from $this->table WHERE id=:id";
        if ($withSoftDelete) {
            $query = $query . ' AND deleted_at is null';
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Exclui uma linha da tabela por ID
     */
    public function delete($id)
    {
        $query = "Delete from $this->table WHERE id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

}
