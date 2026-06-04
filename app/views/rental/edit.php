<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $data['judul'] ?? "Edit Rental" ?>
    </title>
</head>

<body>
    <form action="?url=RentalController/editStore" method="post">
        <label for="id">Rental Id : </label>
        <input type="text" name="id" id="id" value=<?= $data['id']; ?> readonly></br>

        <label for="userId" name="userId">User Id</label>
        <select name="userId" id="userId">
            <?php foreach ($data['users'] as $userId) { ?>

                <option value="<?= $userId['id'] ?>" <?php if ($userId['id'] == $data['userId']) { ?> selected <?php } ?>>
                    <?= $userId['id'] ?>
                </option>
            <?php } ?>
        </select>
        <br>
        <label for="lockerId" name="lockerId">Locker Id</label>
        <select name="lockerId" id="lockerId">

            <option value="<?= $data['lockerId'] ?>" selected>
            <?= $data['lockerId'] ?>
            </option>

            <?php foreach ($data['lockers'] as $lockerId) { ?>
                    <option value="<?= $lockerId['id'] ?>"><?= $lockerId['id'] ?></option>
            <?php } ?>
        </select>
        <br>
        <input type="submit" value="Update">

    </form>
</body>

</html>