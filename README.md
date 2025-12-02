# Nama : Ariza Nola Rufiana
# NIM : H1D023005
## Tugas 9 Pertemuan 11
### Struktur Sistem**

Alur kerjanya:

```
Flutter UI → Request API → CodeIgniter Controller → Model → Database → Response JSON → Flutter UI
```

### Tampilan UI & Penjelasan Proses
#### Proses Login dan registrasi

<img width="250" height="500" alt="Screenshot 2025-12-03 001528" src="https://github.com/user-attachments/assets/aa32c346-26f8-4c3d-8487-46caa5688aec" />
<img width="250" height="500" alt="Screenshot 2025-12-03 001630" src="https://github.com/user-attachments/assets/2b6f6e64-39e0-4e9f-870f-1092db46fafc" />

Pada halaman login dan registrasi, pengguna menginputkan email dan password.
Alur proses:
1. Pengguna mengisi email dan password
2. Klik tombol **Login**
3. Flutter mengirim request **POST /login** ke API
4. API mengecek:
   * apakah email terdaftar
   * apakah password benar (password_verify)
5. Jika valid → API mengirim token + data user
6. Aplikasi menyimpan token sebagai session lokal dan masuk ke halaman dashboard
7. Jika gagal → tampil popup error
Kode API Login (Backend)

```php
// contoh LoginController
if (!password_verify($password, $member['password'])) {
    return $this->responseHasil(400,false,"Password tidak valid");
}
```
Kode Login Flutter

```dart
// contoh request login flutter
final response = await http.post(Uri.parse("${Api.login}"), body: {
  "email": emailController.text,
  "password": passController.text,
});
```

Proses Registrasi**
<img width="250" height="500" alt="Screenshot 2025-12-02 231115" src="https://github.com/user-attachments/assets/3d3db8e6-0312-44de-94aa-fb41285e10b1" />
<img width="250" height="500" alt="Screenshot 2025-12-02 231303" src="https://github.com/user-attachments/assets/5566c7f8-7a83-4849-90c9-d8c03c1d6f93" />
Penjelasan Proses
* User mengisi nama, email, password
* Flutter mengirim data ke API REST
* API hash password lalu insert ke database

Cuplikan kode API Registrasi

```php
$data = [
  'nama' => $this->request->getVar('nama'),
  'email' => $this->request->getVar('email'),
  'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
];

$model->insert($data);
```

#### CRUD Produk
Form Tambah Produk (Create)
<img width="250" height="500" alt="Screenshot 2025-12-03 000312" src="https://github.com/user-attachments/assets/b0421b70-ccaa-4d31-9551-dc0515b14666" />
Penjelasan:

* User mengisi nama produk, harga, deskripsi, kategori
* Tekan Submit → Flutter kirim request **POST /produk**
* API menyimpan ke database
Cuplikan kode API:

```php
public function create(){
   $model = new MProduk();
   $model->insert([
      'nama_produk' => $this->request->getVar('nama_produk'),
      'harga' => $this->request->getVar('harga'),
   ]);
}
```
List Produk (Read)
<img width="250" height="500" alt="Screenshot 2025-12-03 000136" src="https://github.com/user-attachments/assets/b7dde7b5-c458-4eb8-a653-3af4336c27f4" />
Penjelasan Alur:

* Flutter request GET /produk
* API mengirim JSON list data produk
* List ditampilkan dalam ListView

---
*Edit Produk (Update)*
<img width="250" height="500" alt="Screenshot 2025-12-03 000225" src="https://github.com/user-attachments/assets/c9775257-c99c-4fe8-81bb-e98b2f020849" />
Penjelasan:

* klik tombol edit pada item
* tampil form edit
* kirim PUT request ke API
* API update kolom pada database

---

---

Hapus Produk (Delete)
<img width="250" height="500" alt="Screenshot 2025-12-03 000157" src="https://github.com/user-attachments/assets/15a56dce-719b-4433-92c4-e9e2c4d81408" />
Alur proses:

* tekan tombol hapus di Flutter
* Flutter kirim DELETE request ke `/produk/id`
* API menghapus baris berdasarkan ID

---

---


Nanti aku generate file-nya otomatis buat kamu tinggal isi gambar-gambar 👍
