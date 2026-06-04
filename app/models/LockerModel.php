<?php
class LockerModel
{

    /**
     * @var PDO
     */
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    /**
     * @return array
     */
    public function getAllLockers(): array
    {
        $stmt = $this->db->query('SELECT id, status FROM lockers');
        return $stmt->fetchAll();
    }

    public function getNotOwnedLockers(): array
    {
        $stmt = $this->db->query('SELECT id FROM lockers where status = "not_owned"');
        return $stmt->fetchAll();
    }

    public function getLocker($id)
    {
        $sql = 'SELECT id, status FROM lockers where id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function createLocker($id, $secreetKey): bool
    {
        $secreetKeyHashed = password_hash($secreetKey, PASSWORD_DEFAULT);
        $id = 'LK-' . $id;
        $sql = 'INSERT INTO lockers (id, secreetKey) VALUES (:id, :secreetKey)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':secreetKey' => $secreetKeyHashed]);
        return $stmt->rowCount() > 0;
    }

    public function deleteLocker($id): bool
    {
        $sql = 'DELETE FROM lockers WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function updateLocker($data): bool
    {
        $hashedSecretKey = password_hash($data['secreetKey'], PASSWORD_DEFAULT);
        $sql = 'UPDATE lockers SET secreetKey = :secreetKey ,status = :status WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $data['id'], ':secreetKey' => $hashedSecretKey, ':status' => $data['status']]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Cek locker dengan id dan pin (secret key)
     * @param string $id
     * @param string $secretKey
     * @return bool
     */
    public function openLocker(string $id, string $secretKey): bool
    {

        $sql = 'SELECT secreetKey FROM lockers WHERE id = :id;';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row && password_verify($secretKey, $row['secreetKey']);
    }
    public function getLastId()
    {
        $sql = 'select *from lockers ORDER BY lockers.id DESC LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $id = $stmt->fetch();
        return $id['id'];
    }
}