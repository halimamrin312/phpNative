<?php
// controller/user.php

// Pastikan file connection.php berada di root folder (satu tingkat di atas controller)
require_once __DIR__ . '/../connection.php';

$userCount = 0;
$errorMessage = "";
$users = [];

// Parameter Paginasi
$limit = 5;
// Validasi aman input page
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

try {
    // Optimasi query: Hitung total
    $sql = "SELECT COUNT(*) as count FROM user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $userCount = (int) $row['count'];
    }

    // Mengambil data dengan limit & offset yang ter-binding (Aman dari SQLi)
    $sql2 = "SELECT * FROM user LIMIT :limit OFFSET :offset";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt2->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt2->execute();
    
    $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Query failed: " . $e->getMessage());
    $errorMessage = "Sistem sedang sibuk. Gagal memuat data pengguna.";
} finally {
    $conn = null;
}

$totalPages = $userCount > 0 ? ceil($userCount / $limit) : 1;

// Memuat view setelah logic selesai
require_once __DIR__ . '/../view/dashboard.php';