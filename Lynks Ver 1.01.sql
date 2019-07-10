-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2019 at 03:16 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lynks_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_number` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 for inactive/1 for active '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biller`
--

CREATE TABLE `biller` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` text COLLATE utf8_unicode_ci,
  `address2` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vat_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `custom_field1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_field2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_field3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_field4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `repeat_type` int(5) NOT NULL,
  `repeat_days` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_end` tinyint(1) DEFAULT NULL,
  `emails` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `additional_content` text COLLATE utf8_unicode_ci NOT NULL,
  `attachments` text COLLATE utf8_unicode_ci NOT NULL,
  `last_send` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_attempts`
--

CREATE TABLE `chat_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `from` int(11) UNSIGNED NOT NULL,
  `to` int(11) UNSIGNED NOT NULL,
  `read` int(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `date_read` datetime DEFAULT NULL,
  `offline` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('76amesceq594ngesg896f7cjdap8psq1', '::1', 1558528982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532383938323b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('9ip5tp40hcr8pu0dq5e8f0q004pnp7ps', '::1', 1558529681, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532393638313b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('fibhnj3i73ajkm4lua6g3t4kajudulu9', '::1', 1558526451, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532363435313b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('g330obqh3i81fdobsv2squ3dne4h5mca', '::1', 1558526041, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532363034313b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('gbe93p482bmvsk10qucl0teu26p7deu3', '::1', 1558530586, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383533303538363b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('kb8vbbmaupmbl90pg20dnu4g0vs5tc8l', '::1', 1558525626, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532353632363b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('kjc9t5nsqqr34589ssmrrvtgp7o38c7d', '::1', 1558526821, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532363832313b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('pvcam0f3m5e3kamqdrtbqpkou943p545', '::1', 1558527261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532373236313b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('ro1ackralr0ai30gqacd1akvacb4hsrr', '::1', 1558528214, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532383231343b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('t1qa7gpffhct05uc1bogc7mn0qtfkpht', '::1', 1558527598, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532373539383b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('u7c59pil19mgm551keib9ppcp1ikte0b', '::1', 1558527910, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383532373931303b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('vh9mdnpo1avp0e47mb8ol0nq0i7680s2', '::1', 1558530989, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383533303538363b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b),
('vnbr1vlga3unp2er0jr2okntu7hnersb', '::1', 1558530014, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383533303031343b6c616e677c733a373a22656e676c697368223b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231343833313137303035223b66697273745f6e616d657c733a353a2241646d696e223b6c6173745f6e616d657c733a383a226973747261746f72223b);

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `biller_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `attachments` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `language`, `subject`, `content`, `data`) VALUES
(1, 'send_invoices_to_customer.tpl', 'english', 'Invoice PDF from {{company_name}}', '<p>Greetings !<br>You have received an invoice from <strong>{{company_name}}</strong>.<br>A PDF file is attached.</p>', 'invoice|customer|company'),
(2, 'send_invoices_to_customer.tpl', 'french', 'Facture PDF de {{company_name}}', '<p>Salutations !<br>Vous avez reçu une facture de <strong>{{company_name}}</strong>.<br>Un fichier PDF est attaché.</p>', 'invoice|customer|company'),
(3, 'send_invoices_to_customer.tpl', 'spanish', 'Factura PDF de {{company_name}}', '<p>Saludos !<br>Ha recibido una factura de <strong>{{company_name}}</strong>. <br> Se adjunta un archivo PDF.</p>', 'invoice|customer|company'),
(4, 'send_invoices_to_customer.tpl', 'turkish', 'dan fatura paketi {{company_name}}', '<p>Selamlar !<br> adresinden bir fatura aldınız  {{company_name}}. <br> Bir PDF dosyası eklenmiştir.</p>', 'invoice|customer|company'),
(5, 'send_invoices_to_customer.tpl', 'russian', 'Счёт-фактура из {{company_name}}', '<p>Приветствую!<br>Вы получили счет-фактуру <strong>{{company_name}}</strong>. <br> Файл PDF прилагается.</p>', 'invoice|customer|company'),
(6, 'send_invoices_to_customer.tpl', 'romanian', 'Factura PDF din {{company_name}}', '<p>Bună!<br>Ați primit o factură de la <strong>{{company_name}}</strong>.<br>Un fișier PDF este atașat.</p>', 'invoice|customer|company'),
(7, 'send_invoices_to_customer.tpl', 'german', 'Rechnung PDF ab {{company_name}}', '<p>Grüße!<br>Sie haben eine Rechnung erhalten <strong>{{company_name}}</strong>. <br> Eine PDF-Datei ist beigefügt.</p>', 'invoice|customer|company'),
(8, 'send_invoices_to_customer.tpl', 'italian', 'Fattura PDF da {{company_name}}', '<p>Saluti !<br>Hai ricevuto una fattura da <strong>{{company_name}}</strong>. <br> È allegato un file PDF.</p>', 'invoice|customer|company'),
(9, 'send_invoices_to_customer.tpl', 'arabic', 'فاتورة بي دي أف من {{company_name}}', '<p>تحية طيبة !<br>لقد تلقيت فاتورة من <strong>{{company_name}}</strong>.<br>ملف PDF مرفق.</p>', 'invoice|customer|company'),
(19, 'send_estimates_to_customer.tpl', 'english', 'Estimate PDF from {{company_name}}', 'Greetings !<br>You have received an estimate from <b>{{company_name}}</b>.<br>A PDF file is attached.', 'estimate|customer|company'),
(20, 'send_estimates_to_customer.tpl', 'french', 'Estimation PDF de{{company_name}}', 'Salutations!<br>Vous avez reçu une estimation de <b>{{company_name}}</b> . <br> Un fichier PDF est joint.', 'estimate|customer|company'),
(21, 'send_estimates_to_customer.tpl', 'spanish', 'Calcule el PDF de{{company_name}}', 'Saludos !<br>Ha recibido una estimación de <b>{{company_name}}</b> . <br> Se adjunta un archivo PDF.', 'estimate|customer|company'),
(22, 'send_estimates_to_customer.tpl', 'turkish', '&#39;den PDF tahmin edin', 'Selamlar !<br><b></b> tarafından bir tahmin aldınız. <br> Bir PDF dosyası eklenmiştir.', 'estimate|customer|company'),
(23, 'send_estimates_to_customer.tpl', 'russian', 'Оценка PDF из{{company_name}}', 'Приветствую !<br>Вы получили оценку от <b>{{company_name}}</b> . <br> Файл PDF прилагается.', 'estimate|customer|company'),
(24, 'send_estimates_to_customer.tpl', 'romanian', 'Proformă PDF din {{company_name}}', 'Bună !<br>Ați primit o proformă de la <b>{{company_name}} </ b>. <br> Un fișier PDF este atașat.', 'estimate|customer|company'),
(25, 'send_estimates_to_customer.tpl', 'german', 'Schätzen Sie PDF aus {{company_name}} ', 'Grüße!<br>Sie haben eine Schätzung erhalten {{company_name}} . <br> Eine PDF-Datei ist beigefügt.', 'estimate|customer|company'),
(26, 'send_estimates_to_customer.tpl', 'italian', 'Stima PDF da {{company_name}} ', 'Saluti !<br>Hai ricevuto una stima da {{company_name}} . <br> È allegato un file PDF.', 'estimate|customer|company'),
(27, 'send_estimates_to_customer.tpl', 'arabic', 'ملف تقدير PDF من  {{company_name}}', 'تحية طيبة !<br>لقد تلقيت تقديرا من <b>{{company_name}}</b> . <br> يتم إرفاق ملف PDF .', 'estimate|customer|company'),
(37, 'send_contracts_to_customer.tpl', 'english', 'Contract PDF from {{company_name}}', 'Greetings !<br>You have received an contract from <b>{{company_name}}</b>.<br>A PDF file is attached.', 'contract|customer|company'),
(38, 'send_contracts_to_customer.tpl', 'french', 'Contrat PDF à partir de {{company_name}} ', 'Salutations !<br>Vous avez reçu un contrat de {{company_name}} . <br> Un fichier PDF est joint.', 'contract|customer|company'),
(39, 'send_contracts_to_customer.tpl', 'spanish', 'Contrato PDF de {{company_name}} ', 'Saludos !<br>Ha recibido un contrato de {{company_name}} . <br> Se adjunta un archivo PDF.', 'contract|customer|company'),
(40, 'send_contracts_to_customer.tpl', 'turkish', 'Şuradan sözleşme PDF&#39;si {{company_name}} ', 'Selamlar !<br>Şuradan bir sözleşme aldınız: {{company_name}} . <br> Bir PDF dosyası eklenmiştir.', 'contract|customer|company'),
(41, 'send_contracts_to_customer.tpl', 'russian', 'Договор PDF от {{company_name}} ', 'Приветствую !<br>Вы получили контракт от {{company_name}} , <br> Файл PDF прилагается.', 'contract|customer|company'),
(42, 'send_contracts_to_customer.tpl', 'romanian', 'Contract PDF la {{company_name}}', 'Salutari !<br>Ați primit un contract de la {{company_name}} . <br> Un fișier PDF este atașat.', 'contract|customer|company'),
(43, 'send_contracts_to_customer.tpl', 'german', 'Vertrag PDF ab {{company_name}} ', 'Grüße!<br>Sie haben einen Vertrag von {{company_name}} . <br> Eine PDF-Datei ist angehängt.', 'contract|customer|company'),
(44, 'send_contracts_to_customer.tpl', 'italian', 'Contratto PDF da {{company_name}} ', 'Saluti !<br>Hai ricevuto un contratto da {{company_name}} . <br> È allegato un file PDF.', 'contract|customer|company'),
(45, 'send_contracts_to_customer.tpl', 'arabic', 'Pdf العقد من {{company_name}} ', 'تحية طيبة !<br>لقد تلقيت عقدا من {{company_name}} . <br> يتم إرفاق ملف بدف.', 'contract|customer|company'),
(46, 'send_receipts_to_customer.tpl', 'english', 'Payment PDF from {{company_name}}', 'Greetings !<br>You have received an payment from <b>{{company_name}}</b>.<br>A PDF file is attached.', 'receipt|customer|company'),
(47, 'send_receipts_to_customer.tpl', 'french', 'Paiement PDF de{{company_name}}', 'Salutations!<br>Vous avez reçu un paiement de <b>{{company_name}}</b> . <br> Un fichier PDF est joint.', 'receipt|customer|company'),
(48, 'send_receipts_to_customer.tpl', 'spanish', 'Pago PDF de{{company_name}}', 'Saludos !<br>Ha recibido un pago de <b>{{company_name}}</b> . <br> Se adjunta un archivo PDF.', 'receipt|customer|company'),
(49, 'send_receipts_to_customer.tpl', 'turkish', 'Ödeme{{company_name}}&#39;den PDF', 'Selamlar !<br><b>/b> S&#39;dan bir ödeme aldınız. <br> Bir PDF dosyası eklenmiştir.', 'receipt|customer|company'),
(50, 'send_receipts_to_customer.tpl', 'russian', 'Оплата PDF из{{company_name}}', 'Приветствую !<br>Вы получили платеж от <b>{{company_name}}</b> . <br> Файл PDF прилагается.', 'receipt|customer|company'),
(51, 'send_receipts_to_customer.tpl', 'romanian', 'Plata PDF din{{company_name}}', 'Bună!<br>Ați primit o plată de la <b>{{company_name}} </ b>. <br> Un fișier PDF este atașat.', 'receipt|customer|company'),
(52, 'send_receipts_to_customer.tpl', 'german', 'Zahlung PDF ab {{company_name}} ', 'Grüße!<br>Sie haben eine Zahlung erhalten von {{company_name}} . <br> Eine PDF-Datei ist beigefügt.', 'receipt|customer|company'),
(53, 'send_receipts_to_customer.tpl', 'italian', 'Pagamento PDF da {{company_name}} ', 'Saluti !<br>Hai ricevuto un pagamento da {{company_name}} . <br> È allegato un file PDF.', 'receipt|customer|company'),
(54, 'send_receipts_to_customer.tpl', 'arabic', 'ملف PDF من {{company_name}}', 'تحية طيبة !<br>لقد تلقيت دفعة من <b>{{company_name}}</b> . <br> يتم إرفاق ملف PDF .', 'receipt|customer|company'),
(64, 'send_rinvoices_to_customer.tpl', 'english', 'New Invoice from {{company_name}}', 'Greetings !<br>You have received an new unpaid invoice from <b>{{company_name}}</b>.<br><a href=\"{{invoice_link}}\" target=\"_blank\">Open</a>', 'invoice|customer|company'),
(65, 'send_rinvoices_to_customer.tpl', 'french', 'Nouvelle facture de {{company_name}} ', 'Salutations !<br>Vous avez reçu une nouvelle facture impayée de {{company_name}} .<br><a href=\"{{invoice_link}}\" target=\"_blank\">Ouvrir</a>', 'invoice|customer|company'),
(66, 'send_rinvoices_to_customer.tpl', 'spanish', 'Nueva factura de {{company_name}} ', 'Saludos !<br>Ha recibido una nueva factura no pagada de {{company_name}} .<br><a href=\"{{invoice_link}}\" target=\"_blank\">Abierto</a>', 'invoice|customer|company'),
(67, 'send_rinvoices_to_customer.tpl', 'turkish', 'Şuradan yeni fatura {{company_name}} ', 'Selamlar !<br>Şuradan yeni bir ödenmemiş fatura aldınız: {{company_name}} .<br><a href=\"{{invoice_link}}\" target=\"_blank\">Açık</a>', 'invoice|customer|company'),
(68, 'send_rinvoices_to_customer.tpl', 'russian', 'Новый счет-фактура {{company_name}} ', 'Приветствую!<br>Вы получили новый неоплаченный счет {{company_name}} ,<br><a href=\"{{invoice_link}}\" target=\"_blank\">открыто</a>', 'invoice|customer|company'),
(69, 'send_rinvoices_to_customer.tpl', 'romanian', 'Factura nouă de la {{company_name}}', 'Bună!<br>Ați primit o nouă factură neachitată de la <b>{{company_name}}</b>.<br><a href=\"{{invoice_link}}\" target=\"_blank\">Deschis</a>', 'invoice|customer|company'),
(70, 'send_rinvoices_to_customer.tpl', 'german', 'Neue Rechnung ab {{company_name}} ', 'Grüße!<br>Sie haben eine neue, unbezahlte Rechnung erhalten {{company_name}} .<br><a href=\"{{invoice_link}}\" target=\"_blank\">Öffnen</a>', 'invoice|customer|company'),
(71, 'send_rinvoices_to_customer.tpl', 'italian', 'Nuova fattura da {{company_name}} ', 'Saluti !<br>Hai ricevuto una nuova fattura non pagata da {{company_name}} .<br><a href=\"{{invoice_link}}\" target=\"_blank\">Aperto</a>', 'invoice|customer|company'),
(72, 'send_rinvoices_to_customer.tpl', 'arabic', 'فاتورة جديدة من {{company_name}} ', 'تحية طيبة !<br>لقد تلقيت فاتورة جديدة غير مدفوعة من {{company_name}} .<br><a href=\"{{invoice_link}}\" target=\"_blank\">فتح</a>', 'invoice|customer|company'),
(73, 'send_customer_reminder.tpl', 'english', 'You have unpaid invoices from {{company_name}}', 'Dear {{customer_fullname}},<br>You have <b>{{count_invoices}}</b> unpaid invoices.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">Invoices</a>', 'invoice_reminder|customer|company'),
(74, 'send_customer_reminder.tpl', 'french', 'Vous avez des factures impayées de {{company_name}} ', 'cher {{customer_fullname}} ,<br>Tu as {{count_invoices}} factures impayées.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">Factures</a>', 'invoice_reminder|customer|company'),
(75, 'send_customer_reminder.tpl', 'spanish', 'Tiene facturas pendientes de pago de {{company_name}} ', 'querido {{customer_fullname}} ,<br>Tienes {{count_invoices}} facturas pendientes de pago.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">Facturas</a>', 'invoice_reminder|customer|company'),
(76, 'send_customer_reminder.tpl', 'turkish', 'Gönderdiğiniz ödenmemiş faturanız var {{company_name}} ', 'Sayın {{customer_fullname}} ,<br>Var {{count_invoices}} ödenmemiş faturalar.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">Faturalar</a>', 'invoice_reminder|customer|company'),
(77, 'send_customer_reminder.tpl', 'russian', 'У вас есть неоплаченные счета-фактуры {{company_name}} ', 'Уважаемые {{customer_fullname}} ,<br>You have <b>{{count_invoices}}</b> unpaid invoices.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">Счета-фактуры</a>', 'invoice_reminder|customer|company'),
(78, 'send_customer_reminder.tpl', 'romanian', 'Aveți facturi neachitate de la {{company_name}}', 'Bună {{customer_fullname}},<br>Aveți <b>{{count_invoices}}</b> facturi neachitate.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">Facturi</a>', 'invoice_reminder|customer|company'),
(79, 'send_customer_reminder.tpl', 'german', 'Sie haben unbezahlte Rechnungen aus {{company_name}} ', 'sehr geehrter {{customer_fullname}} ,<br>Du hast {{count_invoices}} unbezahlte Rechnungen.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">Rechnungen</a>', 'invoice_reminder|customer|company'),
(80, 'send_customer_reminder.tpl', 'italian', 'Hai fatture non pagate da {{company_name}} ', 'caro {{customer_fullname}} ,<br>Hai {{count_invoices}} fatture non pagate.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">Fatture</a>', 'invoice_reminder|customer|company'),
(81, 'send_customer_reminder.tpl', 'arabic', 'لديك فواتير غير مدفوعة م', 'العزيز {{customer_fullname}} ،<br>عندك {{count_invoices}} فواتير غير مدفوعة.<br>{{invoices_table}}<br><a href=\"http://localhost/malex_updated/index.php/invoices\" target=\"_blank\">الفواتير</a>', 'invoice_reminder|customer|company'),
(82, 'send_overdue_reminder.tpl', 'english', 'You have unpaid invoices from {{company_name}}', 'Dear {{customer_fullname}},<br>You might have missed the payment date and the invoice is now overdue by <b>{{invoice_overdue_days}}</b> days.<br><br><table width=\'100%\'><tr><td>Reference : </td><th>{{invoice_reference}}</th></tr><tr><td>Date : </td><th>{{invoice_date}}</th></tr><tr><td>Due Date : </td><th>{{invoice_date_due}}</th></tr><tr><td>Total : </td><th>{{invoice_total}}</th></tr><tr><td>Payments : </td><th>{{invoice_total_payments}}</th></tr><tr><td>Total Due : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">Invoice</a>', 'invoice|customer|company'),
(83, 'send_overdue_reminder.tpl', 'french', 'Vous avez des factures impayées de {{company_name}} ', 'cher {{customer_fullname}} ,<br>Vous avez peut-être manqué la date de paiement et la facture est maintenant en retard {{invoice_overdue_days}} journées.<br><br><table width=\'100%\'><tr><td>Référence : </td><th>{{invoice_reference}}</th></tr><tr><td>Date : </td><th>{{invoice_date}}</th></tr><tr><td>Date d&#39;échéance : </td><th>{{invoice_date_due}}</th></tr><tr><td>Total : </td><th>{{invoice_total}}</th></tr><tr><td>Paiements : </td><th>{{invoice_total_payments}}</th></tr><tr><td>Total dû : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">Facture</a>', 'invoice|customer|company'),
(84, 'send_overdue_reminder.tpl', 'spanish', 'Tiene facturas pendientes de pago de {{company_name}} ', 'querido {{customer_fullname}} ,<br>Es posible que haya perdido la fecha de pago y la factura esté atrasada por {{invoice_overdue_days}} días.<br><br><table width=\'100%\'><tr><td>Referencia : </td><th>{{invoice_reference}}</th></tr><tr><td>Fecha : </td><th>{{invoice_date}}</th></tr><tr><td>Fecha de vencimiento : </td><th>{{invoice_date_due}}</th></tr><tr><td>Total : </td><th>{{invoice_total}}</th></tr><tr><td>Pagos : </td><th>{{invoice_total_payments}}</th></tr><tr><td>Total debido : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">Factura</a>', 'invoice|customer|company'),
(85, 'send_overdue_reminder.tpl', 'turkish', 'Gönderdiğiniz ödenmemiş faturanız var {{company_name}} ', 'Sayın {{customer_fullname}} ,<br>Ödeme tarihini kaçırmış olabilirsiniz ve fatura şimdi tarafından gecikmiştir. {{invoice_overdue_days}} günler.<br><br><table width=\'100%\'><tr><td>Referans : </td><th>{{invoice_reference}}</th></tr><tr><td>tarih : </td><th>{{invoice_date}}</th></tr><tr><td>Bitiş tarihi : </td><th>{{invoice_date_due}}</th></tr><tr><td>Genel Toplam : </td><th>{{invoice_total}}</th></tr><tr><td>Ödemeler : </td><th>{{invoice_total_payments}}</th></tr><tr><td>Vadesi gereken toplam : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">Fatura</a>', 'invoice|customer|company'),
(86, 'send_overdue_reminder.tpl', 'russian', 'У вас есть неоплаченные счета-фактуры {{company_name}} ', 'Уважаемые {{customer_fullname}} ,<br>Возможно, вы пропустили дату платежа, и счет теперь просрочен {{invoice_overdue_days}} дней.<br><br><table width=\'100%\'><tr><td>Справка : </td><th>{{invoice_reference}}</th></tr><tr><td>Дата : </td><th>{{invoice_date}}</th></tr><tr><td>Срок : </td><th>{{invoice_date_due}}</th></tr><tr><td>Всего : </td><th>{{invoice_total}}</th></tr><tr><td>платежи : </td><th>{{invoice_total_payments}}</th></tr><tr><td>Общая сумма : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">Выставленный счет</a>', 'invoice|customer|company'),
(87, 'send_overdue_reminder.tpl', 'romanian', 'Aveți facturi neachitate de la {{company_name}}', 'Bună {{customer_fullname}},<br>S-ar putea să fi întarziat data de plații, iar factura este acum depășită de <b>{{invoice_overdue_days}}</b> zile<br><br><table width=\'100%\'><tr><td>Referinţă : </td><th>{{invoice_reference}}</th></tr><tr><td>Data : </td><th>{{invoice_date}}</th></tr><tr><td>Data scadentă : </td><th>{{invoice_date_due}}</th></tr><tr><td>Total : </td><th>{{invoice_total}}</th></tr><tr><td>Plăţile : </td><th>{{invoice_total_payments}}</th></tr><tr><td>Total datorat : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">Factură</a>', 'invoice|customer|company'),
(88, 'send_overdue_reminder.tpl', 'german', 'Sie haben unbezahlte Rechnungen aus {{company_name}} ', 'sehr geehrter {{customer_fullname}} ,<br>Vielleicht haben Sie das Zahlungsdatum verpasst und die Rechnung ist jetzt überfällig {{invoice_overdue_days}} Tage.<br><br><table width=\'100%\'><tr><td>Referenz : </td><th>{{invoice_reference}}</th></tr><tr><td>Datum : </td><th>{{invoice_date}}</th></tr><tr><td>Geburtstermin : </td><th>{{invoice_date_due}}</th></tr><tr><td>Gesamt : </td><th>{{invoice_total}}</th></tr><tr><td>Zahlungen : </td><th>{{invoice_total_payments}}</th></tr><tr><td>Gesamt fällig : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">Rechnung</a>', 'invoice|customer|company'),
(89, 'send_overdue_reminder.tpl', 'italian', 'Hai fatture non pagate da {{company_name}} ', 'caro {{customer_fullname}} ,<br>Potresti aver perso la data di pagamento e la fattura è ormai scaduta {{invoice_overdue_days}} giorni.<br><br><table width=\'100%\'><tr><td>Riferimento : </td><th>{{invoice_reference}}</th></tr><tr><td>Data : </td><th>{{invoice_date}}</th></tr><tr><td>Scadenza : </td><th>{{invoice_date_due}}</th></tr><tr><td>Totale : </td><th>{{invoice_total}}</th></tr><tr><td>pagamenti : </td><th>{{invoice_total_payments}}</th></tr><tr><td>Totale dovuto : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">Fattura</a>', 'invoice|customer|company'),
(90, 'send_overdue_reminder.tpl', 'arabic', 'لديك فواتير غير مدفوعة م', 'العزيز {{customer_fullname}} ،<br>قد تكون قد فاتك تاريخ الدفع إلى الفاتورة متأخرة الآن {{invoice_overdue_days}} أيام.<br><br><table width=\'100%\'><tr><td>الرقم المرجعي : </td><th>{{invoice_reference}}</th></tr><tr><td>التاريخ : </td><th>{{invoice_date}}</th></tr><tr><td>تاريخ الاستحقاق : </td><th>{{invoice_date_due}}</th></tr><tr><td>المجموع : </td><th>{{invoice_total}}</th></tr><tr><td>المدفوعات : </td><th>{{invoice_total_payments}}</th></tr><tr><td>الاجمالي المستحق : </td><th>{{invoice_total_due}}</th></tr></table><br><a href=\"{{invoice_link}}\" target=\"_blank\">فاتورة</a>', 'invoice|customer|company'),
(91, 'send_forgotten_password.tpl', 'english', 'Forgotten Password Verification - {{company_name}}', 'Hi {{user_first_name}},<br>We have received a request to reset your password.<br>Your username is <b>{{user_username}}</b>.<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">Reset Password</a>', 'user|company'),
(92, 'send_forgotten_password.tpl', 'french', 'Vérification du mot de passe oublié - {{company_name}}', 'Salut {{user_first_name}},<br>Nous avons reçu une demande pour réinitialiser votre mot de passe..<br>Votre nom d\'utilisateur est <b>{{user_username}}</b>.<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">Réinitialiser le mot de passe</a>', 'user|company'),
(93, 'send_forgotten_password.tpl', 'spanish', 'Verificación de la contraseña olvidada - {{company_name}}', 'Su,<br>Hemos recibido una solicitud para restablecer su contraseña. <br> Su nombre de usuario es <b>{{user_username}}</b> .<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">Restablecer la contraseña</a>', 'user|company'),
(94, 'send_forgotten_password.tpl', 'turkish', 'Unutulan Parola Doğrulaması - {{company_name}}', 'Merhaba{{user_first_name}},<br>Şifrenizi sıfırlama talebi aldık. <br> Kullanıcı adınız <b>{{user_username}}</b> .<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">Şifreyi yenile</a>', 'user|company'),
(95, 'send_forgotten_password.tpl', 'russian', 'Проверка забытого пароля - {{company_name}}', 'Его,<br>Мы получили запрос на сброс пароля. <br> Ваше имя пользователя <b>{{user_username}}</b> .<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">Сброс пароля</a>', 'user|company'),
(96, 'send_forgotten_password.tpl', 'romanian', 'Verificarea parolei uitată - {{company_name}}', 'Bună {{user_first_name}},<br>Am primit o solicitare de resetare a parolei.<br>Numele tău de utilizator este <b>{{user_username}}</b>.<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">Resetează parola</a>', 'user|company'),
(97, 'send_forgotten_password.tpl', 'german', 'Passwort vergessen - {{company_name}}', 'Hallo {{user_first_name}} ,<br>Wir haben eine Anfrage erhalten, um Ihr Passwort zurückzusetzen. <br> Dein Benutzername ist {{user_username}} .<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">Passwort zurücksetzen</a>', 'user|company'),
(98, 'send_forgotten_password.tpl', 'italian', 'Dimenticata la verifica della password - {{company_name}}', 'Ciao {{user_first_name}} ,<br>Abbiamo ricevuto una richiesta di reimpostazione della password. <br> Il tuo nome utente è {{user_username}} .<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">Resetta la password</a>', 'user|company'),
(99, 'send_forgotten_password.tpl', 'arabic', 'التحقق من كلمة المرور المنسية - {{company_name}}', 'مرحبا {{user_first_name}},<br>لقد تلقينا طلبا لإعادة تعيين كلمة المرور الخاصة بك.<br> اسم المستخدم الخاص بك هو <b>{{user_username}}</b>.<br><a href=\"{{user_forgotten_password_code}}\" target=\"_blank\">إعادة تعيين كلمة المرور</a>', 'user|company'),
(100, 'send_activate.tpl', 'english', 'Account Activation - {{company_name}}', 'Congratulation !<br>Hi <b>{{user_username}}</b>, you have successfully registered on the <i>{{company_name}}</i>.<br>To activate your account, please confirm your registration.<br><a href=\"{{user_activation_code}}\" target=\"_blank\">Confirm registration</a>', 'user|company'),
(101, 'send_activate.tpl', 'french', 'Activation du compte - {{company_name}}', 'Félicitation !<br>Salut <b>{{user_username}}</b>, Vous avez enregistré avec succès sur le <i>{{company_name}}</i>.<br>Pour activer votre compte, veuillez confirmer votre inscription.<br><a href=\"{{user_activation_code}}\" target=\"_blank\">Confirmer l\'inscription</a>', 'user|company'),
(102, 'send_activate.tpl', 'spanish', 'activación de cuenta - {{company_name}}', 'Enhorabuena !<br>Hola <b>{{user_username}}</b> , has registrado correctamente en el <i>{{company_name}}</i> . <br> Para activar su cuenta, confirme su registro.<br><a href=\"{{user_activation_code}}\" target=\"_blank\">Confirmar registro</a>', 'user|company'),
(103, 'send_activate.tpl', 'turkish', 'Hesap Aktivasyonu - {{company_name}}', 'Tebrikler!<br>Merhaba, <b>{{user_username}}</b> , başarıyla <i>{{company_name}}</i> kayıt yaptın. <br> Hesabınızı etkinleştirmek için lütfen kayıt işleminizi onaylayın.<br><a href=\"{{user_activation_code}}\" target=\"_blank\">Kaydı onayla</a>', 'user|company'),
(104, 'send_activate.tpl', 'russian', 'Активация аккаунта - {{company_name}}', 'Поздравляем!<br>Привет <b>{{user_username}}</b> , вы успешно зарегистрировались на <i>{{company_name}}</i> . <br> Чтобы активировать свою учетную запись, пожалуйста, подтвердите свою регистрацию.<br><a href=\"{{user_activation_code}}\" target=\"_blank\">Подтверждение регистрации</a>', 'user|company'),
(105, 'send_activate.tpl', 'romanian', 'Activare cont - {{company_name}}', 'Felicitari !<br>Bună <b>{{user_username}}</b>, v-ați înregistrat cu succes pe <i>{{company_name}}</i>.<br>Pentru a vă activa contul, vă rugăm să confirmați înregistrarea.<br><a href=\"{{user_activation_code}}\" target=\"_blank\">Confirmați înregistrarea</a>', 'user|company'),
(106, 'send_activate.tpl', 'german', 'Account Aktivierung - {{company_name}}', 'Herzlichen Glückwunsch!<br>Hallo {{user_username}} Du hast dich erfolgreich registriert<br><a href=\"{{user_activation_code}}\" target=\"_blank\">Registrierung bestätigen</a>', 'user|company'),
(107, 'send_activate.tpl', 'italian', 'attivazione dell&#39;account - {{company_name}}', 'Congratulazioni!<br>Ciao {{user_username}} , sei stato registrato con successo nel sito<br><a href=\"{{user_activation_code}}\" target=\"_blank\">Conferma la registrazione</a>', 'user|company'),
(108, 'send_activate.tpl', 'arabic', 'تنشيط الحساب - {{company_name}}', 'تهنئة !<br>مرحبا <b>{{user_username}}</b>, لقد سجلت بنجاح على <i>{{company_name}}</i>.<br> لتفعيل حسابك، يرجى تأكيد تسجيلك.<br><a href=\"{{user_activation_code}}\" target=\"_blank\">تأكيد التسجيل</a>', 'user|company'),
(109, 'send_activate_customer.tpl', 'english', 'Account Activation - {{company_name}}', 'Congratulation !<br>Hi <b>{{user_username}}</b>, you have successfully registered on the <i>{{company_name}}</i>.<br>To activate your account, please confirm your registration.<br><br><p>Username :<b>{{user_username}}</b><br>Password :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">Confirm registration</a>', 'user|company'),
(110, 'send_activate_customer.tpl', 'french', 'Activation du compte - {{company_name}}', 'Félicitation !<br>Salut <b>{{user_username}}</b>, Vous avez enregistré avec succès sur le <i>{{company_name}}</i>.<br>Pour activer votre compte, veuillez confirmer votre inscription.<br><br><p>Nom d\'utilisateur :<b>{{user_username}}</b><br>Mot de passe : :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">Confirmer l\'inscription</a>', 'user|company'),
(111, 'send_activate_customer.tpl', 'spanish', 'activación de cuenta - {{company_name}}', 'Enhorabuena !<br>Hola <b>{{user_username}}</b> , has registrado correctamente en el <i>{{company_name}}</i> . <br> Para activar su cuenta, confirme su registro.<br><br><p>Nombre de usuario :<b>{{user_username}}</b><br>Contraseña :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">Confirmar registro</a>', 'user|company'),
(112, 'send_activate_customer.tpl', 'turkish', 'Hesap Aktivasyonu - {{company_name}}', 'Tebrikler!<br>Merhaba, <b>{{user_username}}</b> , başarıyla <i>{{company_name}}</i> kayıt yaptın. <br> Hesabınızı etkinleştirmek için lütfen kayıt işleminizi onaylayın.<br><br><p>Kullanıcı adı :<b>{{user_username}}</b><br>Parola :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">Kaydı onayla</a>', 'user|company'),
(113, 'send_activate_customer.tpl', 'russian', 'Активация аккаунта - {{company_name}}', 'Поздравляем!<br>Привет <b>{{user_username}}</b> , вы успешно зарегистрировались на <i>{{company_name}}</i> . <br> Чтобы активировать свою учетную запись, пожалуйста, подтвердите свою регистрацию.<br><br><p>Имя пользователя :<b>{{user_username}}</b><br>пароль :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">Подтверждение регистрации</a>', 'user|company'),
(114, 'send_activate_customer.tpl', 'romanian', 'Activare cont - {{company_name}}', 'Felicitari !<br>Bună <b>{{user_username}}</b>, v-ați înregistrat cu succes pe <i>{{company_name}}</i>.<br>Pentru a vă activa contul, vă rugăm să confirmați înregistrarea.<br><br><p>Nume de utilizator :<b>{{user_username}}</b><br>Parola :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">Confirmați înregistrarea</a>', 'user|company'),
(115, 'send_activate_customer.tpl', 'german', 'Account Aktivierung - {{company_name}}', 'Herzlichen Glückwunsch!<br>Hallo {{user_username}} Du hast dich erfolgreich registriert<br><br><p>Benutzername :<b>{{user_username}}</b><br>Passwort :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">Registrierung bestätigen</a>', 'user|company'),
(116, 'send_activate_customer.tpl', 'italian', 'attivazione dell&#39;account - {{company_name}}', 'Congratulazioni!<br>Ciao {{user_username}} , sei stato registrato con successo nel sito<br><br><p>Nome utente :<b>{{user_username}}</b><br>Parola d&#39;ordine :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">Conferma la registrazione</a>', 'user|company'),
(117, 'send_activate_customer.tpl', 'arabic', 'تنشيط الحساب - {{company_name}}', 'تهنئة !<br>مرحبا <b>{{user_username}}</b>, لقد سجلت بنجاح على <i>{{company_name}}</i>.<br> لتفعيل حسابك، يرجى تأكيد تسجيلك.<br><br><p>إسم العضوية :<b>{{user_username}}</b><br>كلمه المرور: :<b>{{user_password}}</b></p><br><a href=\"{{user_activation_code}}\" target=\"_blank\">تأكيد التسجيل</a>', 'user|company'),
(118, 'send_file.tpl', 'english', 'File from {{company_name}}', '', 'file|company'),
(119, 'send_file.tpl', 'french', 'Fichier de {{company_name}} ', '', 'file|company'),
(120, 'send_file.tpl', 'spanish', 'Archivo de {{company_name}} ', '', 'file|company'),
(121, 'send_file.tpl', 'turkish', 'Dosyasından {{company_name}} ', '', 'file|company'),
(122, 'send_file.tpl', 'russian', 'Файл из {{company_name}} ', '', 'file|company'),
(123, 'send_file.tpl', 'romanian', 'Fișier la {{company_name}}', '', 'file|company'),
(124, 'send_file.tpl', 'german', 'Datei von {{company_name}} ', '', 'file|company'),
(125, 'send_file.tpl', 'italian', 'File da {{company_name}} ', '', 'file|company'),
(126, 'send_file.tpl', 'arabic', 'ملف من {{company_name}} ', '', 'file|company'),
(127, 'send_purchase_order_to_customer.tpl', 'english', 'Invoice PDF from {{company_name}}', '<p>Greetings !<br>You have received an purchase order from <strong>{{company_name}}</strong>.<br>A PDF file is attached.</p>', 'purchase order|customer|company'),
(128, 'send_purchase_order_to_customer.tpl', 'french', 'Bon de commande PDF de {{company_name}}', '<p>Salutations! <br> Vous avez reçu une commande dachat de <strong> {{company_name}} </ strong>. <br> Un fichier PDF est joint. </ p></strong></p>', 'purchase order|customer|company'),
(129, 'send_purchase_order_to_customer.tpl', 'spanish', 'PDF de la orden de compra de {{company_name}}', '<p>Saludos! <br> Recibió una orden de compra de <strong> {{company_name}} </ strong>. <br> Se adjunta un archivo PDF. </ p></strong></p>', 'purchase order|customer|company'),
(130, 'send_purchase_order_to_customer.tpl', 'turkish', '{{Company_name}} sitesinden Sipariş PDF i Satın Alın', '<p>Selamlar! <br> <strong> {{company_name}} </ strong> dan bir satın alma siparişi aldınız. <br> Bir PDF dosyası ekli. </ p></strong></p>', 'purchase order|customer|company'),
(131, 'send_purchase_order_to_customer.tpl', 'russian', 'PDF-документ заказа на покупку от {{company_name}}', '<p>Приветствую! <br> Вы получили заказ на покупку от <strong> {{company_name}} </ strong>. <br> PDF-файл прилагается. </ p></strong></p>', 'purchase order|customer|company'),
(132, 'send_purchase_order_to_customer.tpl', 'romanian', 'Comanda de achiziție PDF de la {{company_name}}', '<p>Salutări! <br> Ați primit o comandă de achiziție de la <strong> {{company_name}} </ strong>. <br> Un fișier PDF este atașat. </ p></strong></p>', 'purchase order|customer|company'),
(133, 'send_purchase_order_to_customer.tpl', 'german', 'Bestell-PDF von {{company_name}}', '<p>Grüße! <br> Sie haben eine Bestellung von <strong> {{company_name}} </ strong> erhalten. <br> Eine PDF-Datei ist beigefügt. </ p></strong></p>', 'purchase order|customer|company'),
(134, 'send_purchase_order_to_customer.tpl', 'italian', ' PDF dell ordine d acquisto da {{company_name}}', '<p>Saluti! <br> Hai ricevuto un ordine di acquisto da <strong> {{company_name}} </ strong>. <br> È allegato un file PDF. </ p></strong></p>', 'purchase order|customer|company'),
(135, 'send_purchase_order_to_customer.tpl', 'arabic', 'أمر الشراء PDF من {{company_name}}', '<p>تحياتي! <br> لقد تلقيت أمر شراء من <strong> {{company_name}} </ strong>. <br> ملف PDF مرفق. </ p></strong></p>', 'purchase order|customer|company');

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE `estimates` (
  `id` int(11) NOT NULL,
  `reference` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `title` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Invoice',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Draft',
  `bill_to_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `terms` text COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `discount_type` tinyint(1) NOT NULL DEFAULT '1',
  `subtotal` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `global_discount` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_discount` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total_tax` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `count` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `custom_field1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field4` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimates_items`
--

CREATE TABLE `estimates_items` (
  `id` int(11) NOT NULL,
  `estimate_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `unit_price` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `tax_type` tinyint(1) NOT NULL DEFAULT '1',
  `tax` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `discount_type` tinyint(1) NOT NULL DEFAULT '1',
  `discount` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(25,4) NOT NULL DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimates_taxes`
--

CREATE TABLE `estimates_taxes` (
  `estimate_id` int(11) NOT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `is_conditional` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `reference` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unpaid',
  `amount` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `tax_id` int(11) DEFAULT NULL,
  `tax_type` tinyint(1) NOT NULL DEFAULT '0',
  `tax_value` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `tax_total` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total_due` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` date DEFAULT NULL,
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `attachments` text COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_categories`
--

CREATE TABLE `expenses_categories` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `expenses_categories`
--

INSERT INTO `expenses_categories` (`id`, `type`, `label`, `is_default`) VALUES
(1, 'Utilities', 'Electricity', 1),
(2, 'Utilities', 'Gas', 0),
(3, 'Utilities', 'Water', 0),
(4, 'Utilities', 'Phone', 0),
(5, 'Utilities', 'Internet', 0),
(6, 'Utilities', 'Other utilities', 0),
(7, 'Supplies', 'Stationery', 0),
(8, 'Supplies', 'Other consumables', 0),
(9, 'Maintenance and repair', 'Repair and maintenance of headquarters', 0),
(10, 'Maintenance and repair', 'Equipment repairs', 0),
(11, 'Maintenance and repair', 'Other', 0),
(12, 'Services', 'Accountancy', 0),
(13, 'Services', 'Legally', 0),
(14, 'Services', 'Consulting', 0),
(15, 'Services', 'Fees', 0),
(16, 'Services', 'Online service subscriptions', 0),
(17, 'Services', 'Transport', 0),
(18, 'Services', 'Other services', 0),
(19, 'Services', 'Courier', 0),
(20, 'Rents', 'Rental of buildings', 0),
(21, 'Rents', 'Car leasing', 0),
(22, 'Rents', 'Equipment rental', 0),
(23, 'Rents', 'Other rents', 0),
(24, 'Auto', 'Fuels', 0),
(25, 'Auto', 'Auto parts', 0),
(26, 'Auto', 'Car maintenance materials', 0),
(27, 'Auto', 'Car repair services', 0),
(28, 'Auto', 'Other', 0),
(29, 'HR', 'Wages', 0),
(30, 'HR', 'Tickets', 0),
(31, 'HR', 'Salary contributions', 0),
(32, 'HR', 'Other', 0),
(33, 'Insurance', 'Insurance and social protection', 0),
(34, 'Insurance', 'Life insurance', 0),
(35, 'Insurance', 'Private pension', 0),
(36, 'Insurance', 'RCA', 0),
(37, 'Insurance', 'Casco', 0),
(38, 'Insurance', 'Other insurance', 0),
(39, 'Taxes', 'VAT', 0),
(40, 'Taxes', 'Tax', 0),
(41, 'Taxes', 'Bank fees', 0),
(42, 'Taxes', 'Building tax', 0),
(43, 'Taxes', 'Key maps', 0),
(44, 'Taxes', 'Fines', 0),
(45, 'Taxes', 'Other taxes', 0),
(46, 'Advertisement', 'Commercials', 0),
(47, 'Advertisement', 'Promotional materials', 0),
(48, 'Advertisement', 'Announcements', 0),
(49, 'Advertisement', 'Online ads', 0),
(50, 'Advertisement', 'Other', 0),
(51, 'Protocol', 'Organized tables', 0),
(52, 'Protocol', 'Gifts', 0),
(53, 'Protocol', 'Gifts', 0),
(54, 'Protocol', 'Other protocol expenses', 0),
(55, 'Inventory items', 'Telephones', 0),
(56, 'Inventory items', 'Furniture', 0),
(57, 'Inventory items', 'IT equipment', 0),
(58, 'Inventory items', 'Other inventory items', 0),
(59, 'Fixed assets', 'Buildings', 0),
(60, 'Fixed assets', 'Lands', 0),
(61, 'Fixed assets', 'Machinery', 0),
(62, 'Fixed assets', 'Other fixed assets', 0),
(63, 'Other expenses', 'Reparation', 0),
(64, 'Other expenses', 'Raw materials', 0),
(65, 'Other expenses', 'Other raw materials', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expenses_payments`
--

CREATE TABLE `expenses_payments` (
  `id` int(11) NOT NULL,
  `expense_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `method` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'cash',
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'released'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `realpath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `folder` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_upload` datetime NOT NULL,
  `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` decimal(25,4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trash` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'Members', 'General User'),
(3, 'customer', 'Client'),
(4, 'supplier', 'Supplier'),
(5, 'superadmin', 'Super Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `initial_balance`
--

CREATE TABLE `initial_balance` (
  `id` int(11) NOT NULL,
  `account_number` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `dtp_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `crd_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '0 for inactive/1 for active ',
  `description` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `reference` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `title` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Invoice',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Draft',
  `gl_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_posted',
  `bill_to_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `terms` text COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `discount_type` tinyint(1) NOT NULL DEFAULT '1',
  `subtotal` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `global_discount` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_discount` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total_tax` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `count` int(11) NOT NULL DEFAULT '0',
  `total_due` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_date` date DEFAULT NULL,
  `estimate_id` int(11) DEFAULT NULL,
  `recurring_id` int(11) DEFAULT NULL,
  `double_currency` tinyint(1) NOT NULL DEFAULT '0',
  `rate` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `custom_field1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field4` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices_items`
--

CREATE TABLE `invoices_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `unit_price` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `tax_type` tinyint(1) NOT NULL DEFAULT '1',
  `tax` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `discount_type` tinyint(1) NOT NULL DEFAULT '1',
  `discount` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(25,4) NOT NULL DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices_taxes`
--

CREATE TABLE `invoices_taxes` (
  `invoice_id` int(11) NOT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `is_conditional` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount_type` tinyint(1) NOT NULL DEFAULT '1',
  `discount` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `tax_type` tinyint(1) NOT NULL DEFAULT '1',
  `tax` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `category` int(11) DEFAULT NULL,
  `unit` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'U',
  `custom_field1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_field4` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items_categories`
--

CREATE TABLE `items_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items_prices`
--

CREATE TABLE `items_prices` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `je_current`
--

CREATE TABLE `je_current` (
  `id` int(11) NOT NULL,
  `doc_name` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `journal_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `acc_debt` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '0 for inactive/1 for active ',
  `acc_crdt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `explanations` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gl_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `param` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `method` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'cash',
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `credit_card` text COLLATE utf8_unicode_ci,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'released'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `biller_id` int(11) NOT NULL,
  `progress` int(3) NOT NULL,
  `billing_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rate` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `estimated_hours` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'progress',
  `date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `members` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects_tasks`
--

CREATE TABLE `projects_tasks` (
  `id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hour_rate` decimal(25,4) NOT NULL,
  `date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `priority` int(1) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `attachments` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `reference` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `title` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Invoice',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Draft',
  `supplier_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `subtotal` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `count` int(11) NOT NULL DEFAULT '0',
  `total_due` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_date` date DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `unit_price` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(25,4) NOT NULL DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payment`
--

CREATE TABLE `purchase_payment` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `method` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'cash',
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `credit_card` text COLLATE utf8_unicode_ci,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'released'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `date` date NOT NULL,
  `cash_in` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_out` decimal(10,2) NOT NULL DEFAULT '0.00',
  `method` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'cash',
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `credit_card` text COLLATE utf8_unicode_ci,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receipts_purchase`
--

CREATE TABLE `receipts_purchase` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `method` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'cash',
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `credit_card` text COLLATE utf8_unicode_ci,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recurring_invoices`
--

CREATE TABLE `recurring_invoices` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `next_date` date DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `occurence` int(4) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `bill_to_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recurring_invoices_items`
--

CREATE TABLE `recurring_invoices_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `recurring_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `skip` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `configuration` text COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `param` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` text COLLATE utf8_unicode_ci,
  `address2` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vat_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `custom_field1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_field2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_field3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_field4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `label`, `value`, `type`, `is_default`, `can_delete`) VALUES
(1, 'lang:no_tax', '0.00', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(1) NOT NULL,
  `complete` int(1) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_due` date DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `attachments` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE `uom` (
  `id` int(11) NOT NULL,
  `unit_of_measurement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`id`, `unit_of_measurement`, `description`, `status`) VALUES
(1, 'asdas', 'asdasd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'admin', '$2y$08$bd1unGaVxfiXu4pEimKFY.Q7YYa4sFlzAiOV.khi9TbwOHJBF74XO', '', 'admin@admin.com', '', NULL, NULL, '3o6rg9FOxhHe31KAtJaLG.', 1268889823, 1558525307, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(2, '::1', 'dasdas', '$2y$08$erOYu5KPo9KJf9Oe3JG1IeC2B.GYpD8.YaTs2AEWGkuw6p8ErCfyy', NULL, 'newuser@user.com', '8cf490eff8eda95e179c743590be9c1f54deaff0', NULL, NULL, NULL, 1558526647, NULL, 0, 'new', 'user', 'dasd', '+15565022063');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 5),
(4, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biller`
--
ALTER TABLE `biller`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_attempts`
--
ALTER TABLE `chat_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to` (`to`),
  ADD KEY `from` (`from`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biller_id` (`biller_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_to_id` (`bill_to_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `estimates_items`
--
ALTER TABLE `estimates_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estimates_items_ibfk_1` (`estimate_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `estimates_taxes`
--
ALTER TABLE `estimates_taxes`
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `tax_rate_id` (`tax_rate_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `expenses_categories`
--
ALTER TABLE `expenses_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses_payments`
--
ALTER TABLE `expenses_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_id` (`expense_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `initial_balance`
--
ALTER TABLE `initial_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_to_id` (`bill_to_id`),
  ADD KEY `estimate_id` (`estimate_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `invoices_items`
--
ALTER TABLE `invoices_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_items_ibfk_1` (`invoice_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `invoices_taxes`
--
ALTER TABLE `invoices_taxes`
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `tax_rate_id` (`tax_rate_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `items_categories`
--
ALTER TABLE `items_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_prices`
--
ALTER TABLE `items_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `je_current`
--
ALTER TABLE `je_current`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `biller_id` (`biller_id`);

--
-- Indexes for table `projects_tasks`
--
ALTER TABLE `projects_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_payment`
--
ALTER TABLE `purchase_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipts_purchase`
--
ALTER TABLE `receipts_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recurring_invoices`
--
ALTER TABLE `recurring_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_to_id` (`bill_to_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `recurring_invoices_items`
--
ALTER TABLE `recurring_invoices_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `recurring_id` (`recurring_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `uom`
--
ALTER TABLE `uom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biller`
--
ALTER TABLE `biller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_attempts`
--
ALTER TABLE `chat_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `estimates`
--
ALTER TABLE `estimates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimates_items`
--
ALTER TABLE `estimates_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_categories`
--
ALTER TABLE `expenses_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `expenses_payments`
--
ALTER TABLE `expenses_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `initial_balance`
--
ALTER TABLE `initial_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices_items`
--
ALTER TABLE `invoices_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items_categories`
--
ALTER TABLE `items_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items_prices`
--
ALTER TABLE `items_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `je_current`
--
ALTER TABLE `je_current`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects_tasks`
--
ALTER TABLE `projects_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_payment`
--
ALTER TABLE `purchase_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipts_purchase`
--
ALTER TABLE `receipts_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recurring_invoices`
--
ALTER TABLE `recurring_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recurring_invoices_items`
--
ALTER TABLE `recurring_invoices_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uom`
--
ALTER TABLE `uom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `biller`
--
ALTER TABLE `biller`
  ADD CONSTRAINT `biller_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `chat_attempts`
--
ALTER TABLE `chat_attempts`
  ADD CONSTRAINT `chat_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`from`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`biller_id`) REFERENCES `biller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contracts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `estimates`
--
ALTER TABLE `estimates`
  ADD CONSTRAINT `estimates_ibfk_1` FOREIGN KEY (`bill_to_id`) REFERENCES `biller` (`id`),
  ADD CONSTRAINT `estimates_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `estimates_items`
--
ALTER TABLE `estimates_items`
  ADD CONSTRAINT `estimates_items_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estimates_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `estimates_taxes`
--
ALTER TABLE `estimates_taxes`
  ADD CONSTRAINT `estimates_taxes_ibfk_1` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estimates_taxes_ibfk_2` FOREIGN KEY (`tax_rate_id`) REFERENCES `tax_rates` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `expenses_payments`
--
ALTER TABLE `expenses_payments`
  ADD CONSTRAINT `expenses_payments_ibfk_1` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`bill_to_id`) REFERENCES `biller` (`id`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `invoices_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `invoices_items`
--
ALTER TABLE `invoices_items`
  ADD CONSTRAINT `invoices_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `invoices_taxes`
--
ALTER TABLE `invoices_taxes`
  ADD CONSTRAINT `invoices_taxes_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_taxes_ibfk_2` FOREIGN KEY (`tax_rate_id`) REFERENCES `tax_rates` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category`) REFERENCES `items_categories` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `items_prices`
--
ALTER TABLE `items_prices`
  ADD CONSTRAINT `items_prices_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`biller_id`) REFERENCES `biller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects_tasks`
--
ALTER TABLE `projects_tasks`
  ADD CONSTRAINT `projects_tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_tasks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recurring_invoices`
--
ALTER TABLE `recurring_invoices`
  ADD CONSTRAINT `recurring_invoices_ibfk_1` FOREIGN KEY (`bill_to_id`) REFERENCES `biller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recurring_invoices_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `recurring_invoices_items`
--
ALTER TABLE `recurring_invoices_items`
  ADD CONSTRAINT `recurring_invoices_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `recurring_invoices_items_ibfk_2` FOREIGN KEY (`recurring_id`) REFERENCES `recurring_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
