## TRIGGER UPDATE LOCKER
```sql
CREATE TRIGGER update_loker
AFTER INSERT ON `myLocker`.`rental` 
FOR EACH ROW
UPDATE `myLocker`.`lockers` set `lockers`.`status` = 'owned' where `lockers`.`id` = new.`locker_id`;

```

## TRIGGER UPDATE LOCKER
```sql
SHOW CREATE TABLE `nama_table`; --Melihat properti table ini

```

## MEMILIH DATA DENGAN KEADAAN YANG DIPILIH
```sql
select * from lockers where id NOT IN (select lockers.id from lockers INNER JOIN rental on lockers.id = locker_id);
```