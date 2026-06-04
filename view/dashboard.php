<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard statistik pengguna">
    <title>Sistem Dashboard Premium</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Dashboard Pengguna</h1>
            <p class="subtitle">Manajemen dan Statistik Akses</p>
        </header>

        <main class="dashboard-content">
            <?php if ($errorMessage): ?>
                <div class="alert error">
                    <p><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            <?php else: ?>
                <div class="stats-card">
                    <h2>Total Pengguna</h2>
                    <div class="stat-number"><?= htmlspecialchars($userCount, ENT_QUOTES, 'UTF-8') ?></div>
                    <p>Terdaftar dalam sistem</p>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($users) > 0): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['userId'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="empty-state">Belum ada pengguna yang terdaftar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="btn-paginate">&laquo; Prev</a>
                    <?php else: ?>
                        <span class="btn-paginate disabled">&laquo; Prev</span>
                    <?php endif; ?>

                    <span class="page-info">Halaman <?= $page ?> dari <?= $totalPages ?></span>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="btn-paginate">Next &raquo;</a>
                    <?php else: ?>
                        <span class="btn-paginate disabled">Next &raquo;</span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
            <?php endif; ?>
        </main>
    </div>
</body>
</html>