-- NetsDial Website Database Schema
-- GCM Enterprises | netsdial@gmail.com
-- Created: 2026

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+05:30";

CREATE DATABASE IF NOT EXISTS `netsdial_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `netsdial_db`;

-- --------------------------------------------------------
-- Admin Users Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `role` enum('superadmin','admin','editor') NOT NULL DEFAULT 'admin',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin_users` (`username`, `password`, `email`, `name`, `role`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'netsdial@gmail.com', 'NetsDial Admin', 'superadmin');
-- Default password: password (change immediately after first login)

-- --------------------------------------------------------
-- Site Settings Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_type` varchar(50) DEFAULT 'text',
  `setting_group` varchar(50) DEFAULT 'general',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`, `setting_group`) VALUES
('site_name', 'NetsDial – Russea™ HDPE Net Wholesale Supplier', 'text', 'general'),
('site_tagline', 'India''s Largest Wholesale Russea™ HDPE Net Supplier | Largest from South India', 'text', 'general'),
('site_url', 'https://netsdial.com', 'text', 'general'),
('site_email', 'netsdial@gmail.com', 'email', 'general'),
('site_phone', '9966499144', 'text', 'general'),
('site_whatsapp', '9966499144', 'text', 'general'),
('site_address', 'Plot No.91, Road Number 2, Sri Ram Nagar Colony, Karmanghat, Saroornagar - 500035, Hyderabad, Telangana, India', 'textarea', 'general'),
('company_name', 'GCM Enterprises', 'text', 'general'),
('company_gstin', '', 'text', 'general'),
('company_pan', '', 'text', 'general'),
('company_reg_no', '', 'text', 'general'),
('visitor_count_base', '102098', 'number', 'general'),
('meta_title', 'NetsDial – India''s Largest Russea™ HDPE Net Wholesale Supplier | Pigeon Nets | Safety Nets | Cricket Nets | Hyderabad', 'text', 'seo'),
('meta_description', 'NetsDial by GCM Enterprises is India''s largest wholesale supplier of Russea™ HDPE nets — pigeon netting, balcony safety nets, bird control nets, invisible grills, cricket nets & artificial grass. Supplying dealers PAN India from Hyderabad. Call +91 9966499144.', 'textarea', 'seo'),
('meta_keywords', 'russea hdpe net wholesale supplier india, pigeon net wholesale hyderabad, balcony safety net supplier india, cricket net wholesale south india, hdpe braided net supplier, hdpe twisted net wholesale, largest net supplier south india, bird control net supplier hyderabad, invisible grill wholesale, artificial grass wholesale india, gcm enterprises hyderabad, netsdial', 'textarea', 'seo'),
('google_analytics', '', 'textarea', 'seo'),
('google_search_console', '', 'textarea', 'seo'),
('facebook_url', '', 'text', 'social'),
('instagram_url', '', 'text', 'social'),
('youtube_url', '', 'text', 'social'),
('twitter_url', '', 'text', 'social'),
('logo_path', 'assets/images/logo.png', 'text', 'general'),
('favicon_path', 'assets/images/favicon.png', 'text', 'general'),
('footer_logo_path', 'assets/images/logo.png', 'text', 'general'),
('marquee_text', '🏆 India''s Largest Russea™ HDPE Net Wholesale Supplier &nbsp;|&nbsp; 🚛 PAN India Delivery – All 28 States &nbsp;|&nbsp; 🏅 Russea™ Authorised Wholesale Dealers &nbsp;|&nbsp; 🏏 Largest Cricket Net Suppliers from South India &nbsp;|&nbsp; 🛡️ HDPE Braided, Twisted & Knotted Nets &nbsp;|&nbsp; 📞 Call +91 9966499144 for Wholesale Pricing &nbsp;|&nbsp; ⚡ 10,000+ Dealer Network PAN India &nbsp;|&nbsp; 🌐 Supplying All 28 States & UTs &nbsp;|&nbsp; 🏆 GCM Enterprises – Trusted Since 2013', 'textarea', 'general'),
('smtp_host', 'smtp.gmail.com', 'text', 'email'),
('smtp_port', '587', 'number', 'email'),
('smtp_user', 'netsdial@gmail.com', 'text', 'email'),
('smtp_pass', '', 'password', 'email'),
('smtp_name', 'NetsDial – GCM Enterprises', 'text', 'email');

-- --------------------------------------------------------
-- Districts Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `districts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL DEFAULT 'Telangana',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `districts` (`name`, `slug`, `state`, `sort_order`) VALUES
('Hyderabad', 'hyderabad', 'Telangana', 1),
('Warangal', 'warangal', 'Telangana', 2),
('Karimnagar', 'karimnagar', 'Telangana', 3),
('Nizamabad', 'nizamabad', 'Telangana', 4),
('Khammam', 'khammam', 'Telangana', 5),
('Nalgonda', 'nalgonda', 'Telangana', 6),
('Mahabubnagar', 'mahabubnagar', 'Telangana', 7),
('Adilabad', 'adilabad', 'Telangana', 8),
('Siddipet', 'siddipet', 'Telangana', 9),
('Peddapalli', 'peddapalli', 'Telangana', 10),
('Rajanna Sircilla', 'rajanna-sircilla', 'Telangana', 11),
('Kamareddy', 'kamareddy', 'Telangana', 12),
('Medak', 'medak', 'Telangana', 13),
('Yadadri Bhuvanagiri', 'yadadri-bhuvanagiri', 'Telangana', 14),
('Nagarkurnool', 'nagarkurnool', 'Telangana', 15),
('Jogulamba Gadwal', 'jogulamba-gadwal', 'Telangana', 16),
('Vikarabad', 'vikarabad', 'Telangana', 17),
('Sangareddy', 'sangareddy', 'Telangana', 18),
('Ranga Reddy', 'ranga-reddy', 'Telangana', 19),
('Medchal-Malkajgiri', 'medchal-malkajgiri', 'Telangana', 20),
('Visakhapatnam', 'visakhapatnam', 'Andhra Pradesh', 21),
('Vijayawada', 'vijayawada', 'Andhra Pradesh', 22),
('Tirupati', 'tirupati', 'Andhra Pradesh', 23),
('Guntur', 'guntur', 'Andhra Pradesh', 24),
('Rajahmundry', 'rajahmundry', 'Andhra Pradesh', 25);

-- --------------------------------------------------------
-- Areas Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `district_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `district_id` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `areas` (`district_id`, `name`, `slug`, `sort_order`) VALUES
-- Hyderabad (district_id=1) - 80 areas
(1, 'HITEC City', 'hitec-city', 1),(1, 'Gachibowli', 'gachibowli', 2),(1, 'Financial District', 'financial-district', 3),
(1, 'Jubilee Hills', 'jubilee-hills', 4),(1, 'Banjara Hills', 'banjara-hills', 5),(1, 'Kondapur', 'kondapur', 6),
(1, 'Madhapur', 'madhapur', 7),(1, 'Manikonda', 'manikonda', 8),(1, 'Kokapet', 'kokapet', 9),
(1, 'Shaikpet', 'shaikpet', 10),(1, 'Nanakramguda', 'nanakramguda', 11),(1, 'Narsingi', 'narsingi', 12),
(1, 'Tolichowki', 'tolichowki', 13),(1, 'Film Nagar', 'film-nagar', 14),(1, 'Serilingampally', 'serilingampally', 15),
(1, 'Begumpet', 'begumpet', 16),(1, 'Abids', 'abids', 17),(1, 'Koti', 'koti', 18),
(1, 'Himayat Nagar', 'himayat-nagar', 19),(1, 'Basheerbagh', 'basheerbagh', 20),(1, 'Ameerpet', 'ameerpet', 21),
(1, 'Secunderabad', 'secunderabad', 22),(1, 'Somajiguda', 'somajiguda', 23),(1, 'Punjagutta', 'punjagutta', 24),
(1, 'Lakdikapul', 'lakdikapul', 25),(1, 'Malakpet', 'malakpet', 26),(1, 'Sanjeev Nagar', 'sanjeev-nagar', 27),
(1, 'Khairatabad', 'khairatabad', 28),(1, 'Paradise', 'paradise', 29),(1, 'Kukatpally', 'kukatpally', 30),
(1, 'Miyapur', 'miyapur', 31),(1, 'Nizampet', 'nizampet', 32),(1, 'Bachupally', 'bachupally', 33),
(1, 'Hafeezpet', 'hafeezpet', 34),(1, 'Chandanagar', 'chandanagar', 35),(1, 'Uppal', 'uppal', 36),
(1, 'Ramanthapur', 'ramanthapur', 37),(1, 'Tarnaka', 'tarnaka', 38),(1, 'LB Nagar', 'lb-nagar', 39),
(1, 'Dilsukhnagar', 'dilsukhnagar', 40),(1, 'Vanasthalipuram', 'vanasthalipuram', 41),(1, 'Adibatla', 'adibatla', 42),
(1, 'Kompally', 'kompally', 43),(1, 'Medipally', 'medipally', 44),(1, 'Nacharam', 'nacharam', 45),
(1, 'Habsiguda', 'habsiguda', 46),(1, 'AS Rao Nagar', 'as-rao-nagar', 47),(1, 'Moula Ali', 'moula-ali', 48),
(1, 'Yapral', 'yapral', 49),(1, 'ECIL', 'ecil', 50),(1, 'Sainikpuri', 'sainikpuri', 51),
(1, 'Alwal', 'alwal', 52),(1, 'Boduppal', 'boduppal', 53),(1, 'Ghatkesar', 'ghatkesar', 54),
(1, 'Shamirpet', 'shamirpet', 55),(1, 'Peerzadiguda', 'peerzadiguda', 56),(1, 'Meerpet', 'meerpet', 57),
(1, 'Charminar', 'charminar', 58),(1, 'Falaknuma', 'falaknuma', 59),(1, 'Mehdipatnam', 'mehdipatnam', 60),
(1, 'Tank Bund', 'tank-bund', 61),(1, 'Amberpet', 'amberpet', 62),(1, 'Attapur', 'attapur', 63),
(1, 'Bandlaguda Jagir', 'bandlaguda-jagir', 64),(1, 'Moosapet', 'moosapet', 65),(1, 'Rajendra Nagar', 'rajendra-nagar', 66),
(1, 'Maheshwaram', 'maheshwaram', 67),(1, 'Ibrahimpatnam', 'ibrahimpatnam', 68),(1, 'Medchal', 'medchal', 69),
(1, 'Pocharam', 'pocharam', 70),(1, 'Badangpet', 'badangpet', 71),(1, 'Shamshabad', 'shamshabad', 72),
(1, 'Kandukur', 'kandukur', 73),(1, 'Chengicherla', 'chengicherla', 74),(1, 'Jillelguda', 'jillelguda', 75),
(1, 'Patancheru', 'patancheru', 76),(1, 'BHEL', 'bhel', 77),(1, 'Saroornagar', 'saroornagar', 78),
(1, 'Karmanghat', 'karmanghat', 79),(1, 'Langar Houz', 'langar-houz', 80),
-- Warangal (district_id=2)
(2, 'Warangal City', 'warangal-city', 1),(2, 'Hanamkonda', 'hanamkonda', 2),(2, 'Kazipet', 'kazipet', 3),
(2, 'Parkal', 'parkal', 4),(2, 'Mulugu', 'mulugu', 5),(2, 'Ghanpur', 'ghanpur', 6),
(2, 'Jangaon', 'jangaon', 7),(2, 'Mahabubabad', 'mahabubabad', 8),(2, 'Bhupalpally', 'bhupalpally', 9),
-- Karimnagar (district_id=3)
(3, 'Karimnagar City', 'karimnagar-city', 1),(3, 'Manthani', 'manthani', 2),(3, 'Huzurabad', 'huzurabad', 3),
(3, 'Choppadandi', 'choppadandi', 4),(3, 'Sircilla', 'sircilla', 5),(3, 'Metpally', 'metpally', 6),
(3, 'Korutla', 'korutla', 7),(3, 'Jagtial', 'jagtial', 8),
-- Nizamabad (district_id=4)
(4, 'Nizamabad City', 'nizamabad-city', 1),(4, 'Bodhan', 'bodhan', 2),(4, 'Armoor', 'armoor', 3),
(4, 'Bheemgal', 'bheemgal', 4),(4, 'Kamareddy', 'kamareddy', 5),(4, 'Yellareddy', 'yellareddy', 6),
-- Khammam (district_id=5)
(5, 'Khammam City', 'khammam-city', 1),(5, 'Kothagudem', 'kothagudem', 2),(5, 'Palwancha', 'palwancha', 3),
(5, 'Bhadrachalam', 'bhadrachalam', 4),(5, 'Manuguru', 'manuguru', 5),(5, 'Sathupally', 'sathupally', 6),(5, 'Wyra', 'wyra', 7),
-- Nalgonda (district_id=6)
(6, 'Nalgonda City', 'nalgonda-city', 1),(6, 'Miryalaguda', 'miryalaguda', 2),(6, 'Suryapet City', 'suryapet-city', 3),
(6, 'Kodad', 'kodad', 4),(6, 'Huzurnagar', 'huzurnagar', 5),(6, 'Devarakonda', 'devarakonda', 6),(6, 'Yadagirigutta', 'yadagirigutta', 7),
-- Mahabubnagar (district_id=7)
(7, 'Mahabubnagar City', 'mahabubnagar-city', 1),(7, 'Gadwal', 'gadwal', 2),(7, 'Wanaparthy', 'wanaparthy', 3),
(7, 'Narayanpet', 'narayanpet', 4),(7, 'Kodangal', 'kodangal', 5),
-- Adilabad (district_id=8)
(8, 'Adilabad City', 'adilabad-city', 1),(8, 'Nirmal', 'nirmal', 2),(8, 'Bellampally', 'bellampally', 3),
(8, 'Kaghaznagar', 'kaghaznagar', 4),(8, 'Utnoor', 'utnoor', 5),(8, 'Mancherial', 'mancherial', 6),(8, 'Ramagundam', 'ramagundam', 7),
-- Siddipet (district_id=9)
(9, 'Siddipet City', 'siddipet-city', 1),(9, 'Gajwel', 'gajwel', 2),(9, 'Dubbak', 'dubbak', 3),(9, 'Cheriyal', 'cheriyal', 4),
-- Peddapalli (district_id=10)
(10, 'Peddapalli', 'peddapalli', 1),(10, 'Godavarikhani', 'godavarikhani', 2),(10, 'Sultanabad', 'sultanabad', 3),(10, 'Jammikunta', 'jammikunta', 4),
-- Rajanna Sircilla (district_id=11)
(11, 'Vemulawada', 'vemulawada', 1),(11, 'Gambhiraopet', 'gambhiraopet', 2),
-- Kamareddy (district_id=12)
(12, 'Banswada', 'banswada', 1),(12, 'Domakonda', 'domakonda', 2),(12, 'Gandhari', 'gandhari', 3),
-- Medak (district_id=13)
(13, 'Medak Town', 'medak-town', 1),(13, 'Ramayampet', 'ramayampet', 2),
-- Yadadri Bhuvanagiri (district_id=14)
(14, 'Bhongir', 'bhongir', 1),(14, 'Aler', 'aler', 2),(14, 'Choutuppal', 'choutuppal', 3),
-- Nagarkurnool (district_id=15)
(15, 'Nagarkurnool Town', 'nagarkurnool-town', 1),(15, 'Kalwakurthy', 'kalwakurthy', 2),(15, 'Achampet', 'achampet', 3),
-- Jogulamba Gadwal (district_id=16)
(16, 'Ieeja', 'ieeja', 1),(16, 'Alampur', 'alampur', 2),
-- Vikarabad (district_id=17)
(17, 'Vikarabad Town', 'vikarabad-town', 1),(17, 'Tandur', 'tandur', 2),(17, 'Pargi', 'pargi', 3),
-- Sangareddy (district_id=18)
(18, 'Sangareddy Town', 'sangareddy-town', 1),(18, 'Patancheru', 'patancheru-sangareddy', 2),(18, 'Zaheerabad', 'zaheerabad', 3),(18, 'Sadasivpet', 'sadasivpet', 4),(18, 'Rudraram', 'rudraram', 5),
-- Ranga Reddy (district_id=19)
(19, 'Shamshabad', 'shamshabad-rr', 1),(19, 'Kandukur', 'kandukur-rr', 2),(19, 'Rajendra Nagar', 'rajendra-nagar-rr', 3),
-- Medchal-Malkajgiri (district_id=20)
(20, 'Kompally', 'kompally-medchal', 1),(20, 'Uppal', 'uppal-medchal', 2),(20, 'Ghatkesar', 'ghatkesar-medchal', 3),(20, 'Boduppal', 'boduppal-medchal', 4),(20, 'Pocharam', 'pocharam-medchal', 5),
-- Visakhapatnam / Vizag (district_id=21) - 40 areas
(21, 'Dwaraka Nagar', 'dwaraka-nagar', 1),(21, 'MVP Colony', 'mvp-colony', 2),(21, 'Gajuwaka', 'gajuwaka', 3),
(21, 'Rushikonda', 'rushikonda', 4),(21, 'Madhurawada', 'madhurawada', 5),(21, 'Bheemunipatnam', 'bheemunipatnam', 6),
(21, 'Kommadi', 'kommadi', 7),(21, 'NAD Junction', 'nad-junction', 8),(21, 'Seethammadhara', 'seethammadhara', 9),
(21, 'Lawsons Bay Colony', 'lawsons-bay-colony', 10),(21, 'Ukkunagaram', 'ukkunagaram', 11),(21, 'Steel Plant', 'steel-plant', 12),
(21, 'Pendurthi', 'pendurthi', 13),(21, 'Kapuluppada', 'kapuluppada', 14),(21, 'Yendada', 'yendada', 15),
(21, 'Anandapuram', 'anandapuram', 16),(21, 'Gopalapatnam', 'gopalapatnam', 17),(21, 'Kancharapalem', 'kancharapalem', 18),
(21, 'Waltair', 'waltair', 19),(21, 'Arilova', 'arilova', 20),(21, 'Pedagantyada', 'pedagantyada', 21),
(21, 'Marripalem', 'marripalem', 22),(21, 'Tadichetlapalem', 'tadichetlapalem', 23),(21, 'Akkayyapalem', 'akkayyapalem', 24),
(21, 'Jagadamba Junction', 'jagadamba-junction', 25),(21, 'Duvvada', 'duvvada', 26),(21, 'Bhavani Nagar', 'bhavani-nagar', 27),
(21, 'Old Town Vizag', 'old-town-vizag', 28),(21, 'Simhachalam', 'simhachalam', 29),(21, 'Tagarapuvalasa', 'tagarapuvalasa', 30),
(21, 'Bheemili', 'bheemili', 31),(21, 'Narava', 'narava', 32),(21, 'Paradesipalem', 'paradesipalem', 33),
(21, 'Chinagadili', 'chinagadili', 34),(21, 'Muralinagar', 'muralinagar', 35),(21, 'Maddilapalem', 'maddilapalem', 36),
(21, 'Resapuvanipalem', 'resapuvanipalem', 37),(21, 'Timmapuram', 'timmapuram', 38),(21, 'Bhavani Hills', 'bhavani-hills', 39),(21, 'Visakhapatnam City', 'visakhapatnam-city', 40),
-- Vijayawada (district_id=22) - 30 areas
(22, 'Vijayawada City', 'vijayawada-city', 1),(22, 'Benz Circle', 'benz-circle', 2),(22, 'MG Road', 'mg-road-vijayawada', 3),
(22, 'Auto Nagar', 'auto-nagar-vijayawada', 4),(22, 'Gunadala', 'gunadala', 5),(22, 'Satyanarayanapuram', 'satyanarayanapuram', 6),
(22, 'Patamata', 'patamata', 7),(22, 'Suryaraopet', 'suryaraopet', 8),(22, 'Machavaram', 'machavaram', 9),
(22, 'Ajit Singh Nagar', 'ajit-singh-nagar', 10),(22, 'Gollapudi', 'gollapudi', 11),(22, 'Nunna', 'nunna', 12),
(22, 'Krishnalanka', 'krishnalanka', 13),(22, 'Payakapuram', 'payakapuram', 14),(22, 'Moghalrajpuram', 'moghalrajpuram', 15),
(22, 'Ramavarappadu', 'ramavarappadu', 16),(22, 'Pedda Avutapalli', 'pedda-avutapalli', 17),(22, 'Ibrahimpatnam Vijayawada', 'ibrahimpatnam-vijayawada', 18),
(22, 'Kondapalli', 'kondapalli', 19),(22, 'Vambay Colony', 'vambay-colony', 20),(22, 'Gannavaram', 'gannavaram', 21),
(22, 'Kankipadu', 'kankipadu', 22),(22, 'Penamaluru', 'penamaluru', 23),(22, 'Mylavaram', 'mylavaram', 24),
(22, 'Vuyyuru', 'vuyyuru', 25),(22, 'Jaggayyapeta', 'jaggayyapeta', 26),(22, 'Nandigama', 'nandigama', 27),
(22, 'Tiruvuru', 'tiruvuru', 28),(22, 'Nuzvid', 'nuzvid', 29),(22, 'Gudivada', 'gudivada', 30),
-- Tirupati (district_id=23) - 10 areas
(23, 'Tirupati City', 'tirupati-city', 1),(23, 'Tiruchanur', 'tiruchanur', 2),(23, 'Renigunta', 'renigunta', 3),
(23, 'Chandragiri', 'chandragiri', 4),(23, 'Srikalahasti', 'srikalahasti', 5),(23, 'Puttur', 'puttur', 6),
(23, 'Pakala', 'pakala', 7),(23, 'Chittoor', 'chittoor', 8),(23, 'Madanapalle', 'madanapalle', 9),(23, 'Pileru', 'pileru', 10),
-- Guntur (district_id=24)
(24, 'Guntur City', 'guntur-city', 1),(24, 'Tenali', 'tenali', 2),(24, 'Mangalagiri', 'mangalagiri', 3),(24, 'Narasaraopet', 'narasaraopet', 4),(24, 'Bapatla', 'bapatla', 5),
-- Rajahmundry (district_id=25)
(25, 'Rajahmundry City', 'rajahmundry-city', 1),(25, 'Kakinada', 'kakinada', 2),(25, 'Peddapuram', 'peddapuram', 3),(25, 'Amalapuram', 'amalapuram', 4);

-- --------------------------------------------------------
-- Service Keywords Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `service_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `short_desc` text,
  `icon` varchar(50) DEFAULT 'fa-shield-alt',
  `image` varchar(255) DEFAULT '',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `service_keywords` (`name`, `slug`, `category`, `short_desc`, `icon`, `sort_order`) VALUES
('Pigeon Netting', 'pigeon-netting', 'Safety & Bird Control', 'Premium Russea™ HDPE pigeon netting solutions for balconies, terraces and open areas. Wholesale supplier across India.', 'fa-dove', 1),
('Bird Netting', 'bird-netting', 'Safety & Bird Control', 'High-quality HDPE bird netting wholesale. UV stabilized, weather resistant bird control nets.', 'fa-crow', 2),
('Anti Bird Nets', 'anti-bird-nets', 'Safety & Bird Control', 'Effective anti-bird nets for apartments, commercial buildings and industrial areas.', 'fa-ban', 3),
('Balcony Safety Nets', 'balcony-safety-nets', 'Safety & Bird Control', 'Child and pet-safe balcony protection nets. Transparent and durable Russea™ nets.', 'fa-shield-alt', 4),
('Children Safety Nets', 'children-safety-nets', 'Safety & Bird Control', 'Specially designed safety nets for toddler and children balcony protection.', 'fa-child', 5),
('Pigeon Spikes', 'pigeon-spikes', 'Safety & Bird Control', 'Stainless steel and polycarbonate pigeon spikes to deter birds from ledges.', 'fa-grip-lines', 6),
('Anti Bird Spikes', 'anti-bird-spikes', 'Safety & Bird Control', 'Professional anti bird spikes for commercial and residential buildings.', 'fa-thumbtack', 7),
('Polycarbonate Spikes', 'polycarbonate-spikes', 'Safety & Bird Control', 'Durable UV-resistant polycarbonate bird spikes for ledge protection.', 'fa-project-diagram', 8),
('SS Bird Spikes', 'ss-bird-spikes', 'Safety & Bird Control', 'Premium stainless steel bird spikes for long-lasting bird control.', 'fa-bars', 9),
('Invisible Grills', 'invisible-grills', 'Home Fittings', 'Modern invisible grills for balconies and windows. Maintain view while ensuring safety.', 'fa-border-all', 10),
('SS Invisible Grills', 'ss-invisible-grills', 'Home Fittings', 'Stainless steel invisible grill systems for high-rise apartments.', 'fa-grip-vertical', 11),
('Cloth Hangers Installation', 'cloth-hangers-installation', 'Home Fittings', 'Ceiling and wall-mounted cloth hanger installation services.', 'fa-tshirt', 12),
('SS Cloth Hangers', 'ss-cloth-hangers', 'Home Fittings', 'Premium stainless steel cloth drying systems for balconies.', 'fa-arrows-alt-h', 13),
('Artificial Grass', 'artificial-grass', 'Sports & Recreation', 'High-quality Russea™ artificial grass for balconies, lawns and gardens.', 'fa-leaf', 14),
('Artificial Turf', 'artificial-turf', 'Sports & Recreation', 'Professional artificial turf for sports grounds and landscaping.', 'fa-football-ball', 15),
('Cricket Ground Pitch Turf', 'cricket-ground-pitch-turf', 'Sports & Recreation', 'Cricket pitch artificial turf for batting nets and grounds.', 'fa-baseball-ball', 16),
('Sports Practice Nets', 'sports-practice-nets', 'Sports & Recreation', 'Multi-sport practice nets for cricket, football and volleyball.', 'fa-table-tennis', 17),
('Box Cricket Nets', 'box-cricket-nets', 'Sports & Recreation', 'Complete box cricket net setup for terraces and grounds.', 'fa-th', 18),
('Box Cricket Setup', 'box-cricket-setup', 'Sports & Recreation', 'End-to-end box cricket ground construction with nets, turf and flooring.', 'fa-building', 19);

-- --------------------------------------------------------
-- Sliders Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `subtitle` varchar(500),
  `button_text` varchar(100) DEFAULT 'Get Free Quote',
  `button_link` varchar(255) DEFAULT 'contact.php',
  `image_path` varchar(255) NOT NULL,
  `service_keyword` varchar(100),
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sliders` (`title`, `subtitle`, `button_text`, `button_link`, `image_path`, `service_keyword`, `sort_order`) VALUES
('Pigeon Netting Solutions', 'India''s #1 Russea™ HDPE Pigeon Net Wholesale Suppliers. Best quality, Lowest Price, Free Delivery across India.', 'Get Free Quote', 'contact.php', 'assets/images/sliders/slider-pigeon-netting.jpg', 'pigeon-netting', 1),
('Balcony Safety Nets', 'Protect your loved ones with Russea™ Premium Balcony Safety Nets. Child & Pet Friendly. UV Stabilized.', 'Get Quote Now', 'contact.php', 'assets/images/sliders/slider-balcony-nets.jpg', 'balcony-safety-nets', 2),
('Invisible Grills', 'Modern Stainless Steel Invisible Grills for Balconies & Windows. Maintain your view, ensure safety.', 'View Pricing', 'estimation.php', 'assets/images/sliders/slider-invisible-grills.jpg', 'invisible-grills', 3),
('Artificial Grass & Turf', 'Premium Artificial Grass & Turf for Homes, Terraces & Sports Grounds. Low maintenance, long lasting.', 'Calculate Cost', 'estimation.php', 'assets/images/sliders/slider-artificial-grass.jpg', 'artificial-grass', 4),
('Box Cricket Setup', 'Complete Box Cricket Ground Construction. Nets + Turf + Flooring + Fabrication. Pan-India Service.', 'Get Estimate', 'estimation.php', 'assets/images/sliders/slider-box-cricket.jpg', 'box-cricket-setup', 5),
('SS Cloth Hangers', 'Premium Stainless Steel Cloth Drying Systems for Balconies. Space-saving, weather-proof, durable.', 'Order Now', 'contact.php', 'assets/images/sliders/slider-cloth-hangers.jpg', 'ss-cloth-hangers', 6);

-- --------------------------------------------------------
-- Reviews Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(150) NOT NULL,
  `customer_email` varchar(150),
  `customer_phone` varchar(20),
  `customer_location` varchar(200),
  `service_used` varchar(200),
  `rating` tinyint(1) NOT NULL DEFAULT 5,
  `review_text` text NOT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `admin_reply` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 150 sample reviews
INSERT INTO `reviews` (`customer_name`, `customer_email`, `customer_location`, `service_used`, `rating`, `review_text`, `is_approved`, `is_featured`) VALUES
('Rajesh Kumar', 'rajesh@email.com', 'Kukatpally, Hyderabad', 'Pigeon Netting', 5, 'Excellent service! Got Russea™ pigeon nets for my 3rd floor balcony. The quality is outstanding and installation was done professionally within hours. Highly recommended for anyone in Hyderabad!', 1, 1),
('Priya Sharma', 'priya@email.com', 'Gachibowli, Hyderabad', 'Balcony Safety Nets', 5, 'Ordered safety nets for my kids'' balcony. The Russea™ nets are very strong and transparent. Great company and excellent after-sales support. Will definitely order again.', 1, 1),
('Venkat Reddy', 'venkat@email.com', 'HITEC City, Hyderabad', 'Invisible Grills', 5, 'Installed SS invisible grills in my apartment. The view from my balcony is still perfect and my family is safe. Quality is top-notch. NetsDial team is very professional.', 1, 1),
('Sushma Patel', 'sushma@email.com', 'Banjara Hills, Hyderabad', 'Artificial Grass', 5, 'Got artificial grass for my rooftop garden. Looks absolutely beautiful! The quality matches international standards. Very happy with NetsDial services.', 1, 1),
('Mohammed Aziz', 'aziz@email.com', 'Secunderabad, Hyderabad', 'Box Cricket Setup', 5, 'Set up a complete box cricket ground for our society. The whole setup - nets, turf, flooring is world class. Kids are loving it. Great investment!', 1, 1),
('Lakshmi Devi', 'lakshmi@email.com', 'Jubilee Hills, Hyderabad', 'SS Cloth Hangers', 5, 'Installed ceiling cloth hangers in my balcony. Space-saving design and very strong. The stainless steel quality is excellent. No rusting even in rains.', 1, 0),
('Arun Teja', 'arun@email.com', 'Kondapur, Hyderabad', 'Bird Netting', 5, 'Best bird netting I have used. The HDPE Russea™ nets are UV resistant and very durable. Pigeons completely gone from my terrace. Excellent product!', 1, 1),
('Deepika Singh', 'deepika@email.com', 'Madhapur, Hyderabad', 'Children Safety Nets', 5, 'Safety of my toddler was my priority. These nets are absolutely strong and transparent. Very professional installation team. 100% satisfied!', 1, 0),
('Ramesh Naidu', 'ramesh@email.com', 'LB Nagar, Hyderabad', 'Anti Bird Nets', 5, 'Ordered anti-bird nets for our commercial building. The quality and price from NetsDial is unbeatable. Fast delivery and professional service.', 1, 0),
('Sunita Rao', 'sunita@email.com', 'Dilsukhnagar, Hyderabad', 'Pigeon Spikes', 5, 'Pigeon spikes are working perfectly. No more pigeons on my AC unit and window ledges. Great quality product at affordable price.', 1, 0),
('Kiran Kumar', 'kiran@email.com', 'Ameerpet, Hyderabad', 'SS Bird Spikes', 5, 'SS bird spikes from NetsDial are heavy duty. Installed them on terrace parapet walls. Perfect solution for bird menace. Highly recommend!', 1, 0),
('Ananya Reddy', 'ananya@email.com', 'Uppal, Hyderabad', 'Polycarbonate Spikes', 5, 'Transparent polycarbonate spikes are working great. They are barely visible and very effective. Good quality at reasonable price.', 1, 0),
('Suresh Babu', 'suresh@email.com', 'Miyapur, Hyderabad', 'Balcony Safety Nets', 5, 'Installed balcony nets for my 10th floor apartment. Very strong and transparent. Kids can safely play on balcony now. Excellent product!', 1, 1),
('Kavitha Nair', 'kavitha@email.com', 'Kompally, Hyderabad', 'Invisible Grills', 5, 'SS invisible grills are perfectly installed. The view is unobstructed and safety is ensured. Professional team, timely service. 5 stars!', 1, 0),
('Ravi Shankar', 'ravi@email.com', 'Bachupally, Hyderabad', 'Cricket Ground Pitch Turf', 5, 'Excellent cricket pitch turf quality. Our apartment society cricket ground looks professional now. Great service from NetsDial team.', 1, 0),
('Meera Krishnan', 'meera@email.com', 'Hafeezpet, Hyderabad', 'Artificial Turf', 5, 'Got artificial turf for my terrace garden. Looks fantastic and very low maintenance. High quality product, great after-sales support.', 1, 0),
('Prasad Venkatesh', 'prasad@email.com', 'Chandanagar, Hyderabad', 'Sports Practice Nets', 5, 'Cricket practice nets are excellent quality. Ordered for our school ground. The HDPE nets are very durable. Highly recommended!', 1, 0),
('Divya Reddy', 'divya@email.com', 'Nizampet', 'Pigeon Netting', 5, 'Great quality pigeon nets. Very transparent and durable. My balcony is now pigeon-free. Professional installation. Excellent service!', 1, 0),
('Sai Krishna', 'sai@email.com', 'Nacharam, Hyderabad', 'Anti Bird Spikes', 5, 'Anti bird spikes are very effective. No more bird droppings on my car. Easy installation and great quality. Recommend NetsDial!', 1, 0),
('Pooja Agarwal', 'pooja@email.com', 'Habsiguda, Hyderabad', 'SS Cloth Hangers', 5, 'Wall mounted SS cloth hangers are perfect for my small balcony. Space-saving and very sturdy. Great value for money!', 1, 0),
('Vijay Bhaskar', 'vijay@email.com', 'Medipally, Hyderabad', 'Balcony Safety Nets', 5, 'Installed safety nets for twin toddlers. Very satisfied with quality and installation. The nets are strong and barely visible. Great service!', 1, 1),
('Usha Rani', 'usha@email.com', 'Warangal City, Warangal', 'Pigeon Netting', 5, 'Ordered Russea™ pigeon nets. Delivery was fast to Warangal. Very good quality at wholesale price. Highly satisfied!', 1, 0),
('Gopal Rao', 'gopal@email.com', 'Karimnagar City, Karimnagar', 'Bird Netting', 5, 'Good quality bird nets delivered to Karimnagar. UV resistant and durable. Will order again for next project.', 1, 0),
('Padma Laxmi', 'padma@email.com', 'Nizamabad City, Nizamabad', 'Balcony Safety Nets', 5, 'Excellent safety nets. Quick delivery to Nizamabad. Very strong and transparent. My family is safe now. Thank you NetsDial!', 1, 0),
('Naresh Babu', 'naresh@email.com', 'Khammam City, Khammam', 'Anti Bird Nets', 5, 'Got anti-bird nets delivered to Khammam. Great quality Russea™ nets at wholesale prices. Very happy with the purchase.', 1, 0),
('Rekha Devi', 'rekha@email.com', 'HITEC City, Hyderabad', 'Invisible Grills', 5, 'Beautiful SS invisible grills! My penthouse balcony view is stunning while being perfectly safe. Professional team, perfect installation.', 1, 1),
('Arvind Sharma', 'arvind@email.com', 'Financial District, Hyderabad', 'Box Cricket Setup', 5, 'Complete box cricket setup for our gated community. World-class quality nets, astro turf and flooring. Kids love it! Great investment!', 1, 1),
('Lalitha Kumari', 'lalitha@email.com', 'Secunderabad, Hyderabad', 'Cloth Hangers Installation', 5, 'Retractable cloth hangers installed in my balcony. Very space-efficient and strong. Stainless steel quality is excellent. Recommended!', 1, 0),
('Venu Gopal', 'venu@email.com', 'Tarnaka, Hyderabad', 'Pigeon Spikes', 5, 'Pigeon spikes installed on all ledges. Zero pigeons after installation. Very effective and durable. Great quality from NetsDial.', 1, 0),
('Saritha Reddy', 'saritha@email.com', 'Alwal, Hyderabad', 'Sports Practice Nets', 4, 'Cricket practice nets are very good quality. Strong HDPE material. Delivery was on time. Slightly heavy but very durable.', 1, 0),
('Mahesh Kumar', 'mahesh@email.com', 'Sainikpuri, Hyderabad', 'Artificial Grass', 5, 'Installed artificial grass in my garden area. Looks absolutely natural and beautiful. Very low maintenance. Great product!', 1, 0),
('Anitha Rao', 'anitha@email.com', 'ECIL, Hyderabad', 'Balcony Safety Nets', 5, 'Excellent safety nets for my 7th floor balcony. Strong, durable and transparent. My pets are safe. Professional installation. 5 stars!', 1, 0),
('Sridhar Naidu', 'sridhar@email.com', 'Yapral, Hyderabad', 'SS Invisible Grills', 5, 'High quality SS invisible grills. View from balcony is perfect. Safety for children ensured. Excellent workmanship and service.', 1, 0),
('Chandrika Devi', 'chandrika@email.com', 'Moula Ali, Hyderabad', 'Anti Bird Nets', 5, 'Anti bird nets are working perfectly. No pigeons in my terrace since installation. Durable UV-resistant material. Great purchase!', 1, 0),
('Hari Babu', 'hari@email.com', 'AS Rao Nagar, Hyderabad', 'Pigeon Netting', 5, 'Russea™ pigeon nets - excellent quality. Very transparent and strong. Professional installation done in 2 hours. Highly satisfied!', 1, 0),
('Nirmala Singh', 'nirmala@email.com', 'Charminar, Hyderabad', 'Bird Netting', 5, 'Best quality bird netting at wholesale price. Delivery was prompt. UV resistant and weatherproof. Will order again for terrace.', 1, 0),
('Prakash Rao', 'prakash@email.com', 'Attapur, Hyderabad', 'SS Cloth Hangers', 5, 'SS cloth hangers are very sturdy and rust-free. Retractable design saves space. Easy to use. Excellent value for money.', 1, 0),
('Kamala Devi', 'kamala@email.com', 'Malakpet, Hyderabad', 'Children Safety Nets', 5, 'Got safety nets for twins'' balcony. Very strong and transparent. Kids are safe now. Professional installation team. 5 stars!', 1, 0),
('Santosh Kumar', 'santosh@email.com', 'Abids, Hyderabad', 'Cricket Ground Pitch Turf', 5, 'Cricket turf is very good quality. Our rooftop cricket ground looks professional now. Great product and service from NetsDial.', 1, 0),
('Vani Reddy', 'vani@email.com', 'Koti, Hyderabad', 'Invisible Grills', 5, 'Invisible grills are perfectly installed. The aesthetic look of my balcony is maintained with safety. Highly recommend NetsDial!', 1, 0),
('Ramana Murthy', 'ramana@email.com', 'Himayat Nagar, Hyderabad', 'Pigeon Spikes', 5, 'Pigeon spikes are very effective. No more mess from pigeons. Good quality product at affordable price. Fast delivery.', 1, 0),
('Swapna Laxmi', 'swapna@email.com', 'Basheerbagh, Hyderabad', 'Balcony Safety Nets', 5, 'Premium quality balcony nets. Transparent and very strong. Perfect for apartment balcony. Professional team, clean installation.', 1, 0),
('Chandra Sekhar', 'chandra@email.com', 'Somajiguda, Hyderabad', 'Artificial Turf', 5, 'Artificial turf for my 2BHK terrace garden. Looks fantastic and natural. Easy maintenance and very durable. Great service!', 1, 0),
('Jaya Lakshmi', 'jaya@email.com', 'Punjagutta, Hyderabad', 'Box Cricket Nets', 5, 'Box cricket nets installed on terrace. Excellent HDPE quality. Kids are enjoying cricket now. Best investment for society amenities!', 1, 0),
('Aditya Varma', 'aditya@email.com', 'Lakdikapul, Hyderabad', 'Anti Bird Spikes', 5, 'SS bird spikes from NetsDial are top quality. No more bird problems. Very happy with the product and customer service.', 1, 0),
('Ratna Kumari', 'ratna@email.com', 'Khairatabad, Hyderabad', 'SS Invisible Grills', 5, 'SS invisible grills for my 15th floor apartment. Safety without compromising view. Excellent quality and professional installation.', 1, 1),
('Balasubramanian', 'bala@email.com', 'Paradise, Hyderabad', 'Pigeon Netting', 4, 'Good quality pigeon nets. Delivery was on time. Installation team was professional. Slightly expensive but worth the quality.', 1, 0),
('Padmavathi Devi', 'padma2@email.com', 'Borabanda, Hyderabad', 'Bird Netting', 5, 'HDPE bird nets are excellent. UV stabilized and very durable. My terrace is pigeon-free for 6 months now. Great product!', 1, 0),
('Ranjit Kumar', 'ranjit@email.com', 'Miyapur, Hyderabad', 'Sports Practice Nets', 5, 'Sports practice nets for football and cricket. Excellent HDPE quality. Very durable and strong. Great value for sports facility.', 1, 0),
('Sujatha Reddy', 'sujatha@email.com', 'Nizampet, Hyderabad', 'Cloth Hangers Installation', 5, 'Ceiling cloth hangers are fantastic. Space-saving and very strong. SS quality means no rust. Professional installation. 5 stars!', 1, 0),
('Hemanth Naidu', 'hemanth@email.com', 'Kukatpally, Hyderabad', 'Balcony Safety Nets', 5, 'Installed safety nets for 4 balconies in my villa. Excellent quality and reasonable price for bulk order. Highly recommend!', 1, 1),
('Madhuri Devi', 'madhuri@email.com', 'Hafeezpet, Hyderabad', 'Pigeon Netting', 5, 'Premium Russea™ pigeon nets. Installation was quick and professional. No more pigeon problems on my balcony. Excellent!', 1, 0),
('Subramaniam Pillai', 'subbu@email.com', 'Gachibowli, Hyderabad', 'Invisible Grills', 5, 'Beautiful invisible grills for twin balconies. View is perfect and safety ensured. SS quality is top-notch. Very satisfied!', 1, 0),
('Yamini Rao', 'yamini@email.com', 'Financial District, Hyderabad', 'Artificial Grass', 5, 'Artificial grass for office terrace garden. Looks stunning! Very good quality and minimal maintenance. Great product from NetsDial.', 1, 0),
('Kalyan Reddy', 'kalyan@email.com', 'Kondapur, Hyderabad', 'Box Cricket Setup', 5, 'Box cricket ground for our society terrace. Professional installation, excellent quality. Best amenity we added this year!', 1, 1),
('Sudha Rani', 'sudha@email.com', 'Madhapur, Hyderabad', 'SS Cloth Hangers', 5, 'Retractable SS cloth hangers are perfect. No more cluttered balcony. Very strong and rust-free. Great product!', 1, 0),
('Venkatesh Reddy', 'venky@email.com', 'Manikonda, Hyderabad', 'Children Safety Nets', 5, 'Child safety nets are excellent. Strong, transparent and durable. My 3-year-old is safe on balcony now. Professional service!', 1, 0),
('Bhavana Sharma', 'bhavana@email.com', 'Kokapet, Hyderabad', 'Balcony Safety Nets', 5, 'Luxury apartment balcony nets installed. Very high quality Russea™ nets. Transparent and strong. Professional installation team.', 1, 0),
('Kishore Kumar', 'kishore@email.com', 'Shaikpet, Hyderabad', 'Anti Bird Nets', 5, 'Anti-bird nets for our building terrace. Excellent quality and fast delivery. Effective solution for bird problem. Recommend!', 1, 0),
('Ramadevi Patel', 'rama@email.com', 'Nanakramguda, Hyderabad', 'SS Bird Spikes', 5, 'Heavy duty SS bird spikes. Installed on all parapet walls. Zero bird problems now. Great quality at competitive price.', 1, 0),
('Sunil Varma', 'sunil@email.com', 'Narsingi, Hyderabad', 'Polycarbonate Spikes', 4, 'Polycarbonate spikes are good quality. Transparent and effective. Delivery was fast. Slightly tricky to install yourself but effective.', 1, 0),
('Geetha Lakshmi', 'geetha@email.com', 'Tolichowki, Hyderabad', 'Pigeon Netting', 5, 'Excellent pigeon nets for my apartment balcony. Russea™ quality is outstanding. Professional installation done perfectly.', 1, 0),
('Rajendra Prasad', 'rajendra@email.com', 'Film Nagar, Hyderabad', 'Cricket Ground Pitch Turf', 5, 'Cricket pitch turf for private ground. Excellent quality, durable and looks professional. Great service from NetsDial team!', 1, 0),
('Vanitha Kumari', 'vanitha@email.com', 'Serilingampally, Hyderabad', 'Invisible Grills', 5, 'SS invisible grills are beautifully installed. Perfect safety without ruining the aesthetics. Very professional team. 5 stars!', 1, 0),
('Nagendra Rao', 'nagendra@email.com', 'Begumpet, Hyderabad', 'Bird Netting', 5, 'HDPE bird netting for commercial building. Excellent quality at wholesale price. Covers large area with minimal material. Great!', 1, 0),
('Archana Reddy', 'archana@email.com', 'Abids, Hyderabad', 'Artificial Grass', 5, 'Artificial grass for kids play area. Soft, durable and looks natural. Kids love playing on it. Very happy with quality!', 1, 0),
('Srikanth Naidu', 'srikanth@email.com', 'Himayat Nagar, Hyderabad', 'Balcony Safety Nets', 5, 'Installed safety nets for my 3 balconies. Excellent Russea™ quality. Transparent and very strong. Professional installation team.', 1, 0),
('Pushpa Laxmi', 'pushpa@email.com', 'Koti, Hyderabad', 'SS Cloth Hangers', 5, 'Wall mounted SS cloth hangers are perfect. Very sturdy and space-saving. Professional installation. Great value for money!', 1, 0),
('Dharma Rao', 'dharma@email.com', 'Somajiguda, Hyderabad', 'Box Cricket Nets', 5, 'Box cricket nets are excellent quality. HDPE material, very durable. Our society terrace cricket is very popular now!', 1, 0),
('Uma Shankar', 'uma@email.com', 'Punjagutta, Hyderabad', 'Pigeon Spikes', 5, 'Pigeon spikes are very effective. Easy installation and durable. No more pigeon mess on terrace. Highly recommend NetsDial!', 1, 0),
('Kaveri Devi', 'kaveri@email.com', 'Basheerbagh, Hyderabad', 'Children Safety Nets', 5, 'Child safety nets installed for twins'' balcony. Very strong and invisible. Great quality and professional service. 5 stars!', 1, 0),
('Balakrishna Rao', 'bala2@email.com', 'Lakdikapul, Hyderabad', 'Sports Practice Nets', 5, 'Football and cricket practice nets for school. Excellent HDPE quality. Very durable even in extreme weather. Great purchase!', 1, 0),
('Naga Lakshmi', 'naga@email.com', 'Attapur, Hyderabad', 'Pigeon Netting', 5, 'Best pigeon netting service! Fast installation, excellent quality nets. My terrace is pigeon-free for 8 months. Highly satisfied!', 1, 0),
('Surendra Kumar', 'surendra@email.com', 'Mehdipatnam, Hyderabad', 'Anti Bird Nets', 5, 'Anti-bird nets for large commercial building. Excellent quality at competitive price. Fast delivery and professional installation.', 1, 0),
('Bhagya Laxmi', 'bhagya@email.com', 'Malakpet, Hyderabad', 'SS Invisible Grills', 5, 'Beautiful SS invisible grills for apartment. Safety + aesthetics perfectly balanced. Very professional team. Recommend NetsDial!', 1, 0),
('Prasanna Kumar', 'prasanna@email.com', 'Uppal, Hyderabad', 'Artificial Turf', 5, 'Artificial turf for landscaping project. Excellent quality, very natural look. Low maintenance and long lasting. Great value!', 1, 0),
('Triveni Devi', 'triveni@email.com', 'Ramanthapur, Hyderabad', 'Balcony Safety Nets', 5, 'Safety nets for my 5th floor balcony. Strong, transparent and durable. Kids and pets are safe. Professional installation!', 1, 0),
('Harikrishna Reddy', 'harikrishna@email.com', 'Boduppal, Hyderabad', 'Bird Netting', 5, 'HDPE bird netting is excellent quality. UV stabilized and weatherproof. My factory terrace is bird-free now. Great product!', 1, 0),
('Sharada Devi', 'sharada@email.com', 'Ghatkesar, Hyderabad', 'Cloth Hangers Installation', 5, 'Ceiling cloth hangers installed in 2 balconies. Very sturdy SS quality. Space-saving design. Professional installation. 5 stars!', 1, 0),
('Rajgopal Rao', 'rajgopal@email.com', 'Peerzadiguda, Hyderabad', 'Pigeon Netting', 5, 'Ordered 500 sq ft of pigeon netting. Excellent Russea™ quality at wholesale price. Fast delivery. Very satisfied customer!', 1, 0),
('Visalakshi Reddy', 'visala@email.com', 'Meerpet, Hyderabad', 'Invisible Grills', 5, 'Invisible grills for my new flat. Excellent workmanship and high-quality SS material. View is perfect. Safety is ensured. Great!', 1, 0),
('Nagarjuna Reddy', 'nagarjuna@email.com', 'Charminar, Hyderabad', 'SS Cloth Hangers', 4, 'Good quality SS cloth hangers. Delivery was on time. Installation was straightforward. Works perfectly. Good value for money.', 1, 0),
('Parvathi Devi', 'parvathi@email.com', 'Falaknuma, Hyderabad', 'Balcony Safety Nets', 5, 'Excellent safety nets for balcony. Very strong and transparent. Professional installation done perfectly. Highly recommend!', 1, 0),
('Seetharam Reddy', 'seetharam@email.com', 'Tank Bund, Hyderabad', 'Cricket Ground Pitch Turf', 5, 'Cricket pitch turf is world-class quality. Astro turf for batting nets. Very satisfied with quality and service. Great!', 1, 0),
('Komala Devi', 'komala@email.com', 'Amberpet, Hyderabad', 'Box Cricket Setup', 5, 'Complete box cricket setup for our apartment terrace. Excellent quality nets, turf and flooring. Great investment for community!', 1, 0),
('Suresh Chandra', 'sureshc@email.com', 'Bandlaguda, Hyderabad', 'Pigeon Spikes', 5, 'Polycarbonate and SS pigeon spikes installed all over. 100% effective. Great quality at affordable price. Recommend NetsDial!', 1, 0),
('Sree Devi', 'sree@email.com', 'Moosapet, Hyderabad', 'Children Safety Nets', 5, 'Safety nets for children are excellent quality. Strong and transparent. My twins are safe on balcony. Professional service!', 1, 0),
('Venkata Rao', 'venkatar@email.com', 'Rajendra Nagar, Hyderabad', 'Artificial Grass', 5, 'Artificial grass for terrace garden. Looks stunning and very natural. Low maintenance. Great quality from NetsDial. Recommend!', 1, 0),
('Aruna Devi', 'aruna@email.com', 'Shamshabad, Hyderabad', 'Bird Netting', 5, 'Bird netting for large warehouse. Excellent HDPE quality at wholesale price. Very effective bird control solution. Great!', 1, 0),
('Narasimha Rao', 'narasimha@email.com', 'Kandukur, Hyderabad', 'Anti Bird Spikes', 5, 'Anti bird spikes are very effective. Heavy duty SS quality. Installed on large commercial building. Zero birds now. Great!', 1, 0),
('Bhanupriya Devi', 'bhanu@email.com', 'Medchal, Hyderabad', 'Balcony Safety Nets', 5, 'Premium safety nets for villa balconies. Russea™ quality is exceptional. Professional installation team. Very satisfied!', 1, 0),
('Satyanarayana', 'satya@email.com', 'Pocharam, Hyderabad', 'SS Invisible Grills', 5, 'SS invisible grills are beautifully done. Safety + beautiful view perfectly combined. Excellent workmanship. Highly recommend!', 1, 0),
('Raghavendra Rao', 'raghav@email.com', 'Maheshwaram, Hyderabad', 'Sports Practice Nets', 5, 'Cricket and volleyball practice nets. Excellent quality at great price. Our sports facility is now complete. Thank you NetsDial!', 1, 0),
('Lata Devi', 'lata@email.com', 'Ibrahimpatnam, Hyderabad', 'Pigeon Netting', 5, 'Great quality pigeon netting at wholesale price. Delivery was fast. Installation team was professional. Very satisfied!', 1, 0),
('Rami Reddy', 'rami@email.com', 'Dwaraka Nagar, Visakhapatnam', 'Pigeon Netting', 5, 'Ordered Russea™ pigeon nets for Vizag apartment. Fast delivery, excellent quality. Very satisfied. Will recommend NetsDial!', 1, 0),
('Saradha Rao', 'saradha@email.com', 'MVP Colony, Visakhapatnam', 'Balcony Safety Nets', 5, 'Excellent safety nets delivered to Vizag. Good quality at wholesale price. Professional and responsive customer service.', 1, 0),
('Murali Krishna', 'murali@email.com', 'Gajuwaka, Visakhapatnam', 'Invisible Grills', 5, 'SS invisible grills for Vizag apartment. Excellent quality. Delivery and installation guidance was perfect. Highly satisfied!', 1, 0),
('Vijaya Lakshmi', 'vijaya@email.com', 'Vijayawada City, Vijayawada', 'Pigeon Netting', 5, 'Great pigeon nets delivered to Vijayawada. Russea™ quality is top-notch. Quick delivery and professional follow-up. 5 stars!', 1, 0),
('Nageswara Rao', 'nagesh@email.com', 'Benz Circle, Vijayawada', 'Anti Bird Nets', 5, 'Anti bird nets delivered to Vijayawada. Good HDPE quality at wholesale price. Very satisfied with NetsDial service.', 1, 0),
('Sathyavathi Devi', 'sathya@email.com', 'Tirupati City, Tirupati', 'Pigeon Netting', 5, 'Pigeon nets for temple town apartment. Excellent quality and fast delivery to Tirupati. Very professional service!', 1, 0),
('Ramprasad Rao', 'ramprasad@email.com', 'Karimnagar City, Karimnagar', 'Balcony Safety Nets', 5, 'Safety nets delivered to Karimnagar. Good quality Russea™ nets at wholesale price. Will order again. Excellent service!', 1, 0),
('Nagamani Devi', 'nagamani@email.com', 'Warangal City, Warangal', 'SS Invisible Grills', 5, 'SS invisible grills ordered for Warangal apartment. Excellent quality. Installation guidance was perfect. Very satisfied!', 1, 0),
('Rama Krishnamurthy', 'rama2@email.com', 'Hanamkonda, Warangal', 'Artificial Grass', 5, 'Artificial grass for Warangal garden. Looks fantastic. Good quality and fast delivery. Very happy with NetsDial service!', 1, 0),
('Subbulakshmi', 'subbu2@email.com', 'Nalgonda City, Nalgonda', 'Bird Netting', 5, 'Good quality bird nets delivered to Nalgonda. Affordable wholesale price. UV resistant and durable. Recommend NetsDial!', 1, 0),
('Tirumala Rao', 'tirumala@email.com', 'Nizamabad City, Nizamabad', 'Cricket Ground Pitch Turf', 5, 'Cricket pitch turf delivered to Nizamabad. Excellent quality at competitive price. Our school ground looks professional now!', 1, 0),
('Hemavathi Devi', 'hema@email.com', 'Kothagudem, Khammam', 'Pigeon Netting', 5, 'Pigeon netting delivered to Kothagudem. Good quality Russea™ nets. Fast delivery and responsive customer support. Thanks!', 1, 0),
('Ramachandra Rao', 'ramachandra@email.com', 'Siddipet City, Siddipet', 'Balcony Safety Nets', 5, 'Safety nets for Siddipet apartment. Excellent quality and quick delivery. Professional customer support. Highly satisfied!', 1, 0),
('Anuradha Devi', 'anuradha@email.com', 'Mancherial, Adilabad', 'Anti Bird Nets', 5, 'Anti bird nets delivered to Mancherial. Good HDPE quality at wholesale price. Very satisfied. Will order again for office!', 1, 0),
('Janardhan Reddy', 'janardhan@email.com', 'Mahabubnagar City, Mahabubnagar', 'Pigeon Netting', 5, 'Excellent pigeon nets delivered to Mahabubnagar. Russea™ quality is outstanding. Fast delivery and great customer service!', 1, 0),
('Sudhakar Naidu', 'sudhakar@email.com', 'Bhongir, Yadadri', 'Balcony Safety Nets', 5, 'Safety nets for apartment in Bhongir. Good quality at wholesale price. Fast delivery. Professional customer support. Recommend!', 1, 0),
('Tulasi Devi', 'tulasi@email.com', 'Vemulawada, Rajanna Sircilla', 'Bird Netting', 5, 'Bird netting for commercial premises in Vemulawada. Excellent HDPE quality. Timely delivery. Very satisfied with service!', 1, 0),
('Mallesh Rao', 'mallesh@email.com', 'Sangareddy Town, Sangareddy', 'Pigeon Netting', 5, 'Pigeon nets for Sangareddy property. Good Russea™ quality at competitive price. Fast delivery and follow-up support. Great!', 1, 0),
('Savitri Devi', 'savitri@email.com', 'Rushikonda, Visakhapatnam', 'Invisible Grills', 5, 'Invisible grills for beach-facing apartment in Vizag. Corrosion-resistant SS quality. Excellent product for coastal areas!', 1, 0),
('Parasuram Reddy', 'parasuram@email.com', 'Madhurawada, Visakhapatnam', 'Balcony Safety Nets', 5, 'Safety nets for high-rise in Madhurawada. Excellent quality and fast delivery to Vizag. Professional customer support!', 1, 0),
('Srinivasa Rao', 'srinivasa@email.com', 'Guntur City, Guntur', 'Pigeon Netting', 5, 'Pigeon netting delivered to Guntur. Good quality Russea™ nets at wholesale price. Very satisfied. Recommend NetsDial!', 1, 0),
('Saraswathi Devi', 'saraswathi@email.com', 'Rajahmundry City, Rajahmundry', 'Bird Netting', 5, 'Bird netting for Rajahmundry commercial building. Excellent HDPE quality. Fast delivery and responsive support. Great!', 1, 0);

-- --------------------------------------------------------
-- Blogs Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text,
  `image_path` varchar(255),
  `author` varchar(100) DEFAULT 'NetsDial Team',
  `category` varchar(100),
  `tags` text,
  `meta_title` varchar(300),
  `meta_description` text,
  `meta_keywords` text,
  `views` int(11) DEFAULT 0,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Gallery Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(100),
  `description` text,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Videos Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `youtube_id` varchar(50),
  `thumbnail` varchar(255),
  `category` varchar(100),
  `description` text,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Contacts Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150),
  `phone` varchar(20) NOT NULL,
  `service` varchar(200),
  `location` varchar(200),
  `message` text,
  `source_page` varchar(255),
  `ip_address` varchar(50),
  `is_read` tinyint(1) DEFAULT 0,
  `status` enum('new','contacted','converted','closed') DEFAULT 'new',
  `admin_notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Offers / Coupons Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `discount_type` enum('percentage','fixed','free_service') DEFAULT 'percentage',
  `discount_value` decimal(10,2) DEFAULT 0,
  `coupon_code` varchar(50),
  `valid_from` date,
  `valid_to` date,
  `terms` text,
  `image_path` varchar(255),
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `offers` (`title`, `description`, `discount_type`, `discount_value`, `coupon_code`, `valid_from`, `valid_to`, `terms`, `is_active`) VALUES
('Summer Special - 15% Off', 'Get 15% off on all pigeon netting and safety net orders above Rs. 5000. Limited time offer!', 'percentage', 15, 'SUMMER15', '2026-07-01', '2026-09-30', 'Valid on orders above Rs. 5000. Cannot be combined with other offers.', 1),
('Free Installation Offer', 'Free professional installation on purchase of 300+ sq ft safety nets. Save up to Rs. 3000!', 'free_service', 0, 'FREEFIT300', '2026-07-01', '2026-08-31', 'Valid on orders of 300 sq ft or above. Hyderabad deliveries only.', 1),
('Box Cricket Special Package', 'Complete box cricket setup at special rate of Rs. 220/sq ft. Includes nets, turf and structure.', 'fixed', 220, 'CRICKET220', '2026-07-01', '2026-12-31', 'Valid for new box cricket setup projects. Subject to site inspection.', 1),
('Bulk Order 20% Off', 'Get 20% off on orders above Rs. 25,000. Perfect for builders and contractors.', 'percentage', 20, 'BULK20', '2026-07-01', '2026-12-31', 'Valid on single orders above Rs. 25,000. For wholesale buyers only.', 1);

-- --------------------------------------------------------
-- Estimation Rates Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `estimation_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `sub_category` varchar(100),
  `thickness` varchar(20),
  `gap_size` varchar(20),
  `length_size` varchar(20),
  `sft_min` int(11),
  `sft_max` int(11),
  `rate_min` decimal(10,2) NOT NULL,
  `rate_max` decimal(10,2) NOT NULL,
  `unit` varchar(20) DEFAULT 'sqft',
  `notes` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Safety Net Rates
INSERT INTO `estimation_rates` (`category`, `sub_category`, `thickness`, `gap_size`, `sft_min`, `sft_max`, `rate_min`, `rate_max`, `unit`) VALUES
('safety_net', 'below_100', '1.5mm', '30mm', 0, 100, 1500, 1500, 'fixed'),
('safety_net', 'below_100', '2mm', '30mm', 0, 100, 1650, 1650, 'fixed'),
('safety_net', 'below_100', '2.5mm', '30mm', 0, 100, 1800, 1800, 'fixed'),
('safety_net', '100_250', '1.5mm', '30mm', 100, 250, 16, 20, 'sqft'),
('safety_net', '100_250', '2mm', '40mm', 100, 250, 24, 28, 'sqft'),
('safety_net', '100_250', '2mm', '45mm', 100, 250, 22, 26, 'sqft'),
('safety_net', '100_250', '2mm', '50mm', 100, 250, 20, 24, 'sqft'),
('safety_net', '100_250', '2.5mm', '40mm', 100, 250, 26, 30, 'sqft'),
('safety_net', '100_250', '2.5mm', '45mm', 100, 250, 24, 28, 'sqft'),
('safety_net', '100_250', '2.5mm', '50mm', 100, 250, 22, 24, 'sqft'),
('safety_net', '250_500', '1.5mm', '30mm', 250, 500, 14, 18, 'sqft'),
('safety_net', '250_500', '2mm', '40mm', 250, 500, 20, 24, 'sqft'),
('safety_net', '250_500', '2mm', '45mm', 250, 500, 18, 22, 'sqft'),
('safety_net', '250_500', '2mm', '50mm', 250, 500, 16, 20, 'sqft'),
('safety_net', '250_500', '2.5mm', '40mm', 250, 500, 22, 26, 'sqft'),
('safety_net', '250_500', '2.5mm', '45mm', 250, 500, 20, 24, 'sqft'),
('safety_net', '250_500', '2.5mm', '50mm', 250, 500, 18, 22, 'sqft'),
('safety_net', '500_1000', '1.5mm', '30mm', 500, 1000, 12, 16, 'sqft'),
('safety_net', '500_1000', '2mm', '40mm', 500, 1000, 18, 22, 'sqft'),
('safety_net', '500_1000', '2mm', '45mm', 500, 1000, 16, 20, 'sqft'),
('safety_net', '500_1000', '2mm', '50mm', 500, 1000, 14, 18, 'sqft'),
('safety_net', '500_1000', '2.5mm', '40mm', 500, 1000, 20, 24, 'sqft'),
('safety_net', '500_1000', '2.5mm', '45mm', 500, 1000, 18, 22, 'sqft'),
('safety_net', '500_1000', '2.5mm', '50mm', 500, 1000, 16, 20, 'sqft'),
('safety_net', '1000_5000', '1.5mm', '30mm', 1000, 5000, 10, 14, 'sqft'),
('safety_net', '1000_5000', '2mm', '40mm', 1000, 5000, 14, 18, 'sqft'),
('safety_net', '1000_5000', '2mm', '45mm', 1000, 5000, 12, 16, 'sqft'),
('safety_net', '1000_5000', '2mm', '50mm', 1000, 5000, 10, 14, 'sqft'),
('safety_net', '1000_5000', '2.5mm', '40mm', 1000, 5000, 16, 20, 'sqft'),
('safety_net', '1000_5000', '2.5mm', '45mm', 1000, 5000, 14, 18, 'sqft'),
('safety_net', '1000_5000', '2.5mm', '50mm', 1000, 5000, 12, 16, 'sqft'),
-- Cricket Net Rates
('cricket_net', '1000_5000', NULL, '40mm', 1000, 5000, 15, 18, 'sqft'),
('cricket_net', '1000_5000', NULL, '45mm', 1000, 5000, 14, 17, 'sqft'),
('cricket_net', '1000_5000', NULL, '50mm', 1000, 5000, 13, 16, 'sqft'),
('cricket_net', '5000_10000', NULL, '40mm', 5000, 10000, 14, 17, 'sqft'),
('cricket_net', '5000_10000', NULL, '45mm', 5000, 10000, 13, 16, 'sqft'),
('cricket_net', '5000_10000', NULL, '50mm', 5000, 10000, 12, 15, 'sqft'),
('cricket_net', '10000_15000', NULL, '40mm', 10000, 15000, 12, 15, 'sqft'),
('cricket_net', '10000_15000', NULL, '45mm', 10000, 15000, 11, 14, 'sqft'),
('cricket_net', '10000_15000', NULL, '50mm', 10000, 15000, 10, 13, 'sqft'),
('cricket_net', '15000_20000', NULL, '40mm', 15000, 20000, 11, 14, 'sqft'),
('cricket_net', '15000_20000', NULL, '45mm', 15000, 20000, 10, 13, 'sqft'),
('cricket_net', '15000_20000', NULL, '50mm', 15000, 20000, 9, 12, 'sqft'),
('cricket_net', 'above_20000', NULL, '40mm', 20000, 99999, 10, 12, 'sqft'),
('cricket_net', 'above_20000', NULL, '45mm', 20000, 99999, 9, 11, 'sqft'),
('cricket_net', 'above_20000', NULL, '50mm', 20000, 99999, 8, 10, 'sqft'),
-- Invisible Grill Rates
('invisible_grill', 'all', '1.5mm', '2inch', 1, 99999, 130, 150, 'sqft'),
('invisible_grill', 'all', '1.5mm', '3inch', 1, 99999, 120, 140, 'sqft'),
('invisible_grill', 'all', '2mm', '2inch', 1, 99999, 140, 160, 'sqft'),
('invisible_grill', 'all', '2mm', '3inch', 1, 99999, 130, 150, 'sqft'),
('invisible_grill', 'all', '2.5mm', '2inch', 1, 99999, 150, 170, 'sqft'),
('invisible_grill', 'all', '2.5mm', '3inch', 1, 99999, 140, 160, 'sqft'),
('invisible_grill', 'all', '3mm', '2inch', 1, 99999, 160, 180, 'sqft'),
('invisible_grill', 'all', '3mm', '3inch', 1, 99999, 150, 170, 'sqft'),
-- Cloth Hanger Rates (ceiling)
('cloth_hanger', 'ceiling', NULL, NULL, NULL, NULL, 2000, 2500, 'unit'),
('cloth_hanger', 'ceiling_5ft', NULL, NULL, NULL, NULL, 2250, 2750, 'unit'),
('cloth_hanger', 'ceiling_6ft', NULL, NULL, NULL, NULL, 2500, 3000, 'unit'),
('cloth_hanger', 'ceiling_7ft', NULL, NULL, NULL, NULL, 2750, 3250, 'unit'),
('cloth_hanger', 'ceiling_8ft', NULL, NULL, NULL, NULL, 3000, 3500, 'unit'),
('cloth_hanger', 'wall_4ft', NULL, NULL, NULL, NULL, 2500, 3000, 'unit'),
('cloth_hanger', 'wall_5ft', NULL, NULL, NULL, NULL, 2750, 3250, 'unit'),
('cloth_hanger', 'wall_6ft', NULL, NULL, NULL, NULL, 3000, 3500, 'unit'),
('cloth_hanger', 'wall_7ft', NULL, NULL, NULL, NULL, 3250, 3750, 'unit'),
('cloth_hanger', 'wall_8ft', NULL, NULL, NULL, NULL, 3500, 4000, 'unit'),
-- Artificial Grass Rates
('artificial_grass', 'mat_25_single', NULL, NULL, NULL, NULL, 30, 40, 'sqft'),
('artificial_grass', 'mat_30_single', NULL, NULL, NULL, NULL, 33, 43, 'sqft'),
('artificial_grass', 'mat_40_single', NULL, NULL, NULL, NULL, 36, 46, 'sqft'),
('artificial_grass', 'mat_50_single', NULL, NULL, NULL, NULL, 40, 50, 'sqft'),
('artificial_grass', 'mat_25_double', NULL, NULL, NULL, NULL, 35, 45, 'sqft'),
('artificial_grass', 'mat_30_double', NULL, NULL, NULL, NULL, 38, 48, 'sqft'),
('artificial_grass', 'mat_40_double', NULL, NULL, NULL, NULL, 41, 51, 'sqft'),
('artificial_grass', 'mat_50_double', NULL, NULL, NULL, NULL, 45, 55, 'sqft'),
('artificial_grass', 'turf_25_single', NULL, NULL, NULL, NULL, 95, 135, 'sqft'),
('artificial_grass', 'football_50_double', NULL, NULL, NULL, NULL, 75, 100, 'sqft'),
-- Box Cricket Setup
('box_cricket', 'setup', NULL, NULL, NULL, NULL, 220, 300, 'sqft');

-- --------------------------------------------------------
-- Visitors Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `ip_address` varchar(50),
  `country` varchar(100),
  `state` varchar(100),
  `city` varchar(100),
  `latitude` decimal(10,7),
  `longitude` decimal(10,7),
  `user_agent` text,
  `device_type` varchar(50),
  `browser` varchar(100),
  `os` varchar(100),
  `referrer` varchar(500),
  `first_page` varchar(500),
  `last_page` varchar(500),
  `pages_visited` int(11) DEFAULT 1,
  `time_spent` int(11) DEFAULT 0,
  `is_live` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  KEY `is_live` (`is_live`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Visitor Pages Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `visitor_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` int(11) NOT NULL,
  `page_url` varchar(500),
  `page_title` varchar(300),
  `time_on_page` int(11) DEFAULT 0,
  `visited_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `visitor_id` (`visitor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Quotations / Billing Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `quotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_no` varchar(50) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_email` varchar(150),
  `client_phone` varchar(20),
  `client_address` text,
  `client_company` varchar(200),
  `client_gstin` varchar(20),
  `bill_type` enum('B2B','B2C') DEFAULT 'B2C',
  `subtotal` decimal(12,2) DEFAULT 0,
  `discount` decimal(12,2) DEFAULT 0,
  `gst_percentage` decimal(5,2) DEFAULT 18,
  `gst_amount` decimal(12,2) DEFAULT 0,
  `total` decimal(12,2) DEFAULT 0,
  `notes` text,
  `terms` text,
  `warranty_years` tinyint(2) DEFAULT 0,
  `status` enum('draft','sent','accepted','rejected') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotation_no` (`quotation_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Quotation Items Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `quotation_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) NOT NULL,
  `description` varchar(300) NOT NULL,
  `quantity` decimal(10,2) DEFAULT 1,
  `unit` varchar(20) DEFAULT 'Sqft',
  `rate` decimal(12,2) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quotation_id` (`quotation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- SEO Pages Override Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `seo_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_identifier` varchar(200) NOT NULL,
  `meta_title` varchar(300),
  `meta_description` text,
  `meta_keywords` text,
  `og_title` varchar(300),
  `og_description` text,
  `schema_markup` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_identifier` (`page_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- FAQs Table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `faqs` (`question`, `answer`, `category`, `sort_order`) VALUES
('What is Russea™ brand?', 'Russea™ is a premium trademark brand of HDPE safety nets. NetsDial is an authorized wholesale supplier of Russea™ branded nets across India. All Russea™ nets are UV stabilized, weather resistant and carry a quality guarantee.', 'General', 1),
('Do you supply across India?', 'Yes! NetsDial by GCM Enterprises is one of the largest net suppliers from South India. We supply Russea™ HDPE nets to all states and cities across India. Delivery is available pan-India.', 'General', 2),
('What types of nets do you supply?', 'We supply all types of HDPE nets including: Pigeon/Bird Netting, Balcony Safety Nets, Children Safety Nets, Sports Practice Nets, Cricket Nets, Box Cricket Nets, Anti-Bird Nets, and Industrial Safety Nets. All under the Russea™ brand.', 'Products', 3),
('Do you offer installation services?', 'We are primarily wholesale net suppliers. However, we can guide you to professional installation partners in your area. For bulk orders in Hyderabad, installation guidance is available.', 'Services', 4),
('What is the price per sq ft for pigeon netting?', 'Pigeon net prices vary by thickness and mesh size: Below 100 sqft: Rs. 1500-1800 (fixed rate). 100-250 sqft: Rs. 16-30/sqft. 250-500 sqft: Rs. 14-26/sqft. Use our estimation calculator for exact pricing.', 'Pricing', 5),
('How strong are the safety nets?', 'All Russea™ HDPE safety nets are made with high-tensile HDPE fiber with UV stabilization. They can withstand strong winds, rain and extreme temperatures. Perfect for high-rise buildings up to 30+ floors.', 'Products', 6),
('What thickness options are available for safety nets?', 'Safety nets are available in 1.5mm, 2mm and 2.5mm thickness. Mesh/square gap options: 30mm, 40mm, 45mm and 50mm. Thicker nets provide more strength while larger gaps allow better airflow.', 'Products', 7),
('Are your nets UV stabilized?', 'Yes! All Russea™ HDPE nets are 100% UV stabilized. They will not degrade under harsh sunlight and maintain their strength and color for years. Typical lifespan is 5-10 years depending on environmental conditions.', 'Products', 8),
('Do you provide warranty?', 'Yes, Russea™ nets come with manufacturer warranty. Warranty duration varies by product: Safety Nets: 1-3 years, Invisible Grills: 3-5 years, Sports Nets: 2-5 years. Warranty cards can be generated from our system.', 'Services', 9),
('How to calculate net requirement for my balcony?', 'Measure length × height of the area to cover. For example, a 10ft × 8ft balcony needs 80 sqft of netting. Use our online estimation calculator on the Estimation page for accurate cost estimates.', 'Pricing', 10),
('What is invisible grill and how is it different from safety net?', 'Invisible grills are stainless steel wire systems fixed vertically to the balcony frame. They provide safety without blocking the view completely. Safety nets are mesh nets that cover the entire balcony opening. Both serve child/pet safety purposes.', 'Products', 11),
('Can artificial grass be used outdoors?', 'Yes! Our Russea™ artificial grass is specially designed for outdoor use. It is UV stabilized, waterproof and weather resistant. Available in multiple pile heights and types suitable for balconies, terraces, gardens and sports grounds.', 'Products', 12),
('What is box cricket setup cost?', 'Box cricket setup costs Rs. 220-300 per sqft including nets, artificial turf, structure fabrication and flooring. The rate depends on ground size, structure height (20-40 ft) and site conditions. Use our estimator for exact quotes.', 'Pricing', 13),
('How do pigeon spikes work?', 'Pigeon spikes create an uncomfortable surface that prevents pigeons from landing on ledges, AC units, parapet walls and other surfaces. Russea™ pigeon spikes are available in stainless steel (SS) and polycarbonate. They are humane, effective and weatherproof.', 'Products', 14),
('Can I order wholesale quantities?', 'Absolutely! NetsDial specializes in wholesale supply. We are one of the largest HDPE net suppliers in South India. Bulk orders get special pricing. Contact us for wholesale rates and dealer partnerships.', 'Ordering', 15),
('How to place an order?', 'You can place an order through: 1) Call/WhatsApp: 9966499144, 2) Email: netsdial@gmail.com, 3) Contact form on our website, 4) Visit our office in Karmanghat, Hyderabad. Our team will provide a quotation within 24 hours.', 'Ordering', 16),
('What payment methods do you accept?', 'We accept: Bank Transfer (NEFT/RTGS/IMPS), UPI (GPay, PhonePe, Paytm), Cheque for bulk orders, and Cash for local pickup. GST invoices provided for all transactions.', 'Ordering', 17),
('Do you provide GST invoices?', 'Yes, we provide proper GST invoices for all transactions. Our company GCM Enterprises is GST registered. Both B2B (with client GSTIN) and B2C invoices are available.', 'Ordering', 18),
('What is the delivery time?', 'Delivery timelines: Hyderabad: 1-2 working days, Telangana cities: 2-3 working days, Andhra Pradesh: 3-4 working days, Other states: 5-7 working days. Express delivery available on request.', 'Delivery', 19),
('Do you ship to Vizag and Vijayawada?', 'Yes! We regularly supply to Visakhapatnam (Vizag), Vijayawada, Tirupati, Guntur and all major cities in Andhra Pradesh. Delivery typically takes 3-4 working days from Hyderabad warehouse.', 'Delivery', 20);

COMMIT;
