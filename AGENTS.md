# Merganteks Sklad - AI Agentlari uchun qo‘llanma

Ushbu fayl loyihada ishlaydigan AI kod-agentlari uchun mo‘ljallangan. Loyiha haqidagi asosiy ma'lumotlar, arxitektura, konventsiyalar va ehtiyot choralari quyida keltirilgan.

---

## 1. Loyiha haqida umumiy ma'lumot

**Merganteks Sklad** — bu toʻqimachilik korxonasi uchun moʻljallangan veb-asosidagi ombor (sklad) boshqaruv tizimi. U quyidagi modullarni oʻz ichiga oladi:

- **Pryaja** — ip yoki ipchikdan iborat xom ashyoning kirim-chiqimini boshqarish.
- **Xom mato** — xom mato (raw fabric) kiritish, qoldiqni nazorat qilish va chiqimini qayd etish.
- **Tayyor mato** — tayyor mato (finished fabric) uchun xuddi shunday kirim-chiqim va qoldiq boshqaruvi.
- **Ximikat** — kimyoviy mahsulotlar (kraska, pigment, parafin va boshqalar) roʻyxati va ularning kilogrammdagi qoldiqlari.
- **KROY** — kroy (kesim) jarayonlari uchun ma'lumotlarni kiritish (hozircha sodda shaklda, lekin katta qismi kommentariyaga olingan).
- **Mijozlar** — mijozlarni roʻyxatga olish, qidirish, tahrirlash va oʻchirish.
- **Shartnoma** — ijaraga berish shartnomasini PDF shaklida yaratish (loyihadagi boshqa qismlar bilan bevosita bogʻliq emas).

Tizimda rollar mavjud (`users.role` maydoni orqali), lekin amalda faqat oddiy login tekshiruvi (`auth_check.php`) ishlatiladi.

---

## 2. Texnologiyalar steki

| Qism | Texnologiya |
|------|-------------|
| Backend | PHP (protsedural/uslubda yozilgan, OOP ishlatilmagan) |
| Ma'lumotlar bazasi | MySQL / MariaDB (PDO orqali ulanadi) |
| Veb-server | Apache (XAMPP steki) |
| Frontend | HTML, CSS, JavaScript (vanilla + jQuery) |
| UI kutubxonalar | Bootstrap 5.3, Bootstrap Icons, Tailwind CSS (CDN orqali) |
| Jadval va diagrammalar | DataTables, Chart.js |
| Tanlash elementlari | Select2 (ximikat sahifasida) |
| PDF generatsiya | FPDF 1.86 (`fpdf186/`) |
| Boshqa | DOMDocument/PHPWord ishlatilmaydi; `.docx` fayllar shablon sifatida saqlangan |

> **Muhim:** Loyihada `composer.json`, `package.json`, `pyproject.toml`, `Cargo.toml` kabi paket menejerlari mavjud **emas**. Barcha bogʻliqliklar CDN orqali yoki XAMPP bilan birga keladigan PHP kengaytmalari orqali ta'minlanadi.

---

## 3. Loyiha tuzilishi

```
sklad/
├── auth/               # Autentifikatsiya: login, logout, parolni o'zgartirish, sessiya tekshiruvi
├── db/                 # db_con.php — yagona PDO ulanish fayli
├── api/                # AJAX/REST endpointlar
│   ├── chemical/       # Ximikat mahsulotlari bilan ishlash
│   ├── cutting/        # KROY ma'lumotlarini saqlash
│   ├── fabric/         # Tayyor mato bilan ishlash
│   ├── raws/           # Xom mato bilan ishlash
│   └── stats/          # Statistika va KPI endpointlar
├── pages/              # Asosiy sahifalar (SPA kabi index.php ichida yuklanadi)
│   ├── chemical/
│   ├── fabric/
│   ├── kroy/
│   ├── raw/
│   ├── pryaja.php
│   └── pryaja_out.php
├── assets/             # CSS va JS fayllar
├── uploads/            # Yuklangan rasmlar
│   ├── chemicals/
│   └── products_raw/
├── fpdf186/            # PDF generatsiya kutubxonasi
├── index.php           # Asosiy kirish nuqtasi (SPA shell)
├── dashboard.php       # Dashboard sahifasi (hozircha faqat shablonda ishlaydi)
├── client_page.php     # Mijozlar sahifasi
├── contract.php        # Shartnoma shaklini kiritish
├── generate_contract.php # PDF shartnoma yaratish
└── AGENTS.md           # Ushbu fayl
```

### 3.1. Kirish nuqtasi va navigatsiya

- Foydalanuvchi avval `auth/login.php` orqali tizimga kiradi.
- Muvaffaqiyatli login dan soʻng `index.php` ga yoʻnaltiriladi.
- `index.php` SPA (Single Page Application) shell vazifasini bajaradi: chap menyu orqali tanlangan boʻlimni hash URL (`#/pages/raw/raw_material`) asosida `$('#content_body').load(...)` orqali yuklaydi.
- Har bir sahifa alohida `.php` fayl boʻlib, toʻliq HTML sahifa emas, balki `index.php` ichidagi `#content_body` ga yuklanadigan fragment.

### 3.2. API konventsiyalari

- API endpointlarining koʻpchiligi JSON qaytaradi.
- Muvaffaqiyatli javob: `{"success": true, ...}`
- Xatolik javobi: `{"success": false, "message": "..."}` yoki `{"success": false, "errors": {...}}`
- Ba'zi eski endpointlar oddiy matn qaytaradi (masalan, `echo "Mijoz muvaffaqiyatli qo‘shildi!";`).
- POST soʻrovlar uchun `FormData` (rasm bilan) yoki `application/x-www-form-urlencoded` ishlatiladi.

### 3.3. Ma'lumotlar bazasi ulanishi

Barcha fayllar `db/db_con.php` ni ulaydi:

```php
require_once "../db/db_con.php";   // ichki papkalardan
require_once "./db/db_con.php";    // ildizdan
```

Ulanish sozlamalari `db/db_con.php` da aniq koʻrsatilgan. Localhost uchun eski sozlamalar kommentariyaga olingan.

---

## 4. Ma'lumotlar bazasi

Quyidagi jadvallar koddan aniqlangan. Toʻliq sxema (schema) loyiha kodlarida tarqalgan, alohida `.sql` dump fayli mavjud emas.

| Jadval | Tavsif |
|--------|--------|
| `users` | Foydalanuvchilar (`id`, `username`, `password` — bcrypt hash, `role`) |
| `clients` | Mijozlar (`id`, `name`, `phone`, `image`, `address`, `passport`, `note`, `created_at`) |
| `suppliers` | Yetkazib beruvchilar (`id`, `name`, `type` — 'in' yoki 'out') |
| `machines` | Stanok/mashinalar (`id`, `name`, `status`) |
| `products_pryaja_in` | Pryaja kirimi (`lot_number`, `bags_count`, `weight_kg`, `ne_number`, `composition`, `composition_percent`, `product_date`, `is_deleted`) |
| `products_pryaja_out` | Pryaja chiqimi (`product_in_id`, `lot_number`, `bags_count`, `weight_kg`, `ne_number`, `composition`, `composition_percent`, `supplier_id`, `product_date`) |
| `products_raw` | Xom mato katalogi (`artikul`, `product_cm`, `composition`, `percentage`, `gramm`, `width`, `weaving`, `yarn_count`, `product_date`, `comment`, `image`, `is_delete`) |
| `raw_inventory` | Xom mato kirim-chiqimi (`product_id`, `direction` — 'in'/'out', `meter`, `comment`, `created_at`) |
| `products_fabric` | Tayyor mato katalogi (xom mato bilan deyarli bir xil maydonlar + `color_type`, `color_name`) |
| `fabric_inventory` | Tayyor mato kirim-chiqimi (`product_id`, `direction`, `meter`, `comment`, `created_at`) |
| `chemical_products` | Ximikat mahsulotlari (`product_name`, `category`, `composition`, `date`, `image`, `machine_ids`) |
| `chemical_inventory` | Ximikat kirim-chiqimi (`product_id`, `direction` — 'in'/'out', `kg`, `comment`, `created_at`) |
| `equipment` | Asbob-uskunalar roʻyxati (ijaraga berish moduli uchun, hozircha faqat statistikada ishlatiladi) |
| `rentals` | Ijaralar roʻyxati (`client_id`, `status`, `total_amount`, `start_time`, `end_time`, ...) |
| `rental_items` | Ijaraga olingan jihozlar |
| `returned_items` | Qaytarilgan jihozlar |

### 4.1. Koʻrinishlar (Views)

Quyidagi MySQL viewlar ishlatiladi (kodda uchraydi):

- `v_raw_balance` — har bir `products_raw` uchun qoldiq hisob (`in` — `out`).
- `v_fabric_balance` — har bir `products_fabric` uchun qoldiq hisob.
- `v_chemical_balance` — har bir `chemical_products` uchun qoldiq hisob.

Agar ushbu viewlar mavjud boʻlmasa, tegishli statistika sahifalari ishlamaydi.

---

## 5. Ishga tushirish (Build & Run)

Loyiha uchun maxsus "build" bosqichi yoʻq. Quyidagi qadamlar bajariladi:

1. **XAMPP** oʻrnatilgan boʻlishi kerak (Apache + MySQL/MariaDB + PHP).
2. Loyihani `xampp/htdocs/merganteks.com/sklad` ga (yoki boshqa DocumentRoot) joylashtirish.
3. MySQL serverini ishga tushirish.
4. Ma'lumotlar bazasini yaratish va jadvallarni/importni joylashtirish (dump mavjud emas, kerak boʻlsa administratordan soʻrash kerak).
5. `db/db_con.php` dagi ulanish sozlamalarini moslash.
6. Brauzerda `http://localhost/merganteks.com/sklad/auth/login.php` manziliga kirish.
7. Birinchi foydalanuvchini yaratish uchun `auth/register.php` ni bir marta chaqirish mumkin (standart: `admin` / `123456`).

> **Eslatma:** `php` CLI yoʻlda yoʻq, shuning uchun loyiha faqat brauzer orqali va Apache/XAMPP muhitida ishga tushiriladi.

---

## 6. Kod yozish uslubi (Code Style)

### 6.1. Umumiy qoidalar

- PHP va JavaScript kodlari asosan **protsedural uslubda** yozilgan.
- OOP ishlatilmagan.
- Kod va izohlar **o‘zbek tilida (lotin yozuvida)** yoziladi.
- Fayl nomlari kichik harf bilan, soʻzlar orasida pastki chiziq (`snake_case`) bilan: `add_product_raw.php`, `get_raw_products.php`.
- Oʻzgaruvchilar ham `snake_case`: `$product_id`, `$where_in`.

### 6.2. PHP konventsiyalari

- PHP teglari: `<?php ... ?>`
- Ma'lumotlar bazasi ulanishi: har bir fayl oʻziga kerakli darajadagi `require_once` bilan `db_con.php` ni ulaydi.
- PDO prepared statementlar ishlatiladi, lekin ba'zi joylarda `$_GET`/`$_POST` qiymatlari toʻgʻridan-toʻgʻri SQL ga qoʻshiladi (xavfsizlik boʻlimiga qarang).
- JSON javoblari uchun `header('Content-Type: application/json; charset=utf-8')` qoʻllaniladi.
- Vaqt mintaqasi: `date_default_timezone_set('Asia/Tashkent')` koʻp fayllarda qoʻllaniladi.

### 6.3. Frontend konventsiyalari

- Bootstrap 5 classlari asosiy UI uchun ishlatiladi.
- Tailwind CSS faqat login va dashboard sahifalarida qo‘shimcha sifatida.
- jQuery 3.6/3.7 CDN orqali ulangan.
- Chart.js diagrammalar va DataTables jadvallar uchun.
- Modal oynalar `data-bs-toggle="modal"` orqali ochiladi.
- Forma yuborishda koʻpincha `fetch()` + `FormData` ishlatiladi.

### 6.4. Izohlar

- Izohlar qisqa va ma'noli boʻlishi kerak.
- Eski/kommentariyaga olingan kodlar koʻp. Yangi kod qo‘shishdan oldin eski kommentariyalarni tozalash yoki ularni eslab qolish tavsiya etiladi.

---

## 7. Testlash

Loyihada avtomatlashtirilgan testlar (PHPUnit, Jest va h.k.) mavjud **emas**.

- Testlash qoʻlda brauzer orqali amalga oshiriladi.
- Yangi oʻzgarishlarni tekshirish uchun quyidagi joylarni sinab ko‘rish tavsiya etiladi:
  - Login/logout
  - Har bir modulda mahsulot qo‘shish (Kirim)
  - Pryaja va ximikatda mahsulot chiqimi (Chiqim)
  - Mijoz qo‘shish, tahrirlash, qidirish
  - Statistika sahifalaridagi KPI kartalari va diagrammalar
  - Rasm yuklash funksiyalari
  - PDF shartnoma yaratish

---

## 8. Xavfsizlik

### 8.1. Mavjud himoya choralari

- `auth/auth_check.php` har bir himoyalangan sahifada chaqirib, sessiyadagi `user_id` ni tekshiradi.
- Parollar `password_hash()` bilan bcrypt orqali saqlanadi va `password_verify()` bilan tekshiriladi.
- Ba'zi joylarda PDO prepared statementlar ishlatiladi.
- Fayl yuklashda format tekshiruvi mavjud (jpg, jpeg, png, gif, webp).

### 8.2. Ehtiyotkorlikni talab qiladigan joylar

- **SQL injection:** Ba'zi endpointlarda foydalanuvchi kiritgan qiymatlar to‘g‘ridan-to‘g‘ri SQL so‘roviga qo‘shiladi (masalan, ba'zi `WHERE` shartlari). Har qanday yangi so‘rovda prepared statement bilan parametrlash talab etiladi.
- **XSS:** Chiqariladigan ma'lumotlar ba'zi joylarda `htmlspecialchars()` bilan filtrlanadi, lekin barcha joyda emas. Dinamik HTML yaratishda ehtiyotkorlik kerak.
- **CSRF:** Tokenlar ishlatilmagan. Muhim amallar (oʻchirish, parol o‘zgartirish) uchun CSRF himoyasini qoʻshish tavsiya etiladi.
- **Fayl yuklash:** Fayl hajmi va MIME-turi to‘liq tekshirilmaydi. Serverga PHP fayllari yuklanishining oldini olish kerak.
- **Ruxsatlar:** Rollar (`role`) jadvalda mavjud, lekin amalda hech qayerda tekshirilmaydi. Har qanday tizimga kirgan foydalanuvchi barcha amallarni bajarishi mumkin.
- **Xatolarni ko‘rsatish:** Ba'zi fayllarda `error_reporting(E_ALL); ini_set('display_errors', 1);` yoqilgan (masalan, `pages/chemical/chemical.php`). Production muhitida buni oʻchirish kerak.

---

## 9. Joylashtirish (Deployment)

- Loyiha hozircha faqat **XAMPP/Windows** muhitida ishlaydi.
- Apache virtual host yoki to‘g‘ridan-to‘g‘ri `htdocs` ichidan ishga tushiriladi.
- `.env` fayli yoʻq, barcha sozlamalar koddagi (asosan `db/db_con.php`).
- CI/CD, Docker yoki bash scriptlar mavjud emas.
- Productionga o‘tkazishdan oldin quyidagilarni tekshirish kerak:
  - `display_errors` ni oʻchirish
  - `db/db_con.php` dagi production DB ma'lumotlarini kiritish
  - Upload papkalariga yozish huquqini berish
  - Xavfsizlik nuqtai nazaridan kodni qayta ko‘rib chiqish

---

## 10. AI agentlari uchun eslatmalar

- Yangi funksiya qo‘shishdan oldin avval mavjud shunga oʻxshash modulni (masalan, xom mato uchun `pages/raw/raw_material.php` va `api/raws/`) namuna sifatida o‘rganing.
- Yangi API endpoint yaratganda `header('Content-Type: application/json; charset=utf-8')` qoʻshish va JSON shaklida javob qaytarish tavsiya etiladi.
- Har bir yangi sahifa `auth/auth_check.php` ni (yoki `db/db_con.php` ni) to‘g‘ri darajadan `require` qilishi kerak.
- Yangi ma'lumotlar bazasi soʻrovlarida **har doim prepared statement** ishlating.
- Front-endda yangi forma qo‘shishda Bootstrap 5 classlaridan foydalaning va mavvali JavaScript uslubiga (fetch + FormData) rioya qiling.
- Rasm yuklash funksiyasi qoʻshilayotgan bo‘lsa, fayl kengaytmasi va hajmini tekshiring.
- Yangi kodni yozishda izohlarni **o‘zbek tilida (lotin)** qoldiring.
- Agar sizga ma'lumotlar bazasi sxemasi kerak boʻlsa, koddagi jadvallar va maydonlar orqali uni tiklashingiz kerak, chunki alohida `.sql` dump fayli yoʻq.

---

*Oxirgi yangilanish: 2026-06-30*
