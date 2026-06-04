<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $data['judul'] ?? 'Open Locker' ?>
    </title>
</head>

<body>
    <h1>Locker = <?= htmlspecialchars($data['status']) ?></h1>

    <form action='?url=LockerController/sneakInLocker' method="post">
        <label for="id">Locker ID :</label>
        <input type="text" name="id" id="id" value="<?= htmlspecialchars($data['id']) ?>" readonly>
        <label for="secreetKey">Secret Key :</label>
        <input type="text" name="secreetKey" id="secreetKey" required>
        <button type="submit">Open Locker</button>
    </form>
</body>

</html>