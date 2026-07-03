-- =====================================================
--  KROY (kesish) bo'limi uchun jadval
--  Merganteks Sklad tizimi
-- =====================================================

CREATE TABLE IF NOT EXISTS `cutting_products` (
    `id`            INT AUTO_INCREMENT PRIMARY KEY,
    `kroy_number`   VARCHAR(50)     DEFAULT NULL,   -- Kroy raqami (KR-001)
    `layer_length`  DECIMAL(10,2)   DEFAULT NULL,   -- Qatlam uzunligi (m)
    `layer_count`   INT             DEFAULT NULL,   -- Qatlam soni
    `composition`   VARCHAR(100)    DEFAULT NULL,   -- Mato tarkibi
    `percentage`    VARCHAR(50)     DEFAULT NULL,   -- Foiz (65/35)
    `gramm`         INT             DEFAULT NULL,   -- Grami (g/m2)
    `width`         INT             DEFAULT NULL,   -- Eni (sm)
    `model_name`    VARCHAR(150)    DEFAULT NULL,   -- Model nomi
    `sizes`         VARCHAR(100)    DEFAULT NULL,   -- O'lchamlar (S,M,L,XL)
    `quantity`      INT             DEFAULT NULL,   -- Model soni
    `image`         VARCHAR(255)    DEFAULT NULL,   -- Rasm fayl nomi
    `cut_date`      DATE            DEFAULT NULL,   -- Sana
    `is_delete`     TINYINT(1)      DEFAULT 0,      -- Soft delete
    `created_at`    TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
