<?php

class RentalModel extends Database
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllRentals()
    {
        $stmt = $this->db->query('SELECT * FROM rental');
        return $stmt->fetchAll();
    }
    public function getLastId()
    {
        $sql = 'SELECT id from rental ORDER BY rental.id DESC LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $id = $stmt->fetch();
        return $id['id'];
    }
    public function createRental($id, $userId, $lockerId)
    {
        $sql = "INSERT INTO rental (id,user_id,locker_id) VALUES (:id,:userId,:lockerId)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':userId' => $userId,
            ':lockerId' => $lockerId
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id): bool
    {
        $sql = 'DELETE FROM rental WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function update($id, $userId, $lockerId)
    {
        $sql = "UPDATE rental SET user_id = :userId , locker_id = :lockerId WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':userId' => $userId, ':lockerId' => $lockerId]);
        return $stmt->rowCount() > 0;
    }
}