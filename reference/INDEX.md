# Reference Design Index — KantinPapa

> Inventaris gambar desain Figma di folder `reference/`. Diperbarui setiap halaman selesai diimplementasikan.
> Status: ❌ Belum | 🔧 Sebagian | ✅ Selesai

## Gambar Referensi

| # | Gambar | Halaman / Fungsi | Route Target | File View | Status |
|---|--------|-----------------|--------------|-----------|--------|
| 1 | `Home page.png` | Home / Menu (guest, belum login) | `GET /menu` | `resources/views/users/home.blade.php` | ✅ Selesai (data DB, search, filter kategori) |
| 2 | `Home page - Customer.png` | Home / Menu (logged in) | `GET /menu` | `resources/views/users/home.blade.php` | ✅ Selesai (data DB, search, filter kategori) |
| 3 | `Login page.png` | Login | `GET /login` | `resources/views/auth/login.blade.php` | ✅ Selesai (auth & role aktif) |
| 4 | `Register Page.png` | Register | `GET /register` | `resources/views/auth/register.blade.php` | ✅ Selesai (auth & validasi aktif) |
| 5 | `Cart page 1.png` | Cart (empty) | `GET /cart` | `resources/views/users/cardempty.blade.php` | ❌ Belum |
| 6 | `Cart Page 2.png` | Cart (with items) | `GET /cart` | `resources/views/users/cart.blade.php` | ❌ Belum |
| 7 | `Review-page.png` | Checkout — Step 1: Review Order | `GET /checkout` | *Belum ada view* | ❌ Belum |
| 8 | `Payment-page.png` | Checkout — Step 2: Payment (QRIS) | `GET /checkout` (step 2) | *Belum ada view* | ❌ Belum |
| 9 | `Desktop - 3.png` | Order Placed! (konfirmasi sukses) | `GET /orders/{order}/confirmed` | `resources/views/users/payconfirm.blade.php` | ❌ Belum |
| 10 | `Order History page.png` | Order History | `GET /orders` | `resources/views/users/orderHistory.blade.php` | ❌ Belum |
| 11 | `Admin Dashboard.png` | Admin Dashboard | `GET /admin` | `resources/views/admin/dashboard.blade.php` | ❌ Belum |
| 12 | `Admin Orders.png` | Admin Order Management | `GET /admin/orders` | `resources/views/admin/orderManagement.blade.php` | ❌ Belum |
| 13 | `Admin Menu.png` | Admin Menu Management | `GET /admin/menus` | `resources/views/admin/menuManagement.blade.php` | ✅ Selesai (CRUD, upload gambar, toggle Active/Off) |
| 14 | `Admin Users.png` | Admin User Management | `GET /admin/users` | `resources/views/admin/userManagement.blade.php` | ❌ Belum |

## Design Tokens (Extracted from Reference Images)

### Colors
| Token | Value | Usage |
|-------|-------|-------|
| Primary / Accent | `#DC2626` (red-600) | Buttons, active nav links, logo "Papa", badges, CTA |
| Primary Hover | `#B91C1C` (red-700) | Button hover state |
| Dark / Sidebar BG | `#0A0A0A` / `#171717` (neutral-950 / neutral-900) | Admin sidebar, login left panel |
| Card Background | `#FFFFFF` | Menu cards, stat cards, order cards |
| Page Background (customer) | `#F5F5F5` (neutral-100) | Cart page, order history, checkout |
| Page Background (admin main) | `#FFFFFF` | Admin content area |
| Text Primary | `#171717` (neutral-900) | Headings, body text |
| Text Secondary | `#737373` (neutral-500) | Subtitles, descriptions, labels |
| Text Muted | `#A3A3A3` (neutral-400) | Placeholders, disabled text |
| Success / Green | `#22C55E` (green-500) | "Active" badge, "Completed" badge, "Paid" badge, checkmark |
| Warning / Orange | `#F97316` (orange-500) | "Preparing" badge |
| Danger / Red | `#EF4444` (red-500) | "Cancelled" badge, "Delete" button, "Cancel" button, "Sold Out" overlay |
| Info / Purple | `#8B5CF6` (violet-500) | "Ready" badge |
| Pending / Yellow | `#EAB308` (yellow-500) | "Pending" badge |
| Suspended / Orange-Red | `#F97316` (orange-500) | "Suspended" status badge |

### Typography
| Element | Size / Weight |
|---------|--------------|
| Logo "KantinPapa" | text-2xl font-bold (Kantin=black, Papa=red-600) |
| Page heading | text-3xl / text-4xl font-bold |
| Section heading | text-xl font-bold |
| Card title (menu name) | text-base font-semibold |
| Card price | text-sm font-semibold |
| Body / description | text-sm font-normal text-neutral-500 |
| Button text | text-sm font-semibold |
| Badge text | text-xs font-semibold |
| Stat card value | text-3xl font-bold |
| Stat card label | text-sm text-neutral-500 |
| Nav link | text-base font-medium |

### Spacing & Radius
| Element | Value |
|---------|-------|
| Menu card | rounded-2xl shadow-sm |
| Stat card | rounded-xl border border-neutral-200 |
| Button (CTA) | rounded-full px-6 py-2.5 (pill shape) |
| Button (action, small) | rounded-lg px-4 py-1.5 |
| Input field | rounded-lg border border-neutral-300 |
| Badge | rounded-full px-3 py-1 |
| Admin sidebar | w-80 (desktop), fixed left |
| Customer navbar | h-16, border-b border-neutral-200 |
| Filter pill | rounded-full px-4 py-1.5 border |
| Search input | rounded-full (customer) / rounded-lg (admin) |

### Component Patterns
| Component | Description |
|-----------|-------------|
| **Navbar (customer)** | Logo left, nav links center (Menu, My Orders), cart icon + user avatar+name right. Active link = red text. |
| **Navbar (guest)** | Logo left, Menu link center, cart icon + "Login" red pill button right. |
| **Sidebar (admin)** | Black/dark bg, logo+subtitle top, nav items (Dashboard, Orders, Menu, Users) with icons, active = red bg pill, "Log out" at bottom. |
| **Menu card** | Image top (rounded-t-2xl), "Popular" red badge overlay top-left, name+price below, stock count right-aligned, red "Add to Cart" button bottom. Sold Out: grayscale image + dark overlay + "Sold Out" text, "Unavailable" label instead of stock. |
| **Status badge** | Pill shape (rounded-full), colored bg with matching text: Pending=yellow, Paid=blue, Preparing=orange, Ready=purple, Completed=green, Cancelled=red, Active=green, Suspended=orange. |
| **Stat card** | Icon top-left, big number, label below, subtitle/metric below label. Rounded-xl with subtle border. |
| **Order card (history)** | Order number bold, date below, items list with qty, payment+order status badges right, total (incl.tax) bottom-right. |

## Halaman Tanpa Gambar Referensi

Halaman/state berikut tidak memiliki gambar referensi dan harus didesain konsisten dengan gaya yang sudah ada:

- Validasi error state (semua form)
- Flash messages (success/error) 
- Loading states
- Konfirmasi hapus (modal)
- Admin: form tambah/edit menu (modal atau halaman terpisah)
- Admin: form edit user
- Pagination (menu catalog, order list, user list)
- 404 / 403 / 500 error pages
- User profile/account page (jika ada)

## Catatan

1. **Dua versi Home page**: `Home page.png` (guest/belum login — navbar tanpa My Orders, ada tombol Login) dan `Home page - Customer.png` (logged in — navbar dengan My Orders dan avatar user). Kontennya identik, perbedaan hanya di navbar. → Gunakan satu view dengan conditional `@auth`/`@guest`.
2. **Checkout 2 langkah**: `Review-page.png` (Step 1: Review) dan `Payment-page.png` (Step 2: Payment/QRIS). Belum ada view Blade untuk ini — buat baru.
3. **Cart memiliki 2 state**: `Cart page 1.png` (empty) dan `Cart Page 2.png` (with items). Implementasi sebagai conditional di satu view atau dua partial.
4. **Admin sidebar**: Identik di semua 4 halaman admin. → Blade component/layout.
5. **Customer navbar**: Identik di semua customer pages (hanya active link berubah). → Blade component/layout.
6. **Filter role di Admin Users**: Gambar menunjukkan duplikat filter pills (dua set "All Roles / User / Admin"). Ini kemungkinan artefak Figma; implementasikan satu set saja.
