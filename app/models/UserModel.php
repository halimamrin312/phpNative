<?php

class UserModel extends Database
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    public function getAllUsers()
    {
        $stmt = $this->db->query('select id from users');
        return $stmt->fetchAll();
    }
}