/*
 Navicat Premium Data Transfer

 Source Server         : somat
 Source Server Type    : PostgreSQL
 Source Server Version : 100010
 Source Host           : skdigital.id:5432
 Source Catalog        : somat
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 100010
 File Encoding         : 65001

 Date: 23/11/2019 13:41:57
*/


-- ----------------------------
-- Sequence structure for log_modal_id_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_modal_id_sequence";
CREATE SEQUENCE "public"."log_modal_id_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for m_user_id_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."m_user_id_sequence";
CREATE SEQUENCE "public"."m_user_id_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pegawai_id_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pegawai_id_sequence";
CREATE SEQUENCE "public"."pegawai_id_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pemasukan_id_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pemasukan_id_sequence";
CREATE SEQUENCE "public"."pemasukan_id_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pencatatan_id_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pencatatan_id_sequence";
CREATE SEQUENCE "public"."pencatatan_id_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for penempatan_id_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."penempatan_id_sequence";
CREATE SEQUENCE "public"."penempatan_id_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pengeluaran_id_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pengeluaran_id_sequence";
CREATE SEQUENCE "public"."pengeluaran_id_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for umkm_id_sequence
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."umkm_id_sequence";
CREATE SEQUENCE "public"."umkm_id_sequence" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for log_modal
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_modal";
CREATE TABLE "public"."log_modal" (
  "id_log_modal" int8 NOT NULL DEFAULT nextval('log_modal_id_sequence'::regclass),
  "nominal" int8,
  "status" int8,
  "add_time" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "id_umkm" int8
)
;

-- ----------------------------
-- Records of log_modal
-- ----------------------------
INSERT INTO "public"."log_modal" VALUES (38, 5000000, 1, '2019-11-08 08:24:44', 11);
INSERT INTO "public"."log_modal" VALUES (39, 253665, 1, '2019-11-08 08:47:40', 12);
INSERT INTO "public"."log_modal" VALUES (40, 4721500, 1, '2019-11-09 03:56:47.040385', 11);
INSERT INTO "public"."log_modal" VALUES (41, 4221500, 1, '2019-11-09 04:02:25.562957', 11);
INSERT INTO "public"."log_modal" VALUES (42, 10000000, 1, '2019-11-11 09:31:12', 13);
INSERT INTO "public"."log_modal" VALUES (43, 10100000, 1, '2019-11-11 08:35:01.231511', 13);
INSERT INTO "public"."log_modal" VALUES (44, 10350000, 1, '2019-11-11 08:36:49.819754', 13);
INSERT INTO "public"."log_modal" VALUES (45, 9850000, 1, '2019-11-11 08:39:29.329947', 13);
INSERT INTO "public"."log_modal" VALUES (46, 5221500, 1, '2019-11-13 03:10:49.223447', 11);
INSERT INTO "public"."log_modal" VALUES (47, 6221500, 1, '2019-11-13 03:11:02.328223', 11);
INSERT INTO "public"."log_modal" VALUES (48, 7221500, 1, '2019-11-13 03:11:05.543391', 11);
INSERT INTO "public"."log_modal" VALUES (49, 8221500, 1, '2019-11-13 03:11:09.633645', 11);
INSERT INTO "public"."log_modal" VALUES (50, 53221500, 1, '2019-11-13 03:11:14.641799', 11);
INSERT INTO "public"."log_modal" VALUES (51, 52221500, 1, '2019-11-13 03:11:44.99781', 11);
INSERT INTO "public"."log_modal" VALUES (52, 51221500, 1, '2019-11-13 03:11:48.909052', 11);
INSERT INTO "public"."log_modal" VALUES (53, 50221500, 1, '2019-11-13 03:11:58.798815', 11);
INSERT INTO "public"."log_modal" VALUES (54, 49221500, 1, '2019-11-13 03:14:01.872377', 11);
INSERT INTO "public"."log_modal" VALUES (55, 48221500, 1, '2019-11-13 03:14:14.790913', 11);
INSERT INTO "public"."log_modal" VALUES (56, 47721500, 1, '2019-11-13 03:14:20.734882', 11);
INSERT INTO "public"."log_modal" VALUES (57, 46721500, 1, '2019-11-13 03:15:28.478083', 11);
INSERT INTO "public"."log_modal" VALUES (58, 46021500, 1, '2019-11-13 03:15:35.397543', 11);
INSERT INTO "public"."log_modal" VALUES (59, 46221500, 1, '2019-11-13 08:32:32.2231', 11);
INSERT INTO "public"."log_modal" VALUES (60, 46071500, 1, '2019-11-13 08:32:45.713059', 11);
INSERT INTO "public"."log_modal" VALUES (61, 5000100, 1, '2019-11-15 02:47:03', 14);
INSERT INTO "public"."log_modal" VALUES (62, 5100100, 1, '2019-11-15 01:56:23.62178', 14);
INSERT INTO "public"."log_modal" VALUES (63, 5030100, 1, '2019-11-15 01:56:34.832981', 14);
INSERT INTO "public"."log_modal" VALUES (64, 5230100, 1, '2019-11-15 01:57:22.751891', 14);
INSERT INTO "public"."log_modal" VALUES (65, 5180100, 1, '2019-11-15 01:57:58.585352', 14);
INSERT INTO "public"."log_modal" VALUES (66, -3928500, 1, '2019-11-15 08:35:44.17943', 11);
INSERT INTO "public"."log_modal" VALUES (67, -2928500, 1, '2019-11-15 11:32:55.36701', 11);
INSERT INTO "public"."log_modal" VALUES (68, -4928500, 1, '2019-11-15 11:33:59.482419', 11);
INSERT INTO "public"."log_modal" VALUES (69, 5000000, 1, '2019-11-19 04:00:01', 15);

-- ----------------------------
-- Table structure for m_user
-- ----------------------------
DROP TABLE IF EXISTS "public"."m_user";
CREATE TABLE "public"."m_user" (
  "id_user" int8 NOT NULL DEFAULT nextval('m_user_id_sequence'::regclass),
  "username" varchar(255) COLLATE "pg_catalog"."default",
  "password" text COLLATE "pg_catalog"."default",
  "id_pegawai" int8,
  "status" int8,
  "add_time" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
)
;

-- ----------------------------
-- Records of m_user
-- ----------------------------
INSERT INTO "public"."m_user" VALUES (1, 'solusiadmin', 'adminsolusi', NULL, 1, '2019-11-07 09:51:12.437864');
INSERT INTO "public"."m_user" VALUES (2, 'bdj', 'bdj', 1, 1, '2019-11-08 03:27:08');
INSERT INTO "public"."m_user" VALUES (3, 'ke', 'ke', 2, 1, '2019-11-08 03:38:30');
INSERT INTO "public"."m_user" VALUES (4, 'we', 'we', 3, 1, '2019-11-08 04:14:11');
INSERT INTO "public"."m_user" VALUES (5, 'k', 'k', 4, 1, '2019-11-11 09:32:11');
INSERT INTO "public"."m_user" VALUES (6, 'bbt', 'bbt', 5, 1, '2019-11-15 02:52:18');
INSERT INTO "public"."m_user" VALUES (7, 'pip', 'pip', 6, 1, '2019-11-19 04:01:38');

-- ----------------------------
-- Table structure for pegawai
-- ----------------------------
DROP TABLE IF EXISTS "public"."pegawai";
CREATE TABLE "public"."pegawai" (
  "id_pegawai" int8 NOT NULL DEFAULT nextval('pegawai_id_sequence'::regclass),
  "nama_pegawai" varchar(255) COLLATE "pg_catalog"."default",
  "alamat" text COLLATE "pg_catalog"."default",
  "no_telp" varchar(255) COLLATE "pg_catalog"."default",
  "nik" varchar(255) COLLATE "pg_catalog"."default",
  "status" int8,
  "add_time" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
)
;

-- ----------------------------
-- Records of pegawai
-- ----------------------------
INSERT INTO "public"."pegawai" VALUES (1, 'Pegawai Bubur DJ', 'Gunung Batu', '0', '0', 1, '2019-11-08 03:26:47');
INSERT INTO "public"."pegawai" VALUES (4, 'kevin', 'cicendo', '087869123931', '3425654528980001', 1, '2019-11-11 09:31:56');
INSERT INTO "public"."pegawai" VALUES (5, 'Shofan Galang', 'Surapati Core - Bandung', '08210080210', '8341418349878342', 1, '2019-11-15 02:50:53');
INSERT INTO "public"."pegawai" VALUES (6, 'apip', 'soreang', '08778954324', '34532213456', 1, '2019-11-19 04:01:16');

-- ----------------------------
-- Table structure for pemasukan
-- ----------------------------
DROP TABLE IF EXISTS "public"."pemasukan";
CREATE TABLE "public"."pemasukan" (
  "id_pemasukan" int8 NOT NULL DEFAULT nextval('pemasukan_id_sequence'::regclass),
  "id_umkm" int8,
  "nominal" int8,
  "add_time" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "saldo" varchar(255) COLLATE "pg_catalog"."default",
  "penjualan" varchar(255) COLLATE "pg_catalog"."default",
  "jumlah" int8,
  "id_pencatatan" int8
)
;

-- ----------------------------
-- Records of pemasukan
-- ----------------------------
INSERT INTO "public"."pemasukan" VALUES (5, 13, 350000, '2019-11-11 09:36:50', '10350000', NULL, NULL, 1);
INSERT INTO "public"."pemasukan" VALUES (9, 13, 90000, '2019-11-14 15:27:32', '0', NULL, NULL, 1);
INSERT INTO "public"."pemasukan" VALUES (7, 14, 300000, '2019-11-15 02:57:23', '5230100', NULL, NULL, 1);
INSERT INTO "public"."pemasukan" VALUES (6, 11, 49200000, '2019-11-11 09:32:33', '46221500', NULL, NULL, 1);
INSERT INTO "public"."pemasukan" VALUES (8, 11, 1000000, '2019-11-22 12:32:56', '-2928500', NULL, NULL, 2);

-- ----------------------------
-- Table structure for pencatatan
-- ----------------------------
DROP TABLE IF EXISTS "public"."pencatatan";
CREATE TABLE "public"."pencatatan" (
  "id_pencatatan" int8 NOT NULL DEFAULT nextval('pencatatan_id_sequence'::regclass),
  "judul_pencatatan" varchar(255) COLLATE "pg_catalog"."default",
  "tanggal_transaksi" date,
  "add_time" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "id_umkm" int8
)
;

-- ----------------------------
-- Records of pencatatan
-- ----------------------------
INSERT INTO "public"."pencatatan" VALUES (1, 'judulnya', '2019-11-11', '2019-11-11 04:12:57', 11);
INSERT INTO "public"."pencatatan" VALUES (2, 'judul lagi', '2019-11-22', '2019-11-22 06:07:24.457618', 11);
INSERT INTO "public"."pencatatan" VALUES (3, 'judulll', '2019-11-11', '2019-11-22 07:10:25.451422', 13);

-- ----------------------------
-- Table structure for penempatan
-- ----------------------------
DROP TABLE IF EXISTS "public"."penempatan";
CREATE TABLE "public"."penempatan" (
  "id_penempatan" int8 NOT NULL DEFAULT nextval('penempatan_id_sequence'::regclass),
  "id_pegawai" int8,
  "id_umkm" int8,
  "add_time" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "status" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of penempatan
-- ----------------------------
INSERT INTO "public"."penempatan" VALUES (5, 1, 11, '2019-11-08 09:18:57', '1');
INSERT INTO "public"."penempatan" VALUES (6, 4, 13, '2019-11-11 09:34:24', '1');
INSERT INTO "public"."penempatan" VALUES (7, 5, 14, '2019-11-15 02:52:42', '1');
INSERT INTO "public"."penempatan" VALUES (8, 6, 15, '2019-11-19 04:01:49', '1');

-- ----------------------------
-- Table structure for pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS "public"."pengeluaran";
CREATE TABLE "public"."pengeluaran" (
  "id_pengeluaran" int8 NOT NULL DEFAULT nextval('pengeluaran_id_sequence'::regclass),
  "id_umkm" int8,
  "add_by" int8,
  "nominal" int8,
  "add_time" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "saldo" varchar(255) COLLATE "pg_catalog"."default",
  "pembelian" varchar(255) COLLATE "pg_catalog"."default",
  "jumlah" int8,
  "id_pencatatan" int8
)
;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO "public"."pengeluaran" VALUES (4, 11, 1, 778500, '2019-11-09 05:02:26', '4221500', NULL, NULL, 1);
INSERT INTO "public"."pengeluaran" VALUES (5, 13, 4, 500000, '2019-11-11 09:39:30', '9850000', NULL, NULL, 1);
INSERT INTO "public"."pengeluaran" VALUES (7, 14, 5, 120000, '2019-11-15 02:57:59', '5180100', NULL, NULL, 1);
INSERT INTO "public"."pengeluaran" VALUES (6, 11, 1, 7350000, '2019-11-11 09:32:46', '46071500', NULL, NULL, 1);
INSERT INTO "public"."pengeluaran" VALUES (8, 11, 1, 52000000, '2019-11-22 12:34:00', '-4928500', NULL, NULL, 1);

-- ----------------------------
-- Table structure for umkm
-- ----------------------------
DROP TABLE IF EXISTS "public"."umkm";
CREATE TABLE "public"."umkm" (
  "id_umkm" int8 NOT NULL DEFAULT nextval('umkm_id_sequence'::regclass),
  "nama_umkm" varchar(255) COLLATE "pg_catalog"."default",
  "alamat" text COLLATE "pg_catalog"."default",
  "jenis_dagangan" varchar(53) COLLATE "pg_catalog"."default",
  "no_kios" varchar(53) COLLATE "pg_catalog"."default",
  "foto" text COLLATE "pg_catalog"."default",
  "status" int8,
  "add_time" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "modal_awal" int8
)
;

-- ----------------------------
-- Records of umkm
-- ----------------------------
INSERT INTO "public"."umkm" VALUES (11, 'Iman Abdul Syukur', 'Alfamart 489. Soekarno Hatta  - Bandung', 'Bubur Ayam DJ', 'KU 0001', '20191108082439-menububur.PNG', 1, '2019-11-08 08:24:44', 5000000);
INSERT INTO "public"."umkm" VALUES (14, 'coba lagi', 'Indomaret, AH Nasution 63. jalan padasuka - Bandung', 'Bakso Bakar Tentakel', 'KU 0002', '20191115024700-baksobakar.jpg', 1, '2019-11-15 02:47:03', 5000100);
INSERT INTO "public"."umkm" VALUES (13, 'coba', 'gunungbatu', 'minuman', 'KU 0002', '20191111093110-new.PNG', 1, '2019-11-11 09:31:12', 10000000);
INSERT INTO "public"."umkm" VALUES (15, 'afifah', 'soreang', 'makanan basi', 'k100', '20191121024330-gbr_bjb.PNG', 1, '2019-11-19 04:00:01', 5000000);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."log_modal_id_sequence"', 70, true);
SELECT setval('"public"."m_user_id_sequence"', 8, true);
SELECT setval('"public"."pegawai_id_sequence"', 7, true);
SELECT setval('"public"."pemasukan_id_sequence"', 10, true);
SELECT setval('"public"."pencatatan_id_sequence"', 4, true);
SELECT setval('"public"."penempatan_id_sequence"', 9, true);
SELECT setval('"public"."pengeluaran_id_sequence"', 9, true);
SELECT setval('"public"."umkm_id_sequence"', 16, true);

-- ----------------------------
-- Primary Key structure for table log_modal
-- ----------------------------
ALTER TABLE "public"."log_modal" ADD CONSTRAINT "log_modal_pkey" PRIMARY KEY ("id_log_modal");

-- ----------------------------
-- Primary Key structure for table m_user
-- ----------------------------
ALTER TABLE "public"."m_user" ADD CONSTRAINT "m_user_pkey" PRIMARY KEY ("id_user");

-- ----------------------------
-- Primary Key structure for table pegawai
-- ----------------------------
ALTER TABLE "public"."pegawai" ADD CONSTRAINT "pegawai_pkey" PRIMARY KEY ("id_pegawai");

-- ----------------------------
-- Primary Key structure for table pemasukan
-- ----------------------------
ALTER TABLE "public"."pemasukan" ADD CONSTRAINT "pemasukan_pkey" PRIMARY KEY ("id_pemasukan");

-- ----------------------------
-- Primary Key structure for table pencatatan
-- ----------------------------
ALTER TABLE "public"."pencatatan" ADD CONSTRAINT "pencatatan_pkey" PRIMARY KEY ("id_pencatatan");

-- ----------------------------
-- Primary Key structure for table penempatan
-- ----------------------------
ALTER TABLE "public"."penempatan" ADD CONSTRAINT "penempatan_pkey" PRIMARY KEY ("id_penempatan");

-- ----------------------------
-- Primary Key structure for table pengeluaran
-- ----------------------------
ALTER TABLE "public"."pengeluaran" ADD CONSTRAINT "pengeluaran_pkey" PRIMARY KEY ("id_pengeluaran");

-- ----------------------------
-- Primary Key structure for table umkm
-- ----------------------------
ALTER TABLE "public"."umkm" ADD CONSTRAINT "umkm_pkey" PRIMARY KEY ("id_umkm");
