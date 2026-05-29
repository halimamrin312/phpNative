# 🔍 Code Review — myLocker PHP MVC Project

**Tanggal:** 29 Mei 2026  
**Reviewer:** Antigravity (Senior Web Developer / Mentor)

---

## 📊 Ringkasan Umum

| Aspek | Nilai | Catatan |
|---|---|---|
| Struktur MVC | ⭐⭐⭐⭐ | Sudah bagus, pisah M-V-C jelas |
| Routing | ⭐⭐⭐ | Berfungsi, tapi belum ada `.htaccess` |
| Database | ⭐⭐⭐⭐ | Singleton pattern, PDO prepared statements ✅ |
| Keamanan | ⭐⭐ | Ada celah penting yang perlu diperbaiki |
| Clean Code | ⭐⭐⭐ | Cukup rapi, ada beberapa inkonsistensi |
| CRUD | ⭐⭐⭐ | Berfungsi tapi ada bug logic |

> [!TIP]
> Overall project ini sudah di jalur yang benar! Kamu sudah paham konsep MVC, cara pakai PDO prepared statements, dan pattern Singleton. Bagus untuk tahap belajar! 👏

---

## ✅ Yang Sudah Bagus

1. **Struktur folder MVC** — Pemisahan `controllers/`, `models/`, `views/`, `core/` sudah benar
2. **Database Singleton** — `Database::getInstance()` pakai Singleton pattern, ini best practice ✅
3. **Prepared Statements** — Semua query pakai `prepare()` + `execute()`, aman dari SQL injection ✅
4. **`htmlspecialchars()`** — Sudah dipakai di view untuk output escaping ✅
5. **Type hints** — Sudah mulai pakai return type `bool`, `array`, `string` di Model ✅
6. **PHPDoc comments** — Ada docblock di beberapa method ✅

---

## 🐛 Bug Yang Ditemukan

### Bug 1: Method `update()` di Controller salah parameter (KRITIS ⚠️)

```diff
// File: app/controllers/LockerController.php (line 80-90)
// Method update() memanggil updateLocker() dengan 2 parameter terpisah
// Tapi updateLocker() di Model menerima 1 parameter array!

public function update()
{
    $id = htmlspecialchars($_POST['id']);
    $secreetKey = htmlspecialchars($_POST['secreetKey']);
-   $valid = $this->model('LockerModel')->updateLocker($id, $secreetKey);
+   $valid = $this->model('LockerModel')->updateLocker([
+       'id' => $id,
+       'secreetKey' => $secreetKey,
+       'status' => htmlspecialchars($_POST['status'] ?? 'Not Owned')
+   ]);
```

> [!WARNING]
> Method `update()` dan `editStore()` melakukan hal yang sama tapi dengan cara berbeda. Ini akan menyebabkan error karena `updateLocker()` di Model mengharapkan array, bukan 2 string terpisah. **Pertimbangkan hapus salah satu** untuk menghindari duplikasi.

---

### Bug 2: Method `createId()` tidak ditemukan di Model

```php
// Controller memanggil:
$data['nextId'] = $this->model('LockerModel')->createId();

// Tapi di Model, method yang ada adalah:
public function getLastID()  // <-- nama berbeda!
```

**Fix:** Ganti `createId()` → `getLastID()` di controller, atau rename method di model.

---

### Bug 3: Model di-instantiate berulang kali

```php
// Setiap kali method dipanggil, model dibuat ulang:
$this->model('LockerModel')->getAllLockers();
$this->model('LockerModel')->createId();  // new LockerModel lagi!
```

**Best practice:** Simpan model sebagai property di controller:

```php
class LockerController extends Controller
{
    private $lockerModel;

    public function __construct()
    {
        $this->lockerModel = $this->model('LockerModel');
    }

    public function index()
    {
        $data['lockers'] = $this->lockerModel->getAllLockers();
        // ...
    }
}
```

---

## 🔒 Masalah Keamanan

### 1. Password disimpan dalam PLAIN TEXT (KRITIS ⚠️)

```php
// Model menyimpan secreetKey langsung ke database:
$stmt->execute([':id' => $id, ':secreetKey' => $secreetKey]);
```

**Seharusnya pakai `password_hash()` dan `password_verify()`:**

```php
// Saat CREATE:
$hashed = password_hash($secreetKey, PASSWORD_DEFAULT);
$stmt->execute([':id' => $id, ':secreetKey' => $hashed]);

// Saat VERIFIKASI (openLocker):
$sql = 'SELECT secreetKey FROM lockers WHERE id = :id';
$stmt = $this->db->prepare($sql);
$stmt->execute([':id' => $id]);
$row = $stmt->fetch();
return $row && password_verify($secretKey, $row['secreetKey']);
```

### 2. Secret Key input pakai `type="text"` di Edit & Open form

```diff
// File: app/views/locker/edit.php
- <input type="text" name="oldSecreetKey" id="oldSecreetKey">
+ <input type="password" name="oldSecreetKey" id="oldSecreetKey">

// File: app/views/locker/openLocker.php  
- <input type="text" name="secreetKey" id="secreetKey" required>
+ <input type="password" name="secreetKey" id="secreetKey" required>
```

### 3. Delete memakai GET request

```html
<!-- Saat ini -->
<a href="?url=LockerController/delete/<?= $locker['id'] ?>">Hapus</a>
```

> [!CAUTION]
> Delete via GET link berbahaya! Crawler atau browser prefetch bisa tidak sengaja menghapus data. Gunakan form POST untuk aksi yang mengubah data.

### 4. Debug echo di Database.php

```diff
// File: app/core/Database.php line 35
- echo ' Koneksi DB Berhasil</br></br>';
+ // Hapus echo ini di production!
```

---

## 🏗️ Masalah Arsitektur

### 1. Routing masih pakai `?url=` (Query String)

Saat ini URL: `http://localhost:8000/?url=LockerController/index`

**Lebih baik:** `http://localhost:8000/locker` (clean URL)

Butuh `.htaccess` (Apache) atau modifikasi routing:

```apache
# .htaccess di folder public/
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
```

> [!NOTE]
> Karena kamu pakai `php -S localhost:8000`, `.htaccess` tidak akan bekerja (itu untuk Apache). Untuk PHP built-in server, kamu perlu custom router file. Ini bisa jadi latihan nanti.

### 2. Tidak ada validasi di Controller

```php
public function createStore()
{
    $id = htmlspecialchars($_POST['id']);
    $secreetKey = htmlspecialchars($_POST['secreetKey']);
    // Langsung ke model tanpa validasi!
}
```

**Seharusnya ada validasi sebelum proses:**

```php
public function createStore()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Tolak jika bukan POST
        return $this->index();
    }

    $id = htmlspecialchars(trim($_POST['id'] ?? ''));
    $secreetKey = htmlspecialchars(trim($_POST['secreetKey'] ?? ''));

    if (empty($id) || empty($secreetKey)) {
        echo "Semua field harus diisi!";
        return;
    }

    if (strlen($secreetKey) < 4) {
        echo "Secret key minimal 4 karakter!";
        return;
    }

    // Baru proses...
}
```

### 3. Tidak ada redirect setelah POST (PRG Pattern)

Saat ini setelah `createStore()`, `editStore()`, `delete()` — kamu memanggil `$this->index()` langsung. Ini menyebabkan:
- URL tidak berubah
- Refresh halaman = submit ulang form

**Best practice:** Gunakan **Post-Redirect-Get (PRG)** pattern:

```php
public function createStore()
{
    // ... proses ...
    if ($valid) {
        header('Location: ?url=LockerController');
        exit;
    }
}
```

---

## ✏️ Typo & Inkonsistensi

| Lokasi | Masalah | Perbaikan |
|---|---|---|
| Seluruh project | `secreetKey` | `secretKey` (typo) |
| Database diagram | `AUTO_INCEREMENT` | `AUTO_INCREMENT` |
| `</br>` tag | Self-closing salah | `<br>` (HTML5) |
| View `edit.php` | value tanpa quotes: `value=<?= ... ?>` | `value="<?= ... ?>"` |
| Column tabel header | `Pemilik` tapi isinya `status` | Ganti ke `Status` |

---

## 📋 Prioritas Perbaikan

### 🔴 Harus Diperbaiki Segera
1. **Fix bug `createId()` → `getLastID()`** — App crash saat buka halaman create
2. **Fix bug `update()` parameter mismatch** — Error saat update
3. **Hapus debug echo di Database.php** — Tidak profesional

### 🟡 Perbaiki Sebelum Lanjut ke Fitur Baru
4. **Hash password** dengan `password_hash()`
5. **Ubah delete ke POST** method
6. **Tambah validasi input** di controller
7. **Fix input type** secret key ke `type="password"`
8. **Implementasi PRG pattern** (redirect setelah POST)

### 🟢 Nice to Have / Latihan Nanti
9. Clean URL routing (`.htaccess`)
10. Simpan model sebagai property (bukan instantiate berulang)
11. Fix typo `secreetKey` → `secretKey`
12. Tambahkan CSS styling

---

## 🎯 Kesimpulan

Kamu sudah memahami **fondasi MVC dengan baik**:
- ✅ Pemisahan Model, View, Controller
- ✅ Routing dasar
- ✅ Database dengan PDO & Singleton
- ✅ CRUD operations

Yang perlu ditingkatkan:
- 🔧 Fix bug (nama method tidak match)
- 🔐 Keamanan (hash password, POST untuk delete)
- 📝 Validasi input
- 🔄 PRG pattern

> [!IMPORTANT]
> Mau saya bantu perbaiki bug-bug yang ditemukan secara langsung? Atau kamu mau coba perbaiki sendiri dulu sebagai latihan? 💪
