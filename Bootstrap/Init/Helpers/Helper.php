<?php

namespace Bootstrap\Init\Helpers;

use \Exception;
use Dotenv\Dotenv;

class Helper
{
    static private $config;

    static private $configFilename = '';

    static function env(String $key, $default = null)
    {   
        $envValue = $default;
        $envPath = __DIR__.'/../../../';

        if(file_exists($envPath)){
            $dotenv = Dotenv::create($envPath);
            $dotenv->load();

            $envValue = getenv($key);
            $envValue = $envValue == 'true'? true : ($envValue == 'false' ? false : $envValue);

            if (empty($envValue)) {
                $envValue = $default;
            }
        }

        return $envValue;
    }

    static function config(String $filename, String $key = '')
    {
        $configDir = __DIR__.'/../../../src/Config/';
        $configPath = $configDir.$filename.'.php';
        $config = array();

        if(file_exists($configPath)){
            if (empty(self::$config)) {
                self::$configFilename = $filename;
                self::$config = include $configPath;
            } else if (self::$configFilename != $filename){
                self::$config = include $configPath;
                self::$configFilename = $filename;
            }
            $config = self::$config;
            if (!empty($key) && isset(self::$config[$key])) {
                $config = self::$config[$key];
            }
        }
        return $config;
    }

}