<?php

namespace Bootstrap\Database\Sql;

use Bootstrap\Database\ConnectionInterface;
use Bootstrap\Init\Helpers\Helper;
use \Exception;
use \PDO;
use \PDOException;

/** 
 *  Database SQL Connection
 *
 *  get a PDO database connection,
 *  by loading a config file containing database settings.
 *
 *  @author Leandro Sales
 */
class APIConnection implements ConnectionInterface
{
    /**
     * The database suported drivers.
     *
     * @var array
     */
    private static $supportedDrivers = ['mysql', 'pgsql'];

    /**
     * The database driver.
     *
     * @var array
     */
    public static $driver;

    /**
     * The pdo connection instance.
     *
     * @var PDO
     */
    private static $instance;

    /**
     * A private construct to ensure that there can be only one instance of this 
     * Class to be provided as a global access point.
     */
    private function __construct()
    {
    }
    
    public static function setInstance()
	{
	  self::$instance->exec("SET search_path TO teladoc_api");
	}
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $database = Helper::config('database', 'default');
            $connections = Helper::config('database', 'connections');

            if (!in_array($database, self::$supportedDrivers)) {
                throw new Exception('Database not suported');
            }
            $info = $connections[$database];
            try {
                self::$driver = $info['driver'];
                //Data Source Name
                $dsn = "$info[driver]:dbname=$info[database];host=$info[host];port=$info[port]";

                self::$instance = new PDO(
                    $dsn, 
                    $info['username'], 
                    $info['password']
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$instance->exec("SET search_path TO teladoc_api");
            } catch (PDOException $e) {
                throw new Exception('Database connection failed: '.$e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Destroy connection
     *
     * @return |nul
     */
    public static function destroyInstance()
    {
        if (isset(self::$instance)) {
            $instance = null;
        }
        return $instance;
    }
}