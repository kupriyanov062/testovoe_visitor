<?php

class Database
{
    const DB_HOST = '127.0.0.1'; // localhost
    const DB_USER = 'root';
    const DB_PASSWORD = '';
    const DB_NAME = 'visitor';
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO(
            'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME,
            self::DB_USER,
            self::DB_PASSWORD);
        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query(string $sql, $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        if (false === $result) {
            return null;
        }
        return $sth->fetchAll();
    }

    public function add(string $sql)
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $this->pdo->lastInsertId();
    }

    public function update(string $sql)
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return true;
    }

}