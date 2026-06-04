## TRIGGER KETIKA RENTAL DI TAMBAHKAN
```sql
CREATE TRIGGER update_loker
AFTER INSERT ON `myLocker`.`rental` 
FOR EACH ROW
UPDATE `myLocker`.`lockers` set `lockers`.`status` = 'owned' where `lockers`.`id` = new.`locker_id`;

```

## TRIGGER KETIKA RENTAL DI HAPUS
```sql
CREATE TRIGGER delete_loker
AFTER DELETE ON `myLocker`.`rental` 
FOR EACH ROW
UPDATE `myLocker`.`lockers` set `lockers`.`status` = 'not_owned' where `lockers`.`id` = old.`locker_id`;
```

## TRIGGER KETIKA RENTAL DI UPDATE
```sql
CREATE TRIGGER edit_loker
AFTER UPDATE ON `myLocker`.`rental` 
FOR EACH ROW
UPDATE `myLocker`.`lockers` set `lockers`.`status` = 'not_owned' where `lockers`.`id` = old.`locker_id`;
```

## MELIHAT INFO TABLE
```sql
SHOW CREATE TABLE `nama_table`; --Melihat properti table ini

```


## MEMILIH DATA DENGAN KEADAAN YANG DIPILIH
```sql
select * from lockers where id NOT IN (select lockers.id from lockers INNER JOIN rental on lockers.id = locker_id);
```

## UPDATE / EDIT TABLE LOCKERS DENGAN KONDISI TERTENTU
```sql
UPDATE lockers set status = "not_owned" where id in (select id from lockers where id NOT IN (select lockers.id from lo
ckers INNER JOIN rental on lockers.id = locker_id));
```

## MELIHAT TRIGGERS YANG ADA DI DB
```sql
SHOW TRIGGERS;
```