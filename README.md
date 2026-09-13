# 🍽️ KantinPapa

**KantinPapa** adalah aplikasi web pemesanan makanan kantin kampus yang memungkinkan mahasiswa memesan makanan secara online tanpa perlu mengantre, serta menyediakan panel admin untuk mengelola pesanan, menu, dan pengguna secara real-time.


## 📋 Daftar Isi
1. [Deskripsi Aplikasi](#-deskripsi-aplikasi)
2. [Fitur Utama](#-fitur-utama)
3. [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
4. [Struktur Proyek](#-struktur-proyek)
5. [Cara Penggunaan](#-cara-penggunaan)
6. [Alur Pengguna](#-alur-pengguna)
7. [Roadmap Pengembangan](#-roadmap-pengembangan)
8. [Kontribusi](#-kontribusi)



---

## 📖 Deskripsi Aplikasi

Kantin kampus sering mengalami antrean panjang pada jam sibuk, terutama saat jam istirahat, sehingga mahasiswa harus menghabiskan waktu menunggu hanya untuk memesan makanan. **KantinPapa** hadir sebagai solusi digital yang menjembatani mahasiswa (customer) dengan pihak pengelola kantin (admin) melalui satu platform pemesanan online yang cepat dan mudah digunakan.

Melalui KantinPapa, mahasiswa dapat menelusuri menu yang tersedia pada hari itu, melihat harga dan sisa stok secara langsung, menambahkan item ke keranjang, melakukan pembayaran (misalnya via QRIS), lalu tinggal datang ke counter saat pesanan sudah siap diambil — tanpa perlu mengantre di kasir.

Di sisi lain, pihak kantin (admin) dapat memantau seluruh transaksi yang masuk secara real-time, mengubah status pesanan (Pending → Paid → Preparing → Ready → Completed), mengelola daftar menu (menambah, mengedit, menghapus, atau menonaktifkan item), serta mengawasi aktivitas dan status akun pengguna, semua dari satu dashboard admin yang terpusat dan informatif.

**Tujuan utama aplikasi:**
- Mempersingkat waktu tunggu pemesanan makanan di kantin kampus.
- Mempermudah pengelola kantin dalam memantau penjualan dan operasional harian.
- Memberikan transparansi stok dan status pesanan kepada mahasiswa.
- Menyediakan data dan laporan sederhana (revenue, jumlah pesanan, dsb.) bagi pihak kantin.

---

## ✨ Fitur Utama

### 👤 Sisi Customer (Mahasiswa)
| Fitur | Deskripsi |
|---|---|
| **Halaman Menu** | Menampilkan seluruh makanan/minuman yang tersedia hari itu lengkap dengan foto, nama, harga, dan sisa stok. |
| **Pencarian Menu** | Kolom pencarian untuk menemukan makanan/minuman tertentu dengan cepat. |
| **Filter Kategori** | Menyaring menu berdasarkan kategori: Rice Bowls, Noodles, Snacks, Drinks, Desserts. |
| **Popular Today** | Menyorot menu-menu yang paling banyak dipesan pada hari itu. |
| **Status Ketersediaan** | Menandai item yang stoknya habis (**Sold Out** / *Unavailable*) secara jelas agar mahasiswa tidak salah pesan. |
| **Keranjang & Checkout** | Menambahkan item ke keranjang (*Add to Cart*) dan melanjutkan ke proses pembayaran. |
| **Riwayat Pesanan** | Melihat daftar pesanan yang pernah dibuat, lengkap dengan nomor order, tanggal, rincian item, status pembayaran, status pesanan, dan total harga (termasuk pajak). |
| **Order Again** | Memesan ulang menu dari riwayat pesanan sebelumnya dengan satu klik. |

### 🛠️ Sisi Admin (Pengelola Kantin)
| Fitur | Deskripsi |
|---|---|
| **Dashboard Analitik** | Ringkasan performa kantin secara real-time: Total Revenue, Today's Revenue, Total Orders, Pending Orders, Completed Orders, dan jumlah Menu Items beserta ketersediaannya. |
| **Order Management** | Memantau seluruh pesanan yang masuk, memfilter berdasarkan status (All, Pending, Paid, Preparing, Ready, Completed, Cancelled), serta memperbarui status pesanan (mis. Pending → Paid → Ready → Completed) atau membatalkannya. |
| **Menu Management** | Menambah menu baru (*+ Add items*), mengedit, menghapus, serta mengaktifkan/menonaktifkan (*Active*/*Off*) item menu tertentu, dilengkapi pencarian dan filter kategori. |
| **Manage Users** | Melihat daftar seluruh pengguna terdaftar beserta statistik (Total Users, Active Users, Total Orders, Total Spent), mencari pengguna berdasarkan nama/email, memfilter berdasarkan role (User/Admin), serta mengubah data, menangguhkan (*Suspend*), memulihkan (*Restore*), atau menghapus (*Delete*) akun pengguna. |
| **Manajemen Role** | Membedakan hak akses antara role **User** (mahasiswa) dan **Admin** (pengelola kantin). |
| **Autentikasi & Logout** | Sistem masuk ke panel admin yang terpisah dari halaman customer, beserta fitur keluar (*Log out*) yang aman. |

---

## 🧰 Teknologi yang Digunakan

| Kategori | Teknologi |
|---|---|
| Markup | **HTML5** |
| Styling | **Tailwind CSS** (via CDN — `@tailwindcss/browser`) |
| Design | **Figma** 
| Version Control | **Git & GitHub** |

---



## 🚀 Cara Penggunaan

### Sebagai Customer (Mahasiswa)
1. Buka halaman **Menu** 
2. Gunakan kolom pencarian atau filter kategori untuk menemukan makanan/minuman yang diinginkan.
3. Klik **"+ Add to Cart"** pada item yang ingin dipesan.
4. Lanjutkan ke proses pembayaran (checkout).
5. Setelah pembayaran berhasil, cek status pesanan melalui menu **"My Orders"** 
6. Ambil pesanan di counter kantin saat status berubah menjadi **Completed**.

### Sebagai Admin (Pengelola Kantin)
1. Login ke **Admin Panel**.
2. Pantau ringkasan performa kantin hari itu di halaman **Dashboard**
3. Buka menu **Orders** untuk melihat pesanan yang masuk, lalu perbarui statusnya sesuai proses (Pending → Paid → Preparing → Ready → Completed), atau batalkan pesanan bila diperlukan.
4. Buka menu **Menu**  untuk menambah, mengedit, menghapus, atau menonaktifkan sementara (*Unavailable*) item menu.
5. Buka menu **Users** untuk memantau daftar pengguna, mencari akun tertentu, mengubah status (*Suspend*/*Restore*), atau menghapus akun bila diperlukan.
6. Klik **Log out** saat selesai menggunakan panel admin.

---

## 🔄 Alur Pengguna

```
[Mahasiswa]                                   [Admin]
    |                                             |
    v                                             v
Buka Menu Kantin                          Login Admin Panel
    |                                             |
    v                                             v
Cari & Pilih Menu                         Lihat Dashboard
    |                                             |
    v                                             v
Tambah ke Keranjang                    Pantau Order Masuk
    |                                             |
    v                                             v
Bayar (QRIS)                         Update Status Pesanan
    |                                             |
    v                                             v
Lihat Riwayat Pesanan              Kelola Menu & Pengguna
    |                                             |
    v                                             v
Ambil Pesanan di Counter                     Logout
```

---

## 🗺️ Roadmap Pengembangan

- [ ] Integrasi backend & database untuk penyimpanan data pesanan secara persisten.
- [ ] Sistem autentikasi nyata (login/register) untuk customer dan admin.
- [ ] Integrasi pembayaran QRIS/payment gateway sungguhan.
- [ ] Notifikasi real-time saat status pesanan berubah.
- [ ] Laporan penjualan dalam bentuk grafik (harian/mingguan/bulanan).
- [ ] Versi mobile-friendly / PWA (Progressive Web App).

---

