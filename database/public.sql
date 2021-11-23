/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 100009
 Source Host           : localhost:5432
 Source Catalog        : tes
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 100009
 File Encoding         : 65001

 Date: 06/08/2019 13:18:01
*/


-- ----------------------------
-- Sequence structure for id_seq_role
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."id_seq_role";
CREATE SEQUENCE "public"."id_seq_role" 
INCREMENT 1
MINVALUE  1
MAXVALUE 999999999999999999
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for id_seq_tasklist
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."id_seq_tasklist";
CREATE SEQUENCE "public"."id_seq_tasklist" 
INCREMENT 1
MINVALUE  1
MAXVALUE 99999999999
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for id_seq_user
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."id_seq_user";
CREATE SEQUENCE "public"."id_seq_user" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9999999999
START 1
CACHE 1;

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS "public"."role";
CREATE TABLE "public"."role" (
  "id" int4 NOT NULL DEFAULT nextval('id_seq_role'::regclass),
  "nama_role" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "keterangan" text COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO "public"."role" VALUES (4, 'manager', NULL);
INSERT INTO "public"."role" VALUES (5, 'pegawai', NULL);

-- ----------------------------
-- Table structure for tasklist
-- ----------------------------
DROP TABLE IF EXISTS "public"."tasklist";
CREATE TABLE "public"."tasklist" (
  "id" int4 NOT NULL DEFAULT nextval('id_seq_tasklist'::regclass),
  "user_id" int4 NOT NULL,
  "judul" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "deskripsi" text COLLATE "pg_catalog"."default",
  "status" varchar(255) COLLATE "pg_catalog"."default",
  "hasil" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of tasklist
-- ----------------------------
INSERT INTO "public"."tasklist" VALUES (2, 1, 'tes', 'tes', NULL, '');
INSERT INTO "public"."tasklist" VALUES (3, 1, 'tes', 'tes', NULL, 'sudah');
INSERT INTO "public"."tasklist" VALUES (4, 1, 'tes', 'tes', NULL, NULL);
INSERT INTO "public"."tasklist" VALUES (1, 1, 'ets', 'tes', 'diterima', 'sudah');
INSERT INTO "public"."tasklist" VALUES (6, 3, 'backup data tahun 2018', 'backup data pengeluaran tahun 2018', NULL, 'sedang proses backup');
INSERT INTO "public"."tasklist" VALUES (5, 1, 'installasi operating system', 'install os windows pc keuangan', 'diterima', 'sudah di lakukan');
INSERT INTO "public"."tasklist" VALUES (7, 1, 'tes 123', 'tes deskripsi', 'diterima', 'tes hasil');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS "public"."user";
CREATE TABLE "public"."user" (
  "id" int4 NOT NULL DEFAULT nextval('id_seq_user'::regclass),
  "username" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "password" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "nama" varchar(255) COLLATE "pg_catalog"."default",
  "role_id" int4
)
;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO "public"."user" VALUES (1, 'krisna', 'krisna', 'krisna', 5);
INSERT INTO "public"."user" VALUES (2, 'mulyadi', 'mulyadi', 'mulyadi', 4);
INSERT INTO "public"."user" VALUES (3, 'keysha', 'keysha', 'keysha', 5);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."id_seq_role"
OWNED BY "public"."role"."id";
SELECT setval('"public"."id_seq_role"', 6, true);
ALTER SEQUENCE "public"."id_seq_tasklist"
OWNED BY "public"."tasklist"."id";
SELECT setval('"public"."id_seq_tasklist"', 8, true);
ALTER SEQUENCE "public"."id_seq_user"
OWNED BY "public"."user"."id";
SELECT setval('"public"."id_seq_user"', 4, true);

-- ----------------------------
-- Primary Key structure for table role
-- ----------------------------
ALTER TABLE "public"."role" ADD CONSTRAINT "role_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table tasklist
-- ----------------------------
ALTER TABLE "public"."tasklist" ADD CONSTRAINT "tasklist_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table user
-- ----------------------------
ALTER TABLE "public"."user" ADD CONSTRAINT "user_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table tasklist
-- ----------------------------
ALTER TABLE "public"."tasklist" ADD CONSTRAINT "tasklist_user_id_fkey" FOREIGN KEY ("user_id") REFERENCES "public"."user" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table user
-- ----------------------------
ALTER TABLE "public"."user" ADD CONSTRAINT "user_role_id_fkey" FOREIGN KEY ("role_id") REFERENCES "public"."role" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
