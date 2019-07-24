<?php

namespace Mvc\Databases\PDO;

use DateTime;
use Mvc\Databases\ConnectionInterface;
use Mvc\Databases\StatementInterface;
use PDO;

/**
 * Class Connection
 * @package Mvc\Databases\PDO
 */
class Connection extends PDO implements ConnectionInterface
{
    const TYPE = [
        'integer' => parent::PARAM_INT,
        'boolean' => parent::PARAM_BOOL
    ];

    /**
     * Connection constructor.
     * @param $dsn
     * @param null $username
     * @param null $passwd
     * @param null $options
     */
    public function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        parent::__construct($dsn, $username, $passwd, $options);
        parent::setAttribute(parent::ATTR_DEFAULT_FETCH_MODE, parent::FETCH_ASSOC);
        parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);
        parent::setAttribute(parent::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * @param string $statement
     * @param array $params
     * @return StatementInterface
     */
    public function request(string $statement, array $params = []): StatementInterface
    {
        $request = new Statement($this->prepare($statement));

        foreach ($params as $field => $value) {
            $paramType = gettype($value);
            $bindType = parent::PARAM_STR;

            if ($value instanceof DateTime) {
                $value = $value->format('Y-m-d H:i:s');
            } elseif (array_key_exists($paramType, self::TYPE)) {
                $bindType = self::TYPE[$paramType];
            } elseif ($value === null) {
                $bindType = parent::PARAM_NULL;
            }

            $request->bind($field, $value, $bindType);
        }

        $request->execute();
        return $request;
    }
}
