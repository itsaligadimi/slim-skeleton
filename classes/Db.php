<?php


namespace App;


class Db
{
    private static $instance = null;

    protected $conn;

    private function __construct($settings)
    {
        $this->conn = new \PDO(
            "mysql:host={$settings['servername']};dbname={$settings['dbname']}",
            $settings['username'],
            $settings['password']
        );
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance($settings = [])
    {
        if (self::$instance == null) {
            self::$instance = new Db($settings);
        }

        return self::$instance;
    }

    public function query($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRow($sql)
    {
        $result = $this->query($sql . " limit 1");
        if (empty($result)) {
            return [];
        }
        return $result[0];
    }

    public function getValue($sql)
    {
        $result = $this->getRow($sql);
        if (empty($result))
            return '';

        $keys = array_keys($result);
        return $result[$keys[0]];
    }

    public function exec($sql)
    {
        return $this->conn->exec($sql);
    }

    public function insert_id()
    {
        $this->conn->lastInsertId();
    }
}