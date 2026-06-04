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
    <h2>Menu</h2>
    <ul>
        <li>
            <a href=<?= '?url=LockerController' ?>>See Lockers</a>
        </li>
        <li>
            <a href=<?= '?url=RentalController' ?>>See Rentals</a>
        </li>
    </ul>
</body>

</html>