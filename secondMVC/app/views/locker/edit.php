<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul'] ?? "Edit Locker" ?></title>
</head>

<body>
    <form action="?url=LockerController/editStore" method="post">
        <label for="id">Id Locker : </label>
        <input type="text" name="id" id="id" value=<?= $data['locker']['id']; ?> readonly></br>

        <label for="status">status</label>
        <input type="text" name="status" id="status" value=<?= $data['locker']['status']; ?> readonly></br>

        <label for="oldSecreetKey">old Secreet Key</label>
        <input type="text" name="oldSecreetKey" id="oldSecreetKey"></br>


        <label for="secreetKey">new Secreet Key</label>
        <input type="text" name="secreetKey" id="secreetKey"></br>

        <input type="submit" value="Update">
    </form>
</body>

</html>