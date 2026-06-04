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
    <h1>Welcome back Admin</h1>
    <h3>Here is your Locker List |
        <a href=<?= '?url=LockerController/create' ?>>Create Locker</a>
    </h3>
    <table border="1px">
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php foreach ($data['lockers'] as $locker) { ?>
            <tr>
                <td><?= htmlspecialchars($locker['id']) ?></td>
                <td><?= htmlspecialchars($locker['status']) ?></td>
                <td>
                    <a href=<?= '?url=LockerController/getLocker/' . htmlspecialchars($locker['id']) . '/' . htmlspecialchars($locker['status']) ?>>Open</a>
                    <a href=<?= '?url=LockerController/edit/' . htmlspecialchars($locker['id']) . '/' . htmlspecialchars($locker['status']) ?>>Edit</a>
                    <form action="?url=LockerController/sneakDelete" method="post">
                        <input type="hidden" value="<?= htmlspecialchars($locker['id']) ?>" name="id" readonly>
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>