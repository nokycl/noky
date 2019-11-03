-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2019 a las 23:03:43
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `noky`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attendances`
--

CREATE TABLE `attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `clock_in_time` datetime NOT NULL,
  `clock_out_time` datetime DEFAULT NULL,
  `clock_in_ip` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `clock_out_ip` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `working_from` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'office',
  `late` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `half_day` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attendance_settings`
--

CREATE TABLE `attendance_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `office_start_time` time NOT NULL,
  `office_end_time` time NOT NULL,
  `halfday_mark_time` time DEFAULT NULL,
  `late_mark_duration` tinyint(4) NOT NULL,
  `clockin_in_day` int(11) NOT NULL DEFAULT 1,
  `employee_clock_in_out` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `office_open_days` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[1,2,3,4,5]',
  `ip_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `radius` int(11) DEFAULT NULL,
  `radius_check` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `ip_check` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `attendance_settings`
--

INSERT INTO `attendance_settings` (`id`, `company_id`, `office_start_time`, `office_end_time`, `halfday_mark_time`, `late_mark_duration`, `clockin_in_day`, `employee_clock_in_out`, `office_open_days`, `ip_address`, `radius`, `radius_check`, `ip_check`, `created_at`, `updated_at`) VALUES
(1, NULL, '09:00:00', '18:00:00', NULL, 20, 2, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', '2019-10-27 06:40:19', '2019-10-27 06:40:19'),
(2, 1, '09:00:00', '18:00:00', NULL, 20, 1, 'yes', '[1,2,3,4,5]', NULL, NULL, 'no', 'no', '2019-10-27 06:47:06', '2019-10-27 06:47:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_contacts`
--

CREATE TABLE `client_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `contact_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_details`
--

CREATE TABLE `client_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gst_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_background` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `package_type` enum('monthly','annual') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'monthly',
  `timezone` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Asia/Kolkata',
  `date_format` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'd-m-Y',
  `time_format` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'h:i a',
  `week_start` int(11) NOT NULL DEFAULT 1,
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `latitude` decimal(10,8) NOT NULL DEFAULT 26.91243360,
  `longitude` decimal(11,8) NOT NULL DEFAULT 75.78727090,
  `leaves_start_from` enum('joining_date','year_start') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'joining_date',
  `active_theme` enum('default','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `status` enum('active','inactive','license_expired') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `task_self` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `last_updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `licence_expire_on` date DEFAULT NULL,
  `rounded_theme` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversation`
--

CREATE TABLE `conversation` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_one` int(10) UNSIGNED NOT NULL,
  `user_two` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversation_reply`
--

CREATE TABLE `conversation_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `conversation_id` int(10) UNSIGNED NOT NULL,
  `reply` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `is_visible` tinyint(4) NOT NULL,
  `iso_alpha2` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `iso_alpha3` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `iso_numeric` int(10) UNSIGNED NOT NULL,
  `currency_code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `currency_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `flag` varchar(6) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `is_visible`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `currency_code`, `currency_name`, `currency_symbol`, `flag`) VALUES
(1, 'Aruba', 1, 'AW', 'AB', 0, 'AWG', 'Guilder', 'ƒ', 'aw.png'),
(2, 'Afghanistan', 1, 'AF', 'AF', 0, 'AFN', 'Afghani', '؋', 'af.png'),
(3, 'Angola', 1, 'AO', 'AG', 0, 'AOA', 'Kwanza', 'Kz', 'ao.png'),
(4, 'Anguilla', 1, 'AI', 'AI', 0, 'XCD', 'Dollar', '$', 'ai.png'),
(5, 'Albania', 1, 'AL', 'AL', 0, 'ALL', 'Lek', 'Lek', 'al.png'),
(6, 'Andorra', 1, 'AD', 'AN', 0, 'EUR', 'Euro', '€', 'ad.png'),
(7, 'Netherlands Antilles', 1, 'AN', 'AN', 0, 'ANG', 'Guilder', 'ƒ', 'an.png'),
(8, 'United Arab Emirates', 1, 'AE', 'AR', 0, 'AED', 'Dirham', '', 'ae.png'),
(9, 'Argentina', 1, 'AR', 'AR', 0, 'ARS', 'Peso', '$', 'ar.png'),
(10, 'Armenia', 1, 'AM', 'AR', 0, 'AMD', 'Dram', '', 'am.png'),
(11, 'American Samoa', 1, 'AS', 'AS', 0, 'USD', 'Dollar', '$', 'as.png'),
(12, 'Antarctica', 1, 'AQ', 'AT', 0, '', '', '', 'aq.png'),
(13, 'French Southern territories', 1, 'TF', 'AT', 0, 'EUR', 'Euro  ', '€', 'tf.png'),
(14, 'Antigua and Barbuda', 1, 'AG', 'AT', 0, 'XCD', 'Dollar', '$', 'ag.png'),
(15, 'Australia', 1, 'AU', 'AU', 0, 'AUD', 'Dollar', '$', 'au.png'),
(16, 'Austria', 1, 'AT', 'AU', 0, 'EUR', 'Euro', '€', 'at.png'),
(17, 'Azerbaijan', 1, 'AZ', 'AZ', 0, 'AZN', 'Manat', 'ман', 'az.png'),
(18, 'Burundi', 1, 'BI', 'BD', 0, 'BIF', 'Franc', '', 'bi.png'),
(19, 'Belgium', 1, 'BE', 'BE', 0, 'EUR', 'Euro', '€', 'be.png'),
(20, 'Benin', 1, 'BJ', 'BE', 0, 'XOF', 'Franc', '', 'bj.png'),
(21, 'Burkina Faso', 1, 'BF', 'BF', 0, 'XOF', 'Franc', '', 'bf.png'),
(22, 'Bangladesh', 1, 'BD', 'BG', 0, 'BDT', 'Taka', '', 'bd.png'),
(23, 'Bulgaria', 1, 'BG', 'BG', 0, 'BGN', 'Lev', 'лв', 'bg.png'),
(24, 'Bahrain', 1, 'BH', 'BH', 0, 'BHD', 'Dinar', '', 'bh.png'),
(25, 'Bahamas', 1, 'BS', 'BH', 0, 'BSD', 'Dollar', '$', 'bs.png'),
(26, 'Bosnia and Herzegovina', 1, 'BA', 'BI', 0, 'BAM', 'Marka', 'KM', 'ba.png'),
(27, 'Belarus', 1, 'BY', 'BL', 0, 'BYR', 'Ruble', 'p.', 'by.png'),
(28, 'Belize', 1, 'BZ', 'BL', 0, 'BZD', 'Dollar', 'BZ$', 'bz.png'),
(29, 'Bermuda', 1, 'BM', 'BM', 0, 'BMD', 'Dollar', '$', 'bm.png'),
(30, 'Bolivia', 1, 'BO', 'BO', 0, 'BOB', 'Boliviano', '$b', 'bo.png'),
(31, 'Brazil', 1, 'BR', 'BR', 0, 'BRL', 'Real', 'R$', 'br.png'),
(32, 'Barbados', 1, 'BB', 'BR', 0, 'BBD', 'Dollar', '$', 'bb.png'),
(33, 'Brunei', 1, 'BN', 'BR', 0, 'BND', 'Dollar', '$', 'bn.png'),
(34, 'Bhutan', 1, 'BT', 'BT', 0, 'BTN', 'Ngultrum', '', 'bt.png'),
(35, 'Bouvet Island', 1, 'BV', 'BV', 0, 'NOK', 'Krone', 'kr', 'bv.png'),
(36, 'Botswana', 1, 'BW', 'BW', 0, 'BWP', 'Pula', 'P', 'bw.png'),
(37, 'Central African Republic', 1, 'CF', 'CA', 0, 'XAF', 'Franc', 'FCF', 'cf.png'),
(38, 'Canada', 1, 'CA', 'CA', 0, 'CAD', 'Dollar', '$', 'ca.png'),
(40, 'Switzerland', 1, 'CH', 'CH', 0, 'CHF', 'Franc', 'CHF', 'ch.png'),
(41, 'Chile', 1, 'CL', 'CH', 0, 'CLP', 'Peso', '', 'cl.png'),
(42, 'China', 1, 'CN', 'CH', 0, 'CNY', 'Yuan Renminbi', '¥', 'cn.png'),
(44, 'Cameroon', 1, 'CM', 'CM', 0, 'XAF', 'Franc', 'FCF', 'cm.png'),
(47, 'Cook Islands', 1, 'CK', 'CO', 0, 'NZD', 'Dollar', '$', 'ck.png'),
(48, 'Colombia', 1, 'CO', 'CO', 0, 'COP', 'Peso', '$', 'co.png'),
(49, 'Comoros', 1, 'KM', 'CO', 0, 'KMF', 'Franc', '', 'km.png'),
(50, 'Cape Verde', 1, 'CV', 'CP', 0, 'CVE', 'Escudo', '', 'cv.png'),
(51, 'Costa Rica', 1, 'CR', 'CR', 0, 'CRC', 'Colon', '₡', 'cr.png'),
(52, 'Cuba', 1, 'CU', 'CU', 0, 'CUP', 'Peso', '₱', 'cu.png'),
(53, 'Christmas Island', 1, 'CX', 'CX', 0, 'AUD', 'Dollar', '$', 'cx.png'),
(54, 'Cayman Islands', 1, 'KY', 'CY', 0, 'KYD', 'Dollar', '$', 'ky.png'),
(55, 'Cyprus', 1, 'CY', 'CY', 0, 'CYP', 'Pound', '', 'cy.png'),
(56, 'Czech Republic', 1, 'CZ', 'CZ', 0, 'CZK', 'Koruna', 'Kč', 'cz.png'),
(57, 'Germany', 1, 'DE', 'DE', 0, 'EUR', 'Euro', '€', 'de.png'),
(58, 'Djibouti', 1, 'DJ', 'DJ', 0, 'DJF', 'Franc', '', 'dj.png'),
(59, 'Dominica', 1, 'DM', 'DM', 0, 'XCD', 'Dollar', '$', 'dm.png'),
(60, 'Denmark', 1, 'DK', 'DN', 0, 'DKK', 'Krone', 'kr', 'dk.png'),
(61, 'Dominican Republic', 1, 'DO', 'DO', 0, 'DOP', 'Peso', 'RD$', 'do.png'),
(62, 'Algeria', 1, 'DZ', 'DZ', 0, 'DZD', 'Dinar', '', 'dz.png'),
(63, 'Ecuador', 1, 'EC', 'EC', 0, 'USD', 'Dollar', '$', 'ec.png'),
(64, 'Egypt', 1, 'EG', 'EG', 0, 'EGP', 'Pound', '£', 'eg.png'),
(65, 'Eritrea', 1, 'ER', 'ER', 0, 'ERN', 'Nakfa', 'Nfk', 'er.png'),
(66, 'Western Sahara', 1, 'EH', 'ES', 0, 'MAD', 'Dirham', '', 'eh.png'),
(67, 'Spain', 1, 'ES', 'ES', 0, 'EUR', 'Euro', '€', 'es.png'),
(68, 'Estonia', 1, 'EE', 'ES', 0, 'EEK', 'Kroon', 'kr', 'ee.png'),
(69, 'Ethiopia', 1, 'ET', 'ET', 0, 'ETB', 'Birr', '', 'et.png'),
(70, 'Finland', 1, 'FI', 'FI', 0, 'EUR', 'Euro', '€', 'fi.png'),
(72, 'Falkland Islands', 1, 'FK', 'FL', 0, 'FKP', 'Pound', '£', 'fk.png'),
(73, 'France', 1, 'FR', 'FR', 0, 'EUR', 'Euro', '€', 'fr.png'),
(74, 'Faroe Islands', 1, 'FO', 'FR', 0, 'DKK', 'Krone', 'kr', 'fo.png'),
(76, 'Gabon', 1, 'GA', 'GA', 0, 'XAF', 'Franc', 'FCF', 'ga.png'),
(77, 'United Kingdom', 1, 'GB', 'GB', 0, 'GBP', 'Pound', '£', 'gb.png'),
(78, 'Georgia', 1, 'GE', 'GE', 0, 'GEL', 'Lari', '', 'ge.png'),
(79, 'Ghana', 1, 'GH', 'GH', 0, 'GHC', 'Cedi', '¢', 'gh.png'),
(80, 'Gibraltar', 1, 'GI', 'GI', 0, 'GIP', 'Pound', '£', 'gi.png'),
(81, 'Guinea', 1, 'GN', 'GI', 0, 'GNF', 'Franc', '', 'gn.png'),
(82, 'Guadeloupe', 1, 'GP', 'GL', 0, 'EUR', 'Euro', '€', 'gp.png'),
(83, 'Gambia', 1, 'GM', 'GM', 0, 'GMD', 'Dalasi', 'D', 'gm.png'),
(84, 'Guinea-Bissau', 1, 'GW', 'GN', 0, 'XOF', 'Franc', '', 'gw.png'),
(85, 'Equatorial Guinea', 1, 'GQ', 'GN', 0, 'XAF', 'Franc', 'FCF', 'gq.png'),
(86, 'Greece', 1, 'GR', 'GR', 0, 'EUR', 'Euro', '€', 'gr.png'),
(87, 'Grenada', 1, 'GD', 'GR', 0, 'XCD', 'Dollar', '$', 'gd.png'),
(88, 'Greenland', 1, 'GL', 'GR', 0, 'DKK', 'Krone', 'kr', 'gl.png'),
(89, 'Guatemala', 1, 'GT', 'GT', 0, 'GTQ', 'Quetzal', 'Q', 'gt.png'),
(90, 'French Guiana', 1, 'GF', 'GU', 0, 'EUR', 'Euro', '€', 'gf.png'),
(91, 'Guam', 1, 'GU', 'GU', 0, 'USD', 'Dollar', '$', 'gu.png'),
(92, 'Guyana', 1, 'GY', 'GU', 0, 'GYD', 'Dollar', '$', 'gy.png'),
(93, 'Hong Kong', 1, 'HK', 'HK', 0, 'HKD', 'Dollar', '$', 'hk.png'),
(95, 'Honduras', 1, 'HN', 'HN', 0, 'HNL', 'Lempira', 'L', 'hn.png'),
(96, 'Croatia', 1, 'HR', 'HR', 0, 'HRK', 'Kuna', 'kn', 'hr.png'),
(97, 'Haiti', 1, 'HT', 'HT', 0, 'HTG', 'Gourde', 'G', 'ht.png'),
(98, 'Hungary', 1, 'HU', 'HU', 0, 'HUF', 'Forint', 'Ft', 'hu.png'),
(99, 'Indonesia', 1, 'ID', 'ID', 0, 'IDR', 'Rupiah', 'Rp', 'id.png'),
(100, 'India', 1, 'IN', 'IN', 0, 'INR', 'Rupee', '₹', 'in.png'),
(101, 'British Indian Ocean Territory', 1, 'IO', 'IO', 0, 'USD', 'Dollar', '$', 'io.png'),
(102, 'Ireland', 1, 'IE', 'IR', 0, 'EUR', 'Euro', '€', 'ie.png'),
(103, 'Iran', 1, 'IR', 'IR', 0, 'IRR', 'Rial', '﷼', 'ir.png'),
(104, 'Iraq', 1, 'IQ', 'IR', 0, 'IQD', 'Dinar', '', 'iq.png'),
(105, 'Iceland', 1, 'IS', 'IS', 0, 'ISK', 'Krona', 'kr', 'is.png'),
(106, 'Israel', 1, 'IL', 'IS', 0, 'ILS', 'Shekel', '₪', 'il.png'),
(107, 'Italy', 1, 'IT', 'IT', 0, 'EUR', 'Euro', '€', 'it.png'),
(108, 'Jamaica', 1, 'JM', 'JA', 0, 'JMD', 'Dollar', '$', 'jm.png'),
(109, 'Jordan', 1, 'JO', 'JO', 0, 'JOD', 'Dinar', '', 'jo.png'),
(110, 'Japan', 1, 'JP', 'JP', 0, 'JPY', 'Yen', '¥', 'jp.png'),
(112, 'Kenya', 1, 'KE', 'KE', 0, 'KES', 'Shilling', '', 'ke.png'),
(113, 'Kyrgyzstan', 1, 'KG', 'KG', 0, 'KGS', 'Som', 'лв', 'kg.png'),
(114, 'Cambodia', 1, 'KH', 'KH', 0, 'KHR', 'Riels', '៛', 'kh.png'),
(115, 'Kiribati', 1, 'KI', 'KI', 0, 'AUD', 'Dollar', '$', 'ki.png'),
(116, 'Saint Kitts and Nevis', 1, 'KN', 'KN', 0, 'XCD', 'Dollar', '$', 'kn.png'),
(117, 'South Korea', 1, 'KR', 'KO', 0, 'KRW', 'Won', '₩', 'kr.png'),
(118, 'Kuwait', 1, 'KW', 'KW', 0, 'KWD', 'Dinar', '', 'kw.png'),
(119, 'Laos', 1, 'LA', 'LA', 0, 'LAK', 'Kip', '₭', 'la.png'),
(120, 'Lebanon', 1, 'LB', 'LB', 0, 'LBP', 'Pound', '£', 'lb.png'),
(121, 'Liberia', 1, 'LR', 'LB', 0, 'LRD', 'Dollar', '$', 'lr.png'),
(123, 'Saint Lucia', 1, 'LC', 'LC', 0, 'XCD', 'Dollar', '$', 'lc.png'),
(124, 'Liechtenstein', 1, 'LI', 'LI', 0, 'CHF', 'Franc', 'CHF', 'li.png'),
(125, 'Sri Lanka', 1, 'LK', 'LK', 0, 'LKR', 'Rupee', '₨', 'lk.png'),
(126, 'Lesotho', 1, 'LS', 'LS', 0, 'LSL', 'Loti', 'L', 'ls.png'),
(127, 'Lithuania', 1, 'LT', 'LT', 0, 'LTL', 'Litas', 'Lt', 'lt.png'),
(128, 'Luxembourg', 1, 'LU', 'LU', 0, 'EUR', 'Euro', '€', 'lu.png'),
(129, 'Latvia', 1, 'LV', 'LV', 0, 'LVL', 'Lat', 'Ls', 'lv.png'),
(130, 'Macao', 1, 'MO', 'MA', 0, 'MOP', 'Pataca', 'MOP', 'mo.png'),
(131, 'Morocco', 1, 'MA', 'MA', 0, 'MAD', 'Dirham', '', 'ma.png'),
(132, 'Monaco', 1, 'MC', 'MC', 0, 'EUR', 'Euro', '€', 'mc.png'),
(133, 'Moldova', 1, 'MD', 'MD', 0, 'MDL', 'Leu', '', 'md.png'),
(134, 'Madagascar', 1, 'MG', 'MD', 0, 'MGA', 'Ariary', '', 'mg.png'),
(135, 'Maldives', 1, 'MV', 'MD', 0, 'MVR', 'Rufiyaa', 'Rf', 'mv.png'),
(136, 'Mexico', 1, 'MX', 'ME', 0, 'MXN', 'Peso', '$', 'mx.png'),
(137, 'Marshall Islands', 1, 'MH', 'MH', 0, 'USD', 'Dollar', '$', 'mh.png'),
(138, 'Macedonia', 1, 'MK', 'MK', 0, 'MKD', 'Denar', 'ден', 'mk.png'),
(139, 'Mali', 1, 'ML', 'ML', 0, 'XOF', 'Franc', '', 'ml.png'),
(140, 'Malta', 1, 'MT', 'ML', 0, 'MTL', 'Lira', '', 'mt.png'),
(141, 'Myanmar', 1, 'MM', 'MM', 0, 'MMK', 'Kyat', 'K', 'mm.png'),
(142, 'Mongolia', 1, 'MN', 'MN', 0, 'MNT', 'Tugrik', '₮', 'mn.png'),
(143, 'Northern Mariana Islands', 1, 'MP', 'MN', 0, 'USD', 'Dollar', '$', 'mp.png'),
(144, 'Mozambique', 1, 'MZ', 'MO', 0, 'MZN', 'Meticail', 'MT', 'mz.png'),
(145, 'Mauritania', 1, 'MR', 'MR', 0, 'MRO', 'Ouguiya', 'UM', 'mr.png'),
(146, 'Montserrat', 1, 'MS', 'MS', 0, 'XCD', 'Dollar', '$', 'ms.png'),
(147, 'Martinique', 1, 'MQ', 'MT', 0, 'EUR', 'Euro', '€', 'mq.png'),
(148, 'Mauritius', 1, 'MU', 'MU', 0, 'MUR', 'Rupee', '₨', 'mu.png'),
(149, 'Malawi', 1, 'MW', 'MW', 0, 'MWK', 'Kwacha', 'MK', 'mw.png'),
(150, 'Malaysia', 1, 'MY', 'MY', 0, 'MYR', 'Ringgit', 'RM', 'my.png'),
(151, 'Mayotte', 1, 'YT', 'MY', 0, 'EUR', 'Euro', '€', 'yt.png'),
(152, 'Namibia', 1, 'NA', 'NA', 0, 'NAD', 'Dollar', '$', 'na.png'),
(153, 'New Caledonia', 1, 'NC', 'NC', 0, 'XPF', 'Franc', '', 'nc.png'),
(154, 'Niger', 1, 'NE', 'NE', 0, 'XOF', 'Franc', '', 'ne.png'),
(155, 'Norfolk Island', 1, 'NF', 'NF', 0, 'AUD', 'Dollar', '$', 'nf.png'),
(156, 'Nigeria', 1, 'NG', 'NG', 0, 'NGN', 'Naira', '₦', 'ng.png'),
(157, 'Nicaragua', 1, 'NI', 'NI', 0, 'NIO', 'Cordoba', 'C$', 'ni.png'),
(158, 'Niue', 1, 'NU', 'NI', 0, 'NZD', 'Dollar', '$', 'nu.png'),
(159, 'Netherlands', 1, 'NL', 'NL', 0, 'EUR', 'Euro', '€', 'nl.png'),
(160, 'Norway', 1, 'NO', 'NO', 0, 'NOK', 'Krone', 'kr', 'no.png'),
(161, 'Nepal', 1, 'NP', 'NP', 0, 'NPR', 'Rupee', '₨', 'np.png'),
(162, 'Nauru', 1, 'NR', 'NR', 0, 'AUD', 'Dollar', '$', 'nr.png'),
(163, 'New Zealand', 1, 'NZ', 'NZ', 0, 'NZD', 'Dollar', '$', 'nz.png'),
(164, 'Oman', 1, 'OM', 'OM', 0, 'OMR', 'Rial', '﷼', 'om.png'),
(165, 'Pakistan', 1, 'PK', 'PA', 0, 'PKR', 'Rupee', '₨', 'pk.png'),
(166, 'Panama', 1, 'PA', 'PA', 0, 'PAB', 'Balboa', 'B/.', 'pa.png'),
(167, 'Pitcairn', 1, 'PN', 'PC', 0, 'NZD', 'Dollar', '$', 'pn.png'),
(168, 'Peru', 1, 'PE', 'PE', 0, 'PEN', 'Sol', 'S/.', 'pe.png'),
(169, 'Philippines', 1, 'PH', 'PH', 0, 'PHP', 'Peso', 'Php', 'ph.png'),
(170, 'Palau', 1, 'PW', 'PL', 0, 'USD', 'Dollar', '$', 'pw.png'),
(171, 'Papua New Guinea', 1, 'PG', 'PN', 0, 'PGK', 'Kina', '', 'pg.png'),
(172, 'Poland', 1, 'PL', 'PO', 0, 'PLN', 'Zloty', 'zł', 'pl.png'),
(173, 'Puerto Rico', 1, 'PR', 'PR', 0, 'USD', 'Dollar', '$', 'pr.png'),
(174, 'North Korea', 1, 'KP', 'PR', 0, 'KPW', 'Won', '₩', 'kp.png'),
(175, 'Portugal', 1, 'PT', 'PR', 0, 'EUR', 'Euro', '€', 'pt.png'),
(176, 'Paraguay', 1, 'PY', 'PR', 0, 'PYG', 'Guarani', 'Gs', 'py.png'),
(178, 'French Polynesia', 1, 'PF', 'PY', 0, 'XPF', 'Franc', '', 'pf.png'),
(179, 'Qatar', 1, 'QA', 'QA', 0, 'QAR', 'Rial', '﷼', 'qa.png'),
(181, 'Romania', 1, 'RO', 'RO', 0, 'RON', 'Leu', 'lei', 'ro.png'),
(183, 'Rwanda', 1, 'RW', 'RW', 0, 'RWF', 'Franc', '', 'rw.png'),
(184, 'Saudi Arabia', 1, 'SA', 'SA', 0, 'SAR', 'Rial', '﷼', 'sa.png'),
(185, 'Sudan', 1, 'SD', 'SD', 0, 'SDD', 'Dinar', '', 'sd.png'),
(186, 'Senegal', 1, 'SN', 'SE', 0, 'XOF', 'Franc', '', 'sn.png'),
(187, 'Singapore', 1, 'SG', 'SG', 0, 'SGD', 'Dollar', '$', 'sg.png'),
(189, 'Saint Helena', 1, 'SH', 'SH', 0, 'SHP', 'Pound', '£', 'sh.png'),
(190, 'Svalbard and Jan Mayen', 1, 'SJ', 'SJ', 0, 'NOK', 'Krone', 'kr', 'sj.png'),
(191, 'Solomon Islands', 1, 'SB', 'SL', 0, 'SBD', 'Dollar', '$', 'sb.png'),
(192, 'Sierra Leone', 1, 'SL', 'SL', 0, 'SLL', 'Leone', 'Le', 'sl.png'),
(193, 'El Salvador', 1, 'SV', 'SL', 0, 'SVC', 'Colone', '$', 'sv.png'),
(194, 'San Marino', 1, 'SM', 'SM', 0, 'EUR', 'Euro', '€', 'sm.png'),
(195, 'Somalia', 1, 'SO', 'SO', 0, 'SOS', 'Shilling', 'S', 'so.png'),
(196, 'Saint Pierre and Miquelon', 1, 'PM', 'SP', 0, 'EUR', 'Euro', '€', 'pm.png'),
(197, 'Sao Tome and Principe', 1, 'ST', 'ST', 0, 'STD', 'Dobra', 'Db', 'st.png'),
(198, 'Suriname', 1, 'SR', 'SU', 0, 'SRD', 'Dollar', '$', 'sr.png'),
(199, 'Slovakia', 1, 'SK', 'SV', 0, 'SKK', 'Koruna', 'Sk', 'sk.png'),
(200, 'Slovenia', 1, 'SI', 'SV', 0, 'EUR', 'Euro', '€', 'si.png'),
(201, 'Sweden', 1, 'SE', 'SW', 0, 'SEK', 'Krona', 'kr', 'se.png'),
(202, 'Swaziland', 1, 'SZ', 'SW', 0, 'SZL', 'Lilangeni', '', 'sz.png'),
(203, 'Seychelles', 1, 'SC', 'SY', 0, 'SCR', 'Rupee', '₨', 'sc.png'),
(204, 'Syria', 1, 'SY', 'SY', 0, 'SYP', 'Pound', '£', 'sy.png'),
(205, 'Turks and Caicos Islands', 1, 'TC', 'TC', 0, 'USD', 'Dollar', '$', 'tc.png'),
(206, 'Chad', 1, 'TD', 'TC', 0, 'XAF', 'Franc', '', 'td.png'),
(207, 'Togo', 1, 'TG', 'TG', 0, 'XOF', 'Franc', '', 'tg.png'),
(208, 'Thailand', 1, 'TH', 'TH', 0, 'THB', 'Baht', '฿', 'th.png'),
(209, 'Tajikistan', 1, 'TJ', 'TJ', 0, 'TJS', 'Somoni', '', 'tj.png'),
(210, 'Tokelau', 1, 'TK', 'TK', 0, 'NZD', 'Dollar', '$', 'tk.png'),
(211, 'Turkmenistan', 1, 'TM', 'TK', 0, 'TMM', 'Manat', 'm', 'tm.png'),
(212, 'East Timor', 1, 'TL', 'TL', 0, 'USD', 'Dollar', '$', 'tl.png'),
(213, 'Tonga', 1, 'TO', 'TO', 0, 'TOP', 'Pa\"anga', 'T$', 'to.png'),
(214, 'Trinidad and Tobago', 1, 'TT', 'TT', 0, 'TTD', 'Dollar', 'TT$', 'tt.png'),
(215, 'Tunisia', 1, 'TN', 'TU', 0, 'TND', 'Dinar', '', 'tn.png'),
(216, 'Turkey', 1, 'TR', 'TU', 0, 'TRY', 'Lira', 'YTL', 'tr.png'),
(217, 'Tuvalu', 1, 'TV', 'TU', 0, 'AUD', 'Dollar', '$', 'tv.png'),
(218, 'Taiwan', 1, 'TW', 'TW', 0, 'TWD', 'Dollar', 'NT$', 'tw.png'),
(219, 'Tanzania', 1, 'TZ', 'TZ', 0, 'TZS', 'Shilling', '', 'tz.png'),
(220, 'Uganda', 1, 'UG', 'UG', 0, 'UGX', 'Shilling', '', 'ug.png'),
(221, 'Ukraine', 1, 'UA', 'UK', 0, 'UAH', 'Hryvnia', '₴', 'ua.png'),
(223, 'Uruguay', 1, 'UY', 'UR', 0, 'UYU', 'Peso', '$U', 'uy.png'),
(224, 'United States', 1, 'US', 'US', 0, 'USD', 'Dollar', '$', 'us.png'),
(225, 'Uzbekistan', 1, 'UZ', 'UZ', 0, 'UZS', 'Som', 'лв', 'uz.png'),
(228, 'Venezuela', 1, 'VE', 'VE', 0, 'VEF', 'Bolivar', 'Bs', 've.png'),
(231, 'Vietnam', 1, 'VN', 'VN', 0, 'VND', 'Dong', '₫', 'vn.png'),
(232, 'Vanuatu', 1, 'VU', 'VU', 0, 'VUV', 'Vatu', 'Vt', 'vu.png'),
(233, 'Wallis and Futuna', 1, 'WF', 'WL', 0, 'XPF', 'Franc', '', 'wf.png'),
(234, 'Samoa', 1, 'WS', 'WS', 0, 'WST', 'Tala', 'WS$', 'ws.png'),
(235, 'Yemen', 1, 'YE', 'YE', 0, 'YER', 'Rial', '﷼', 'ye.png'),
(237, 'South Africa', 1, 'ZA', 'ZA', 0, 'ZAR', 'Rand', 'R', 'za.png'),
(238, 'Zambia', 1, 'ZM', 'ZM', 0, 'ZMK', 'Kwacha', 'ZK', 'zm.png'),
(239, 'Zimbabwe', 1, 'ZW', 'ZW', 0, 'ZWD', 'Dollar', 'Z$', 'zw.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit_notes`
--

CREATE TABLE `credit_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `cn_number` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `discount` double NOT NULL DEFAULT 0,
  `discount_type` enum('percent','fixed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'percent',
  `sub_total` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('paid','unpaid') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unpaid',
  `recurring` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `billing_frequency` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `billing_cycle` int(11) DEFAULT NULL,
  `file` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_original_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit_note_items`
--

CREATE TABLE `credit_note_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `credit_note_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `quantity` int(11) NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `exchange_rate` double DEFAULT NULL,
  `is_cryptocurrency` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `usd_price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `currencies`
--

INSERT INTO `currencies` (`id`, `company_id`, `currency_name`, `currency_symbol`, `currency_code`, `exchange_rate`, `is_cryptocurrency`, `usd_price`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dollars', '$', 'USD', NULL, 'no', NULL, '2019-10-27 06:47:05', '2019-10-27 06:47:05'),
(2, 1, 'Pounds', '£', 'GBP', NULL, 'no', NULL, '2019-10-27 06:47:05', '2019-10-27 06:47:05'),
(3, 1, 'Euros', '€', 'EUR', NULL, 'no', NULL, '2019-10-27 06:47:05', '2019-10-27 06:47:05'),
(4, 1, 'Rupee', '₹', 'INR', NULL, 'no', NULL, '2019-10-27 06:47:05', '2019-10-27 06:47:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `custom_field_group_id` int(10) UNSIGNED DEFAULT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `required` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `values` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_fields_data`
--

CREATE TABLE `custom_fields_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `custom_field_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(10000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_field_groups`
--

CREATE TABLE `custom_field_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `custom_field_groups`
--

INSERT INTO `custom_field_groups` (`id`, `company_id`, `name`, `model`) VALUES
(1, 1, 'Client', 'App\\ClientDetails'),
(2, 1, 'Employee', 'App\\EmployeeDetails'),
(3, 1, 'Project', 'App\\Project');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_notification_settings`
--

CREATE TABLE `email_notification_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `setting_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `send_email` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `send_slack` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `send_push` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `email_notification_settings`
--

INSERT INTO `email_notification_settings` (`id`, `company_id`, `setting_name`, `send_email`, `send_slack`, `send_push`, `created_at`, `updated_at`) VALUES
(7, 1, 'New Expense/Added by Admin', 'yes', 'no', 'no', '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(8, 1, 'New Expense/Added by Member', 'yes', 'no', 'no', '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(9, 1, 'Expense Status Changed', 'yes', 'no', 'no', '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(10, 1, 'New Support Ticket Request', 'yes', 'no', 'no', '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(11, 1, 'User Registration/Added by Admin', 'yes', 'no', 'no', '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(12, 1, 'Employee Assign to Project', 'yes', 'no', 'no', '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(13, 1, 'New Notice Published', 'no', 'no', 'no', '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(14, 1, 'User Assign to Task', 'yes', 'no', 'no', '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(15, 1, 'New Leave Application', 'yes', 'no', 'no', '2019-10-27 06:47:05', '2019-10-27 06:47:05'),
(16, 1, 'Task Completed', 'yes', 'no', 'no', '2019-10-27 06:47:05', '2019-10-27 06:47:05'),
(17, 1, 'Invoice Create/Update Notification', 'yes', 'no', 'no', '2019-10-27 06:47:05', '2019-10-27 06:47:05'),
(18, NULL, 'User Registration/Added by Admin', 'yes', 'no', 'no', '2019-10-27 06:47:14', '2019-10-27 06:47:14'),
(19, NULL, 'Employee Assign to Project', 'yes', 'no', 'no', '2019-10-27 06:47:14', '2019-10-27 06:47:14'),
(20, NULL, 'New Notice Published', 'no', 'no', 'no', '2019-10-27 06:47:14', '2019-10-27 06:47:14'),
(21, NULL, 'User Assign to Task', 'yes', 'no', 'no', '2019-10-27 06:47:14', '2019-10-27 06:47:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee_details`
--

CREATE TABLE `employee_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `hourly_rate` double DEFAULT NULL,
  `slack_username` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `joining_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `employee_details`
--

INSERT INTO `employee_details` (`id`, `company_id`, `user_id`, `address`, `hourly_rate`, `slack_username`, `department_id`, `designation_id`, `created_at`, `updated_at`, `joining_date`, `last_date`) VALUES
(1, 1, 1, 'address', 50, NULL, NULL, NULL, '2019-10-27 06:47:12', '2019-10-27 06:47:12', '2019-10-27 03:47:12', NULL),
(2, 1, 2, 'address', 50, NULL, NULL, NULL, '2019-10-27 06:47:13', '2019-10-27 06:47:13', '2019-10-27 03:47:13', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee_docs`
--

CREATE TABLE `employee_docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hashname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee_skills`
--

CREATE TABLE `employee_skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `skill_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee_teams`
--

CREATE TABLE `employee_teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estimates`
--

CREATE TABLE `estimates` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `estimate_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid_till` date NOT NULL,
  `sub_total` double(16,2) NOT NULL,
  `total` double(16,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('declined','accepted','waiting') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'waiting',
  `note` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `discount_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estimate_items`
--

CREATE TABLE `estimate_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `estimate_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `item_summary` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `quantity` double(16,2) NOT NULL,
  `unit_price` double(16,2) NOT NULL,
  `amount` double(16,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `event_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `label_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `where` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `repeat` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `repeat_every` int(11) DEFAULT NULL,
  `repeat_cycles` int(11) DEFAULT NULL,
  `repeat_type` enum('day','week','month','year') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'day',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_attendees`
--

CREATE TABLE `event_attendees` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_from` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `currency_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `bill` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `faq_category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `features`
--

CREATE TABLE `features` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('image','icon') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'image',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `features`
--

INSERT INTO `features` (`id`, `title`, `description`, `image`, `icon`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Business Needs.', '<p>Manage your projects and your talent in a single system, resulting in empowered teams, satisfied clients, and increased profitability.</p>', NULL, NULL, 'image', '2019-10-27 06:45:52', '2019-10-27 06:45:52'),
(2, 'Reports', '<p>Reports section to analyse what\'s working and what\'s not for your business</p>', NULL, NULL, 'image', '2019-10-27 06:45:53', '2019-10-27 06:45:53'),
(3, 'Tickets', '<p>Whether someone\'s internet is not working, someone is facing issue with housekeeping or need something regarding their work they can raise ticket for all their problems. Admin can assign the tickets to respective department agents.</p>', NULL, NULL, 'image', '2019-10-27 06:45:53', '2019-10-27 06:45:53'),
(4, 'Responsive', 'Your website works on any device: desktop, tablet or mobile.', NULL, 'fas fa-desktop', 'icon', '2019-10-27 06:45:53', '2019-10-27 06:45:53'),
(5, 'Customizable', 'You can easily read, edit, and write your own code, or change everything.', NULL, 'fas fa-wrench', 'icon', '2019-10-27 06:45:53', '2019-10-27 06:45:53'),
(6, 'UI Elements', 'There is a bunch of useful and necessary elements for developing your website.', NULL, 'fas fa-cubes', 'icon', '2019-10-27 06:45:53', '2019-10-27 06:45:53'),
(7, 'Clean Code', 'You can find our code well organized, commented and readable.', NULL, 'fas fa-code', 'icon', '2019-10-27 06:45:53', '2019-10-27 06:45:53'),
(8, 'Documented', 'As you can see in the source code, we provided a comprehensive documentation.', NULL, 'far fa-file-alt', 'icon', '2019-10-27 06:45:53', '2019-10-27 06:45:53'),
(9, 'Free Updates', 'When you purchase this template, you\'ll freely receive future updates.', NULL, 'fas fa-download', 'icon', '2019-10-27 06:45:53', '2019-10-27 06:45:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `file_storage_settings`
--

CREATE TABLE `file_storage_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `filesystem` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `auth_keys` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `file_storage_settings`
--

INSERT INTO `file_storage_settings` (`id`, `company_id`, `filesystem`, `auth_keys`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'local', NULL, 'enabled', '2019-10-27 06:41:08', '2019-10-27 06:41:08'),
(2, 1, 'local', NULL, 'enabled', '2019-10-27 06:47:08', '2019-10-27 06:47:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `footer_menu`
--

CREATE TABLE `footer_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `front_details`
--

CREATE TABLE `front_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `header_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `header_description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `get_started_show` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `sign_in_show` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `feature_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `feature_description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_links` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `front_details`
--

INSERT INTO `front_details` (`id`, `header_title`, `header_description`, `image`, `get_started_show`, `sign_in_show`, `feature_title`, `feature_description`, `price_title`, `price_description`, `address`, `phone`, `email`, `social_links`, `created_at`, `updated_at`) VALUES
(1, 'Project Management System', 'The most powerful and simple way to collaborate with your team', '', 'yes', 'yes', 'Team communications for the 21st century.', NULL, 'Affordable Pricing', 'Worksuite for Teams is a single workspace for your small- to medium-sized company or team.', 'Company address', '+91 1234567890', 'company@example.com', '[{\"name\":\"facebook\",\"link\":\"https:\\/\\/facebook.com\"},{\"name\":\"twitter\",\"link\":\"https:\\/\\/twitter.com\"},{\"name\":\"instagram\",\"link\":\"https:\\/\\/instagram.com\"},{\"name\":\"dribbble\",\"link\":\"https:\\/\\/dribbble.com\"}]', '2019-10-27 06:45:52', '2019-10-27 06:46:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `global_currencies`
--

CREATE TABLE `global_currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `exchange_rate` double DEFAULT NULL,
  `usd_price` double DEFAULT NULL,
  `is_cryptocurrency` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `global_currencies`
--

INSERT INTO `global_currencies` (`id`, `currency_name`, `currency_symbol`, `currency_code`, `exchange_rate`, `usd_price`, `is_cryptocurrency`, `created_at`, `updated_at`) VALUES
(1, 'Dollars', '$', 'USD', 1, NULL, 'no', '2019-10-27 06:46:58', '2019-11-04 00:58:40'),
(5, 'Peso Chileno', '$', 'CLP', 742.395571, NULL, 'no', '2019-11-04 00:58:39', '2019-11-04 00:58:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `global_settings`
--

CREATE TABLE `global_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `timezone` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Asia/Kolkata',
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `company_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `company_phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_background` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_map_key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `currency_converter_key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `google_recaptcha_key` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_recaptcha_secret` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supported_until` timestamp NULL DEFAULT NULL,
  `hide_cron_message` tinyint(1) NOT NULL DEFAULT 0,
  `week_start` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `global_settings`
--

INSERT INTO `global_settings` (`id`, `currency_id`, `timezone`, `locale`, `company_name`, `company_email`, `company_phone`, `logo`, `login_background`, `address`, `website`, `last_updated_by`, `created_at`, `updated_at`, `google_map_key`, `currency_converter_key`, `google_recaptcha_key`, `google_recaptcha_secret`, `purchase_code`, `supported_until`, `hide_cron_message`, `week_start`) VALUES
(1, 1, 'America/Santiago', 'ES-LAT', 'Noky', 'noky@noky.cl', '1234567891', NULL, NULL, 'Company address', 'noky.cl', 3, '2019-10-27 06:46:59', '2019-11-04 00:58:28', '', '7a5ae32dde95ba85bc6b', NULL, NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `holidays`
--

CREATE TABLE `holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `occassion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoices`
--

CREATE TABLE `invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_number` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `sub_total` double(16,2) NOT NULL,
  `discount` double NOT NULL DEFAULT 0,
  `discount_type` enum('percent','fixed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'percent',
  `total` double(16,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('paid','unpaid','partial') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unpaid',
  `recurring` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `billing_cycle` int(11) DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `billing_frequency` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_original_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit_note` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `item_summary` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `quantity` double(16,2) NOT NULL,
  `unit_price` double(16,2) NOT NULL,
  `amount` double(16,2) NOT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_settings`
--

CREATE TABLE `invoice_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_prefix` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_digit` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `estimate_prefix` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EST',
  `estimate_digit` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `credit_note_prefix` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'CN',
  `credit_note_digit` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `template` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `due_after` int(11) NOT NULL,
  `invoice_terms` text COLLATE utf8_unicode_ci NOT NULL,
  `gst_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_gst` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `invoice_settings`
--

INSERT INTO `invoice_settings` (`id`, `company_id`, `invoice_prefix`, `invoice_digit`, `estimate_prefix`, `estimate_digit`, `credit_note_prefix`, `credit_note_digit`, `template`, `due_after`, `invoice_terms`, `gst_number`, `show_gst`, `created_at`, `updated_at`) VALUES
(1, NULL, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, 'no', '2019-10-27 06:39:49', '2019-10-27 06:39:49'),
(2, 1, 'INV', 3, 'EST', 3, 'CN', 3, 'invoice-1', 15, 'Thank you for your business. Please process this invoice within the due date.', NULL, 'no', '2019-10-27 06:47:06', '2019-10-27 06:47:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `issues`
--

CREATE TABLE `issues` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','resolved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language_settings`
--

CREATE TABLE `language_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `language_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `language_settings`
--

INSERT INTO `language_settings` (`id`, `language_code`, `language_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ar', 'Arabic', 'disabled', NULL, NULL),
(2, 'de', 'German', 'disabled', NULL, NULL),
(3, 'es', 'Spanish', 'enabled', NULL, NULL),
(4, 'et', 'Estonian', 'disabled', NULL, NULL),
(5, 'fa', 'Farsi', 'disabled', NULL, NULL),
(6, 'fr', 'French', 'enabled', NULL, NULL),
(7, 'gr', 'Greek', 'disabled', NULL, NULL),
(8, 'it', 'Italian', 'disabled', NULL, NULL),
(9, 'nl', 'Dutch', 'disabled', NULL, NULL),
(10, 'pl', 'Polish', 'disabled', NULL, NULL),
(11, 'pt', 'Portuguese', 'disabled', NULL, NULL),
(12, 'pt-br', 'Portuguese (Brazil)', 'disabled', NULL, NULL),
(13, 'ro', 'Romanian', 'disabled', NULL, NULL),
(14, 'ru', 'Russian', 'enabled', NULL, NULL),
(15, 'tr', 'Turkish', 'disabled', NULL, NULL),
(16, 'zh-CN', 'Chinese (S)', 'disabled', NULL, NULL),
(17, 'zh-TW', 'Chinese (T)', 'disabled', NULL, NULL),
(18, 'ES-LAT', 'Español Latino', 'enabled', '2019-10-27 21:21:26', '2019-10-27 21:21:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `leads`
--

CREATE TABLE `leads` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `client_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `next_follow_up` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lead_files`
--

CREATE TABLE `lead_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hashname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lead_follow_up`
--

CREATE TABLE `lead_follow_up` (
  `id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `remark` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `next_follow_up_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lead_sources`
--

CREATE TABLE `lead_sources` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lead_sources`
--

INSERT INTO `lead_sources` (`id`, `company_id`, `type`, `created_at`, `updated_at`) VALUES
(1, NULL, 'email', NULL, NULL),
(2, NULL, 'google', NULL, NULL),
(3, NULL, 'facebook', NULL, NULL),
(4, NULL, 'friend', NULL, NULL),
(5, NULL, 'direct visit', NULL, NULL),
(6, NULL, 'tv ad', NULL, NULL),
(7, 1, 'email', NULL, NULL),
(8, 1, 'google', NULL, NULL),
(9, 1, 'facebook', NULL, NULL),
(10, 1, 'friend', NULL, NULL),
(11, 1, 'direct visit', NULL, NULL),
(12, 1, 'tv ad', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lead_status`
--

CREATE TABLE `lead_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lead_status`
--

INSERT INTO `lead_status` (`id`, `company_id`, `type`, `created_at`, `updated_at`) VALUES
(1, NULL, 'pending', NULL, NULL),
(2, NULL, 'inprocess', NULL, NULL),
(3, NULL, 'converted', NULL, NULL),
(4, 1, 'pending', NULL, NULL),
(5, 1, 'inprocess', NULL, NULL),
(6, 1, 'converted', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `leaves`
--

CREATE TABLE `leaves` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `duration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `leave_date` date NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('approved','pending','rejected') COLLATE utf8_unicode_ci NOT NULL,
  `reject_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `no_of_leaves` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `leave_types`
--

INSERT INTO `leave_types` (`id`, `company_id`, `type_name`, `color`, `no_of_leaves`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Casual', 'success', 5, '2019-10-27 06:40:46', '2019-10-27 06:40:46'),
(2, NULL, 'Sick', 'danger', 5, '2019-10-27 06:40:46', '2019-10-27 06:40:46'),
(3, NULL, 'Earned', 'info', 5, '2019-10-27 06:40:46', '2019-10-27 06:40:46'),
(4, 1, 'Casual', 'success', 5, '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(5, 1, 'Sick', 'danger', 5, '2019-10-27 06:47:04', '2019-10-27 06:47:04'),
(6, 1, 'Earned', 'info', 5, '2019-10-27 06:47:04', '2019-10-27 06:47:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licences`
--

CREATE TABLE `licences` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `license_number` char(29) COLLATE utf8_unicode_ci NOT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_person` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `last_payment_date` date DEFAULT NULL,
  `next_payment_date` date DEFAULT NULL,
  `status` enum('valid','invalid') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'valid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_time_for`
--

CREATE TABLE `log_time_for` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `log_time_for` enum('project','task') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'project',
  `auto_timer_stop` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `log_time_for`
--

INSERT INTO `log_time_for` (`id`, `company_id`, `log_time_for`, `auto_timer_stop`, `created_at`, `updated_at`) VALUES
(1, 1, 'project', 'no', '2019-10-27 06:47:08', '2019-10-27 06:47:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ltm_translations`
--

CREATE TABLE `ltm_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ltm_translations`
--

INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 0, 'en', 'messages', 'unsubscribeSuccess', 'Plan unsubscribe successfully.', '2019-10-27 21:22:14', '2019-10-27 21:23:51'),
(2, 0, 'en', 'messages', 'fetchChat', 'Fetching chat detail.', '2019-10-27 21:22:14', '2019-10-27 21:23:36'),
(3, 0, 'en', 'modules', 'hrs', 'hrs', '2019-10-27 21:22:14', '2019-10-27 21:25:37'),
(4, 0, 'en', 'modules', 'mins', 'mins', '2019-10-27 21:22:15', '2019-10-27 21:25:37'),
(5, 0, 'en', 'messages', 'eventCreateSuccess', 'Event created successfully.', '2019-10-27 21:22:15', '2019-10-27 21:23:43'),
(6, 0, 'en', 'messages', 'eventDeleteSuccess', 'Event deleted successfully.', '2019-10-27 21:22:15', '2019-10-27 21:23:43'),
(7, 0, 'en', 'messages', 'productAdded', 'Product added successfully.', '2019-10-27 21:22:15', '2019-10-27 21:23:47'),
(8, 0, 'en', 'messages', 'productUpdated', 'Product updated successfully.', '2019-10-27 21:22:15', '2019-10-27 21:23:47'),
(9, 0, 'en', 'messages', 'productDeleted', 'Product deleted successfully.', '2019-10-27 21:22:15', '2019-10-27 21:23:47'),
(10, 0, 'en', 'messages', 'boardColumnSaved', 'Board column saved successfully.', '2019-10-27 21:22:15', '2019-10-27 21:23:43'),
(11, 0, 'en', 'app', 'menu.attendanceReport', 'Attendance Report', '2019-10-27 21:22:15', '2019-10-27 21:23:02'),
(12, 0, 'en', 'app', 'employee', 'Employee', '2019-10-27 21:22:15', '2019-10-27 21:23:12'),
(13, 0, 'en', 'modules', 'attendance.present', 'Present', '2019-10-27 21:22:15', '2019-10-27 21:24:53'),
(14, 0, 'en', 'modules', 'attendance.absent', 'Absent', '2019-10-27 21:22:15', '2019-10-27 21:24:53'),
(15, 0, 'en', 'modules', 'attendance.hoursClocked', 'Hours Clocked', '2019-10-27 21:22:15', '2019-10-27 21:24:55'),
(16, 0, 'en', 'app', 'days', 'Days', '2019-10-27 21:22:15', '2019-10-27 21:23:05'),
(17, 0, 'en', 'modules', 'attendance.late', 'Late', '2019-10-27 21:22:15', '2019-10-27 21:24:52'),
(18, 0, 'en', 'modules', 'attendance.halfDay', 'Half Day', '2019-10-27 21:22:15', '2019-10-27 21:24:52'),
(19, 0, 'en', 'app', 'startDate', 'Start Date', '2019-10-27 21:22:15', '2019-10-27 21:23:17'),
(20, 0, 'en', 'app', 'endDate', 'End Date', '2019-10-27 21:22:15', '2019-10-27 21:23:18'),
(21, 0, 'en', 'modules', 'attendance.totalWorkingDays', 'Total Working Days', '2019-10-27 21:22:15', '2019-10-27 21:24:52'),
(22, 0, 'en', 'messages', 'settingsUpdated', 'Settings updated successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:32'),
(23, 0, 'en', 'messages', 'contactAdded', 'Contact added successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:31'),
(24, 0, 'en', 'messages', 'contactUpdated', 'Contact updated successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:31'),
(25, 0, 'en', 'messages', 'contactDeleted', 'Contact deleted successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:31'),
(26, 0, 'en', 'messages', 'currencyAdded', 'Currency added successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:32'),
(27, 0, 'en', 'messages', 'currencyUpdated', 'Currency updated successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:32'),
(28, 0, 'en', 'modules', 'currencySettings.cantDeleteDefault', 'Cannot delete default currency.', '2019-10-27 21:22:16', '2019-10-27 21:24:35'),
(29, 0, 'en', 'messages', 'currencyDeleted', 'Currency deleted successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:32'),
(30, 0, 'en', 'messages', 'exchangeRateUpdateSuccess', 'Exchange rate updated successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:41'),
(31, 0, 'en', 'messages', 'currencyConvertKeyUpdated', 'Currency convert API key updated successfully', '2019-10-27 21:22:16', '2019-10-27 21:23:50'),
(32, 0, 'en', 'messages', 'fileUploaded', 'File uploaded successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:34'),
(33, 0, 'en', 'messages', 'fileDeleted', 'File deleted successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:35'),
(34, 0, 'en', 'messages', 'reportGenerated', 'Report generated successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:32'),
(35, 0, 'en', 'app', 'client', 'Client', '2019-10-27 21:22:16', '2019-10-27 21:22:45'),
(36, 0, 'en', 'app', 'lead', 'Lead', '2019-10-27 21:22:16', '2019-10-27 21:22:48'),
(37, 0, 'en', 'messages', 'LeadDeleted', 'Lead deleted successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:46'),
(38, 0, 'en', 'messages', 'leadStatusChangeSuccess', 'Status changed successfully.', '2019-10-27 21:22:16', '2019-10-27 21:23:47'),
(39, 0, 'en', 'messages', 'leadFollowUpAddedSuccess', 'Lead follow up added successfully.', '2019-10-27 21:22:17', '2019-10-27 21:23:47'),
(40, 0, 'en', 'messages', 'holidayAddedSuccess', '<strong>New Holidays</strong> successfully added to the Database.', '2019-10-27 21:22:17', '2019-10-27 21:23:47'),
(41, 0, 'en', 'messages', 'holidayDeletedSuccess', 'Holidays successfully deleted.', '2019-10-27 21:22:17', '2019-10-27 21:23:47'),
(42, 0, 'en', 'messages', 'checkDayHoliday', 'Choose at-least 1.', '2019-10-27 21:22:17', '2019-10-27 21:23:37'),
(43, 0, 'en', 'modules', 'lead.changeToClient', 'Change To Client', '2019-10-27 21:22:17', '2019-10-27 21:25:05'),
(44, 0, 'en', 'modules', 'lead.addFollowUp', 'Add Follow Up', '2019-10-27 21:22:17', '2019-10-27 21:25:05'),
(45, 0, 'en', 'modules', 'lead.action', 'Action', '2019-10-27 21:22:17', '2019-10-27 21:25:05'),
(46, 0, 'en', 'modules', 'lead.view', 'View', '2019-10-27 21:22:17', '2019-10-27 21:25:05'),
(47, 0, 'en', 'modules', 'lead.edit', 'Edit', '2019-10-27 21:22:17', '2019-10-27 21:25:05'),
(48, 0, 'en', 'app', 'delete', 'Delete', '2019-10-27 21:22:17', '2019-10-27 21:23:06'),
(49, 0, 'en', 'app', 'pending', 'Pending', '2019-10-27 21:22:17', '2019-10-27 21:23:04'),
(50, 0, 'en', 'messages', 'LeadAddedUpdated', 'Lead added successfully.', '2019-10-27 21:22:17', '2019-10-27 21:23:46'),
(51, 0, 'en', 'messages', 'LeadUpdated', 'Lead updated successfully.', '2019-10-27 21:22:17', '2019-10-27 21:23:46'),
(52, 0, 'en', 'messages', 'leadFollowUpUpdatedSuccess', 'Lead follow up added successfully.', '2019-10-27 21:22:17', '2019-10-27 21:23:47'),
(53, 0, 'en', 'messages', 'followUpFilter', 'Filter applied.', '2019-10-27 21:22:17', '2019-10-27 21:23:47'),
(54, 0, 'en', 'messages', 'leadSourceAddSuccess', 'Lead source added successfully.', '2019-10-27 21:22:17', '2019-10-27 21:23:46'),
(55, 0, 'en', 'messages', 'leadSourceUpdateSuccess', 'Lead source updated successfully.', '2019-10-27 21:22:17', '2019-10-27 21:23:46'),
(56, 0, 'en', 'messages', 'leadSourceDeleteSuccess', 'Lead source deleted successfully.', '2019-10-27 21:22:17', '2019-10-27 21:23:46'),
(57, 0, 'en', 'messages', 'leadStatusAddSuccess', 'Lead sttaus added successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:47'),
(58, 0, 'en', 'messages', 'leadStatusUpdateSuccess', 'Lead status updated successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:47'),
(59, 0, 'en', 'messages', 'leadStatusDeleteSuccess', 'Lead status deleted successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:47'),
(60, 0, 'en', 'messages', 'logTimeUpdateSuccess', 'Log time updated successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:47'),
(61, 0, 'en', 'messages', 'creditNoteDeleted', 'Credit Note deleted successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:52'),
(62, 0, 'en', 'messages', 'creditNoteCanNotDeleted', 'Invalid Request You can not delete this Credit Note', '2019-10-27 21:22:18', '2019-10-27 21:23:52'),
(63, 0, 'en', 'messages', 'quantityNumber', 'Quantity should be a number', '2019-10-27 21:22:18', '2019-10-27 21:23:32'),
(64, 0, 'en', 'messages', 'unitPriceNumber', 'Unit price should be a number', '2019-10-27 21:22:18', '2019-10-27 21:23:33'),
(65, 0, 'en', 'messages', 'amountNumber', 'Amount should be a number.', '2019-10-27 21:22:18', '2019-10-27 21:23:33'),
(66, 0, 'en', 'messages', 'itemBlank', 'Item name cannot be blank.', '2019-10-27 21:22:18', '2019-10-27 21:23:33'),
(67, 0, 'en', 'messages', 'creditNoteCreated', 'Credit Note created successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:52'),
(68, 0, 'en', 'messages', 'invalidRequest', 'Invalid Request', '2019-10-27 21:22:18', '2019-10-27 21:23:41'),
(69, 0, 'en', 'messages', 'creditNoteUpdated', 'Credit Note updated successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:52'),
(70, 0, 'en', 'messages', 'fileUploadedSuccessfully', 'File uploaded successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:30'),
(71, 0, 'en', 'messages', 'fileUploadIssue', 'File not uploaded. Please contact to administrator', '2019-10-27 21:22:18', '2019-10-27 21:23:38'),
(72, 0, 'en', 'modules', 'payments.addPayment', 'Add Payment', '2019-10-27 21:22:18', '2019-10-27 21:24:47'),
(73, 0, 'en', 'modules', 'payments.paymentLink', 'Payment Link', '2019-10-27 21:22:18', '2019-10-27 21:24:43'),
(74, 0, 'en', 'app', 'credit-note', 'Credit Note', '2019-10-27 21:22:18', '2019-10-27 21:23:21'),
(75, 0, 'en', 'modules', 'invoices.partial', 'Partially Paid', '2019-10-27 21:22:18', '2019-10-27 21:24:18'),
(76, 0, 'en', 'messages', 'invoiceDeleted', 'Invoice deleted successfully.', '2019-10-27 21:22:18', '2019-10-27 21:23:32'),
(77, 0, 'en', 'messages', 'invoiceCanNotDeleted', 'Invalid Request You can not delete this invoice', '2019-10-27 21:22:19', '2019-10-27 21:23:52'),
(78, 0, 'en', 'messages', 'invoiceCreated', 'Invoice created successfully.', '2019-10-27 21:22:19', '2019-10-27 21:23:33'),
(79, 0, 'en', 'messages', 'invoiceUpdated', 'Invoice updated successfully.', '2019-10-27 21:22:19', '2019-10-27 21:23:33'),
(80, 0, 'en', 'modules', 'issues.markResolved', 'Mark Resolved', '2019-10-27 21:22:19', '2019-10-27 21:24:20'),
(81, 0, 'en', 'modules', 'issues.markPending', 'Mark Pending', '2019-10-27 21:22:19', '2019-10-27 21:24:20'),
(82, 0, 'en', 'modules', 'issues.pending', 'Pending', '2019-10-27 21:22:19', '2019-10-27 21:24:19'),
(83, 0, 'en', 'modules', 'issues.resolved', 'Resolved', '2019-10-27 21:22:19', '2019-10-27 21:24:20'),
(84, 0, 'en', 'messages', 'issueStatusChanged', 'Issue status changed successfully.', '2019-10-27 21:22:19', '2019-10-27 21:23:33'),
(85, 0, 'en', 'messages', 'taskUpdatedSuccessfully', 'Task updated successfully.', '2019-10-27 21:22:19', '2019-10-27 21:23:30'),
(86, 0, 'en', 'messages', 'taskDeletedSuccessfully', 'Task deleted successfully.', '2019-10-27 21:22:19', '2019-10-27 21:23:30'),
(87, 0, 'en', 'app', 'loginAsEmployee', 'Login As Employee', '2019-10-27 21:22:19', '2019-10-27 21:22:41'),
(88, 0, 'en', 'messages', 'newTaskAddedToTheProject', 'New task added to the project.', '2019-10-27 21:22:19', '2019-10-27 21:23:28'),
(89, 0, 'en', 'app', 'loginAsAdmin', 'Login As Admin', '2019-10-27 21:22:19', '2019-10-27 21:22:41'),
(90, 0, 'en', 'messages', 'taskCreatedSuccessfully', 'Task created successfully.', '2019-10-27 21:22:20', '2019-10-27 21:23:29'),
(91, 0, 'en', 'app', 'title', 'Title', '2019-10-27 21:22:20', '2019-10-27 21:22:42'),
(92, 0, 'en', 'app', 'active', 'Active', '2019-10-27 21:22:20', '2019-10-27 21:22:48'),
(93, 0, 'en', 'app', 'note', 'Note', '2019-10-27 21:22:20', '2019-10-27 21:22:42'),
(94, 0, 'en', 'messages', 'timeLogDeleted', 'Time log deleted successfully.', '2019-10-27 21:22:20', '2019-10-27 21:23:33'),
(95, 0, 'en', 'app', 'save', 'Save', '2019-10-27 21:22:20', '2019-10-27 21:22:42'),
(96, 0, 'en', 'messages', 'timerStoppedSuccessfully', 'Timer stopped successfully.', '2019-10-27 21:22:20', '2019-10-27 21:23:29'),
(97, 0, 'en', 'app', 'update', 'Update', '2019-10-27 21:22:20', '2019-10-27 21:22:42'),
(98, 0, 'en', 'messages', 'maxColckIn', NULL, '2019-10-27 21:22:20', '2019-10-27 21:22:20'),
(99, 0, 'en', 'app', 'back', 'Back', '2019-10-27 21:22:20', '2019-10-27 21:22:42'),
(100, 0, 'en', 'messages', 'attendanceSaveSuccess', 'Attendance Saved Successfully.', '2019-10-27 21:22:20', '2019-10-27 21:23:43'),
(101, 0, 'en', 'app', 'reset', 'Reset', '2019-10-27 21:22:20', '2019-10-27 21:22:42'),
(102, 0, 'en', 'messages', 'attendanceDelete', 'Attendance deleted successfully.', '2019-10-27 21:22:20', '2019-10-27 21:23:45'),
(103, 0, 'en', 'app', 'addNew', 'Add New', '2019-10-27 21:22:20', '2019-10-27 21:22:43'),
(104, 0, 'en', 'messages', 'leadClientChangeSuccess', 'Lead changed in client successfully.', '2019-10-27 21:22:20', '2019-10-27 21:23:47'),
(105, 0, 'en', 'app', 'edit', 'Edit', '2019-10-27 21:22:20', '2019-10-27 21:22:43'),
(106, 0, 'en', 'messages', 'clientDeleted', 'Client deleted successfully.', '2019-10-27 21:22:21', '2019-10-27 21:23:33'),
(107, 0, 'en', 'app', 'id', 'Id', '2019-10-27 21:22:21', '2019-10-27 21:22:43'),
(108, 0, 'en', 'app', 'deactive', 'Deactive', '2019-10-27 21:22:21', '2019-10-27 21:23:15'),
(109, 0, 'en', 'app', 'name', 'Name', '2019-10-27 21:22:21', '2019-10-27 21:22:43'),
(110, 0, 'en', 'app', 'menu.designation', 'Designation', '2019-10-27 21:22:21', '2019-10-27 21:23:02'),
(111, 0, 'en', 'app', 'email', 'Email', '2019-10-27 21:22:21', '2019-10-27 21:22:43'),
(112, 0, 'en', 'messages', 'updatedSuccessfully', 'Updated successfully', '2019-10-27 21:22:21', '2019-10-27 21:24:22'),
(113, 0, 'en', 'app', 'phone', 'Phone', '2019-10-27 21:22:21', '2019-10-27 21:22:43'),
(114, 0, 'en', 'messages', 'upgradePackageForAddEmployees', 'You need to upgrade your package to create more employees because your employees length is :employeeCount and package max employees length is  :maxEmployees', '2019-10-27 21:22:21', '2019-10-27 21:23:51'),
(115, 0, 'en', 'app', 'mobile', 'Mobile', '2019-10-27 21:22:21', '2019-10-27 21:22:43'),
(116, 0, 'en', 'messages', 'downGradePackageForAddEmployees', 'You can\\\'t downgrade package because your employees length is :employeeCount and package max employees length is :maxEmployees', '2019-10-27 21:22:21', '2019-10-27 21:23:51'),
(117, 0, 'en', 'app', 'createdAt', 'Created At', '2019-10-27 21:22:21', '2019-10-27 21:22:43'),
(118, 0, 'en', 'messages', 'employeeAdded', 'Employee added successfully.', '2019-10-27 21:22:21', '2019-10-27 21:23:41'),
(119, 0, 'en', 'app', 'action', 'Action', '2019-10-27 21:22:21', '2019-10-27 21:22:44'),
(120, 0, 'en', 'messages', 'employeeUpdated', 'Employee info updated successfully.', '2019-10-27 21:22:21', '2019-10-27 21:23:34'),
(121, 0, 'en', 'app', 'search', 'Search...', '2019-10-27 21:22:21', '2019-10-27 21:22:44'),
(122, 0, 'en', 'messages', 'adminCannotDelete', 'Admin user cannot be deleted.', '2019-10-27 21:22:21', '2019-10-27 21:23:34'),
(123, 0, 'en', 'app', 'markRead', 'Mark as Read', '2019-10-27 21:22:21', '2019-10-27 21:22:44'),
(124, 0, 'en', 'messages', 'employeeDeleted', 'Employee deleted successfully.', '2019-10-27 21:22:21', '2019-10-27 21:23:34'),
(125, 0, 'en', 'app', 'deadline', 'Deadline', '2019-10-27 21:22:21', '2019-10-27 21:22:44'),
(126, 0, 'en', 'messages', 'roleCannotChange', 'Role of this user cannot be changed.', '2019-10-27 21:22:21', '2019-10-27 21:23:40'),
(127, 0, 'en', 'app', 'project', 'Project', '2019-10-27 21:22:22', '2019-10-27 21:22:44'),
(128, 0, 'en', 'app', 'inactive', 'Inactive', '2019-10-27 21:22:22', '2019-10-27 21:23:18'),
(129, 0, 'en', 'app', 'completion', 'Completion', '2019-10-27 21:22:22', '2019-10-27 21:22:44'),
(130, 0, 'en', 'messages', 'roleAssigned', 'Roles assigned successfully.', '2019-10-27 21:22:22', '2019-10-27 21:23:40'),
(131, 0, 'en', 'app', 'address', 'Address', '2019-10-27 21:22:22', '2019-10-27 21:22:44'),
(132, 0, 'en', 'messages', 'addItem', 'Add at-least 1 item.', '2019-10-27 21:22:22', '2019-10-27 21:23:32'),
(133, 0, 'en', 'app', 'completed', 'Completed', '2019-10-27 21:22:22', '2019-10-27 21:22:45'),
(134, 0, 'en', 'messages', 'estimateCreated', 'Estimate created successfully.', '2019-10-27 21:22:22', '2019-10-27 21:23:40'),
(135, 0, 'en', 'app', 'hideCompletedTasks', 'Hide Completed Tasks', '2019-10-27 21:22:22', '2019-10-27 21:22:45'),
(136, 0, 'en', 'messages', 'estimateUpdated', 'Estimate updated successfully.', '2019-10-27 21:22:22', '2019-10-27 21:23:41'),
(137, 0, 'en', 'app', 'dueDate', 'Due Date', '2019-10-27 21:22:22', '2019-10-27 21:22:45'),
(138, 0, 'en', 'messages', 'estimateDeleted', 'Estimate deleted successfully.', '2019-10-27 21:22:22', '2019-10-27 21:23:41'),
(139, 0, 'en', 'app', 'status', 'Status', '2019-10-27 21:22:22', '2019-10-27 21:22:45'),
(140, 0, 'en', 'messages', 'estimateCanNotDeleted', 'Invalid Request You can not delete this Estimate', '2019-10-27 21:22:22', '2019-10-27 21:23:52'),
(141, 0, 'en', 'app', 'task', 'Task', '2019-10-27 21:22:22', '2019-10-27 21:22:45'),
(142, 0, 'en', 'messages', 'expenseSuccess', 'Expense Added Successfully.', '2019-10-27 21:22:22', '2019-10-27 21:23:41'),
(143, 0, 'en', 'messages', 'expenseUpdateSuccess', 'Expense updated successfully.', '2019-10-27 21:22:22', '2019-10-27 21:23:41'),
(144, 0, 'en', 'app', 'details', 'Details', '2019-10-27 21:22:22', '2019-10-27 21:22:46'),
(145, 0, 'en', 'messages', 'expenseDeleted', 'Expense deleted successfully.', '2019-10-27 21:22:22', '2019-10-27 21:23:41'),
(146, 0, 'en', 'app', 'stop', 'Stop', '2019-10-27 21:22:22', '2019-10-27 21:22:46'),
(147, 0, 'en', 'app', 'menu.leaves', 'Leaves', '2019-10-27 21:22:22', '2019-10-27 21:22:57'),
(148, 0, 'en', 'app', 'remove', 'Remove', '2019-10-27 21:22:22', '2019-10-27 21:22:46'),
(149, 0, 'en', 'messages', 'leaveAssignSuccess', 'Leave assigned successfully.', '2019-10-27 21:22:22', '2019-10-27 21:23:44'),
(150, 0, 'en', 'app', 'description', 'Description', '2019-10-27 21:22:22', '2019-10-27 21:22:46'),
(151, 0, 'en', 'messages', 'leaveStatusUpdate', 'Leave status updated successfully.', '2019-10-27 21:22:23', '2019-10-27 21:23:44'),
(152, 0, 'en', 'app', 'incomplete', 'Incomplete', '2019-10-27 21:22:23', '2019-10-27 21:22:46'),
(153, 0, 'en', 'app', 'approved', 'Approved', '2019-10-27 21:22:23', '2019-10-27 21:23:12'),
(154, 0, 'en', 'app', 'invoice', 'Invoice', '2019-10-27 21:22:23', '2019-10-27 21:22:46'),
(155, 0, 'en', 'app', 'reject', 'Reject', '2019-10-27 21:22:23', '2019-10-27 21:23:07'),
(156, 0, 'en', 'app', 'date', 'Date', '2019-10-27 21:22:23', '2019-10-27 21:22:46'),
(157, 0, 'en', 'messages', 'leaveTypeAdded', 'Leave type saved.', '2019-10-27 21:22:23', '2019-10-27 21:23:44'),
(158, 0, 'en', 'app', 'selectDateRange', 'Select Date Range', '2019-10-27 21:22:23', '2019-10-27 21:22:47'),
(159, 0, 'en', 'messages', 'leaveTypeDeleted', 'Leave type deleted.', '2019-10-27 21:22:23', '2019-10-27 21:23:44'),
(160, 0, 'en', 'app', 'selectProject', 'Select Project', '2019-10-27 21:22:23', '2019-10-27 21:22:47'),
(161, 0, 'en', 'messages', 'noticeAdded', 'Notice added successfully.', '2019-10-27 21:22:23', '2019-10-27 21:23:34'),
(162, 0, 'en', 'app', 'apply', 'Apply', '2019-10-27 21:22:23', '2019-10-27 21:22:47'),
(163, 0, 'en', 'messages', 'noticeUpdated', 'Notice updated successfully.', '2019-10-27 21:22:23', '2019-10-27 21:23:34'),
(164, 0, 'en', 'app', 'filterResults', 'Filter Results', '2019-10-27 21:22:23', '2019-10-27 21:22:47'),
(165, 0, 'en', 'messages', 'noticeDeleted', 'Notice deleted successfully.', '2019-10-27 21:22:23', '2019-10-27 21:23:34'),
(166, 0, 'en', 'app', 'selectImage', 'Select Image', '2019-10-27 21:22:23', '2019-10-27 21:22:47'),
(167, 0, 'en', 'messages', 'paymentSuccess', 'Payment added successfully.', '2019-10-27 21:22:23', '2019-10-27 21:23:41'),
(168, 0, 'en', 'app', 'change', 'Change', '2019-10-27 21:22:23', '2019-10-27 21:22:47'),
(169, 0, 'en', 'messages', 'paymentDeleted', 'Payment deleted successfully.', '2019-10-27 21:22:23', '2019-10-27 21:23:41'),
(170, 0, 'en', 'app', 'adminPanel', 'Admin Panel', '2019-10-27 21:22:23', '2019-10-27 21:22:47'),
(171, 0, 'en', 'messages', 'importSuccess', 'File imported successfully.', '2019-10-27 21:22:23', '2019-10-27 21:23:46'),
(172, 0, 'en', 'app', 'employeePanel', 'Employee Panel', '2019-10-27 21:22:23', '2019-10-27 21:22:47'),
(173, 0, 'en', 'messages', 'categoryAdded', 'Category added successfully.', '2019-10-27 21:22:23', '2019-10-27 21:23:34'),
(174, 0, 'en', 'app', 'clientPanel', 'Client Panel', '2019-10-27 21:22:24', '2019-10-27 21:22:47'),
(175, 0, 'en', 'messages', 'categoryDeleted', 'Category deleted successfully.', '2019-10-27 21:22:24', '2019-10-27 21:23:34'),
(176, 0, 'en', 'app', 'logout', 'Logout', '2019-10-27 21:22:24', '2019-10-27 21:22:48'),
(177, 0, 'en', 'messages', 'newFileUploadedToTheProject', 'New file uploaded to the project.', '2019-10-27 21:22:24', '2019-10-27 21:23:28'),
(178, 0, 'en', 'messages', 'isAddedAsProjectMember', 'is added as project member.', '2019-10-27 21:22:24', '2019-10-27 21:23:30'),
(179, 0, 'en', 'app', 'clientName', 'Client Name', '2019-10-27 21:22:24', '2019-10-27 21:22:48'),
(180, 0, 'en', 'messages', 'membersAddedSuccessfully', 'Members added successfully.', '2019-10-27 21:22:24', '2019-10-27 21:23:29'),
(181, 0, 'en', 'messages', 'memberRemovedFromProject', 'Member removed from project successfully.', '2019-10-27 21:22:24', '2019-10-27 21:23:30'),
(182, 0, 'en', 'app', 'paymentOn', 'Payment On', '2019-10-27 21:22:24', '2019-10-27 21:22:48'),
(183, 0, 'en', 'app', 'menu.projects', 'Projects', '2019-10-27 21:22:24', '2019-10-27 21:22:50'),
(184, 0, 'en', 'app', 'amount', 'Amount', '2019-10-27 21:22:24', '2019-10-27 21:22:48'),
(185, 0, 'en', 'messages', 'milestoneSuccess', 'Milestone saved successfully.', '2019-10-27 21:22:24', '2019-10-27 21:23:52'),
(186, 0, 'en', 'app', 'gateway', 'Gateway', '2019-10-27 21:22:24', '2019-10-27 21:22:49'),
(187, 0, 'en', 'messages', 'deleteSuccess', 'Deleted Successfully.', '2019-10-27 21:22:24', '2019-10-27 21:23:43'),
(188, 0, 'en', 'app', 'transactionId', 'Transaction Id', '2019-10-27 21:22:24', '2019-10-27 21:22:49'),
(189, 0, 'en', 'messages', 'addedAsNewProject', 'added as new project.', '2019-10-27 21:22:24', '2019-10-27 21:23:29'),
(190, 0, 'en', 'app', 'timeLog', 'Time Log ', '2019-10-27 21:22:24', '2019-10-27 21:22:49'),
(191, 0, 'en', 'modules', 'projects.projectUpdated', ' project details updated.', '2019-10-27 21:22:24', '2019-10-27 21:24:08'),
(192, 0, 'en', 'app', 'selectTask', 'Select Task', '2019-10-27 21:22:24', '2019-10-27 21:22:49'),
(193, 0, 'en', 'messages', 'projectUpdated', 'Project updated successfully.', '2019-10-27 21:22:25', '2019-10-27 21:23:35'),
(194, 0, 'en', 'app', 'category', 'Category', '2019-10-27 21:22:25', '2019-10-27 21:22:49'),
(195, 0, 'en', 'messages', 'projectDeleted', 'Project deleted successfully.', '2019-10-27 21:22:25', '2019-10-27 21:23:35'),
(196, 0, 'en', 'app', 'panel', 'Panel', '2019-10-27 21:22:25', '2019-10-27 21:22:49'),
(197, 0, 'en', 'messages', 'projectArchiveSuccessfully', 'Project archived successfully.', '2019-10-27 21:22:25', '2019-10-27 21:23:48'),
(198, 0, 'en', 'app', 'projectTemplate', 'Project Template', '2019-10-27 21:22:25', '2019-10-27 21:22:50'),
(199, 0, 'en', 'messages', 'projectRevertSuccessfully', 'Project reverted successfully.', '2019-10-27 21:22:25', '2019-10-27 21:23:48'),
(200, 0, 'en', 'app', 'menu.home', 'Home', '2019-10-27 21:22:25', '2019-10-27 21:22:50'),
(201, 0, 'en', 'messages', 'noMemberAddedToProject', 'No member added to this project.', '2019-10-27 21:22:25', '2019-10-27 21:23:31'),
(202, 0, 'en', 'app', 'menu.dashboard', 'Dashboard', '2019-10-27 21:22:25', '2019-10-27 21:22:50'),
(203, 0, 'en', 'modules', 'projects.addMemberTitle', 'Add Project Members', '2019-10-27 21:22:25', '2019-10-27 21:24:08'),
(204, 0, 'en', 'app', 'menu.clients', 'Clients', '2019-10-27 21:22:25', '2019-10-27 21:22:50'),
(205, 0, 'en', 'modules', 'projects.pause', 'Pause', '2019-10-27 21:22:25', '2019-10-27 21:24:11'),
(206, 0, 'en', 'app', 'menu.employees', 'Employees', '2019-10-27 21:22:25', '2019-10-27 21:22:50'),
(207, 0, 'en', 'app', 'progress', 'Progress', '2019-10-27 21:22:25', '2019-10-27 21:23:17'),
(208, 0, 'en', 'app', 'unpaid', 'Unpaid', '2019-10-27 21:22:25', '2019-10-27 21:23:17'),
(209, 0, 'en', 'app', 'menu.taskCalendar', 'Task Calendar', '2019-10-27 21:22:25', '2019-10-27 21:22:50'),
(210, 0, 'en', 'app', 'menu.payments', 'Payments', '2019-10-27 21:22:25', '2019-10-27 21:22:53'),
(211, 0, 'en', 'app', 'menu.invoices', 'Invoices', '2019-10-27 21:22:25', '2019-10-27 21:22:50'),
(212, 0, 'en', 'messages', 'roleCreated', 'Role created successfully.', '2019-10-27 21:22:25', '2019-10-27 21:23:44'),
(213, 0, 'en', 'app', 'menu.issues', 'Issues', '2019-10-27 21:22:25', '2019-10-27 21:22:51'),
(214, 0, 'en', 'messages', 'roleUpdated', 'Role updated successfully.', '2019-10-27 21:22:25', '2019-10-27 21:23:49'),
(215, 0, 'en', 'app', 'menu.timeLogs', 'Time Logs', '2019-10-27 21:22:26', '2019-10-27 21:22:51'),
(216, 0, 'en', 'messages', 'noteCreated', 'Note created successfully.', '2019-10-27 21:22:26', '2019-10-27 21:23:35'),
(217, 0, 'en', 'app', 'menu.tasks', 'Tasks', '2019-10-27 21:22:26', '2019-10-27 21:22:51'),
(218, 0, 'en', 'messages', 'noteUpdated', 'Note updated successfully.', '2019-10-27 21:22:26', '2019-10-27 21:23:35'),
(219, 0, 'en', 'app', 'menu.noticeBoard', 'Notice Board', '2019-10-27 21:22:26', '2019-10-27 21:22:51'),
(220, 0, 'en', 'messages', 'noteDeleted', 'Note deleted successfully.', '2019-10-27 21:22:26', '2019-10-27 21:23:35'),
(221, 0, 'en', 'app', 'menu.stickyNotes', 'Sticky Notes', '2019-10-27 21:22:26', '2019-10-27 21:22:51'),
(222, 0, 'en', 'messages', 'subTaskAdded', 'Sub task added successfully.', '2019-10-27 21:22:26', '2019-10-27 21:23:49'),
(223, 0, 'en', 'app', 'menu.reports', 'Reports', '2019-10-27 21:22:26', '2019-10-27 21:22:51'),
(224, 0, 'en', 'messages', 'subTaskUpdated', 'Sub task updated successfully.', '2019-10-27 21:22:26', '2019-10-27 21:23:49'),
(225, 0, 'en', 'app', 'menu.taskReport', 'Task Report', '2019-10-27 21:22:26', '2019-10-27 21:22:52'),
(226, 0, 'en', 'messages', 'groupUpdatedSuccessfully', 'Group updated successfully.', '2019-10-27 21:22:26', '2019-10-27 21:23:42'),
(227, 0, 'en', 'app', 'menu.timeLogReport', 'Time Log Report', '2019-10-27 21:22:26', '2019-10-27 21:22:52'),
(228, 0, 'en', 'messages', 'departmentAdded', 'Department added successfully', '2019-10-27 21:22:26', '2019-10-27 21:23:54'),
(229, 0, 'en', 'app', 'menu.financeReport', 'Finance Report', '2019-10-27 21:22:27', '2019-10-27 21:22:52'),
(230, 0, 'en', 'messages', 'ticketAddSuccess', 'Ticket created successfully.', '2019-10-27 21:22:27', '2019-10-27 21:23:42'),
(231, 0, 'en', 'app', 'menu.settings', 'Settings', '2019-10-27 21:22:27', '2019-10-27 21:22:52'),
(232, 0, 'en', 'messages', 'ticketReplySuccess', 'Reply sent successfully.', '2019-10-27 21:22:27', '2019-10-27 21:23:43'),
(233, 0, 'en', 'app', 'menu.accountSettings', 'Company Settings', '2019-10-27 21:22:27', '2019-10-27 21:22:52'),
(234, 0, 'en', 'modules', 'tickets.agent', 'Agent', '2019-10-27 21:22:27', '2019-10-27 21:24:49'),
(235, 0, 'en', 'app', 'menu.profileSettings', 'Profile Settings', '2019-10-27 21:22:27', '2019-10-27 21:22:52'),
(236, 0, 'en', 'modules', 'tasks.priority', 'Priority', '2019-10-27 21:22:27', '2019-10-27 21:24:13'),
(237, 0, 'en', 'app', 'menu.emailSettings', 'Email Settings', '2019-10-27 21:22:27', '2019-10-27 21:22:52'),
(238, 0, 'en', 'messages', 'ticketDeleteSuccess', 'Ticket deleted successfully.', '2019-10-27 21:22:27', '2019-10-27 21:23:43'),
(239, 0, 'en', 'app', 'menu.moduleSettings', 'Module Settings', '2019-10-27 21:22:27', '2019-10-27 21:22:52'),
(240, 0, 'en', 'messages', 'timeLogAdded', 'Time logged successfully.', '2019-10-27 21:22:27', '2019-10-27 21:23:35'),
(241, 0, 'en', 'app', 'menu.currencySettings', 'Currency Settings', '2019-10-27 21:22:27', '2019-10-27 21:22:53'),
(242, 0, 'en', 'messages', 'timelogAlreadyExist', 'Time-log already exist for this user.', '2019-10-27 21:22:27', '2019-10-27 21:23:51'),
(243, 0, 'en', 'app', 'menu.contacts', 'Contacts', '2019-10-27 21:22:27', '2019-10-27 21:22:53'),
(244, 0, 'en', 'app', 'menu.messages', 'Messages', '2019-10-27 21:22:27', '2019-10-27 21:22:53'),
(245, 0, 'en', 'messages', 'timeLogUpdated', 'Time log updated successfully.', '2019-10-27 21:22:27', '2019-10-27 21:23:35'),
(246, 0, 'en', 'app', 'menu.themeSettings', 'Theme Settings', '2019-10-27 21:22:28', '2019-10-27 21:22:53'),
(247, 0, 'en', 'messages', 'methodsAdded', 'Offline method added successfully.', '2019-10-27 21:22:28', '2019-10-27 21:23:37'),
(248, 0, 'en', 'app', 'menu.estimates', 'Estimates', '2019-10-27 21:22:28', '2019-10-27 21:22:53'),
(249, 0, 'en', 'messages', 'methodsUpdated', 'Offline method updated successfully.', '2019-10-27 21:22:28', '2019-10-27 21:23:37'),
(250, 0, 'en', 'app', 'menu.paymentGatewayCredential', 'Payment Credentials', '2019-10-27 21:22:28', '2019-10-27 21:22:53'),
(251, 0, 'en', 'messages', 'methodsDeleted', 'Offline method deleted successfully.', '2019-10-27 21:22:28', '2019-10-27 21:23:37'),
(252, 0, 'en', 'app', 'menu.expenses', 'Expenses', '2019-10-27 21:22:28', '2019-10-27 21:22:54'),
(253, 0, 'en', 'messages', 'templateMembersAddedSuccessfully', 'Template Members added successfully.', '2019-10-27 21:22:28', '2019-10-27 21:23:37'),
(254, 0, 'en', 'app', 'menu.incomeVsExpenseReport', 'Income Vs Expense Report', '2019-10-27 21:22:29', '2019-10-27 21:22:54'),
(255, 0, 'en', 'messages', 'templateMemberRemovedFromProject', 'Template Member removed from project successfully.', '2019-10-27 21:22:29', '2019-10-27 21:23:37'),
(256, 0, 'en', 'app', 'menu.projectSettings', 'Project Settings', '2019-10-27 21:22:29', '2019-10-27 21:23:02'),
(257, 0, 'en', 'app', 'menu.invoiceSettings', 'Invoice Settings', '2019-10-27 21:22:29', '2019-10-27 21:22:54'),
(258, 0, 'en', 'modules', 'projectTemplate.projectUpdated', ' project details updated.', '2019-10-27 21:22:29', '2019-10-27 21:25:16'),
(259, 0, 'en', 'app', 'menu.slackSettings', 'Slack Settings', '2019-10-27 21:22:29', '2019-10-27 21:22:54'),
(260, 0, 'en', 'modules', 'projectTemplate.addMemberTitle', 'Add Template Members', '2019-10-27 21:22:29', '2019-10-27 21:25:16'),
(261, 0, 'en', 'app', 'menu.updates', 'Update Log', '2019-10-27 21:22:29', '2019-10-27 21:22:54'),
(262, 0, 'en', 'app', 'menu.projectTemplateTask', 'Project Template Task', '2019-10-27 21:22:29', '2019-10-27 21:22:59'),
(263, 0, 'en', 'app', 'menu.ticketSettings', 'Ticket Settings', '2019-10-27 21:22:29', '2019-10-27 21:22:55'),
(264, 0, 'en', 'messages', 'templateTaskCreatedSuccessfully', 'Template Task created successfully.', '2019-10-27 21:22:29', '2019-10-27 21:23:37'),
(265, 0, 'en', 'app', 'menu.ticketAgents', 'Ticket Agents', '2019-10-27 21:22:29', '2019-10-27 21:22:55'),
(266, 0, 'en', 'messages', 'templateTaskUpdatedSuccessfully', 'Template Task updated successfully.', '2019-10-27 21:22:29', '2019-10-27 21:23:37'),
(267, 0, 'en', 'app', 'menu.ticketTypes', 'Ticket Types', '2019-10-27 21:22:29', '2019-10-27 21:22:55'),
(268, 0, 'en', 'modules', 'proposal.action', 'Action', '2019-10-27 21:22:29', '2019-10-27 21:25:07'),
(269, 0, 'en', 'app', 'menu.ticketChannel', 'Ticket Channel', '2019-10-27 21:22:29', '2019-10-27 21:22:55'),
(270, 0, 'en', 'modules', 'proposal.download', 'Download', '2019-10-27 21:22:30', '2019-10-27 21:25:07'),
(271, 0, 'en', 'app', 'menu.replyTemplates', 'Reply Templates', '2019-10-27 21:22:30', '2019-10-27 21:22:55'),
(272, 0, 'en', 'modules', 'proposal.edit', 'Edit', '2019-10-27 21:22:30', '2019-10-27 21:25:06'),
(273, 0, 'en', 'modules', 'proposal.delete', 'Delete', '2019-10-27 21:22:30', '2019-10-27 21:25:07'),
(274, 0, 'en', 'app', 'menu.tickets', 'Tickets', '2019-10-27 21:22:30', '2019-10-27 21:22:56'),
(275, 0, 'en', 'messages', 'proposalCreated', 'Proposal created successfully.', '2019-10-27 21:22:30', '2019-10-27 21:23:47'),
(276, 0, 'en', 'app', 'menu.attendanceSettings', 'Attendance Settings', '2019-10-27 21:22:30', '2019-10-27 21:22:56'),
(277, 0, 'en', 'messages', 'proposalUpdated', 'Proposal updated successfully.', '2019-10-27 21:22:30', '2019-10-27 21:23:47'),
(278, 0, 'en', 'app', 'menu.attendance', 'Attendance', '2019-10-27 21:22:30', '2019-10-27 21:22:56'),
(279, 0, 'en', 'messages', 'proposalDeleted', 'Proposal deleted successfully.', '2019-10-27 21:22:30', '2019-10-27 21:23:47'),
(280, 0, 'en', 'app', 'menu.finance', 'Finance', '2019-10-27 21:22:30', '2019-10-27 21:22:56'),
(281, 0, 'en', 'messages', 'taskSettingUpdateSuccess', NULL, '2019-10-27 21:22:30', '2019-10-27 21:22:30'),
(282, 0, 'en', 'app', 'menu.customFields', 'Custom Fields', '2019-10-27 21:22:30', '2019-10-27 21:22:56'),
(283, 0, 'en', 'messages', 'taxAdded', 'Tax added successfully.', '2019-10-27 21:22:30', '2019-10-27 21:23:46'),
(284, 0, 'en', 'app', 'menu.Events', 'Events', '2019-10-27 21:22:30', '2019-10-27 21:22:56'),
(285, 0, 'en', 'messages', 'agentAddedSuccessfully', 'Agent added successfully.', '2019-10-27 21:22:30', '2019-10-27 21:23:41'),
(286, 0, 'en', 'app', 'menu.payroll', 'Payroll', '2019-10-27 21:22:30', '2019-10-27 21:22:56'),
(287, 0, 'en', 'messages', 'statusUpdatedSuccessfully', 'Status updated successfully.', '2019-10-27 21:22:31', '2019-10-27 21:23:41'),
(288, 0, 'en', 'app', 'menu.rolesPermission', 'Roles & Permissions', '2019-10-27 21:22:31', '2019-10-27 21:22:57'),
(289, 0, 'en', 'messages', 'agentRemoveSuccess', 'Agent removed successfully.', '2019-10-27 21:22:31', '2019-10-27 21:23:42'),
(290, 0, 'en', 'messages', 'ticketChannelAddSuccess', 'Ticket channel added successfully.', '2019-10-27 21:22:31', '2019-10-27 21:23:42'),
(291, 0, 'en', 'app', 'menu.messageSettings', 'Message Settings', '2019-10-27 21:22:31', '2019-10-27 21:22:57'),
(292, 0, 'en', 'messages', 'ticketChannelUpdateSuccess', 'Ticket channel updated successfully.', '2019-10-27 21:22:31', '2019-10-27 21:23:42'),
(293, 0, 'en', 'app', 'menu.storageSettings', 'Storage Settings', '2019-10-27 21:22:31', '2019-10-27 21:22:57'),
(294, 0, 'en', 'messages', 'ticketChannelDeleteSuccess', 'Ticket channel deleted successfully.', '2019-10-27 21:22:31', '2019-10-27 21:23:43'),
(295, 0, 'en', 'app', 'menu.leaveSettings', 'Leaves Settings', '2019-10-27 21:22:31', '2019-10-27 21:22:57'),
(296, 0, 'en', 'messages', 'groupAddedSuccess', 'Group added successfully.', '2019-10-27 21:22:31', '2019-10-27 21:23:42'),
(297, 0, 'en', 'app', 'menu.employeeList', 'Employee List', '2019-10-27 21:22:31', '2019-10-27 21:22:57'),
(298, 0, 'en', 'messages', 'groupDeleteSuccess', 'Group deleted successfully.', '2019-10-27 21:22:31', '2019-10-27 21:23:42'),
(299, 0, 'en', 'app', 'menu.teams', 'Teams', '2019-10-27 21:22:32', '2019-10-27 21:22:57'),
(300, 0, 'en', 'messages', 'templateAddSuccess', 'Template added successfully.', '2019-10-27 21:22:32', '2019-10-27 21:23:42'),
(301, 0, 'en', 'app', 'menu.leaveReport', 'Leave Report', '2019-10-27 21:22:32', '2019-10-27 21:22:57'),
(302, 0, 'en', 'messages', 'templateUpdateSuccess', 'Template update success.', '2019-10-27 21:22:32', '2019-10-27 21:23:42'),
(303, 0, 'en', 'app', 'menu.lead', 'Leads', '2019-10-27 21:22:32', '2019-10-27 21:22:57'),
(304, 0, 'en', 'messages', 'templateDeleteSuccess', 'Template deleted successfully.', '2019-10-27 21:22:32', '2019-10-27 21:23:42'),
(305, 0, 'en', 'app', 'menu.leadSource', 'Lead Source', '2019-10-27 21:22:32', '2019-10-27 21:22:58'),
(306, 0, 'en', 'messages', 'ticketTypeAddSuccess', 'Ticket type added successfully.', '2019-10-27 21:22:32', '2019-10-27 21:23:42'),
(307, 0, 'en', 'app', 'menu.leadStatus', 'Lead Status', '2019-10-27 21:22:32', '2019-10-27 21:22:58'),
(308, 0, 'en', 'messages', 'ticketTypeUpdateSuccess', 'Ticket type updated successfully.', '2019-10-27 21:22:32', '2019-10-27 21:23:42'),
(309, 0, 'en', 'app', 'menu.products', 'Products', '2019-10-27 21:22:32', '2019-10-27 21:22:58'),
(310, 0, 'en', 'messages', 'ticketTypeDeleteSuccess', 'Ticket type deleted successfully.', '2019-10-27 21:22:32', '2019-10-27 21:23:42'),
(311, 0, 'en', 'app', 'menu.holiday', 'Holiday', '2019-10-27 21:22:32', '2019-10-27 21:22:58'),
(312, 0, 'en', 'auth', 'recaptchaFailed', 'Recaptcha no valida.', '2019-10-27 21:22:32', '2019-10-27 21:28:43'),
(313, 0, 'en', 'app', 'menu.offlinePaymentMethod', 'Offline Payment Method', '2019-10-27 21:22:32', '2019-10-27 21:22:58'),
(314, 0, 'en', 'messages', 'issueCreated', 'Issue created successfully.', '2019-10-27 21:22:32', '2019-10-27 21:23:36'),
(315, 0, 'en', 'app', 'menu.onlinePayment', 'Online Payment Credential', '2019-10-27 21:22:32', '2019-10-27 21:22:58'),
(316, 0, 'en', 'messages', 'issueUpdated', 'Issue updated successfully.', '2019-10-27 21:22:32', '2019-10-27 21:23:36'),
(317, 0, 'en', 'app', 'menu.method', 'Method', '2019-10-27 21:22:32', '2019-10-27 21:22:59'),
(318, 0, 'en', 'messages', 'issueDeleted', 'Issue deleted successfully.', '2019-10-27 21:22:32', '2019-10-27 21:23:37'),
(319, 0, 'en', 'app', 'menu.timeLogSettings', 'Time Log Settings', '2019-10-27 21:22:33', '2019-10-27 21:22:59'),
(320, 0, 'en', 'messages', 'profileUpdated', 'Profile updated successfully.', '2019-10-27 21:22:33', '2019-10-27 21:23:35'),
(321, 0, 'en', 'app', 'menu.projectTemplate', 'Project Template', '2019-10-27 21:22:33', '2019-10-27 21:22:59'),
(322, 0, 'en', 'messages', 'companyChanged', 'Company changed successfully.', '2019-10-27 21:22:33', '2019-10-27 21:23:51'),
(323, 0, 'en', 'modules', 'client.viewDetails', 'View Details', '2019-10-27 21:22:33', '2019-10-27 21:24:00'),
(324, 0, 'en', 'app', 'menu.projectTemplateMember', 'Project Template Member', '2019-10-27 21:22:33', '2019-10-27 21:22:59'),
(325, 0, 'en', 'modules', 'timeLogs.startTimer', 'Start Timer', '2019-10-27 21:22:33', '2019-10-27 21:24:22'),
(326, 0, 'en', 'app', 'menu.addProjectTemplate', 'Project Templates', '2019-10-27 21:22:33', '2019-10-27 21:22:59'),
(327, 0, 'en', 'messages', 'notAnAuthorisedDevice', 'This is not an authorised device for clock-in or clock-out', '2019-10-27 21:22:33', '2019-10-27 21:23:38'),
(328, 0, 'en', 'app', 'menu.template', 'Template', '2019-10-27 21:22:33', '2019-10-27 21:22:59'),
(329, 0, 'en', 'messages', 'notAnValidLocation', 'This is not an valid location for clock-in or clock-out', '2019-10-27 21:22:33', '2019-10-27 21:23:38'),
(330, 0, 'en', 'app', 'menu.leadFiles', 'Lead Files', '2019-10-27 21:22:33', '2019-10-27 21:23:00'),
(331, 0, 'en', 'messages', 'clientAdded', 'Client info added successfully.', '2019-10-27 21:22:33', '2019-10-27 21:23:33'),
(332, 0, 'en', 'app', 'menu.pushNotifications', 'Push Notifications', '2019-10-27 21:22:33', '2019-10-27 21:23:00'),
(333, 0, 'en', 'messages', 'clientUpdated', 'Client info updated successfully.', '2019-10-27 21:22:33', '2019-10-27 21:23:33'),
(334, 0, 'en', 'app', 'menu.notificationSettings', 'Notification Settings', '2019-10-27 21:22:33', '2019-10-27 21:23:00'),
(335, 0, 'en', 'messages', 'unAuthorisedUser', 'You are not authorised user.', '2019-10-27 21:22:33', '2019-10-27 21:23:28'),
(336, 0, 'en', 'app', 'menu.viewArchive', 'View Archive', '2019-10-27 21:22:33', '2019-10-27 21:23:00'),
(337, 0, 'en', 'messages', 'updatedProfile', 'Updated profile.', '2019-10-27 21:22:33', '2019-10-27 21:23:31'),
(338, 0, 'en', 'app', 'menu.clientModule', 'Client Module Setting', '2019-10-27 21:22:34', '2019-10-27 21:23:00'),
(339, 0, 'en', 'messages', 'taskUpdated', 'Marked the task as ', '2019-10-27 21:22:34', '2019-10-27 21:23:31'),
(340, 0, 'en', 'app', 'menu.employeeModule', 'Employee Module Setting', '2019-10-27 21:22:34', '2019-10-27 21:23:00'),
(341, 0, 'en', 'messages', 'sortDone', 'Sorting done.', '2019-10-27 21:22:34', '2019-10-27 21:23:48'),
(342, 0, 'en', 'app', 'menu.adminModule', 'Admin Module Setting', '2019-10-27 21:22:34', '2019-10-27 21:23:00'),
(343, 0, 'en', 'messages', 'timerStartedTask', 'Started the timer for task ', '2019-10-27 21:22:34', '2019-10-27 21:23:48'),
(344, 0, 'en', 'app', 'menu.documents', 'Documents', '2019-10-27 21:22:34', '2019-10-27 21:23:00'),
(345, 0, 'en', 'messages', 'timerStartedBy', 'Timer started by', '2019-10-27 21:22:34', '2019-10-27 21:23:29'),
(346, 0, 'en', 'app', 'menu.employeeDocs', 'Employee Documents', '2019-10-27 21:22:34', '2019-10-27 21:23:01'),
(347, 0, 'en', 'messages', 'timerStartedProject', 'Started the timer for project ', '2019-10-27 21:22:34', '2019-10-27 21:23:30'),
(348, 0, 'en', 'app', 'menu.pushNotificationSetting', 'Push Notification Setting', '2019-10-27 21:22:34', '2019-10-27 21:23:01'),
(349, 0, 'en', 'messages', 'timerStartedSuccessfully', 'Timer started successfully.', '2019-10-27 21:22:34', '2019-10-27 21:23:29'),
(350, 0, 'en', 'app', 'menu.companies', 'Companies', '2019-10-27 21:22:34', '2019-10-27 21:23:01'),
(351, 0, 'en', 'messages', 'timerAlreadyRunning', 'Timer is already running.', '2019-10-27 21:22:34', '2019-10-27 21:23:50'),
(352, 0, 'en', 'app', 'menu.packages', 'Packages', '2019-10-27 21:22:34', '2019-10-27 21:23:01'),
(353, 0, 'en', 'messages', 'timerStoppedBy', 'Timer stopped by', '2019-10-27 21:22:34', '2019-10-27 21:23:28'),
(354, 0, 'en', 'app', 'menu.billing', 'Billing', '2019-10-27 21:22:34', '2019-10-27 21:23:01'),
(355, 0, 'en', 'messages', 'notificationRead', 'Notification marked as read.', '2019-10-27 21:22:34', '2019-10-27 21:23:45'),
(356, 0, 'en', 'app', 'menu.features', 'FEATURES', '2019-10-27 21:22:34', '2019-10-27 21:23:01'),
(357, 0, 'en', 'modules', 'superadmin.verified', 'Verified', '2019-10-27 21:22:34', '2019-10-27 21:25:35'),
(358, 0, 'en', 'app', 'menu.pricing', 'PRICING', '2019-10-27 21:22:34', '2019-10-27 21:23:01'),
(359, 0, 'en', 'modules', 'superadmin.registerDate', 'Register Date', '2019-10-27 21:22:34', '2019-10-27 21:25:35'),
(360, 0, 'en', 'app', 'menu.contact', 'CONTACT', '2019-10-27 21:22:34', '2019-10-27 21:23:01'),
(361, 0, 'en', 'modules', 'superadmin.totalUsers', 'Total Users', '2019-10-27 21:22:35', '2019-10-27 21:25:35'),
(362, 0, 'en', 'app', 'menu.credit-note', 'Credit Note', '2019-10-27 21:22:35', '2019-10-27 21:23:02'),
(363, 0, 'en', 'messages', 'userDeleted', NULL, '2019-10-27 21:22:35', '2019-10-27 21:22:35'),
(364, 0, 'en', 'app', 'menu.financeSettings', 'Finance Settings', '2019-10-27 21:22:35', '2019-10-27 21:23:02'),
(365, 0, 'en', 'messages', 'smtpError', 'Your SMTP details are not correct. Please update to correct one', '2019-10-27 21:22:35', '2019-10-27 21:23:53'),
(366, 0, 'en', 'app', 'menu.accountSetup', 'Account Setup', '2019-10-27 21:22:35', '2019-10-27 21:23:02'),
(367, 0, 'en', 'messages', 'smtpSecureEnabled', 'Please check if you have enabled less secure app on your account from here ', '2019-10-27 21:22:35', '2019-10-27 21:23:53'),
(368, 0, 'en', 'app', 'menu.faq', 'FAQ', '2019-10-27 21:22:35', '2019-10-27 21:23:02'),
(369, 0, 'en', 'messages', 'uploadSuccess', 'Details updated successfully.', '2019-10-27 21:22:35', '2019-10-27 21:23:51'),
(370, 0, 'en', 'messages', 'languageUpdated', 'Language updated successfully', '2019-10-27 21:22:35', '2019-10-27 21:24:22'),
(371, 0, 'en', 'app', 'menu.faqCategory', 'FAQ Category', '2019-10-27 21:22:35', '2019-10-27 21:23:02'),
(372, 0, 'en', 'messages', 'languageAdded', 'Language added successfully.', '2019-10-27 21:22:35', '2019-10-27 21:23:54'),
(373, 0, 'en', 'messages', 'languageDeleted', 'Language deleted successfully', '2019-10-27 21:22:35', '2019-10-27 21:23:54'),
(374, 0, 'en', 'app', 'exportExcel', 'Export To Excel', '2019-10-27 21:22:35', '2019-10-27 21:23:02'),
(375, 0, 'en', 'app', 'package', 'Package', '2019-10-27 21:22:35', '2019-10-27 21:23:20'),
(376, 0, 'en', 'app', 'datatable', '//cdn.datatables.net/plug-ins/1.10.15/i18n/English.json', '2019-10-27 21:22:35', '2019-10-27 21:23:03'),
(377, 0, 'en', 'messages', 'superAdminUpdated', 'Super Admin info updated successfully.', '2019-10-27 21:22:35', '2019-10-27 21:23:38'),
(378, 0, 'en', 'app', 'role', 'User Role', '2019-10-27 21:22:35', '2019-10-27 21:23:03'),
(379, 0, 'en', 'messages', 'atleastOneValidation', 'Choose at-least 1', '2019-10-27 21:22:36', '2019-10-27 21:23:45'),
(380, 0, 'en', 'app', 'projectAdminPanel', 'Project Admin Panel', '2019-10-27 21:22:36', '2019-10-27 21:23:03'),
(381, 0, 'en', 'messages', 'chooseProject', 'Choose a project.', '2019-10-27 21:22:36', '2019-10-27 21:23:45'),
(382, 0, 'en', 'app', 'loginAsProjectAdmin', 'Login As Project Admin', '2019-10-27 21:22:36', '2019-10-27 21:23:03'),
(383, 0, 'en', 'modules', 'tickets.groupName', 'Group Name', '2019-10-27 21:22:36', '2019-10-27 21:24:48'),
(384, 0, 'en', 'app', 'required', 'Required', '2019-10-27 21:22:36', '2019-10-27 21:23:06'),
(385, 0, 'en', 'app', 'price', 'Price', '2019-10-27 21:22:36', '2019-10-27 21:23:04'),
(386, 0, 'en', 'modules', 'tickets.requesterName', 'Requester Name', '2019-10-27 21:22:36', '2019-10-27 21:24:50'),
(387, 0, 'en', 'app', 'duration', 'Duration', '2019-10-27 21:22:36', '2019-10-27 21:23:04'),
(388, 0, 'en', 'email', 'cancelLicense.subject', 'License cancelled due to failed payment.', '2019-10-27 21:22:36', '2019-10-27 21:23:27'),
(389, 0, 'en', 'app', 'last', 'Last', '2019-10-27 21:22:36', '2019-10-27 21:23:04'),
(390, 0, 'en', 'email', 'hello', 'Hello', '2019-10-27 21:22:36', '2019-10-27 21:23:24'),
(391, 0, 'en', 'app', 'month', 'Month', '2019-10-27 21:22:36', '2019-10-27 21:23:04'),
(392, 0, 'en', 'email', 'cancelLicense.text', 'License has been cancelled due to the failed payment. Please check the details.', '2019-10-27 21:22:36', '2019-10-27 21:23:27'),
(393, 0, 'en', 'app', 'select', 'Select', '2019-10-27 21:22:36', '2019-10-27 21:23:04'),
(394, 0, 'en', 'modules', 'accountSettings.companyName', 'Company Name', '2019-10-27 21:22:37', '2019-10-27 21:24:26'),
(395, 0, 'en', 'app', 'income', 'Income', '2019-10-27 21:22:37', '2019-10-27 21:23:05'),
(396, 0, 'en', 'modules', 'payments.paidOn', 'Paid On', '2019-10-27 21:22:37', '2019-10-27 21:24:47'),
(397, 0, 'en', 'app', 'expense', 'Expense', '2019-10-27 21:22:37', '2019-10-27 21:23:05'),
(398, 0, 'en', 'app', 'total', 'Total', '2019-10-27 21:22:37', '2019-10-27 21:23:05'),
(399, 0, 'en', 'email', 'loginDashboard', 'Login To Dashboard', '2019-10-27 21:22:37', '2019-10-27 21:23:24'),
(400, 0, 'en', 'email', 'thankyouNote', 'Thank you for using our application!', '2019-10-27 21:22:37', '2019-10-27 21:23:24'),
(401, 0, 'en', 'app', 'year', 'Year', '2019-10-27 21:22:37', '2019-10-27 21:23:05'),
(402, 0, 'en', 'email', 'planPurchase.subject', NULL, '2019-10-27 21:22:37', '2019-10-27 21:22:37'),
(403, 0, 'en', 'app', 'yes', 'Yes', '2019-10-27 21:22:37', '2019-10-27 21:23:05'),
(404, 0, 'en', 'email', 'planPurchase.text', 'Company purchased plan', '2019-10-27 21:22:38', '2019-10-27 21:23:27'),
(405, 0, 'en', 'app', 'no', 'No', '2019-10-27 21:22:38', '2019-10-27 21:23:05'),
(406, 0, 'en', 'email', 'planUpdate.subject', 'Company updated plan.', '2019-10-27 21:22:38', '2019-10-27 21:23:26'),
(407, 0, 'en', 'app', 'day', 'Day', '2019-10-27 21:22:38', '2019-10-27 21:23:05'),
(408, 0, 'en', 'email', 'newEvent.subject', 'New Event Created', '2019-10-27 21:22:38', '2019-10-27 21:23:24'),
(409, 0, 'en', 'app', 'week', 'Week', '2019-10-27 21:22:38', '2019-10-27 21:23:05'),
(410, 0, 'en', 'email', 'newEvent.text', 'New event has been created. Download the attachment to add event to your calendar.', '2019-10-27 21:22:38', '2019-10-27 21:23:24'),
(411, 0, 'en', 'app', 'submit', 'Submit', '2019-10-27 21:22:38', '2019-10-27 21:23:06'),
(412, 0, 'en', 'email', 'invoices.paymentReceived', 'Payment received for invoice.', '2019-10-27 21:22:38', '2019-10-27 21:23:27'),
(413, 0, 'en', 'email', 'leave.applied', 'Leave application applied.', '2019-10-27 21:22:38', '2019-10-27 21:23:26'),
(414, 0, 'en', 'app', 'filterBy', 'Filter by', '2019-10-27 21:22:38', '2019-10-27 21:23:06'),
(415, 0, 'en', 'email', 'leaves.statusSubject', 'Leave application status updated', '2019-10-27 21:22:38', '2019-10-27 21:23:25'),
(416, 0, 'en', 'app', 'others', 'Others', '2019-10-27 21:22:38', '2019-10-27 21:23:06'),
(417, 0, 'en', 'email', 'leave.approve', 'Leave application approved.', '2019-10-27 21:22:38', '2019-10-27 21:23:26'),
(418, 0, 'en', 'email', 'leave.reject', 'Leave application rejected.', '2019-10-27 21:22:38', '2019-10-27 21:23:26'),
(419, 0, 'en', 'app', 'close', 'Close', '2019-10-27 21:22:38', '2019-10-27 21:23:06'),
(420, 0, 'en', 'app', 'reason', 'Reason', '2019-10-27 21:22:38', '2019-10-27 21:23:16'),
(421, 0, 'en', 'app', 'value', 'Value', '2019-10-27 21:22:39', '2019-10-27 21:23:07'),
(422, 0, 'en', 'email', 'licenseExpire.subject', 'Company Licence expired.', '2019-10-27 21:22:39', '2019-10-27 21:23:26'),
(423, 0, 'en', 'app', 'add', 'Add', '2019-10-27 21:22:39', '2019-10-27 21:23:07'),
(424, 0, 'en', 'email', 'licenseExpire.text', 'Your company license has been expired. Please check billing details.', '2019-10-27 21:22:39', '2019-10-27 21:23:26'),
(425, 0, 'en', 'app', 'view', 'View', '2019-10-27 21:22:39', '2019-10-27 21:23:07'),
(426, 0, 'en', 'email', 'licenseExpirePre.subject', 'Company license Expiring soon.', '2019-10-27 21:22:39', '2019-10-27 21:23:26'),
(427, 0, 'en', 'app', 'accept', 'Accept', '2019-10-27 21:22:39', '2019-10-27 21:23:07'),
(428, 0, 'en', 'email', 'licenseExpirePre.text', 'Your company license is expiring soon Please check billing details.', '2019-10-27 21:22:39', '2019-10-27 21:23:26'),
(429, 0, 'en', 'email', 'newClientTask.subject', 'New Task Generated', '2019-10-27 21:22:39', '2019-10-27 21:23:26'),
(430, 0, 'en', 'app', 'to', 'To', '2019-10-27 21:22:39', '2019-10-27 21:23:07'),
(431, 0, 'en', 'email', 'newTask.subject', 'New Task Assigned to You', '2019-10-27 21:22:39', '2019-10-27 21:23:25'),
(432, 0, 'en', 'app', 'monday', 'Monday', '2019-10-27 21:22:39', '2019-10-27 21:23:08'),
(433, 0, 'en', 'email', 'newCompany.subject', 'New company registered', '2019-10-27 21:22:39', '2019-10-27 21:23:26'),
(434, 0, 'en', 'app', 'tuesday', 'Tuesday', '2019-10-27 21:22:39', '2019-10-27 21:23:08'),
(435, 0, 'en', 'email', 'newCompany.text', 'New company has been registered.', '2019-10-27 21:22:39', '2019-10-27 21:23:26'),
(436, 0, 'en', 'app', 'wednesday', 'Wednesday', '2019-10-27 21:22:39', '2019-10-27 21:23:08'),
(437, 0, 'en', 'email', 'newExpense.subject', 'New Expense added', '2019-10-27 21:22:39', '2019-10-27 21:23:24'),
(438, 0, 'en', 'app', 'thursday', 'Thursday', '2019-10-27 21:22:39', '2019-10-27 21:23:08'),
(439, 0, 'en', 'email', 'expenseStatus.subject', 'Expense status updated', '2019-10-27 21:22:40', '2019-10-27 21:23:24'),
(440, 0, 'en', 'app', 'friday', 'Friday', '2019-10-27 21:22:40', '2019-10-27 21:23:08'),
(441, 0, 'en', 'email', 'expenseStatus.text', 'Your expense status updated to', '2019-10-27 21:22:40', '2019-10-27 21:23:24'),
(442, 0, 'en', 'app', 'saturday', 'Saturday', '2019-10-27 21:22:40', '2019-10-27 21:23:08'),
(443, 0, 'en', 'email', 'leaves.subject', 'New leave request received', '2019-10-27 21:22:40', '2019-10-27 21:23:25'),
(444, 0, 'en', 'app', 'sunday', 'Sunday', '2019-10-27 21:22:40', '2019-10-27 21:23:08'),
(445, 0, 'en', 'modules', 'leaves.leaveType', 'Leave Type', '2019-10-27 21:22:40', '2019-10-27 21:24:59'),
(446, 0, 'en', 'app', 'newNotifications', 'New notifications', '2019-10-27 21:22:40', '2019-10-27 21:23:08'),
(447, 0, 'en', 'app', 'from', 'From', '2019-10-27 21:22:40', '2019-10-27 21:23:08');
INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(448, 0, 'en', 'modules', 'leaves.reason', 'Reason for absence', '2019-10-27 21:22:40', '2019-10-27 21:25:00'),
(449, 0, 'en', 'app', 'cancel', 'Cancel', '2019-10-27 21:22:40', '2019-10-27 21:23:09'),
(450, 0, 'en', 'email', 'newNotice.subject', 'New Notice Published', '2019-10-27 21:22:40', '2019-10-27 21:23:25'),
(451, 0, 'en', 'app', 'january', 'January', '2019-10-27 21:22:41', '2019-10-27 21:23:09'),
(452, 0, 'en', 'email', 'newNotice.text', 'New notice has been published. Login to view the notice.', '2019-10-27 21:22:41', '2019-10-27 21:23:25'),
(453, 0, 'en', 'app', 'february', 'February', '2019-10-27 21:22:41', '2019-10-27 21:23:09'),
(454, 0, 'en', 'email', 'newProjectMember.subject', 'New Project Assigned', '2019-10-27 21:22:41', '2019-10-27 21:23:25'),
(455, 0, 'en', 'app', 'march', 'March', '2019-10-27 21:22:41', '2019-10-27 21:23:09'),
(456, 0, 'en', 'email', 'newProjectMember.text', 'You have been added as a member to the project', '2019-10-27 21:22:41', '2019-10-27 21:23:25'),
(457, 0, 'en', 'app', 'april', 'April', '2019-10-27 21:22:41', '2019-10-27 21:23:09'),
(458, 0, 'en', 'email', 'newTicket.subject', 'New Support Ticket Requested', '2019-10-27 21:22:41', '2019-10-27 21:23:25'),
(459, 0, 'en', 'app', 'may', 'May', '2019-10-27 21:22:41', '2019-10-27 21:23:09'),
(460, 0, 'en', 'email', 'newTicket.text', 'New Support Ticket is requested. Login to view the ticket.', '2019-10-27 21:22:41', '2019-10-27 21:23:25'),
(461, 0, 'en', 'app', 'june', 'June', '2019-10-27 21:22:41', '2019-10-27 21:23:09'),
(462, 0, 'en', 'email', 'newUser.subject', 'Welcome to', '2019-10-27 21:22:41', '2019-10-27 21:23:25'),
(463, 0, 'en', 'app', 'july', 'July', '2019-10-27 21:22:41', '2019-10-27 21:23:09'),
(464, 0, 'en', 'email', 'newUser.text', 'Your account has been created successfully.', '2019-10-27 21:22:41', '2019-10-27 21:23:25'),
(465, 0, 'en', 'app', 'august', 'August', '2019-10-27 21:22:41', '2019-10-27 21:23:10'),
(466, 0, 'en', 'email', 'projectReminder.subject', 'Project Reminder', '2019-10-27 21:22:42', '2019-10-27 21:23:27'),
(467, 0, 'en', 'app', 'september', 'September', '2019-10-27 21:22:42', '2019-10-27 21:23:10'),
(468, 0, 'en', 'email', 'projectReminder.text', 'This is to remind you about the due date of the following projects which is', '2019-10-27 21:22:42', '2019-10-27 21:23:27'),
(469, 0, 'en', 'app', 'october', 'October', '2019-10-27 21:22:42', '2019-10-27 21:23:10'),
(470, 0, 'en', 'email', 'messages.loginForMoreDetails', 'Log in for more details.', '2019-10-27 21:22:42', '2019-10-27 21:23:27'),
(471, 0, 'en', 'app', 'november', 'November', '2019-10-27 21:22:42', '2019-10-27 21:23:10'),
(472, 0, 'en', 'email', 'taskComplete.subject', 'Task marked as complete', '2019-10-27 21:22:42', '2019-10-27 21:23:25'),
(473, 0, 'en', 'app', 'december', 'December', '2019-10-27 21:22:42', '2019-10-27 21:23:10'),
(474, 0, 'en', 'email', 'reminder.subject', 'Reminder for assigned task', '2019-10-27 21:22:42', '2019-10-27 21:23:26'),
(475, 0, 'en', 'app', 'complete', 'Complete', '2019-10-27 21:22:42', '2019-10-27 21:23:10'),
(476, 0, 'en', 'email', 'taskUpdate.subject', 'Task updated', '2019-10-27 21:22:42', '2019-10-27 21:23:26'),
(477, 0, 'en', 'app', 'low', 'Low', '2019-10-27 21:22:42', '2019-10-27 21:23:10'),
(478, 0, 'en', 'messages', 'smtpSuccess', 'Your SMTP details are correct', '2019-10-27 21:22:43', '2019-10-27 21:23:53'),
(479, 0, 'en', 'app', 'Manage role', 'Manage role', '2019-10-27 21:22:43', '2019-10-27 21:23:11'),
(480, 0, 'en', 'messages', 'smtpNotSet', 'You have not configured SMTP settings. You might get an error when adding info ', '2019-10-27 21:22:43', '2019-10-27 21:23:53'),
(481, 0, 'en', 'app', 'Search:', 'Search:', '2019-10-27 21:22:43', '2019-10-27 21:23:11'),
(482, 0, 'en', 'modules', 'permission.projectNote', 'User can view the basic details of projects assigned to him even without any permission.', '2019-10-27 21:22:43', '2019-10-27 21:24:58'),
(483, 0, 'en', 'app', 'mo', 'Mo', '2019-10-27 21:22:43', '2019-10-27 21:23:11'),
(484, 0, 'en', 'modules', 'permission.attendanceNote', 'User can view his own attendance even without any permission.', '2019-10-27 21:22:43', '2019-10-27 21:24:58'),
(485, 0, 'en', 'app', 'tu', 'Tu', '2019-10-27 21:22:43', '2019-10-27 21:23:11'),
(486, 0, 'en', 'modules', 'permission.taskNote', 'User can view the tasks assigned to him even without any permission.', '2019-10-27 21:22:43', '2019-10-27 21:24:58'),
(487, 0, 'en', 'app', 'we', 'We', '2019-10-27 21:22:43', '2019-10-27 21:23:11'),
(488, 0, 'en', 'modules', 'permission.ticketNote', 'User can view the tickets generated by him as default even without any permission.', '2019-10-27 21:22:43', '2019-10-27 21:24:58'),
(489, 0, 'en', 'app', 'th', 'Th', '2019-10-27 21:22:43', '2019-10-27 21:23:11'),
(490, 0, 'en', 'modules', 'permission.eventNote', 'User can view the events to be attended by him as default even without any permission.', '2019-10-27 21:22:43', '2019-10-27 21:24:58'),
(491, 0, 'en', 'app', 'fr', 'Fr', '2019-10-27 21:22:43', '2019-10-27 21:23:11'),
(492, 0, 'en', 'modules', 'permission.holidayNote', 'User can view the holidays as default even without any permission.', '2019-10-27 21:22:43', '2019-10-27 21:24:58'),
(493, 0, 'en', 'app', 'sa', 'Sa', '2019-10-27 21:22:43', '2019-10-27 21:23:11'),
(494, 0, 'en', 'modules', 'accountSettings.uploadLogo', 'Upload your logo', '2019-10-27 21:22:44', '2019-10-27 21:24:27'),
(495, 0, 'en', 'app', 'su', 'Su', '2019-10-27 21:22:44', '2019-10-27 21:23:12'),
(496, 0, 'en', 'modules', 'attendance.notClockOut', 'Did not clock out', '2019-10-27 21:22:44', '2019-10-27 21:24:55'),
(497, 0, 'en', 'app', 'selectFile', 'Select File', '2019-10-27 21:22:44', '2019-10-27 21:23:12'),
(498, 0, 'en', 'modules', 'attendance.holidayfor', 'Holiday for', '2019-10-27 21:22:44', '2019-10-27 21:24:54'),
(499, 0, 'en', 'app', 'login', 'Log In', '2019-10-27 21:22:44', '2019-10-27 21:23:12'),
(500, 0, 'en', 'messages', 'noRecordFound', 'No record found.', '2019-10-27 21:22:44', '2019-10-27 21:23:45'),
(501, 0, 'en', 'app', 'rememberMe', 'Remember Me', '2019-10-27 21:22:44', '2019-10-27 21:23:12'),
(502, 0, 'en', 'modules', 'attendance.attendanceDetail', 'Attendance Detail', '2019-10-27 21:22:44', '2019-10-27 21:24:54'),
(503, 0, 'en', 'modules', 'attendance.holidays', 'Holidays', '2019-10-27 21:22:44', '2019-10-27 21:24:54'),
(504, 0, 'en', 'app', 'forgotPassword', 'Forgot Password', '2019-10-27 21:22:44', '2019-10-27 21:23:12'),
(505, 0, 'en', 'app', 'welcome', 'Welcome', '2019-10-27 21:22:44', '2019-10-27 21:23:12'),
(506, 0, 'en', 'modules', 'attendance.leaveFor', 'Leave for', '2019-10-27 21:22:45', '2019-10-27 21:24:54'),
(507, 0, 'en', 'app', 'admin', 'Admin', '2019-10-27 21:22:45', '2019-10-27 21:23:12'),
(508, 0, 'en', 'modules', 'attendance.ipAddress', 'IP Address', '2019-10-27 21:22:45', '2019-10-27 21:24:55'),
(509, 0, 'en', 'app', 'annual', 'Annual', '2019-10-27 21:22:45', '2019-10-27 21:23:20'),
(510, 0, 'en', 'app', 'monthly', 'Monthly', '2019-10-27 21:22:45', '2019-10-27 21:23:20'),
(511, 0, 'en', 'app', 'forbiddenError', 'Forbidden Error', '2019-10-27 21:22:45', '2019-10-27 21:23:13'),
(512, 0, 'en', 'app', 'max', 'Max', '2019-10-27 21:22:45', '2019-10-27 21:23:20'),
(513, 0, 'en', 'app', 'noPermission', 'You do not have permission to access this.', '2019-10-27 21:22:46', '2019-10-27 21:23:13'),
(514, 0, 'en', 'modules', 'billing.nextPaymentDate', 'Next Payment Date', '2019-10-27 21:22:46', '2019-10-27 21:25:36'),
(515, 0, 'en', 'app', 'recoverPassword', 'Recover Password', '2019-10-27 21:22:46', '2019-10-27 21:23:13'),
(516, 0, 'en', 'modules', 'billing.previousPaymentDate', 'Previous Payment Date', '2019-10-27 21:22:46', '2019-10-27 21:25:36'),
(517, 0, 'en', 'app', 'sendPasswordLink', 'Send Reset Link', '2019-10-27 21:22:46', '2019-10-27 21:23:13'),
(518, 0, 'en', 'modules', 'projects.members', 'Members', '2019-10-27 21:22:46', '2019-10-27 21:24:06'),
(519, 0, 'en', 'app', 'enterEmailInstruction', 'Enter your Email and instructions will be sent to you!', '2019-10-27 21:22:46', '2019-10-27 21:23:13'),
(520, 0, 'en', 'modules', 'invoices.payPaypal', 'Pay via Paypal', '2019-10-27 21:22:46', '2019-10-27 21:24:17'),
(521, 0, 'en', 'app', 'medium', 'Medium', '2019-10-27 21:22:46', '2019-10-27 21:23:13'),
(522, 0, 'en', 'modules', 'invoices.payStripe', 'Pay via Stripe', '2019-10-27 21:22:46', '2019-10-27 21:24:18'),
(523, 0, 'en', 'modules', 'contacts.addContact', 'Add Contact', '2019-10-27 21:22:46', '2019-10-27 21:24:01'),
(524, 0, 'en', 'app', 'high', 'High', '2019-10-27 21:22:46', '2019-10-27 21:23:13'),
(525, 0, 'en', 'modules', 'client.createTitle', 'Add Client Info', '2019-10-27 21:22:47', '2019-10-27 21:23:59'),
(526, 0, 'en', 'app', 'urgent', 'Urgent', '2019-10-27 21:22:47', '2019-10-27 21:23:13'),
(527, 0, 'en', 'modules', 'client.updateTitle', 'Update Client Info', '2019-10-27 21:22:47', '2019-10-27 21:24:00'),
(528, 0, 'en', 'app', 'open', 'Open', '2019-10-27 21:22:47', '2019-10-27 21:23:13'),
(529, 0, 'en', 'app', 'resolved', 'Resolved', '2019-10-27 21:22:47', '2019-10-27 21:23:13'),
(530, 0, 'en', 'modules', 'estimates.convertInvoiceTitle', 'CONVERT INVOICE TO CREDIT NOTE', '2019-10-27 21:22:47', '2019-10-27 21:24:40'),
(531, 0, 'en', 'modules', 'credit-notes.item', 'Item', '2019-10-27 21:22:47', '2019-10-27 21:25:32'),
(532, 0, 'en', 'app', 'optional', 'Optional', '2019-10-27 21:22:47', '2019-10-27 21:23:14'),
(533, 0, 'en', 'modules', 'credit-notes.qty', 'Qty/Hrs', '2019-10-27 21:22:47', '2019-10-27 21:25:32'),
(534, 0, 'en', 'app', 'sampleFile', 'Sample File', '2019-10-27 21:22:47', '2019-10-27 21:23:14'),
(535, 0, 'en', 'modules', 'credit-notes.unitPrice', 'Unit Price', '2019-10-27 21:22:47', '2019-10-27 21:25:32'),
(536, 0, 'en', 'app', 'male', 'male', '2019-10-27 21:22:47', '2019-10-27 21:23:14'),
(537, 0, 'en', 'modules', 'credit-notes.tax', 'Tax', '2019-10-27 21:22:47', '2019-10-27 21:25:32'),
(538, 0, 'en', 'app', 'female', 'female', '2019-10-27 21:22:47', '2019-10-27 21:23:14'),
(539, 0, 'en', 'modules', 'credit-notes.amount', 'Amount', '2019-10-27 21:22:47', '2019-10-27 21:25:32'),
(540, 0, 'en', 'app', 'language', 'Language', '2019-10-27 21:22:47', '2019-10-27 21:23:14'),
(541, 0, 'en', 'app', 'team', 'Team', '2019-10-27 21:22:47', '2019-10-27 21:23:14'),
(542, 0, 'en', 'modules', 'invoices.tax', 'Tax', '2019-10-27 21:22:47', '2019-10-27 21:24:16'),
(543, 0, 'en', 'modules', 'credit-notes.addItem', 'Add Item', '2019-10-27 21:22:47', '2019-10-27 21:25:32'),
(544, 0, 'en', 'app', 'manage', 'Manage', '2019-10-27 21:22:47', '2019-10-27 21:23:14'),
(545, 0, 'en', 'modules', 'credit-notes.discount', 'Discount', '2019-10-27 21:22:47', '2019-10-27 21:25:33'),
(546, 0, 'en', 'app', 'upcoming', 'Upcoming', '2019-10-27 21:22:48', '2019-10-27 21:23:15'),
(547, 0, 'en', 'app', 'loading', 'Loading...', '2019-10-27 21:22:48', '2019-10-27 21:23:22'),
(548, 0, 'en', 'app', 'changes', 'changes', '2019-10-27 21:22:48', '2019-10-27 21:23:22'),
(549, 0, 'en', 'app', 'source', 'Source', '2019-10-27 21:22:48', '2019-10-27 21:23:15'),
(550, 0, 'en', 'messages', 'discountMoreThenTotal', 'Discount cannot be more than total amount.', '2019-10-27 21:22:48', '2019-10-27 21:23:52'),
(551, 0, 'en', 'app', 'next_follow_up', 'Next Follow Up', '2019-10-27 21:22:48', '2019-10-27 21:23:15'),
(552, 0, 'en', 'modules', 'projects.dropFile', 'Drop files here OR click to upload', '2019-10-27 21:22:48', '2019-10-27 21:24:26'),
(553, 0, 'en', 'app', 'followUp', 'Follow Up', '2019-10-27 21:22:48', '2019-10-27 21:23:15'),
(554, 0, 'en', 'app', 'gstIn', 'GSTIN', '2019-10-27 21:22:48', '2019-10-27 21:23:20'),
(555, 0, 'en', 'app', 'createdOn', 'Created On', '2019-10-27 21:22:49', '2019-10-27 21:23:15'),
(556, 0, 'en', 'modules', 'payments.paymentDetails', 'Payment details', '2019-10-27 21:22:49', '2019-10-27 21:24:43'),
(557, 0, 'en', 'app', 'remark', 'Remark', '2019-10-27 21:22:49', '2019-10-27 21:23:15'),
(558, 0, 'en', 'modules', 'credit-notes.downloadPdf', 'Download Pdf', '2019-10-27 21:22:49', '2019-10-27 21:25:34'),
(559, 0, 'en', 'app', 'notice', 'Note', '2019-10-27 21:22:49', '2019-10-27 21:23:16'),
(560, 0, 'en', 'app', 'minutes', 'Minutes', '2019-10-27 21:22:49', '2019-10-27 21:23:16'),
(561, 0, 'en', 'modules', 'currencySettings.exchangeRate', 'Exchange Rate', '2019-10-27 21:22:49', '2019-10-27 21:24:35'),
(562, 0, 'en', 'app', 'onLeave', 'On Leave', '2019-10-27 21:22:49', '2019-10-27 21:23:16'),
(563, 0, 'en', 'messages', 'exchangeRateNote', 'Exchange rate is calculated from your default currency. Change default currency in company settings.', '2019-10-27 21:22:49', '2019-10-27 21:23:41'),
(564, 0, 'en', 'app', 'inclusiveAllTaxes', 'Inclusive All Taxes', '2019-10-27 21:22:49', '2019-10-27 21:23:16'),
(565, 0, 'en', 'modules', 'customFields.addField', 'Add Field', '2019-10-27 21:22:49', '2019-10-27 21:24:56'),
(566, 0, 'en', 'modules', 'dashboard.totalClients', 'Total Clients', '2019-10-27 21:22:49', '2019-10-27 21:23:55'),
(567, 0, 'en', 'modules', 'dashboard.totalEmployees', 'Total Employees', '2019-10-27 21:22:49', '2019-10-27 21:23:55'),
(568, 0, 'en', 'app', 'enable', 'Enable', '2019-10-27 21:22:49', '2019-10-27 21:23:16'),
(569, 0, 'en', 'app', 'disable', 'Disable', '2019-10-27 21:22:50', '2019-10-27 21:23:17'),
(570, 0, 'en', 'modules', 'dashboard.totalProjects', 'Total Projects', '2019-10-27 21:22:50', '2019-10-27 21:23:55'),
(571, 0, 'en', 'modules', 'dashboard.totalUnpaidInvoices', 'Unpaid Invoices', '2019-10-27 21:22:50', '2019-10-27 21:23:57'),
(572, 0, 'en', 'modules', 'dashboard.totalHoursLogged', 'Hours Logged', '2019-10-27 21:22:50', '2019-10-27 21:24:22'),
(573, 0, 'en', 'app', 'all', 'All', '2019-10-27 21:22:50', '2019-10-27 21:23:17'),
(574, 0, 'en', 'modules', 'dashboard.totalPendingTasks', 'Pending Tasks', '2019-10-27 21:22:50', '2019-10-27 21:23:55'),
(575, 0, 'en', 'app', 'paid', 'Paid', '2019-10-27 21:22:50', '2019-10-27 21:23:17'),
(576, 0, 'en', 'modules', 'dashboard.totalCompletedTasks', 'Completed Tasks', '2019-10-27 21:22:50', '2019-10-27 21:23:55'),
(577, 0, 'en', 'app', 'partial', 'Partial', '2019-10-27 21:22:50', '2019-10-27 21:23:17'),
(578, 0, 'en', 'modules', 'dashboard.totalTodayAttendance', 'Today Attendance', '2019-10-27 21:22:50', '2019-10-27 21:23:57'),
(579, 0, 'en', 'modules', 'tickets.totalResolvedTickets', 'Resolved Tickets', '2019-10-27 21:22:50', '2019-10-27 21:24:50'),
(580, 0, 'en', 'app', 'global', 'Global', '2019-10-27 21:22:51', '2019-10-27 21:23:18'),
(581, 0, 'en', 'modules', 'tickets.totalUnresolvedTickets', 'Unresolved Tickets', '2019-10-27 21:22:51', '2019-10-27 21:24:51'),
(582, 0, 'en', 'app', 'superAdminPanel', 'Super Admin Panel', '2019-10-27 21:22:51', '2019-10-27 21:23:18'),
(583, 0, 'en', 'modules', 'dashboard.weatherSetLocation', 'Set current location to see weather', '2019-10-27 21:22:51', '2019-10-27 21:23:57'),
(584, 0, 'en', 'messages', 'earningChartNote', 'The earnings are mentioned in your base currency. You can change it here.', '2019-10-27 21:22:51', '2019-10-27 21:23:28'),
(585, 0, 'en', 'app', 'earnings', 'Earnings', '2019-10-27 21:22:51', '2019-10-27 21:23:18'),
(586, 0, 'en', 'messages', 'noTicketFound', 'No ticket found.', '2019-10-27 21:22:51', '2019-10-27 21:23:44'),
(587, 0, 'en', 'app', 'watchTutorial', 'Watch Tutorial', '2019-10-27 21:22:51', '2019-10-27 21:23:18'),
(588, 0, 'en', 'messages', 'noOpenTasks', 'No open tasks.', '2019-10-27 21:22:51', '2019-10-27 21:23:31'),
(589, 0, 'en', 'app', 'skills', 'Skills', '2019-10-27 21:22:52', '2019-10-27 21:23:18'),
(590, 0, 'en', 'messages', 'noPendingLeadFollowUps', 'No pending follow-up.', '2019-10-27 21:22:52', '2019-10-27 21:23:47'),
(591, 0, 'en', 'app', 'latitude', 'Latitude', '2019-10-27 21:22:52', '2019-10-27 21:23:19'),
(592, 0, 'en', 'modules', 'emailSettings.notificationSubtitle', 'Select the events for which an email should be sent to user.', '2019-10-27 21:22:52', '2019-10-27 21:24:30'),
(593, 0, 'en', 'modules', 'employees.createTitle', 'Add Employee Info', '2019-10-27 21:22:52', '2019-10-27 21:24:24'),
(594, 0, 'en', 'app', 'longitude', 'Longitude', '2019-10-27 21:22:52', '2019-10-27 21:23:19'),
(595, 0, 'en', 'app', 'front', 'Front', '2019-10-27 21:22:52', '2019-10-27 21:23:19'),
(596, 0, 'en', 'modules', 'employees.passwordNote', 'Employee will login using this password.', '2019-10-27 21:22:52', '2019-10-27 21:24:02'),
(597, 0, 'en', 'app', 'image', 'Image', '2019-10-27 21:22:52', '2019-10-27 21:23:19'),
(598, 0, 'en', 'modules', 'employees.slackUsername', 'Slack Username', '2019-10-27 21:22:52', '2019-10-27 21:24:03'),
(599, 0, 'en', 'app', 'icon', 'Icon', '2019-10-27 21:22:52', '2019-10-27 21:23:19'),
(600, 0, 'en', 'modules', 'profile.uploadPicture', 'Upload your picture', '2019-10-27 21:22:52', '2019-10-27 21:24:30'),
(601, 0, 'en', 'app', 'featureWithImage', 'Feature With Image', '2019-10-27 21:22:52', '2019-10-27 21:23:19'),
(602, 0, 'en', 'messages', 'manageDepartment', NULL, '2019-10-27 21:22:52', '2019-10-27 21:22:52'),
(603, 0, 'en', 'app', 'featureWithIcon', 'Feature With Icon', '2019-10-27 21:22:52', '2019-10-27 21:23:19'),
(604, 0, 'en', 'messages', 'employeeDocsAllowedFormat', 'Allowed file formats: jpg, png, gif, doc, docx, xls, xlsx, pdf, txt.', '2019-10-27 21:22:53', '2019-10-27 21:23:38'),
(605, 0, 'en', 'app', 'gstNumber', 'GST Number', '2019-10-27 21:22:53', '2019-10-27 21:23:19'),
(606, 0, 'en', 'modules', 'employees.updateTitle', 'update Employee Info', '2019-10-27 21:22:53', '2019-10-27 21:24:02'),
(607, 0, 'en', 'app', 'showGst', 'Show GST Number', '2019-10-27 21:22:53', '2019-10-27 21:23:20'),
(608, 0, 'en', 'modules', 'employees.updatePasswordNote', 'Employee will login using this password. (Leave blank to keep current password)', '2019-10-27 21:22:53', '2019-10-27 21:24:02'),
(609, 0, 'en', 'modules', 'dashboard.freeEmployees', 'Not working on project', '2019-10-27 21:22:53', '2019-10-27 21:24:23'),
(610, 0, 'en', 'app', 'module', 'Module', '2019-10-27 21:22:53', '2019-10-27 21:23:20'),
(611, 0, 'en', 'modules', 'estimates.createEstimate', 'Create Estimate', '2019-10-27 21:22:53', '2019-10-27 21:24:39'),
(612, 0, 'en', 'modules', 'invoices.item', 'Item', '2019-10-27 21:22:53', '2019-10-27 21:24:16'),
(613, 0, 'en', 'app', 'mobileNumber', 'Mobile Number', '2019-10-27 21:22:53', '2019-10-27 21:23:20'),
(614, 0, 'en', 'modules', 'invoices.qty', 'Qty/Hrs', '2019-10-27 21:22:53', '2019-10-27 21:24:16'),
(615, 0, 'en', 'app', 'superAdmin', 'Super Admin', '2019-10-27 21:22:53', '2019-10-27 21:23:20'),
(616, 0, 'en', 'modules', 'invoices.unitPrice', 'Unit Price', '2019-10-27 21:22:53', '2019-10-27 21:24:16'),
(617, 0, 'en', 'app', 'new', 'New', '2019-10-27 21:22:53', '2019-10-27 21:23:20'),
(618, 0, 'en', 'modules', 'invoices.amount', 'Amount', '2019-10-27 21:22:53', '2019-10-27 21:24:29'),
(619, 0, 'en', 'app', 'password', 'Password', '2019-10-27 21:22:54', '2019-10-27 21:23:20'),
(620, 0, 'en', 'modules', 'invoices.addItem', 'Add Item', '2019-10-27 21:22:54', '2019-10-27 21:24:29'),
(621, 0, 'en', 'app', 'freeTrial', 'Free Trial', '2019-10-27 21:22:54', '2019-10-27 21:23:20'),
(622, 0, 'en', 'modules', 'invoices.discount', 'Discount', '2019-10-27 21:22:54', '2019-10-27 21:24:16'),
(623, 0, 'en', 'modules', 'estimates.updateEstimate', 'Update Estimate', '2019-10-27 21:22:54', '2019-10-27 21:24:40'),
(624, 0, 'en', 'modules', 'events.viewAttendees', 'View Attendees', '2019-10-27 21:22:54', '2019-10-27 21:24:57'),
(625, 0, 'en', 'modules', 'events.addEvent', 'Add Event', '2019-10-27 21:22:55', '2019-10-27 21:24:56'),
(626, 0, 'en', 'app', 'webhook', 'Webhook URL', '2019-10-27 21:22:55', '2019-10-27 21:23:20'),
(627, 0, 'en', 'modules', 'messages.chooseMember', 'Choose Member', '2019-10-27 21:22:55', '2019-10-27 21:24:35'),
(628, 0, 'en', 'app', 'searchResults', 'Search Results', '2019-10-27 21:22:55', '2019-10-27 21:23:20'),
(629, 0, 'en', 'modules', 'projects.selectClient', 'Select Client', '2019-10-27 21:22:55', '2019-10-27 21:24:25'),
(630, 0, 'en', 'app', 'estimate', 'Estimate', '2019-10-27 21:22:55', '2019-10-27 21:23:21'),
(631, 0, 'en', 'modules', 'expenses.addExpense', 'Add Expense', '2019-10-27 21:22:55', '2019-10-27 21:24:43'),
(632, 0, 'en', 'app', 'leave_type', 'Leave Type', '2019-10-27 21:22:55', '2019-10-27 21:23:21'),
(633, 0, 'en', 'app', 'tableView', 'Table View', '2019-10-27 21:22:55', '2019-10-27 21:23:21'),
(634, 0, 'en', 'modules', 'expenses.updateExpense', 'Update Expense', '2019-10-27 21:22:55', '2019-10-27 21:24:43'),
(635, 0, 'en', 'app', 'calendarView', 'Calendar View', '2019-10-27 21:22:56', '2019-10-27 21:23:21'),
(636, 0, 'en', 'modules', 'holiday.title', 'Holiday', '2019-10-27 21:22:56', '2019-10-27 21:25:10'),
(637, 0, 'en', 'app', 'disableCache', 'Disable Cache', '2019-10-27 21:22:56', '2019-10-27 21:23:21'),
(638, 0, 'en', 'modules', 'holiday.occasion', 'Occasion', '2019-10-27 21:22:56', '2019-10-27 21:25:10'),
(639, 0, 'en', 'app', 'refreshCache', 'Refresh Cache', '2019-10-27 21:22:56', '2019-10-27 21:23:21'),
(640, 0, 'en', 'app', 'enableCache', 'Enable Cache', '2019-10-27 21:22:56', '2019-10-27 21:23:21'),
(641, 0, 'en', 'modules', 'holiday.listOf', 'List Of', '2019-10-27 21:22:56', '2019-10-27 21:25:10'),
(642, 0, 'en', 'modules', 'holiday.markSunday', ' Mark Default Holidays', '2019-10-27 21:22:56', '2019-10-27 21:25:10'),
(643, 0, 'en', 'app', 'company_name', 'Company Name', '2019-10-27 21:22:56', '2019-10-27 21:23:21'),
(644, 0, 'en', 'modules', 'holiday.markHoliday', 'Mark Holiday', '2019-10-27 21:22:56', '2019-10-27 21:25:11'),
(645, 0, 'en', 'app', 'invoiceNumber', 'Invoice Number', '2019-10-27 21:22:56', '2019-10-27 21:23:21'),
(646, 0, 'en', 'modules', 'estimates.convertEstimateTitle', 'Convert Estimate To Invoice', '2019-10-27 21:22:57', '2019-10-27 21:24:40'),
(647, 0, 'en', 'app', 'purchasePackage', 'Purchase Package', '2019-10-27 21:22:57', '2019-10-27 21:23:21'),
(648, 0, 'en', 'modules', 'proposal.convertProposalTitle', 'Convert Proposal To Invoice', '2019-10-27 21:22:57', '2019-10-27 21:25:06'),
(649, 0, 'en', 'app', 'list', 'List', '2019-10-27 21:22:57', '2019-10-27 21:23:21'),
(650, 0, 'en', 'modules', 'invoices.type', 'Type', '2019-10-27 21:22:57', '2019-10-27 21:24:17'),
(651, 0, 'en', 'app', 'thumbnail', 'Thumbnail', '2019-10-27 21:22:57', '2019-10-27 21:23:21'),
(652, 0, 'en', 'modules', 'invoices.addInvoice', 'Add Invoice', '2019-10-27 21:22:57', '2019-10-27 21:24:15'),
(653, 0, 'en', 'app', 'zero', 'Zero', '2019-10-27 21:22:57', '2019-10-27 21:23:21'),
(654, 0, 'en', 'modules', 'invoices.downloadPdf', 'Download Pdf', '2019-10-27 21:22:57', '2019-10-27 21:24:29'),
(655, 0, 'en', 'app', 'company', 'Company', '2019-10-27 21:22:57', '2019-10-27 21:23:22'),
(656, 0, 'en', 'app', 'copied', 'copied', '2019-10-27 21:22:57', '2019-10-27 21:23:22'),
(657, 0, 'en', 'modules', 'lead.createTitle', 'Add Lead Info', '2019-10-27 21:22:57', '2019-10-27 21:25:02'),
(658, 0, 'en', 'modules', 'lead.updateTitle', 'Update Lead Info', '2019-10-27 21:22:57', '2019-10-27 21:25:03'),
(659, 0, 'en', 'app', 'viewInvoice', 'View Invoice', '2019-10-27 21:22:57', '2019-10-27 21:23:22'),
(660, 0, 'en', 'modules', 'followup.updateFollow', 'Update Follow Up', '2019-10-27 21:22:57', '2019-10-27 21:25:07'),
(661, 0, 'en', 'app', 'viewPayments', 'View Payments', '2019-10-27 21:22:58', '2019-10-27 21:23:22'),
(662, 0, 'en', 'modules', 'followup.newFollowUp', 'New Follow Up', '2019-10-27 21:22:58', '2019-10-27 21:25:07'),
(663, 0, 'en', 'app', 'billedTo', 'Billed To', '2019-10-27 21:22:58', '2019-10-27 21:23:22'),
(664, 0, 'en', 'app', 'thanks', 'Thanks', '2019-10-27 21:22:58', '2019-10-27 21:23:22'),
(665, 0, 'en', 'modules', 'followup.followUpNote', 'Follow up add and edit functionality will work when lead <b>next follow up</b> will <b>YES</b>.', '2019-10-27 21:22:58', '2019-10-27 21:25:10'),
(666, 0, 'en', 'modules', 'lead.leadFollowUp', 'Follow Up Next', '2019-10-27 21:22:58', '2019-10-27 21:25:04'),
(667, 0, 'en', 'app', 'terms', 'Terms', '2019-10-27 21:22:58', '2019-10-27 21:23:22'),
(668, 0, 'en', 'app', 'congratulations', 'Congratulations', '2019-10-27 21:22:58', '2019-10-27 21:23:22'),
(669, 0, 'en', 'messages', 'noFileUploaded', 'You have not uploaded any file.', '2019-10-27 21:22:58', '2019-10-27 21:23:31'),
(670, 0, 'en', 'modules', 'projects.uploadFile', 'Upload File', '2019-10-27 21:22:58', '2019-10-27 21:24:26'),
(671, 0, 'en', 'app', 'paperlessOffice', 'You have taken the first step to create a paperless office', '2019-10-27 21:22:58', '2019-10-27 21:23:22'),
(672, 0, 'en', 'app', 'info', 'Info', '2019-10-27 21:22:59', '2019-10-27 21:23:22'),
(673, 0, 'en', 'modules', 'lead.leadSource', 'Lead Source', '2019-10-27 21:22:59', '2019-10-27 21:25:03'),
(674, 0, 'en', 'app', 'signup', 'Sign Up', '2019-10-27 21:22:59', '2019-10-27 21:23:22'),
(675, 0, 'en', 'messages', 'noLeadSourceAdded', 'No lead source added.', '2019-10-27 21:22:59', '2019-10-27 21:23:46'),
(676, 0, 'en', 'modules', 'lead.leadStatus', 'Lead Status', '2019-10-27 21:22:59', '2019-10-27 21:25:04'),
(677, 0, 'en', 'app', 'summary', 'Summary', '2019-10-27 21:22:59', '2019-10-27 21:23:23'),
(678, 0, 'en', 'messages', 'noLeadStatusAdded', 'No lead status added.', '2019-10-27 21:22:59', '2019-10-27 21:23:46'),
(679, 0, 'en', 'modules', 'leaves.calendarView', 'Calendar View', '2019-10-27 21:22:59', '2019-10-27 21:25:02'),
(680, 0, 'en', 'app', 'language_code', 'Language Code', '2019-10-27 21:22:59', '2019-10-27 21:23:23'),
(681, 0, 'en', 'modules', 'leaves.assignLeave', 'Assign Leave', '2019-10-27 21:22:59', '2019-10-27 21:24:59'),
(682, 0, 'en', 'app', 'enabled', 'Enabled', '2019-10-27 21:22:59', '2019-10-27 21:23:23'),
(683, 0, 'en', 'modules', 'leaves.addLeaveType', 'Add Leave Type', '2019-10-27 21:23:00', '2019-10-27 21:24:59'),
(684, 0, 'en', 'app', 'disabled', 'Disabled', '2019-10-27 21:23:00', '2019-10-27 21:23:23'),
(685, 0, 'en', 'messages', 'selectMultipleDates', 'You can select multiple dates.', '2019-10-27 21:23:00', '2019-10-27 21:23:44'),
(686, 0, 'en', 'app', 'faqCategory', 'FAQ Category', '2019-10-27 21:23:00', '2019-10-27 21:23:23'),
(687, 0, 'en', 'messages', 'noPendingLeaves', 'No pending leaves remaining.', '2019-10-27 21:23:00', '2019-10-27 21:23:45'),
(688, 0, 'en', 'app', 'department', 'Department', '2019-10-27 21:23:00', '2019-10-27 21:23:23'),
(689, 0, 'en', 'modules', 'leaves.leaveRequest', 'Leave Request', '2019-10-27 21:23:00', '2019-10-27 21:25:02'),
(690, 0, 'en', 'app', 'designation', 'Designation', '2019-10-27 21:23:00', '2019-10-27 21:23:23'),
(691, 0, 'en', 'modules', 'leaves.remainingLeaves', 'Remaining Leaves', '2019-10-27 21:23:00', '2019-10-27 21:25:02'),
(692, 0, 'en', 'app', 'slug', 'Slug', '2019-10-27 21:23:00', '2019-10-27 21:23:23'),
(693, 0, 'en', 'modules', 'sticky.colors', 'Color', '2019-10-27 21:23:00', '2019-10-27 21:24:24'),
(694, 0, 'en', 'app', 'yourEmailAddress', 'Your Email Address', '2019-10-27 21:23:00', '2019-10-27 21:23:23'),
(695, 0, 'en', 'messages', 'logTimeNote', 'Log time setting will update on select.', '2019-10-27 21:23:00', '2019-10-27 21:23:48'),
(696, 0, 'en', 'app', 'confirmPassword', 'Confirm Password', '2019-10-27 21:23:00', '2019-10-27 21:23:24'),
(697, 0, 'en', 'modules', 'moduleSettings.moduleSetting', 'Module Setting', '2019-10-27 21:23:00', '2019-10-27 21:24:34'),
(698, 0, 'en', 'app', 'timelogs', 'Time Logs', '2019-10-27 21:23:00', '2019-10-27 21:23:24'),
(699, 0, 'en', 'modules', 'moduleSettings.employeeSubTitle', 'Select the modules which you want to enable.', '2019-10-27 21:23:01', '2019-10-27 21:24:33'),
(700, 0, 'en', 'app', 'clients', 'Clients', '2019-10-27 21:23:01', '2019-10-27 21:23:24'),
(701, 0, 'en', 'modules', 'moduleSettings.section', 'section.', '2019-10-27 21:23:01', '2019-10-27 21:24:34'),
(702, 0, 'en', 'app', 'employees', 'Employees', '2019-10-27 21:23:01', '2019-10-27 21:23:24'),
(703, 0, 'en', 'modules', 'notices.addNotice', 'Add New Notice', '2019-10-27 21:23:01', '2019-10-27 21:24:30'),
(704, 0, 'en', 'auth', 'failed', 'Estas credenciales no coinciden con nuestros registros. Intente nuevamente.', '2019-10-27 21:23:01', '2019-10-27 21:28:43'),
(705, 0, 'en', 'modules', 'notices.updateNotice', 'Update Notice', '2019-10-27 21:23:01', '2019-10-27 21:24:24'),
(706, 0, 'en', 'auth', 'throttle', 'Demasiados intentos de inicio de sesión. Por favor intente nuevamente en:seconds seconds.', '2019-10-27 21:23:01', '2019-10-27 21:28:43'),
(707, 0, 'en', 'messages', 'addPaypalWebhookUrl', 'Add this webhook url on your paypal app settings.', '2019-10-27 21:23:01', '2019-10-27 21:23:51'),
(708, 0, 'en', 'messages', 'addStripeWebhookUrl', 'Add this webhook url on your stripe app settings.', '2019-10-27 21:23:01', '2019-10-27 21:23:52'),
(709, 0, 'en', 'messages', 'noMethodsAdded', 'No Methods Added.', '2019-10-27 21:23:01', '2019-10-27 21:23:37'),
(710, 0, 'en', 'modules', 'offlinePayment.title', 'Offline Payment Method', '2019-10-27 21:23:02', '2019-10-27 21:25:11'),
(711, 0, 'en', 'modules', 'payments.updatePayment', 'Update Payment', '2019-10-27 21:23:02', '2019-10-27 21:24:41'),
(712, 0, 'en', 'modules', 'payments.import', 'Import CSV', '2019-10-27 21:23:02', '2019-10-27 21:24:41'),
(713, 0, 'en', 'messages', 'productPrice', 'Insert price without currency code.', '2019-10-27 21:23:02', '2019-10-27 21:23:38'),
(714, 0, 'en', 'email', 'regards', 'Regards', '2019-10-27 21:23:02', '2019-10-27 21:23:24'),
(715, 0, 'en', 'modules', 'profile.passwordNote', 'Leave blank to keep your current password.', '2019-10-27 21:23:02', '2019-10-27 21:24:29'),
(716, 0, 'en', 'modules', 'accountSettings.sendReminderInfo', 'Remind project members about due date of projects.', '2019-10-27 21:23:02', '2019-10-27 21:24:29'),
(717, 0, 'en', 'modules', 'projectTemplate.createTitle', 'Add Template Template', '2019-10-27 21:23:02', '2019-10-27 21:25:13'),
(718, 0, 'en', 'modules', 'projectCategory.addProjectCategory', 'Add Project Category', '2019-10-27 21:23:02', '2019-10-27 21:24:36'),
(719, 0, 'en', 'modules', 'projectTemplate.updateTitle', 'Update Template Details', '2019-10-27 21:23:02', '2019-10-27 21:25:13'),
(720, 0, 'en', 'modules', 'templateTasks.updateTask', 'Update Template Task', '2019-10-27 21:23:03', '2019-10-27 21:25:18'),
(721, 0, 'en', 'modules', 'templateTasks.high', 'High', '2019-10-27 21:23:03', '2019-10-27 21:25:18'),
(722, 0, 'en', 'modules', 'templateTasks.medium', 'Medium', '2019-10-27 21:23:04', '2019-10-27 21:25:18'),
(723, 0, 'en', 'modules', 'templateTasks.low', 'Low', '2019-10-27 21:23:04', '2019-10-27 21:25:18'),
(724, 0, 'en', 'modules', 'tasks.newTask', 'New Task', '2019-10-27 21:23:04', '2019-10-27 21:24:12'),
(725, 0, 'en', 'modules', 'tasks.high', 'High', '2019-10-27 21:23:04', '2019-10-27 21:24:12'),
(726, 0, 'en', 'modules', 'tasks.medium', 'Medium', '2019-10-27 21:23:04', '2019-10-27 21:24:13'),
(727, 0, 'en', 'modules', 'tasks.low', 'Low', '2019-10-27 21:23:05', '2019-10-27 21:24:13'),
(728, 0, 'en', 'messages', 'sweetAlertTitle', 'Are you sure?', '2019-10-27 21:23:05', '2019-10-27 21:23:48'),
(729, 0, 'en', 'messages', 'unArchiveMessage', 'Do you want to revert this project.', '2019-10-27 21:23:05', '2019-10-27 21:23:48'),
(730, 0, 'en', 'messages', 'confirmRevert', 'Yes, revert it!', '2019-10-27 21:23:05', '2019-10-27 21:23:48'),
(731, 0, 'en', 'messages', 'confirmNoArchive', 'No, cancel please!', '2019-10-27 21:23:05', '2019-10-27 21:23:48'),
(732, 0, 'en', 'modules', 'projects.createTitle', 'Add Project', '2019-10-27 21:23:05', '2019-10-27 21:24:24'),
(733, 0, 'en', 'modules', 'projects.updateTitle', 'Update Project Details', '2019-10-27 21:23:05', '2019-10-27 21:24:25'),
(734, 0, 'en', 'modules', 'tasks.assignTo', 'Assigned To', '2019-10-27 21:23:06', '2019-10-27 21:24:12'),
(735, 0, 'en', 'modules', 'projects.viewGanttChart', 'Gantt Chart', '2019-10-27 21:23:06', '2019-10-27 21:24:09'),
(736, 0, 'en', 'messages', 'archiveMessage', 'Do you want to archive this project.', '2019-10-27 21:23:06', '2019-10-27 21:23:48'),
(737, 0, 'en', 'email', 'planUpdate.text', 'named company has been updated plan', '2019-10-27 21:23:06', '2019-10-27 21:23:26'),
(738, 0, 'en', 'messages', 'confirmArchive', 'Yes, archive it!', '2019-10-27 21:23:06', '2019-10-27 21:23:48'),
(739, 0, 'en', 'messages', 'noInvoice', 'No invoice created.', '2019-10-27 21:23:06', '2019-10-27 21:23:31'),
(740, 0, 'en', 'messages', 'noIssue', 'No issue found.', '2019-10-27 21:23:06', '2019-10-27 21:23:31'),
(741, 0, 'en', 'modules', 'projects.milestones', 'Milestones', '2019-10-27 21:23:07', '2019-10-27 21:24:10'),
(742, 0, 'en', 'modules', 'projects.createMilestone', 'Create Milestone', '2019-10-27 21:23:07', '2019-10-27 21:24:11'),
(743, 0, 'en', 'modules', 'projects.addFileLink', 'Add file link', '2019-10-27 21:23:07', '2019-10-27 21:24:10'),
(744, 0, 'en', 'modules', 'projects.resume', 'Resume', '2019-10-27 21:23:07', '2019-10-27 21:24:27'),
(745, 0, 'en', 'modules', 'projects.activeTimers', 'Active Timers', '2019-10-27 21:23:07', '2019-10-27 21:24:07'),
(746, 0, 'en', 'modules', 'projects.projectEarningInfo', 'Calculated from Payments Module', '2019-10-27 21:23:07', '2019-10-27 21:24:10'),
(747, 0, 'en', 'modules', 'projects.projectExpenseInfo', 'Calculated from Expenses Module', '2019-10-27 21:23:08', '2019-10-27 21:24:10'),
(748, 0, 'en', 'messages', 'noClientAddedToProject', 'No client assigned to the project.', '2019-10-27 21:23:08', '2019-10-27 21:23:43'),
(749, 0, 'en', 'modules', 'tasks.updateTask', 'Update Task', '2019-10-27 21:23:08', '2019-10-27 21:24:13'),
(750, 0, 'en', 'installer_messages', 'title', 'Laravel Installer', '2019-10-27 21:23:08', '2019-10-27 21:23:27'),
(751, 0, 'en', 'modules', 'taskCategory.addTaskCategory', 'Add Task Category', '2019-10-27 21:23:08', '2019-10-27 21:25:20'),
(752, 0, 'en', 'installer_messages', 'next', 'Next Step', '2019-10-27 21:23:08', '2019-10-27 21:23:27'),
(753, 0, 'en', 'modules', 'taskCategory.manageTaskCategory', 'Manage Task Category', '2019-10-27 21:23:08', '2019-10-27 21:25:21'),
(754, 0, 'en', 'installer_messages', 'finish', 'Install', '2019-10-27 21:23:08', '2019-10-27 21:23:27'),
(755, 0, 'en', 'modules', 'timeLogs.logTime', 'Log Time', '2019-10-27 21:23:08', '2019-10-27 21:24:22'),
(756, 0, 'en', 'installer_messages', 'welcome.title', 'Welcome To The Installer', '2019-10-27 21:23:08', '2019-10-27 21:23:27'),
(757, 0, 'en', 'modules', 'proposal.createTitle', 'Add Proposal Info', '2019-10-27 21:23:08', '2019-10-27 21:25:05'),
(758, 0, 'en', 'installer_messages', 'welcome.message', 'Welcome to the setup wizard.', '2019-10-27 21:23:08', '2019-10-27 21:23:27'),
(759, 0, 'en', 'modules', 'proposal.updateProposal', 'Update Proposal', '2019-10-27 21:23:08', '2019-10-27 21:25:06'),
(760, 0, 'en', 'installer_messages', 'requirements.title', 'Server Requirements', '2019-10-27 21:23:08', '2019-10-27 21:23:27'),
(761, 0, 'en', 'installer_messages', 'permissions.title', 'Permissions', '2019-10-27 21:23:09', '2019-10-27 21:23:27'),
(762, 0, 'en', 'modules', 'slackSettings.notificationSubtitle', 'Select the events for which an notification should be sent to user.', '2019-10-27 21:23:09', '2019-10-27 21:24:45'),
(763, 0, 'en', 'installer_messages', 'environment.title', 'Database Configuration', '2019-10-27 21:23:09', '2019-10-27 21:23:28'),
(764, 0, 'en', 'modules', 'invoices.currency', 'Currency', '2019-10-27 21:23:09', '2019-10-27 21:24:15'),
(765, 0, 'en', 'installer_messages', 'environment.save', 'Save .env', '2019-10-27 21:23:09', '2019-10-27 21:23:28'),
(766, 0, 'en', 'modules', 'financeReport.selectCurrency', 'Select Currency', '2019-10-27 21:23:09', '2019-10-27 21:24:25'),
(767, 0, 'en', 'modules', 'financeReport.noteText', 'The earnings are calculated with latest exchange rate for different currencies.', '2019-10-27 21:23:09', '2019-10-27 21:24:26'),
(768, 0, 'en', 'installer_messages', 'environment.success', 'Your .env file settings have been saved.', '2019-10-27 21:23:09', '2019-10-27 21:23:28'),
(769, 0, 'en', 'installer_messages', 'environment.errors', 'Unable to save the .env file, Please create it manually.', '2019-10-27 21:23:09', '2019-10-27 21:23:28'),
(770, 0, 'en', 'modules', 'employees.employeeName', 'Employee Name', '2019-10-27 21:23:09', '2019-10-27 21:24:01'),
(771, 0, 'en', 'installer_messages', 'install', 'Install', '2019-10-27 21:23:09', '2019-10-27 21:23:28'),
(772, 0, 'en', 'modules', 'roles.addRole', 'Manage Role', '2019-10-27 21:23:09', '2019-10-27 21:24:58'),
(773, 0, 'en', 'installer_messages', 'final.title', 'Finished', '2019-10-27 21:23:09', '2019-10-27 21:23:28'),
(774, 0, 'en', 'modules', 'slackSettings.uploadSlackLogo', 'Upload Notification Logo', '2019-10-27 21:23:09', '2019-10-27 21:24:45'),
(775, 0, 'en', 'installer_messages', 'final.finished', 'Application has been successfully installed.', '2019-10-27 21:23:10', '2019-10-27 21:23:28'),
(776, 0, 'en', 'modules', 'sticky.lastUpdated', 'Updated', '2019-10-27 21:23:10', '2019-10-27 21:24:24'),
(777, 0, 'en', 'installer_messages', 'final.exit', 'Click here to exit', '2019-10-27 21:23:10', '2019-10-27 21:23:28'),
(778, 0, 'en', 'modules', 'invoices.due', 'Due', '2019-10-27 21:23:10', '2019-10-27 21:24:19'),
(779, 0, 'en', 'modules', 'taskCalendar.note', 'Calendar shows the due tasks on their due dates.', '2019-10-27 21:23:10', '2019-10-27 21:24:23'),
(780, 0, 'en', 'installer_messages', 'checkPermissionAgain', ' Check Permission Again', '2019-10-27 21:23:10', '2019-10-27 21:23:28'),
(781, 0, 'en', 'modules', 'taskDetail', 'Task Detail', '2019-10-27 21:23:10', '2019-10-27 21:24:36'),
(782, 0, 'en', 'messages', 'taskSettingNote', 'Self task setting\n will update on select.', '2019-10-27 21:23:10', '2019-10-27 21:23:51'),
(783, 0, 'en', 'messages', 'Login As Employee', 'Login As Employee', '2019-10-27 21:23:10', '2019-10-27 21:23:28'),
(784, 0, 'en', 'modules', 'tasks.comment', 'Comment', '2019-10-27 21:23:11', '2019-10-27 21:24:28'),
(785, 0, 'en', 'modules', 'tasks.subTask', 'Sub Task', '2019-10-27 21:23:11', '2019-10-27 21:24:28'),
(786, 0, 'en', 'modules', 'tasks.tasksTable', 'Tasks Table', '2019-10-27 21:23:11', '2019-10-27 21:24:14'),
(787, 0, 'en', 'modules', 'tasks.addBoardColumn', 'Add Column', '2019-10-27 21:23:11', '2019-10-27 21:24:13'),
(788, 0, 'en', 'modules', 'tasks.assignBy', 'Assigned By', '2019-10-27 21:23:11', '2019-10-27 21:24:14'),
(789, 0, 'en', 'messages', 'newMemberAddedToTheProject', 'New member added to the project.', '2019-10-27 21:23:11', '2019-10-27 21:23:29'),
(790, 0, 'en', 'modules', 'tasks.chooseAssignee', 'Choose Assignee', '2019-10-27 21:23:11', '2019-10-27 21:24:13'),
(791, 0, 'en', 'modules', 'tasks.taskBoard', 'Task Board', '2019-10-27 21:23:11', '2019-10-27 21:24:13'),
(792, 0, 'en', 'modules', 'tasks.deleteRecurringTasks', 'Delete with recurring tasks.', '2019-10-27 21:23:12', '2019-10-27 21:24:15'),
(793, 0, 'en', 'modules', 'tasks.markComplete', 'Mark as complete', '2019-10-27 21:23:12', '2019-10-27 21:24:14'),
(794, 0, 'en', 'modules', 'tasks.markIncomplete', 'Mark as incomplete', '2019-10-27 21:23:12', '2019-10-27 21:24:28'),
(795, 0, 'en', 'messages', 'remindToAssignedEmployee', 'Send Reminder', '2019-10-27 21:23:12', '2019-10-27 21:23:51'),
(796, 0, 'en', 'modules', 'tasks.reminder', 'Reminder', '2019-10-27 21:23:12', '2019-10-27 21:24:15'),
(797, 0, 'en', 'messages', 'faviconNote', 'Go to https://www.favicon-generator.org/ and generate favicons.\n\nAfter that upload the favicons to public/favicon directory.', '2019-10-27 21:23:12', '2019-10-27 21:23:46'),
(798, 0, 'en', 'modules', 'themeSettings.customCssNote', 'If you have large custom css then create following 3 files in <strong>public/css/</strong> and make changes in it.', '2019-10-27 21:23:12', '2019-10-27 21:24:39'),
(799, 0, 'en', 'messages', 'clientUploadedAFileToTheProject', '(Client) uploaded a file to the project.', '2019-10-27 21:23:12', '2019-10-27 21:23:30'),
(800, 0, 'en', 'modules', 'themeSettings.customCss', 'Custom CSS', '2019-10-27 21:23:12', '2019-10-27 21:24:38'),
(801, 0, 'en', 'modules', 'themeSettings.customCssPlaceholder', 'Enter your custom css after this line', '2019-10-27 21:23:12', '2019-10-27 21:24:39'),
(802, 0, 'en', 'modules', 'tickets.agents', 'Agents', '2019-10-27 21:23:13', '2019-10-27 21:24:47'),
(803, 0, 'en', 'modules', 'tickets.chooseAgents', 'Choose Agents', '2019-10-27 21:23:13', '2019-10-27 21:24:47'),
(804, 0, 'en', 'messages', 'noProjectFound', 'No Project Found.', '2019-10-27 21:23:13', '2019-10-27 21:23:30'),
(805, 0, 'en', 'modules', 'tickets.manageGroups', 'Manage Groups', '2019-10-27 21:23:13', '2019-10-27 21:24:48'),
(806, 0, 'en', 'messages', 'noProjectAssigned', 'No project assigned to you.', '2019-10-27 21:23:13', '2019-10-27 21:23:30'),
(807, 0, 'en', 'messages', 'noAgentAdded', 'No agent added.', '2019-10-27 21:23:13', '2019-10-27 21:23:41'),
(808, 0, 'en', 'messages', 'noActivityByThisUser', 'No activity by the user.', '2019-10-27 21:23:13', '2019-10-27 21:23:30'),
(809, 0, 'en', 'messages', 'noTicketChannelAdded', NULL, '2019-10-27 21:23:13', '2019-10-27 21:23:13'),
(810, 0, 'en', 'modules', 'tickets.template', 'Template', '2019-10-27 21:23:13', '2019-10-27 21:24:48'),
(811, 0, 'en', 'messages', 'noTemplateFound', 'No template found.', '2019-10-27 21:23:13', '2019-10-27 21:23:42'),
(812, 0, 'en', 'messages', 'noProjectCategoryAdded', 'No project category added.', '2019-10-27 21:23:13', '2019-10-27 21:23:31'),
(813, 0, 'en', 'modules', 'tickets.ticketType', 'Ticket Type', '2019-10-27 21:23:13', '2019-10-27 21:24:48'),
(814, 0, 'en', 'messages', 'noClientAdded', 'No client added.', '2019-10-27 21:23:13', '2019-10-27 21:23:31'),
(815, 0, 'en', 'messages', 'noTicketTypeAdded', 'No ticket type added.', '2019-10-27 21:23:14', '2019-10-27 21:23:42'),
(816, 0, 'en', 'messages', 'noActiveTimer', 'No active timer.', '2019-10-27 21:23:14', '2019-10-27 21:23:31'),
(817, 0, 'en', 'modules', 'tickets.applyTemplate', 'Apply Template', '2019-10-27 21:23:14', '2019-10-27 21:24:50'),
(818, 0, 'en', 'modules', 'tickets.addType', 'Add Type', '2019-10-27 21:23:14', '2019-10-27 21:24:48'),
(819, 0, 'en', 'modules', 'tickets.addChannel', 'Add Channel', '2019-10-27 21:23:14', '2019-10-27 21:24:49'),
(820, 0, 'en', 'messages', 'noOpenIssues', 'No open issues.', '2019-10-27 21:23:14', '2019-10-27 21:23:31'),
(821, 0, 'en', 'modules', 'tickets.ticketTypes', NULL, '2019-10-27 21:23:14', '2019-10-27 21:23:14'),
(822, 0, 'en', 'messages', 'noMessage', 'No message found.', '2019-10-27 21:23:15', '2019-10-27 21:23:35'),
(823, 0, 'en', 'messages', 'noConversation', 'No conversation found.', '2019-10-27 21:23:15', '2019-10-27 21:23:36'),
(824, 0, 'en', 'modules', 'messages.startConversation', 'Start Conversation', '2019-10-27 21:23:15', '2019-10-27 21:24:35'),
(825, 0, 'en', 'messages', 'defaultColorNote', 'If you will not choose any color blue will be default', '2019-10-27 21:23:15', '2019-10-27 21:23:31'),
(826, 0, 'en', 'modules', 'client.clientName', 'Client Name', '2019-10-27 21:23:15', '2019-10-27 21:24:00'),
(827, 0, 'en', 'modules', 'messages.send', 'Send', '2019-10-27 21:23:15', '2019-10-27 21:24:35'),
(828, 0, 'en', 'modules', 'messages.searchContact', 'Search Contact', '2019-10-27 21:23:15', '2019-10-27 21:24:35'),
(829, 0, 'en', 'messages', 'noUser', 'No user found.', '2019-10-27 21:23:15', '2019-10-27 21:23:36'),
(830, 0, 'en', 'modules', 'messages.typeMessage', 'Type your message here...', '2019-10-27 21:23:16', '2019-10-27 21:24:35'),
(831, 0, 'en', 'modules', 'client.password', 'Password', '2019-10-27 21:23:16', '2019-10-27 21:24:00'),
(832, 0, 'en', 'modules', 'dashboard.totalPaidAmount', 'Paid Amount', '2019-10-27 21:23:16', '2019-10-27 21:23:56'),
(833, 0, 'en', 'modules', 'dashboard.totalOutstandingAmount', 'Outstanding Amount', '2019-10-27 21:23:16', '2019-10-27 21:23:56'),
(834, 0, 'en', 'modules', 'invoices.payNow', 'Pay Now', '2019-10-27 21:23:16', '2019-10-27 21:24:18'),
(835, 0, 'en', 'modules', 'issues.addIssue', 'Add Issue', '2019-10-27 21:23:16', '2019-10-27 21:24:19'),
(836, 0, 'en', 'modules', 'issues.updateIssue', 'Update Issue', '2019-10-27 21:23:17', '2019-10-27 21:24:20'),
(837, 0, 'en', 'modules', 'profile.updateTitle', 'Update Profile Info', '2019-10-27 21:23:17', '2019-10-27 21:24:29'),
(838, 0, 'en', 'modules', 'tickets.closeTicket', 'Close Ticket', '2019-10-27 21:23:17', '2019-10-27 21:24:50'),
(839, 0, 'en', 'modules', 'tickets.reopenTicket', 'Reopen Ticket', '2019-10-27 21:23:17', '2019-10-27 21:24:50'),
(840, 0, 'en', 'modules', 'messages.chooseAdmin', 'Choose Admin', '2019-10-27 21:23:17', '2019-10-27 21:24:35'),
(841, 0, 'en', 'modules', 'client.companyName', 'Company Name', '2019-10-27 21:23:18', '2019-10-27 21:23:59'),
(842, 0, 'en', 'modules', 'profile.yourName', 'Your Name', '2019-10-27 21:23:18', '2019-10-27 21:24:29'),
(843, 0, 'en', 'modules', 'profile.yourEmail', 'Your Email', '2019-10-27 21:23:18', '2019-10-27 21:24:29'),
(844, 0, 'en', 'modules', 'messages.message', 'Message', '2019-10-27 21:23:19', '2019-10-27 21:24:35'),
(845, 0, 'en', 'modules', 'invoices.paid', 'Paid', '2019-10-27 21:23:19', '2019-10-27 21:24:15'),
(846, 0, 'en', 'modules', 'tickets.ticket', 'Ticket', '2019-10-27 21:23:19', '2019-10-27 21:24:49'),
(847, 0, 'en', 'modules', 'sticky.addNote', 'Add Note', '2019-10-27 21:23:19', '2019-10-27 21:24:24'),
(848, 0, 'en', 'modules', 'accountSettings.google_recaptcha_key', 'Google Recpatcha Key', '2019-10-27 21:23:20', '2019-10-27 21:24:28'),
(849, 0, 'en', 'messages', 'categoryUpdated', 'Category updated successfully.', '2019-10-27 21:23:20', '2019-10-27 21:23:34'),
(850, 0, 'en', 'modules', 'accountSettings.currencyConverterKey', 'Currency converter key', '2019-10-27 21:23:20', '2019-10-27 21:24:28'),
(851, 0, 'en', 'modules', 'client.passwordNote', 'Client will login using this password.', '2019-10-27 21:23:20', '2019-10-27 21:24:00'),
(852, 0, 'en', 'modules', 'client.passwordUpdateNote', 'Client will login using this password. (Leave blank to keep current password)', '2019-10-27 21:23:20', '2019-10-27 21:24:00'),
(853, 0, 'en', 'modules', 'holiday.date', 'Date', '2019-10-27 21:23:20', '2019-10-27 21:25:10'),
(854, 0, 'en', 'modules', 'holiday.day', 'Day', '2019-10-27 21:23:20', '2019-10-27 21:25:10'),
(855, 0, 'en', 'modules', 'holiday.action', 'Action', '2019-10-27 21:23:20', '2019-10-27 21:25:10'),
(856, 0, 'en', 'modules', 'leaves.applyLeave', 'Apply Leave', '2019-10-27 21:23:20', '2019-10-27 21:25:01'),
(857, 0, 'en', 'modules', 'templateTasks.newTask', 'New Template Task', '2019-10-27 21:23:21', '2019-10-27 21:25:17'),
(858, 0, 'en', 'modules', 'projects.noOpenTasks', 'No open tasks.', '2019-10-27 21:23:21', '2019-10-27 21:24:08'),
(859, 0, 'en', 'modules', 'tasks.taskDetail', 'Task Detail', '2019-10-27 21:23:21', '2019-10-27 21:24:13'),
(860, 0, 'en', 'messages', 'noNotice', 'No notice published.', '2019-10-27 21:23:21', '2019-10-27 21:23:35'),
(861, 0, 'en', 'modules', 'timeLogs.selectTask', 'Select Task', '2019-10-27 21:23:21', '2019-10-27 21:24:22'),
(862, 0, 'en', 'modules', 'timeLogs.selectProject', 'Select Project', '2019-10-27 21:23:21', '2019-10-27 21:24:22'),
(863, 0, 'en', 'modules', 'timeLogs.noProjectFound', 'No Task Assigned', '2019-10-27 21:23:21', '2019-10-27 21:24:22'),
(864, 0, 'en', 'modules', 'timeLogs.noTaskFound', 'No Task Assigned', '2019-10-27 21:23:21', '2019-10-27 21:24:22'),
(865, 0, 'en', 'modules', 'timeLogs.stopTimer', 'Stop Timer', '2019-10-27 21:23:21', '2019-10-27 21:24:30'),
(866, 0, 'en', 'messages', 'planPurchaseBy', 'Plan purchased by', '2019-10-27 21:23:22', '2019-10-27 21:23:50'),
(867, 0, 'en', 'messages', 'planUpdatedBy', 'Plan updated by', '2019-10-27 21:23:22', '2019-10-27 21:23:50'),
(868, 0, 'en', 'messages', 'namedCompanyRegistered.', 'named company registered.', '2019-10-27 21:23:22', '2019-10-27 21:23:50'),
(869, 0, 'en', 'messages', 'currencyConvertApiKeyUrl', 'Get API key by this url', '2019-10-27 21:23:22', '2019-10-27 21:23:49'),
(870, 0, 'en', 'messages', 'addCurrencyNote', 'Add currency covert key for  add or edit currency and Update exchange rate.', '2019-10-27 21:23:22', '2019-10-27 21:23:50'),
(871, 0, 'en', 'messages', 'installationWelcome', ' Welcome to Worksuite! Let\'s get you started', '2019-10-27 21:23:22', '2019-10-27 21:23:52'),
(872, 0, 'en', 'messages', 'installationProgress', 'Progress', '2019-10-27 21:23:22', '2019-10-27 21:23:52'),
(873, 0, 'en', 'messages', 'installationStep1', 'Step 1. Installation', '2019-10-27 21:23:23', '2019-10-27 21:23:52'),
(874, 0, 'en', 'messages', 'installationCongratulation', 'Congratulations! You have taken the first step to better managing your worksuite', '2019-10-27 21:23:23', '2019-10-27 21:23:53'),
(875, 0, 'en', 'messages', 'templateTaskDeletedSuccessfully', 'Template Task deleted successfully.', '2019-10-27 21:23:23', '2019-10-27 21:23:37'),
(876, 0, 'en', 'messages', 'installationStep2', 'Step 2. SMTP Settings', '2019-10-27 21:23:23', '2019-10-27 21:23:53'),
(877, 0, 'en', 'messages', 'installationSmtp', 'Add your smtp details to make emails work', '2019-10-27 21:23:24', '2019-10-27 21:23:53'),
(878, 0, 'en', 'messages', 'noProjectTemplateAdded', 'No project template added.', '2019-10-27 21:23:24', '2019-10-27 21:23:38'),
(879, 0, 'en', 'messages', 'installationStep3', 'Step 3. Global Settings', '2019-10-27 21:23:24', '2019-10-27 21:23:53'),
(880, 0, 'en', 'messages', 'selectTemplate', 'Select Template', '2019-10-27 21:23:24', '2019-10-27 21:23:38'),
(881, 0, 'en', 'messages', 'installationCompanySetting', 'Make changes to global setting to start using app.', '2019-10-27 21:23:24', '2019-10-27 21:23:53'),
(882, 0, 'en', 'messages', 'installationStep4', 'Step 4. Profile Setting', '2019-10-27 21:23:24', '2019-10-27 21:23:53'),
(883, 0, 'en', 'messages', 'installationProfileSetting', 'Update your login email and password', '2019-10-27 21:23:24', '2019-10-27 21:23:53'),
(884, 0, 'en', 'modules', 'update.newUpdate', 'New update available', '2019-10-27 21:23:24', '2019-10-27 21:24:46'),
(885, 0, 'en', 'messages', 'monthWiseDataNotFound', 'No Holiday found for this month.', '2019-10-27 21:23:24', '2019-10-27 21:23:38'),
(886, 0, 'en', 'messages', 'noDocsFound', 'No Document found.', '2019-10-27 21:23:24', '2019-10-27 21:23:38'),
(887, 0, 'en', 'messages', 'FeatureImageSizeMessage', 'Uploading image size should be 400x352.', '2019-10-27 21:23:24', '2019-10-27 21:23:51'),
(888, 0, 'en', 'modules', 'frontSettings.title', 'Frontend CMS', '2019-10-27 21:23:24', '2019-10-27 21:25:27'),
(889, 0, 'en', 'messages', 'headerImageSizeMessage', 'Uploading image size should be 688x504.', '2019-10-27 21:23:24', '2019-10-27 21:23:51');
INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(890, 0, 'en', 'modules', 'accountSettings.updateTitle', 'Update Organization Settings', '2019-10-27 21:23:25', '2019-10-27 21:24:31'),
(891, 0, 'en', '_json', 'zero', NULL, '2019-10-27 21:23:25', '2019-10-27 21:23:25'),
(892, 0, 'en', '_json', 'changes', NULL, '2019-10-27 21:23:25', '2019-10-27 21:23:25'),
(893, 0, 'en', 'messages', 'welcome.message', 'Welcome to the setup wizard', '2019-10-27 21:23:25', '2019-10-27 21:23:38'),
(894, 0, 'en', '_json', 'v', NULL, '2019-10-27 21:23:25', '2019-10-27 21:23:25'),
(895, 0, 'en', 'messages', 'welcome.title', 'Welcome to the installer', '2019-10-27 21:23:25', '2019-10-27 21:23:39'),
(896, 0, 'en', '_json', 'status', NULL, '2019-10-27 21:23:25', '2019-10-27 21:23:25'),
(897, 0, 'en', 'messages', 'title', 'Laravel installer', '2019-10-27 21:23:25', '2019-10-27 21:23:39'),
(898, 0, 'en', 'messages', 'requirements.title', 'formalities', '2019-10-27 21:23:25', '2019-10-27 21:23:39'),
(899, 0, 'en', '_json', 'messages.noUser ', NULL, '2019-10-27 21:23:25', '2019-10-27 21:23:25'),
(900, 0, 'en', 'messages', 'permissions.title', 'Permissions', '2019-10-27 21:23:26', '2019-10-27 21:23:39'),
(901, 0, 'en', 'messages', 'next', 'Following', '2019-10-27 21:23:26', '2019-10-27 21:23:39'),
(902, 0, 'en', 'messages', 'finish', 'Install', '2019-10-27 21:23:26', '2019-10-27 21:23:39'),
(903, 0, 'en', 'messages', 'final.title', 'Finalized.', '2019-10-27 21:23:26', '2019-10-27 21:23:39'),
(904, 0, 'en', 'messages', 'final.finished', 'The application has been installed successfully!', '2019-10-27 21:23:26', '2019-10-27 21:23:39'),
(905, 0, 'en', 'messages', 'final.exit', 'Click here to exit.', '2019-10-27 21:23:26', '2019-10-27 21:23:39'),
(906, 0, 'en', 'messages', 'environment.errors', 'It is not possible to create the .env file, please try manually.', '2019-10-27 21:23:27', '2019-10-27 21:23:39'),
(907, 0, 'en', 'messages', 'environment.save', 'Save .env file', '2019-10-27 21:23:27', '2019-10-27 21:23:39'),
(908, 0, 'en', 'messages', 'environment.success', 'Changes to your .env file have been saved.', '2019-10-27 21:23:27', '2019-10-27 21:23:40'),
(909, 0, 'en', 'messages', 'environment.title', 'Settings of the environment', '2019-10-27 21:23:27', '2019-10-27 21:23:40'),
(910, 0, 'en', 'messages', 'noProjectCategory', 'No project category found.', '2019-10-27 21:23:27', '2019-10-27 21:23:40'),
(911, 0, 'en', 'messages', 'noTaskCategory', 'No task category found.', '2019-10-27 21:23:27', '2019-10-27 21:23:40'),
(912, 0, 'en', 'messages', 'databaseUpdated', 'Database update successfully.', '2019-10-27 21:23:30', '2019-10-27 21:23:41'),
(913, 0, 'en', 'messages', 'noGroupAdded', 'No group added.', '2019-10-27 21:23:30', '2019-10-27 21:23:41'),
(914, 0, 'en', 'messages', 'noFeedbackReceived', 'No feedback received.', '2019-10-27 21:23:34', '2019-10-27 21:23:43'),
(915, 0, 'en', 'messages', 'customFieldCreateSuccess', 'Custom field created successfully.', '2019-10-27 21:23:35', '2019-10-27 21:23:43'),
(916, 0, 'en', 'messages', 'permissionUpdated', 'Permission updated successfully.', '2019-10-27 21:23:35', '2019-10-27 21:23:43'),
(917, 0, 'en', 'messages', 'noRoleMemberFound', 'No member is assigned to this role.', '2019-10-27 21:23:35', '2019-10-27 21:23:44'),
(918, 0, 'en', 'messages', 'noRoleFound', 'No role found.', '2019-10-27 21:23:36', '2019-10-27 21:23:44'),
(919, 0, 'en', 'messages', 'noLeaveTypeAdded', 'No leave type added.', '2019-10-27 21:23:36', '2019-10-27 21:23:44'),
(920, 0, 'en', 'messages', 'leaveDeleteSuccess', 'Leave deleted successfully.', '2019-10-27 21:23:37', '2019-10-27 21:23:44'),
(921, 0, 'en', 'messages', 'updateAlert', 'Do not click update now button if the application is customised. Your changes will be lost.', '2019-10-27 21:23:38', '2019-10-27 21:23:45'),
(922, 0, 'en', 'messages', 'updateBackupNotice', 'Take backup of files and database before updating.', '2019-10-27 21:23:38', '2019-10-27 21:23:45'),
(923, 0, 'en', 'messages', 'fieldBlank', 'Field cannot be blank.', '2019-10-27 21:23:39', '2019-10-27 21:23:45'),
(924, 0, 'en', 'messages', 'defaultRoleCantDelete', 'Default role can not be deleted.', '2019-10-27 21:23:39', '2019-10-27 21:23:45'),
(925, 0, 'en', 'messages', 'noTaskAddedToProject', 'No task added to this project.', '2019-10-27 21:23:43', '2019-10-27 21:23:48'),
(926, 0, 'en', 'messages', 'noAttendanceDetailTOday', 'No attendance detail for today.', '2019-10-27 21:23:43', '2019-10-27 21:23:48'),
(927, 0, 'en', 'messages', 'noAttendanceDetail', 'No attendance detail.', '2019-10-27 21:23:44', '2019-10-27 21:23:48'),
(928, 0, 'en', 'messages', 'noTaskCategoryAdded', 'No task category added.', '2019-10-27 21:23:44', '2019-10-27 21:23:48'),
(929, 0, 'en', 'messages', 'NewCompanyRegistered', 'New company registered.', '2019-10-27 21:23:47', '2019-10-27 21:23:50'),
(930, 0, 'en', 'messages', 'planPurchaseByCompany', 'Plan purchased by company', '2019-10-27 21:23:47', '2019-10-27 21:23:50'),
(931, 0, 'en', 'messages', 'planUpdatedByCompany', 'Plan updated by company', '2019-10-27 21:23:47', '2019-10-27 21:23:50'),
(932, 0, 'en', 'messages', 'feature.addedSuccess', 'Feature added successfully.', '2019-10-27 21:23:47', '2019-10-27 21:23:50'),
(933, 0, 'en', 'messages', 'feature.updatedSuccess', 'Feature updated successfully.', '2019-10-27 21:23:47', '2019-10-27 21:23:50'),
(934, 0, 'en', 'messages', 'feature.deletedSuccess', 'Feature deleted successfully.', '2019-10-27 21:23:47', '2019-10-27 21:23:51'),
(935, 0, 'en', 'messages', 'reminderMailSuccess', 'Reminder Mail sent successfully', '2019-10-27 21:23:48', '2019-10-27 21:23:51'),
(936, 0, 'en', 'messages', 'employeeSelfTask', 'Employee can create task for self.', '2019-10-27 21:23:48', '2019-10-27 21:23:51'),
(937, 0, 'en', 'messages', 'licenseExpiredNote', 'License has been expired please purchase.', '2019-10-27 21:23:49', '2019-10-27 21:23:51'),
(938, 0, 'en', 'messages', 'purchasePackageMessage', 'You need to purchase a package to explore more features.', '2019-10-27 21:23:50', '2019-10-27 21:23:52'),
(939, 0, 'en', 'messages', 'createSuccess', 'Created successfully', '2019-10-27 21:23:53', '2019-10-27 21:23:54'),
(940, 0, 'en', 'messages', 'updateSuccess', 'Updated successfully', '2019-10-27 21:23:54', '2019-10-27 21:24:21'),
(941, 1, 'en', 'messages', 'updateSuccess', 'Updated successfully', '2019-10-27 21:23:54', '2019-10-27 21:23:54'),
(942, 1, 'en', 'messages', 'updateSuccess', 'Updated successfully', '2019-10-27 21:23:54', '2019-10-27 21:23:54'),
(943, 0, 'en', 'messages', 'designationAdded', 'Designation added successfully', '2019-10-27 21:23:54', '2019-10-27 21:23:54'),
(944, 1, 'en', 'messages', 'designationAdded', 'Designation added successfully', '2019-10-27 21:23:54', '2019-10-27 21:23:54'),
(945, 0, 'en', 'messages', 'officeTimeOver', 'Office hours have passed. You cannot mark attendance for today now.', '2019-10-27 21:23:54', '2019-10-27 21:23:55'),
(946, 1, 'en', 'messages', 'officeTimeOver', 'Office hours have passed. You cannot mark attendance for today now.', '2019-10-27 21:23:54', '2019-10-27 21:23:54'),
(947, 0, 'en', 'messages', 'cacheEnabled', 'Cache is Enabled', '2019-10-27 21:23:55', '2019-10-27 21:23:55'),
(948, 1, 'en', 'messages', 'cacheEnabled', 'Cache is Enabled', '2019-10-27 21:23:55', '2019-10-27 21:23:55'),
(949, 0, 'en', 'messages', 'cacheDisabled', 'Cache is disabled', '2019-10-27 21:23:55', '2019-10-27 21:23:55'),
(950, 0, 'en', 'modules', 'dashboard.totalPaidInvoices', 'Paid Invoices', '2019-10-27 21:23:55', '2019-10-27 21:24:22'),
(951, 1, 'en', 'modules', 'dashboard.totalPaidInvoices', 'Paid Invoices', '2019-10-27 21:23:55', '2019-10-27 21:23:55'),
(952, 1, 'en', 'modules', 'dashboard.totalPaidInvoices', 'Paid Invoices', '2019-10-27 21:23:55', '2019-10-27 21:23:55'),
(953, 0, 'en', 'modules', 'dashboard.totalPendingIssues', 'Total Pending Issues', '2019-10-27 21:23:55', '2019-10-27 21:23:56'),
(954, 1, 'en', 'modules', 'dashboard.totalPendingIssues', 'Total Pending Issues', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(955, 0, 'en', 'modules', 'dashboard.recentEarnings', 'Recent Earnings', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(956, 1, 'en', 'modules', 'dashboard.recentEarnings', 'Recent Earnings', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(957, 0, 'en', 'modules', 'dashboard.overdueTasks', 'Overdue Tasks', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(958, 0, 'en', 'modules', 'dashboard.pendingClientIssues', 'Pending Issues', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(959, 1, 'en', 'modules', 'dashboard.pendingClientIssues', 'Pending Issues', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(960, 0, 'en', 'modules', 'dashboard.projectActivityTimeline', 'Project Activity Timeline', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(961, 1, 'en', 'modules', 'dashboard.projectActivityTimeline', 'Project Activity Timeline', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(962, 0, 'en', 'modules', 'dashboard.userActivityTimeline', 'User Activity Timeline', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(963, 0, 'en', 'modules', 'dashboard.dueDate', 'Due Date', '2019-10-27 21:23:56', '2019-10-27 21:23:57'),
(964, 1, 'en', 'modules', 'dashboard.dueDate', 'Due Date', '2019-10-27 21:23:56', '2019-10-27 21:23:56'),
(965, 0, 'en', 'modules', 'dashboard.newTickets', 'New Tickets', '2019-10-27 21:23:57', '2019-10-27 21:23:57'),
(966, 0, 'en', 'modules', 'dashboard.followUpDate', 'Follow Up Date', '2019-10-27 21:23:57', '2019-10-27 21:24:22'),
(967, 1, 'en', 'modules', 'dashboard.followUpDate', 'Follow Up Date', '2019-10-27 21:23:57', '2019-10-27 21:23:57'),
(968, 1, 'en', 'modules', 'dashboard.followUpDate', 'Follow Up Date', '2019-10-27 21:23:57', '2019-10-27 21:23:57'),
(969, 0, 'en', 'modules', 'dashboard.pendingFollowUp', 'Pending FollowUp', '2019-10-27 21:23:57', '2019-10-27 21:24:23'),
(970, 1, 'en', 'modules', 'dashboard.pendingFollowUp', 'Pending FollowUp', '2019-10-27 21:23:57', '2019-10-27 21:23:57'),
(971, 1, 'en', 'modules', 'dashboard.pendingFollowUp', 'Pending FollowUp', '2019-10-27 21:23:57', '2019-10-27 21:23:57'),
(972, 0, 'en', 'modules', 'dashboard.totalLeads', 'Total Leads', '2019-10-27 21:23:57', '2019-10-27 21:23:58'),
(973, 0, 'en', 'modules', 'dashboard.totalConvertedClient', 'Total Client Convert', '2019-10-27 21:23:58', '2019-10-27 21:23:58'),
(974, 1, 'en', 'modules', 'dashboard.totalConvertedClient', 'Total Client Convert', '2019-10-27 21:23:58', '2019-10-27 21:23:58'),
(975, 0, 'en', 'modules', 'dashboard.totalPendingFollowUps', 'Total Pending Follow Up', '2019-10-27 21:23:58', '2019-10-27 21:23:58'),
(976, 1, 'en', 'modules', 'dashboard.totalPendingFollowUps', 'Total Pending Follow Up', '2019-10-27 21:23:58', '2019-10-27 21:23:58'),
(977, 0, 'en', 'modules', 'dashboard.nextFollowUp', 'Next Follow Up', '2019-10-27 21:23:58', '2019-10-27 21:23:58'),
(978, 0, 'en', 'modules', 'dashboard.holidayCheck', 'Today is Holiday for', '2019-10-27 21:23:58', '2019-10-27 21:23:58'),
(979, 0, 'en', 'modules', 'dashboard.totalArchiveProjects', 'Total Archived Projects', '2019-10-27 21:23:58', '2019-10-27 21:23:58'),
(980, 0, 'en', 'modules', 'dashboard.totalCompanies', 'Total Companies', '2019-10-27 21:23:58', '2019-10-27 21:24:23'),
(981, 1, 'en', 'modules', 'dashboard.totalCompanies', 'Total Companies', '2019-10-27 21:23:58', '2019-10-27 21:23:58'),
(982, 1, 'en', 'modules', 'dashboard.totalCompanies', 'Total Companies', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(983, 0, 'en', 'modules', 'dashboard.activeCompanies', 'Active Companies', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(984, 1, 'en', 'modules', 'dashboard.activeCompanies', 'Active Companies', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(985, 0, 'en', 'modules', 'dashboard.licenseExpired', 'License Expired', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(986, 1, 'en', 'modules', 'dashboard.licenseExpired', 'License Expired', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(987, 0, 'en', 'modules', 'dashboard.inactiveCompanies', 'Inactive Companies', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(988, 0, 'en', 'modules', 'client.companyDetails', 'Company Details', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(989, 0, 'en', 'modules', 'client.website', 'Website', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(990, 1, 'en', 'modules', 'client.website', 'Website', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(991, 0, 'en', 'modules', 'client.address', 'Address', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(992, 0, 'en', 'modules', 'client.clientDetails', 'Client Details', '2019-10-27 21:23:59', '2019-10-27 21:23:59'),
(993, 0, 'en', 'modules', 'client.clientEmail', 'Client Email', '2019-10-27 21:24:00', '2019-10-27 21:24:23'),
(994, 1, 'en', 'modules', 'client.clientEmail', 'Client Email', '2019-10-27 21:24:00', '2019-10-27 21:24:00'),
(995, 1, 'en', 'modules', 'client.clientEmail', 'Client Email', '2019-10-27 21:24:00', '2019-10-27 21:24:00'),
(996, 0, 'en', 'modules', 'client.emailNote', 'Client will login using this email.', '2019-10-27 21:24:00', '2019-10-27 21:24:00'),
(997, 1, 'en', 'modules', 'client.emailNote', 'Client will login using this email.', '2019-10-27 21:24:00', '2019-10-27 21:24:00'),
(998, 0, 'en', 'modules', 'client.mobile', 'Mobile', '2019-10-27 21:24:00', '2019-10-27 21:24:00'),
(999, 0, 'en', 'modules', 'client.addNewClient', 'Add New Client', '2019-10-27 21:24:00', '2019-10-27 21:24:00'),
(1000, 0, 'en', 'modules', 'client.projectName', 'Project Name', '2019-10-27 21:24:00', '2019-10-27 21:24:23'),
(1001, 1, 'en', 'modules', 'client.projectName', 'Project Name', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1002, 1, 'en', 'modules', 'client.projectName', 'Project Name', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1003, 0, 'en', 'modules', 'client.startedOn', 'Started On', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1004, 0, 'en', 'modules', 'client.deadline', 'Deadline', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1005, 0, 'en', 'modules', 'client.generateRandomPassword', 'Generate Random Password', '2019-10-27 21:24:01', '2019-10-27 21:24:24'),
(1006, 1, 'en', 'modules', 'client.generateRandomPassword', 'Generate Random Password', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1007, 1, 'en', 'modules', 'client.generateRandomPassword', 'Generate Random Password', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1008, 0, 'en', 'modules', 'client.offline', 'Offline', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1009, 0, 'en', 'modules', 'client.online', 'Online', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1010, 1, 'en', 'modules', 'client.online', 'Online', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1011, 0, 'en', 'modules', 'client.all', 'All', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1012, 1, 'en', 'modules', 'client.all', 'All', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1013, 0, 'en', 'modules', 'contacts.contactName', 'Contact Name', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1014, 0, 'en', 'modules', 'employees.addNewEmployee', 'Add New Employee', '2019-10-27 21:24:01', '2019-10-27 21:24:01'),
(1015, 0, 'en', 'modules', 'employees.employeeEmail', 'Employee Email', '2019-10-27 21:24:01', '2019-10-27 21:24:02'),
(1016, 0, 'en', 'modules', 'employees.emailNote', 'Employee will login using this email.', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1017, 0, 'en', 'modules', 'employees.employeePassword', 'Password', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1018, 0, 'en', 'modules', 'employees.jobTitle', 'Job Title', '2019-10-27 21:24:02', '2019-10-27 21:24:24'),
(1019, 1, 'en', 'modules', 'employees.jobTitle', 'Job Title', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1020, 1, 'en', 'modules', 'employees.jobTitle', 'Job Title', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1021, 0, 'en', 'modules', 'employees.hourlyRate', 'Hourly Rate', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1022, 0, 'en', 'modules', 'employees.tasksDone', 'Tasks Done', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1023, 0, 'en', 'modules', 'employees.hoursLogged', 'Hours Logged', '2019-10-27 21:24:02', '2019-10-27 21:24:24'),
(1024, 1, 'en', 'modules', 'employees.hoursLogged', 'Hours Logged', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1025, 1, 'en', 'modules', 'employees.hoursLogged', 'Hours Logged', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1026, 0, 'en', 'modules', 'employees.activity', 'Activity', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1027, 0, 'en', 'modules', 'employees.profile', 'Profile', '2019-10-27 21:24:02', '2019-10-27 21:24:02'),
(1028, 0, 'en', 'modules', 'employees.fullName', 'Full Name', '2019-10-27 21:24:02', '2019-10-27 21:24:03'),
(1029, 0, 'en', 'modules', 'employees.startTime', 'Start Time', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1030, 1, 'en', 'modules', 'employees.startTime', 'Start Time', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1031, 0, 'en', 'modules', 'employees.endTime', 'End Time', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1032, 1, 'en', 'modules', 'employees.endTime', 'End Time', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1033, 0, 'en', 'modules', 'employees.totalHours', 'Total Hours', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1034, 1, 'en', 'modules', 'employees.totalHours', 'Total Hours', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1035, 0, 'en', 'modules', 'employees.memo', 'Memo', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1036, 1, 'en', 'modules', 'employees.memo', 'Memo', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1037, 0, 'en', 'modules', 'employees.joiningDate', 'Joining Date', '2019-10-27 21:24:03', '2019-10-27 21:24:03'),
(1038, 0, 'en', 'modules', 'employees.gender', 'Gender', '2019-10-27 21:24:03', '2019-10-27 21:24:04'),
(1039, 0, 'en', 'modules', 'employees.title', 'Select Employee', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1040, 0, 'en', 'modules', 'employees.role', 'Role', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1041, 0, 'en', 'modules', 'employees.lastDate', 'Last Date', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1042, 1, 'en', 'modules', 'employees.lastDate', 'Last Date', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1043, 0, 'en', 'modules', 'projects.addNewProject', 'Add New Project', '2019-10-27 21:24:04', '2019-10-27 21:24:24'),
(1044, 1, 'en', 'modules', 'projects.addNewProject', 'Add New Project', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1045, 1, 'en', 'modules', 'projects.addNewProject', 'Add New Project', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1046, 0, 'en', 'modules', 'projects.projectName', 'Project Name', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1047, 1, 'en', 'modules', 'projects.projectName', 'Project Name', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1048, 0, 'en', 'modules', 'projects.projectMembers', 'Project Members', '2019-10-27 21:24:04', '2019-10-27 21:24:24'),
(1049, 0, 'en', 'modules', 'projects.projectMembers', 'Project Members', '2019-10-27 21:24:04', '2019-10-27 21:24:04'),
(1050, 0, 'en', 'modules', 'projects.startDate', 'Start Date', '2019-10-27 21:24:05', '2019-10-27 21:24:05'),
(1051, 0, 'en', 'modules', 'projects.deadline', 'Deadline', '2019-10-27 21:24:05', '2019-10-27 21:24:05'),
(1052, 0, 'en', 'modules', 'projects.projectSummary', 'Project Summary', '2019-10-27 21:24:05', '2019-10-27 21:24:05'),
(1053, 1, 'en', 'modules', 'projects.projectSummary', 'Project Summary', '2019-10-27 21:24:05', '2019-10-27 21:24:05'),
(1054, 0, 'en', 'modules', 'projects.note', 'Note', '2019-10-27 21:24:05', '2019-10-27 21:24:25'),
(1055, 1, 'en', 'modules', 'projects.note', 'Note', '2019-10-27 21:24:05', '2019-10-27 21:24:05'),
(1056, 1, 'en', 'modules', 'projects.note', 'Note', '2019-10-27 21:24:05', '2019-10-27 21:24:05'),
(1057, 0, 'en', 'modules', 'projects.projectCategory', 'Project Category', '2019-10-27 21:24:05', '2019-10-27 21:24:26'),
(1058, 1, 'en', 'modules', 'projects.projectCategory', 'Project Category', '2019-10-27 21:24:05', '2019-10-27 21:24:05'),
(1059, 1, 'en', 'modules', 'projects.projectCategory', 'Project Category', '2019-10-27 21:24:05', '2019-10-27 21:24:05'),
(1060, 0, 'en', 'modules', 'projects.clientFeedback', 'Client Feedback', '2019-10-27 21:24:06', '2019-10-27 21:24:26'),
(1061, 1, 'en', 'modules', 'projects.clientFeedback', 'Client Feedback', '2019-10-27 21:24:06', '2019-10-27 21:24:06'),
(1062, 0, 'en', 'modules', 'projects.projectCompletionStatus', 'Project Completion Status', '2019-10-27 21:24:06', '2019-10-27 21:24:06'),
(1063, 1, 'en', 'modules', 'projects.clientFeedback', 'Client Feedback', '2019-10-27 21:24:06', '2019-10-27 21:24:06'),
(1064, 1, 'en', 'modules', 'projects.projectCompletionStatus', 'Project Completion Status', '2019-10-27 21:24:06', '2019-10-27 21:24:06'),
(1065, 0, 'en', 'modules', 'projects.overview', 'Overview', '2019-10-27 21:24:06', '2019-10-27 21:24:06'),
(1066, 0, 'en', 'modules', 'projects.files', 'Files', '2019-10-27 21:24:06', '2019-10-27 21:24:06'),
(1067, 1, 'en', 'modules', 'projects.files', 'Files', '2019-10-27 21:24:06', '2019-10-27 21:24:06'),
(1068, 0, 'en', 'modules', 'projects.whoWorking', 'Who\'s Working', '2019-10-27 21:24:07', '2019-10-27 21:24:07'),
(1069, 0, 'en', 'modules', 'projects.activeSince', 'Active Since', '2019-10-27 21:24:07', '2019-10-27 21:24:07'),
(1070, 0, 'en', 'modules', 'projects.openTasks', 'Open Tasks', '2019-10-27 21:24:07', '2019-10-27 21:24:07'),
(1071, 1, 'en', 'modules', 'projects.openTasks', 'Open Tasks', '2019-10-27 21:24:07', '2019-10-27 21:24:07'),
(1072, 0, 'en', 'modules', 'projects.daysLeft', 'Days Left', '2019-10-27 21:24:07', '2019-10-27 21:24:26'),
(1073, 1, 'en', 'modules', 'projects.daysLeft', 'Days Left', '2019-10-27 21:24:07', '2019-10-27 21:24:07'),
(1074, 1, 'en', 'modules', 'projects.daysLeft', 'Days Left', '2019-10-27 21:24:07', '2019-10-27 21:24:07'),
(1075, 0, 'en', 'modules', 'projects.hoursLogged', 'Hours Logged', '2019-10-27 21:24:07', '2019-10-27 21:24:26'),
(1076, 1, 'en', 'modules', 'projects.hoursLogged', 'Hours Logged', '2019-10-27 21:24:07', '2019-10-27 21:24:07'),
(1077, 1, 'en', 'modules', 'projects.hoursLogged', 'Hours Logged', '2019-10-27 21:24:07', '2019-10-27 21:24:07'),
(1078, 0, 'en', 'modules', 'projects.issuesPending', 'Issues Pending', '2019-10-27 21:24:08', '2019-10-27 21:24:08'),
(1079, 0, 'en', 'modules', 'projects.activityTimeline', 'Activity Timeline', '2019-10-27 21:24:08', '2019-10-27 21:24:26'),
(1080, 1, 'en', 'modules', 'projects.activityTimeline', 'Activity Timeline', '2019-10-27 21:24:08', '2019-10-27 21:24:08'),
(1081, 1, 'en', 'modules', 'projects.activityTimeline', 'Activity Timeline', '2019-10-27 21:24:08', '2019-10-27 21:24:08'),
(1082, 0, 'en', 'modules', 'projects.calculateTasksProgress', 'Calculate progress through tasks', '2019-10-27 21:24:08', '2019-10-27 21:24:08'),
(1083, 0, 'en', 'modules', 'projects.clientViewTask', 'Client can view tasks of this project', '2019-10-27 21:24:09', '2019-10-27 21:24:27'),
(1084, 1, 'en', 'modules', 'projects.clientViewTask', 'Client can view tasks of this project', '2019-10-27 21:24:09', '2019-10-27 21:24:09'),
(1085, 1, 'en', 'modules', 'projects.clientViewTask', 'Client can view tasks of this project', '2019-10-27 21:24:09', '2019-10-27 21:24:09'),
(1086, 0, 'en', 'modules', 'projects.manualTimelog', 'Allow manual time logs?', '2019-10-27 21:24:09', '2019-10-27 21:24:09'),
(1087, 0, 'en', 'modules', 'projects.clientTaskNotification', 'Send task notification to client?', '2019-10-27 21:24:09', '2019-10-27 21:24:09'),
(1088, 1, 'en', 'modules', 'projects.clientTaskNotification', 'Send task notification to client?', '2019-10-27 21:24:09', '2019-10-27 21:24:09'),
(1089, 0, 'en', 'modules', 'projects.allProject', 'All Projects', '2019-10-27 21:24:09', '2019-10-27 21:24:09'),
(1090, 0, 'en', 'modules', 'projects.withoutDeadline', 'Without deadline', '2019-10-27 21:24:09', '2019-10-27 21:24:27'),
(1091, 1, 'en', 'modules', 'projects.withoutDeadline', 'Without deadline', '2019-10-27 21:24:09', '2019-10-27 21:24:09'),
(1092, 1, 'en', 'modules', 'projects.withoutDeadline', 'Without deadline', '2019-10-27 21:24:09', '2019-10-27 21:24:09'),
(1093, 0, 'en', 'modules', 'projects.expenses_total', 'Expenses', '2019-10-27 21:24:10', '2019-10-27 21:24:10'),
(1094, 1, 'en', 'modules', 'projects.expenses_total', 'Expenses', '2019-10-27 21:24:10', '2019-10-27 21:24:10'),
(1095, 0, 'en', 'modules', 'projects.selfAssignAsProjectMember', 'Self assign as project member', '2019-10-27 21:24:10', '2019-10-27 21:24:10'),
(1096, 1, 'en', 'modules', 'projects.selfAssignAsProjectMember', 'Self assign as project member', '2019-10-27 21:24:10', '2019-10-27 21:24:10'),
(1097, 0, 'en', 'modules', 'projects.milestoneCost', 'Milestone Cost', '2019-10-27 21:24:10', '2019-10-27 21:24:11'),
(1098, 0, 'en', 'modules', 'projects.milestoneSummary', 'Milestone Summary', '2019-10-27 21:24:11', '2019-10-27 21:24:11'),
(1099, 0, 'en', 'modules', 'projects.milestoneTitle', 'Milestone Title', '2019-10-27 21:24:11', '2019-10-27 21:24:11'),
(1100, 0, 'en', 'modules', 'projects.projectBudget', 'Project Budget', '2019-10-27 21:24:11', '2019-10-27 21:24:11'),
(1101, 0, 'en', 'modules', 'projects.hours_allocated', 'Hours Allocated', '2019-10-27 21:24:11', '2019-10-27 21:24:11'),
(1102, 0, 'en', 'modules', 'projects.budgetInfo', 'Budget Info', '2019-10-27 21:24:11', '2019-10-27 21:24:11'),
(1103, 0, 'en', 'modules', 'projects.remindBefore', 'Remind before', '2019-10-27 21:24:11', '2019-10-27 21:24:27'),
(1104, 1, 'en', 'modules', 'projects.remindBefore', 'Remind before', '2019-10-27 21:24:11', '2019-10-27 21:24:11'),
(1105, 1, 'en', 'modules', 'projects.remindBefore', 'Remind before', '2019-10-27 21:24:11', '2019-10-27 21:24:11'),
(1106, 0, 'en', 'modules', 'tasks.lastCreated', 'Last Created', '2019-10-27 21:24:12', '2019-10-27 21:24:12'),
(1107, 0, 'en', 'modules', 'tasks.dueSoon', 'Due Soon', '2019-10-27 21:24:12', '2019-10-27 21:24:12'),
(1108, 1, 'en', 'modules', 'tasks.dueSoon', 'Due Soon', '2019-10-27 21:24:12', '2019-10-27 21:24:12'),
(1109, 0, 'en', 'modules', 'tasks.columnName', 'Column Name', '2019-10-27 21:24:13', '2019-10-27 21:24:27'),
(1110, 1, 'en', 'modules', 'tasks.columnName', 'Column Name', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1111, 1, 'en', 'modules', 'tasks.columnName', 'Column Name', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1112, 0, 'en', 'modules', 'tasks.labelColor', 'Label Color', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1113, 0, 'en', 'modules', 'tasks.position', 'Position', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1114, 1, 'en', 'modules', 'tasks.position', 'Position', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1115, 0, 'en', 'modules', 'tasks.taskCategory', 'Task Category', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1116, 1, 'en', 'modules', 'tasks.taskCategory', 'Task Category', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1117, 0, 'en', 'modules', 'tasks.category', 'Category', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1118, 1, 'en', 'modules', 'tasks.category', 'Category', '2019-10-27 21:24:14', '2019-10-27 21:24:14'),
(1119, 0, 'en', 'modules', 'tasks.cyclesToolTip', 'Recurring task will be created between start and due date for the below number of cycles.', '2019-10-27 21:24:15', '2019-10-27 21:24:28'),
(1120, 1, 'en', 'modules', 'tasks.cyclesToolTip', 'Recurring task will be created between start and due date for the below number of cycles.', '2019-10-27 21:24:15', '2019-10-27 21:24:15'),
(1121, 1, 'en', 'modules', 'tasks.cyclesToolTip', 'Recurring task will be created between start and due date for the below number of cycles.', '2019-10-27 21:24:15', '2019-10-27 21:24:15'),
(1122, 0, 'en', 'modules', 'invoices.unpaid', 'Unpaid', '2019-10-27 21:24:15', '2019-10-27 21:24:15'),
(1123, 0, 'en', 'modules', 'invoices.invoiceDate', 'Invoice Date', '2019-10-27 21:24:15', '2019-10-27 21:24:16'),
(1124, 0, 'en', 'modules', 'invoices.subTotal', 'Sub Total', '2019-10-27 21:24:16', '2019-10-27 21:24:29'),
(1125, 1, 'en', 'modules', 'invoices.subTotal', 'Sub Total', '2019-10-27 21:24:16', '2019-10-27 21:24:16'),
(1126, 1, 'en', 'modules', 'invoices.subTotal', 'Sub Total', '2019-10-27 21:24:16', '2019-10-27 21:24:16'),
(1127, 0, 'en', 'modules', 'invoices.total', 'Total', '2019-10-27 21:24:16', '2019-10-27 21:24:16'),
(1128, 0, 'en', 'modules', 'invoices.billedTo', 'Billed To', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1129, 0, 'en', 'modules', 'invoices.generatedBy', 'Generated By', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1130, 0, 'en', 'modules', 'invoices.price', 'Price', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1131, 0, 'en', 'modules', 'invoices.isRecurringPayment', 'Is it a recurring payments?', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1132, 1, 'en', 'modules', 'invoices.isRecurringPayment', 'Is it a recurring payments?', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1133, 0, 'en', 'modules', 'invoices.billingCycle', 'Billing Cycle', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1134, 1, 'en', 'modules', 'invoices.billingCycle', 'Billing Cycle', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1135, 0, 'en', 'modules', 'invoices.billingFrequency', 'Billing Frequency', '2019-10-27 21:24:17', '2019-10-27 21:24:29'),
(1136, 1, 'en', 'modules', 'invoices.billingFrequency', 'Billing Frequency', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1137, 1, 'en', 'modules', 'invoices.billingFrequency', 'Billing Frequency', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1138, 0, 'en', 'modules', 'invoices.billingInterval', 'Billing Interval', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1139, 1, 'en', 'modules', 'invoices.billingInterval', 'Billing Interval', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1140, 0, 'en', 'modules', 'invoices.recurringPayments', 'Recurring Payment', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1141, 1, 'en', 'modules', 'invoices.recurringPayments', 'Recurring Payment', '2019-10-27 21:24:17', '2019-10-27 21:24:17'),
(1142, 0, 'en', 'modules', 'invoices.taxName', 'Tax Name', '2019-10-27 21:24:18', '2019-10-27 21:24:18'),
(1143, 1, 'en', 'modules', 'invoices.taxName', 'Tax Name', '2019-10-27 21:24:18', '2019-10-27 21:24:18'),
(1144, 0, 'en', 'modules', 'invoices.rate', 'Rate', '2019-10-27 21:24:18', '2019-10-27 21:24:29'),
(1145, 1, 'en', 'modules', 'invoices.rate', 'Rate', '2019-10-27 21:24:18', '2019-10-27 21:24:18'),
(1146, 1, 'en', 'modules', 'invoices.rate', 'Rate', '2019-10-27 21:24:18', '2019-10-27 21:24:18'),
(1147, 0, 'en', 'modules', 'invoices.payOffline', 'Pay Offline', '2019-10-27 21:24:18', '2019-10-27 21:24:30'),
(1148, 1, 'en', 'modules', 'invoices.payOffline', 'Pay Offline', '2019-10-27 21:24:18', '2019-10-27 21:24:18'),
(1149, 1, 'en', 'modules', 'invoices.payOffline', 'Pay Offline', '2019-10-27 21:24:18', '2019-10-27 21:24:18'),
(1150, 0, 'en', 'modules', 'invoices.uploadInvoice', 'Upload Invoice', '2019-10-27 21:24:19', '2019-10-27 21:24:19'),
(1151, 1, 'en', 'modules', 'invoices.uploadInvoice', 'Upload Invoice', '2019-10-27 21:24:19', '2019-10-27 21:24:19'),
(1152, 0, 'en', 'modules', 'invoices.project', 'Project', '2019-10-27 21:24:19', '2019-10-27 21:24:19'),
(1153, 1, 'en', 'modules', 'invoices.project', 'Project', '2019-10-27 21:24:19', '2019-10-27 21:24:19'),
(1154, 0, 'en', 'modules', 'invoices.copyPaymentLink', 'Copy Payment Link', '2019-10-27 21:24:19', '2019-10-27 21:24:30'),
(1155, 1, 'en', 'modules', 'invoices.copyPaymentLink', 'Copy Payment Link', '2019-10-27 21:24:19', '2019-10-27 21:24:19'),
(1156, 1, 'en', 'modules', 'invoices.copyPaymentLink', 'Copy Payment Link', '2019-10-27 21:24:19', '2019-10-27 21:24:19'),
(1157, 0, 'en', 'modules', 'issues.reportedOn', 'Reported On', '2019-10-27 21:24:20', '2019-10-27 21:24:20'),
(1158, 1, 'en', 'modules', 'issues.reportedOn', 'Reported On', '2019-10-27 21:24:20', '2019-10-27 21:24:20'),
(1159, 0, 'en', 'modules', 'timeLogs.whoLogged', 'Who Logged', '2019-10-27 21:24:20', '2019-10-27 21:24:20'),
(1160, 0, 'en', 'modules', 'timeLogs.startTime', 'Start Time', '2019-10-27 21:24:20', '2019-10-27 21:24:20'),
(1161, 1, 'en', 'modules', 'timeLogs.startTime', 'Start Time', '2019-10-27 21:24:20', '2019-10-27 21:24:20'),
(1162, 0, 'en', 'modules', 'timeLogs.endTime', 'End Time', '2019-10-27 21:24:20', '2019-10-27 21:24:20'),
(1163, 1, 'en', 'modules', 'timeLogs.endTime', 'End Time', '2019-10-27 21:24:20', '2019-10-27 21:24:20'),
(1164, 0, 'en', 'modules', 'timeLogs.totalHours', 'Total Hours', '2019-10-27 21:24:20', '2019-10-27 21:24:21'),
(1165, 0, 'en', 'modules', 'timeLogs.memo', 'Memo', '2019-10-27 21:24:21', '2019-10-27 21:24:21'),
(1166, 0, 'en', 'modules', 'timeLogs.lastUpdatedBy', 'Last updated by', '2019-10-27 21:24:21', '2019-10-27 21:24:21'),
(1167, 0, 'en', 'modules', 'timeLogs.employeeName', 'Employee Name', '2019-10-27 21:24:21', '2019-10-27 21:24:21'),
(1168, 1, 'en', 'modules', 'timeLogs.employeeName', 'Employee Name', '2019-10-27 21:24:21', '2019-10-27 21:24:21'),
(1169, 0, 'en', 'modules', 'timeLogs.startDate', 'Start Date', '2019-10-27 21:24:21', '2019-10-27 21:24:21'),
(1170, 1, 'en', 'modules', 'timeLogs.startDate', 'Start Date', '2019-10-27 21:24:21', '2019-10-27 21:24:21'),
(1171, 0, 'en', 'modules', 'timeLogs.endDate', 'End Date', '2019-10-27 21:24:21', '2019-10-27 21:24:30'),
(1172, 1, 'en', 'modules', 'timeLogs.endDate', 'End Date', '2019-10-27 21:24:21', '2019-10-27 21:24:21'),
(1173, 1, 'en', 'modules', 'timeLogs.endDate', 'End Date', '2019-10-27 21:24:21', '2019-10-27 21:24:21'),
(1174, 0, 'en', 'modules', 'timeLogs.task', 'Task', '2019-10-27 21:24:22', '2019-10-27 21:24:23'),
(1175, 0, 'en', 'modules', 'taskCalendar.taskDetail', 'Task Detail', '2019-10-27 21:24:23', '2019-10-27 21:24:23'),
(1176, 0, 'en', 'modules', 'notices.notice', 'Notice', '2019-10-27 21:24:23', '2019-10-27 21:24:23'),
(1177, 1, 'en', 'modules', 'notices.notice', 'Notice', '2019-10-27 21:24:23', '2019-10-27 21:24:23'),
(1178, 0, 'en', 'modules', 'notices.noticeHeading', 'Notice Heading', '2019-10-27 21:24:23', '2019-10-27 21:24:23'),
(1179, 0, 'en', 'modules', 'notices.noticeDetails', 'Notice Details', '2019-10-27 21:24:23', '2019-10-27 21:24:24'),
(1180, 1, 'en', 'modules', 'notices.noticeDetails', 'Notice Details', '2019-10-27 21:24:23', '2019-10-27 21:24:23'),
(1181, 0, 'en', 'modules', 'taskReport.taskToComplete', 'Task To Be Completed', '2019-10-27 21:24:24', '2019-10-27 21:24:24'),
(1182, 1, 'en', 'modules', 'taskReport.taskToComplete', 'Task To Be Completed', '2019-10-27 21:24:24', '2019-10-27 21:24:24'),
(1183, 0, 'en', 'modules', 'taskReport.completedTasks', 'Completed Tasks', '2019-10-27 21:24:24', '2019-10-27 21:24:24'),
(1184, 1, 'en', 'modules', 'taskReport.completedTasks', 'Completed Tasks', '2019-10-27 21:24:24', '2019-10-27 21:24:24'),
(1185, 0, 'en', 'modules', 'taskReport.pendingTasks', 'Pending Tasks', '2019-10-27 21:24:24', '2019-10-27 21:24:24'),
(1186, 1, 'en', 'modules', 'taskReport.pendingTasks', 'Pending Tasks', '2019-10-27 21:24:24', '2019-10-27 21:24:24'),
(1187, 0, 'en', 'modules', 'taskReport.chartTitle', 'Pie Chart', '2019-10-27 21:24:24', '2019-10-27 21:24:24'),
(1188, 1, 'en', 'modules', 'taskReport.chartTitle', 'Pie Chart', '2019-10-27 21:24:24', '2019-10-27 21:24:24'),
(1189, 0, 'en', 'modules', 'leaveReport.leaveReport', 'Leave Report', '2019-10-27 21:24:25', '2019-10-27 21:24:25'),
(1190, 1, 'en', 'modules', 'leaveReport.leaveReport', 'Leave Report', '2019-10-27 21:24:25', '2019-10-27 21:24:25'),
(1191, 0, 'en', 'modules', 'timeLogReport.chartTitle', 'Time Log Bar Chart', '2019-10-27 21:24:25', '2019-10-27 21:24:25'),
(1192, 1, 'en', 'modules', 'timeLogReport.chartTitle', 'Time Log Bar Chart', '2019-10-27 21:24:25', '2019-10-27 21:24:25'),
(1193, 0, 'en', 'modules', 'financeReport.showAmountIn', 'Show amount in ', '2019-10-27 21:24:25', '2019-10-27 21:24:25'),
(1194, 1, 'en', 'modules', 'financeReport.showAmountIn', 'Show amount in ', '2019-10-27 21:24:25', '2019-10-27 21:24:25'),
(1195, 0, 'en', 'modules', 'financeReport.chartTitle', 'Earnings Bar Chart', '2019-10-27 21:24:25', '2019-10-27 21:24:25'),
(1196, 0, 'en', 'modules', 'financeReport.financeReport', 'Earnings Bar Chart', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1197, 0, 'en', 'modules', 'accountSettings.companyEmail', 'Company Email', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1198, 0, 'en', 'modules', 'accountSettings.companyPhone', 'Company Phone', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1199, 0, 'en', 'modules', 'accountSettings.companyWebsite', 'Company Website', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1200, 0, 'en', 'modules', 'accountSettings.companyLogo', 'Company Logo', '2019-10-27 21:24:26', '2019-10-27 21:24:31'),
(1201, 1, 'en', 'modules', 'accountSettings.companyLogo', 'Company Logo', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1202, 1, 'en', 'modules', 'accountSettings.companyLogo', 'Company Logo', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1203, 0, 'en', 'modules', 'accountSettings.companyAddress', 'Company Address', '2019-10-27 21:24:26', '2019-10-27 21:24:31'),
(1204, 1, 'en', 'modules', 'accountSettings.companyAddress', 'Company Address', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1205, 1, 'en', 'modules', 'accountSettings.companyAddress', 'Company Address', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1206, 0, 'en', 'modules', 'accountSettings.defaultTimezone', 'Default Timezone', '2019-10-27 21:24:26', '2019-10-27 21:24:32'),
(1207, 1, 'en', 'modules', 'accountSettings.defaultTimezone', 'Default Timezone', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1208, 1, 'en', 'modules', 'accountSettings.defaultTimezone', 'Default Timezone', '2019-10-27 21:24:26', '2019-10-27 21:24:26'),
(1209, 0, 'en', 'modules', 'accountSettings.defaultCurrency', 'Default Currency', '2019-10-27 21:24:27', '2019-10-27 21:24:32'),
(1210, 1, 'en', 'modules', 'accountSettings.defaultCurrency', 'Default Currency', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1211, 1, 'en', 'modules', 'accountSettings.defaultCurrency', 'Default Currency', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1212, 0, 'en', 'modules', 'accountSettings.changeLanguage', 'Change Language', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1213, 0, 'en', 'modules', 'accountSettings.getLocation', 'Set current location', '2019-10-27 21:24:27', '2019-10-27 21:24:32'),
(1214, 1, 'en', 'modules', 'accountSettings.getLocation', 'Set current location', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1215, 1, 'en', 'modules', 'accountSettings.getLocation', 'Set current location', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1216, 0, 'en', 'modules', 'accountSettings.dateFormat', 'Date Format', '2019-10-27 21:24:27', '2019-10-27 21:24:32'),
(1217, 1, 'en', 'modules', 'accountSettings.dateFormat', 'Date Format', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1218, 1, 'en', 'modules', 'accountSettings.dateFormat', 'Date Format', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1219, 0, 'en', 'modules', 'accountSettings.timeFormat', 'Time Format', '2019-10-27 21:24:27', '2019-10-27 21:24:32'),
(1220, 1, 'en', 'modules', 'accountSettings.timeFormat', 'Time Format', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1221, 1, 'en', 'modules', 'accountSettings.timeFormat', 'Time Format', '2019-10-27 21:24:27', '2019-10-27 21:24:27'),
(1222, 0, 'en', 'modules', 'accountSettings.google_map_key', 'Google map key', '2019-10-27 21:24:28', '2019-10-27 21:24:33'),
(1223, 1, 'en', 'modules', 'accountSettings.google_map_key', 'Google map key', '2019-10-27 21:24:28', '2019-10-27 21:24:28'),
(1224, 1, 'en', 'modules', 'accountSettings.google_map_key', 'Google map key', '2019-10-27 21:24:28', '2019-10-27 21:24:28'),
(1225, 0, 'en', 'modules', 'accountSettings.sendReminder', 'Send Reminder', '2019-10-27 21:24:28', '2019-10-27 21:24:28'),
(1226, 1, 'en', 'modules', 'accountSettings.sendReminder', 'Send Reminder', '2019-10-27 21:24:28', '2019-10-27 21:24:28'),
(1227, 0, 'en', 'modules', 'accountSettings.google_recaptcha_secret', 'Google Recpatcha Secret', '2019-10-27 21:24:28', '2019-10-27 21:24:29'),
(1228, 0, 'en', 'modules', 'accountSettings.weekStartFrom', 'Week start from', '2019-10-27 21:24:29', '2019-10-27 21:24:29'),
(1229, 0, 'en', 'modules', 'profile.yourPassword', 'Your Password', '2019-10-27 21:24:29', '2019-10-27 21:24:29'),
(1230, 1, 'en', 'modules', 'profile.yourPassword', 'Your Password', '2019-10-27 21:24:29', '2019-10-27 21:24:29'),
(1231, 0, 'en', 'modules', 'profile.yourMobileNumber', 'Your Mobile Number', '2019-10-27 21:24:29', '2019-10-27 21:24:33'),
(1232, 1, 'en', 'modules', 'profile.yourMobileNumber', 'Your Mobile Number', '2019-10-27 21:24:29', '2019-10-27 21:24:29'),
(1233, 1, 'en', 'modules', 'profile.yourMobileNumber', 'Your Mobile Number', '2019-10-27 21:24:29', '2019-10-27 21:24:29'),
(1234, 0, 'en', 'modules', 'profile.yourAddress', 'Your Address', '2019-10-27 21:24:29', '2019-10-27 21:24:30'),
(1235, 0, 'en', 'modules', 'profile.profilePicture', 'Profile Picture', '2019-10-27 21:24:29', '2019-10-27 21:24:30'),
(1236, 0, 'en', 'modules', 'emailSettings.notificationTitle', 'Set Email Notification Settings', '2019-10-27 21:24:30', '2019-10-27 21:24:33'),
(1237, 1, 'en', 'modules', 'emailSettings.notificationTitle', 'Set Email Notification Settings', '2019-10-27 21:24:30', '2019-10-27 21:24:30'),
(1238, 1, 'en', 'modules', 'emailSettings.notificationTitle', 'Set Email Notification Settings', '2019-10-27 21:24:30', '2019-10-27 21:24:30'),
(1239, 0, 'en', 'modules', 'emailSettings.configTitle', 'Mail Configuration', '2019-10-27 21:24:30', '2019-10-27 21:24:30'),
(1240, 1, 'en', 'modules', 'emailSettings.configTitle', 'Mail Configuration', '2019-10-27 21:24:30', '2019-10-27 21:24:30'),
(1241, 0, 'en', 'modules', 'emailSettings.mailDriver', 'Mail Driver', '2019-10-27 21:24:30', '2019-10-27 21:24:30'),
(1242, 0, 'en', 'modules', 'emailSettings.mailHost', 'Mail Host', '2019-10-27 21:24:30', '2019-10-27 21:24:30'),
(1243, 0, 'en', 'modules', 'emailSettings.mailPort', 'Mail Port', '2019-10-27 21:24:30', '2019-10-27 21:24:33'),
(1244, 1, 'en', 'modules', 'emailSettings.mailPort', 'Mail Port', '2019-10-27 21:24:30', '2019-10-27 21:24:30'),
(1245, 1, 'en', 'modules', 'emailSettings.mailPort', 'Mail Port', '2019-10-27 21:24:30', '2019-10-27 21:24:30'),
(1246, 0, 'en', 'modules', 'emailSettings.mailUsername', 'Mail Username', '2019-10-27 21:24:30', '2019-10-27 21:24:31'),
(1247, 0, 'en', 'modules', 'emailSettings.mailPassword', 'Mail Password', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1248, 1, 'en', 'modules', 'emailSettings.mailPassword', 'Mail Password', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1249, 0, 'en', 'modules', 'emailSettings.mailFrom', 'Mail From Name', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1250, 0, 'en', 'modules', 'emailSettings.mailEncryption', 'Mail Encryption', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1251, 1, 'en', 'modules', 'emailSettings.mailEncryption', 'Mail Encryption', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1252, 0, 'en', 'modules', 'emailSettings.userRegistration', 'User Registration/Added by Admin', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1253, 1, 'en', 'modules', 'emailSettings.userRegistration', 'User Registration/Added by Admin', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1254, 0, 'en', 'modules', 'emailSettings.employeeAssign', 'Employee Assign to Project', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1255, 0, 'en', 'modules', 'emailSettings.newNotice', 'New Notice Published', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1256, 1, 'en', 'modules', 'emailSettings.newNotice', 'New Notice Published', '2019-10-27 21:24:31', '2019-10-27 21:24:31'),
(1257, 0, 'en', 'modules', 'emailSettings.taskAssign', 'User Assign to Task', '2019-10-27 21:24:31', '2019-10-27 21:24:32'),
(1258, 0, 'en', 'modules', 'emailSettings.expenseAdded', 'New Expense (Added by Admin)', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1259, 1, 'en', 'modules', 'emailSettings.expenseAdded', 'New Expense (Added by Admin)', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1260, 0, 'en', 'modules', 'emailSettings.expenseMember', 'New Expense (Added by Member)', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1261, 0, 'en', 'modules', 'emailSettings.expenseStatus', 'Expense Status Changed', '2019-10-27 21:24:32', '2019-10-27 21:24:33'),
(1262, 1, 'en', 'modules', 'emailSettings.expenseStatus', 'Expense Status Changed', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1263, 1, 'en', 'modules', 'emailSettings.expenseStatus', 'Expense Status Changed', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1264, 0, 'en', 'modules', 'emailSettings.ticketRequest', 'New Support Ticket Request', '2019-10-27 21:24:32', '2019-10-27 21:24:33'),
(1265, 1, 'en', 'modules', 'emailSettings.ticketRequest', 'New Support Ticket Request', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1266, 1, 'en', 'modules', 'emailSettings.ticketRequest', 'New Support Ticket Request', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1267, 0, 'en', 'modules', 'emailSettings.mailFromEmail', 'Mail From Email', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1268, 1, 'en', 'modules', 'emailSettings.mailFromEmail', 'Mail From Email', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1269, 0, 'en', 'modules', 'emailSettings.leaveRequest', 'Leave Request Received', '2019-10-27 21:24:32', '2019-10-27 21:24:33'),
(1270, 1, 'en', 'modules', 'emailSettings.leaveRequest', 'Leave Request Received', '2019-10-27 21:24:32', '2019-10-27 21:24:32'),
(1271, 0, 'en', 'modules', 'emailSettings.taskComplete', 'Task completed', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1272, 1, 'en', 'modules', 'emailSettings.taskComplete', 'Task completed', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1273, 0, 'en', 'modules', 'emailSettings.sendTestEmail', 'Send Test Email', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1274, 1, 'en', 'modules', 'emailSettings.sendTestEmail', 'Send Test Email', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1275, 0, 'en', 'modules', 'emailSettings.removeImage', 'Remove Image', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1276, 0, 'en', 'modules', 'emailSettings.invoiceNotification', 'Invoice  Notification', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1277, 0, 'en', 'modules', 'moduleSettings.employeeModuleTitle', 'Modules', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1278, 1, 'en', 'modules', 'moduleSettings.employeeModuleTitle', 'Modules', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1279, 0, 'en', 'modules', 'moduleSettings.clientModuleTitle', 'Client Module Title', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1280, 0, 'en', 'modules', 'moduleSettings.clientSubTitle', 'Select the modules which client can access.', '2019-10-27 21:24:33', '2019-10-27 21:24:34'),
(1281, 1, 'en', 'modules', 'moduleSettings.clientSubTitle', 'Select the modules which client can access.', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1282, 1, 'en', 'modules', 'moduleSettings.clientSubTitle', 'Select the modules which client can access.', '2019-10-27 21:24:33', '2019-10-27 21:24:33'),
(1283, 0, 'en', 'modules', 'currencySettings.addNewCurrency', 'Add New Currency', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1284, 0, 'en', 'modules', 'currencySettings.currencyName', 'Currency Name', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1285, 1, 'en', 'modules', 'currencySettings.currencyName', 'Currency Name', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1286, 0, 'en', 'modules', 'currencySettings.currencySymbol', 'Currency Symbol', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1287, 1, 'en', 'modules', 'currencySettings.currencySymbol', 'Currency Symbol', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1288, 0, 'en', 'modules', 'currencySettings.currencyCode', 'Currency Code', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1289, 0, 'en', 'modules', 'currencySettings.currencies', 'Currencies', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1290, 0, 'en', 'modules', 'currencySettings.updateTitle', 'Update Currency', '2019-10-27 21:24:34', '2019-10-27 21:24:46'),
(1291, 1, 'en', 'modules', 'currencySettings.updateTitle', 'Update Currency', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1292, 1, 'en', 'modules', 'currencySettings.updateTitle', 'Update Currency', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1293, 1, 'en', 'modules', 'currencySettings.updateTitle', 'Update Currency', '2019-10-27 21:24:34', '2019-10-27 21:24:34'),
(1294, 0, 'en', 'modules', 'currencySettings.isCryptoCurrency', 'Is Cryptocurrency', '2019-10-27 21:24:35', '2019-10-27 21:24:35'),
(1295, 0, 'en', 'modules', 'currencySettings.usdPrice', 'Usd Price', '2019-10-27 21:24:35', '2019-10-27 21:24:35'),
(1296, 0, 'en', 'modules', 'currencySettings.usdPriceInfo', 'Required to calculate earnings.', '2019-10-27 21:24:35', '2019-10-27 21:24:35'),
(1297, 0, 'en', 'modules', 'messages.allowClientEmployeeChat', 'Allow chat between client and employees?', '2019-10-27 21:24:35', '2019-10-27 21:24:35'),
(1298, 1, 'en', 'modules', 'messages.allowClientEmployeeChat', 'Allow chat between client and employees?', '2019-10-27 21:24:35', '2019-10-27 21:24:35'),
(1299, 1, 'en', 'modules', 'messages.allowClientEmployeeChat', 'Allow chat between client and employees?', '2019-10-27 21:24:35', '2019-10-27 21:24:35'),
(1300, 0, 'en', 'modules', 'messages.allowClientAdminChat', 'Allow chat between client and admin?', '2019-10-27 21:24:35', '2019-10-27 21:24:35'),
(1301, 0, 'en', 'modules', 'messages.admins', 'Administrators', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1302, 1, 'en', 'modules', 'messages.admins', 'Administrators', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1303, 0, 'en', 'modules', 'messages.members', 'Project Members', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1304, 1, 'en', 'modules', 'messages.admins', 'Administrators', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1305, 1, 'en', 'modules', 'messages.members', 'Project Members', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1306, 0, 'en', 'modules', 'projectCategory.categoryName', 'Category Name', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1307, 1, 'en', 'modules', 'projectCategory.categoryName', 'Category Name', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1308, 1, 'en', 'modules', 'projectCategory.categoryName', 'Category Name', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1309, 0, 'en', 'modules', 'themeSettings.adminPanelTheme', 'Admin Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36');
INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1310, 1, 'en', 'modules', 'themeSettings.adminPanelTheme', 'Admin Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1311, 1, 'en', 'modules', 'themeSettings.adminPanelTheme', 'Admin Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1312, 0, 'en', 'modules', 'themeSettings.projectAdminPanelTheme', 'Project Admin Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1313, 1, 'en', 'modules', 'themeSettings.projectAdminPanelTheme', 'Project Admin Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1314, 1, 'en', 'modules', 'themeSettings.projectAdminPanelTheme', 'Project Admin Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1315, 0, 'en', 'modules', 'themeSettings.employeePanelTheme', 'Employee Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1316, 1, 'en', 'modules', 'themeSettings.employeePanelTheme', 'Employee Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1317, 1, 'en', 'modules', 'themeSettings.employeePanelTheme', 'Employee Panel Theme', '2019-10-27 21:24:36', '2019-10-27 21:24:36'),
(1318, 0, 'en', 'modules', 'themeSettings.clientPanelTheme', 'Client Panel Theme', '2019-10-27 21:24:37', '2019-10-27 21:24:46'),
(1319, 1, 'en', 'modules', 'themeSettings.clientPanelTheme', 'Client Panel Theme', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1320, 1, 'en', 'modules', 'themeSettings.clientPanelTheme', 'Client Panel Theme', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1321, 1, 'en', 'modules', 'themeSettings.clientPanelTheme', 'Client Panel Theme', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1322, 0, 'en', 'modules', 'themeSettings.headerColor', 'Header Color (Primary)', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1323, 0, 'en', 'modules', 'themeSettings.sidebarColor', 'Sidebar Color', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1324, 1, 'en', 'modules', 'themeSettings.sidebarColor', 'Sidebar Color', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1325, 1, 'en', 'modules', 'themeSettings.sidebarColor', 'Sidebar Color', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1326, 0, 'en', 'modules', 'themeSettings.sidebarTextColor', 'Sidebar Text Color', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1327, 1, 'en', 'modules', 'themeSettings.sidebarTextColor', 'Sidebar Text Color', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1328, 0, 'en', 'modules', 'themeSettings.linkColor', 'Link Color', '2019-10-27 21:24:37', '2019-10-27 21:24:46'),
(1329, 1, 'en', 'modules', 'themeSettings.linkColor', 'Link Color', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1330, 1, 'en', 'modules', 'themeSettings.linkColor', 'Link Color', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1331, 1, 'en', 'modules', 'themeSettings.linkColor', 'Link Color', '2019-10-27 21:24:37', '2019-10-27 21:24:37'),
(1332, 0, 'en', 'modules', 'themeSettings.loginScreenBackground', 'Login Screen Background', '2019-10-27 21:24:38', '2019-10-27 21:24:46'),
(1333, 0, 'en', 'modules', 'themeSettings.loginScreenBackground', 'Login Screen Background', '2019-10-27 21:24:38', '2019-10-27 21:24:38'),
(1334, 0, 'en', 'modules', 'themeSettings.uploadImage', 'Upload Image', '2019-10-27 21:24:38', '2019-10-27 21:24:38'),
(1335, 1, 'en', 'modules', 'themeSettings.uploadImage', 'Upload Image', '2019-10-27 21:24:38', '2019-10-27 21:24:38'),
(1336, 0, 'en', 'modules', 'themeSettings.useDefaultTheme', 'Use Default Theme', '2019-10-27 21:24:38', '2019-10-27 21:24:46'),
(1337, 1, 'en', 'modules', 'themeSettings.useDefaultTheme', 'Use Default Theme', '2019-10-27 21:24:38', '2019-10-27 21:24:38'),
(1338, 1, 'en', 'modules', 'themeSettings.useDefaultTheme', 'Use Default Theme', '2019-10-27 21:24:38', '2019-10-27 21:24:38'),
(1339, 1, 'en', 'modules', 'themeSettings.useDefaultTheme', 'Use Default Theme', '2019-10-27 21:24:38', '2019-10-27 21:24:38'),
(1340, 0, 'en', 'modules', 'themeSettings.useCustomTheme', 'Use Custom Theme', '2019-10-27 21:24:38', '2019-10-27 21:24:39'),
(1341, 1, 'en', 'modules', 'themeSettings.useCustomTheme', 'Use Custom Theme', '2019-10-27 21:24:38', '2019-10-27 21:24:38'),
(1342, 0, 'en', 'modules', 'themeSettings.enableRoundTheme', 'Enable rounded theme?', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1343, 1, 'en', 'modules', 'themeSettings.enableRoundTheme', 'Enable rounded theme?', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1344, 0, 'en', 'modules', 'themeSettings.publicCss', 'public/css/', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1345, 0, 'en', 'modules', 'estimates.validTill', 'Valid Till', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1346, 1, 'en', 'modules', 'estimates.validTill', 'Valid Till', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1347, 0, 'en', 'modules', 'estimates.waiting', 'Waiting', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1348, 0, 'en', 'modules', 'estimates.accepted', 'Accepted', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1349, 1, 'en', 'modules', 'estimates.accepted', 'Accepted', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1350, 1, 'en', 'modules', 'estimates.accepted', 'Accepted', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1351, 0, 'en', 'modules', 'estimates.declined', 'Declined', '2019-10-27 21:24:39', '2019-10-27 21:24:40'),
(1352, 1, 'en', 'modules', 'estimates.declined', 'Declined', '2019-10-27 21:24:39', '2019-10-27 21:24:39'),
(1353, 0, 'en', 'modules', 'estimates.estimatesNumber', 'Estimate #', '2019-10-27 21:24:40', '2019-10-27 21:24:40'),
(1354, 1, 'en', 'modules', 'estimates.estimatesNumber', 'Estimate #', '2019-10-27 21:24:40', '2019-10-27 21:24:40'),
(1355, 0, 'en', 'modules', 'payments.selectInvoice', 'Select Invoice', '2019-10-27 21:24:41', '2019-10-27 21:24:47'),
(1356, 1, 'en', 'modules', 'payments.selectInvoice', 'Select Invoice', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1357, 1, 'en', 'modules', 'payments.selectInvoice', 'Select Invoice', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1358, 1, 'en', 'modules', 'payments.selectInvoice', 'Select Invoice', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1359, 0, 'en', 'modules', 'payments.paymentGateway', 'Payment Gateway', '2019-10-27 21:24:41', '2019-10-27 21:24:48'),
(1360, 0, 'en', 'modules', 'payments.paymentGateway', 'Payment Gateway', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1361, 0, 'en', 'modules', 'payments.transactionId', 'Transaction Id', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1362, 0, 'en', 'modules', 'payments.paypalStatus', 'Paypal Status', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1363, 0, 'en', 'modules', 'payments.markInvoicePaid', 'Mark Invoice Paid?', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1364, 1, 'en', 'modules', 'payments.markInvoicePaid', 'Mark Invoice Paid?', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1365, 0, 'en', 'modules', 'payments.stripeStatus', 'Stripe Status', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1366, 1, 'en', 'modules', 'payments.stripeStatus', 'Stripe Status', '2019-10-27 21:24:41', '2019-10-27 21:24:41'),
(1367, 0, 'en', 'modules', 'payments.firstCharacter', 'First Character is Currency?', '2019-10-27 21:24:41', '2019-10-27 21:24:42'),
(1368, 1, 'en', 'modules', 'payments.firstCharacter', 'First Character is Currency?', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1369, 0, 'en', 'modules', 'payments.remark', 'Remark', '2019-10-27 21:24:42', '2019-10-27 21:24:48'),
(1370, 0, 'en', 'modules', 'payments.remark', 'Remark', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1371, 1, 'en', 'modules', 'payments.remark', 'Remark', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1372, 0, 'en', 'modules', 'payments.amount', 'Amount', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1373, 0, 'en', 'modules', 'payments.totalAmount', 'Total Amount', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1374, 1, 'en', 'modules', 'payments.totalAmount', 'Total Amount', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1375, 0, 'en', 'modules', 'payments.totalPaid', 'Total Paid', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1376, 1, 'en', 'modules', 'payments.totalPaid', 'Total Paid', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1377, 0, 'en', 'modules', 'payments.totalDue', 'Total Due', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1378, 0, 'en', 'modules', 'payments.paymentDetailNotFound', 'Payment details not found.', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1379, 1, 'en', 'modules', 'payments.paymentDetailNotFound', 'Payment details not found.', '2019-10-27 21:24:42', '2019-10-27 21:24:42'),
(1380, 0, 'en', 'modules', 'expenses.itemName', 'Item Name', '2019-10-27 21:24:43', '2019-10-27 21:24:43'),
(1381, 1, 'en', 'modules', 'expenses.itemName', 'Item Name', '2019-10-27 21:24:43', '2019-10-27 21:24:43'),
(1382, 0, 'en', 'modules', 'expenses.purchaseDate', 'Purchase Date', '2019-10-27 21:24:43', '2019-10-27 21:24:43'),
(1383, 1, 'en', 'modules', 'expenses.purchaseDate', 'Purchase Date', '2019-10-27 21:24:43', '2019-10-27 21:24:43'),
(1384, 0, 'en', 'modules', 'expenses.purchaseFrom', 'Purchased From', '2019-10-27 21:24:43', '2019-10-27 21:24:43'),
(1385, 0, 'en', 'modules', 'invoiceSettings.invoicePrefix', 'Invoice Prefix', '2019-10-27 21:24:43', '2019-10-27 21:24:43'),
(1386, 0, 'en', 'modules', 'invoiceSettings.template', 'Template', '2019-10-27 21:24:43', '2019-10-27 21:24:43'),
(1387, 1, 'en', 'modules', 'invoiceSettings.template', 'Template', '2019-10-27 21:24:43', '2019-10-27 21:24:43'),
(1388, 0, 'en', 'modules', 'invoiceSettings.dueAfter', 'Due after', '2019-10-27 21:24:43', '2019-10-27 21:24:44'),
(1389, 0, 'en', 'modules', 'invoiceSettings.invoiceTerms', 'Invoice terms', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1390, 1, 'en', 'modules', 'invoiceSettings.invoiceTerms', 'Invoice terms', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1391, 0, 'en', 'modules', 'invoiceSettings.updateTitle', 'Update Finance Settings', '2019-10-27 21:24:44', '2019-10-27 21:24:48'),
(1392, 1, 'en', 'modules', 'invoiceSettings.updateTitle', 'Update Finance Settings', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1393, 1, 'en', 'modules', 'invoiceSettings.updateTitle', 'Update Finance Settings', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1394, 1, 'en', 'modules', 'invoiceSettings.updateTitle', 'Update Finance Settings', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1395, 0, 'en', 'modules', 'invoiceSettings.invoiceDigit', 'Invoice Number Digits', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1396, 0, 'en', 'modules', 'invoiceSettings.invoiceLookLike', 'Invoice Number Sample', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1397, 1, 'en', 'modules', 'invoiceSettings.invoiceLookLike', 'Invoice Number Sample', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1398, 0, 'en', 'modules', 'invoiceSettings.estimatePrefix', 'Estimate Prefix', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1399, 1, 'en', 'modules', 'invoiceSettings.estimatePrefix', 'Estimate Prefix', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1400, 1, 'en', 'modules', 'invoiceSettings.estimatePrefix', 'Estimate Prefix', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1401, 0, 'en', 'modules', 'invoiceSettings.estimateDigit', 'Estimate Number Digits', '2019-10-27 21:24:44', '2019-10-27 21:24:49'),
(1402, 1, 'en', 'modules', 'invoiceSettings.estimateDigit', 'Estimate Number Digits', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1403, 1, 'en', 'modules', 'invoiceSettings.estimateDigit', 'Estimate Number Digits', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1404, 1, 'en', 'modules', 'invoiceSettings.estimateDigit', 'Estimate Number Digits', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1405, 0, 'en', 'modules', 'invoiceSettings.estimateLookLike', 'Estimate Number Sample', '2019-10-27 21:24:44', '2019-10-27 21:24:49'),
(1406, 1, 'en', 'modules', 'invoiceSettings.estimateLookLike', 'Estimate Number Sample', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1407, 1, 'en', 'modules', 'invoiceSettings.estimateLookLike', 'Estimate Number Sample', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1408, 1, 'en', 'modules', 'invoiceSettings.estimateLookLike', 'Estimate Number Sample', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1409, 0, 'en', 'modules', 'invoiceSettings.credit_notePrefix', 'Credit Note Prefix', '2019-10-27 21:24:44', '2019-10-27 21:24:44'),
(1410, 0, 'en', 'modules', 'invoiceSettings.credit_noteDigit', 'Credit Note Digits', '2019-10-27 21:24:44', '2019-10-27 21:24:45'),
(1411, 0, 'en', 'modules', 'invoiceSettings.credit_noteLookLike', 'Credit Note Number Sample', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1412, 0, 'en', 'modules', 'slackSettings.updateTitle', 'Update Slack Settings', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1413, 0, 'en', 'modules', 'slackSettings.notificationTitle', 'Set Notification Settings', '2019-10-27 21:24:45', '2019-10-27 21:24:49'),
(1414, 1, 'en', 'modules', 'slackSettings.notificationTitle', 'Set Notification Settings', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1415, 1, 'en', 'modules', 'slackSettings.notificationTitle', 'Set Notification Settings', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1416, 1, 'en', 'modules', 'slackSettings.notificationTitle', 'Set Notification Settings', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1417, 0, 'en', 'modules', 'slackSettings.sendTestNotification', 'Send Test Notification', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1418, 1, 'en', 'modules', 'slackSettings.sendTestNotification', 'Send Test Notification', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1419, 1, 'en', 'modules', 'slackSettings.sendTestNotification', 'Send Test Notification', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1420, 0, 'en', 'modules', 'slackSettings.slackWebhook', 'Slack Webhook', '2019-10-27 21:24:45', '2019-10-27 21:24:49'),
(1421, 1, 'en', 'modules', 'slackSettings.slackWebhook', 'Slack Webhook', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1422, 1, 'en', 'modules', 'slackSettings.slackWebhook', 'Slack Webhook', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1423, 1, 'en', 'modules', 'slackSettings.slackWebhook', 'Slack Webhook', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1424, 0, 'en', 'modules', 'slackSettings.slackNotificationLogo', 'Notification Logo', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1425, 0, 'en', 'modules', 'update.systemDetails', 'System Details', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1426, 1, 'en', 'modules', 'update.systemDetails', 'System Details', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1427, 1, 'en', 'modules', 'update.systemDetails', 'System Details', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1428, 0, 'en', 'modules', 'update.updateTitle', 'Update To New Version', '2019-10-27 21:24:45', '2019-10-27 21:24:49'),
(1429, 0, 'en', 'modules', 'update.updateTitle', 'Update To New Version', '2019-10-27 21:24:45', '2019-10-27 21:24:46'),
(1430, 1, 'en', 'modules', 'update.updateTitle', 'Update To New Version', '2019-10-27 21:24:45', '2019-10-27 21:24:45'),
(1431, 0, 'en', 'modules', 'update.updateDatabase', 'Update Database', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1432, 0, 'en', 'modules', 'update.fileReplaceAlert', 'To update the worksuite to new version check documentation for the instructions.', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1433, 1, 'en', 'modules', 'update.fileReplaceAlert', 'To update the worksuite to new version check documentation for the instructions.', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1434, 0, 'en', 'modules', 'update.updateDatabaseButton', 'Click to update database', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1435, 1, 'en', 'modules', 'update.updateDatabaseButton', 'Click to update database', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1436, 0, 'en', 'modules', 'update.updateNow', 'Update Now', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1437, 0, 'en', 'modules', 'update.updateAlternate', 'If the Update Now button does not work then follow the update instructions as mentioned in the documentation.', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1438, 0, 'en', 'modules', 'update.updateManual', 'Update Manually', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1439, 1, 'en', 'modules', 'update.updateManual', 'Update Manually', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1440, 1, 'en', 'modules', 'update.updateManual', 'Update Manually', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1441, 0, 'en', 'modules', 'update.updateFiles', 'Update Files', '2019-10-27 21:24:46', '2019-10-27 21:24:50'),
(1442, 1, 'en', 'modules', 'update.updateFiles', 'Update Files', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1443, 1, 'en', 'modules', 'update.updateFiles', 'Update Files', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1444, 1, 'en', 'modules', 'update.updateFiles', 'Update Files', '2019-10-27 21:24:46', '2019-10-27 21:24:46'),
(1445, 0, 'en', 'modules', 'update.downloadUpdateFile', 'Download Update File', '2019-10-27 21:24:47', '2019-10-27 21:24:50'),
(1446, 1, 'en', 'modules', 'update.downloadUpdateFile', 'Download Update File', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1447, 1, 'en', 'modules', 'update.downloadUpdateFile', 'Download Update File', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1448, 1, 'en', 'modules', 'update.downloadUpdateFile', 'Download Update File', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1449, 0, 'en', 'modules', 'update.install', 'Install', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1450, 1, 'en', 'modules', 'update.install', 'Install', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1451, 0, 'en', 'modules', 'incomeVsExpenseReport.totalIncome', 'Total Income', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1452, 1, 'en', 'modules', 'incomeVsExpenseReport.totalIncome', 'Total Income', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1453, 0, 'en', 'modules', 'incomeVsExpenseReport.totalExpense', 'Total Expense', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1454, 0, 'en', 'modules', 'incomeVsExpenseReport.chartTitle', 'Bar Chart', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1455, 1, 'en', 'modules', 'incomeVsExpenseReport.chartTitle', 'Bar Chart', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1456, 1, 'en', 'modules', 'incomeVsExpenseReport.chartTitle', 'Bar Chart', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1457, 0, 'en', 'modules', 'tickets.assignGroup', 'Assign Group', '2019-10-27 21:24:47', '2019-10-27 21:24:47'),
(1458, 0, 'en', 'modules', 'tickets.addGroup', 'Add group', '2019-10-27 21:24:47', '2019-10-27 21:24:48'),
(1459, 0, 'en', 'modules', 'tickets.group', 'Group', '2019-10-27 21:24:48', '2019-10-27 21:24:48'),
(1460, 1, 'en', 'modules', 'tickets.group', 'Group', '2019-10-27 21:24:48', '2019-10-27 21:24:48'),
(1461, 0, 'en', 'modules', 'tickets.channelName', 'Channel Name', '2019-10-27 21:24:48', '2019-10-27 21:24:48'),
(1462, 1, 'en', 'modules', 'tickets.channelName', 'Channel Name', '2019-10-27 21:24:48', '2019-10-27 21:24:48'),
(1463, 0, 'en', 'modules', 'tickets.templateHeading', 'Template Heading', '2019-10-27 21:24:48', '2019-10-27 21:24:48'),
(1464, 1, 'en', 'modules', 'tickets.templateHeading', 'Template Heading', '2019-10-27 21:24:48', '2019-10-27 21:24:48'),
(1465, 0, 'en', 'modules', 'tickets.templateText', 'Template Text', '2019-10-27 21:24:48', '2019-10-27 21:24:48'),
(1466, 0, 'en', 'modules', 'tickets.addTicket', 'Create Ticket', '2019-10-27 21:24:49', '2019-10-27 21:24:50'),
(1467, 1, 'en', 'modules', 'tickets.addTicket', 'Create Ticket', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1468, 1, 'en', 'modules', 'tickets.addTicket', 'Create Ticket', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1469, 1, 'en', 'modules', 'tickets.addTicket', 'Create Ticket', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1470, 0, 'en', 'modules', 'tickets.ticketSubject', 'Ticket Subject', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1471, 1, 'en', 'modules', 'tickets.ticketSubject', 'Ticket Subject', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1472, 0, 'en', 'modules', 'tickets.ticketDescription', 'Ticket Description', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1473, 1, 'en', 'modules', 'tickets.ticketDescription', 'Ticket Description', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1474, 0, 'en', 'modules', 'tickets.tags', 'Tags', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1475, 1, 'en', 'modules', 'tickets.tags', 'Tags', '2019-10-27 21:24:49', '2019-10-27 21:24:49'),
(1476, 0, 'en', 'modules', 'tickets.reply', 'Reply', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1477, 0, 'en', 'modules', 'tickets.totalTickets', 'Total Tickets', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1478, 0, 'en', 'modules', 'tickets.totalClosedTickets', 'Closed Tickets', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1479, 0, 'en', 'modules', 'tickets.totalOpenTickets', 'Open Tickets', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1480, 1, 'en', 'modules', 'tickets.totalOpenTickets', 'Open Tickets', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1481, 0, 'en', 'modules', 'tickets.totalPendingTickets', 'Pending Tickets', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1482, 0, 'en', 'modules', 'tickets.requestedOn', 'Requested On', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1483, 0, 'en', 'modules', 'tickets.requestTicket', 'Request Support Ticket', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1484, 1, 'en', 'modules', 'tickets.requestTicket', 'Request Support Ticket', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1485, 0, 'en', 'modules', 'tickets.goToAgentDashboard', 'Go To Agent Dashboard', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1486, 1, 'en', 'modules', 'tickets.goToAgentDashboard', 'Go To Agent Dashboard', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1487, 0, 'en', 'modules', 'tickets.totalTicketInfo', 'No. of new tickets which were created for the selected date range.', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1488, 1, 'en', 'modules', 'tickets.totalTicketInfo', 'No. of new tickets which were created for the selected date range.', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1489, 0, 'en', 'modules', 'tickets.closedTicketInfo', 'No. of tickets which were closed in the selected date range.', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1490, 1, 'en', 'modules', 'tickets.closedTicketInfo', 'No. of tickets which were closed in the selected date range.', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1491, 0, 'en', 'modules', 'tickets.openTicketInfo', 'No. of tickets which are not yet assigned to any agent and updated in the selected date range.', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1492, 1, 'en', 'modules', 'tickets.openTicketInfo', 'No. of tickets which are not yet assigned to any agent and updated in the selected date range.', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1493, 0, 'en', 'modules', 'tickets.pendingTicketInfo', 'No. of tickets which were updated in the selected date range and are assigned to an agent.', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1494, 0, 'en', 'modules', 'tickets.resolvedTicketInfo', 'No. of tickets which were resolved in the selected date range but waiting for requester confirmation.', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1495, 0, 'en', 'modules', 'tickets.completedProjects', 'Completed Projects', '2019-10-27 21:24:50', '2019-10-27 21:24:51'),
(1496, 1, 'en', 'modules', 'tickets.completedProjects', 'Completed Projects', '2019-10-27 21:24:50', '2019-10-27 21:24:50'),
(1497, 0, 'en', 'modules', 'tickets.inProcessProjects', 'In Process Projects', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1498, 0, 'en', 'modules', 'tickets.overDueProjects', 'Overdue Projects', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1499, 0, 'en', 'modules', 'tickets.ticketTrendGraph', 'Ticket trend graph', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1500, 0, 'en', 'modules', 'tickets.urgent', 'Urgent', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1501, 1, 'en', 'modules', 'tickets.urgent', 'Urgent', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1502, 0, 'en', 'modules', 'tickets.nofilter', 'No filter', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1503, 1, 'en', 'modules', 'tickets.nofilter', 'No filter', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1504, 0, 'en', 'modules', 'tickets.noGroupAssigned', 'No group assigned', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1505, 0, 'en', 'modules', 'attendance.officeStartTime', 'Office Start Time', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1506, 1, 'en', 'modules', 'attendance.officeStartTime', 'Office Start Time', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1507, 0, 'en', 'modules', 'attendance.officeEndTime', 'Office End Time', '2019-10-27 21:24:51', '2019-10-27 21:24:52'),
(1508, 1, 'en', 'modules', 'attendance.officeEndTime', 'Office End Time', '2019-10-27 21:24:51', '2019-10-27 21:24:51'),
(1509, 0, 'en', 'modules', 'attendance.halfDayMarkTime', 'HalfDay Mark Time', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1510, 1, 'en', 'modules', 'attendance.halfDayMarkTime', 'HalfDay Mark Time', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1511, 0, 'en', 'modules', 'attendance.lateMark', 'Late mark after (minutes)', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1512, 1, 'en', 'modules', 'attendance.lateMark', 'Late mark after (minutes)', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1513, 0, 'en', 'modules', 'attendance.allowSelfClock', 'Allowed Employee self Clock-In/Clock-Out', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1514, 0, 'en', 'modules', 'attendance.markAttendance', 'Mark Attendance', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1515, 1, 'en', 'modules', 'attendance.markAttendance', 'Mark Attendance', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1516, 0, 'en', 'modules', 'attendance.clock_in', 'Clock In', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1517, 1, 'en', 'modules', 'attendance.clock_in', 'Clock In', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1518, 0, 'en', 'modules', 'attendance.clock_out', 'Clock Out', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1519, 1, 'en', 'modules', 'attendance.clock_out', 'Clock Out', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1520, 0, 'en', 'modules', 'attendance.working_from', 'Working From', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1521, 1, 'en', 'modules', 'attendance.working_from', 'Working From', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1522, 1, 'en', 'modules', 'attendance.working_from', 'Working From', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1523, 0, 'en', 'modules', 'attendance.officeOpenDays', 'Office opens on', '2019-10-27 21:24:52', '2019-10-27 21:24:52'),
(1524, 0, 'en', 'modules', 'attendance.daysPresent', 'Days Present', '2019-10-27 21:24:52', '2019-10-27 21:24:53'),
(1525, 1, 'en', 'modules', 'attendance.daysPresent', 'Days Present', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1526, 1, 'en', 'modules', 'attendance.daysPresent', 'Days Present', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1527, 0, 'en', 'modules', 'attendance.currentTime', 'Current Time', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1528, 1, 'en', 'modules', 'attendance.currentTime', 'Current Time', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1529, 1, 'en', 'modules', 'attendance.currentTime', 'Current Time', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1530, 1, 'en', 'modules', 'attendance.currentTime', 'Current Time', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1531, 0, 'en', 'modules', 'attendance.attendanceByDate', 'Attendance By Date', '2019-10-27 21:24:53', '2019-10-27 21:25:00'),
(1532, 1, 'en', 'modules', 'attendance.attendanceByDate', 'Attendance By Date', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1533, 1, 'en', 'modules', 'attendance.attendanceByDate', 'Attendance By Date', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1534, 1, 'en', 'modules', 'attendance.attendanceByDate', 'Attendance By Date', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1535, 1, 'en', 'modules', 'attendance.attendanceByDate', 'Attendance By Date', '2019-10-27 21:24:53', '2019-10-27 21:24:53'),
(1536, 0, 'en', 'modules', 'attendance.attendanceByMember', 'Attendance by Member', '2019-10-27 21:24:53', '2019-10-27 21:24:54'),
(1537, 1, 'en', 'modules', 'attendance.attendanceByMember', 'Attendance by Member', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1538, 0, 'en', 'modules', 'attendance.holiday', 'Holiday', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1539, 0, 'en', 'modules', 'attendance.checkininday', 'Maximum check-in allowed in a day?', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1540, 0, 'en', 'modules', 'attendance.maxColckIn', 'Maximum check-ins reached.', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1541, 0, 'en', 'modules', 'attendance.yes', 'Yes', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1542, 0, 'en', 'modules', 'attendance.no', 'No', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1543, 1, 'en', 'modules', 'attendance.no', 'No', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1544, 0, 'en', 'modules', 'attendance.leave', 'On Leave', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1545, 1, 'en', 'modules', 'attendance.leave', 'On Leave', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1546, 1, 'en', 'modules', 'attendance.leave', 'On Leave', '2019-10-27 21:24:54', '2019-10-27 21:24:54'),
(1547, 0, 'en', 'modules', 'attendance.checkForIp', 'Clock-in check with added IP address', '2019-10-27 21:24:54', '2019-10-27 21:24:55'),
(1548, 1, 'en', 'modules', 'attendance.checkForIp', 'Clock-in check with added IP address', '2019-10-27 21:24:55', '2019-10-27 21:24:55'),
(1549, 1, 'en', 'modules', 'attendance.checkForIp', 'Clock-in check with added IP address', '2019-10-27 21:24:55', '2019-10-27 21:24:55'),
(1550, 1, 'en', 'modules', 'attendance.checkForIp', 'Clock-in check with added IP address', '2019-10-27 21:24:55', '2019-10-27 21:24:55'),
(1551, 0, 'en', 'modules', 'attendance.checkForRadius', 'Clock-in check with added location Radius', '2019-10-27 21:24:55', '2019-10-27 21:25:00'),
(1552, 1, 'en', 'modules', 'attendance.checkForRadius', 'Clock-in check with added location Radius', '2019-10-27 21:24:55', '2019-10-27 21:24:55'),
(1553, 1, 'en', 'modules', 'attendance.checkForRadius', 'Clock-in check with added location Radius', '2019-10-27 21:24:55', '2019-10-27 21:24:55'),
(1554, 1, 'en', 'modules', 'attendance.checkForRadius', 'Clock-in check with added location Radius', '2019-10-27 21:24:55', '2019-10-27 21:24:55'),
(1555, 1, 'en', 'modules', 'attendance.checkForRadius', 'Clock-in check with added location Radius', '2019-10-27 21:24:55', '2019-10-27 21:24:55'),
(1556, 0, 'en', 'modules', 'attendance.radius', 'Radius (in meter)', '2019-10-27 21:24:55', '2019-10-27 21:24:55'),
(1557, 0, 'en', 'modules', 'customFields.label', 'Label', '2019-10-27 21:24:55', '2019-10-27 21:24:56'),
(1558, 0, 'en', 'modules', 'events.eventName', 'Event Name', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1559, 1, 'en', 'modules', 'events.eventName', 'Event Name', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1560, 1, 'en', 'modules', 'events.eventName', 'Event Name', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1561, 0, 'en', 'modules', 'events.startOn', 'Starts On', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1562, 1, 'en', 'modules', 'events.startOn', 'Starts On', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1563, 1, 'en', 'modules', 'events.startOn', 'Starts On', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1564, 0, 'en', 'modules', 'events.endOn', 'Ends On', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1565, 1, 'en', 'modules', 'events.endOn', 'Ends On', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1566, 1, 'en', 'modules', 'events.endOn', 'Ends On', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1567, 0, 'en', 'modules', 'events.addAttendees', 'Add Attendees', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1568, 1, 'en', 'modules', 'events.addAttendees', 'Add Attendees', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1569, 1, 'en', 'modules', 'events.addAttendees', 'Add Attendees', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1570, 0, 'en', 'modules', 'events.allEmployees', 'All Employees', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1571, 1, 'en', 'modules', 'events.allEmployees', 'All Employees', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1572, 1, 'en', 'modules', 'events.allEmployees', 'All Employees', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1573, 0, 'en', 'modules', 'events.where', 'Where', '2019-10-27 21:24:56', '2019-10-27 21:25:00'),
(1574, 1, 'en', 'modules', 'events.where', 'Where', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1575, 1, 'en', 'modules', 'events.where', 'Where', '2019-10-27 21:24:56', '2019-10-27 21:24:56'),
(1576, 1, 'en', 'modules', 'events.where', 'Where', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1577, 1, 'en', 'modules', 'events.where', 'Where', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1578, 0, 'en', 'modules', 'events.repeat', 'Repeat', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1579, 1, 'en', 'modules', 'events.repeat', 'Repeat', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1580, 0, 'en', 'modules', 'events.repeat', 'Repeat', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1581, 0, 'en', 'modules', 'events.repeatEvery', 'Repeat every', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1582, 0, 'en', 'modules', 'events.cycles', 'Cycles', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1583, 0, 'en', 'modules', 'events.cyclesToolTip', 'Recurring will be stopped after the number of cycles. Keep it blank for infinity.', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1584, 1, 'en', 'modules', 'events.cyclesToolTip', 'Recurring will be stopped after the number of cycles. Keep it blank for infinity.', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1585, 0, 'en', 'modules', 'payroll.addPayroll', 'Add Payroll', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1586, 1, 'en', 'modules', 'payroll.addPayroll', 'Add Payroll', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1587, 1, 'en', 'modules', 'payroll.addPayroll', 'Add Payroll', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1588, 0, 'en', 'modules', 'payroll.amountPaid', 'Amount Paid', '2019-10-27 21:24:57', '2019-10-27 21:24:58'),
(1589, 1, 'en', 'modules', 'payroll.amountPaid', 'Amount Paid', '2019-10-27 21:24:57', '2019-10-27 21:24:57'),
(1590, 0, 'en', 'modules', 'payroll.updatePayroll', 'Update Payroll', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1591, 1, 'en', 'modules', 'payroll.updatePayroll', 'Update Payroll', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1592, 1, 'en', 'modules', 'payroll.updatePayroll', 'Update Payroll', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1593, 0, 'en', 'modules', 'payroll.projectPayrollReport', 'Project Payroll Report', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1594, 1, 'en', 'modules', 'payroll.projectPayrollReport', 'Project Payroll Report', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1595, 1, 'en', 'modules', 'payroll.projectPayrollReport', 'Project Payroll Report', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1596, 1, 'en', 'modules', 'payroll.projectPayrollReport', 'Project Payroll Report', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1597, 0, 'en', 'modules', 'payroll.totalEarning', 'Total Earning', '2019-10-27 21:24:58', '2019-10-27 21:25:01'),
(1598, 1, 'en', 'modules', 'payroll.totalEarning', 'Total Earning', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1599, 1, 'en', 'modules', 'payroll.totalEarning', 'Total Earning', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1600, 1, 'en', 'modules', 'payroll.totalEarning', 'Total Earning', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1601, 1, 'en', 'modules', 'payroll.totalEarning', 'Total Earning', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1602, 0, 'en', 'modules', 'permission.selectAll', 'Select All', '2019-10-27 21:24:58', '2019-10-27 21:24:58'),
(1603, 0, 'en', 'modules', 'permission.addRoleMember', 'Manage Role Members', '2019-10-27 21:24:58', '2019-10-27 21:24:59'),
(1604, 0, 'en', 'modules', 'permission.addMembers', 'Add Members', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1605, 1, 'en', 'modules', 'permission.addMembers', 'Add Members', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1606, 1, 'en', 'modules', 'permission.addMembers', 'Add Members', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1607, 1, 'en', 'modules', 'permission.addMembers', 'Add Members', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1608, 0, 'en', 'modules', 'permission.roleName', 'Role Name', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1609, 1, 'en', 'modules', 'permission.roleName', 'Role Name', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1610, 1, 'en', 'modules', 'permission.roleName', 'Role Name', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1611, 1, 'en', 'modules', 'permission.roleName', 'Role Name', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1612, 0, 'en', 'modules', 'leaves.selectDuration', 'Select Duration', '2019-10-27 21:24:59', '2019-10-27 21:25:00'),
(1613, 1, 'en', 'modules', 'leaves.selectDuration', 'Select Duration', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1614, 1, 'en', 'modules', 'leaves.selectDuration', 'Select Duration', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1615, 1, 'en', 'modules', 'leaves.selectDuration', 'Select Duration', '2019-10-27 21:24:59', '2019-10-27 21:24:59'),
(1616, 0, 'en', 'modules', 'leaves.single', 'Single', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1617, 0, 'en', 'modules', 'leaves.multiple', 'Multiple', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1618, 0, 'en', 'modules', 'leaves.halfDay', 'Half Day', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1619, 1, 'en', 'modules', 'leaves.halfDay', 'Half Day', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1620, 0, 'en', 'modules', 'leaves.hours', 'Hours', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1621, 1, 'en', 'modules', 'leaves.hours', 'Hours', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1622, 0, 'en', 'modules', 'leaves.selectDates', 'Select Dates', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1623, 1, 'en', 'modules', 'leaves.selectDates', 'Select Dates', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1624, 0, 'en', 'modules', 'leaves.applicantName', 'Applicant Name', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1625, 1, 'en', 'modules', 'leaves.applicantName', 'Applicant Name', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1626, 0, 'en', 'modules', 'leaves.updateLeave', 'Update Leave', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1627, 1, 'en', 'modules', 'leaves.updateLeave', 'Update Leave', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1628, 0, 'en', 'modules', 'leaves.pendingLeaves', 'Pending Leaves', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1629, 1, 'en', 'modules', 'leaves.pendingLeaves', 'Pending Leaves', '2019-10-27 21:25:00', '2019-10-27 21:25:00'),
(1630, 0, 'en', 'modules', 'leaves.noOfLeaves', 'No of Leaves', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1631, 1, 'en', 'modules', 'leaves.noOfLeaves', 'No of Leaves', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1632, 0, 'en', 'modules', 'leaves.countLeavesFromDateOfJoining', 'Count leaves from the date of joining', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1633, 1, 'en', 'modules', 'leaves.countLeavesFromDateOfJoining', 'Count leaves from the date of joining', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1634, 1, 'en', 'modules', 'leaves.countLeavesFromDateOfJoining', 'Count leaves from the date of joining', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1635, 0, 'en', 'modules', 'leaves.countLeavesFromStartOfYear', 'Count leaves from the start of the year', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1636, 1, 'en', 'modules', 'leaves.countLeavesFromStartOfYear', 'Count leaves from the start of the year', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1637, 1, 'en', 'modules', 'leaves.countLeavesFromStartOfYear', 'Count leaves from the start of the year', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1638, 1, 'en', 'modules', 'leaves.countLeavesFromStartOfYear', 'Count leaves from the start of the year', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1639, 1, 'en', 'modules', 'leaves.countLeavesFromStartOfYear', 'Count leaves from the start of the year', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1640, 0, 'en', 'modules', 'leaves.leavesTaken', 'Leaves Taken', '2019-10-27 21:25:01', '2019-10-27 21:25:36'),
(1641, 1, 'en', 'modules', 'leaves.leavesTaken', 'Leaves Taken', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1642, 1, 'en', 'modules', 'leaves.leavesTaken', 'Leaves Taken', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1643, 1, 'en', 'modules', 'leaves.leavesTaken', 'Leaves Taken', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1644, 1, 'en', 'modules', 'leaves.leavesTaken', 'Leaves Taken', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1645, 1, 'en', 'modules', 'leaves.leavesTaken', 'Leaves Taken', '2019-10-27 21:25:01', '2019-10-27 21:25:01'),
(1646, 0, 'en', 'modules', 'leaves.myLeaves', 'My Leaves', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1647, 0, 'en', 'modules', 'low', 'Low', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1648, 0, 'en', 'modules', 'lead.companyDetails', 'Company Details', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1649, 1, 'en', 'modules', 'lead.companyDetails', 'Company Details', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1650, 1, 'en', 'modules', 'lead.companyDetails', 'Company Details', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1651, 1, 'en', 'modules', 'lead.companyDetails', 'Company Details', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1652, 0, 'en', 'modules', 'lead.companyName', 'Company Name', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1653, 1, 'en', 'modules', 'lead.companyName', 'Company Name', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1654, 0, 'en', 'modules', 'lead.website', 'Website', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1655, 1, 'en', 'modules', 'lead.website', 'Website', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1656, 0, 'en', 'modules', 'lead.address', 'Address', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1657, 1, 'en', 'modules', 'lead.address', 'Address', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1658, 1, 'en', 'modules', 'lead.address', 'Address', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1659, 0, 'en', 'modules', 'lead.leadDetails', 'Lead Details', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1660, 0, 'en', 'modules', 'lead.clientName', 'Client Name', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1661, 1, 'en', 'modules', 'lead.clientName', 'Client Name', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1662, 1, 'en', 'modules', 'lead.clientName', 'Client Name', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1663, 0, 'en', 'modules', 'lead.clientEmail', 'Client Email', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1664, 0, 'en', 'modules', 'lead.emailNote', 'Lead will login using this email.', '2019-10-27 21:25:02', '2019-10-27 21:25:03'),
(1665, 1, 'en', 'modules', 'lead.emailNote', 'Lead will login using this email.', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1666, 1, 'en', 'modules', 'lead.emailNote', 'Lead will login using this email.', '2019-10-27 21:25:02', '2019-10-27 21:25:02'),
(1667, 0, 'en', 'modules', 'lead.password', 'Password', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1668, 1, 'en', 'modules', 'lead.password', 'Password', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1669, 1, 'en', 'modules', 'lead.password', 'Password', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1670, 1, 'en', 'modules', 'lead.password', 'Password', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1671, 0, 'en', 'modules', 'lead.passwordNote', 'Client will login using this password.', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1672, 0, 'en', 'modules', 'lead.passwordUpdateNote', 'Client will login using this password. (Leave blank to keep current password)', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1673, 1, 'en', 'modules', 'lead.passwordUpdateNote', 'Client will login using this password. (Leave blank to keep current password)', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1674, 1, 'en', 'modules', 'lead.passwordUpdateNote', 'Client will login using this password. (Leave blank to keep current password)', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1675, 0, 'en', 'modules', 'lead.mobile', 'Mobile', '2019-10-27 21:25:03', '2019-10-27 21:25:37'),
(1676, 1, 'en', 'modules', 'lead.mobile', 'Mobile', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1677, 1, 'en', 'modules', 'lead.mobile', 'Mobile', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1678, 1, 'en', 'modules', 'lead.mobile', 'Mobile', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1679, 1, 'en', 'modules', 'lead.mobile', 'Mobile', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1680, 1, 'en', 'modules', 'lead.mobile', 'Mobile', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1681, 0, 'en', 'modules', 'lead.addNewLead', 'Add New Lead', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1682, 1, 'en', 'modules', 'lead.addNewLead', 'Add New Lead', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1683, 1, 'en', 'modules', 'lead.addNewLead', 'Add New Lead', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1684, 1, 'en', 'modules', 'lead.addNewLead', 'Add New Lead', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1685, 1, 'en', 'modules', 'lead.addNewLead', 'Add New Lead', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1686, 0, 'en', 'modules', 'lead.viewDetails', 'View Details', '2019-10-27 21:25:03', '2019-10-27 21:25:03'),
(1687, 0, 'en', 'modules', 'lead.remark', 'Remark', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1688, 0, 'en', 'modules', 'lead.proposal', 'Proposal', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1689, 1, 'en', 'modules', 'lead.proposal', 'Proposal', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1690, 0, 'en', 'modules', 'lead.profile', 'Profile', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1691, 1, 'en', 'modules', 'lead.profile', 'Profile', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1692, 0, 'en', 'modules', 'lead.followUp', 'Follow Up', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1693, 0, 'en', 'modules', 'lead.note', 'Note', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1694, 0, 'en', 'modules', 'lead.email', 'Email', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1695, 0, 'en', 'modules', 'lead.source', 'Source', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1696, 0, 'en', 'modules', 'lead.status', 'Status', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1697, 0, 'en', 'modules', 'lead.leadDetail', 'Lead Detail', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1698, 1, 'en', 'modules', 'lead.leadDetail', 'Lead Detail', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1699, 1, 'en', 'modules', 'lead.leadDetail', 'Lead Detail', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1700, 0, 'en', 'modules', 'lead.nextFollowUp', 'Next Follow Up', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1701, 1, 'en', 'modules', 'lead.nextFollowUp', 'Next Follow Up', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1702, 0, 'en', 'modules', 'lead.all', 'All', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1703, 0, 'en', 'modules', 'lead.lead', 'Lead', '2019-10-27 21:25:04', '2019-10-27 21:25:37'),
(1704, 1, 'en', 'modules', 'lead.lead', 'Lead', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1705, 1, 'en', 'modules', 'lead.lead', 'Lead', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1706, 1, 'en', 'modules', 'lead.lead', 'Lead', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1707, 1, 'en', 'modules', 'lead.lead', 'Lead', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1708, 0, 'en', 'modules', 'lead.client', 'Client', '2019-10-27 21:25:04', '2019-10-27 21:25:05'),
(1709, 1, 'en', 'modules', 'lead.lead', 'Lead', '2019-10-27 21:25:04', '2019-10-27 21:25:04'),
(1710, 0, 'en', 'modules', 'lead.pending', 'Pending', '2019-10-27 21:25:05', '2019-10-27 21:25:05'),
(1711, 0, 'en', 'modules', 'lead.file', 'Files', '2019-10-27 21:25:05', '2019-10-27 21:25:05'),
(1712, 1, 'en', 'modules', 'lead.file', 'Files', '2019-10-27 21:25:05', '2019-10-27 21:25:05'),
(1713, 0, 'en', 'modules', 'proposal.updateTitle', 'Update Proposal Info', '2019-10-27 21:25:05', '2019-10-27 21:25:05'),
(1714, 0, 'en', 'modules', 'proposal.addNewLead', 'Add New Proposal', '2019-10-27 21:25:05', '2019-10-27 21:25:05'),
(1715, 1, 'en', 'modules', 'proposal.addNewLead', 'Add New Proposal', '2019-10-27 21:25:05', '2019-10-27 21:25:05'),
(1716, 0, 'en', 'modules', 'proposal.viewDetails', 'View Details', '2019-10-27 21:25:05', '2019-10-27 21:25:37'),
(1717, 1, 'en', 'modules', 'proposal.viewDetails', 'View Details', '2019-10-27 21:25:05', '2019-10-27 21:25:05'),
(1718, 1, 'en', 'modules', 'proposal.viewDetails', 'View Details', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1719, 1, 'en', 'modules', 'proposal.viewDetails', 'View Details', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1720, 1, 'en', 'modules', 'proposal.viewDetails', 'View Details', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1721, 1, 'en', 'modules', 'proposal.viewDetails', 'View Details', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1722, 0, 'en', 'modules', 'proposal.title', ' Lead Proposal', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1723, 0, 'en', 'modules', 'proposal.proposal', ' Lead Proposal', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1724, 1, 'en', 'modules', 'proposal.proposal', ' Lead Proposal', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1725, 1, 'en', 'modules', 'proposal.proposal', ' Lead Proposal', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1726, 1, 'en', 'modules', 'proposal.proposal', ' Lead Proposal', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1727, 0, 'en', 'modules', 'proposal.createProposal', 'Create Proposal', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1728, 0, 'en', 'modules', 'proposal.validTill', 'Valid Till', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1729, 1, 'en', 'modules', 'proposal.validTill', 'Valid Till', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1730, 0, 'en', 'modules', 'proposal.waiting', 'Waiting', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1731, 1, 'en', 'modules', 'proposal.waiting', 'Waiting', '2019-10-27 21:25:06', '2019-10-27 21:25:06');
INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1732, 1, 'en', 'modules', 'proposal.waiting', 'Waiting', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1733, 0, 'en', 'modules', 'proposal.accepted', 'Accepted', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1734, 0, 'en', 'modules', 'proposal.declined', 'Declined', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1735, 1, 'en', 'modules', 'proposal.declined', 'Declined', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1736, 1, 'en', 'modules', 'proposal.declined', 'Declined', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1737, 1, 'en', 'modules', 'proposal.declined', 'Declined', '2019-10-27 21:25:06', '2019-10-27 21:25:06'),
(1738, 0, 'en', 'modules', 'proposal.view', 'View', '2019-10-27 21:25:07', '2019-10-27 21:25:07'),
(1739, 1, 'en', 'modules', 'proposal.view', 'View', '2019-10-27 21:25:07', '2019-10-27 21:25:07'),
(1740, 1, 'en', 'modules', 'proposal.view', 'View', '2019-10-27 21:25:07', '2019-10-27 21:25:07'),
(1741, 0, 'en', 'modules', 'followup.addNewLead', 'Add New Proposal', '2019-10-27 21:25:07', '2019-10-27 21:25:07'),
(1742, 1, 'en', 'modules', 'followup.addNewLead', 'Add New Proposal', '2019-10-27 21:25:07', '2019-10-27 21:25:07'),
(1743, 0, 'en', 'modules', 'followup.viewDetails', 'View Details', '2019-10-27 21:25:07', '2019-10-27 21:25:08'),
(1744, 1, 'en', 'modules', 'followup.viewDetails', 'View Details', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1745, 0, 'en', 'modules', 'followup.title', ' Lead Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1746, 0, 'en', 'modules', 'followup.proposal', ' Lead Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:37'),
(1747, 1, 'en', 'modules', 'followup.proposal', ' Lead Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1748, 1, 'en', 'modules', 'followup.proposal', ' Lead Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1749, 1, 'en', 'modules', 'followup.proposal', ' Lead Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1750, 1, 'en', 'modules', 'followup.proposal', ' Lead Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1751, 1, 'en', 'modules', 'followup.proposal', ' Lead Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1752, 0, 'en', 'modules', 'followup.createProposal', 'Create Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:38'),
(1753, 1, 'en', 'modules', 'followup.createProposal', 'Create Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1754, 1, 'en', 'modules', 'followup.createProposal', 'Create Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1755, 1, 'en', 'modules', 'followup.createProposal', 'Create Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1756, 1, 'en', 'modules', 'followup.createProposal', 'Create Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1757, 1, 'en', 'modules', 'followup.createProposal', 'Create Proposal', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1758, 0, 'en', 'modules', 'followup.validTill', 'Valid Till', '2019-10-27 21:25:08', '2019-10-27 21:25:09'),
(1759, 1, 'en', 'modules', 'followup.validTill', 'Valid Till', '2019-10-27 21:25:08', '2019-10-27 21:25:08'),
(1760, 0, 'en', 'modules', 'followup.waiting', 'Waiting', '2019-10-27 21:25:08', '2019-10-27 21:25:09'),
(1761, 1, 'en', 'modules', 'followup.waiting', 'Waiting', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1762, 1, 'en', 'modules', 'followup.waiting', 'Waiting', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1763, 1, 'en', 'modules', 'followup.waiting', 'Waiting', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1764, 0, 'en', 'modules', 'followup.accepted', 'Accepted', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1765, 1, 'en', 'modules', 'followup.accepted', 'Accepted', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1766, 1, 'en', 'modules', 'followup.accepted', 'Accepted', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1767, 0, 'en', 'modules', 'followup.declined', 'Declined', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1768, 1, 'en', 'modules', 'followup.declined', 'Declined', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1769, 1, 'en', 'modules', 'followup.declined', 'Declined', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1770, 1, 'en', 'modules', 'followup.declined', 'Declined', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1771, 0, 'en', 'modules', 'followup.updateProposal', 'Update Proposal', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1772, 1, 'en', 'modules', 'followup.updateProposal', 'Update Proposal', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1773, 0, 'en', 'modules', 'followup.convertProposalTitle', 'Convert Proposal To Invoice', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1774, 1, 'en', 'modules', 'followup.convertProposalTitle', 'Convert Proposal To Invoice', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1775, 0, 'en', 'modules', 'followup.followUpNotFound', 'No follow up found', '2019-10-27 21:25:09', '2019-10-27 21:25:10'),
(1776, 1, 'en', 'modules', 'followup.followUpNotFound', 'No follow up found', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1777, 1, 'en', 'modules', 'followup.followUpNotFound', 'No follow up found', '2019-10-27 21:25:09', '2019-10-27 21:25:09'),
(1778, 0, 'en', 'modules', 'holiday.addNewHoliday', 'Add Holiday', '2019-10-27 21:25:10', '2019-10-27 21:25:10'),
(1779, 0, 'en', 'modules', 'holiday.viewDetails', 'View Details', '2019-10-27 21:25:10', '2019-10-27 21:25:10'),
(1780, 1, 'en', 'modules', 'holiday.viewDetails', 'View Details', '2019-10-27 21:25:10', '2019-10-27 21:25:10'),
(1781, 0, 'en', 'modules', 'holiday.createHoliday', 'Create Holiday', '2019-10-27 21:25:10', '2019-10-27 21:25:10'),
(1782, 0, 'en', 'modules', 'holiday.followUpNotFound', 'No Holiday found', '2019-10-27 21:25:10', '2019-10-27 21:25:10'),
(1783, 1, 'en', 'modules', 'holiday.followUpNotFound', 'No Holiday found', '2019-10-27 21:25:10', '2019-10-27 21:25:10'),
(1784, 0, 'en', 'modules', 'holiday.viewOnCalendar', 'View on Calendar', '2019-10-27 21:25:11', '2019-10-27 21:25:38'),
(1785, 1, 'en', 'modules', 'holiday.viewOnCalendar', 'View on Calendar', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1786, 1, 'en', 'modules', 'holiday.viewOnCalendar', 'View on Calendar', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1787, 1, 'en', 'modules', 'holiday.viewOnCalendar', 'View on Calendar', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1788, 1, 'en', 'modules', 'holiday.viewOnCalendar', 'View on Calendar', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1789, 1, 'en', 'modules', 'holiday.viewOnCalendar', 'View on Calendar', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1790, 0, 'en', 'modules', 'holiday.officeHolidayMarkDays', 'Mark day for Holiday', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1791, 1, 'en', 'modules', 'holiday.officeHolidayMarkDays', 'Mark day for Holiday', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1792, 1, 'en', 'modules', 'holiday.officeHolidayMarkDays', 'Mark day for Holiday', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1793, 0, 'en', 'modules', 'offlinePayment.method', 'Method', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1794, 1, 'en', 'modules', 'offlinePayment.method', 'Method', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1795, 1, 'en', 'modules', 'offlinePayment.method', 'Method', '2019-10-27 21:25:11', '2019-10-27 21:25:11'),
(1796, 0, 'en', 'modules', 'offlinePayment.description', 'Description', '2019-10-27 21:25:11', '2019-10-27 21:25:12'),
(1797, 1, 'en', 'modules', 'offlinePayment.description', 'Description', '2019-10-27 21:25:12', '2019-10-27 21:25:12'),
(1798, 0, 'en', 'modules', 'offlinePayment.addMethod', 'Add Method', '2019-10-27 21:25:12', '2019-10-27 21:25:12'),
(1799, 0, 'en', 'modules', 'offlinePayment.active', 'Active', '2019-10-27 21:25:12', '2019-10-27 21:25:12'),
(1800, 1, 'en', 'modules', 'offlinePayment.active', 'Active', '2019-10-27 21:25:12', '2019-10-27 21:25:12'),
(1801, 1, 'en', 'modules', 'offlinePayment.active', 'Active', '2019-10-27 21:25:12', '2019-10-27 21:25:12'),
(1802, 0, 'en', 'modules', 'offlinePayment.inActive', 'Inactive', '2019-10-27 21:25:12', '2019-10-27 21:25:12'),
(1803, 0, 'en', 'modules', 'projectTemplate.addNewTemplate', 'Add New Template', '2019-10-27 21:25:12', '2019-10-27 21:25:13'),
(1804, 1, 'en', 'modules', 'projectTemplate.addNewTemplate', 'Add New Template', '2019-10-27 21:25:12', '2019-10-27 21:25:12'),
(1805, 1, 'en', 'modules', 'projectTemplate.addNewTemplate', 'Add New Template', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1806, 1, 'en', 'modules', 'projectTemplate.addNewTemplate', 'Add New Template', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1807, 0, 'en', 'modules', 'projectTemplate.projectName', 'Template Name', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1808, 1, 'en', 'modules', 'projectTemplate.projectName', 'Template Name', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1809, 0, 'en', 'modules', 'projectTemplate.projectMembers', 'Template Members', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1810, 0, 'en', 'modules', 'projectTemplate.selectClient', 'Select Client', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1811, 1, 'en', 'modules', 'projectTemplate.selectClient', 'Select Client', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1812, 1, 'en', 'modules', 'projectTemplate.selectClient', 'Select Client', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1813, 1, 'en', 'modules', 'projectTemplate.selectClient', 'Select Client', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1814, 0, 'en', 'modules', 'projectTemplate.startDate', 'Start Date', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1815, 1, 'en', 'modules', 'projectTemplate.startDate', 'Start Date', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1816, 1, 'en', 'modules', 'projectTemplate.startDate', 'Start Date', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1817, 1, 'en', 'modules', 'projectTemplate.startDate', 'Start Date', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1818, 0, 'en', 'modules', 'projectTemplate.deadline', 'Deadline', '2019-10-27 21:25:13', '2019-10-27 21:25:38'),
(1819, 1, 'en', 'modules', 'projectTemplate.deadline', 'Deadline', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1820, 1, 'en', 'modules', 'projectTemplate.deadline', 'Deadline', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1821, 1, 'en', 'modules', 'projectTemplate.deadline', 'Deadline', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1822, 1, 'en', 'modules', 'projectTemplate.deadline', 'Deadline', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1823, 1, 'en', 'modules', 'projectTemplate.deadline', 'Deadline', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1824, 0, 'en', 'modules', 'projectTemplate.projectSummary', 'Template Summary', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1825, 0, 'en', 'modules', 'projectTemplate.note', 'Note', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1826, 1, 'en', 'modules', 'projectTemplate.note', 'Note', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1827, 1, 'en', 'modules', 'projectTemplate.note', 'Note', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1828, 0, 'en', 'modules', 'projectTemplate.projectCategory', 'Template Category', '2019-10-27 21:25:13', '2019-10-27 21:25:13'),
(1829, 0, 'en', 'modules', 'projectTemplate.clientFeedback', 'Client Feedback', '2019-10-27 21:25:13', '2019-10-27 21:25:14'),
(1830, 0, 'en', 'modules', 'projectTemplate.projectCompletionStatus', 'Template Completion Status', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1831, 0, 'en', 'modules', 'projectTemplate.overview', 'Overview', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1832, 1, 'en', 'modules', 'projectTemplate.overview', 'Overview', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1833, 1, 'en', 'modules', 'projectTemplate.overview', 'Overview', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1834, 1, 'en', 'modules', 'projectTemplate.overview', 'Overview', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1835, 0, 'en', 'modules', 'projectTemplate.members', 'Members', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1836, 0, 'en', 'modules', 'projectTemplate.files', 'Files', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1837, 1, 'en', 'modules', 'projectTemplate.files', 'Files', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1838, 1, 'en', 'modules', 'projectTemplate.files', 'Files', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1839, 1, 'en', 'modules', 'projectTemplate.files', 'Files', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1840, 0, 'en', 'modules', 'projectTemplate.activeTimers', 'Active Timers', '2019-10-27 21:25:14', '2019-10-27 21:25:15'),
(1841, 1, 'en', 'modules', 'projectTemplate.activeTimers', 'Active Timers', '2019-10-27 21:25:14', '2019-10-27 21:25:14'),
(1842, 0, 'en', 'modules', 'projectTemplate.whoWorking', 'Who\'s Working', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1843, 0, 'en', 'modules', 'projectTemplate.activeSince', 'Active Since', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1844, 0, 'en', 'modules', 'projectTemplate.openTasks', 'Open Tasks', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1845, 1, 'en', 'modules', 'projectTemplate.openTasks', 'Open Tasks', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1846, 1, 'en', 'modules', 'projectTemplate.openTasks', 'Open Tasks', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1847, 1, 'en', 'modules', 'projectTemplate.openTasks', 'Open Tasks', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1848, 0, 'en', 'modules', 'projectTemplate.daysLeft', 'Days Left', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1849, 1, 'en', 'modules', 'projectTemplate.daysLeft', 'Days Left', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1850, 0, 'en', 'modules', 'projectTemplate.hoursLogged', 'Hours Logged', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1851, 0, 'en', 'modules', 'projectTemplate.issuesPending', 'Issues Pending', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1852, 0, 'en', 'modules', 'projectTemplate.activityTimeline', 'Activity Timeline', '2019-10-27 21:25:15', '2019-10-27 21:25:38'),
(1853, 1, 'en', 'modules', 'projectTemplate.activityTimeline', 'Activity Timeline', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1854, 1, 'en', 'modules', 'projectTemplate.activityTimeline', 'Activity Timeline', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1855, 1, 'en', 'modules', 'projectTemplate.activityTimeline', 'Activity Timeline', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1856, 1, 'en', 'modules', 'projectTemplate.activityTimeline', 'Activity Timeline', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1857, 1, 'en', 'modules', 'projectTemplate.activityTimeline', 'Activity Timeline', '2019-10-27 21:25:15', '2019-10-27 21:25:15'),
(1858, 0, 'en', 'modules', 'projectTemplate.uploadFile', 'Upload File', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1859, 1, 'en', 'modules', 'projectTemplate.uploadFile', 'Upload File', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1860, 0, 'en', 'modules', 'projectTemplate.dropFile', 'Drop files here OR click to upload', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1861, 1, 'en', 'modules', 'projectTemplate.dropFile', 'Drop files here OR click to upload', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1862, 1, 'en', 'modules', 'projectTemplate.dropFile', 'Drop files here OR click to upload', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1863, 1, 'en', 'modules', 'projectTemplate.dropFile', 'Drop files here OR click to upload', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1864, 0, 'en', 'modules', 'projectTemplate.noOpenTasks', 'No open tasks.', '2019-10-27 21:25:16', '2019-10-27 21:25:39'),
(1865, 1, 'en', 'modules', 'projectTemplate.noOpenTasks', 'No open tasks.', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1866, 1, 'en', 'modules', 'projectTemplate.noOpenTasks', 'No open tasks.', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1867, 1, 'en', 'modules', 'projectTemplate.noOpenTasks', 'No open tasks.', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1868, 1, 'en', 'modules', 'projectTemplate.noOpenTasks', 'No open tasks.', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1869, 1, 'en', 'modules', 'projectTemplate.noOpenTasks', 'No open tasks.', '2019-10-27 21:25:16', '2019-10-27 21:25:16'),
(1870, 0, 'en', 'modules', 'projectTemplate.calculateTasksProgress', 'Calculate progress through tasks', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1871, 1, 'en', 'modules', 'projectTemplate.calculateTasksProgress', 'Calculate progress through tasks', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1872, 1, 'en', 'modules', 'projectTemplate.calculateTasksProgress', 'Calculate progress through tasks', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1873, 0, 'en', 'modules', 'projectTemplate.viewGanttChart', 'Gantt Chart', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1874, 1, 'en', 'modules', 'projectTemplate.viewGanttChart', 'Gantt Chart', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1875, 0, 'en', 'modules', 'projectTemplate.clientViewTask', 'Client can view tasks of this project', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1876, 1, 'en', 'modules', 'projectTemplate.clientViewTask', 'Client can view tasks of this project', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1877, 0, 'en', 'modules', 'projectTemplate.clientTaskNotification', 'Send task notification to client?', '2019-10-27 21:25:17', '2019-10-27 21:25:39'),
(1878, 1, 'en', 'modules', 'projectTemplate.clientTaskNotification', 'Send task notification to client?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1879, 1, 'en', 'modules', 'projectTemplate.clientTaskNotification', 'Send task notification to client?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1880, 1, 'en', 'modules', 'projectTemplate.clientTaskNotification', 'Send task notification to client?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1881, 1, 'en', 'modules', 'projectTemplate.clientTaskNotification', 'Send task notification to client?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1882, 0, 'en', 'modules', 'projectTemplate.manualTimelog', 'Allow manual time logs?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1883, 1, 'en', 'modules', 'projectTemplate.manualTimelog', 'Allow manual time logs?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1884, 1, 'en', 'modules', 'projectTemplate.clientTaskNotification', 'Send task notification to client?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1885, 1, 'en', 'modules', 'projectTemplate.manualTimelog', 'Allow manual time logs?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1886, 1, 'en', 'modules', 'projectTemplate.manualTimelog', 'Allow manual time logs?', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1887, 0, 'en', 'modules', 'templateTasks.lastCreated', 'Last Created', '2019-10-27 21:25:17', '2019-10-27 21:25:18'),
(1888, 1, 'en', 'modules', 'templateTasks.lastCreated', 'Last Created', '2019-10-27 21:25:17', '2019-10-27 21:25:17'),
(1889, 0, 'en', 'modules', 'templateTasks.dueSoon', 'Due Soon', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1890, 1, 'en', 'modules', 'templateTasks.dueSoon', 'Due Soon', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1891, 1, 'en', 'modules', 'templateTasks.dueSoon', 'Due Soon', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1892, 0, 'en', 'modules', 'templateTasks.assignTo', 'Assigned To', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1893, 0, 'en', 'modules', 'templateTasks.priority', 'Priority', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1894, 1, 'en', 'modules', 'templateTasks.priority', 'Priority', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1895, 0, 'en', 'modules', 'templateTasks.chooseAssignee', 'Choose Assignee', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1896, 1, 'en', 'modules', 'templateTasks.chooseAssignee', 'Choose Assignee', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1897, 1, 'en', 'modules', 'templateTasks.chooseAssignee', 'Choose Assignee', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1898, 0, 'en', 'modules', 'templateTasks.taskDetail', 'Template Task Detail', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1899, 0, 'en', 'modules', 'templateTasks.taskBoard', 'Template Task Board', '2019-10-27 21:25:18', '2019-10-27 21:25:18'),
(1900, 0, 'en', 'modules', 'templateTasks.addBoardColumn', 'Add Column', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1901, 1, 'en', 'modules', 'templateTasks.addBoardColumn', 'Add Column', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1902, 1, 'en', 'modules', 'templateTasks.addBoardColumn', 'Add Column', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1903, 0, 'en', 'modules', 'templateTasks.columnName', 'Column Name', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1904, 1, 'en', 'modules', 'templateTasks.columnName', 'Column Name', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1905, 0, 'en', 'modules', 'templateTasks.labelColor', 'Label Color', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1906, 1, 'en', 'modules', 'templateTasks.labelColor', 'Label Color', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1907, 1, 'en', 'modules', 'templateTasks.labelColor', 'Label Color', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1908, 1, 'en', 'modules', 'templateTasks.labelColor', 'Label Color', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1909, 0, 'en', 'modules', 'templateTasks.tasksTable', 'Tasks Table', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1910, 0, 'en', 'modules', 'templateTasks.position', 'Position', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1911, 0, 'en', 'modules', 'templateTasks.subTask', 'Sub Template Task', '2019-10-27 21:25:19', '2019-10-27 21:25:39'),
(1912, 1, 'en', 'modules', 'templateTasks.subTask', 'Sub Template Task', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1913, 1, 'en', 'modules', 'templateTasks.subTask', 'Sub Template Task', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1914, 1, 'en', 'modules', 'templateTasks.subTask', 'Sub Template Task', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1915, 1, 'en', 'modules', 'templateTasks.subTask', 'Sub Template Task', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1916, 1, 'en', 'modules', 'templateTasks.subTask', 'Sub Template Task', '2019-10-27 21:25:19', '2019-10-27 21:25:19'),
(1917, 0, 'en', 'modules', 'templateTasks.comment', 'Comment', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1918, 1, 'en', 'modules', 'templateTasks.comment', 'Comment', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1919, 1, 'en', 'modules', 'templateTasks.comment', 'Comment', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1920, 1, 'en', 'modules', 'templateTasks.comment', 'Comment', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1921, 1, 'en', 'modules', 'templateTasks.comment', 'Comment', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1922, 0, 'en', 'modules', 'logTimeSetting.title', 'Log Time Setting', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1923, 1, 'en', 'modules', 'logTimeSetting.title', 'Log Time Setting', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1924, 1, 'en', 'modules', 'logTimeSetting.title', 'Log Time Setting', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1925, 0, 'en', 'modules', 'logTimeSetting.project', 'Project', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1926, 1, 'en', 'modules', 'logTimeSetting.project', 'Project', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1927, 1, 'en', 'modules', 'logTimeSetting.project', 'Project', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1928, 0, 'en', 'modules', 'logTimeSetting.task', 'Task', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1929, 1, 'en', 'modules', 'logTimeSetting.task', 'Task', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1930, 1, 'en', 'modules', 'logTimeSetting.task', 'Task', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1931, 0, 'en', 'modules', 'logTimeSetting.autoStopTimerAfterOfficeTime', 'Stop timer automatically after office time.', '2019-10-27 21:25:20', '2019-10-27 21:25:39'),
(1932, 1, 'en', 'modules', 'logTimeSetting.autoStopTimerAfterOfficeTime', 'Stop timer automatically after office time.', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1933, 1, 'en', 'modules', 'logTimeSetting.autoStopTimerAfterOfficeTime', 'Stop timer automatically after office time.', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1934, 1, 'en', 'modules', 'logTimeSetting.autoStopTimerAfterOfficeTime', 'Stop timer automatically after office time.', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1935, 1, 'en', 'modules', 'logTimeSetting.autoStopTimerAfterOfficeTime', 'Stop timer automatically after office time.', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1936, 1, 'en', 'modules', 'logTimeSetting.autoStopTimerAfterOfficeTime', 'Stop timer automatically after office time.', '2019-10-27 21:25:20', '2019-10-27 21:25:20'),
(1937, 0, 'en', 'modules', 'taskCategory.categoryName', 'Category Name', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1938, 1, 'en', 'modules', 'taskCategory.categoryName', 'Category Name', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1939, 1, 'en', 'modules', 'taskCategory.categoryName', 'Category Name', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1940, 1, 'en', 'modules', 'taskCategory.categoryName', 'Category Name', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1941, 1, 'en', 'modules', 'taskCategory.categoryName', 'Category Name', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1942, 0, 'en', 'modules', 'taskCategory.taskCategory', 'Task Category', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1943, 0, 'en', 'modules', 'pushSettings.updateTitle', 'Update Push Notification Settings', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1944, 1, 'en', 'modules', 'pushSettings.updateTitle', 'Update Push Notification Settings', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1945, 0, 'en', 'modules', 'pushSettings.oneSignalAppId', 'One Signal App ID', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1946, 0, 'en', 'modules', 'pushSettings.oneSignalRestApiKey', 'One Signal Rest API Key', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1947, 1, 'en', 'modules', 'pushSettings.oneSignalRestApiKey', 'One Signal Rest API Key', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1948, 1, 'en', 'modules', 'pushSettings.oneSignalRestApiKey', 'One Signal Rest API Key', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1949, 0, 'en', 'modules', 'stripeSettings.title', 'Stripe Settings', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1950, 1, 'en', 'modules', 'stripeSettings.title', 'Stripe Settings', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1951, 1, 'en', 'modules', 'stripeSettings.title', 'Stripe Settings', '2019-10-27 21:25:21', '2019-10-27 21:25:21'),
(1952, 0, 'en', 'modules', 'stripeSettings.apiKey', 'Api Key', '2019-10-27 21:25:21', '2019-10-27 21:25:22'),
(1953, 0, 'en', 'modules', 'stripeSettings.apiSecret', 'Api Secret', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1954, 0, 'en', 'modules', 'stripeSettings.webhookKey', 'Webhook Key Secret', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1955, 1, 'en', 'modules', 'stripeSettings.webhookKey', 'Webhook Key Secret', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1956, 1, 'en', 'modules', 'stripeSettings.webhookKey', 'Webhook Key Secret', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1957, 0, 'en', 'modules', 'stripeSettings.subtitle', 'Stripe credentials', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1958, 1, 'en', 'modules', 'stripeSettings.subtitle', 'Stripe credentials', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1959, 0, 'en', 'modules', 'frontCms.updateTitle', 'Update Front Detail', '2019-10-27 21:25:22', '2019-10-27 21:25:39'),
(1960, 1, 'en', 'modules', 'frontCms.updateTitle', 'Update Front Detail', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1961, 1, 'en', 'modules', 'frontCms.updateTitle', 'Update Front Detail', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1962, 1, 'en', 'modules', 'frontCms.updateTitle', 'Update Front Detail', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1963, 1, 'en', 'modules', 'frontCms.updateTitle', 'Update Front Detail', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1964, 1, 'en', 'modules', 'frontCms.updateTitle', 'Update Front Detail', '2019-10-27 21:25:22', '2019-10-27 21:25:22'),
(1965, 0, 'en', 'modules', 'frontCms.headerTitle', 'Header Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1966, 1, 'en', 'modules', 'frontCms.headerTitle', 'Header Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1967, 1, 'en', 'modules', 'frontCms.headerTitle', 'Header Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1968, 1, 'en', 'modules', 'frontCms.headerTitle', 'Header Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1969, 0, 'en', 'modules', 'frontCms.frontDetail', 'Front Detail', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1970, 0, 'en', 'modules', 'frontCms.featureDetail', 'Feature Detail', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1971, 0, 'en', 'modules', 'frontCms.headerDescription', 'Header Description', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1972, 1, 'en', 'modules', 'frontCms.headerDescription', 'Header Description', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1973, 1, 'en', 'modules', 'frontCms.headerDescription', 'Header Description', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1974, 0, 'en', 'modules', 'frontCms.mainImage', 'Header Image', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1975, 1, 'en', 'modules', 'frontCms.mainImage', 'Header Image', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1976, 0, 'en', 'modules', 'frontCms.featureTitle', 'Feature Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1977, 1, 'en', 'modules', 'frontCms.featureTitle', 'Feature Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1978, 1, 'en', 'modules', 'frontCms.featureTitle', 'Feature Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1979, 0, 'en', 'modules', 'frontCms.featureDescription', 'Feature Description', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1980, 1, 'en', 'modules', 'frontCms.featureDescription', 'Feature Description', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1981, 1, 'en', 'modules', 'frontCms.featureDescription', 'Feature Description', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1982, 0, 'en', 'modules', 'frontCms.priceDetail', 'Price Detail', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1983, 1, 'en', 'modules', 'frontCms.priceDetail', 'Price Detail', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1984, 0, 'en', 'modules', 'frontCms.priceTitle', 'Price Title', '2019-10-27 21:25:23', '2019-10-27 21:25:40'),
(1985, 1, 'en', 'modules', 'frontCms.priceTitle', 'Price Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1986, 1, 'en', 'modules', 'frontCms.priceTitle', 'Price Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1987, 1, 'en', 'modules', 'frontCms.priceTitle', 'Price Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1988, 1, 'en', 'modules', 'frontCms.priceTitle', 'Price Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1989, 1, 'en', 'modules', 'frontCms.priceTitle', 'Price Title', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1990, 0, 'en', 'modules', 'frontCms.priceDescription', 'Price Description', '2019-10-27 21:25:23', '2019-10-27 21:25:24'),
(1991, 1, 'en', 'modules', 'frontCms.priceDescription', 'Price Description', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1992, 1, 'en', 'modules', 'frontCms.priceDescription', 'Price Description', '2019-10-27 21:25:23', '2019-10-27 21:25:23'),
(1993, 1, 'en', 'modules', 'frontCms.priceDescription', 'Price Description', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(1994, 0, 'en', 'modules', 'frontCms.contactDetail', 'Contact Detail', '2019-10-27 21:25:24', '2019-10-27 21:25:40'),
(1995, 1, 'en', 'modules', 'frontCms.contactDetail', 'Contact Detail', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(1996, 1, 'en', 'modules', 'frontCms.contactDetail', 'Contact Detail', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(1997, 1, 'en', 'modules', 'frontCms.contactDetail', 'Contact Detail', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(1998, 1, 'en', 'modules', 'frontCms.contactDetail', 'Contact Detail', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(1999, 1, 'en', 'modules', 'frontCms.contactDetail', 'Contact Detail', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2000, 0, 'en', 'modules', 'frontCms.getStartedButtonShow', 'Show get started button', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2001, 1, 'en', 'modules', 'frontCms.getStartedButtonShow', 'Show get started button', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2002, 1, 'en', 'modules', 'frontCms.getStartedButtonShow', 'Show get started button', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2003, 0, 'en', 'modules', 'frontCms.singInButtonShow', 'Show sign-in button', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2004, 1, 'en', 'modules', 'frontCms.singInButtonShow', 'Show sign-in button', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2005, 1, 'en', 'modules', 'frontCms.singInButtonShow', 'Show sign-in button', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2006, 0, 'en', 'modules', 'frontCms.pickPlan', 'Pick your plan', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2007, 1, 'en', 'modules', 'frontCms.pickPlan', 'Pick your plan', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2008, 0, 'en', 'modules', 'frontCms.perYear', 'Per Year', '2019-10-27 21:25:24', '2019-10-27 21:25:25'),
(2009, 1, 'en', 'modules', 'frontCms.perYear', 'Per Year', '2019-10-27 21:25:24', '2019-10-27 21:25:24'),
(2010, 0, 'en', 'modules', 'frontCms.perMonth', 'Per Month', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2011, 1, 'en', 'modules', 'frontCms.perMonth', 'Per Month', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2012, 1, 'en', 'modules', 'frontCms.perMonth', 'Per Month', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2013, 0, 'en', 'modules', 'frontCms.getStarted', 'Get Started', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2014, 1, 'en', 'modules', 'frontCms.getStarted', 'Get Started', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2015, 1, 'en', 'modules', 'frontCms.getStarted', 'Get Started', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2016, 0, 'en', 'modules', 'frontCms.submitEnquiry', 'Submit Enquiry', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2017, 1, 'en', 'modules', 'frontCms.submitEnquiry', 'Submit Enquiry', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2018, 0, 'en', 'modules', 'frontCms.socialLinks', 'Social Links', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2019, 1, 'en', 'modules', 'frontCms.socialLinks', 'Social Links', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2020, 0, 'en', 'modules', 'frontCms.facebook', 'Facebook', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2021, 1, 'en', 'modules', 'frontCms.facebook', 'Facebook', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2022, 1, 'en', 'modules', 'frontCms.facebook', 'Facebook', '2019-10-27 21:25:25', '2019-10-27 21:25:25'),
(2023, 0, 'en', 'modules', 'frontCms.twitter', 'Twitter', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2024, 1, 'en', 'modules', 'frontCms.twitter', 'Twitter', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2025, 1, 'en', 'modules', 'frontCms.twitter', 'Twitter', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2026, 1, 'en', 'modules', 'frontCms.twitter', 'Twitter', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2027, 0, 'en', 'modules', 'frontCms.instagram', 'Instagram', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2028, 1, 'en', 'modules', 'frontCms.instagram', 'Instagram', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2029, 0, 'en', 'modules', 'frontCms.dribbble', 'Dribbble', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2030, 0, 'en', 'modules', 'frontCms.enterFacebookLink', 'Enter Facebook Link', '2019-10-27 21:25:26', '2019-10-27 21:25:40'),
(2031, 1, 'en', 'modules', 'frontCms.enterFacebookLink', 'Enter Facebook Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2032, 1, 'en', 'modules', 'frontCms.enterFacebookLink', 'Enter Facebook Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2033, 1, 'en', 'modules', 'frontCms.enterFacebookLink', 'Enter Facebook Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2034, 1, 'en', 'modules', 'frontCms.enterFacebookLink', 'Enter Facebook Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2035, 1, 'en', 'modules', 'frontCms.enterFacebookLink', 'Enter Facebook Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2036, 0, 'en', 'modules', 'frontCms.enterTwitterLink', 'Enter Twitter Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2037, 0, 'en', 'modules', 'frontCms.enterInstagramLink', 'Enter Instagram Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2038, 1, 'en', 'modules', 'frontCms.enterInstagramLink', 'Enter Instagram Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2039, 1, 'en', 'modules', 'frontCms.enterInstagramLink', 'Enter Instagram Link', '2019-10-27 21:25:26', '2019-10-27 21:25:26'),
(2040, 0, 'en', 'modules', 'frontCms.enterDribbbleLink', 'Enter Dribbble Link', '2019-10-27 21:25:26', '2019-10-27 21:25:27'),
(2041, 1, 'en', 'modules', 'frontCms.enterDribbbleLink', 'Enter Dribbble Link', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2042, 1, 'en', 'modules', 'frontCms.enterDribbbleLink', 'Enter Dribbble Link', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2043, 0, 'en', 'modules', 'frontCms.enterSocialLinks', 'Please enter social links in', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2044, 1, 'en', 'modules', 'frontCms.enterSocialLinks', 'Please enter social links in', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2045, 0, 'en', 'modules', 'frontCms.socialLinksNote', 'Note: Leave input blank to hide it on Home Page.', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2046, 1, 'en', 'modules', 'frontCms.socialLinksNote', 'Note: Leave input blank to hide it on Home Page.', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2047, 1, 'en', 'modules', 'frontCms.socialLinksNote', 'Note: Leave input blank to hide it on Home Page.', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2048, 1, 'en', 'modules', 'frontCms.socialLinksNote', 'Note: Leave input blank to hide it on Home Page.', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2049, 1, 'en', 'modules', 'frontCms.socialLinksNote', 'Note: Leave input blank to hide it on Home Page.', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2050, 0, 'en', 'modules', 'featureSetting.addFeature', 'Add Feature', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2051, 0, 'en', 'modules', 'featureSetting.editFeature', 'Edit Feature', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2052, 1, 'en', 'modules', 'featureSetting.editFeature', 'Edit Feature', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2053, 1, 'en', 'modules', 'featureSetting.editFeature', 'Edit Feature', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2054, 0, 'en', 'modules', 'feature.setting', 'Feature Setting', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2055, 1, 'en', 'modules', 'feature.setting', 'Feature Setting', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2056, 0, 'en', 'modules', 'module.attendance', 'Attendance', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2057, 1, 'en', 'modules', 'module.attendance', 'Attendance', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2058, 1, 'en', 'modules', 'module.attendance', 'Attendance', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2059, 1, 'en', 'modules', 'module.attendance', 'Attendance', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2060, 1, 'en', 'modules', 'module.attendance', 'Attendance', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2061, 0, 'en', 'modules', 'module.clients', 'Clients', '2019-10-27 21:25:27', '2019-10-27 21:25:41'),
(2062, 1, 'en', 'modules', 'module.clients', 'Clients', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2063, 1, 'en', 'modules', 'module.clients', 'Clients', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2064, 0, 'en', 'modules', 'module.clients', 'Clients', '2019-10-27 21:25:27', '2019-10-27 21:25:28'),
(2065, 1, 'en', 'modules', 'module.clients', 'Clients', '2019-10-27 21:25:27', '2019-10-27 21:25:27'),
(2066, 0, 'en', 'modules', 'module.employees', 'Employees', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2067, 1, 'en', 'modules', 'module.employees', 'Employees', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2068, 0, 'en', 'modules', 'module.estimates', 'Estimates', '2019-10-27 21:25:28', '2019-10-27 21:25:41'),
(2069, 1, 'en', 'modules', 'module.estimates', 'Estimates', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2070, 1, 'en', 'modules', 'module.estimates', 'Estimates', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2071, 1, 'en', 'modules', 'module.estimates', 'Estimates', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2072, 1, 'en', 'modules', 'module.estimates', 'Estimates', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2073, 1, 'en', 'modules', 'module.estimates', 'Estimates', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2074, 0, 'en', 'modules', 'module.events', 'Events', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2075, 1, 'en', 'modules', 'module.events', 'Events', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2076, 0, 'en', 'modules', 'module.expenses', 'Expenses', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2077, 1, 'en', 'modules', 'module.expenses', 'Expenses', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2078, 0, 'en', 'modules', 'module.holidays', 'Holidays', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2079, 1, 'en', 'modules', 'module.holidays', 'Holidays', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2080, 1, 'en', 'modules', 'module.holidays', 'Holidays', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2081, 0, 'en', 'modules', 'module.invoices', 'Invoices', '2019-10-27 21:25:28', '2019-10-27 21:25:41'),
(2082, 0, 'en', 'modules', 'module.invoices', 'Invoices', '2019-10-27 21:25:28', '2019-10-27 21:25:29'),
(2083, 1, 'en', 'modules', 'module.invoices', 'Invoices', '2019-10-27 21:25:28', '2019-10-27 21:25:28'),
(2084, 0, 'en', 'modules', 'module.leads', 'Leads', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2085, 1, 'en', 'modules', 'module.leads', 'Leads', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2086, 0, 'en', 'modules', 'module.leaves', 'Leaves', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2087, 1, 'en', 'modules', 'module.leaves', 'Leaves', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2088, 1, 'en', 'modules', 'module.leaves', 'Leaves', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2089, 0, 'en', 'modules', 'module.messages', 'Messages', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2090, 1, 'en', 'modules', 'module.messages', 'Messages', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2091, 1, 'en', 'modules', 'module.messages', 'Messages', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2092, 0, 'en', 'modules', 'module.notice board', 'Notice Board', '2019-10-27 21:25:29', '2019-10-27 21:25:41'),
(2093, 0, 'en', 'modules', 'module.notice board', 'Notice Board', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2094, 0, 'en', 'modules', 'module.notice board', 'Notice Board', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2095, 0, 'en', 'modules', 'module.noticeBoard', 'Notice Board', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2096, 1, 'en', 'modules', 'module.noticeBoard', 'Notice Board', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2097, 0, 'en', 'modules', 'module.notices', 'Notices', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2098, 1, 'en', 'modules', 'module.notices', 'Notices', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2099, 1, 'en', 'modules', 'module.notices', 'Notices', '2019-10-27 21:25:29', '2019-10-27 21:25:29'),
(2100, 0, 'en', 'modules', 'module.payments', 'Payments', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2101, 0, 'en', 'modules', 'module.products', 'Products', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2102, 1, 'en', 'modules', 'module.products', 'Products', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2103, 0, 'en', 'modules', 'module.projects', 'Projects', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2104, 1, 'en', 'modules', 'module.projects', 'Projects', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2105, 0, 'en', 'modules', 'module.tasks', 'Tasks', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2106, 1, 'en', 'modules', 'module.tasks', 'Tasks', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2107, 0, 'en', 'modules', 'module.tickets', 'Tickets', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2108, 1, 'en', 'modules', 'module.tickets', 'Tickets', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2109, 0, 'en', 'modules', 'module.timelogs', 'Time Logs', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2110, 1, 'en', 'modules', 'module.timelogs', 'Time Logs', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2111, 1, 'en', 'modules', 'module.timelogs', 'Time Logs', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2112, 0, 'en', 'modules', 'module.creditNotes', 'Credit Note', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2113, 1, 'en', 'modules', 'module.creditNotes', 'Credit Note', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2114, 0, 'en', 'modules', 'paymentSetting.paypal', 'Paypal', '2019-10-27 21:25:30', '2019-10-27 21:25:31'),
(2115, 1, 'en', 'modules', 'paymentSetting.paypal', 'Paypal', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2116, 1, 'en', 'modules', 'paymentSetting.paypal', 'Paypal', '2019-10-27 21:25:30', '2019-10-27 21:25:30'),
(2117, 1, 'en', 'modules', 'paymentSetting.paypal', 'Paypal', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2118, 1, 'en', 'modules', 'paymentSetting.paypal', 'Paypal', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2119, 0, 'en', 'modules', 'paymentSetting.stripe', 'Stripe', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2120, 1, 'en', 'modules', 'paymentSetting.stripe', 'Stripe', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2121, 1, 'en', 'modules', 'paymentSetting.stripe', 'Stripe', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2122, 0, 'en', 'modules', 'paymentSetting.paypalClientId', 'Paypal Client Id', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2123, 1, 'en', 'modules', 'paymentSetting.paypalClientId', 'Paypal Client Id', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2124, 1, 'en', 'modules', 'paymentSetting.paypalClientId', 'Paypal Client Id', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2125, 1, 'en', 'modules', 'paymentSetting.paypalClientId', 'Paypal Client Id', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2126, 0, 'en', 'modules', 'paymentSetting.paypalSecret', 'Paypal Secret', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2127, 0, 'en', 'modules', 'paymentSetting.stripeClientId', 'Publishable Key', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2128, 1, 'en', 'modules', 'paymentSetting.stripeClientId', 'Publishable Key', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2129, 1, 'en', 'modules', 'paymentSetting.stripeClientId', 'Publishable Key', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2130, 0, 'en', 'modules', 'paymentSetting.stripeSecret', 'Stripe Secret', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2131, 0, 'en', 'modules', 'paymentSetting.stripeWebhookSecret', 'Stripe Webhook Secret', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2132, 1, 'en', 'modules', 'paymentSetting.stripeWebhookSecret', 'Stripe Webhook Secret', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2133, 1, 'en', 'modules', 'paymentSetting.stripeWebhookSecret', 'Stripe Webhook Secret', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2134, 0, 'en', 'modules', 'packageSetting.noOfDays', 'Number Of Days', '2019-10-27 21:25:31', '2019-10-27 21:25:32'),
(2135, 1, 'en', 'modules', 'packageSetting.noOfDays', 'Number Of Days', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2136, 1, 'en', 'modules', 'packageSetting.noOfDays', 'Number Of Days', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2137, 1, 'en', 'modules', 'packageSetting.noOfDays', 'Number Of Days', '2019-10-27 21:25:31', '2019-10-27 21:25:31'),
(2138, 0, 'en', 'modules', 'packageSetting.notificationBeforeDays', 'Notification Before Days', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2139, 1, 'en', 'modules', 'packageSetting.notificationBeforeDays', 'Notification Before Days', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2140, 0, 'en', 'modules', 'package.stripeAnnualPlanId', 'Stripe Annual Plan ID', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2141, 1, 'en', 'modules', 'package.stripeAnnualPlanId', 'Stripe Annual Plan ID', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2142, 0, 'en', 'modules', 'package.stripeMonthlyPlanId', 'Stripe Monthly Plan ID', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2143, 0, 'en', 'modules', 'credit-notes.currency', 'Currency', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2144, 1, 'en', 'modules', 'credit-notes.currency', 'Currency', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2145, 0, 'en', 'modules', 'credit-notes.creditNoteDate', 'Credit Note Date', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2146, 1, 'en', 'modules', 'credit-notes.creditNoteDate', 'Credit Note Date', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2147, 1, 'en', 'modules', 'credit-notes.creditNoteDate', 'Credit Note Date', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2148, 0, 'en', 'modules', 'credit-notes.isRecurringPayment', 'Is it a recurring payments?', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2149, 1, 'en', 'modules', 'credit-notes.isRecurringPayment', 'Is it a recurring payments?', '2019-10-27 21:25:32', '2019-10-27 21:25:32'),
(2150, 0, 'en', 'modules', 'credit-notes.subTotal', 'Sub Total', '2019-10-27 21:25:33', '2019-10-27 21:25:42'),
(2151, 1, 'en', 'modules', 'credit-notes.subTotal', 'Sub Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2152, 1, 'en', 'modules', 'credit-notes.subTotal', 'Sub Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2153, 1, 'en', 'modules', 'credit-notes.subTotal', 'Sub Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2154, 1, 'en', 'modules', 'credit-notes.subTotal', 'Sub Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2155, 1, 'en', 'modules', 'credit-notes.subTotal', 'Sub Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2156, 0, 'en', 'modules', 'credit-notes.total', 'Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2157, 1, 'en', 'modules', 'credit-notes.total', 'Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33');
INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(2158, 1, 'en', 'modules', 'credit-notes.total', 'Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2159, 1, 'en', 'modules', 'credit-notes.total', 'Total', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2160, 0, 'en', 'modules', 'credit-notes.paid', 'Paid', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2161, 1, 'en', 'modules', 'credit-notes.paid', 'Paid', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2162, 1, 'en', 'modules', 'credit-notes.paid', 'Paid', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2163, 0, 'en', 'modules', 'credit-notes.unpaid', 'Unpaid', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2164, 1, 'en', 'modules', 'credit-notes.unpaid', 'Unpaid', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2165, 1, 'en', 'modules', 'credit-notes.unpaid', 'Unpaid', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2166, 0, 'en', 'modules', 'credit-notes.partial', 'Partial', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2167, 1, 'en', 'modules', 'credit-notes.partial', 'Partial', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2168, 0, 'en', 'modules', 'credit-notes.addCreditNote', 'Add Credit Note', '2019-10-27 21:25:33', '2019-10-27 21:25:33'),
(2169, 0, 'en', 'modules', 'credit-notes.billingFrequency', 'Billing Frequency', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2170, 1, 'en', 'modules', 'credit-notes.billingFrequency', 'Billing Frequency', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2171, 1, 'en', 'modules', 'credit-notes.billingFrequency', 'Billing Frequency', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2172, 0, 'en', 'modules', 'credit-notes.billingInterval', 'Billing Interval', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2173, 1, 'en', 'modules', 'credit-notes.billingInterval', 'Billing Interval', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2174, 1, 'en', 'modules', 'credit-notes.billingInterval', 'Billing Interval', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2175, 0, 'en', 'modules', 'credit-notes.billingCycle', 'Billing Cycle', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2176, 1, 'en', 'modules', 'credit-notes.billingCycle', 'Billing Cycle', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2177, 0, 'en', 'modules', 'credit-notes.billedTo', 'Billed To', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2178, 1, 'en', 'modules', 'credit-notes.billedTo', 'Billed To', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2179, 0, 'en', 'modules', 'credit-notes.generatedBy', 'Generated By', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2180, 1, 'en', 'modules', 'credit-notes.generatedBy', 'Generated By', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2181, 0, 'en', 'modules', 'credit-notes.price', 'Price', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2182, 1, 'en', 'modules', 'credit-notes.price', 'Price', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2183, 1, 'en', 'modules', 'credit-notes.price', 'Price', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2184, 1, 'en', 'modules', 'credit-notes.price', 'Price', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2185, 0, 'en', 'modules', 'superadmin.details', 'Details', '2019-10-27 21:25:34', '2019-10-27 21:25:35'),
(2186, 1, 'en', 'modules', 'superadmin.details', 'Details', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2187, 1, 'en', 'modules', 'superadmin.details', 'Details', '2019-10-27 21:25:34', '2019-10-27 21:25:34'),
(2188, 1, 'en', 'modules', 'superadmin.details', 'Details', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2189, 0, 'en', 'modules', 'superadmin.recentRegisteredCompanies', 'Recent Registered Companies', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2190, 0, 'en', 'modules', 'superadmin.recentSubscriptions', 'Recent Subscriptions', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2191, 1, 'en', 'modules', 'superadmin.recentSubscriptions', 'Recent Subscriptions', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2192, 1, 'en', 'modules', 'superadmin.recentSubscriptions', 'Recent Subscriptions', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2193, 0, 'en', 'modules', 'superadmin.recentLicenseExpiredCompanies', 'Recent Licence Expired Companies', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2194, 1, 'en', 'modules', 'superadmin.recentLicenseExpiredCompanies', 'Recent Licence Expired Companies', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2195, 1, 'en', 'modules', 'superadmin.recentLicenseExpiredCompanies', 'Recent Licence Expired Companies', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2196, 1, 'en', 'modules', 'superadmin.recentLicenseExpiredCompanies', 'Recent Licence Expired Companies', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2197, 0, 'en', 'modules', 'billing.yourCurrentPlan', 'Your Current Plan', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2198, 1, 'en', 'modules', 'billing.yourCurrentPlan', 'Your Current Plan', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2199, 0, 'en', 'modules', 'billing.unsubscribe', 'Unsubscribe', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2200, 1, 'en', 'modules', 'billing.unsubscribe', 'Unsubscribe', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2201, 1, 'en', 'modules', 'billing.unsubscribe', 'Unsubscribe', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2202, 1, 'en', 'modules', 'billing.unsubscribe', 'Unsubscribe', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2203, 0, 'en', 'modules', 'billing.changePlan', 'Change Plan', '2019-10-27 21:25:35', '2019-10-27 21:25:36'),
(2204, 1, 'en', 'modules', 'billing.changePlan', 'Change Plan', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2205, 1, 'en', 'modules', 'billing.changePlan', 'Change Plan', '2019-10-27 21:25:35', '2019-10-27 21:25:35'),
(2206, 0, 'en', 'modules', 'billing.choosePlan', 'Choose Plan', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2207, 1, 'en', 'modules', 'billing.choosePlan', 'Choose Plan', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2208, 1, 'en', 'modules', 'billing.choosePlan', 'Choose Plan', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2209, 1, 'en', 'modules', 'billing.choosePlan', 'Choose Plan', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2210, 0, 'en', 'modules', 'company.accountSetup', 'Account Details', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2211, 1, 'en', 'modules', 'company.accountSetup', 'Account Details', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2212, 1, 'en', 'modules', 'company.accountSetup', 'Account Details', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2213, 0, 'en', 'modules', 'projectSettings.sendNotificationsTo', 'Send Reminder To', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2214, 0, 'en', 'modules', 'footer.setting', 'Footer Menu Setting', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2215, 1, 'en', 'modules', 'footer.setting', 'Footer Menu Setting', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2216, 1, 'en', 'modules', 'footer.setting', 'Footer Menu Setting', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2217, 1, 'en', 'modules', 'footer.setting', 'Footer Menu Setting', '2019-10-27 21:25:36', '2019-10-27 21:25:36'),
(2218, 0, 'en', 'modules', 'footer.addFooter', 'Add Footer Menu', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2219, 1, 'en', 'modules', 'footer.addFooter', 'Add Footer Menu', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2220, 1, 'en', 'modules', 'footer.addFooter', 'Add Footer Menu', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2221, 0, 'en', 'modules', 'footer.editFooter', 'Edit Footer Menu', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2222, 1, 'en', 'modules', 'footer.editFooter', 'Edit Footer Menu', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2223, 1, 'en', 'modules', 'footer.editFooter', 'Edit Footer Menu', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2224, 1, 'en', 'modules', 'footer.editFooter', 'Edit Footer Menu', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2225, 1, 'en', 'modules', 'footer.editFooter', 'Edit Footer Menu', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2226, 0, 'en', 'modules', 'leave.leaveRequest', 'Leave Request Received', '2019-10-27 21:25:37', '2019-10-27 21:25:43'),
(2227, 1, 'en', 'modules', 'leave.leaveRequest', 'Leave Request Received', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2228, 1, 'en', 'modules', 'leave.leaveRequest', 'Leave Request Received', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2229, 1, 'en', 'modules', 'leave.leaveRequest', 'Leave Request Received', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2230, 1, 'en', 'modules', 'leave.leaveRequest', 'Leave Request Received', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2231, 1, 'en', 'modules', 'leave.leaveRequest', 'Leave Request Received', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2232, 0, 'en', 'pagination', 'previous', '&laquo; Previous', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2233, 0, 'en', 'pagination', 'next', 'Next &raquo;', '2019-10-27 21:25:37', '2019-10-27 21:25:38'),
(2234, 1, 'en', 'pagination', 'next', 'Next &raquo;', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2235, 1, 'en', 'pagination', 'next', 'Next &raquo;', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2236, 1, 'en', 'pagination', 'next', 'Next &raquo;', '2019-10-27 21:25:37', '2019-10-27 21:25:37'),
(2237, 0, 'en', 'passwords', 'password', 'Passwords must be at least six characters and match the confirmation.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2238, 1, 'en', 'passwords', 'password', 'Passwords must be at least six characters and match the confirmation.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2239, 0, 'en', 'passwords', 'reset', 'Your password has been reset!', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2240, 0, 'en', 'passwords', 'sent', 'We have e-mailed your password reset link!', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2241, 1, 'en', 'passwords', 'sent', 'We have e-mailed your password reset link!', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2242, 0, 'en', 'passwords', 'token', 'This password reset token is invalid.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2243, 0, 'en', 'passwords', 'user', 'We can\'t find a user with that e-mail address.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2244, 1, 'en', 'passwords', 'user', 'We can\'t find a user with that e-mail address.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2245, 1, 'en', 'passwords', 'user', 'We can\'t find a user with that e-mail address.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2246, 1, 'en', 'passwords', 'user', 'We can\'t find a user with that e-mail address.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2247, 0, 'en', 'validation', 'accepted', 'The :attribute must be accepted.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2248, 0, 'en', 'validation', 'active_url', 'The :attribute is not a valid URL.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2249, 0, 'en', 'validation', 'after', 'The :attribute must be a date after :date.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2250, 1, 'en', 'validation', 'after', 'The :attribute must be a date after :date.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2251, 1, 'en', 'validation', 'after', 'The :attribute must be a date after :date.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2252, 0, 'en', 'validation', 'after_or_equal', 'The :attribute must be a date after or equal to :date.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2253, 0, 'en', 'validation', 'alpha', 'The :attribute may only contain letters.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2254, 0, 'en', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, and dashes.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2255, 1, 'en', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, and dashes.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2256, 1, 'en', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, and dashes.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2257, 1, 'en', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, and dashes.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2258, 0, 'en', 'validation', 'alpha_num', 'The :attribute may only contain letters and numbers.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2259, 1, 'en', 'validation', 'alpha_num', 'The :attribute may only contain letters and numbers.', '2019-10-27 21:25:38', '2019-10-27 21:25:38'),
(2260, 0, 'en', 'validation', 'array', 'The :attribute must be an array.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2261, 1, 'en', 'validation', 'array', 'The :attribute must be an array.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2262, 1, 'en', 'validation', 'array', 'The :attribute must be an array.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2263, 1, 'en', 'validation', 'array', 'The :attribute must be an array.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2264, 1, 'en', 'validation', 'array', 'The :attribute must be an array.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2265, 0, 'en', 'validation', 'before', 'The :attribute must be a date before :date.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2266, 1, 'en', 'validation', 'before', 'The :attribute must be a date before :date.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2267, 1, 'en', 'validation', 'before', 'The :attribute must be a date before :date.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2268, 1, 'en', 'validation', 'before', 'The :attribute must be a date before :date.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2269, 0, 'en', 'validation', 'before_or_equal', 'The :attribute must be a date before or equal to :date.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2270, 1, 'en', 'validation', 'before_or_equal', 'The :attribute must be a date before or equal to :date.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2271, 0, 'en', 'validation', 'between.numeric', 'The :attribute must be between :min and :max.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2272, 0, 'en', 'validation', 'between.file', 'The :attribute must be between :min and :max kilobytes.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2273, 0, 'en', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2274, 1, 'en', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2275, 1, 'en', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2276, 1, 'en', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2277, 0, 'en', 'validation', 'between.array', 'The :attribute must have between :min and :max items.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2278, 0, 'en', 'validation', 'boolean', 'The :attribute field must be true or false.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2279, 0, 'en', 'validation', 'confirmed', 'The :attribute confirmation does not match.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2280, 1, 'en', 'validation', 'confirmed', 'The :attribute confirmation does not match.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2281, 0, 'en', 'validation', 'date', 'The :attribute is not a valid date.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2282, 1, 'en', 'validation', 'date', 'The :attribute is not a valid date.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2283, 0, 'en', 'validation', 'date_format', 'The :attribute does not match the format :format.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2284, 1, 'en', 'validation', 'date_format', 'The :attribute does not match the format :format.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2285, 1, 'en', 'validation', 'date_format', 'The :attribute does not match the format :format.', '2019-10-27 21:25:39', '2019-10-27 21:25:39'),
(2286, 0, 'en', 'validation', 'different', 'The :attribute and :other must be different.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2287, 1, 'en', 'validation', 'different', 'The :attribute and :other must be different.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2288, 0, 'en', 'validation', 'digits', 'The :attribute must be :digits digits.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2289, 1, 'en', 'validation', 'digits', 'The :attribute must be :digits digits.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2290, 0, 'en', 'validation', 'digits_between', 'The :attribute must be between :min and :max digits.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2291, 1, 'en', 'validation', 'digits_between', 'The :attribute must be between :min and :max digits.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2292, 0, 'en', 'validation', 'dimensions', 'The :attribute has invalid image dimensions.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2293, 1, 'en', 'validation', 'dimensions', 'The :attribute has invalid image dimensions.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2294, 1, 'en', 'validation', 'dimensions', 'The :attribute has invalid image dimensions.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2295, 0, 'en', 'validation', 'distinct', 'The :attribute field has a duplicate value.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2296, 1, 'en', 'validation', 'distinct', 'The :attribute field has a duplicate value.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2297, 0, 'en', 'validation', 'email', 'The :attribute must be a valid email address.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2298, 1, 'en', 'validation', 'email', 'The :attribute must be a valid email address.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2299, 1, 'en', 'validation', 'email', 'The :attribute must be a valid email address.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2300, 0, 'en', 'validation', 'exists', 'The selected :attribute is invalid.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2301, 1, 'en', 'validation', 'exists', 'The selected :attribute is invalid.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2302, 0, 'en', 'validation', 'file', 'The :attribute must be a file.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2303, 1, 'en', 'validation', 'file', 'The :attribute must be a file.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2304, 1, 'en', 'validation', 'file', 'The :attribute must be a file.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2305, 1, 'en', 'validation', 'file', 'The :attribute must be a file.', '2019-10-27 21:25:40', '2019-10-27 21:25:40'),
(2306, 0, 'en', 'validation', 'filled', 'The :attribute field must have a value.', '2019-10-27 21:25:40', '2019-10-27 21:25:41'),
(2307, 0, 'en', 'validation', 'image', 'The :attribute must be an image.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2308, 1, 'en', 'validation', 'image', 'The :attribute must be an image.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2309, 0, 'en', 'validation', 'in', 'The selected :attribute is invalid.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2310, 1, 'en', 'validation', 'in', 'The selected :attribute is invalid.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2311, 1, 'en', 'validation', 'in', 'The selected :attribute is invalid.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2312, 0, 'en', 'validation', 'in_array', 'The :attribute field does not exist in :other.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2313, 0, 'en', 'validation', 'integer', 'The :attribute must be an integer.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2314, 0, 'en', 'validation', 'ip', 'The :attribute must be a valid IP address.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2315, 1, 'en', 'validation', 'ip', 'The :attribute must be a valid IP address.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2316, 1, 'en', 'validation', 'ip', 'The :attribute must be a valid IP address.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2317, 0, 'en', 'validation', 'json', 'The :attribute must be a valid JSON string.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2318, 1, 'en', 'validation', 'json', 'The :attribute must be a valid JSON string.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2319, 1, 'en', 'validation', 'json', 'The :attribute must be a valid JSON string.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2320, 0, 'en', 'validation', 'max.numeric', 'The :attribute may not be greater than :max.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2321, 1, 'en', 'validation', 'max.numeric', 'The :attribute may not be greater than :max.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2322, 0, 'en', 'validation', 'max.file', 'The :attribute may not be greater than :max kilobytes.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2323, 1, 'en', 'validation', 'max.file', 'The :attribute may not be greater than :max kilobytes.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2324, 0, 'en', 'validation', 'max.string', 'The :attribute may not be greater than :max characters.', '2019-10-27 21:25:41', '2019-10-27 21:25:42'),
(2325, 1, 'en', 'validation', 'max.string', 'The :attribute may not be greater than :max characters.', '2019-10-27 21:25:41', '2019-10-27 21:25:41'),
(2326, 0, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2327, 1, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2328, 1, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2329, 1, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2330, 0, 'en', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2331, 1, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2332, 1, 'en', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2333, 1, 'en', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2334, 1, 'en', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2335, 0, 'en', 'validation', 'mimetypes', 'The :attribute must be a file of type: :values.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2336, 1, 'en', 'validation', 'mimetypes', 'The :attribute must be a file of type: :values.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2337, 1, 'en', 'validation', 'mimetypes', 'The :attribute must be a file of type: :values.', '2019-10-27 21:25:42', '2019-10-27 21:25:42'),
(2338, 0, 'en', 'validation', 'min.numeric', 'The :attribute must be at least :min.', '2019-10-27 21:25:42', '2019-10-27 21:25:43'),
(2339, 0, 'en', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2340, 1, 'en', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2341, 1, 'en', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2342, 1, 'en', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2343, 0, 'en', 'validation', 'min.string', 'The :attribute must be at least :min characters.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2344, 1, 'en', 'validation', 'min.string', 'The :attribute must be at least :min characters.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2345, 1, 'en', 'validation', 'min.string', 'The :attribute must be at least :min characters.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2346, 1, 'en', 'validation', 'min.string', 'The :attribute must be at least :min characters.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2347, 0, 'en', 'validation', 'min.array', 'The :attribute must have at least :min items.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2348, 1, 'en', 'validation', 'min.array', 'The :attribute must have at least :min items.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2349, 0, 'en', 'validation', 'not_in', 'The selected :attribute is invalid.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2350, 0, 'en', 'validation', 'numeric', 'The :attribute must be a number.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2351, 1, 'en', 'validation', 'numeric', 'The :attribute must be a number.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2352, 1, 'en', 'validation', 'numeric', 'The :attribute must be a number.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2353, 0, 'en', 'validation', 'present', 'The :attribute field must be present.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2354, 1, 'en', 'validation', 'present', 'The :attribute field must be present.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2355, 1, 'en', 'validation', 'present', 'The :attribute field must be present.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2356, 1, 'en', 'validation', 'present', 'The :attribute field must be present.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2357, 0, 'en', 'validation', 'regex', 'The :attribute format is invalid.', '2019-10-27 21:25:43', '2019-10-27 21:25:43'),
(2358, 0, 'en', 'validation', 'required', 'The :attribute field is required.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2359, 1, 'en', 'validation', 'required', 'The :attribute field is required.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2360, 0, 'en', 'validation', 'required_if', 'The :attribute field is required when :other is :value.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2361, 1, 'en', 'validation', 'required_if', 'The :attribute field is required when :other is :value.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2362, 1, 'en', 'validation', 'required_if', 'The :attribute field is required when :other is :value.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2363, 0, 'en', 'validation', 'required_unless', 'The :attribute field is required unless :other is in :values.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2364, 1, 'en', 'validation', 'required_unless', 'The :attribute field is required unless :other is in :values.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2365, 1, 'en', 'validation', 'required_unless', 'The :attribute field is required unless :other is in :values.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2366, 0, 'en', 'validation', 'required_with', 'The :attribute field is required when :values is present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2367, 1, 'en', 'validation', 'required_with', 'The :attribute field is required when :values is present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2368, 0, 'en', 'validation', 'required_with_all', 'The :attribute field is required when :values is present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2369, 0, 'en', 'validation', 'required_with_all', 'The :attribute field is required when :values is present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2370, 1, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2371, 1, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2372, 1, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2373, 1, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2374, 1, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2375, 1, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2376, 1, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2377, 0, 'en', 'validation', 'required_without_all', 'The :attribute field is required when none of :values are present.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2378, 0, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2019-10-27 21:25:44', '2019-10-27 21:25:45'),
(2379, 1, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2019-10-27 21:25:44', '2019-10-27 21:25:44'),
(2380, 1, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2381, 1, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2382, 1, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2383, 1, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2384, 0, 'en', 'validation', 'size.numeric', 'The :attribute must be :size.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2385, 1, 'en', 'validation', 'size.numeric', 'The :attribute must be :size.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2386, 1, 'en', 'validation', 'size.numeric', 'The :attribute must be :size.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2387, 0, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2388, 1, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2389, 1, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2390, 1, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2391, 1, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2392, 0, 'en', 'validation', 'size.string', 'The :attribute must be :size characters.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2393, 0, 'en', 'validation', 'size.array', 'The :attribute must contain :size items.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2394, 1, 'en', 'validation', 'size.array', 'The :attribute must contain :size items.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2395, 1, 'en', 'validation', 'size.array', 'The :attribute must contain :size items.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2396, 1, 'en', 'validation', 'size.array', 'The :attribute must contain :size items.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2397, 0, 'en', 'validation', 'string', 'The :attribute must be a string.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2398, 1, 'en', 'validation', 'string', 'The :attribute must be a string.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2399, 0, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2400, 1, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2401, 1, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2402, 1, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2403, 1, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2404, 0, 'en', 'validation', 'unique', 'The :attribute has already been taken.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2405, 1, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2406, 0, 'en', 'validation', 'uploaded', 'The :attribute failed to upload.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2407, 1, 'en', 'validation', 'uploaded', 'The :attribute failed to upload.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2408, 1, 'en', 'validation', 'uploaded', 'The :attribute failed to upload.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2409, 1, 'en', 'validation', 'uploaded', 'The :attribute failed to upload.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2410, 0, 'en', 'validation', 'url', 'The :attribute format is invalid.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2411, 1, 'en', 'validation', 'url', 'The :attribute format is invalid.', '2019-10-27 21:25:45', '2019-10-27 21:25:45'),
(2412, 0, 'en', 'validation', 'custom.attribute-name.rule-name', 'custom-message', '2019-10-27 21:25:45', '2019-10-27 21:25:46'),
(2413, 1, 'en', 'validation', 'custom.attribute-name.rule-name', 'custom-message', '2019-10-27 21:25:45', '2019-10-27 21:25:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_settings`
--

CREATE TABLE `message_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `allow_client_admin` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `allow_client_employee` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `message_settings`
--

INSERT INTO `message_settings` (`id`, `company_id`, `allow_client_admin`, `allow_client_employee`, `created_at`, `updated_at`) VALUES
(1, NULL, 'no', 'no', '2019-10-27 06:40:52', '2019-10-27 06:40:52'),
(2, 1, 'no', 'no', '2019-10-27 06:47:08', '2019-10-27 06:47:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_04_02_193003_create_countries_table', 1),
(2, '2014_04_02_193005_create_translations_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2016_06_20_112951_create_user_chat_table', 1),
(6, '2017_03_23_110416_add_column_users_table', 1),
(7, '2017_03_23_111036_create_client_details_table', 1),
(8, '2017_03_23_112028_create_client_contacts_table', 1),
(9, '2017_03_23_112353_create_employee_details_table', 1),
(10, '2017_03_23_114438_create_organisation_settings_table', 1),
(11, '2017_03_23_122646_create_project_category_table', 1),
(12, '2017_03_23_123601_create_projects_table', 1),
(13, '2017_03_23_125424_create_project_members_table', 1),
(14, '2017_03_23_125625_create_project_time_logs_table', 1),
(15, '2017_03_23_130413_create_project_files_table', 1),
(16, '2017_03_24_051800_create_tasks_table', 1),
(17, '2017_03_24_054355_create_notices_table', 1),
(18, '2017_03_24_055005_create_conversation_table', 1),
(19, '2017_03_24_055539_create_conversation_reply_table', 1),
(20, '2017_03_24_055859_create_invoices_table', 1),
(21, '2017_03_24_060421_create_invoice_items_table', 1),
(22, '2017_03_24_060751_create_quotations_table', 1),
(23, '2017_03_24_061241_create_quotation_items_table', 1),
(24, '2017_03_24_061505_create_sticky_notes_table', 1),
(25, '2017_03_24_064541_create_issues_table', 1),
(26, '2017_03_29_123858_entrust_setup_tables', 1),
(27, '2017_04_04_193158_AddColumnsProjectFilesTable', 1),
(28, '2017_04_05_063103_change_clientid_projectid_invoice_table', 1),
(29, '2017_04_06_051401_add_discount_column_invoice_table', 1),
(30, '2017_04_06_054728_add_status_column_issues_table', 1),
(31, '2017_04_08_152902_add_total_hours_column_time_log_table', 1),
(32, '2017_04_18_095809_create_project_activity_table', 1),
(33, '2017_04_18_103815_create_user_activities_table', 1),
(34, '2017_04_19_101519_create_email_notification_settings_table', 1),
(35, '2017_04_20_185211_add_colour_column_sticky_notes_table', 1),
(36, '2017_04_28_114154_create_notifications_table', 1),
(37, '2017_05_03_131016_add_project_completion_field_projects', 1),
(38, '2017_05_03_174333_create_currencies_table', 1),
(39, '2017_05_05_124330_create_module_settings_table', 1),
(40, '2017_05_05_233111_add_status_column_invoices', 1),
(41, '2017_05_11_140502_add_currency_symbol_column_invoices', 1),
(42, '2017_05_11_170244_add_currency_id_column_organisation_settings_table', 1),
(43, '2017_05_22_172748_add_timezone_column_settings_table', 1),
(44, '2017_05_24_120216_create_smtp_settings_table', 1),
(45, '2017_05_31_112158_create_universal_search_table', 1),
(46, '2017_06_22_131112_add_locale_organisation_settings_table', 1),
(47, '2017_07_13_091922_add_calculate_task_progress_column_project_table', 1),
(48, '2017_07_20_093528_on_delete_setnull_timelog', 1),
(49, '2017_07_21_120958_create_theme_settings_table', 1),
(50, '2017_07_24_113657_add_link_color_column_theme_settings_table', 1),
(51, '2017_07_24_123050_add_login_background_organisation_settings_table', 1),
(52, '2017_07_27_101351_add_column_type_invoice_items_table', 1),
(53, '2017_07_28_102010_create_estimates_table', 1),
(54, '2017_07_28_103230_create_estimate_items_table', 1),
(55, '2017_08_04_064431_create_payments_table', 1),
(56, '2017_08_05_103940_create_payment_gateway_credential_table', 1),
(57, '2017_08_08_055908_add_enable_paypal_column_payment_gateway_table', 1),
(58, '2017_08_09_054230_create_expenses_table', 1),
(59, '2017_08_21_065430_add_exchange_rate_column_currency_table', 1),
(60, '2017_08_21_131318_create_invoice_setting_table', 1),
(61, '2017_08_22_055908_add_expense_email_setting_to_email_notification_setting_table', 1),
(62, '2017_08_28_110759_add_recurring_columns_in_invoice_table', 1),
(63, '2017_08_30_061016_add_plan_id_to_payments_table', 1),
(64, '2017_08_30_093400_create_settings_table', 1),
(65, '2017_08_30_123956_add_slack_username_column_employee_details_table', 1),
(66, '2017_08_30_133725_add_send_slack_column_email_notification_settings_table', 1),
(67, '2017_09_01_060715_add_stipe_column_to_payment_credentials_table', 1),
(68, '2017_09_01_090124_add_customer_id_column_to_payments_table', 1),
(69, '2017_09_02_084049_add_locale_column_users_table', 1),
(70, '2017_09_14_095429_create_ticket_reply_templates_table', 1),
(71, '2017_09_14_095815_create_ticket_types_table', 1),
(72, '2017_09_14_100400_create_ticket_groups_table', 1),
(73, '2017_09_14_100530_create_ticket_tag_list_table', 1),
(74, '2017_09_14_114900_create_ticket_channels_table', 1),
(75, '2017_09_14_115003_create_ticket_agent_groups_table', 1),
(76, '2017_09_14_115004_create_tickets_table', 1),
(77, '2017_09_14_115005_create_ticket_tags_table', 1),
(78, '2017_09_18_064917_add_status_column_ticket_agent_group_table', 1),
(79, '2017_09_24_101700_create_ticket_replies_table', 1),
(80, '2017_09_25_060229_drop_description_column_ticket_table', 1),
(81, '2017_09_25_072611_add_deleted_at_column_tickets', 1),
(82, '2017_09_25_072627_add_deleted_at_column_ticket_reply', 1),
(83, '2017_10_03_094922_ticket_notification_migration', 1),
(84, '2017_10_03_134003_add_latitude_longitude_column', 1),
(85, '2017_10_12_111741_create_attendance_setting_table', 1),
(86, '2017_10_13_051909_create_attendance_table', 1),
(87, '2017_10_26_051335_add_mail_from_email_column_smtp_settings_table', 1),
(88, '2017_10_26_112253_add_office_open_days_column_attendance_settings_table', 1),
(89, '2017_11_01_054603_add_columns_to_client_details', 1),
(90, '2017_11_02_045542_change_on_cascade_project_members', 1),
(91, '2017_11_07_054438_add_project_admin_column_project_table', 1),
(92, '2017_11_07_125619_remove_project_admin_role', 1),
(93, '2017_11_08_045549_make_project_id_nullable_tasks_table', 1),
(94, '2017_11_09_071318_create_taskboard_columns_table', 1),
(95, '2017_11_09_092817_add_column_tasks_table', 1),
(96, '2017_11_20_070830_create_custom_fields_table', 1),
(97, '2017_11_20_071758_create_custom_fields__data_table', 1),
(98, '2017_11_22_071535_create_events_table', 1),
(99, '2017_11_23_065323_add_cryptocurrency_columns', 1),
(100, '2017_11_24_103957_create_event_attendees_table', 1),
(101, '2017_12_07_034433_change cascade users in time log table', 1),
(102, '2017_12_12_071823_create_modules_table', 1),
(103, '2017_12_12_073501_add_module_id_column_permissions_table', 1),
(104, '2017_12_21_114839_change_upload_folder', 1),
(105, '2017_12_28_112910_create_leave_types_table', 1),
(106, '2017_12_30_184422_create_leaves_table', 1),
(107, '2018_01_02_122442_add_leaves_notification_setting', 1),
(108, '2018_01_05_062543_add_user_css_column_theme_settings', 1),
(109, '2018_01_09_180937_add_task_completed_notification_setting', 1),
(110, '2018_01_29_073527_create_message_setting_table', 1),
(111, '2018_04_12_100452_add_dropbox_link_column_project_files_table', 1),
(112, '2018_04_12_123243_create_file_storage_table', 1),
(113, '2018_04_13_072732_create_groups_table', 1),
(114, '2018_04_13_092757_create_employee_groups_table', 1),
(115, '2018_04_17_113657_set_attendance_late_column_default', 1),
(116, '2018_05_07_065407_alter_invoice_id_null_payments', 1),
(117, '2018_05_07_065557_add_currency_id_column_payments_table', 1),
(118, '2018_05_08_064539_add_note_column_invoices', 1),
(119, '2018_05_15_072536_add_project_id_column_payments', 1),
(120, '2018_05_28_094515_set_gateway_column_null_payments_table', 1),
(121, '2018_05_29_070343_change_completed_on_column_to_datetime', 1),
(122, '2018_05_29_114402_populate_file_storage_settings_table', 1),
(123, '2018_05_30_051128_add_google_url_to_project_files_table', 1),
(124, '2018_06_05_092136_create_sub_tasks_table', 1),
(125, '2018_06_06_091511_create_task_comments_table', 1),
(126, '2018_06_11_054204_create_push_subscriptions_table', 1),
(127, '2018_06_14_094059_create_taxes_table', 1),
(128, '2018_06_18_065034_add_tax_id_column_invoice_items_table', 1),
(129, '2018_06_18_071442_add_discount_column_invoice_items_table', 1),
(130, '2018_06_21_052408_change_default_taskboard_columns', 1),
(131, '2018_06_26_160023_add_leave_count_column_leave_types_table', 1),
(132, '2018_06_27_072813_add_leaves_start_from_column', 1),
(133, '2018_06_27_075233_add_joining_date_column', 1),
(134, '2018_06_27_113713_add_gender_column_users_table', 1),
(135, '2018_06_28_054604_add_client_view_task_column_project_table', 1),
(136, '2018_06_28_191256_create_language_settings_table', 1),
(137, '2018_06_29_060331_add_active_theme_column_settings', 1),
(138, '2018_06_29_081128_add_manual_timelog_column_project_timelog', 1),
(139, '2018_06_29_104709_seed_languages', 1),
(140, '2018_08_02_121259_add_minutes_column_time_log_table', 1),
(141, '2018_08_22_103829_add_leaves_module', 1),
(142, '2018_08_22_104302_add_leaves_permissions', 1),
(143, '2018_08_27_114329_add_module_list_in_module_settings', 1),
(144, '2018_08_30_065158_add_status_column_users_table', 1),
(145, '2018_08_31_095814_create_lead_table', 1),
(146, '2018_08_31_095815_create_lead_source_table', 1),
(147, '2018_08_31_095815_create_lead_status_table', 1),
(148, '2018_08_31_095816_create_lead_follow_up_table', 1),
(149, '2018_09_04_095158_alter_lead_table', 1),
(150, '2018_09_04_095816_add_lead_module', 1),
(151, '2018_09_05_102010_create_proposal_table', 1),
(152, '2018_09_05_113230_create_proposal_items_table', 1),
(153, '2018_09_07_051239_alter_lead_website_table', 1),
(154, '2018_09_15_174026_add_default_lead_settings', 1),
(155, '2018_09_17_045718_add_leads_permission', 1),
(156, '2018_09_19_091643_add_remarks_to_payments_table', 1),
(157, '2018_09_19_100708_create_products_table', 1),
(158, '2018_09_21_095816_create_offline_payment_method_table', 1),
(159, '2018_09_25_065158_alter_payment_table', 1),
(160, '2018_09_28_110029_create_log_time_for_table', 1),
(161, '2018_09_28_965158_alter_project_time_log_table', 1),
(162, '2018_10_03_121901_create_packages_table', 1),
(163, '2018_10_03_121902_alter_organisation_settings_table', 1),
(164, '2018_10_04_042418_create_licences_table', 1),
(165, '2018_10_04_082754_add_super_admin_column_in_users_table', 1),
(166, '2018_10_08_091643_alter_project_table', 1),
(167, '2018_10_08_095950_create_subscriptions_table', 1),
(168, '2018_10_08_110029_create_lead_files_table', 1),
(169, '2018_10_08_120639_add_company_id_in_users_table', 1),
(170, '2018_10_10_110029_create_holidays_table', 1),
(171, '2018_10_10_114514_add_company_id_in_teams_table', 1),
(172, '2018_10_10_120621_add_company_id_in_leads_table', 1),
(173, '2018_10_10_123601_create_project_templates_table', 1),
(174, '2018_10_10_125424_create_project_template_members_table', 1),
(175, '2018_10_10_135816_add_holiday_module', 1),
(176, '2018_10_10_251800_create_project_template_tasks_table', 1),
(177, '2018_10_11_044355_add_company_id_in_attendances_table', 1),
(178, '2018_10_11_055814_add_company_id_in_holidays_table', 1),
(179, '2018_10_11_061029_add_company_id_in_projects_table', 1),
(180, '2018_10_11_061955_add_company_id_in_project_category_table', 1),
(181, '2018_10_11_063520_add_company_id_in_project_members_table', 1),
(182, '2018_10_11_065229_add_company_id_in_invoices_table', 1),
(183, '2018_10_11_070557_add_company_id_in_project_activity_table', 1),
(184, '2018_10_11_071656_add_company_id_in_products_table', 1),
(185, '2018_10_11_072547_add_company_id_in_taxes_table', 1),
(186, '2018_10_11_081816_add_company_id_in_tasks_table', 1),
(187, '2018_10_11_083600_add_company_id_in_taskboard_columns_table', 1),
(188, '2018_10_11_100425_add_company_id_in_estimates_table', 1),
(189, '2018_10_11_101701_add_company_id_in_payments_table', 1),
(190, '2018_10_11_102047_add_company_id_in_expenses_table', 1),
(191, '2018_10_11_110008_add_company_id_in_employee_details_table', 1),
(192, '2018_10_11_115208_add_company_id_in_project_time_logs_table', 1),
(193, '2018_10_11_115805_add_company_id_in_user_activities_table', 1),
(194, '2018_10_12_045341_add_company_id_in_tickets_table', 1),
(195, '2018_10_12_051409_add_company_id_in_ticket_channels_table', 1),
(196, '2018_10_12_052646_add_company_id_in_ticket_types_table', 1),
(197, '2018_10_12_060038_add_company_id_in_ticket_groups_table', 1),
(198, '2018_10_12_061136_add_company_id_in_ticket_agent_groups_table', 1),
(199, '2018_10_12_061807_add_company_id_in_ticket_reply_templates_table', 1),
(200, '2018_10_12_072321_add_company_id_in_events_table', 1),
(201, '2018_10_12_090132_add_company_id_in_leave_types_table', 1),
(202, '2018_10_12_090146_add_company_id_in_leaves_table', 1),
(203, '2018_10_12_093431_add_company_id_in_notices_table', 1),
(204, '2018_10_12_110433_add_company_id_in_email_notification_settings_table', 1),
(205, '2018_10_12_110842_add_company_id_in_smtp_settings_table', 1),
(206, '2018_10_15_051607_add_company_id_in_currencies_table', 1),
(207, '2018_10_15_052819_create_global_settings_table', 1),
(208, '2018_10_15_065737_add_company_id_in_theme_settings_table', 1),
(209, '2018_10_15_070856_alter_currency_id_in_companies_table', 1),
(210, '2018_10_15_083914_add_company_id_in_payment_gateway_credentials_table', 1),
(211, '2018_10_15_093625_add_company_id_in_invoice_settings_table', 1),
(212, '2018_10_15_094709_add_company_id_in_slack_settings_table', 1),
(213, '2018_10_15_105445_add_company_id_in_attendance_settings_table', 1),
(214, '2018_10_15_115927_add_company_id_in_custom_field_groups_table', 1),
(215, '2018_10_16_045235_add_company_id_in_module_settings_table', 1),
(216, '2018_10_16_071301_add_company_id_in_roles_table', 1),
(217, '2018_10_16_095816_add_holiday_module_detail', 1),
(218, '2018_10_17_043749_add_company_id_in_message_settings_table', 1),
(219, '2018_10_17_052214_add_company_id_in_file_storage_settings_table', 1),
(220, '2018_10_17_063334_add_company_id_in_lead_sources_table', 1),
(221, '2018_10_17_063359_add_company_id_in_lead_status_table', 1),
(222, '2018_10_17_081757_remove_config_datatable_file', 1),
(223, '2018_10_17_965158_alter_leads_address_table', 1),
(224, '2018_10_17_965168_alter_leads_phone_table', 1),
(225, '2018_10_18_034518_create_stripe_invoices_table', 1),
(226, '2018_10_18_075228_add_column_in_global_settings_table', 1),
(227, '2018_10_18_091643_alter_attendance_setting_table', 1),
(228, '2018_10_19_045718_add_holidays_permission', 1),
(229, '2018_10_20_094413_add_products_module', 1),
(230, '2018_10_20_094504_add_products_permissions', 1),
(231, '2018_10_21_051239_alter_holiday_website_table', 1),
(232, '2018_10_22_050933_alter_state_column_companies_table', 1),
(233, '2018_10_23_071525_remove_company_id_column_smtp_settings_table', 1),
(234, '2018_10_24_041117_add_column_email_verification_code_in_users_table', 1),
(235, '2018_10_24_071300_add_file_column_to_invoices_table', 1),
(236, '2018_10_24_965158_alter_employee_detail_table', 1),
(237, '2018_10_29_965158_alter_attendance_setting_default_table', 1),
(238, '2018_11_02_061629_add_column_in_proposals_table', 1),
(239, '2018_11_10_071300_alter_user_table', 1),
(240, '2018_11_10_122646_create_task_category_table', 1),
(241, '2018_11_15_105021_alter_stripe_invoices_table', 1),
(242, '2018_11_16_072246_add_company_id_in_client_details_table', 1),
(243, '2018_11_16_104747_add_column_in_estimate_items_table', 1),
(244, '2018_11_16_112847_add_column_in_proposals_items_table', 1),
(245, '2018_11_22_044348_add_estimate_number_column_in_estimates_table', 1),
(246, '2018_11_30_965158_alter_invoice_item_table', 1),
(247, '2018_12_12_965158_alter_invoice_estimate_response_table', 1),
(248, '2018_12_14_094504_add_expenses_permissions', 1),
(249, '2018_12_14_194504_add_expenses_permissions_detail', 1),
(250, '2018_12_20_1065158_alter_company_setting_table', 1),
(251, '2018_12_20_965158_alter_estimate_quantity_table', 1),
(252, '2018_12_27_074504_check_verify_purchase_file', 1),
(253, '2018_12_28_075730_create_push_notification_settings_table', 1),
(254, '2018_12_28_082056_add_send_push_column_email_notification_table', 1),
(255, '2018_12_28_123245_add_onesignal_player_id_column_users_table', 1),
(256, '2019_01_02_1065158_alter_module_setting_table', 1),
(257, '2019_01_02_2065158_insert_module_setting_client_table', 1),
(258, '2019_01_04_110029_create_employee_docs_table', 1),
(259, '2019_01_10_063520_add_company_id_in_lead_files_table', 1),
(260, '2019_01_17_045235_add_company_id_in_project_template_table', 1),
(261, '2019_01_17_055235_add_company_id_in_task_category_table', 1),
(262, '2019_01_17_065235_add_company_id_in_employee_docs_table', 1),
(263, '2019_01_17_075235_add_company_id_in_log_time_for_table', 1),
(264, '2019_01_21_1065158_alter_task_creator_table', 1),
(265, '2019_02_06_1065158_alter_attendance_check_table', 1),
(266, '2019_02_08_174333_create_global_currencies_table', 1),
(267, '2019_02_08_275235_add_currency_id_in_global_setting_table', 1),
(268, '2019_02_11_1065158_alter_log_time_for_table', 1),
(269, '2019_02_12_2065158_insert_module_setting_client_task_table', 1),
(270, '2019_02_13_110029_create_skills_table', 1),
(271, '2019_02_13_130029_create_employee_skills_table', 1),
(272, '2019_02_15_1065158_alter_employee_end_date_table', 1),
(273, '2019_02_15_1165158_alter_custom_status_table', 1),
(274, '2019_02_20_074848_create_jobs_table', 1),
(275, '2019_02_22_1165158_add_company_currency_api_google_api', 1),
(276, '2019_02_22_1165158_add_currency_api_google_api', 1),
(277, '2019_02_25_965158_alter_package_max_size_table', 1),
(278, '2019_02_28_965158_alter_package_sort_billing_cycle_table', 1),
(279, '2019_03_04_073501_change_module_id_notice_permissions_table', 1),
(280, '2019_03_05_110029_create_front_detail_table', 1),
(281, '2019_03_05_110039_create_feature_table', 1),
(282, '2019_03_08_1165158_create_stripe_table', 1),
(283, '2019_03_08_965158_alter_invoice_project_id_null_table', 1),
(284, '2019_03_11_132024_seed_front_end_data', 1),
(285, '2019_03_18_1165158_alter_stripe_setting_table', 1),
(286, '2019_03_19_061905_add_google_recaptcha_key_column_global_settings', 1),
(287, '2019_03_19_1265158_paypal_invoice_table', 1),
(288, '2019_04_03_965158_alter_project_deadline_table', 1),
(289, '2019_04_04_074848_alter_invoice_setting_table', 1),
(290, '2019_04_04_075848_alter_client_Details_table', 1),
(291, '2019_04_04_1165158_alter_package_default_table', 1),
(292, '2019_04_10_075848_alter_company_task_table', 1),
(293, '2019_04_17_1165158_create_package_setting_table', 1),
(294, '2019_04_22_075848_alter_package_setting_table', 1),
(295, '2019_06_05_163256_add_timezone_column_global_settings_table', 1),
(296, '2019_06_05_180258_add_locale_column_global_settings_table', 1),
(297, '2019_06_21_100408_add_name_and_email_columns_to_client_details_table', 1),
(298, '2019_07_05_083850_add_company_id_in_client_contacts_table', 1),
(299, '2019_07_09_133247_remove_invoice_unique_index', 1),
(300, '2019_07_16_145850_add_deleted_at_in_estimates_table', 1),
(301, '2019_07_16_145851_add_deleted_at_in_invoices_table', 1),
(302, '2019_07_17_145848_remove_estimate_unique_index', 1),
(303, '2019_07_19_112506_add_project_id_column_in_expenses_table', 1),
(304, '2019_08_05_112511_create_credit_notes_table', 1),
(305, '2019_08_05_112513_create_credit_note_items_table', 1),
(306, '2019_08_06_112518_add_credit_note_column_in_invoices_table', 1),
(307, '2019_08_07_112521_add_columns_in_invoice_settings_table', 1),
(308, '2019_08_13_073129_update_settings_add_envato_key', 1),
(309, '2019_08_13_073129_update_settings_add_support_key', 1),
(310, '2019_08_14_091832_add_item_summary_invoice_items_table', 1),
(311, '2019_08_14_105412_add_item_summary_estimate_items_table', 1),
(312, '2019_08_16_075733_change_price_size_proposal', 1),
(313, '2019_08_22_055908_add_invoice_email_setting_to_email_notification_setting_table', 1),
(314, '2019_08_22_075432_remove_unique_column_name_taskboard', 1),
(315, '2019_08_22_121805_add_external_link_column_project_files_table', 1),
(316, '2019_08_26_120718_add_offline_method_id_column_payments_table', 1),
(317, '2019_08_28_070105_create_project_milestones_table', 1),
(318, '2019_08_28_081847_update_smtp_setting_verified', 1),
(319, '2019_08_28_100242_add_columns_projects_table', 1),
(320, '2019_08_28_101747_add_milestone_id_column_tasks_table', 1),
(321, '2019_08_28_115700_add_budget_columns_projects_table', 1),
(322, '2019_08_28_2083812_add_invoice_created_column_project_milestones_table', 1),
(323, '2019_08_29_140115_make_smtp_type_nullable', 1),
(324, '2019_09_03_021925_add_currency_in_free_trail', 1),
(325, '2019_09_04_115714_add_recurring_task_id_column_in_tasks_table', 1),
(326, '2019_09_09_041914_create_project_settings_table', 1),
(327, '2019_09_09_045042_create_faq_categories_table', 1),
(328, '2019_09_09_045056_create_faqs_table', 1),
(329, '2019_09_09_081030_add_rounded_theme_column', 1),
(330, '2019_09_09_115714_add_cron_job_message_hide_table', 1),
(331, '2019_09_12_061447_add_google_recaptcha_secret_in_global_settings_table', 1),
(332, '2019_09_12_1074848_create_designation_table', 1),
(333, '2019_09_12_115714_add_team_field_employee_table', 1),
(334, '2019_10_01_110039_create_footer_menu_table', 1),
(335, '2019_10_03_110030_add_social_links_column_in_front_details_table', 1),
(336, '2019_10_03_112806_add_week_start_column_in_companies_table', 1),
(337, '2019_10_04_101818_add_paypal_mode_in_payment_gateway_credentials_table', 1),
(338, '2019_10_04_124931_add_week_start_column_gloabl_settings', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `module_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'clients', '', NULL, NULL),
(2, 'employees', '', NULL, NULL),
(3, 'projects', 'User can view the basic details of projects assigned to him even without any permission.', NULL, NULL),
(4, 'attendance', 'User can view his own attendance even without any permission.', NULL, NULL),
(5, 'tasks', 'User can view the tasks assigned to him even without any permission.', NULL, NULL),
(6, 'estimates', '', NULL, NULL),
(7, 'invoices', '', NULL, NULL),
(8, 'payments', '', NULL, NULL),
(9, 'timelogs', '', NULL, NULL),
(10, 'tickets', 'User can view the tickets generated by him as default even without any permission.', NULL, NULL),
(11, 'events', 'User can view the events to be attended by him as default even without any permission.', NULL, NULL),
(12, 'messages', '', NULL, NULL),
(13, 'notices', '', NULL, NULL),
(14, 'leaves', 'User can view the leaves applied by him as default even without any permission.', NULL, NULL),
(15, 'leads', NULL, NULL, NULL),
(16, 'holidays', NULL, '2019-10-27 06:44:36', '2019-10-27 06:44:36'),
(17, 'products', NULL, '2019-10-27 06:44:37', '2019-10-27 06:44:37'),
(18, 'expenses', 'User can view and add(self expenses) the expenses as default even without any permission.', '2019-10-27 06:45:03', '2019-10-27 06:45:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module_settings`
--

CREATE TABLE `module_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `module_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('admin','employee','client') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notices`
--

CREATE TABLE `notices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `heading` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `offline_payment_methods`
--

CREATE TABLE `offline_payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `packages`
--

CREATE TABLE `packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_storage_size` int(10) UNSIGNED DEFAULT NULL,
  `max_file_size` int(10) UNSIGNED DEFAULT NULL,
  `annual_price` decimal(8,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `monthly_price` decimal(8,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `billing_cycle` tinyint(3) UNSIGNED DEFAULT NULL,
  `max_employees` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sort` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_in_package` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_annual_plan_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_monthly_plan_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default` enum('yes','no','trial') COLLATE utf8_unicode_ci DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `packages`
--

INSERT INTO `packages` (`id`, `currency_id`, `name`, `description`, `max_storage_size`, `max_file_size`, `annual_price`, `monthly_price`, `billing_cycle`, `max_employees`, `sort`, `module_in_package`, `stripe_annual_plan_id`, `stripe_monthly_plan_id`, `default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Default', 'Its a default package and cannot be deleted', NULL, NULL, '0.00', '0.00', NULL, 20, NULL, '{\"1\":\"clients\",\"2\":\"employees\",\"3\":\"projects\",\"4\":\"attendance\",\"5\":\"tasks\",\"6\":\"estimates\",\"7\":\"invoices\",\"8\":\"payments\",\"9\":\"timelogs\",\"10\":\"tickets\",\"11\":\"events\",\"12\":\"messages\",\"13\":\"notices\",\"14\":\"leaves\",\"15\":\"leads\",\"16\":\"holidays\",\"17\":\"products\",\"18\":\"expenses\"}', 'default_plan', 'default_plan', 'yes', '2019-10-27 06:46:03', '2019-11-04 01:00:51'),
(2, 1, 'Trial', 'Its a trial package', NULL, NULL, '0.00', '0.00', NULL, 20, NULL, '', 'trial_plan', 'trial_plan', 'trial', '2019-10-27 06:46:04', '2019-10-27 06:46:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `package_settings`
--

CREATE TABLE `package_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `no_of_days` int(11) DEFAULT 30,
  `modules` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notification_before` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `package_settings`
--

INSERT INTO `package_settings` (`id`, `status`, `no_of_days`, `modules`, `notification_before`, `created_at`, `updated_at`) VALUES
(1, 'inactive', 30, NULL, NULL, '2019-10-27 06:46:04', '2019-10-27 06:46:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` double NOT NULL,
  `gateway` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('complete','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'complete',
  `paid_on` datetime DEFAULT NULL,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `offline_method_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_gateway_credentials`
--

CREATE TABLE `payment_gateway_credentials` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `paypal_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `stripe_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_webhook_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `paypal_mode` enum('sandbox','live') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sandbox'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `payment_gateway_credentials`
--

INSERT INTO `payment_gateway_credentials` (`id`, `company_id`, `paypal_client_id`, `paypal_secret`, `paypal_status`, `stripe_client_id`, `stripe_secret`, `stripe_webhook_secret`, `stripe_status`, `created_at`, `updated_at`, `paypal_mode`) VALUES
(1, NULL, NULL, NULL, 'active', NULL, NULL, NULL, 'active', '2019-10-27 06:39:45', '2019-10-27 06:39:45', 'sandbox'),
(2, 1, NULL, NULL, 'active', NULL, NULL, NULL, 'active', '2019-10-27 06:47:06', '2019-10-27 06:47:06', 'sandbox');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paypal_invoices`
--

CREATE TABLE `paypal_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `sub_total` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_frequency` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `paid_on` datetime DEFAULT NULL,
  `next_pay_date` datetime DEFAULT NULL,
  `recurring` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `status` enum('paid','unpaid','pending') COLLATE utf8_unicode_ci DEFAULT 'pending',
  `plan_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_on` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'add_clients', 'Add Clients', NULL, 1, NULL, NULL),
(2, 'view_clients', 'View Clients', NULL, 1, NULL, NULL),
(3, 'edit_clients', 'Edit Clients', NULL, 1, NULL, NULL),
(4, 'delete_clients', 'Delete Clients', NULL, 1, NULL, NULL),
(5, 'add_employees', 'Add Employees', NULL, 2, NULL, NULL),
(6, 'view_employees', 'View Employees', NULL, 2, NULL, NULL),
(7, 'edit_employees', 'Edit Employees', NULL, 2, NULL, NULL),
(8, 'delete_employees', 'Delete Employees', NULL, 2, NULL, NULL),
(9, 'add_projects', 'Add Project', NULL, 3, NULL, NULL),
(10, 'view_projects', 'View Project', NULL, 3, NULL, NULL),
(11, 'edit_projects', 'Edit Project', NULL, 3, NULL, NULL),
(12, 'delete_projects', 'Delete Project', NULL, 3, NULL, NULL),
(13, 'add_attendance', 'Add Attendance', NULL, 4, NULL, NULL),
(14, 'view_attendance', 'View Attendance', NULL, 4, NULL, NULL),
(15, 'add_tasks', 'Add Tasks', NULL, 5, NULL, NULL),
(16, 'view_tasks', 'View Tasks', NULL, 5, NULL, NULL),
(17, 'edit_tasks', 'Edit Tasks', NULL, 5, NULL, NULL),
(18, 'delete_tasks', 'Delete Tasks', NULL, 5, NULL, NULL),
(19, 'add_estimates', 'Add Estimates', NULL, 6, NULL, NULL),
(20, 'view_estimates', 'View Estimates', NULL, 6, NULL, NULL),
(21, 'edit_estimates', 'Edit Estimates', NULL, 6, NULL, NULL),
(22, 'delete_estimates', 'Delete Estimates', NULL, 6, NULL, NULL),
(23, 'add_invoices', 'Add Invoices', NULL, 7, NULL, NULL),
(24, 'view_invoices', 'View Invoices', NULL, 7, NULL, NULL),
(25, 'edit_invoices', 'Edit Invoices', NULL, 7, NULL, NULL),
(26, 'delete_invoices', 'Delete Invoices', NULL, 7, NULL, NULL),
(27, 'add_payments', 'Add Payments', NULL, 8, NULL, NULL),
(28, 'view_payments', 'View Payments', NULL, 8, NULL, NULL),
(29, 'edit_payments', 'Edit Payments', NULL, 8, NULL, NULL),
(30, 'delete_payments', 'Delete Payments', NULL, 8, NULL, NULL),
(31, 'add_timelogs', 'Add Timelogs', NULL, 9, NULL, NULL),
(32, 'view_timelogs', 'View Timelogs', NULL, 9, NULL, NULL),
(33, 'edit_timelogs', 'Edit Timelogs', NULL, 9, NULL, NULL),
(34, 'delete_timelogs', 'Delete Timelogs', NULL, 9, NULL, NULL),
(35, 'add_tickets', 'Add Tickets', NULL, 10, NULL, NULL),
(36, 'view_tickets', 'View Tickets', NULL, 10, NULL, NULL),
(37, 'edit_tickets', 'Edit Tickets', NULL, 10, NULL, NULL),
(38, 'delete_tickets', 'Delete Tickets', NULL, 10, NULL, NULL),
(39, 'add_events', 'Add Events', NULL, 11, NULL, NULL),
(40, 'view_events', 'View Events', NULL, 11, NULL, NULL),
(41, 'edit_events', 'Edit Events', NULL, 11, NULL, NULL),
(42, 'delete_events', 'Delete Events', NULL, 11, NULL, NULL),
(43, 'add_notice', 'Add Notice', NULL, 13, NULL, '2019-10-27 06:45:49'),
(44, 'view_notice', 'View Notice', NULL, 13, NULL, '2019-10-27 06:45:49'),
(45, 'edit_notice', 'Edit Notice', NULL, 13, NULL, '2019-10-27 06:45:49'),
(46, 'delete_notice', 'Delete Notice', NULL, 13, NULL, '2019-10-27 06:45:49'),
(47, 'add_leave', 'Add Leave', NULL, 14, NULL, NULL),
(48, 'view_leave', 'View Leave', NULL, 14, NULL, NULL),
(49, 'edit_leave', 'Edit Leave', NULL, 14, NULL, NULL),
(50, 'delete_leave', 'Delete Leave', NULL, 14, NULL, NULL),
(51, 'add_lead', 'Add Lead', NULL, 15, NULL, NULL),
(52, 'view_lead', 'View Lead', NULL, 15, NULL, NULL),
(53, 'edit_lead', 'Edit Lead', NULL, 15, NULL, NULL),
(54, 'delete_lead', 'Delete Lead', NULL, 15, NULL, NULL),
(55, 'add_holiday', 'Add Holiday', NULL, 16, NULL, NULL),
(56, 'view_holiday', 'View Holiday', NULL, 16, NULL, NULL),
(57, 'edit_holiday', 'Edit Holiday', NULL, 16, NULL, NULL),
(58, 'delete_holiday', 'Delete Holiday', NULL, 16, NULL, NULL),
(59, 'add_product', 'Add Product', NULL, 17, NULL, NULL),
(60, 'view_product', 'View Product', NULL, 17, NULL, NULL),
(61, 'edit_product', 'Edit Product', NULL, 17, NULL, NULL),
(62, 'delete_product', 'Delete Product', NULL, 17, NULL, NULL),
(63, 'add_expenses', 'Add Expenses', NULL, 18, NULL, NULL),
(64, 'view_expenses', 'View Expenses', NULL, 18, NULL, NULL),
(65, 'edit_expenses', 'Edit Expenses', NULL, 18, NULL, NULL),
(66, 'delete_expenses', 'Delete Expenses', NULL, 18, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `project_summary` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_admin` int(10) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `notes` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `feedback` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `manual_timelog` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `client_view_task` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `allow_client_notification` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `completion_percent` tinyint(4) NOT NULL,
  `calculate_task_progress` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'true',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `paused` tinyint(1) NOT NULL,
  `project_budget` double(20,2) DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `hours_allocated` double(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_activity`
--

CREATE TABLE `project_activity` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `activity` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_category`
--

CREATE TABLE `project_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `project_category`
--

INSERT INTO `project_category` (`id`, `company_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Laravel', '2019-10-27 06:47:09', '2019-10-27 06:47:09'),
(2, 1, 'Java', '2019-10-27 06:47:10', '2019-10-27 06:47:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_files`
--

CREATE TABLE `project_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `hashname` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dropbox_link` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `external_link_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_link` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_members`
--

CREATE TABLE `project_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_milestones`
--

CREATE TABLE `project_milestones` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `milestone_title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `summary` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` double(8,2) NOT NULL,
  `status` enum('complete','incomplete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'incomplete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invoice_created` tinyint(1) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_settings`
--

CREATE TABLE `project_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `send_reminder` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `remind_time` int(11) NOT NULL,
  `remind_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remind_to` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '["admins","members"]',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `project_settings`
--

INSERT INTO `project_settings` (`id`, `company_id`, `send_reminder`, `remind_time`, `remind_type`, `remind_to`, `created_at`, `updated_at`) VALUES
(1, 1, 'no', 5, 'days', '[\"admins\",\"members\"]', '2019-10-27 06:47:06', '2019-10-27 06:47:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_templates`
--

CREATE TABLE `project_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `project_summary` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `feedback` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_view_task` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `allow_client_notification` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `manual_timelog` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_template_members`
--

CREATE TABLE `project_template_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_template_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_template_tasks`
--

CREATE TABLE `project_template_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `heading` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_template_id` int(10) UNSIGNED NOT NULL,
  `priority` enum('low','medium','high') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'medium',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_time_logs`
--

CREATE TABLE `project_time_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `task_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `memo` text COLLATE utf8_unicode_ci NOT NULL,
  `total_hours` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_minutes` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `edited_by_user` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proposals`
--

CREATE TABLE `proposals` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `valid_till` date NOT NULL,
  `sub_total` double(16,2) NOT NULL,
  `total` double(16,2) NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('declined','accepted','waiting') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'waiting',
  `note` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `discount_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proposal_items`
--

CREATE TABLE `proposal_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `proposal_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('item','discount','tax') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'item',
  `quantity` double(16,2) NOT NULL,
  `unit_price` double(16,2) NOT NULL,
  `amount` double(16,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `push_notification_settings`
--

CREATE TABLE `push_notification_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `onesignal_app_id` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `onesignal_rest_api_key` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `notification_logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `push_notification_settings`
--

INSERT INTO `push_notification_settings` (`id`, `onesignal_app_id`, `onesignal_rest_api_key`, `notification_logo`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'inactive', '2019-10-27 06:45:11', '2019-10-27 06:45:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `endpoint` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `public_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_token` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quotations`
--

CREATE TABLE `quotations` (
  `id` int(10) UNSIGNED NOT NULL,
  `business_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `client_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `client_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_total` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quotation_items`
--

CREATE TABLE `quotation_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `quotation_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `company_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'App Administrator', 'Admin is allowed to manage everything of the app.', '2019-10-27 06:47:07', '2019-10-27 06:47:07'),
(2, 1, 'employee', 'Employee', 'Employee can see tasks and projects assigned to him.', '2019-10-27 06:47:07', '2019-10-27 06:47:07'),
(3, 1, 'client', 'Client', 'Client can see own tasks and projects.', '2019-10-27 06:47:07', '2019-10-27 06:47:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `skills`
--

CREATE TABLE `skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slack_settings`
--

CREATE TABLE `slack_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `slack_webhook` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `slack_logo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `slack_settings`
--

INSERT INTO `slack_settings` (`id`, `company_id`, `slack_webhook`, `slack_logo`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, '2019-10-27 06:39:52', '2019-10-27 06:39:52'),
(2, 1, NULL, NULL, '2019-10-27 06:47:06', '2019-10-27 06:47:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail_driver` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'smtp',
  `mail_host` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'smtp.gmail.com',
  `mail_port` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '587',
  `mail_username` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'youremail@gmail.com',
  `mail_password` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'your password',
  `mail_from_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'your name',
  `mail_from_email` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'from@email.com',
  `mail_encryption` enum('tls','ssl') COLLATE utf8_unicode_ci DEFAULT 'tls',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_from_name`, `mail_from_email`, `mail_encryption`, `created_at`, `updated_at`, `verified`) VALUES
(1, 'mail', 'smtp.gmail.com', '587', 'myemail@gmail.com', 'mypassword', 'froiden', 'from@email.com', 'tls', '2019-10-27 06:44:38', '2019-10-27 06:44:38', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sticky_notes`
--

CREATE TABLE `sticky_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `note_text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `colour` enum('blue','yellow','red','gray','purple','green') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'blue',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stripe_invoices`
--

CREATE TABLE `stripe_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) UNSIGNED NOT NULL,
  `pay_date` date NOT NULL,
  `next_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stripe_setting`
--

CREATE TABLE `stripe_setting` (
  `id` int(10) UNSIGNED NOT NULL,
  `api_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `webhook_key` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_client_id` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_secret` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `stripe_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `stripe_setting`
--

INSERT INTO `stripe_setting` (`id`, `api_key`, `api_secret`, `webhook_key`, `paypal_client_id`, `paypal_secret`, `paypal_status`, `stripe_status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'inactive', 'inactive', '2019-10-27 06:45:50', '2019-10-27 06:45:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_tasks`
--

CREATE TABLE `sub_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('incomplete','complete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'incomplete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taskboard_columns`
--

CREATE TABLE `taskboard_columns` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `column_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `taskboard_columns`
--

INSERT INTO `taskboard_columns` (`id`, `company_id`, `column_name`, `slug`, `label_color`, `priority`, `created_at`, `updated_at`) VALUES
(3, 1, 'Incomplete', 'incomplete', '#d21010', 1, '2019-10-27 06:47:01', '2019-10-27 06:47:01'),
(4, 1, 'Completed', 'completed', '#679c0d', 2, '2019-10-27 06:47:02', '2019-10-27 06:47:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `heading` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `due_date` date NOT NULL,
  `start_date` date DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `task_category_id` int(10) UNSIGNED DEFAULT NULL,
  `priority` enum('low','medium','high') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('incomplete','completed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'incomplete',
  `board_column_id` int(10) UNSIGNED DEFAULT 1,
  `column_priority` int(11) NOT NULL,
  `completed_on` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `recurring_task_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `milestone_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_category`
--

CREATE TABLE `task_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_comments`
--

CREATE TABLE `task_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taxes`
--

CREATE TABLE `taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `tax_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `rate_percent` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `team_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `panel` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `header_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `sidebar_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `sidebar_text_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `link_color` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#ffffff',
  `user_css` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `company_id`, `panel`, `header_color`, `sidebar_color`, `sidebar_text_color`, `link_color`, `user_css`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', '#ed4040', '#292929', '#cbcbcb', '#ffffff', NULL, '2019-10-27 06:47:05', '2019-10-27 06:47:05'),
(2, 1, 'project_admin', '#5475ed', '#292929', '#cbcbcb', '#ffffff', NULL, '2019-10-27 06:47:06', '2019-10-27 06:47:06'),
(3, 1, 'employee', '#f7c80c', '#292929', '#cbcbcb', '#ffffff', NULL, '2019-10-27 06:47:06', '2019-10-27 06:47:06'),
(4, 1, 'client', '#00c292', '#292929', '#cbcbcb', '#ffffff', NULL, '2019-10-27 06:47:06', '2019-10-27 06:47:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `subject` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('open','pending','resolved','closed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `priority` enum('low','medium','high','urgent') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'medium',
  `agent_id` int(10) UNSIGNED DEFAULT NULL,
  `channel_id` int(10) UNSIGNED DEFAULT NULL,
  `type_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_agent_groups`
--

CREATE TABLE `ticket_agent_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `agent_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('enabled','disabled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_channels`
--

CREATE TABLE `ticket_channels` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `channel_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ticket_channels`
--

INSERT INTO `ticket_channels` (`id`, `company_id`, `channel_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Email', '2019-10-27 06:39:58', '2019-10-27 06:39:58'),
(2, NULL, 'Phone', '2019-10-27 06:39:58', '2019-10-27 06:39:58'),
(3, NULL, 'Twitter', '2019-10-27 06:39:58', '2019-10-27 06:39:58'),
(4, NULL, 'Facebook', '2019-10-27 06:39:59', '2019-10-27 06:39:59'),
(5, 1, 'Email', '2019-10-27 06:47:02', '2019-10-27 06:47:02'),
(6, 1, 'Phone', '2019-10-27 06:47:02', '2019-10-27 06:47:02'),
(7, 1, 'Twitter', '2019-10-27 06:47:02', '2019-10-27 06:47:02'),
(8, 1, 'Facebook', '2019-10-27 06:47:03', '2019-10-27 06:47:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_groups`
--

CREATE TABLE `ticket_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `group_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ticket_groups`
--

INSERT INTO `ticket_groups` (`id`, `company_id`, `group_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Sales', '2019-10-27 06:39:56', '2019-10-27 06:39:56'),
(2, NULL, 'Code', '2019-10-27 06:39:56', '2019-10-27 06:39:56'),
(3, NULL, 'Management', '2019-10-27 06:39:56', '2019-10-27 06:39:56'),
(4, 1, 'Sales', '2019-10-27 06:47:03', '2019-10-27 06:47:03'),
(5, 1, 'Code', '2019-10-27 06:47:03', '2019-10-27 06:47:03'),
(6, 1, 'Management', '2019-10-27 06:47:03', '2019-10-27 06:47:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_reply_templates`
--

CREATE TABLE `ticket_reply_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `reply_heading` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `reply_text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_tags`
--

CREATE TABLE `ticket_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_tag_list`
--

CREATE TABLE `ticket_tag_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_types`
--

CREATE TABLE `ticket_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ticket_types`
--

INSERT INTO `ticket_types` (`id`, `company_id`, `type`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Question', '2019-10-27 06:39:55', '2019-10-27 06:39:55'),
(2, NULL, 'Problem', '2019-10-27 06:39:55', '2019-10-27 06:39:55'),
(3, NULL, 'Incident', '2019-10-27 06:39:56', '2019-10-27 06:39:56'),
(4, NULL, 'Feature Request', '2019-10-27 06:39:56', '2019-10-27 06:39:56'),
(5, 1, 'Question', '2019-10-27 06:47:03', '2019-10-27 06:47:03'),
(6, 1, 'Problem', '2019-10-27 06:47:03', '2019-10-27 06:47:03'),
(7, 1, 'Incident', '2019-10-27 06:47:03', '2019-10-27 06:47:03'),
(8, 1, 'Feature Request', '2019-10-27 06:47:03', '2019-10-27 06:47:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universal_search`
--

CREATE TABLE `universal_search` (
  `id` int(10) UNSIGNED NOT NULL,
  `searchable_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `route_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `universal_search`
--

INSERT INTO `universal_search` (`id`, `searchable_id`, `title`, `route_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin Name', 'admin.employees.show', '2019-10-27 06:47:12', '2019-10-27 06:47:12'),
(2, 2, 'Emory Prohaska', 'admin.employees.show', '2019-10-27 06:47:13', '2019-10-27 06:47:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','others') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `status` enum('active','deactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `login` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enable',
  `onesignal_player_id` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `super_admin` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `email_verification_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `password`, `remember_token`, `image`, `mobile`, `gender`, `locale`, `status`, `login`, `onesignal_player_id`, `created_at`, `updated_at`, `super_admin`, `email_verification_code`) VALUES
(3, NULL, 'Noky', 'noky@noky.cl', '$2y$10$G3WRhDgPQS7rsFMpSYWGzerv89YD9QdL66YL5L6AJsgsYvL3np6Pq', NULL, NULL, NULL, 'male', 'en', 'active', 'enable', NULL, '2019-10-27 06:47:13', '2019-11-04 00:59:41', '1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_chat`
--

CREATE TABLE `users_chat` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_one` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `from` int(10) UNSIGNED DEFAULT NULL,
  `to` int(10) UNSIGNED DEFAULT NULL,
  `message_seen` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `activity` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id_foreign` (`user_id`),
  ADD KEY `attendances_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `attendance_settings`
--
ALTER TABLE `attendance_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `client_contacts`
--
ALTER TABLE `client_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_contacts_user_id_foreign` (`user_id`),
  ADD KEY `client_contacts_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `client_details`
--
ALTER TABLE `client_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_details_user_id_foreign` (`user_id`),
  ADD KEY `client_details_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisation_settings_last_updated_by_foreign` (`last_updated_by`),
  ADD KEY `companies_package_id_foreign` (`package_id`),
  ADD KEY `companies_currency_id_foreign` (`currency_id`);

--
-- Indices de la tabla `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_user_one_foreign` (`user_one`),
  ADD KEY `conversation_user_two_foreign` (`user_two`);

--
-- Indices de la tabla `conversation_reply`
--
ALTER TABLE `conversation_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_reply_conversation_id_foreign` (`conversation_id`),
  ADD KEY `conversation_reply_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_iso_alpha2_index` (`iso_alpha2`),
  ADD KEY `countries_iso_alpha3_index` (`iso_alpha3`);

--
-- Indices de la tabla `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_notes_company_id_foreign` (`company_id`),
  ADD KEY `credit_notes_project_id_foreign` (`project_id`),
  ADD KEY `credit_notes_currency_id_foreign` (`currency_id`);

--
-- Indices de la tabla `credit_note_items`
--
ALTER TABLE `credit_note_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_note_items_credit_note_id_foreign` (`credit_note_id`),
  ADD KEY `credit_note_items_tax_id_foreign` (`tax_id`);

--
-- Indices de la tabla `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currencies_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_fields_custom_field_group_id_foreign` (`custom_field_group_id`);

--
-- Indices de la tabla `custom_fields_data`
--
ALTER TABLE `custom_fields_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_fields_data_custom_field_id_foreign` (`custom_field_id`),
  ADD KEY `custom_fields_data_model_index` (`model`);

--
-- Indices de la tabla `custom_field_groups`
--
ALTER TABLE `custom_field_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_field_groups_model_index` (`model`),
  ADD KEY `custom_field_groups_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `email_notification_settings`
--
ALTER TABLE `email_notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_notification_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_details_slack_username_unique` (`slack_username`),
  ADD KEY `employee_details_user_id_foreign` (`user_id`),
  ADD KEY `employee_details_company_id_foreign` (`company_id`),
  ADD KEY `employee_details_designation_id_foreign` (`designation_id`),
  ADD KEY `employee_details_department_id_foreign` (`department_id`);

--
-- Indices de la tabla `employee_docs`
--
ALTER TABLE `employee_docs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_docs_user_id_foreign` (`user_id`),
  ADD KEY `employee_docs_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `employee_skills`
--
ALTER TABLE `employee_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_skills_user_id_foreign` (`user_id`),
  ADD KEY `employee_skills_skill_id_foreign` (`skill_id`);

--
-- Indices de la tabla `employee_teams`
--
ALTER TABLE `employee_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_teams_team_id_foreign` (`team_id`),
  ADD KEY `employee_teams_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estimates_client_id_foreign` (`client_id`),
  ADD KEY `estimates_currency_id_foreign` (`currency_id`),
  ADD KEY `estimates_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estimate_items_estimate_id_foreign` (`estimate_id`),
  ADD KEY `estimate_items_tax_id_foreign` (`tax_id`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_attendees_user_id_foreign` (`user_id`),
  ADD KEY `event_attendees_event_id_foreign` (`event_id`);

--
-- Indices de la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_currency_id_foreign` (`currency_id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`),
  ADD KEY `expenses_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_faq_category_id_foreign` (`faq_category_id`);

--
-- Indices de la tabla `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `file_storage_settings`
--
ALTER TABLE `file_storage_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_storage_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `footer_menu`
--
ALTER TABLE `footer_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `front_details`
--
ALTER TABLE `front_details`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `global_currencies`
--
ALTER TABLE `global_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `global_settings`
--
ALTER TABLE `global_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `global_settings_last_updated_by_foreign` (`last_updated_by`),
  ADD KEY `global_settings_currency_id_foreign` (`currency_id`);

--
-- Indices de la tabla `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holidays_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_project_id_foreign` (`project_id`),
  ADD KEY `invoices_currency_id_foreign` (`currency_id`),
  ADD KEY `invoices_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_tax_id_foreign` (`tax_id`);

--
-- Indices de la tabla `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issues_user_id_foreign` (`user_id`),
  ADD KEY `issues_project_id_foreign` (`project_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `language_settings`
--
ALTER TABLE `language_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leads_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `lead_files`
--
ALTER TABLE `lead_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_files_lead_id_foreign` (`lead_id`),
  ADD KEY `lead_files_user_id_foreign` (`user_id`),
  ADD KEY `lead_files_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `lead_follow_up`
--
ALTER TABLE `lead_follow_up`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_follow_up_lead_id_foreign` (`lead_id`);

--
-- Indices de la tabla `lead_sources`
--
ALTER TABLE `lead_sources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_sources_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `lead_status`
--
ALTER TABLE `lead_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_status_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_user_id_foreign` (`user_id`),
  ADD KEY `leaves_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `leaves_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_types_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `licences`
--
ALTER TABLE `licences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `licences_company_id_foreign` (`company_id`),
  ADD KEY `licences_package_id_foreign` (`package_id`);

--
-- Indices de la tabla `log_time_for`
--
ALTER TABLE `log_time_for`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_time_for_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `ltm_translations`
--
ALTER TABLE `ltm_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `message_settings`
--
ALTER TABLE `message_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `module_settings`
--
ALTER TABLE `module_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notices_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `offline_payment_methods`
--
ALTER TABLE `offline_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offline_payment_methods_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_currency_id_foreign` (`currency_id`);

--
-- Indices de la tabla `package_settings`
--
ALTER TABLE `package_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD UNIQUE KEY `payments_plan_id_unique` (`plan_id`),
  ADD UNIQUE KEY `payments_event_id_unique` (`event_id`),
  ADD KEY `payments_currency_id_foreign` (`currency_id`),
  ADD KEY `payments_project_id_foreign` (`project_id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `payments_company_id_foreign` (`company_id`),
  ADD KEY `payments_offline_method_id_foreign` (`offline_method_id`);

--
-- Indices de la tabla `payment_gateway_credentials`
--
ALTER TABLE `payment_gateway_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_gateway_credentials_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `paypal_invoices`
--
ALTER TABLE `paypal_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paypal_invoices_company_id_foreign` (`company_id`),
  ADD KEY `paypal_invoices_currency_id_foreign` (`currency_id`),
  ADD KEY `paypal_invoices_package_id_foreign` (`package_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD KEY `permissions_module_id_foreign` (`module_id`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_tax_id_foreign` (`tax_id`),
  ADD KEY `products_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_category_id_foreign` (`category_id`),
  ADD KEY `projects_client_id_foreign` (`client_id`),
  ADD KEY `projects_project_admin_foreign` (`project_admin`),
  ADD KEY `projects_company_id_foreign` (`company_id`),
  ADD KEY `projects_currency_id_foreign` (`currency_id`);

--
-- Indices de la tabla `project_activity`
--
ALTER TABLE `project_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_activity_project_id_foreign` (`project_id`),
  ADD KEY `project_activity_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `project_category`
--
ALTER TABLE `project_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_category_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_files_user_id_foreign` (`user_id`),
  ADD KEY `project_files_project_id_foreign` (`project_id`),
  ADD KEY `project_files_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_members_project_id_foreign` (`project_id`),
  ADD KEY `project_members_user_id_foreign` (`user_id`),
  ADD KEY `project_members_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `project_milestones`
--
ALTER TABLE `project_milestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_milestones_company_id_foreign` (`company_id`),
  ADD KEY `project_milestones_project_id_foreign` (`project_id`),
  ADD KEY `project_milestones_currency_id_foreign` (`currency_id`);

--
-- Indices de la tabla `project_settings`
--
ALTER TABLE `project_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `project_templates`
--
ALTER TABLE `project_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_templates_category_id_foreign` (`category_id`),
  ADD KEY `project_templates_client_id_foreign` (`client_id`),
  ADD KEY `project_templates_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `project_template_members`
--
ALTER TABLE `project_template_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_template_members_user_id_foreign` (`user_id`),
  ADD KEY `project_template_members_project_template_id_foreign` (`project_template_id`);

--
-- Indices de la tabla `project_template_tasks`
--
ALTER TABLE `project_template_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_template_tasks_user_id_foreign` (`user_id`),
  ADD KEY `project_template_tasks_project_template_id_foreign` (`project_template_id`);

--
-- Indices de la tabla `project_time_logs`
--
ALTER TABLE `project_time_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_time_logs_edited_by_user_foreign` (`edited_by_user`),
  ADD KEY `project_time_logs_project_id_foreign` (`project_id`),
  ADD KEY `project_time_logs_user_id_foreign` (`user_id`),
  ADD KEY `project_time_logs_task_id_foreign` (`task_id`),
  ADD KEY `project_time_logs_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposals_lead_id_foreign` (`lead_id`),
  ADD KEY `proposals_currency_id_foreign` (`currency_id`),
  ADD KEY `proposals_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `proposal_items`
--
ALTER TABLE `proposal_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_items_proposal_id_foreign` (`proposal_id`),
  ADD KEY `proposal_items_tax_id_foreign` (`tax_id`);

--
-- Indices de la tabla `push_notification_settings`
--
ALTER TABLE `push_notification_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  ADD KEY `push_subscriptions_user_id_index` (`user_id`);

--
-- Indices de la tabla `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_items_quotation_id_foreign` (`quotation_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `slack_settings`
--
ALTER TABLE `slack_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slack_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sticky_notes`
--
ALTER TABLE `sticky_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sticky_notes_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `stripe_invoices`
--
ALTER TABLE `stripe_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stripe_invoices_company_id_foreign` (`company_id`),
  ADD KEY `stripe_invoices_package_id_foreign` (`package_id`);

--
-- Indices de la tabla `stripe_setting`
--
ALTER TABLE `stripe_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sub_tasks`
--
ALTER TABLE `sub_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_tasks_task_id_foreign` (`task_id`);

--
-- Indices de la tabla `taskboard_columns`
--
ALTER TABLE `taskboard_columns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taskboard_columns_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`),
  ADD KEY `tasks_project_id_foreign` (`project_id`),
  ADD KEY `tasks_board_column_id_foreign` (`board_column_id`),
  ADD KEY `tasks_company_id_foreign` (`company_id`),
  ADD KEY `tasks_task_category_id_foreign` (`task_category_id`),
  ADD KEY `tasks_created_by_foreign` (`created_by`),
  ADD KEY `tasks_milestone_id_foreign` (`milestone_id`),
  ADD KEY `tasks_recurring_task_id_foreign` (`recurring_task_id`);

--
-- Indices de la tabla `task_category`
--
ALTER TABLE `task_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_category_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_comments_user_id_foreign` (`user_id`),
  ADD KEY `task_comments_task_id_foreign` (`task_id`);

--
-- Indices de la tabla `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxes_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_settings_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`),
  ADD KEY `tickets_agent_id_foreign` (`agent_id`),
  ADD KEY `tickets_channel_id_foreign` (`channel_id`),
  ADD KEY `tickets_type_id_foreign` (`type_id`),
  ADD KEY `tickets_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `ticket_agent_groups`
--
ALTER TABLE `ticket_agent_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_agent_groups_agent_id_foreign` (`agent_id`),
  ADD KEY `ticket_agent_groups_group_id_foreign` (`group_id`),
  ADD KEY `ticket_agent_groups_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `ticket_channels`
--
ALTER TABLE `ticket_channels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_channels_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `ticket_groups`
--
ALTER TABLE `ticket_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_groups_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_replies_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_replies_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `ticket_reply_templates`
--
ALTER TABLE `ticket_reply_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_reply_templates_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `ticket_tags`
--
ALTER TABLE `ticket_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_tags_tag_id_foreign` (`tag_id`),
  ADD KEY `ticket_tags_ticket_id_foreign` (`ticket_id`);

--
-- Indices de la tabla `ticket_tag_list`
--
ALTER TABLE `ticket_tag_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_types_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `universal_search`
--
ALTER TABLE `universal_search`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `users_chat`
--
ALTER TABLE `users_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_chat_user_one_foreign` (`user_one`),
  ADD KEY `users_chat_user_id_foreign` (`user_id`),
  ADD KEY `users_chat_from_foreign` (`from`),
  ADD KEY `users_chat_to_foreign` (`to`);

--
-- Indices de la tabla `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activities_user_id_foreign` (`user_id`),
  ADD KEY `user_activities_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `attendance_settings`
--
ALTER TABLE `attendance_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `client_contacts`
--
ALTER TABLE `client_contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `client_details`
--
ALTER TABLE `client_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conversation_reply`
--
ALTER TABLE `conversation_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT de la tabla `credit_notes`
--
ALTER TABLE `credit_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `credit_note_items`
--
ALTER TABLE `credit_note_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `custom_fields_data`
--
ALTER TABLE `custom_fields_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `custom_field_groups`
--
ALTER TABLE `custom_field_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `email_notification_settings`
--
ALTER TABLE `email_notification_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `employee_docs`
--
ALTER TABLE `employee_docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `employee_skills`
--
ALTER TABLE `employee_skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `employee_teams`
--
ALTER TABLE `employee_teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estimates`
--
ALTER TABLE `estimates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estimate_items`
--
ALTER TABLE `estimate_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `event_attendees`
--
ALTER TABLE `event_attendees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `features`
--
ALTER TABLE `features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `file_storage_settings`
--
ALTER TABLE `file_storage_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `footer_menu`
--
ALTER TABLE `footer_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `front_details`
--
ALTER TABLE `front_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `global_currencies`
--
ALTER TABLE `global_currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `global_settings`
--
ALTER TABLE `global_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invoice_settings`
--
ALTER TABLE `invoice_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `language_settings`
--
ALTER TABLE `language_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lead_files`
--
ALTER TABLE `lead_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lead_follow_up`
--
ALTER TABLE `lead_follow_up`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lead_sources`
--
ALTER TABLE `lead_sources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `lead_status`
--
ALTER TABLE `lead_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `licences`
--
ALTER TABLE `licences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log_time_for`
--
ALTER TABLE `log_time_for`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ltm_translations`
--
ALTER TABLE `ltm_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2414;

--
-- AUTO_INCREMENT de la tabla `message_settings`
--
ALTER TABLE `message_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT de la tabla `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `module_settings`
--
ALTER TABLE `module_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `offline_payment_methods`
--
ALTER TABLE `offline_payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `package_settings`
--
ALTER TABLE `package_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payment_gateway_credentials`
--
ALTER TABLE `payment_gateway_credentials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `paypal_invoices`
--
ALTER TABLE `paypal_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_activity`
--
ALTER TABLE `project_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_category`
--
ALTER TABLE `project_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_members`
--
ALTER TABLE `project_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_milestones`
--
ALTER TABLE `project_milestones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_settings`
--
ALTER TABLE `project_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `project_templates`
--
ALTER TABLE `project_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_template_members`
--
ALTER TABLE `project_template_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_template_tasks`
--
ALTER TABLE `project_template_tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project_time_logs`
--
ALTER TABLE `project_time_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proposal_items`
--
ALTER TABLE `proposal_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `push_notification_settings`
--
ALTER TABLE `push_notification_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
