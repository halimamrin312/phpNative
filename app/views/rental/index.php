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
    <h1>Welcome Back Admin</h1>
    <h3>Here is your Rental List |
        <a href=<?= '?url=RentalController/create' ?>>Create Rental</a>
    </h3>
    <table border="1px">
        <tr>
            <th>Id</th>
            <th>User Id</th>
            <th>Locker Id</th>
            <th>Action</th>
        </tr>

        <?php foreach ($data['rentals'] as $rental) { ?>
            <tr>
                <td><?= htmlspecialchars($rental['id']) ?></td>
                <td><?= htmlspecialchars($rental['user_id']) ?></td>
                <td><?= htmlspecialchars($rental['locker_id']) ?></td>
                <td>
                    <a href=<?= '?url=RentalController/edit/' . htmlspecialchars($rental['id']) . '/' . htmlspecialchars($rental['user_id']) . '/' . htmlspecialchars($rental['locker_id']) ?>>Edit</a>
                    <form action="?url=RentalController/sneakDelete" method="post">
                        <input type="hidden" value="<?= htmlspecialchars($rental['id']) ?>" name="id" readonly>
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>