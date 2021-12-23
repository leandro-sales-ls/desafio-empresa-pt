<?php

namespace Bootstrap\Database;

interface ConnectionInterface
{
    /**
     * Gets the database instance (it creates the instance if it not exist).
     */
    public static function getInstance();
}