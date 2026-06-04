<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $data['judul']; ?>
    </title>
</head>

<body>
    <h1>Haii Selamat Datang, Admin</h1>
    <h3>Berikut adalah list Locker |
        <a href=<?= '?url=LockerController/create' ?>> Tambah</a>
    </h3>
    <table border="1px">
        <tr>
            <th>Id</th>
            <th>Pemilik</th>
            <th>ACTION</th>
        </tr>

        <?php foreach ($data['lockers'] as $locker) { ?>
            <tr>
                <td><?= htmlspecialchars($locker['id']) ?></td>
                <td><?= htmlspecialchars($locker['status']) ?></td>
                <td>
                    <a href=<?= '?url=LockerController/getLocker/' . htmlspecialchars($locker['id']) . '/' . htmlspecialchars($locker['status']) ?>>Buka</a>
                    <a href=<?= '?url=LockerController/edit/' . htmlspecialchars($locker['id']) . '/' . htmlspecialchars($locker['status']) ?>>Edit</a>
                    <a href=<?= '?url=LockerController/delete/' . htmlspecialchars($locker['id']) ?>>Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>