-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 15, 2025 at 11:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hasta`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `userID` bigint(20) NOT NULL,
  `adminDept` enum('finance','IT') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blacklistedcust`
--

CREATE TABLE `blacklistedcust` (
  `blacklistID` bigint(11) NOT NULL,
  `customerUID` bigint(11) NOT NULL,
  `reason` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookingID` int(11) NOT NULL,
  `userID` bigint(20) DEFAULT NULL,
  `vehicleID` int(11) DEFAULT NULL,
  `pickup_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookingID`, `userID`, `vehicleID`, `pickup_date`, `return_date`, `total_price`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 6, 3, '2025-12-17', '2025-12-20', 320.00, 'pending', NULL, '2025-12-15 08:39:02', '2025-12-15 08:39:02'),
(2, 6, 1, '2025-12-17', '2025-12-18', 90.00, 'pending', NULL, '2025-12-15 08:39:36', '2025-12-15 08:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
  `commissionID` bigint(20) NOT NULL,
  `commissionType` varchar(50) NOT NULL,
  `status` enum('pending','rejected','approved') NOT NULL,
  `amount` double NOT NULL,
  `staffID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `referralCode` varchar(20) NOT NULL,
  `accountNumber` varchar(20) NOT NULL,
  `bankType` enum('Maybank','CIMB','Public Bank','RHB','Hong Leong Bank','Ambank','HSBC Malaysia','OCBC Malaysia','Bank Rakyat','Bank Islam','Affin Bank','Alliance Bank','BSN') NOT NULL,
  `customerType` enum('student','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `userID`, `referralCode`, `accountNumber`, `bankType`, `customerType`) VALUES
(1, 5, '', '957388028', 'Alliance Bank', 'student'),
(2, 6, '', '957388023', 'Public Bank', 'student'),
(3, 7, '', '957388033', 'Alliance Bank', 'student'),
(4, 8, '', '9573880281', 'Affin Bank', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `damage_case`
--

CREATE TABLE `damage_case` (
  `caseID` bigint(20) NOT NULL,
  `caseType` varchar(50) NOT NULL,
  `filledBy` bigint(20) NOT NULL,
  `resolutionStatus` varchar(50) NOT NULL,
  `inspectionID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `facultyID` bigint(20) NOT NULL,
  `facultyName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackID` bigint(20) NOT NULL,
  `rate` int(11) NOT NULL,
  `reviewSentences` varchar(255) NOT NULL,
  `customerID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection`
--

CREATE TABLE `inspection` (
  `inspectionID` int(11) NOT NULL,
  `date` date NOT NULL,
  `carCondition` varchar(50) NOT NULL,
  `mileageReturned` int(50) NOT NULL,
  `fuelLevel` int(50) NOT NULL,
  `damageDetected` tinyint(1) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `evidence` varchar(255) NOT NULL,
  `adminID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loyaltycard`
--

CREATE TABLE `loyaltycard` (
  `cardID` bigint(20) NOT NULL,
  `currentStamp` int(11) NOT NULL,
  `totalStamp` int(11) NOT NULL,
  `redeemedStamp` int(11) NOT NULL,
  `referralCode` varchar(255) NOT NULL,
  `customerID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` bigint(20) NOT NULL,
  `paymentType` enum('full payment','deposit') NOT NULL,
  `ampunt` double NOT NULL,
  `receipt_file_path` varchar(255) NOT NULL,
  `paymentStatus` enum('approved','pending','rejected') NOT NULL,
  `verifiedBy` bigint(20) NOT NULL,
  `verifiedTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bookingID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('U2tajkQOqeVtMrx4xMwqQN58xsw0bdVrm9amK2Ou', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGxLUkJYMXlxd0xwb0Q4dHJocnFuSFRJakw0eW8yVHl6cUg1bDVSZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1765835447),
('xN3ht5Knkdi9NV04msBXxl77aaRa2agelkJuztl8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOEhieVpYZk5zdDhaanMzQ3daM2g2cU43d2sxd3NLSmd6bWhVM3pMNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImRhc2hib2FyZC5pbmRleCI7fX0=', 1765818840);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `userID` bigint(20) NOT NULL,
  `staffRole` enum('salesperson','runner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffcustomer`
--

CREATE TABLE `staffcustomer` (
  `id` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `staffNo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffcustomer`
--

INSERT INTO `staffcustomer` (`id`, `userID`, `staffNo`) VALUES
(1, 8, '004');

-- --------------------------------------------------------

--
-- Table structure for table `studentcustomer`
--

CREATE TABLE `studentcustomer` (
  `id` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `matricNo` varchar(10) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `residentialCollege` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentcustomer`
--

INSERT INTO `studentcustomer` (`id`, `userID`, `matricNo`, `faculty`, `residentialCollege`) VALUES
(1, 5, 'a2343ss', 'Faculty of Science', 'KTDI'),
(2, 6, 'a2343s4', 'Faculty of Computing', 'KTF'),
(3, 7, 'a24cs1111', 'Faculty of Medicine', 'KTHO');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` bigint(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `noHP` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `noIC` varchar(12) NOT NULL,
  `userType` enum('customer','admin','staff','') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `password`, `name`, `noHP`, `email`, `noIC`, `userType`, `remember_token`) VALUES
(5, '$2y$12$8xl52rCyRr8BlqpHeY4dYuk5Uskf4XW24kb3GvMtJ1XLIZoDo6gcC', 'john cena', '12', 'cjohn@gmail.com', '040323110109', 'customer', NULL),
(6, '$2y$12$3mYH0Ig2tE3E2g7eXerGeeF62nOKwEFELxaV/8Xnq.4beg6fnjDW6', 'syahla', '122', 'elly@gmail.com', '040323110103', 'customer', 'FAgbw4KEC4dU55qv4lwUejPdpbqcZwq3t6imkjT9JNfIK5uandLUCPrXdsME'),
(7, '$2y$12$u1y2wD5WWBnEg7Nfdlu8Nu1y5XjHOh2SDuKs1JE8ZTY.guc/9RLRW', 'lalilsa', '1234567899', 'lil@gmi.com', '040323110101', 'customer', NULL),
(8, '$2y$12$CaN1J/cQEMxy4F1tCvoDZOOCmNUwG9INxafUPrlOR3cWad7VVsV8e', 'lela', '123456789', 'lela@gmail.com', '030121172211', 'customer', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicleID` int(11) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `image_url` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicleID`, `brand`, `model`, `year`, `type`, `seats`, `price_per_day`, `available`, `image_url`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Toyota', 'Camry', 2022, 'Sedan', 5, 45.00, 1, NULL, 'Comfortable sedan with great fuel economy', '2025-12-15 16:20:01', '2025-12-15 16:20:01'),
(2, 'Honda', 'CR-V', 2023, 'SUV', 5, 65.00, 1, NULL, 'Spacious SUV with advanced safety features', '2025-12-15 16:20:01', '2025-12-15 16:20:01'),
(3, 'Ford', 'Explorer', 2022, 'SUV', 7, 80.00, 1, NULL, 'Large family SUV with 7 seats', '2025-12-15 16:20:01', '2025-12-15 16:20:01'),
(4, 'BMW', 'X5', 2023, 'Luxury SUV', 5, 120.00, 1, NULL, 'Premium luxury SUV with all features', '2025-12-15 16:20:01', '2025-12-15 16:20:01'),
(5, 'Mercedes', 'C-Class', 2023, 'Luxury Sedan', 5, 110.00, 1, NULL, 'Executive sedan with luxury interior', '2025-12-15 16:20:01', '2025-12-15 16:20:01'),
(6, 'Toyota', 'Hiace', 2021, 'Van', 12, 90.00, 1, NULL, 'Commercial van for group travel', '2025-12-15 16:20:01', '2025-12-15 16:20:01'),
(7, 'Hyundai', 'i10', 2022, 'Compact', 4, 35.00, 1, NULL, 'Economical city car', '2025-12-15 16:20:01', '2025-12-15 16:20:01'),
(8, 'Mazda', 'CX-5', 2023, 'SUV', 5, 70.00, 1, NULL, 'Sporty SUV with great handling', '2025-12-15 16:20:01', '2025-12-15 16:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `verificationdocs`
--

CREATE TABLE `verificationdocs` (
  `documentID` int(11) NOT NULL,
  `reviewedBy` bigint(20) NOT NULL,
  `reviewStatus` enum('pending','approved','rejected') NOT NULL,
  `ic_file_path` varchar(50) NOT NULL,
  `matric_file_path` varchar(50) NOT NULL,
  `license_file_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `voucherCode` varchar(255) NOT NULL,
  `voucherTypeID` int(11) NOT NULL,
  `expiryDate` date NOT NULL,
  `voucherLimit` int(11) NOT NULL,
  `status` enum('pending','active','expired') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `blacklistedcust`
--
ALTER TABLE `blacklistedcust`
  ADD PRIMARY KEY (`blacklistID`),
  ADD KEY `customerUID` (`customerUID`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `vehicleID` (`vehicleID`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`commissionID`),
  ADD KEY `staffID` (`staffID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_case`
--
ALTER TABLE `damage_case`
  ADD PRIMARY KEY (`caseID`),
  ADD KEY `filledBy` (`filledBy`,`inspectionID`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`facultyID`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackID`),
  ADD KEY `feedback-cust` (`customerID`);

--
-- Indexes for table `inspection`
--
ALTER TABLE `inspection`
  ADD KEY `inspect-admin` (`adminID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loyaltycard`
--
ALTER TABLE `loyaltycard`
  ADD PRIMARY KEY (`cardID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `bookingID` (`bookingID`),
  ADD KEY `verifiedBy` (`verifiedBy`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `staffcustomer`
--
ALTER TABLE `staffcustomer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentcustomer`
--
ALTER TABLE `studentcustomer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicleID`);

--
-- Indexes for table `verificationdocs`
--
ALTER TABLE `verificationdocs`
  ADD PRIMARY KEY (`documentID`),
  ADD KEY `reviewedBy` (`reviewedBy`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucherCode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blacklistedcust`
--
ALTER TABLE `blacklistedcust`
  MODIFY `blacklistID` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commission`
--
ALTER TABLE `commission`
  MODIFY `commissionID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `damage_case`
--
ALTER TABLE `damage_case`
  MODIFY `caseID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `facultyID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loyaltycard`
--
ALTER TABLE `loyaltycard`
  MODIFY `cardID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffcustomer`
--
ALTER TABLE `staffcustomer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `studentcustomer`
--
ALTER TABLE `studentcustomer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blacklistedcust`
--
ALTER TABLE `blacklistedcust`
  ADD CONSTRAINT `blacklist-cust` FOREIGN KEY (`customerUID`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`vehicleID`) REFERENCES `vehicles` (`vehicleID`);

--
-- Constraints for table `commission`
--
ALTER TABLE `commission`
  ADD CONSTRAINT `commission-staff` FOREIGN KEY (`staffID`) REFERENCES `staff` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `damage_case`
--
ALTER TABLE `damage_case`
  ADD CONSTRAINT `case-runner` FOREIGN KEY (`filledBy`) REFERENCES `staff` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback-cust` FOREIGN KEY (`customerID`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inspection`
--
ALTER TABLE `inspection`
  ADD CONSTRAINT `inspect-admin` FOREIGN KEY (`adminID`) REFERENCES `admin` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `loyaltycard`
--
ALTER TABLE `loyaltycard`
  ADD CONSTRAINT `loyalty-cust` FOREIGN KEY (`customerID`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `booking-payment` FOREIGN KEY (`bookingID`) REFERENCES `bookings` (`bookingID`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff-payment` FOREIGN KEY (`verifiedBy`) REFERENCES `staff` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `user-staff` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `verificationdocs`
--
ALTER TABLE `verificationdocs`
  ADD CONSTRAINT `doc-staff` FOREIGN KEY (`reviewedBy`) REFERENCES `staff` (`userID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
