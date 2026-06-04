<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $data['judul'] ?>
    </title>
</head>

<body>
    <form action="?url=RentalController/createStore" method="post">
        <label for="id" name="id">ID Rental</label>
        <input type="text" name="id" id="id" value="<?= $data['nextId'] ?>" readonly>
        <br>

        <label for="userId" name="userId">User Id</label>
        <select name="userId" id="userId">
            <?php foreach ($data['users'] as $userId) { ?>
                <option value="<?= $userId['id'] ?>"><?= $userId['id'] ?></option>
            <?php } ?>
        </select>

        <br>
        <label for="lockerId" name="lockerId">Locker Id</label>
        <select name="lockerId" id="lockerId">
            <?php foreach ($data['lockers'] as $lockerId) { ?>
                <option value="<?= $lockerId['id'] ?>"><?= $lockerId['id'] ?></option>
            <?php } ?>
        </select>

        <br>
        <button type="submit" name="submit" id="submit">Add Rental</button>
    </form>
</body>

</html>