-- ==========================================================
-- Log HARDWARE - Official Spare Parts & Appliance Store
-- CodeIgniter 3 MySQL Database Schema & Seed Data
-- ==========================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------
-- Table structure for `admins`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT 'Admin Staff',
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'superadmin',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Initial Admin Credentials
-- Email: Sameer123@AA.com
-- Password: Sameer3111 (Bcrypt Hashed)
-- --------------------------------------------------------
INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Sameer Admin', 'Sameer123@AA.com', '$2y$10$dWkCzJyxzTMkutRscWJnLeDr4FDtu51OLcjylmSvAxnt4BMG.psVa', 'superadmin', 'active', NOW());

-- --------------------------------------------------------
-- Table structure for `categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT 'inventory_2',
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_category_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Seed Categories (From Stitch design references)
-- --------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `status`, `created_at`) VALUES
(1, 'AC', 'ac', 'Air Conditioner parts, compressors, filters, remotes and PCB boards', 'mode_fan', 'active', NOW()),
(2, 'Washing machine', 'washing-machine', 'Washers, drain pumps, inlet valves, timers, drums and pulsators', 'local_laundry_service', 'active', NOW()),
(3, 'Refrigerator', 'refrigerator', 'Fridges, defrost thermostats, relays, gas charging valves, door gaskets', 'kitchen', 'active', NOW()),
(4, 'Micro oven', 'micro-oven', 'Microwave ovens, high voltage magnetrons, capacitors, glass plates, diodes', 'microwave', 'active', NOW()),
(5, 'Water purifier', 'water-purifier', 'RO membranes, sediment filters, carbon blocks, booster pumps, adapters', 'water_drop', 'active', NOW());

-- --------------------------------------------------------
-- Table structure for `products`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(11) UNSIGNED NOT NULL,
  `brand` varchar(100) NOT NULL DEFAULT 'Universal',
  `product_name` varchar(200) NOT NULL,
  `sku` varchar(80) NOT NULL,
  `size` varchar(80) DEFAULT 'Standard',
  `description` text DEFAULT NULL,
  `specs` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `original_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT 'default.png',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_sku` (`sku`),
  KEY `idx_category` (`category_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Seed Products (Matching the Stitch Visual Design Exactly)
-- --------------------------------------------------------
INSERT INTO `products` (`id`, `category_id`, `brand`, `product_name`, `sku`, `size`, `description`, `specs`, `price`, `original_price`, `stock_quantity`, `image`, `is_featured`, `status`, `created_at`) VALUES
(1, 1, 'LG, Samsung, Daikin, Voltas', 'AC Air Filter', 'AC-FILT-STD-01', 'Standard', 'High density washable poly-mesh air filter suitable for all split and window air conditioner models.', '{\"material\":\"HD Polypropylene Mesh\",\"washable\":\"Yes\",\"dimensions\":\"305mm x 310mm\",\"warranty\":\"6 Months\"}', 350.00, 499.00, 18, 'ac-air-filter.svg', 1, 'active', NOW()),
(2, 1, 'LG, Daikin, Voltas, Hitachi', 'AC Compressor', 'AC-COMP-ROT-02', '1.5 Ton / 2 Ton', 'Original heavy duty rotary inverter compressor engineered for 1.5T to 2T energy efficient cooling units.', '{\"type\":\"Rotary Inverter Compressor\",\"refrigerant\":\"R32 / R410A\",\"displacement\":\"14.2 cc\",\"warranty\":\"3 Years Store Warranty\"}', 7850.00, 9500.00, 7, 'ac-compressor.svg', 1, 'active', NOW()),
(3, 1, 'Universal, All Brands', 'AC Remote Control', 'AC-REM-UNI-03', 'Universal', 'Universal replacement remote controller pre-programmed with 1000+ brand codes and backlit LCD display.', '{\"display\":\"Backlit LCD Display\",\"distance\":\"Up to 8 Meters\",\"compatibility\":\"1000+ Codes pre-programmed\",\"battery\":\"2x AAA Included\"}', 450.00, 650.00, 42, 'ac-remote-control.svg', 1, 'active', NOW()),
(4, 1, 'LG, Samsung, Daikin, Voltas', 'AC PCB Board', 'AC-PCB-INV-04', '1.5 Ton / 2 Ton', 'Dual inverter control mother board with surge protection and heat-resistant industrial conformal coating.', '{\"type\":\"Dual Inverter Control Board\",\"protection\":\"Surge & Heat Resistant Coating\",\"voltage\":\"220V 50Hz\",\"status\":\"Backorder available in 3 days\"}', 3200.00, 3900.00, 0, 'ac-pcb-board.svg', 0, 'active', NOW()),
(5, 2, 'LG, Samsung', 'Washing Machine Drain Pump', 'WM-PUMP-05', 'Standard', 'High-torque magnetic synchronous drain pump designed for automatic front-load and top-load washers.', '{\"wattage\":\"30W 220V\",\"type\":\"Magnetic Synchronous Pump\",\"warranty\":\"1 Year\"}', 850.00, 1100.00, 15, 'wm-drain-pump.svg', 1, 'active', NOW()),
(6, 3, 'Whirlpool, Samsung, LG', 'Refrigerator Defrost Thermostat', 'RF-THERM-06', 'Standard', 'Bi-metal hermetically sealed defrost bi-metal thermostat with safety cut-off fuse protection.', '{\"cutOffTemp\":\"+10°C\",\"cutInTemp\":\"-5°C\",\"waterproof\":\"Bi-metal Sealed\"}', 380.00, 520.00, 22, 'rf-thermostat.svg', 1, 'active', NOW()),
(7, 4, 'LG, Samsung, IFB', 'Microwave High Voltage Magnetron', 'MO-MAGN-07', 'Universal', 'Industrial-grade 900W 2450MHz microwave heating magnetron tube with dual air-cooled cooling fin array.', '{\"frequency\":\"2450 MHz\",\"output\":\"900W\",\"cooling\":\"Air-cooled fin array\"}', 1450.00, 1850.00, 9, 'mo-magnetron.svg', 1, 'active', NOW()),
(8, 5, 'Kent, Aquaguard, All Brands', 'Water Purifier RO Membrane 75 GPD', 'WP-MEMB-08', 'Standard', '0.0001 Micron thin-film composite polyamide reverse osmosis membrane with 97% mineral salt rejection.', '{\"capacity\":\"75 Gallons/day (0.0001 Micron)\",\"material\":\"Polyamide Thin Film\",\"saltRejection\":\"97%\"}', 1150.00, 1600.00, 30, 'wp-ro-membrane.svg', 1, 'active', NOW());

-- --------------------------------------------------------
-- Table structure for `inquiries`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE `inquiries` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(11) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(30) NOT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','in_progress','completed','cancelled') NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inquiry_product` (`product_id`),
  CONSTRAINT `fk_inquiry_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Seed Sample Inquiries
-- --------------------------------------------------------
INSERT INTO `inquiries` (`id`, `product_id`, `customer_name`, `customer_phone`, `customer_email`, `message`, `status`, `created_at`) VALUES
(1, 2, 'Rajesh Kumar (Technician)', '+91 98450 12345', 'rajesh.cooltech@gmail.com', 'Need bulk pricing for 5 units of 1.5 Ton AC Rotary Compressor for immediate site delivery.', 'new', NOW() - INTERVAL 2 HOUR),
(2, 4, 'Anand Verma', '+91 97412 88990', 'anand.service@outlook.com', 'Is the Dual Inverter AC PCB board compatible with 2022 Daikin Split model FTKP50?', 'in_progress', NOW() - INTERVAL 1 DAY),
(3, 8, 'Suresh Reddy', '+91 99001 44332', 'suresh.r@yahoo.com', 'Looking for 10x RO membrane 75 GPD with pre-filter set for wholesale order.', 'completed', NOW() - INTERVAL 3 DAY);

SET FOREIGN_KEY_CHECKS = 1;
