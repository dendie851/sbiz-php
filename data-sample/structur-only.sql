/*
 Navicat Premium Data Transfer

 Source Server         : Localhost - MySQL
 Source Server Type    : MySQL
 Source Server Version : 100419
 Source Host           : localhost:3306
 Source Schema         : fahrian_new_product

 Target Server Type    : MySQL
 Target Server Version : 100419
 File Encoding         : 65001

 Date: 14/10/2026 12:55:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for affiliate
-- ----------------------------
DROP TABLE IF EXISTS `affiliate`;
CREATE TABLE `affiliate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `country_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `city` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fee_affilate_nominal` double NOT NULL,
  `fee_affilate_percent` double NOT NULL,
  `date_input` datetime(0) NULL DEFAULT NULL,
  `last_login` datetime(0) NOT NULL,
  `is_active` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=not active,1=active',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=not delete,1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 19 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for affiliate_bank
-- ----------------------------
DROP TABLE IF EXISTS `affiliate_bank`;
CREATE TABLE `affiliate_bank`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) NULL DEFAULT NULL,
  `bank_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `reseller_id_uniq`(`affiliate_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for affiliate_point_claim
-- ----------------------------
DROP TABLE IF EXISTS `affiliate_point_claim`;
CREATE TABLE `affiliate_point_claim`  (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) NOT NULL,
  `reward_id` int(20) NOT NULL,
  `no_point_claim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `points_spent` int(11) NOT NULL,
  `points_price_reward` int(11) NULL DEFAULT NULL,
  `status_claim` enum('0','1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '0=Pending, 1=di setujui, 2=proses penyerahan reward, 3=selesai, 4=di tolak',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_request` date NULL DEFAULT NULL,
  `date_approve` date NULL DEFAULT NULL,
  `date_process` date NULL DEFAULT NULL,
  `date_complete` date NULL DEFAULT NULL,
  `date_reject` date NULL DEFAULT NULL,
  `is_delete` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '0=not delete,1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for affiliate_setting
-- ----------------------------
DROP TABLE IF EXISTS `affiliate_setting`;
CREATE TABLE `affiliate_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `value` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '1' COMMENT '0=not active, 1=active',
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=dapat di delete, 1=tidak dapat di delete',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `reseller_id_uniq`(`name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for affiliate_stuff
-- ----------------------------
DROP TABLE IF EXISTS `affiliate_stuff`;
CREATE TABLE `affiliate_stuff`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) NOT NULL,
  `stuff_id` int(11) NOT NULL,
  `link_product_brosur` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `price_basic` decimal(11, 0) NOT NULL,
  `fee_affiliate_nominal` double NOT NULL,
  `fee_affiliate_percent` double NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not delete 1=delete',
  `point` double NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 161 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for affiliate_withdraw_fee
-- ----------------------------
DROP TABLE IF EXISTS `affiliate_withdraw_fee`;
CREATE TABLE `affiliate_withdraw_fee`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) NULL DEFAULT NULL,
  `affiliate_bank_id` int(11) NOT NULL,
  `no_payment` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `from_bank` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_withdraw` double NOT NULL,
  `date_transfer` date NOT NULL,
  `date_input` datetime(0) NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete, 1= delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 27 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for affiliate_withdraw_fee_detail
-- ----------------------------
DROP TABLE IF EXISTS `affiliate_withdraw_fee_detail`;
CREATE TABLE `affiliate_withdraw_fee_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_withdraw_fee_id` int(11) NOT NULL,
  `sales_order_id` int(11) NULL DEFAULT NULL,
  `sales_order_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `amount_fee_affiliate` double(255, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 34 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for client
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `messanger` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` date NOT NULL,
  `address` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0= can be delete, 1= not delete',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=no delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 15 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `address` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for const
-- ----------------------------
DROP TABLE IF EXISTS `const`;
CREATE TABLE `const`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` enum('1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1' COMMENT '1= Metric 2=Location',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0 = not delete, 1 = delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 42 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `country_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `city` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_input` datetime(0) NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=not delete,1=delete',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `phone_number`(`country_code`, `phone_number`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for customer_group
-- ----------------------------
DROP TABLE IF EXISTS `customer_group`;
CREATE TABLE `customer_group`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for district
-- ----------------------------
DROP TABLE IF EXISTS `district`;
CREATE TABLE `district`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `city` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `province` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7485 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for expedition
-- ----------------------------
DROP TABLE IF EXISTS `expedition`;
CREATE TABLE `expedition`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0= can be delete, 1= not delete',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=no delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 54 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fin_equitas
-- ----------------------------
DROP TABLE IF EXISTS `fin_equitas`;
CREATE TABLE `fin_equitas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fin_profit_loss_id` int(11) NOT NULL COMMENT 'field untuk mendeksi data yg berasl dari tabel fin_profit_loss',
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipe` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=out,1=in',
  `nominal` int(11) NOT NULL,
  `date_transaction` date NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=not delete,1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fin_expenses_revenue
-- ----------------------------
DROP TABLE IF EXISTS `fin_expenses_revenue`;
CREATE TABLE `fin_expenses_revenue`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nominal` int(11) NOT NULL DEFAULT 0,
  `type` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=expenses,1=revenue',
  `periode` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=harian, 1=bulanan',
  `is_show_report_convertion_adds` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=tidak sertakan di, 1=di sertakan',
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not fix 1=fix',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delet, 1=deleted',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 86 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fin_pay_expenses
-- ----------------------------
DROP TABLE IF EXISTS `fin_pay_expenses`;
CREATE TABLE `fin_pay_expenses`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fin_expenses_revenue_id` int(11) NOT NULL,
  `fin_source_fund_id` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nominal` double NOT NULL,
  `periode` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=harian, 1=bulanan',
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_transaction` date NOT NULL,
  `date_system` datetime(0) NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 781 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fin_profit_loss
-- ----------------------------
DROP TABLE IF EXISTS `fin_profit_loss`;
CREATE TABLE `fin_profit_loss`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `total_expenses` int(11) NOT NULL,
  `total_revenue` int(11) NOT NULL,
  `profit` int(11) NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=no deleter, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 22 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fin_profit_loss_detail
-- ----------------------------
DROP TABLE IF EXISTS `fin_profit_loss_detail`;
CREATE TABLE `fin_profit_loss_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fin_profit_loss_id` int(11) NOT NULL,
  `fin_expenses_revenue_id` int(11) NOT NULL,
  `type` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=expenses, 1=revenue',
  `periode` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=harian, 1=bulanan',
  `nominal` int(11) NOT NULL,
  `description` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 95 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fin_source_fund
-- ----------------------------
DROP TABLE IF EXISTS `fin_source_fund`;
CREATE TABLE `fin_source_fund`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `account_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for location
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0= can be delete, 1= not delete',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=no delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `position_id` int(11) NOT NULL,
  `access_category_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_enabled` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 111 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mutation_bank
-- ----------------------------
DROP TABLE IF EXISTS `mutation_bank`;
CREATE TABLE `mutation_bank`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `date` datetime(0) NULL DEFAULT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `balance` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `mutation_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 303 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for period_order
-- ----------------------------
DROP TABLE IF EXISTS `period_order`;
CREATE TABLE `period_order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `is_status` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=open periode, 1=close periode',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=no delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for platform_market
-- ----------------------------
DROP TABLE IF EXISTS `platform_market`;
CREATE TABLE `platform_market`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fee_admin_percent` double(11, 0) NULL DEFAULT NULL,
  `is_marketplace` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not marketplace, 1=marketplace',
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0= can be delete, 1= not delete',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=no delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for position
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `privilage` char(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for postcal_code
-- ----------------------------
DROP TABLE IF EXISTS `postcal_code`;
CREATE TABLE `postcal_code`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `province_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `city_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `disctrict_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `subdistrict_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `zip_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tarif_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 82808 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for promotion_calendar
-- ----------------------------
DROP TABLE IF EXISTS `promotion_calendar`;
CREATE TABLE `promotion_calendar`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_transaction` date NOT NULL,
  `date_system` datetime(0) NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 373 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for promotion_calendar_platform_market
-- ----------------------------
DROP TABLE IF EXISTS `promotion_calendar_platform_market`;
CREATE TABLE `promotion_calendar_platform_market`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_calender_id` int(11) NOT NULL,
  `platform_market_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 409 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reseller
-- ----------------------------
DROP TABLE IF EXISTS `reseller`;
CREATE TABLE `reseller`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `country_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `city` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fee_reseller_nominal` double NOT NULL,
  `fee_reseller_percent` double NOT NULL,
  `date_input` datetime(0) NOT NULL,
  `last_login` datetime(0) NOT NULL,
  `is_dropshipper` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=not active,1=active',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=not delete,1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reseller_bank
-- ----------------------------
DROP TABLE IF EXISTS `reseller_bank`;
CREATE TABLE `reseller_bank`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reseller_id` int(11) NULL DEFAULT NULL,
  `bank_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `reseller_id_uniq`(`reseller_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reseller_information
-- ----------------------------
DROP TABLE IF EXISTS `reseller_information`;
CREATE TABLE `reseller_information`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for reseller_stuff
-- ----------------------------
DROP TABLE IF EXISTS `reseller_stuff`;
CREATE TABLE `reseller_stuff`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reseller_id` int(11) NOT NULL,
  `stuff_id` int(11) NOT NULL,
  `link_product_brosur` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `price_basic` decimal(11, 0) NOT NULL,
  `fee_reseller_nominal` double NOT NULL,
  `fee_reseller_percent` double NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not delete 1=delete',
  `point` double NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 143 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reseller_withdraw_cod
-- ----------------------------
DROP TABLE IF EXISTS `reseller_withdraw_cod`;
CREATE TABLE `reseller_withdraw_cod`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reseller_id` int(11) NULL DEFAULT NULL,
  `reseller_bank_id` int(11) NOT NULL,
  `no_payment` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `from_bank` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_withdraw` double NOT NULL,
  `date_transfer` date NOT NULL,
  `date_input` datetime(0) NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete, 1= delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 27 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reseller_withdraw_cod_detail
-- ----------------------------
DROP TABLE IF EXISTS `reseller_withdraw_cod_detail`;
CREATE TABLE `reseller_withdraw_cod_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reseller_withdraw_cod_id` int(11) NOT NULL,
  `sales_order_id` int(11) NULL DEFAULT NULL,
  `sales_order_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `amount_cod_reseller` double(255, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 37 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reseller_withdraw_fee
-- ----------------------------
DROP TABLE IF EXISTS `reseller_withdraw_fee`;
CREATE TABLE `reseller_withdraw_fee`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reseller_id` int(11) NULL DEFAULT NULL,
  `reseller_bank_id` int(11) NOT NULL,
  `no_payment` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `from_bank` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_withdraw` double NOT NULL,
  `date_transfer` date NOT NULL,
  `date_input` datetime(0) NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete, 1= delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 19 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reseller_withdraw_fee_detail
-- ----------------------------
DROP TABLE IF EXISTS `reseller_withdraw_fee_detail`;
CREATE TABLE `reseller_withdraw_fee_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reseller_withdraw_fee_id` int(11) NOT NULL,
  `sales_order_id` int(11) NULL DEFAULT NULL,
  `sales_order_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `amount_fee_reseller` double(255, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 26 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reward
-- ----------------------------
DROP TABLE IF EXISTS `reward`;
CREATE TABLE `reward`  (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `points_required` int(11) NOT NULL,
  `daily_stock` int(11) NULL DEFAULT 0,
  `is_active` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1' COMMENT '0=not active 1=active',
  `is_delete` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '0=not delete 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sales_order
-- ----------------------------
DROP TABLE IF EXISTS `sales_order`;
CREATE TABLE `sales_order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `reseller_id` int(11) NOT NULL,
  `affiliate_id` int(11) NOT NULL,
  `expedition_id` int(11) NOT NULL,
  `period_order_id` int(11) NOT NULL,
  `warehouse_external_id` int(11) NULL DEFAULT NULL,
  `fin_source_fund_id` int(11) NULL DEFAULT NULL,
  `disctrict_id` int(11) NULL DEFAULT NULL,
  `platform_market_id` int(11) NULL DEFAULT NULL,
  `no_order` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dropshipper_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dropshipper_phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `address_shipping` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dropshipper_address` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `tipe_order` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=direct order,1=preorder',
  `description_payment` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description_shipping` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `discount_persen` double NOT NULL,
  `discount_amount` decimal(10, 0) NOT NULL,
  `amount_sale` int(11) NOT NULL,
  `amount_basic_sale` int(11) NOT NULL,
  `amount_fee_reseller` double(11, 0) NULL DEFAULT NULL,
  `amount_fee_affiliate` double(11, 0) NULL DEFAULT NULL,
  `amount_reseller_to_customer` double(11, 0) NULL DEFAULT NULL,
  `shipping_cost` double(11, 0) NOT NULL,
  `shipping_cost_before_discount` double(11, 0) NULL DEFAULT NULL,
  `shipping_cost_discount` double(11, 0) NULL DEFAULT NULL,
  `platform_market_fee_percent` double(11, 0) NULL DEFAULT NULL,
  `fee_admin_percent` double(11, 0) NULL DEFAULT NULL,
  `no_resi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `marketplace` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `country` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `province` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `city` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `districts` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `districts_sub` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `postal_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `packing_option` enum('0','1','2','3') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=packing normal, 1=buble wrap, 2=packing kayu, 3=packing kardus',
  `service_option` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=reg, 1=yes',
  `date_order` date NOT NULL,
  `date_packing` date NOT NULL,
  `date_payment` date NOT NULL,
  `date_shipping` date NOT NULL,
  `date_receipt_cod` datetime(0) NULL DEFAULT NULL,
  `status_order` enum('0','1','2','3','4') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=order,1=packing,2=shipping,3=selesai,4=order belum bayar',
  `status_payment` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=notyet pay,1payment',
  `status_close` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=notyet close, 1=close',
  `status_complate_stuff` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1' COMMENT '0=not complate fisik stuff, 1=complate fisik stuff',
  `status_marketplace` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not marketplace, 1=market place',
  `status_payment_commision_reseller` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not pay, 1=pay',
  `status_payback_cod_reseller` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not pay, 1=pay',
  `status_receipt_cod` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=belum terima, 1 sudah terima',
  `status_respon_customer` enum('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not yet respon customer, 1=already respon customer,2=repeat order',
  `status_respon_customer_breakdown` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status_payment_commision_affiliate` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not pay, 1=pay',
  `is_warehouse_external` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `is_reseller` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not reseller, 1=reseller',
  `is_affiliate` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not affiliate, 1=affiliate',
  `is_cod` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not cod, 1=cod',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=no delete, 1=delete',
  `is_return` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not return, 1=return',
  `is_delete_permanent` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_dropshipper` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT '0=not delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_phone_number`(`phone`) USING BTREE,
  INDEX `index_sales_id`(`sales_id`) USING BTREE,
  INDEX `index_date_order`(`date_order`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 28 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sales_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `sales_order_detail`;
CREATE TABLE `sales_order_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_order_id` int(11) NOT NULL,
  `stuff_id` int(11) NOT NULL,
  `price_basic` decimal(10, 0) NOT NULL,
  `price` decimal(10, 0) NOT NULL,
  `price_reseller_to_customer` decimal(10, 0) NULL DEFAULT NULL,
  `fee_sales` double NOT NULL,
  `reseller_fee_nominal` double NULL DEFAULT NULL,
  `reseller_fee_percent` double NULL DEFAULT NULL,
  `affiliate_fee_nominal` double NULL DEFAULT NULL,
  `affiliate_fee_percent` double NULL DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `discount_persen` double NOT NULL,
  `discount_money` decimal(10, 0) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nickname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_bundling` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0 = barang satuan, 1 = barang bundling',
  `customer_rate` enum('0','1','2','3','4','5') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT 'bintang 1 s.d 5, 0 = tidak memberi rate',
  `customer_respon` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `customer_respon_screenshoot_upload` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `reseller_point` double NULL DEFAULT 0,
  `affiliate_point` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `index_sales_order_id`(`sales_order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 26 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sales_order_detail_bundling
-- ----------------------------
DROP TABLE IF EXISTS `sales_order_detail_bundling`;
CREATE TABLE `sales_order_detail_bundling`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_order_detail_id` int(11) NOT NULL,
  `stuff_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `price_basic` decimal(10, 0) NULL DEFAULT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `fee_sales` double NULL DEFAULT NULL,
  `discount_type` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=percent, 1=nomina',
  `discount_percent` double NULL DEFAULT NULL,
  `discount_nominal` double NULL DEFAULT NULL,
  `qty` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sales_order_followup
-- ----------------------------
DROP TABLE IF EXISTS `sales_order_followup`;
CREATE TABLE `sales_order_followup`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `country_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `from_ip` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_input` datetime(0) NOT NULL,
  `is_followup` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not follow, 1=follow',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sales_order_followup_detail
-- ----------------------------
DROP TABLE IF EXISTS `sales_order_followup_detail`;
CREATE TABLE `sales_order_followup_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_order_followup_id` int(11) NOT NULL,
  `stuff_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for sales_order_history
-- ----------------------------
DROP TABLE IF EXISTS `sales_order_history`;
CREATE TABLE `sales_order_history`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_order_id` int(11) NOT NULL,
  `no_sales_order` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `activity` enum('1','2','3','4','5') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT '1=validasi payment, 2=packing, 3=shipping, 4=selesai, 5=hapus order',
  `datetime_track` datetime(0) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=tidak dihapus, 1=hapus',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `SALES_ORDER`(`sales_order_id`, `activity`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sales_retur
-- ----------------------------
DROP TABLE IF EXISTS `sales_retur`;
CREATE TABLE `sales_retur`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_retur` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_so` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `amount_basic_sale` double NOT NULL,
  `amount_sale` double(255, 0) NULL DEFAULT NULL,
  `date_retur` date NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=no delete, 1=delete ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for stuff
-- ----------------------------
DROP TABLE IF EXISTS `stuff`;
CREATE TABLE `stuff`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `sku` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nickname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `stock` int(11) NULL DEFAULT NULL,
  `stock_min_alert` int(11) NULL DEFAULT NULL,
  `const_id` int(11) NULL DEFAULT NULL,
  `location_id` int(11) NULL DEFAULT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `price_basic` decimal(11, 0) NOT NULL,
  `fee_sales` double NOT NULL,
  `is_hidden` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not hidden,1=hidden',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=not delete 1=delete',
  `cost_cs` double NOT NULL,
  `cost_ops` double NOT NULL DEFAULT 0,
  `cost_riset` double NOT NULL DEFAULT 0,
  `cost_adv` double NOT NULL DEFAULT 0,
  `description` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for stuff_bundling
-- ----------------------------
DROP TABLE IF EXISTS `stuff_bundling`;
CREATE TABLE `stuff_bundling`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nickname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `price_min` decimal(10, 0) NULL DEFAULT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `price_basic` decimal(11, 0) NULL DEFAULT NULL,
  `fee_sales` double NULL DEFAULT NULL,
  `is_hidden` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not hidden,1=hidden',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for stuff_bundling_detail
-- ----------------------------
DROP TABLE IF EXISTS `stuff_bundling_detail`;
CREATE TABLE `stuff_bundling_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stuff_bundling_id` int(11) NOT NULL,
  `stuff_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `fee_sales` double NULL DEFAULT NULL,
  `discount_type` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0' COMMENT '0=percent, 1=nomina',
  `discount_percent` double NULL DEFAULT NULL,
  `discount_nominal` double NULL DEFAULT NULL,
  `qty` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for stuff_category
-- ----------------------------
DROP TABLE IF EXISTS `stuff_category`;
CREATE TABLE `stuff_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cost_cs` double NOT NULL,
  `cost_ops` double NOT NULL,
  `cost_riset` double NOT NULL,
  `cost_adv` double NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for stuff_category_sub
-- ----------------------------
DROP TABLE IF EXISTS `stuff_category_sub`;
CREATE TABLE `stuff_category_sub`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stuff_category_id` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for stuff_category_sub_row
-- ----------------------------
DROP TABLE IF EXISTS `stuff_category_sub_row`;
CREATE TABLE `stuff_category_sub_row`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stuff_id` int(11) NULL DEFAULT NULL,
  `stuff_category_sub_id` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for stuff_history
-- ----------------------------
DROP TABLE IF EXISTS `stuff_history`;
CREATE TABLE `stuff_history`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stuff_id` int(11) NOT NULL,
  `reseller_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `tipe` enum('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=out, 1=in, 2=koreksi',
  `amount` int(11) NOT NULL,
  `description` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `suplier_id` int(11) NULL DEFAULT NULL,
  `client_id` int(11) NULL DEFAULT NULL,
  `sales_order_id` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=not delete 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 29 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for stuff_photo
-- ----------------------------
DROP TABLE IF EXISTS `stuff_photo`;
CREATE TABLE `stuff_photo`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stuff_id` int(11) NULL DEFAULT NULL,
  `photo_thumail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_primary` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '0=not primary 1=primary',
  `is_active` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '1' COMMENT '0=not active 1=active',
  `is_delete` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '0=not detele 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for suplier
-- ----------------------------
DROP TABLE IF EXISTS `suplier`;
CREATE TABLE `suplier`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0= can be delete, 1= not delete',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=no delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 108 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for warehouse_external
-- ----------------------------
DROP TABLE IF EXISTS `warehouse_external`;
CREATE TABLE `warehouse_external`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `address` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0= can be delete, 1= not delete',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=no delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 27 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
