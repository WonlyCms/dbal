<?php


namespace Doctrine\DBAL\Driver;


use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\DBAL\Driver\ServerInfoAwareConnection;
use Doctrine\DBAL\Driver\Statement;

class PdoDecoratorConnection implements \Doctrine\DBAL\Driver\Connection, ServerInfoAwareConnection
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $pdo->setAttribute(\PDO::ATTR_STATEMENT_CLASS, PDOStatement::class);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    /**
     * Returns the version number of the database server connected to.
     *
     * @return string
     */
    public function getServerVersion()
    {
        return $this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);
    }

    /**
     * Checks whether a query is required to retrieve the database server version.
     *
     * @return bool True if a query is required to retrieve the database server version, false otherwise.
     */
    public function requiresQueryForServerVersion()
    {
        return false;
    }

    /**
     * Prepares a statement for execution and returns a Statement object.
     *
     * @param  string  $prepareString
     *
     * @return Statement
     */
    public function prepare($prepareString)
    {
        return call_user_func_array([PDOStatement::class, __FUNCTION__], func_get_args());
    }

    /**
     * Executes an SQL statement, returning a result set as a Statement object.
     *
     * @return Statement
     */
    public function query()
    {
        return call_user_func_array([PDOStatement::class, __FUNCTION__], func_get_args());
    }

    /**
     * Quotes a string for use in a query.
     *
     * @param  mixed  $input
     * @param  int    $type
     *
     * @return mixed
     */
    public function quote($input, $type = ParameterType::STRING)
    {
        return call_user_func_array([PDOStatement::class, __FUNCTION__], func_get_args());
    }

    /**
     * Executes an SQL statement and return the number of affected rows.
     *
     * @param  string  $statement
     *
     * @return int
     */
    public function exec($statement)
    {
        return call_user_func_array([PDOStatement::class, __FUNCTION__], func_get_args());
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @param  string|null  $name
     *
     * @return string
     */
    public function lastInsertId($name = null)
    {
        return call_user_func_array([PDOStatement::class, __FUNCTION__], func_get_args());
    }

    /**
     * Initiates a transaction.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function beginTransaction()
    {
        return call_user_func([PDOStatement::class, __FUNCTION__]);
    }

    /**
     * Commits a transaction.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function commit()
    {
        return call_user_func([PDOStatement::class, __FUNCTION__]);
    }

    /**
     * Rolls back the current transaction, as initiated by beginTransaction().
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function rollBack()
    {
        return call_user_func_array([PDOStatement::class, __FUNCTION__], func_get_args());
    }

    /**
     * Returns the error code associated with the last operation on the database handle.
     *
     * @return string|null The error code, or null if no operation has been run on the database handle.
     */
    public function errorCode()
    {
        return call_user_func([PDOStatement::class, __FUNCTION__]);
    }

    /**
     * Returns extended error information associated with the last operation on the database handle.
     *
     * @return mixed[]
     */
    public function errorInfo()
    {
        return call_user_func([PDOStatement::class, __FUNCTION__]);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }

    final public function __wakeup()
    {
        $this->pdo->__wakeup();
    }

    final public function __sleep()
    {
        $this->pdo->__sleep();
    }
}