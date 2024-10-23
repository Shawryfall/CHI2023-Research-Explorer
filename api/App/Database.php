<?php

namespace App;

/**
 * Database class for managing database connections and queries.
 *
 * This class provides functionality to connect to a database and execute SQL queries.
 * It uses the PDO extension for database access.
 * 
 * @author Patrick Shaw
 */
class Database 
{
    /**
     * @var \PDO Represents the PDO database connection.
     */
    private $dbConnection;
  
    /**
     * Constructor for the Database class.
     *
     * Initializes the database connection using a provided database name.
     *
     * @param string $dbName The name of the database file for SQLite.
     */
    public function __construct($dbName) 
    {
        $this->setDbConnection($dbName);  
    }
 
    /**
     * Sets up the database connection.
     *
     * This method creates a new PDO connection to the specified SQLite database.
     * It also configures the error mode for the PDO connection.
     *
     * @param string $dbName The name of the database file for SQLite.
     */
    private function setDbConnection($dbName) 
    {
        $this->dbConnection = new \PDO('sqlite:'.$dbName);
        $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * Executes an SQL query using the current database connection.
     *
     * This method prepares and executes an SQL statement using provided parameters.
     * It returns the result as an associative array.
     *
     * @param string $sql The SQL query to be executed.
     * @param array $params Optional parameters to bind to the SQL query.
     * @return array The result set as an associative array.
     */
    public function executeSQL($sql, $params=[])
    { 
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
