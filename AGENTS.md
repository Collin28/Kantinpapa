# KantinPapa — Konteks Proyek untuk AI Agent

> Dokumen ini adalah sumber kebenaran (source of truth) untuk AI agent yang bekerja langsung di dalam proyek KantinPapa.
> Letakkan di root proyek sebagai `AGENTS.md` (atau `GEMINI.md`) agar terbaca otomatis di setiap sesi.
> Dianalisis dari repo `Collin28/Kantinpapa` (branch `main`, commit `d4c225e`, 11 Nov 2026). Jika kode sudah berubah sejak itu, **kode aktual menang atas dokumen ini** — perbarui dokumen ini setelah perubahan besar.
> Penanda: **[FAKTA]** = terverifikasi langsung dari kode/git. **[REKOMENDASI]** = usulan desain, boleh diubah pemilik proyek.
> Desain visual mengacu pada gambar di folder `reference/` (lihat bagian 2A).

---

## 1. Ringkasan Aplikasi

KantinPapa adalah aplikasi web pemesanan makanan kantin kampus. Mahasiswa melihat menu, memasukkan ke keranjang, membayar (target: QRIS), lalu mengambil pesanan di counter tanpa antre. Admin (pengelola kantin) memantau pesanan, mengubah status, mengelola menu, dan mengelola pengguna dari panel admin.

Bahasa UI: campuran Indonesia–Inggris (label tombol/judul berbahasa Inggris, beberapa teks Indonesia seperti "Pajak (10%)"). Mata uang Rupiah, format `Rp 18.000`. Atribut `<html lang="id">`.

Dua peran: **User** (mahasiswa) dan **Admin** (pengelola kantin).

---

## 2. Tech Stack **[FAKTA]**

| Layer | Teknologi |
|---|---|
| Backend | PHP ^8.3, **Laravel ^13.17** (skeleton standar, `laravel/tinker`) |
| Dev tools | Pint, Pail, PHPUnit ^12.5, Collision, Faker, Mockery, `laravel/pao` |
| Database | **MySQL** (keputusan pemilik proyek; engine InnoDB, charset `utf8mb4`). Catatan **[FAKTA]**: `.env.example` dan `config/database.php` di repo masih default `sqlite`, jadi `.env` lokal harus memakai `DB_CONNECTION=mysql` |
| Session / Cache / Queue | Semua `database` driver |
| Frontend | Blade + **Tailwind CSS via CDN** di semua view (bukan lewat Vite) |
| Build tool (terpasang, belum dipakai view) | Vite ^8, `@tailwindcss/vite` ^4, `laravel-vite-plugin` ^3.1 |
| Font | Instrument Sans (Bunny, via plugin Vite) — hanya dipakai `welcome.blade.php` |
| Desain | Figma (referensi UI) |

Perintah penting: `composer setup`, `composer dev` (menjalankan `php artisan dev`), `composer test`.

> README.md di repo **sudah usang**: masih menyebut stack "HTML5 + Tailwind CDN" dan tidak menyebut Laravel. Perbarui README setelah fondasi backend selesai.

---

## 2A. Folder Referensi Desain (Figma)

Proyek memiliki folder **`reference/`** di root yang berisi gambar hasil ekspor desain Figma (PNG/JPG), idealnya satu gambar per halaman atau state. *(Jika nama folder sebenarnya berbeda, ikuti nama aslinya dan perbarui bagian ini.)*

**Kedudukan referensi**
- Gambar di `reference/` adalah **sumber kebenaran visual**. Bila berbeda dengan Blade yang sudah ada, **gambar yang menang**; Blade lama hanyalah titik awal dan boleh ditulis ulang.
- Gambar menentukan tampilan, bukan data. Teks/angka dummy di gambar (nama menu, harga, nama pengguna) **jangan** dijadikan data permanen; ambil dari database.
- Jika sebuah halaman tidak punya gambar referensi, ikuti gaya halaman lain yang sudah ada dan catat di inventaris (lihat bawah).

**Cara kerja agent dengan referensi**
1. **Inventarisasi dulu.** Sebelum menulis kode UI, buka semua gambar dan buat `reference/INDEX.md`: tabel *gambar → halaman → route → file view → state (belum/sebagian/selesai)*. Perbarui tabel ini setiap kali sebuah halaman selesai.
2. **Ekstrak design tokens** (warna, font, ukuran teks, radius, shadow, spacing) dari gambar dan simpan sekali di blok `@theme` pada `resources/css/app.css`. Jangan menyebar nilai warna/ukuran ad-hoc di banyak view. Sebagai titik awal, UI saat ini memakai merah `red-600` (aksen), netral `neutral-950`/`zinc-900` (gelap), kartu `rounded-2xl`, tombol pill `rounded-full`; verifikasi terhadap gambar.
3. **Pecah komponen berulang** menjadi Blade component (navbar, sidebar admin, kartu menu, badge status, kartu statistik, tabel, modal) alih-alih menyalin markup.
4. **Cocokkan, lalu bandingkan.** Setelah halaman dibuat, bandingkan hasil render dengan gambar (tata letak, jarak, tipografi, warna, state hover/aktif). Catat selisih yang disengaja.
5. **Aset gambar produk** (logo, foto menu, ikon) harus diekspor/dipotong sendiri dan disimpan di `public/images/` (aset statis) atau `storage/app/public` (unggahan admin). **Jangan** memakai screenshot halaman penuh sebagai aset, dan jangan menaruh folder `reference/` di dalam `public/`.
6. **Responsif.** Bila gambar hanya satu ukuran (umumnya desktop), pertahankan rasio dan komposisinya, lalu buat responsif dengan breakpoint Tailwind yang wajar; tanyakan bila layout mobile ambigu. Halaman customer harus nyaman di ponsel (mahasiswa memesan lewat HP); panel admin boleh desktop-first.
7. **State yang tidak digambar** (loading, error validasi, empty state, flash message, konfirmasi hapus) dibuat konsisten dengan gaya yang ada dan dicatat di `INDEX.md`.
8. Bila dua gambar saling bertentangan atau sebuah detail tidak terbaca, **tanyakan** ke pemilik proyek; jangan menebak.

**Konvensi penamaan yang disarankan:** `reference/<area>/<halaman>[-<state>].png`, misalnya `reference/customer/home.png`, `reference/customer/cart-empty.png`, `reference/admin/order-management.png`.

---

## 3. Arsitektur Saat Ini **[FAKTA]**

Pola: **Laravel MVC standar**, tetapi saat ini baru lapisan **View + Controller tipis**. Tidak ada logika bisnis, tidak ada Model domain, tidak ada autentikasi nyata.

```
app/Http/Controllers/
  AuthController.php   -> login(), register()           (hanya return view)
  UserController.php   -> index(), orderHistory(), cart(), payConfirm()   (hanya return view)
  AdminController.php  -> index(), orderManagement(), menuManagement(), userManagement()  (hanya return view)
app/Models/User.php    -> Authenticatable standar; #[Fillable(name,email,password)]; TIDAK ada 'role'
routes/web.php         -> HANYA 1 route: GET / -> view('welcome')
resources/views/
  welcome.blade.php          (halaman default Laravel)
  auth/login.blade.php       (form tanpa action/name/@csrf)
  auth/register.blade.php    (form dengan @csrf, name field, tapi memakai route('register') yang belum ada)
  users/home.blade.php       (katalog menu; data hardcode via @for)
  users/cart.blade.php       (keranjang; hardcode, pajak 10%)
  users/cardempty.blade.php  (state keranjang kosong; tidak ada controller/route)
  users/payconfirm.blade.php (halaman "Order Placed!")
  users/orderHistory.blade.php (riwayat pesanan; hardcode)
  admin/dashboard.blade.php, orderManagement, menuManagement, userManagement (semua hardcode)
database/migrations/       (lihat bagian 4)
```

Karakteristik view **[FAKTA]**: setiap file adalah HTML penuh mandiri (`<!DOCTYPE html>` sendiri), **tanpa layout Blade bersama** — sidebar admin dan navbar customer di-copy-paste di setiap file. Seluruh angka, nama, status, dan gambar adalah data dummy (mis. "Nasi Ayam Bakar", "KTG-891248", "Rp 12.480.000"). Hampir semua link `href="#"`. Hampir tidak ada JavaScript (kecuali toggle password di register).

---

## 4. Database **[FAKTA]**

Tabel yang ada setelah semua migrasi dijalankan:

| Tabel | Kolom |
|---|---|
| `users` | id, name, email (unique), email_verified_at, password, remember_token, timestamps |
| `password_reset_tokens`, `sessions` | bawaan Laravel |
| `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` | bawaan Laravel |
| `categories` | id, name, timestamps |
| `menus` | id, **category_id** (FK → categories, ditambah migrasi terpisah), name, description (text, wajib), price decimal(10,2), img_url (wajib), is_available (boolean, tanpa default), timestamps |

**Perangkap migrasi yang harus diketahui:**
- Migrasi `2026_11_11_053610_add_column_role_from_users` menambah kolom `role`, lalu `2026_11_11_120000_drop_role_from_users_table` langsung **menghapusnya**. Hasil akhir: **tabel `users` TIDAK punya kolom `role`**, padahal commit terakhir berjudul "add role to users". Jangan berasumsi kolom role ada.
- `menus` tidak punya kolom **stok**, padahal UI menampilkan "24 left" dan README menyebut sisa stok.
- Belum ada tabel `orders`, `order_items`, `payments`, maupun keranjang. Belum ada kolom status akun (untuk fitur Suspend/Restore).
- Belum ada model `Menu` dan `Category`. `DatabaseSeeder` hanya membuat satu `Test User`.

---

## 5. Fungsi Aplikasi yang Dirancang (dari UI & README)

**Customer (mahasiswa)**
- Katalog menu: foto, nama, harga, sisa stok, badge "Popular", state "Sold Out/Unavailable".
- Pencarian menu dan filter kategori: All, Rice Bowls, Noodles, Snacks, Drinks, Desserts.
- Bagian "Popular Today".
- Keranjang: daftar item, jumlah, subtotal, **pajak 10%**, total. Keranjang kosong punya halaman sendiri.
- Checkout dan bayar (QRIS) → halaman konfirmasi "Order Placed!".
- Riwayat pesanan: nomor order (format contoh `KTG-891248`), tanggal, item, status pembayaran, status pesanan, total termasuk pajak, tombol **Order Again**.

**Admin**
- Dashboard: Total Revenue, Today's Revenue (+ jumlah order hari ini), Total Orders, Pending Orders, Completed, Menu Items (+ jumlah available).
- Order Management: filter status (All, Pending, Paid, Preparing, Ready, Completed, Cancelled); tombol "→ Paid" (dari Pending), "→ Ready" (dari Preparing), "→ Completed" (dari Ready), dan "Cancel" pada order yang belum selesai. Mockup **belum punya** tombol Paid → Preparing; tambahkan di implementasi.
- Menu Management: tambah, edit, hapus, toggle Active/Off, pencarian, filter kategori.
- Manage Users: statistik (Total Users, Active Users, Total Orders, Total Spent), pencarian nama/email, filter role (User/Admin), aksi Suspend / Restore / Delete.

**Aturan bisnis yang sudah tersirat [FAKTA dari UI]**
- Pajak 10% atas subtotal (contoh: 36.000 + 10.000 = 46.000 → total 50.600).
- Dua status terpisah per order: **status pembayaran** (Pending, Paid) dan **status pesanan** (Pending, Paid, Preparing, Ready, Completed, Cancelled).
- Alur status: Pending → Paid → Preparing → Ready → Completed; Cancelled tersedia selama order belum Completed.
- Placeholder email kampus: `you@campus.ac.id`. Validasi password register: min. 6 karakter + konfirmasi.

---

## 6. Status Progress

Perkiraan keseluruhan: **sekitar 10–15% dari aplikasi fungsional.** Tahap saat ini adalah *prototipe UI statis di dalam skeleton Laravel*. Pemberi penilaian ini adalah analisis kode; pemilik proyek boleh mengoreksi.

| Area | Status | Catatan |
|---|---|---|
| Desain UI (11 halaman Blade) | ~95% | Layout bersama (`app`, `admin`) & `@vite` aktif; konten masih statis kecuali auth |
| Skeleton Laravel + env | Selesai | `APP_NAME=KantinPapa`, timezone `Asia/Jakarta`, test DB MySQL (`kantinpapa_test`) |
| Skema DB: users, menus, categories | **Selesai** | `users` (`role`, `status`), `categories` (`slug`), `menus` (`stock`) |
| Skema DB: orders, order_items, payments | **0%** | Belum ada |
| Model Eloquent domain | Parsial | `User`, `Category`, `Menu` siap; `Order`, `OrderItem`, `Payment` belum ada |
| Routing | **Pulih** | Route publik, auth, customer (`auth`+`active`), dan admin (`auth`+`active`+`admin`) aktif |
| Autentikasi (login/register/logout) | **Selesai** | Session auth, FormRequest, seeder admin & user demo |
| Otorisasi role & middleware | **Selesai** | Middleware `admin` (`EnsureUserIsAdmin`) & `active` (`EnsureUserIsActive`) |
| CRUD menu (admin) | **Selesai** | CRUD, upload gambar, search/filter kategori, toggle Active/Off |
| Alur keranjang → checkout → order | **0%** | |
| Manajemen order & status (admin) | **0%** | |
| Manajemen user (admin) | **0%** | |
| Dashboard data nyata | **0%** | |
| Pembayaran QRIS | **0%** | |
| Notifikasi real-time | **0%** | |
| Test otomatis | **Aktif** | `ExampleTest`, `AuthTest`, `MenuTest` lulus di MySQL test DB |

**Histori git (15 commit, 20 Agu – 11 Nov 2026, 2 kontributor: Collin28 dan ryuzzzzzzxzz):** DB awal → homepage & register → cart/payment/login → order history → controller/view/route → merge → kolom role (ditambah lalu dihapus).

---

## 7. Masalah & Utang Teknis (urut prioritas)

1. **Route hilang akibat merge.** Commit `9a9fd2f` punya 14 route (`/auth`, `/user/*`, `/admin/*`), tetapi commit "reset" (`200e7c0`) pada branch lain mengosongkan `web.php`, dan merge `11e38bd` mengambil versi kosong. **Di `main` sekarang hanya ada `GET /`.** Controller dan view ada, tetapi tidak bisa diakses. Route lama juga cacat: route `register` memakai nama `auth.login` (duplikat), dan tidak ada route POST.
2. **Nama route tidak cocok dengan view.** `register.blade.php` memanggil `route('register')` dan `route('login')`; tidak ada route dengan nama itu → error `RouteNotFoundException` saat halaman dirender.
3. **Nama view berbeda huruf besar-kecil.** `UserController::payConfirm()` memanggil `users.payConfirm`, file aslinya `payconfirm.blade.php`. Berjalan di Windows/macOS, **gagal di Linux/server produksi**.
4. **Migrasi role saling menghapus** (lihat bagian 4).
5. **Tanpa layout bersama.** Duplikasi sidebar/navbar di tiap view akan menyulitkan setiap perubahan.
6. **Tailwind via CDN** padahal Vite + Tailwind 4 sudah terpasang. Halaman memakai dua CDN berbeda: `cdn.tailwindcss.com` (v3, hanya untuk home & register) dan `@tailwindcss/browser@4` (lainnya) → gaya bisa tidak konsisten. CDN juga tidak layak untuk produksi.
7. **Dua versi halaman home/register pernah dihapus** ("reset"); cek bahwa versi sekarang adalah yang diinginkan sebelum menimpa.
8. **Naming tidak konsisten:** `cardempty` (kemungkinan typo "cartempty"), campuran camelCase dan lowercase pada nama file view/route.
9. **README usang** dan tidak ada petunjuk setup.
10. `APP_NAME=Laravel` di `.env.example`; timezone `UTC` (kampus di Indonesia → pertimbangkan `Asia/Jakarta`); locale `en`.

---

## 8. Arsitektur Target **[REKOMENDASI]**

### 8.1 Skema database
```
users:        + role string default 'user' (index)   // 'user' | 'admin'
              + status string default 'active'        // 'active' | 'suspended'
categories:   id, name, slug unique
menus:        id, category_id FK, name, description nullable, price (unsignedInteger Rupiah atau decimal),
              img_url nullable, stock unsignedInteger default 0, is_available bool default true, timestamps
orders:       id, order_number unique (KTG-xxxxxx), user_id FK, subtotal, tax_amount, total,
              payment_status ('pending','paid','failed'), order_status ('pending','paid','preparing','ready','completed','cancelled'),
              paid_at nullable, timestamps
order_items:  id, order_id FK, menu_id FK, menu_name (snapshot), unit_price (snapshot), qty, line_total
payments:     id, order_id FK, method ('qris'), provider_ref nullable, amount, status, paid_at nullable, raw_payload json nullable
cart:         simpan di session untuk tahap awal (tabel carts/cart_items opsional di tahap berikutnya)
```
Simpan harga/nama menu pada `order_items` sebagai snapshot agar riwayat tidak berubah saat menu diedit. Gunakan `DB::transaction` + pengurangan stok atomik saat checkout.

### 8.2 Struktur kode
```
app/Models/            Menu, Category, Order, OrderItem, Payment, User
app/Enums/             OrderStatus, PaymentStatus, UserRole
app/Http/Controllers/  Auth/, Customer/ (Menu, Cart, Checkout, Order), Admin/ (Dashboard, Order, Menu, User)
app/Http/Middleware/   EnsureUserIsAdmin (alias 'admin'), EnsureUserIsActive
app/Http/Requests/     FormRequest per aksi tulis
app/Services/          CartService, CheckoutService, OrderStatusService (aturan transisi status)
resources/views/layouts/  app.blade.php (customer), admin.blade.php (sidebar sekali saja)
resources/views/components/  menu-card, status-badge, stat-card
```
Jaga controller tetap tipis; logika bisnis di Service/Action. Gunakan Eloquent + eager loading (hindari N+1). Gunakan Policy/middleware untuk otorisasi.

### 8.3 Peta route
```
GET  /                       -> redirect ke /menu
GET  /menu                   -> katalog (search ?q=, filter ?category=)       name: menu.index
GET/POST  /login, /register ; POST /logout                                      name: login, register, logout
-- auth --
GET/POST/PATCH/DELETE /cart ...                                                 name: cart.*
GET  /checkout ; POST /checkout                                                 name: checkout.*
GET  /orders ; GET /orders/{order} ; POST /orders/{order}/reorder               name: orders.*
-- auth + admin (prefix /admin, name admin.*) --
GET  /admin                     dashboard
resource /admin/orders          (index, show) + PATCH /admin/orders/{order}/status
resource /admin/menus           (CRUD) + PATCH /admin/menus/{menu}/toggle
resource /admin/users           (index, update, destroy) + PATCH suspend / restore
```

---

## 9. Roadmap Pengembangan **[REKOMENDASI]**

Kerjakan **berurutan**; tiap fase harus lulus acceptance criteria sebelum lanjut. Satu fase = satu branch/PR kecil.

**Fase 0 — Stabilkan fondasi**
- Inventarisasi folder `reference/` dan buat `reference/INDEX.md`; ekstrak design tokens ke `resources/css/app.css` (bagian 2A).
- Pulihkan route (versi di bagian 8.3, dimulai dengan route yang sudah ada), perbaiki nama route dan casing view `payconfirm`.
- Buat `layouts/app` dan `layouts/admin`; pindahkan view ke layout; ganti CDN dengan `@vite` (Tailwind 4 lokal).
- Rapikan migrasi `role` (hapus pasangan add/drop, ganti dengan satu migrasi yang menambah `role` dan `status`).
- Set `APP_NAME=KantinPapa`, timezone `Asia/Jakarta`, locale sesuai keputusan.
- Ubah blok database di `.env.example` ke MySQL (`DB_CONNECTION=mysql`, host/port/nama DB tanpa kredensial asli) dan atur `config/database.php` bila perlu; siapkan database test MySQL terpisah untuk `phpunit.xml`.
- *Selesai bila:* semua halaman terbuka tanpa error di Linux, `php artisan route:list` menampilkan route lengkap, `composer test` hijau.

**Fase 1 — Autentikasi & role**
- Register/login/logout (session), validasi lewat FormRequest, middleware `admin` & `active`, seeder akun admin + data contoh.
- Redirect pasca-login: admin → `/admin`, user → `/menu`. Akun `suspended` tidak bisa login.
- *Selesai bila:* test feature untuk register, login, akses admin ditolak untuk user biasa.

**Fase 2 — Menu & kategori (data nyata)**
- Model + migrasi `stock`; seeder 5 kategori dan menu contoh.
- Katalog customer membaca DB (pencarian, filter kategori, Sold Out saat stok 0 atau tidak tersedia, Popular Today dari jumlah order hari ini).
- CRUD menu admin (upload gambar ke `storage/public`), toggle Active/Off.

**Fase 3 — Keranjang & checkout**
- Keranjang berbasis session (tambah, ubah qty, hapus, halaman kosong), hitung subtotal + pajak 10% di server.
- Checkout membuat `orders` + `order_items` dalam transaksi, mengurangi stok, menghasilkan `order_number`.
- Halaman "Order Placed!" dan **Riwayat pesanan** dari DB + Order Again.

**Fase 4 — Manajemen order & dashboard admin**
- Daftar order dengan filter status, aksi ubah status memakai `OrderStatusService` (transisi valid saja), Cancel mengembalikan stok.
- Dashboard: angka dari query nyata (revenue total/hari ini, jumlah order per status, jumlah menu).
- Manajemen user: statistik, cari, filter role, suspend/restore/delete (admin tidak boleh menghapus/menangguhkan dirinya sendiri).

**Fase 5 — Pembayaran QRIS**
- Mulai dengan konfirmasi pembayaran manual oleh admin (Pending → Paid), lalu integrasi payment gateway (mis. Midtrans/Xendit) dengan webhook idempoten dan verifikasi signature. *Keputusan gateway ada di pemilik proyek.*

**Fase 6 — Penyempurnaan**
- Notifikasi status order (polling atau Laravel Reverb/broadcast), laporan grafik harian/mingguan/bulanan, PWA/mobile-friendly, rate limiting, logging.

---

## 10. Aturan untuk AI Agent

**Wajib**
- Baca bagian 3, 4, dan 7 sebelum mengubah apa pun; jangan berasumsi kolom `role`, stok, atau route sudah ada.
- Ikuti gambar di `reference/` sebagai acuan visual (bagian 2A); untuk halaman tanpa gambar, pertahankan gaya view yang ada. Saat mengubah markup statis menjadi dinamis, jangan mengubah tampilan kecuali gambar referensi atau pemilik proyek memintanya.
- Pelihara `reference/INDEX.md` dan dokumen ini: setelah satu fase selesai, perbarui bagian 6 (Status Progress) dan 7 (Masalah) agar sesuai kondisi kode.
- Semua validasi dan perhitungan uang **di server** (jangan percaya harga/total dari klien). Pajak 10% dihitung ulang di backend.
- Setiap migrasi baru: file baru dengan `up()` dan `down()`; jangan edit migrasi yang sudah ter-commit dan pernah dijalankan. Database yang dipakai adalah **MySQL** (lihat bagian 11): jangan menulis kode atau migrasi yang hanya jalan di SQLite.
- Tulis test (PHPUnit Feature test) untuk setiap fitur yang ditambahkan; jalankan `composer test` dan `./vendor/bin/pint` sebelum selesai.
- Gunakan `@csrf`, mass-assignment yang eksplisit (`#[Fillable]`/`$fillable`), Policy/middleware untuk otorisasi, dan `DB::transaction` untuk operasi multi-tabel.
- Commit kecil dan bermakna dengan pesan Bahasa Inggris gaya `feat:`, `fix:`, `refactor:` (sesuai histori repo).
- Teks UI mengikuti bahasa yang sudah ada pada halaman terkait; tanyakan bila ingin menyeragamkan bahasa.

**Dilarang**
- Meng-commit `.env`, kunci, atau kredensial payment gateway.
- Menghapus atau menimpa view yang ada tanpa konfirmasi (riwayat repo menunjukkan sebuah "reset" pernah membuang pekerjaan).
- Menambah dependensi besar (admin panel penuh seperti Filament, Livewire/Inertia) tanpa persetujuan — stack saat ini sengaja sederhana: Blade + Tailwind.
- Melompati fase roadmap atau mengerjakan banyak fase dalam satu perubahan.

**Saat ragu:** tanyakan kepada pemilik proyek. Keputusan terbuka saat ini: (1) gateway pembayaran QRIS yang dipakai, (2) apakah keranjang disimpan di session atau database, (3) satu atau banyak penjual per kantin (saat ini diasumsikan **satu kantin, satu admin tim**), (4) bahasa UI final, (5) gambar referensi mana yang berlaku bila ada versi ganda atau bertentangan.

---

## 11. Perintah yang Sering Dipakai

```bash
composer dev                 # server dev + vite
composer test                # jalankan test (config:clear + artisan test)
./vendor/bin/pint            # format kode PHP
php artisan migrate          # jalankan migrasi (jangan migrate:fresh tanpa izin pemilik proyek)
php artisan route:list       # cek route
npm run build                # build aset produksi
```
**Database: MySQL.** Konfigurasi koneksi ada di `.env` lokal (`DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). `.env` tidak boleh di-commit dan agent tidak boleh membaca, mencetak, atau mengubah kredensial di dalamnya kecuali diminta.

Jangan menjalankan perintah yang menghapus data (`migrate:fresh`, `migrate:rollback`, `db:wipe`, `TRUNCATE`, `DROP`) tanpa konfirmasi pemilik proyek, karena ini database MySQL sungguhan, bukan berkas yang mudah dibuat ulang.

**Catatan MySQL untuk migrasi dan query:**
- Gunakan tipe kolom yang eksplisit; uang disimpan sebagai `unsignedInteger` (Rupiah utuh) atau `decimal(12,2)`, bukan `float`.
- Foreign key memakai `foreignId()->constrained()` dengan aksi `onDelete` yang disengaja (mis. `restrictOnDelete` untuk `order_items.menu_id` agar riwayat tidak rusak).
- Urutan migrasi harus benar karena MySQL menegakkan foreign key: tabel induk (`categories`, `users`) dibuat sebelum tabel anak.
- Tambahkan index pada kolom yang sering difilter (`orders.order_status`, `orders.user_id`, `menus.category_id`, `users.role`).
- Pencarian menu/user memakai `LIKE` (collation `utf8mb4_unicode_ci` tidak peka huruf besar-kecil); bila perlu pencarian teks lanjutan, pertimbangkan `FULLTEXT` pada fase penyempurnaan.
- Pengurangan stok saat checkout memakai `DB::transaction` dan penguncian baris (`lockForUpdate()`) agar tidak terjadi stok minus saat dua pesanan bersamaan.
- Session, cache, dan queue memakai driver `database` di MySQL yang sama (tabel `sessions`, `cache`, `jobs` sudah ada di migrasi).
- Test: `phpunit.xml` **[FAKTA]** memakai `sqlite` `:memory:`. Karena produksi/dev memakai MySQL, pertimbangkan database test MySQL terpisah (mis. `kantinpapa_test`) agar perilaku foreign key, transaksi, dan penguncian baris teruji sama; jangan pernah mengarahkan test ke database utama.
