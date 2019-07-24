<?php

namespace Mvc\Databases\PDO;

use Mvc\Databases\StatementInterface;
use PDOStatement;

class Statement implements StatementInterface
{
    /** @var PDOStatement $statement */
    private $statement;

    /**
     * Statement constructor.
     * @param PDOStatement $statement
     */
    public function __construct(PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param int $type
     * @return void
     */
    public function bind(string $name, $value, int $type)
    {
        $this->statement->bindValue($name, $value, $type);
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        return $this->statement->execute();
    }

    /**
     * @return array|bool
     */
    public function fetch()
    {
        return $this->statement->fetch();
    }
}
