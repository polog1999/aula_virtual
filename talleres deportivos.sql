/*
 Navicat Premium Data Transfer

 Source Server         : Sistema de talleres deportivos
 Source Server Type    : PostgreSQL
 Source Server Version : 170002 (170002)
 Source Host           : 192.168.0.16:5432
 Source Catalog        : db_talleres_dep
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 170002 (170002)
 File Encoding         : 65001

 Date: 14/01/2026 17:47:33
*/


-- ----------------------------
-- Type structure for asistencias_estado
-- ----------------------------
DROP TYPE IF EXISTS "public"."asistencias_estado";
CREATE TYPE "public"."asistencias_estado" AS ENUM (
  'ASISTIO',
  'FALTO',
  'TARDANZA',
  'JUSTIFICADO'
);
ALTER TYPE "public"."asistencias_estado" OWNER TO "jpolo";

-- ----------------------------
-- Type structure for cronograma_pagos_estado
-- ----------------------------
DROP TYPE IF EXISTS "public"."cronograma_pagos_estado";
CREATE TYPE "public"."cronograma_pagos_estado" AS ENUM (
  'PENDIENTE',
  'PAGADO',
  'VENCIDO'
);
ALTER TYPE "public"."cronograma_pagos_estado" OWNER TO "jpolo";

-- ----------------------------
-- Type structure for horarios_dia_semana
-- ----------------------------
DROP TYPE IF EXISTS "public"."horarios_dia_semana";
CREATE TYPE "public"."horarios_dia_semana" AS ENUM (
  'LUNES',
  'MARTES',
  'MIÉRCOLES',
  'JUEVES',
  'VIERNES',
  'SÁBADO',
  'DOMINGO'
);
ALTER TYPE "public"."horarios_dia_semana" OWNER TO "jpolo";

-- ----------------------------
-- Type structure for matriculas_estado
-- ----------------------------
DROP TYPE IF EXISTS "public"."matriculas_estado";
CREATE TYPE "public"."matriculas_estado" AS ENUM (
  'INACTIVA',
  'ACTIVA',
  'RETIRADO',
  'FINALIZADO',
  'CANCELADA'
);
ALTER TYPE "public"."matriculas_estado" OWNER TO "jpolo";

-- ----------------------------
-- Type structure for pagos_docentes_estado
-- ----------------------------
DROP TYPE IF EXISTS "public"."pagos_docentes_estado";
CREATE TYPE "public"."pagos_docentes_estado" AS ENUM (
  'PENDIENTE',
  'PAGADO',
  'OBSERVADO'
);
ALTER TYPE "public"."pagos_docentes_estado" OWNER TO "jpolo";

-- ----------------------------
-- Type structure for sesiones_estado
-- ----------------------------
DROP TYPE IF EXISTS "public"."sesiones_estado";
CREATE TYPE "public"."sesiones_estado" AS ENUM (
  'Pendiente',
  'Abierta',
  'Cerrada'
);
ALTER TYPE "public"."sesiones_estado" OWNER TO "jpolo";

-- ----------------------------
-- Type structure for users_role
-- ----------------------------
DROP TYPE IF EXISTS "public"."users_role";
CREATE TYPE "public"."users_role" AS ENUM (
  'ADMIN',
  'DOCENTE',
  'ALUMNO',
  'TESORERIA',
  'PADRE',
  'ENCARGADO_SEDE'
);
ALTER TYPE "public"."users_role" OWNER TO "jpolo";

-- ----------------------------
-- Sequence structure for asistencias_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."asistencias_id_seq";
CREATE SEQUENCE "public"."asistencias_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for categorias_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."categorias_id_seq";
CREATE SEQUENCE "public"."categorias_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for codigos_tusnes_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."codigos_tusnes_id_seq";
CREATE SEQUENCE "public"."codigos_tusnes_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for cronograma_pagos_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cronograma_pagos_id_seq";
CREATE SEQUENCE "public"."cronograma_pagos_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for disciplinas_deportivas_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."disciplinas_deportivas_id_seq";
CREATE SEQUENCE "public"."disciplinas_deportivas_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for evaluaciones_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."evaluaciones_id_seq";
CREATE SEQUENCE "public"."evaluaciones_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for failed_jobs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."failed_jobs_id_seq";
CREATE SEQUENCE "public"."failed_jobs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for horarios_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."horarios_id_seq";
CREATE SEQUENCE "public"."horarios_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for jobs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."jobs_id_seq";
CREATE SEQUENCE "public"."jobs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for lugares_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."lugares_id_seq";
CREATE SEQUENCE "public"."lugares_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for matriculas_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."matriculas_id_seq";
CREATE SEQUENCE "public"."matriculas_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for migrations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."migrations_id_seq";
CREATE SEQUENCE "public"."migrations_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for orden_alumnos_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orden_alumnos_id_seq";
CREATE SEQUENCE "public"."orden_alumnos_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for orden_apoderados_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orden_apoderados_id_seq";
CREATE SEQUENCE "public"."orden_apoderados_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pagos_docentes_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pagos_docentes_id_seq";
CREATE SEQUENCE "public"."pagos_docentes_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pagos_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pagos_id_seq";
CREATE SEQUENCE "public"."pagos_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pagos_niubiz_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pagos_niubiz_id_seq";
CREATE SEQUENCE "public"."pagos_niubiz_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for periodos_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."periodos_id_seq";
CREATE SEQUENCE "public"."periodos_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pre_inscripcion_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pre_inscripcion_id_seq";
CREATE SEQUENCE "public"."pre_inscripcion_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for secciones_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."secciones_id_seq";
CREATE SEQUENCE "public"."secciones_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for secciones_periodo_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."secciones_periodo_id_seq";
CREATE SEQUENCE "public"."secciones_periodo_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for sesiones_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."sesiones_id_seq";
CREATE SEQUENCE "public"."sesiones_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for talleres_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."talleres_id_seq";
CREATE SEQUENCE "public"."talleres_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."users_id_seq";
CREATE SEQUENCE "public"."users_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for alumnos
-- ----------------------------
DROP TABLE IF EXISTS "public"."alumnos";
CREATE TABLE "public"."alumnos" (
  "user_id" int8 NOT NULL,
  "padre_id" int8,
  "codigo_estudiante" varchar(20) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "informacion_medica" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."alumnos"."informacion_medica" IS 'Alergias, condiciones importantes, etc.';

-- ----------------------------
-- Records of alumnos
-- ----------------------------

-- ----------------------------
-- Table structure for asistencias
-- ----------------------------
DROP TABLE IF EXISTS "public"."asistencias";
CREATE TABLE "public"."asistencias" (
  "id" int8 NOT NULL DEFAULT nextval('asistencias_id_seq'::regclass),
  "matricula_id" int8 NOT NULL,
  "fecha" date NOT NULL,
  "estado" "public"."asistencias_estado" NOT NULL,
  "detalles" text COLLATE "pg_catalog"."default",
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone
)
;

-- ----------------------------
-- Records of asistencias
-- ----------------------------

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS "public"."cache";
CREATE TABLE "public"."cache" (
  "key" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "value" text COLLATE "pg_catalog"."default" NOT NULL,
  "expiration" int4 NOT NULL
)
;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS "public"."cache_locks";
CREATE TABLE "public"."cache_locks" (
  "key" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "owner" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "expiration" int4 NOT NULL
)
;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS "public"."categorias";
CREATE TABLE "public"."categorias" (
  "id" int8 NOT NULL DEFAULT nextval('categorias_id_seq'::regclass),
  "descripcion" text COLLATE "pg_catalog"."default",
  "created_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP,
  "edad_min" int2,
  "edad_max" int2,
  "tiene_discapacidad" bool
)
;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO "public"."categorias" VALUES (3, 'Desarrollo técnico-táctico y pre-competitivo.', '2025-10-21 10:45:55', '2025-12-15 08:59:59', 6, 9, 'f');
INSERT INTO "public"."categorias" VALUES (19, NULL, '2025-12-15 09:08:20', '2025-12-15 09:08:20', 10, 13, 'f');
INSERT INTO "public"."categorias" VALUES (20, NULL, '2025-12-15 09:08:32', '2025-12-15 09:08:32', 14, 17, 'f');
INSERT INTO "public"."categorias" VALUES (22, NULL, '2025-12-15 09:09:25', '2025-12-15 09:09:25', 6, 11, 'f');
INSERT INTO "public"."categorias" VALUES (23, NULL, '2025-12-15 09:09:34', '2025-12-15 09:09:34', 12, 17, 'f');
INSERT INTO "public"."categorias" VALUES (29, NULL, '2025-12-15 09:23:00', '2025-12-15 09:23:00', 6, 17, 'f');
INSERT INTO "public"."categorias" VALUES (30, NULL, '2025-12-15 09:23:24', '2025-12-15 09:23:24', 9, 13, 'f');
INSERT INTO "public"."categorias" VALUES (31, NULL, '2025-12-15 09:25:15', '2025-12-15 09:25:15', 5, 8, 'f');
INSERT INTO "public"."categorias" VALUES (21, NULL, '2025-12-15 09:08:47', '2025-12-15 10:35:07', 25, NULL, 'f');
INSERT INTO "public"."categorias" VALUES (27, NULL, '2025-12-15 09:11:58', '2025-12-15 10:35:10', NULL, NULL, 't');
INSERT INTO "public"."categorias" VALUES (32, NULL, '2025-12-15 09:29:36', '2025-12-15 10:35:13', NULL, NULL, 'f');
INSERT INTO "public"."categorias" VALUES (26, NULL, '2025-12-15 09:11:37', '2025-12-15 12:40:53', 8, NULL, 'f');

-- ----------------------------
-- Table structure for codigos_tusnes
-- ----------------------------
DROP TABLE IF EXISTS "public"."codigos_tusnes";
CREATE TABLE "public"."codigos_tusnes" (
  "id" int8 NOT NULL DEFAULT nextval('codigos_tusnes_id_seq'::regclass),
  "grupo" varchar(255) COLLATE "pg_catalog"."default",
  "codigo" varchar(255) COLLATE "pg_catalog"."default",
  "taller_id" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "es_vecino" bool
)
;

-- ----------------------------
-- Records of codigos_tusnes
-- ----------------------------
INSERT INTO "public"."codigos_tusnes" VALUES (68, '23', 'O0021', 23, NULL, '2026-01-08 14:30:13', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (69, '23', 'O0041', 23, NULL, '2026-01-08 14:30:13', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (60, '23', 'O0022', 73, '2026-01-08 14:19:48', '2026-01-08 14:19:48', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (61, '23', 'O0042', 73, '2026-01-08 14:19:48', '2026-01-08 14:19:48', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (65, '23', 'O0024', 61, '2026-01-08 14:22:48', '2026-01-08 14:22:48', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (64, '23', 'O0044', 61, '2026-01-08 14:22:48', '2026-01-08 14:22:48', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (63, '23', 'O0024', 60, '2026-01-08 14:23:01', '2026-01-08 14:23:01', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (62, '23', 'O0044', 60, '2026-01-08 14:23:01', '2026-01-08 14:23:01', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (66, '23', 'O0019', 22, '2026-01-08 14:27:01', '2026-01-08 14:27:01', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (31, '23', 'O0071', 19, '2026-01-08 09:53:12', '2026-01-08 09:53:12', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (30, '23', 'O0068', 19, '2026-01-08 09:53:12', '2026-01-08 09:53:12', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (33, '23', 'O0035', 24, '2026-01-08 09:45:10', '2026-01-08 09:45:10', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (32, '23', 'O0015', 24, '2026-01-08 09:45:10', '2026-01-08 09:45:10', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (35, '23', 'O0035', 25, '2026-01-08 09:44:54', '2026-01-08 09:44:54', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (34, '23', 'O0015', 25, '2026-01-08 09:44:54', '2026-01-08 09:44:54', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (36, '23', 'O0015', 27, '2026-01-08 09:43:47', '2026-01-08 09:43:47', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (37, '23', 'O0035', 27, '2026-01-08 09:43:47', '2026-01-08 09:43:47', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (51, '23', 'O0044', 62, '2026-01-08 10:18:54', '2026-01-08 10:18:54', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (50, '23', 'O0024', 62, '2026-01-08 10:18:54', '2026-01-08 10:18:54', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (53, '23', 'O0044', 63, '2026-01-08 10:18:38', '2026-01-08 10:18:38', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (52, '23', 'O0024', 63, '2026-01-08 10:18:38', '2026-01-08 10:18:38', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (54, '23', 'O0024', 64, '2026-01-08 10:18:15', '2026-01-08 10:18:15', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (55, '23', 'O0044', 64, '2026-01-08 10:18:15', '2026-01-08 10:18:15', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (59, '23', 'O0014', 65, '2026-01-08 10:20:37', '2026-01-08 10:20:37', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (67, '23', 'O0039', 22, '2026-01-08 14:27:01', '2026-01-08 14:27:01', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (58, '23', 'O0013', 65, '2026-01-08 10:20:37', '2026-01-08 10:20:37', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (57, '23', 'O0072', 66, '2026-01-08 10:17:05', '2026-01-08 10:17:05', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (56, '23', 'O0069', 66, '2026-01-08 10:17:05', '2026-01-08 10:17:05', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (44, '23', 'O0016', 67, '2026-01-08 10:13:45', '2026-01-08 10:13:45', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (45, '23', 'O0036', 67, '2026-01-08 10:13:45', '2026-01-08 10:13:45', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (46, '23', 'O0016', 68, '2026-01-08 10:13:36', '2026-01-08 10:13:36', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (47, '23', 'O0036', 68, '2026-01-08 10:13:36', '2026-01-08 10:13:36', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (48, '23', 'O0016', 69, '2026-01-08 10:13:01', '2026-01-08 10:13:01', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (49, '23', 'O0036', 69, '2026-01-08 10:13:01', '2026-01-08 10:13:01', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (41, '23', 'O0038', 70, '2026-01-08 10:11:31', '2026-01-08 10:11:31', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (40, '23', 'O0018', 70, '2026-01-08 10:11:31', '2026-01-08 10:11:31', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (43, '23', 'O0038', 71, '2026-01-08 10:11:17', '2026-01-08 10:11:17', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (42, '23', 'O0018', 71, '2026-01-08 10:11:17', '2026-01-08 10:11:17', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (39, '23', 'O0070', 72, '2026-01-08 10:07:44', '2026-01-08 10:07:44', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (38, '23', 'O0067', 72, '2026-01-08 10:07:44', '2026-01-08 10:07:44', 't');
INSERT INTO "public"."codigos_tusnes" VALUES (26, '23', 'O0039', 88, '2026-01-08 08:55:03', '2026-01-08 08:55:03', 'f');
INSERT INTO "public"."codigos_tusnes" VALUES (25, '23', 'O0019', 88, '2026-01-08 08:55:03', '2026-01-08 08:55:03', 't');

-- ----------------------------
-- Table structure for cronograma_pagos
-- ----------------------------
DROP TABLE IF EXISTS "public"."cronograma_pagos";
CREATE TABLE "public"."cronograma_pagos" (
  "id" int8 NOT NULL DEFAULT nextval('cronograma_pagos_id_seq'::regclass),
  "matricula_id" int8 NOT NULL,
  "concepto" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "monto" numeric(10,2) NOT NULL,
  "fecha_vencimiento" date,
  "estado" "public"."cronograma_pagos_estado" NOT NULL DEFAULT 'PENDIENTE'::cronograma_pagos_estado,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "fecha_pago" timestamp(6)
)
;
COMMENT ON COLUMN "public"."cronograma_pagos"."concepto" IS 'Ej: Matrícula, Mensualidad Setiembre';

-- ----------------------------
-- Records of cronograma_pagos
-- ----------------------------

-- ----------------------------
-- Table structure for disciplinas_deportivas
-- ----------------------------
DROP TABLE IF EXISTS "public"."disciplinas_deportivas";
CREATE TABLE "public"."disciplinas_deportivas" (
  "id" int8 NOT NULL DEFAULT nextval('disciplinas_deportivas_id_seq'::regclass),
  "nombre" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "imagen" varchar(255) COLLATE "pg_catalog"."default",
  "descripcion" text COLLATE "pg_catalog"."default",
  "activo" bool NOT NULL DEFAULT true,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "cod_serv" varchar(6) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of disciplinas_deportivas
-- ----------------------------
INSERT INTO "public"."disciplinas_deportivas" VALUES (19, 'Atletismo', 'imagenes/In03kptDKBUhUQd0SexVhX4LusSnkJOMOFEU2wj6.jpg', NULL, 't', '2025-11-10 15:16:50', '2025-11-11 17:00:19', '0');
INSERT INTO "public"."disciplinas_deportivas" VALUES (4, 'Natación', 'imagenes/WGsmWUoeVEub9kEcrs0udLVDuYaXRwQLKnyZ5hdK.webp', 'Aprendizaje y perfeccionamiento de estilos de nado en un ambiente seguro.', 't', NULL, '2025-11-11 17:00:30', '0');
INSERT INTO "public"."disciplinas_deportivas" VALUES (6, 'Ajedrez', 'imagenes/omv4WTQkjWlJvybUVF00HQmndPQc85FDCrj6FUHs.avif', 'Deporte mental que fomenta el pensamiento estratégico y la concentración.', 't', NULL, '2025-11-11 17:00:47', '0');
INSERT INTO "public"."disciplinas_deportivas" VALUES (2, 'Voley', 'imagenes/p3W8NF8VgalkyOVQtyua1esRx7Jzv8SxFp1zI758.jpg', 'Desarrollo de habilidades de saque, recepción, voleo y mate.', 't', NULL, '2025-11-11 17:00:58', '0');
INSERT INTO "public"."disciplinas_deportivas" VALUES (1, 'Fútbol', 'imagenes/9Maks9V1Zy2MNR0kXk3mqD2iH1slZxtU6xZYQfYW.avif', 'Deporte de equipo enfocado en la técnica, táctica y trabajo en conjunto.', 't', NULL, '2025-11-11 17:07:38', '1112');
INSERT INTO "public"."disciplinas_deportivas" VALUES (20, 'Kung Fu', 'imagenes/4gWLk8Bl3oDcDFgJW5E6fcLXmx9KhJEoQXtK4iwF.jpg', NULL, 't', '2025-11-10 15:17:01', '2025-11-11 17:19:25', '0');
INSERT INTO "public"."disciplinas_deportivas" VALUES (28, 'Fútbol Femenino', 'imagenes/BEJt35SBNwQGn7N1HjUtjZYlJ87MmcvS3IrQuth1.jpg', NULL, 't', '2025-12-22 14:08:30', '2025-12-22 14:08:30', '00');
INSERT INTO "public"."disciplinas_deportivas" VALUES (29, 'Fútbol 7', 'imagenes/tR9YjO0Dwx1QQXCdcXCSU998570iXE51bthSgs0w.jpg', NULL, 't', '2025-12-22 14:14:53', '2025-12-22 14:14:53', '0000');
INSERT INTO "public"."disciplinas_deportivas" VALUES (30, 'Futsal', 'imagenes/dTz0pY2dP3Mw47AbiTbBFwZN8AN9kY4w3p75ubyP.jpg', NULL, 't', '2025-12-30 11:11:13', '2025-12-30 11:12:45', '0');
INSERT INTO "public"."disciplinas_deportivas" VALUES (18, 'Baloncesto', 'imagenes/2LIR951iSunzhfqPjwDPRaP3xewc2JMAOW0usr0q.jpg', NULL, 't', '2025-11-10 15:16:26', '2025-12-30 11:17:56', '0');

-- ----------------------------
-- Table structure for docentes
-- ----------------------------
DROP TABLE IF EXISTS "public"."docentes";
CREATE TABLE "public"."docentes" (
  "user_id" int8 NOT NULL,
  "especialidad" varchar(100) COLLATE "pg_catalog"."default",
  "cv_url" text COLLATE "pg_catalog"."default",
  "numero_cuenta_bancaria" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying
)
;

-- ----------------------------
-- Records of docentes
-- ----------------------------
INSERT INTO "public"."docentes" VALUES (385, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (386, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (387, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (389, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (390, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (391, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (392, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (393, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (499, NULL, NULL, NULL);
INSERT INTO "public"."docentes" VALUES (500, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for evaluaciones
-- ----------------------------
DROP TABLE IF EXISTS "public"."evaluaciones";
CREATE TABLE "public"."evaluaciones" (
  "id" int8 NOT NULL DEFAULT nextval('evaluaciones_id_seq'::regclass),
  "matricula_id" int8 NOT NULL,
  "nombre_evaluacion" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "calificacion" numeric(4,2) NOT NULL,
  "fecha_evaluacion" date NOT NULL,
  "observacion" text COLLATE "pg_catalog"."default",
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone
)
;

-- ----------------------------
-- Records of evaluaciones
-- ----------------------------
INSERT INTO "public"."evaluaciones" VALUES (1, 1, 'Control de Balón', 16.50, '2025-09-29', 'Buen progreso en dominio.', NULL, NULL);
INSERT INTO "public"."evaluaciones" VALUES (2, 2, 'Pases Cortos', 14.00, '2025-09-29', 'Necesita mejorar precisión.', NULL, NULL);
INSERT INTO "public"."evaluaciones" VALUES (3, 4, 'Recepción Alta', 18.00, '2025-09-30', 'Excelente técnica.', NULL, NULL);
INSERT INTO "public"."evaluaciones" VALUES (4, 10, 'Apertura Italiana', 17.00, '2025-10-04', 'Conceptos básicos entendidos.', NULL, NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS "public"."failed_jobs";
CREATE TABLE "public"."failed_jobs" (
  "id" int8 NOT NULL DEFAULT nextval('failed_jobs_id_seq'::regclass),
  "uuid" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "connection" text COLLATE "pg_catalog"."default" NOT NULL,
  "queue" text COLLATE "pg_catalog"."default" NOT NULL,
  "payload" text COLLATE "pg_catalog"."default" NOT NULL,
  "exception" text COLLATE "pg_catalog"."default" NOT NULL,
  "failed_at" timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
)
;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for horarios
-- ----------------------------
DROP TABLE IF EXISTS "public"."horarios";
CREATE TABLE "public"."horarios" (
  "id" int8 NOT NULL DEFAULT nextval('horarios_id_seq'::regclass),
  "seccion_id" int8 NOT NULL,
  "dia_semana" "public"."horarios_dia_semana" NOT NULL,
  "hora_inicio" time(6) NOT NULL,
  "hora_fin" time(6) NOT NULL,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone
)
;

-- ----------------------------
-- Records of horarios
-- ----------------------------
INSERT INTO "public"."horarios" VALUES (94, 87, 'MARTES', '08:30:00', '09:30:00', '2025-12-22 12:48:42', '2025-12-22 12:48:42');
INSERT INTO "public"."horarios" VALUES (95, 87, 'JUEVES', '08:30:00', '09:30:00', '2025-12-22 12:48:42', '2025-12-22 12:48:42');
INSERT INTO "public"."horarios" VALUES (96, 88, 'MARTES', '09:30:00', '10:30:00', '2025-12-22 12:49:48', '2025-12-22 12:49:48');
INSERT INTO "public"."horarios" VALUES (97, 88, 'JUEVES', '09:30:00', '10:30:00', '2025-12-22 12:49:48', '2025-12-22 12:49:48');
INSERT INTO "public"."horarios" VALUES (98, 89, 'MARTES', '10:30:00', '11:30:00', '2025-12-22 12:51:40', '2025-12-22 12:51:40');
INSERT INTO "public"."horarios" VALUES (99, 89, 'JUEVES', '10:30:00', '11:30:00', '2025-12-22 12:51:40', '2025-12-22 12:51:40');
INSERT INTO "public"."horarios" VALUES (100, 90, 'MIÉRCOLES', '19:00:00', '21:00:00', '2025-12-22 12:52:46', '2025-12-22 12:52:46');
INSERT INTO "public"."horarios" VALUES (101, 90, 'VIERNES', '19:00:00', '21:00:00', '2025-12-22 12:52:46', '2025-12-22 12:52:46');
INSERT INTO "public"."horarios" VALUES (127, 120, 'MARTES', '09:30:00', '10:30:00', '2025-12-22 14:10:51', '2025-12-22 14:10:51');
INSERT INTO "public"."horarios" VALUES (128, 120, 'JUEVES', '09:30:00', '10:30:00', '2025-12-22 14:10:51', '2025-12-22 14:10:51');
INSERT INTO "public"."horarios" VALUES (129, 121, 'MARTES', '09:30:00', '10:30:00', '2025-12-22 14:11:35', '2025-12-22 14:11:35');
INSERT INTO "public"."horarios" VALUES (130, 121, 'JUEVES', '09:30:00', '10:30:00', '2025-12-22 14:11:35', '2025-12-22 14:11:35');
INSERT INTO "public"."horarios" VALUES (131, 122, 'MARTES', '08:00:00', '09:00:00', '2025-12-22 14:17:41', '2025-12-22 14:17:41');
INSERT INTO "public"."horarios" VALUES (132, 122, 'JUEVES', '08:00:00', '09:00:00', '2025-12-22 14:17:41', '2025-12-22 14:17:41');
INSERT INTO "public"."horarios" VALUES (133, 123, 'MARTES', '09:00:00', '10:00:00', '2025-12-22 14:18:55', '2025-12-22 14:18:55');
INSERT INTO "public"."horarios" VALUES (134, 123, 'JUEVES', '09:00:00', '01:00:00', '2025-12-22 14:18:55', '2025-12-22 14:18:55');
INSERT INTO "public"."horarios" VALUES (135, 124, 'MARTES', '10:00:00', '11:00:00', '2025-12-22 14:19:53', '2025-12-22 14:19:53');
INSERT INTO "public"."horarios" VALUES (136, 124, 'JUEVES', '10:00:00', '11:00:00', '2025-12-22 14:19:53', '2025-12-22 14:19:53');
INSERT INTO "public"."horarios" VALUES (137, 125, 'SÁBADO', '09:00:00', '13:00:00', '2025-12-22 14:46:03', '2025-12-22 14:46:03');
INSERT INTO "public"."horarios" VALUES (138, 126, 'MIÉRCOLES', '19:00:00', '21:00:00', '2025-12-29 10:23:37', '2025-12-29 10:23:37');
INSERT INTO "public"."horarios" VALUES (139, 126, 'VIERNES', '19:00:00', '21:00:00', '2025-12-29 10:23:37', '2025-12-29 10:23:37');
INSERT INTO "public"."horarios" VALUES (140, 127, 'MARTES', '19:00:00', '21:00:00', '2025-12-29 10:24:46', '2025-12-29 10:24:46');
INSERT INTO "public"."horarios" VALUES (141, 127, 'JUEVES', '19:00:00', '21:00:00', '2025-12-29 10:24:46', '2025-12-29 10:24:46');
INSERT INTO "public"."horarios" VALUES (142, 128, 'MARTES', '08:00:00', '09:00:00', '2025-12-30 11:15:05', '2025-12-30 11:15:05');
INSERT INTO "public"."horarios" VALUES (143, 128, 'JUEVES', '08:00:00', '09:00:00', '2025-12-30 11:15:05', '2025-12-30 11:15:05');
INSERT INTO "public"."horarios" VALUES (144, 129, 'MARTES', '09:00:00', '10:00:00', '2025-12-30 11:15:48', '2025-12-30 11:15:48');
INSERT INTO "public"."horarios" VALUES (145, 129, 'JUEVES', '09:00:00', '10:00:00', '2025-12-30 11:15:48', '2025-12-30 11:15:48');
INSERT INTO "public"."horarios" VALUES (146, 130, 'MARTES', '10:00:00', '11:00:00', '2025-12-30 11:16:23', '2025-12-30 11:16:23');
INSERT INTO "public"."horarios" VALUES (147, 130, 'JUEVES', '10:00:00', '11:00:00', '2025-12-30 11:16:23', '2025-12-30 11:16:23');
INSERT INTO "public"."horarios" VALUES (148, 131, 'MIÉRCOLES', '09:00:00', '10:00:00', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."horarios" VALUES (149, 131, 'VIERNES', '09:00:00', '10:00:00', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."horarios" VALUES (150, 132, 'MIÉRCOLES', '10:00:00', '11:00:00', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."horarios" VALUES (151, 132, 'VIERNES', '10:00:00', '11:00:00', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."horarios" VALUES (152, 133, 'MARTES', '09:00:00', '10:00:00', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."horarios" VALUES (153, 133, 'JUEVES', '09:00:00', '10:00:00', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."horarios" VALUES (154, 134, 'MARTES', '10:00:00', '11:00:00', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."horarios" VALUES (155, 134, 'JUEVES', '10:00:00', '11:00:00', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."horarios" VALUES (156, 135, 'MARTES', '08:00:00', '09:00:00', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."horarios" VALUES (157, 135, 'JUEVES', '08:00:00', '09:00:00', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."horarios" VALUES (158, 136, 'MARTES', '09:00:00', '10:00:00', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."horarios" VALUES (159, 136, 'JUEVES', '09:00:00', '10:00:00', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."horarios" VALUES (160, 137, 'MIÉRCOLES', '09:00:00', '10:00:00', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."horarios" VALUES (161, 137, 'VIERNES', '09:00:00', '10:00:00', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."horarios" VALUES (162, 138, 'MIÉRCOLES', '10:00:00', '11:00:00', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."horarios" VALUES (163, 138, 'VIERNES', '10:00:00', '11:00:00', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."horarios" VALUES (166, 140, 'MARTES', '10:00:00', '11:00:00', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."horarios" VALUES (167, 140, 'JUEVES', '10:00:00', '11:00:00', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."horarios" VALUES (164, 139, 'SÁBADO', '18:00:00', '20:00:00', '2025-12-30 12:58:47', '2025-12-30 17:24:39');
INSERT INTO "public"."horarios" VALUES (165, 139, 'DOMINGO', '18:00:00', '20:00:00', '2025-12-30 12:58:47', '2025-12-30 17:24:39');

-- ----------------------------
-- Table structure for inscripcion_alumnos
-- ----------------------------
DROP TABLE IF EXISTS "public"."inscripcion_alumnos";
CREATE TABLE "public"."inscripcion_alumnos" (
  "apellido_paterno" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "apellido_materno" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "fecha_nacimiento" date NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default",
  "direccion" varchar(255) COLLATE "pg_catalog"."default",
  "tipo_documento" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "numero_documento" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "celular" varchar(255) COLLATE "pg_catalog"."default",
  "user_id" int4,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "nombres" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "id" int8 NOT NULL DEFAULT nextval('orden_alumnos_id_seq'::regclass),
  "numero_conadis" varchar(255) COLLATE "pg_catalog"."default",
  "distrito" varchar(255) COLLATE "pg_catalog"."default",
  "numero_contribuyente" varchar(255) COLLATE "pg_catalog"."default",
  "codigo_distrito" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of inscripcion_alumnos
-- ----------------------------

-- ----------------------------
-- Table structure for inscripcion_apoderados
-- ----------------------------
DROP TABLE IF EXISTS "public"."inscripcion_apoderados";
CREATE TABLE "public"."inscripcion_apoderados" (
  "nombres" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "apellido_paterno" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "apellido_materno" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "fecha_nacimiento" date,
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "direccion" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "tipo_documento" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "numero_documento" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "celular" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "user_id" int8,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "id" int8 NOT NULL DEFAULT nextval('orden_apoderados_id_seq'::regclass),
  "distrito" varchar(255) COLLATE "pg_catalog"."default",
  "numero_contribuyente" varchar(255) COLLATE "pg_catalog"."default",
  "codigo_distrito" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of inscripcion_apoderados
-- ----------------------------

-- ----------------------------
-- Table structure for inscripciones
-- ----------------------------
DROP TABLE IF EXISTS "public"."inscripciones";
CREATE TABLE "public"."inscripciones" (
  "id" int8 NOT NULL DEFAULT nextval('pre_inscripcion_id_seq'::regclass),
  "seccion_id" int8 NOT NULL,
  "tipo_inscripcion" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
  "monto" numeric(8,2) NOT NULL,
  "estado" varchar(20) COLLATE "pg_catalog"."default",
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "comprobante_path" varchar(255) COLLATE "pg_catalog"."default",
  "comprobante_subido_en" timestamp(0),
  "numero_orden" varchar(10) COLLATE "pg_catalog"."default",
  "visanet_auth_code" varchar(255) COLLATE "pg_catalog"."default",
  "reference_uuid" uuid NOT NULL,
  "pasarela_transaccion_id" varchar COLLATE "pg_catalog"."default",
  "inscripcion_apoderado_id" int8,
  "inscripcion_alumno_id" int8,
  "pago_id" int8,
  "user_id" int8,
  "es_vecino" bool,
  "numero_liquidacion" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of inscripciones
-- ----------------------------

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS "public"."job_batches";
CREATE TABLE "public"."job_batches" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "total_jobs" int4 NOT NULL,
  "pending_jobs" int4 NOT NULL,
  "failed_jobs" int4 NOT NULL,
  "failed_job_ids" text COLLATE "pg_catalog"."default" NOT NULL,
  "options" text COLLATE "pg_catalog"."default",
  "cancelled_at" int4,
  "created_at" int4 NOT NULL,
  "finished_at" int4
)
;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS "public"."jobs";
CREATE TABLE "public"."jobs" (
  "id" int8 NOT NULL DEFAULT nextval('jobs_id_seq'::regclass),
  "queue" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "payload" text COLLATE "pg_catalog"."default" NOT NULL,
  "attempts" int2 NOT NULL,
  "reserved_at" int4,
  "available_at" int4 NOT NULL,
  "created_at" int4 NOT NULL
)
;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for lugares
-- ----------------------------
DROP TABLE IF EXISTS "public"."lugares";
CREATE TABLE "public"."lugares" (
  "id" int8 NOT NULL DEFAULT nextval('lugares_id_seq'::regclass),
  "nombre" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "direccion" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "descripcion" text COLLATE "pg_catalog"."default",
  "created_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP,
  "link_maps" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."lugares"."nombre" IS 'Ej: Estadio Municipal, Coliseo Cerrado';
COMMENT ON COLUMN "public"."lugares"."direccion" IS 'Ej: Av. La Molina 123';
COMMENT ON COLUMN "public"."lugares"."descripcion" IS 'Información adicional sobre el lugar, como puntos de referencia o capacidad.';

-- ----------------------------
-- Records of lugares
-- ----------------------------
INSERT INTO "public"."lugares" VALUES (8, 'Covima', 'W3P5+87P, La Molina 15012', NULL, '2025-11-10 15:11:35', '2025-11-11 14:39:13', 'https://maps.app.goo.gl/2sf9otcCuz9KiJ578');
INSERT INTO "public"."lugares" VALUES (9, 'El valle', 'V3W4+QRH, Lima 15024', NULL, '2025-11-10 15:12:59', '2025-11-11 14:40:07', 'https://maps.app.goo.gl/iwkipU8ohLNhmqUQ8');
INSERT INTO "public"."lugares" VALUES (10, 'Los Pinos', 'La Molina 15023', NULL, '2025-11-10 15:13:08', '2025-11-11 14:40:43', 'https://maps.app.goo.gl/tiCgsyAoxiJwgFRz5');
INSERT INTO "public"."lugares" VALUES (11, 'Matazango', 'Calle Camino Real Mz. R, Lima 15023', NULL, '2025-11-10 15:13:34', '2025-11-11 14:44:57', 'https://maps.app.goo.gl/Qp4TzouSRgUQkk8z8');
INSERT INTO "public"."lugares" VALUES (12, 'Musa', 'W466+XMX, La Molina 15026', NULL, '2025-11-10 15:13:51', '2025-11-11 14:45:57', 'https://maps.app.goo.gl/qVJuE552GLjn7Bd1A');
INSERT INTO "public"."lugares" VALUES (13, 'Viña alta', 'W354+5G2, La Molina 15024', NULL, '2025-11-10 15:14:17', '2025-11-11 14:46:32', 'https://maps.app.goo.gl/qf6antTjBA5XV5LDA');
INSERT INTO "public"."lugares" VALUES (14, 'Estadio Municipal', 'aaaa', NULL, '2025-12-22 12:23:15', '2025-12-22 12:23:15', 'aaaa');
INSERT INTO "public"."lugares" VALUES (15, 'Complejo César Vidaurre Reina Farje', 'A', NULL, '2025-12-22 14:45:19', '2025-12-22 14:45:19', 'A');
INSERT INTO "public"."lugares" VALUES (16, 'Losa Humboldt', 'av, a tal', NULL, '2025-12-30 11:28:45', '2025-12-30 11:28:52', 'https://maps.app.goo.gl/PsavdPUCXy7JJKWY8');
INSERT INTO "public"."lugares" VALUES (17, 'San César', 'aaa', NULL, '2025-12-30 14:48:07', '2025-12-30 14:48:07', 'aaaaa');

-- ----------------------------
-- Table structure for matriculas
-- ----------------------------
DROP TABLE IF EXISTS "public"."matriculas";
CREATE TABLE "public"."matriculas" (
  "id" int8 NOT NULL DEFAULT nextval('matriculas_id_seq'::regclass),
  "alumno_id" int8 NOT NULL,
  "seccion_id" int8 NOT NULL,
  "fecha_matricula" timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "estado" "public"."matriculas_estado" NOT NULL DEFAULT 'ACTIVA'::matriculas_estado,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "deleted_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "orden_id" int8
)
;

-- ----------------------------
-- Records of matriculas
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS "public"."migrations";
CREATE TABLE "public"."migrations" (
  "id" int4 NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
  "migration" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "batch" int4 NOT NULL
)
;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO "public"."migrations" VALUES (1, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO "public"."migrations" VALUES (2, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO "public"."migrations" VALUES (3, '0001_01_01_000000_create_users_table', 2);

-- ----------------------------
-- Table structure for padres
-- ----------------------------
DROP TABLE IF EXISTS "public"."padres";
CREATE TABLE "public"."padres" (
  "user_id" int8 NOT NULL,
  "parentesco" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone
)
;

-- ----------------------------
-- Records of padres
-- ----------------------------

-- ----------------------------
-- Table structure for pagos
-- ----------------------------
DROP TABLE IF EXISTS "public"."pagos";
CREATE TABLE "public"."pagos" (
  "id" int8 NOT NULL DEFAULT nextval('pagos_id_seq'::regclass),
  "cronograma_pago_id" int8 NOT NULL,
  "monto_pagado" numeric(10,2) NOT NULL,
  "fecha_pago" timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "metodo_pago" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "codigo_operacion" varchar(100) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "comprobante_url" text COLLATE "pg_catalog"."default",
  "tesoreria_id" int8,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "numero_orden" varchar(255) COLLATE "pg_catalog"."default",
  "user_id" int4,
  "pagos_niubiz_id" int4
)
;
COMMENT ON COLUMN "public"."pagos"."tesoreria_id" IS 'Usuario de tesorería que registró el pago';

-- ----------------------------
-- Records of pagos
-- ----------------------------

-- ----------------------------
-- Table structure for pagos_docentes
-- ----------------------------
DROP TABLE IF EXISTS "public"."pagos_docentes";
CREATE TABLE "public"."pagos_docentes" (
  "id" int8 NOT NULL DEFAULT nextval('pagos_docentes_id_seq'::regclass),
  "docente_id" int8 NOT NULL,
  "periodo_pago" varchar(20) COLLATE "pg_catalog"."default" NOT NULL,
  "horas_dictadas" int4 NOT NULL,
  "monto_por_hora" numeric(10,2) NOT NULL,
  "monto_total" numeric(10,2) NOT NULL,
  "fecha_pago" date,
  "estado" "public"."pagos_docentes_estado" NOT NULL DEFAULT 'PENDIENTE'::pagos_docentes_estado,
  "tesoreria_id" int8,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone
)
;
COMMENT ON COLUMN "public"."pagos_docentes"."tesoreria_id" IS 'Usuario de tesorería que procesó el pago';

-- ----------------------------
-- Records of pagos_docentes
-- ----------------------------

-- ----------------------------
-- Table structure for pagos_niubiz
-- ----------------------------
DROP TABLE IF EXISTS "public"."pagos_niubiz";
CREATE TABLE "public"."pagos_niubiz" (
  "id" int8 NOT NULL DEFAULT nextval('pagos_niubiz_id_seq'::regclass),
  "num_orden_niubiz" varchar(255) COLLATE "pg_catalog"."default",
  "id_transaccion_niubiz" varchar(255) COLLATE "pg_catalog"."default",
  "codigo_autorizacion" varchar(255) COLLATE "pg_catalog"."default",
  "monto_pagado" numeric(255,0),
  "moneda" varchar(255) COLLATE "pg_catalog"."default",
  "marca_tarjeta" varchar(255) COLLATE "pg_catalog"."default",
  "tarjeta_enmascarada" varchar(255) COLLATE "pg_catalog"."default",
  "codigo_accion" varchar(255) COLLATE "pg_catalog"."default",
  "descripcion_estado" varchar(255) COLLATE "pg_catalog"."default",
  "fecha_transaccion" varchar(255) COLLATE "pg_catalog"."default",
  "ecoreTransactionUUID" uuid,
  "merchantId" int4,
  "terminalId" varchar(32) COLLATE "pg_catalog"."default",
  "captureType" varchar(255) COLLATE "pg_catalog"."default",
  "tokenId" varchar(32) COLLATE "pg_catalog"."default",
  "estado" varchar(255) COLLATE "pg_catalog"."default",
  "eci_descripcion" varchar(255) COLLATE "pg_catalog"."default",
  "json_niubiz" json,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "id_unico" varchar(255) COLLATE "pg_catalog"."default",
  "brand" varchar(255) COLLATE "pg_catalog"."default",
  "inscripcion_id" int8,
  "cronograma_pago_id" int8,
  "trace_number" varchar(255) COLLATE "pg_catalog"."default",
  "id_resolutor" varchar(255) COLLATE "pg_catalog"."default",
  "signature" varchar(255) COLLATE "pg_catalog"."default",
  "authorization_code" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of pagos_niubiz
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."password_reset_tokens";
CREATE TABLE "public"."password_reset_tokens" (
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "token" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(0)
)
;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for periodos
-- ----------------------------
DROP TABLE IF EXISTS "public"."periodos";
CREATE TABLE "public"."periodos" (
  "ciclo" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "id" int8 NOT NULL DEFAULT nextval('periodos_id_seq'::regclass),
  "anio" int8,
  "fecha_inicio" date,
  "fecha_fin" date
)
;

-- ----------------------------
-- Records of periodos
-- ----------------------------
INSERT INTO "public"."periodos" VALUES ('Regular', 7, 2025, '2025-11-10', '2026-01-31');
INSERT INTO "public"."periodos" VALUES ('Verano', 9, 2026, '2026-01-01', '2026-03-21');

-- ----------------------------
-- Table structure for secciones
-- ----------------------------
DROP TABLE IF EXISTS "public"."secciones";
CREATE TABLE "public"."secciones" (
  "id" int8 NOT NULL DEFAULT nextval('secciones_id_seq'::regclass),
  "taller_id" int8 NOT NULL,
  "docente_id" int8,
  "lugar_id" int8,
  "nombre" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "vacantes" int4 NOT NULL,
  "vacantes_disponibles" int4 DEFAULT 0,
  "activo" bool NOT NULL DEFAULT true,
  "created_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP,
  "periodo_id" int8 NOT NULL DEFAULT nextval('secciones_periodo_id_seq'::regclass),
  "fecha_inicio" date,
  "fecha_fin" date
)
;
COMMENT ON COLUMN "public"."secciones"."vacantes_disponibles" IS 'Se puede actualizar con un trigger o desde la aplicación';

-- ----------------------------
-- Records of secciones
-- ----------------------------
INSERT INTO "public"."secciones" VALUES (125, 65, 385, 15, 'A', 30, 0, 't', '2025-12-22 14:46:03', '2025-12-24 10:11:35', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (124, 64, 393, 9, 'C', 20, 0, 't', '2025-12-22 14:19:53', '2025-12-24 10:11:50', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (123, 63, 392, 9, 'B', 20, 0, 't', '2025-12-22 14:18:55', '2025-12-24 10:12:05', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (122, 62, 389, 9, 'A', 20, 0, 't', '2025-12-22 14:17:42', '2025-12-24 10:12:11', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (121, 61, 385, 14, 'B', 20, 0, 't', '2025-12-22 14:11:35', '2025-12-24 10:12:21', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (120, 60, 391, 14, 'A', 20, 0, 't', '2025-12-22 14:10:51', '2025-12-24 10:12:28', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (90, 19, 392, 14, 'D', 15, 0, 't', '2025-12-22 12:52:47', '2025-12-24 10:12:44', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (89, 27, 387, 14, 'C', 20, 0, 't', '2025-12-22 12:51:40', '2025-12-24 10:14:14', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (88, 24, 386, 14, 'B', 30, 0, 't', '2025-12-22 12:49:49', '2025-12-24 10:14:23', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (87, 25, 385, 14, 'A', 30, 0, 't', '2025-12-22 12:48:42', '2025-12-24 10:14:29', 9, '2025-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (126, 66, 385, 9, 'MUJERES', 10, 0, 't', '2025-12-29 10:23:38', '2025-12-29 10:23:38', 9, '2025-01-01', '2025-03-21');
INSERT INTO "public"."secciones" VALUES (127, 66, 387, 9, 'HOMBRES', 7, 0, 't', '2025-12-29 10:24:47', '2025-12-29 10:24:47', 9, '2025-01-01', '2025-03-21');
INSERT INTO "public"."secciones" VALUES (128, 67, 389, 8, 'A', 15, 0, 't', '2025-12-30 11:15:05', '2025-12-30 11:20:50', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (130, 69, 389, 8, 'C', 20, 0, 't', '2025-12-30 11:16:23', '2025-12-30 11:21:03', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (129, 68, 387, 8, 'B', 15, 0, 't', '2025-12-30 11:15:49', '2025-12-30 11:21:11', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (131, 70, 386, 8, 'A', 20, 0, 't', '2025-12-30 11:23:59', '2025-12-30 11:23:59', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (132, 71, 387, 8, 'B', 20, 0, 't', '2025-12-30 11:26:19', '2025-12-30 11:26:19', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (133, 70, 390, 16, 'C', 20, 0, 't', '2025-12-30 11:29:49', '2025-12-30 11:29:49', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (134, 71, 387, 16, 'D', 15, 0, 't', '2025-12-30 11:30:38', '2025-12-30 11:30:38', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (135, 70, 392, 9, 'E', 20, 0, 't', '2025-12-30 11:32:11', '2025-12-30 11:32:11', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (136, 71, 387, 9, 'F', 20, 0, 't', '2025-12-30 11:35:23', '2025-12-30 11:35:23', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (137, 70, 385, 15, 'G', 15, 0, 't', '2025-12-30 11:36:08', '2025-12-30 11:36:08', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (138, 71, 386, 15, 'H', 20, 0, 't', '2025-12-30 11:37:02', '2025-12-30 11:37:02', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (139, 72, 389, 9, 'G', 20, 0, 't', '2025-12-30 12:58:48', '2025-12-30 12:58:48', 9, '2026-01-01', '2026-03-21');
INSERT INTO "public"."secciones" VALUES (140, 73, 385, 17, 'Intermedio/avanzado - A', 20, 0, 't', '2025-12-30 14:52:33', '2025-12-30 14:52:33', 9, '2026-01-01', '2026-03-21');

-- ----------------------------
-- Table structure for sesiones
-- ----------------------------
DROP TABLE IF EXISTS "public"."sesiones";
CREATE TABLE "public"."sesiones" (
  "id" int8 NOT NULL DEFAULT nextval('sesiones_id_seq'::regclass),
  "seccion_id" int4 NOT NULL,
  "fecha" date NOT NULL,
  "estado" "public"."sesiones_estado",
  "created_at" timestamp(6),
  "updated_at" timestamp(6)
)
;

-- ----------------------------
-- Records of sesiones
-- ----------------------------
INSERT INTO "public"."sesiones" VALUES (1239, 128, '2026-01-01', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1240, 128, '2026-01-06', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1241, 128, '2026-01-08', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1242, 128, '2026-01-13', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1243, 128, '2026-01-15', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1244, 128, '2026-01-20', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1245, 128, '2026-01-22', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1246, 128, '2026-01-27', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1247, 128, '2026-01-29', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1248, 128, '2026-02-03', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1249, 128, '2026-02-05', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1250, 128, '2026-02-10', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1251, 128, '2026-02-12', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1252, 128, '2026-02-17', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1253, 128, '2026-02-19', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1254, 128, '2026-02-24', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1255, 128, '2026-02-26', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1256, 128, '2026-03-03', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1257, 128, '2026-03-05', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1258, 128, '2026-03-10', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1259, 128, '2026-03-12', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1260, 128, '2026-03-17', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1261, 128, '2026-03-19', 'Pendiente', '2025-12-30 11:20:50', '2025-12-30 11:20:50');
INSERT INTO "public"."sesiones" VALUES (1301, 129, '2026-02-26', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1302, 129, '2026-03-03', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1303, 129, '2026-03-05', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1304, 129, '2026-03-10', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1305, 129, '2026-03-12', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1306, 129, '2026-03-17', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1307, 129, '2026-03-19', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1331, 132, '2026-01-02', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1332, 132, '2026-01-07', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1333, 132, '2026-01-09', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1334, 132, '2026-01-14', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1335, 132, '2026-01-16', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1336, 132, '2026-01-21', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1337, 132, '2026-01-23', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1338, 132, '2026-01-28', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1339, 132, '2026-01-30', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1340, 132, '2026-02-04', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1341, 132, '2026-02-06', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1342, 132, '2026-02-11', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1343, 132, '2026-02-13', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1344, 132, '2026-02-18', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1345, 132, '2026-02-20', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1346, 132, '2026-02-25', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1347, 132, '2026-02-27', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1348, 132, '2026-03-04', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1349, 132, '2026-03-06', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1350, 132, '2026-03-11', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1351, 132, '2026-03-13', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1352, 132, '2026-03-18', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1353, 132, '2026-03-20', 'Pendiente', '2025-12-30 11:26:19', '2025-12-30 11:26:19');
INSERT INTO "public"."sesiones" VALUES (1377, 134, '2026-01-01', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1378, 134, '2026-01-06', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1379, 134, '2026-01-08', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1380, 134, '2026-01-13', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1381, 134, '2026-01-15', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1382, 134, '2026-01-20', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1383, 134, '2026-01-22', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1384, 134, '2026-01-27', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1385, 134, '2026-01-29', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1386, 134, '2026-02-03', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1387, 134, '2026-02-05', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1388, 134, '2026-02-10', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1389, 134, '2026-02-12', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1390, 134, '2026-02-17', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1391, 134, '2026-02-19', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1392, 134, '2026-02-24', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1393, 134, '2026-02-26', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1394, 134, '2026-03-03', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1395, 134, '2026-03-05', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1396, 134, '2026-03-10', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1397, 134, '2026-03-12', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1398, 134, '2026-03-17', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1399, 134, '2026-03-19', 'Pendiente', '2025-12-30 11:30:37', '2025-12-30 11:30:37');
INSERT INTO "public"."sesiones" VALUES (1410, 135, '2026-02-05', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1411, 135, '2026-02-10', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1412, 135, '2026-02-12', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1413, 135, '2026-02-17', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1414, 135, '2026-02-19', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1415, 135, '2026-02-24', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1416, 135, '2026-02-26', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1417, 135, '2026-03-03', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1418, 135, '2026-03-05', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1419, 135, '2026-03-10', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1420, 135, '2026-03-12', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1421, 135, '2026-03-17', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1422, 135, '2026-03-19', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1423, 136, '2026-01-01', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1424, 136, '2026-01-06', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1425, 136, '2026-01-08', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1426, 136, '2026-01-13', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1427, 136, '2026-01-15', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1428, 136, '2026-01-20', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1429, 136, '2026-01-22', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1430, 136, '2026-01-27', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1262, 130, '2026-01-01', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1263, 130, '2026-01-06', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1264, 130, '2026-01-08', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1265, 130, '2026-01-13', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1266, 130, '2026-01-15', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1267, 130, '2026-01-20', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1268, 130, '2026-01-22', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1269, 130, '2026-01-27', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1270, 130, '2026-01-29', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1271, 130, '2026-02-03', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1272, 130, '2026-02-05', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1273, 130, '2026-02-10', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1274, 130, '2026-02-12', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1275, 130, '2026-02-17', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1276, 130, '2026-02-19', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1277, 130, '2026-02-24', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1278, 130, '2026-02-26', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1279, 130, '2026-03-03', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1280, 130, '2026-03-05', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1281, 130, '2026-03-10', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1282, 130, '2026-03-12', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1283, 130, '2026-03-17', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1284, 130, '2026-03-19', 'Pendiente', '2025-12-30 11:21:02', '2025-12-30 11:21:02');
INSERT INTO "public"."sesiones" VALUES (1308, 131, '2026-01-02', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1309, 131, '2026-01-07', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1310, 131, '2026-01-09', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1311, 131, '2026-01-14', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1312, 131, '2026-01-16', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1313, 131, '2026-01-21', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1314, 131, '2026-01-23', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1315, 131, '2026-01-28', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1316, 131, '2026-01-30', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1317, 131, '2026-02-04', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1318, 131, '2026-02-06', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1319, 131, '2026-02-11', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1320, 131, '2026-02-13', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1321, 131, '2026-02-18', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1322, 131, '2026-02-20', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1323, 131, '2026-02-25', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1324, 131, '2026-02-27', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1325, 131, '2026-03-04', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1326, 131, '2026-03-06', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1327, 131, '2026-03-11', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1328, 131, '2026-03-13', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1329, 131, '2026-03-18', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1330, 131, '2026-03-20', 'Pendiente', '2025-12-30 11:23:58', '2025-12-30 11:23:58');
INSERT INTO "public"."sesiones" VALUES (1354, 133, '2026-01-01', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1355, 133, '2026-01-06', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1356, 133, '2026-01-08', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1357, 133, '2026-01-13', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1358, 133, '2026-01-15', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1359, 133, '2026-01-20', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1360, 133, '2026-01-22', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1361, 133, '2026-01-27', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1362, 133, '2026-01-29', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1363, 133, '2026-02-03', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1364, 133, '2026-02-05', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1365, 133, '2026-02-10', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1366, 133, '2026-02-12', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1367, 133, '2026-02-17', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1368, 133, '2026-02-19', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1369, 133, '2026-02-24', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1370, 133, '2026-02-26', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1371, 133, '2026-03-03', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1372, 133, '2026-03-05', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1373, 133, '2026-03-10', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1374, 133, '2026-03-12', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1375, 133, '2026-03-17', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1376, 133, '2026-03-19', 'Pendiente', '2025-12-30 11:29:49', '2025-12-30 11:29:49');
INSERT INTO "public"."sesiones" VALUES (1400, 135, '2026-01-01', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1401, 135, '2026-01-06', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1402, 135, '2026-01-08', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1403, 135, '2026-01-13', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1404, 135, '2026-01-15', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1405, 135, '2026-01-20', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1406, 135, '2026-01-22', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1407, 135, '2026-01-27', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (885, 125, '2026-01-03', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (886, 125, '2026-01-10', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (887, 125, '2026-01-17', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (888, 125, '2026-01-24', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (889, 125, '2026-01-31', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (890, 125, '2026-02-07', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (891, 125, '2026-02-14', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (892, 125, '2026-02-21', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (893, 125, '2026-02-28', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (894, 125, '2026-03-07', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (895, 125, '2026-03-14', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (896, 125, '2026-03-21', 'Pendiente', '2025-12-24 10:11:34', '2025-12-24 10:11:34');
INSERT INTO "public"."sesiones" VALUES (1408, 135, '2026-01-29', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (1409, 135, '2026-02-03', 'Pendiente', '2025-12-30 11:32:10', '2025-12-30 11:32:10');
INSERT INTO "public"."sesiones" VALUES (899, 124, '2026-01-01', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (900, 124, '2026-01-06', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (901, 124, '2026-01-08', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (902, 124, '2026-01-13', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (903, 124, '2026-01-15', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (904, 124, '2026-01-20', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (905, 124, '2026-01-22', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (906, 124, '2026-01-27', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (907, 124, '2026-01-29', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (908, 124, '2026-02-03', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (909, 124, '2026-02-05', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (910, 124, '2026-02-10', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (911, 124, '2026-02-12', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (912, 124, '2026-02-17', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (913, 124, '2026-02-19', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (914, 124, '2026-02-24', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (915, 124, '2026-02-26', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (916, 124, '2026-03-03', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (917, 124, '2026-03-05', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (918, 124, '2026-03-10', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (919, 124, '2026-03-12', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (920, 124, '2026-03-17', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (921, 124, '2026-03-19', 'Pendiente', '2025-12-24 10:11:49', '2025-12-24 10:11:49');
INSERT INTO "public"."sesiones" VALUES (924, 123, '2026-01-01', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (925, 123, '2026-01-06', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (926, 123, '2026-01-08', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (927, 123, '2026-01-13', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (928, 123, '2026-01-15', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (929, 123, '2026-01-20', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (930, 123, '2026-01-22', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (931, 123, '2026-01-27', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (932, 123, '2026-01-29', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (933, 123, '2026-02-03', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (934, 123, '2026-02-05', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (935, 123, '2026-02-10', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (936, 123, '2026-02-12', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (937, 123, '2026-02-17', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (938, 123, '2026-02-19', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (939, 123, '2026-02-24', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (940, 123, '2026-02-26', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (941, 123, '2026-03-03', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (942, 123, '2026-03-05', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (943, 123, '2026-03-10', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (944, 123, '2026-03-12', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (945, 123, '2026-03-17', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (946, 123, '2026-03-19', 'Pendiente', '2025-12-24 10:12:04', '2025-12-24 10:12:04');
INSERT INTO "public"."sesiones" VALUES (949, 122, '2026-01-01', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (950, 122, '2026-01-06', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (951, 122, '2026-01-08', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (952, 122, '2026-01-13', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (953, 122, '2026-01-15', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (954, 122, '2026-01-20', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (955, 122, '2026-01-22', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (956, 122, '2026-01-27', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (957, 122, '2026-01-29', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (958, 122, '2026-02-03', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (959, 122, '2026-02-05', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (960, 122, '2026-02-10', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (961, 122, '2026-02-12', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (962, 122, '2026-02-17', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (963, 122, '2026-02-19', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (964, 122, '2026-02-24', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (965, 122, '2026-02-26', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (966, 122, '2026-03-03', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (967, 122, '2026-03-05', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (968, 122, '2026-03-10', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (969, 122, '2026-03-12', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (970, 122, '2026-03-17', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (971, 122, '2026-03-19', 'Pendiente', '2025-12-24 10:12:11', '2025-12-24 10:12:11');
INSERT INTO "public"."sesiones" VALUES (974, 121, '2026-01-01', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (975, 121, '2026-01-06', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (976, 121, '2026-01-08', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (977, 121, '2026-01-13', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (978, 121, '2026-01-15', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (979, 121, '2026-01-20', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (980, 121, '2026-01-22', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (981, 121, '2026-01-27', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (982, 121, '2026-01-29', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (983, 121, '2026-02-03', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (984, 121, '2026-02-05', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (985, 121, '2026-02-10', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (986, 121, '2026-02-12', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (987, 121, '2026-02-17', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (988, 121, '2026-02-19', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (989, 121, '2026-02-24', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (990, 121, '2026-02-26', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (991, 121, '2026-03-03', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (992, 121, '2026-03-05', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (993, 121, '2026-03-10', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (994, 121, '2026-03-12', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (995, 121, '2026-03-17', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (996, 121, '2026-03-19', 'Pendiente', '2025-12-24 10:12:20', '2025-12-24 10:12:20');
INSERT INTO "public"."sesiones" VALUES (999, 120, '2026-01-01', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1000, 120, '2026-01-06', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1001, 120, '2026-01-08', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1002, 120, '2026-01-13', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1003, 120, '2026-01-15', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1004, 120, '2026-01-20', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1005, 120, '2026-01-22', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1006, 120, '2026-01-27', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1007, 120, '2026-01-29', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1008, 120, '2026-02-03', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1009, 120, '2026-02-05', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1010, 120, '2026-02-10', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1011, 120, '2026-02-12', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1012, 120, '2026-02-17', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1013, 120, '2026-02-19', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1014, 120, '2026-02-24', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1015, 120, '2026-02-26', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1016, 120, '2026-03-03', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1017, 120, '2026-03-05', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1018, 120, '2026-03-10', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1019, 120, '2026-03-12', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1020, 120, '2026-03-17', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1021, 120, '2026-03-19', 'Pendiente', '2025-12-24 10:12:28', '2025-12-24 10:12:28');
INSERT INTO "public"."sesiones" VALUES (1025, 90, '2026-01-02', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1026, 90, '2026-01-07', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1027, 90, '2026-01-09', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1028, 90, '2026-01-14', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1029, 90, '2026-01-16', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1030, 90, '2026-01-21', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1031, 90, '2026-01-23', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1032, 90, '2026-01-28', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1033, 90, '2026-01-30', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1034, 90, '2026-02-04', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1035, 90, '2026-02-06', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1036, 90, '2026-02-11', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1037, 90, '2026-02-13', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1038, 90, '2026-02-18', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1039, 90, '2026-02-20', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1040, 90, '2026-02-25', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1041, 90, '2026-02-27', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1042, 90, '2026-03-04', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1043, 90, '2026-03-06', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1044, 90, '2026-03-11', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1045, 90, '2026-03-13', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1046, 90, '2026-03-18', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1047, 90, '2026-03-20', 'Pendiente', '2025-12-24 10:12:43', '2025-12-24 10:12:43');
INSERT INTO "public"."sesiones" VALUES (1050, 89, '2026-01-01', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1051, 89, '2026-01-06', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1052, 89, '2026-01-08', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1053, 89, '2026-01-13', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1054, 89, '2026-01-15', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1055, 89, '2026-01-20', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1056, 89, '2026-01-22', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1057, 89, '2026-01-27', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1058, 89, '2026-01-29', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1059, 89, '2026-02-03', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1060, 89, '2026-02-05', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1061, 89, '2026-02-10', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1062, 89, '2026-02-12', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1063, 89, '2026-02-17', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1064, 89, '2026-02-19', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1065, 89, '2026-02-24', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1066, 89, '2026-02-26', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1067, 89, '2026-03-03', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1068, 89, '2026-03-05', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1069, 89, '2026-03-10', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1070, 89, '2026-03-12', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1071, 89, '2026-03-17', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1072, 89, '2026-03-19', 'Pendiente', '2025-12-24 10:14:14', '2025-12-24 10:14:14');
INSERT INTO "public"."sesiones" VALUES (1075, 88, '2026-01-01', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1076, 88, '2026-01-06', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1077, 88, '2026-01-08', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1078, 88, '2026-01-13', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1079, 88, '2026-01-15', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1080, 88, '2026-01-20', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1081, 88, '2026-01-22', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1082, 88, '2026-01-27', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1083, 88, '2026-01-29', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1084, 88, '2026-02-03', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1085, 88, '2026-02-05', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1086, 88, '2026-02-10', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1087, 88, '2026-02-12', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1088, 88, '2026-02-17', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1089, 88, '2026-02-19', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1090, 88, '2026-02-24', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1091, 88, '2026-02-26', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1092, 88, '2026-03-03', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1093, 88, '2026-03-05', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1094, 88, '2026-03-10', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1095, 88, '2026-03-12', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1096, 88, '2026-03-17', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1097, 88, '2026-03-19', 'Pendiente', '2025-12-24 10:14:22', '2025-12-24 10:14:22');
INSERT INTO "public"."sesiones" VALUES (1100, 87, '2026-01-01', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1101, 87, '2026-01-06', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1102, 87, '2026-01-08', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1103, 87, '2026-01-13', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1104, 87, '2026-01-15', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1105, 87, '2026-01-20', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1106, 87, '2026-01-22', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1107, 87, '2026-01-27', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1108, 87, '2026-01-29', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1109, 87, '2026-02-03', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1110, 87, '2026-02-05', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1111, 87, '2026-02-10', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1112, 87, '2026-02-12', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1113, 87, '2026-02-17', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1114, 87, '2026-02-19', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1115, 87, '2026-02-24', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1116, 87, '2026-02-26', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1117, 87, '2026-03-03', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1118, 87, '2026-03-05', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1119, 87, '2026-03-10', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1120, 87, '2026-03-12', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1121, 87, '2026-03-17', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1122, 87, '2026-03-19', 'Pendiente', '2025-12-24 10:14:28', '2025-12-24 10:14:28');
INSERT INTO "public"."sesiones" VALUES (1285, 129, '2026-01-01', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1286, 129, '2026-01-06', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1287, 129, '2026-01-08', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1288, 129, '2026-01-13', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1289, 129, '2026-01-15', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1290, 129, '2026-01-20', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1291, 129, '2026-01-22', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1292, 129, '2026-01-27', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1293, 129, '2026-01-29', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1294, 129, '2026-02-03', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1295, 129, '2026-02-05', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1296, 129, '2026-02-10', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1297, 129, '2026-02-12', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1298, 129, '2026-02-17', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1299, 129, '2026-02-19', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1300, 129, '2026-02-24', 'Pendiente', '2025-12-30 11:21:10', '2025-12-30 11:21:10');
INSERT INTO "public"."sesiones" VALUES (1431, 136, '2026-01-29', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1432, 136, '2026-02-03', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1433, 136, '2026-02-05', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1434, 136, '2026-02-10', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1435, 136, '2026-02-12', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1436, 136, '2026-02-17', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1437, 136, '2026-02-19', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1438, 136, '2026-02-24', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1439, 136, '2026-02-26', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1440, 136, '2026-03-03', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1441, 136, '2026-03-05', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1442, 136, '2026-03-10', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1443, 136, '2026-03-12', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1444, 136, '2026-03-17', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1445, 136, '2026-03-19', 'Pendiente', '2025-12-30 11:35:22', '2025-12-30 11:35:22');
INSERT INTO "public"."sesiones" VALUES (1446, 137, '2026-01-02', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1447, 137, '2026-01-07', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1448, 137, '2026-01-09', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1449, 137, '2026-01-14', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1450, 137, '2026-01-16', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1451, 137, '2026-01-21', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1452, 137, '2026-01-23', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1453, 137, '2026-01-28', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1454, 137, '2026-01-30', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1455, 137, '2026-02-04', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1456, 137, '2026-02-06', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1457, 137, '2026-02-11', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1458, 137, '2026-02-13', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1459, 137, '2026-02-18', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1460, 137, '2026-02-20', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1461, 137, '2026-02-25', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1462, 137, '2026-02-27', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1463, 137, '2026-03-04', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1464, 137, '2026-03-06', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1465, 137, '2026-03-11', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1466, 137, '2026-03-13', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1467, 137, '2026-03-18', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1468, 137, '2026-03-20', 'Pendiente', '2025-12-30 11:36:07', '2025-12-30 11:36:07');
INSERT INTO "public"."sesiones" VALUES (1469, 138, '2026-01-02', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1470, 138, '2026-01-07', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1471, 138, '2026-01-09', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1472, 138, '2026-01-14', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1473, 138, '2026-01-16', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1474, 138, '2026-01-21', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1475, 138, '2026-01-23', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1476, 138, '2026-01-28', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1477, 138, '2026-01-30', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1478, 138, '2026-02-04', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1479, 138, '2026-02-06', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1480, 138, '2026-02-11', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1481, 138, '2026-02-13', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1482, 138, '2026-02-18', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1483, 138, '2026-02-20', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1484, 138, '2026-02-25', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1485, 138, '2026-02-27', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1486, 138, '2026-03-04', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1487, 138, '2026-03-06', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1488, 138, '2026-03-11', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1489, 138, '2026-03-13', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1490, 138, '2026-03-18', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1491, 138, '2026-03-20', 'Pendiente', '2025-12-30 11:37:01', '2025-12-30 11:37:01');
INSERT INTO "public"."sesiones" VALUES (1515, 140, '2026-01-01', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1516, 140, '2026-01-06', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1517, 140, '2026-01-08', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1518, 140, '2026-01-13', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1519, 140, '2026-01-15', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1520, 140, '2026-01-20', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1521, 140, '2026-01-22', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1522, 140, '2026-01-27', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1523, 140, '2026-01-29', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1524, 140, '2026-02-03', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1525, 140, '2026-02-05', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1526, 140, '2026-02-10', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1527, 140, '2026-02-12', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1528, 140, '2026-02-17', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1529, 140, '2026-02-19', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1530, 140, '2026-02-24', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1531, 140, '2026-02-26', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1532, 140, '2026-03-03', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1533, 140, '2026-03-05', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1534, 140, '2026-03-10', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1535, 140, '2026-03-12', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1536, 140, '2026-03-17', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1537, 140, '2026-03-19', 'Pendiente', '2025-12-30 14:52:32', '2025-12-30 14:52:32');
INSERT INTO "public"."sesiones" VALUES (1538, 139, '2026-01-03', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1539, 139, '2026-01-10', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1540, 139, '2026-01-17', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1541, 139, '2026-01-24', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1542, 139, '2026-01-31', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1543, 139, '2026-02-07', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1544, 139, '2026-02-14', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1545, 139, '2026-02-21', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1546, 139, '2026-02-28', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1547, 139, '2026-03-07', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1548, 139, '2026-03-14', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');
INSERT INTO "public"."sesiones" VALUES (1549, 139, '2026-03-21', 'Pendiente', '2025-12-30 17:24:39', '2025-12-30 17:24:39');

-- ----------------------------
-- Table structure for talleres
-- ----------------------------
DROP TABLE IF EXISTS "public"."talleres";
CREATE TABLE "public"."talleres" (
  "id" int8 NOT NULL DEFAULT nextval('talleres_id_seq'::regclass),
  "disciplina_id" int8 NOT NULL,
  "categoria_id" int8 NOT NULL,
  "costo_matricula" numeric(10,2),
  "costo_mensualidad" numeric(10,2),
  "activo" bool NOT NULL DEFAULT true,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "deleted_at" timestamp(0) DEFAULT NULL::timestamp without time zone
)
;

-- ----------------------------
-- Records of talleres
-- ----------------------------
INSERT INTO "public"."talleres" VALUES (88, 19, 3, NULL, NULL, 't', '2026-01-08 08:55:03', '2026-01-08 08:55:03', NULL);
INSERT INTO "public"."talleres" VALUES (73, 6, 32, NULL, NULL, 't', '2025-12-30 14:50:05', '2026-01-08 09:15:34', NULL);
INSERT INTO "public"."talleres" VALUES (27, 1, 20, NULL, NULL, 't', '2025-12-22 12:50:23', '2026-01-08 09:32:46', NULL);
INSERT INTO "public"."talleres" VALUES (25, 1, 3, NULL, NULL, 't', '2025-12-22 12:35:03', '2026-01-08 09:44:54', NULL);
INSERT INTO "public"."talleres" VALUES (24, 1, 19, NULL, NULL, 't', '2025-12-15 09:57:08', '2026-01-08 09:45:11', NULL);
INSERT INTO "public"."talleres" VALUES (19, 1, 21, NULL, NULL, 't', '2025-11-11 14:28:51', '2026-01-08 09:53:13', NULL);
INSERT INTO "public"."talleres" VALUES (72, 2, 21, NULL, NULL, 't', '2025-12-30 12:44:21', '2026-01-08 10:07:45', NULL);
INSERT INTO "public"."talleres" VALUES (71, 18, 20, NULL, NULL, 't', '2025-12-30 11:18:56', '2026-01-08 10:11:18', NULL);
INSERT INTO "public"."talleres" VALUES (70, 18, 19, NULL, NULL, 't', '2025-12-30 11:18:35', '2026-01-08 10:11:32', NULL);
INSERT INTO "public"."talleres" VALUES (69, 30, 20, NULL, NULL, 't', '2025-12-30 11:13:30', '2026-01-08 10:13:01', NULL);
INSERT INTO "public"."talleres" VALUES (68, 30, 19, NULL, NULL, 't', '2025-12-30 11:13:19', '2026-01-08 10:13:24', NULL);
INSERT INTO "public"."talleres" VALUES (67, 30, 3, NULL, NULL, 't', '2025-12-30 11:13:00', '2026-01-08 10:13:46', NULL);
INSERT INTO "public"."talleres" VALUES (66, 29, 21, NULL, NULL, 't', '2025-12-29 10:22:20', '2026-01-08 10:17:06', NULL);
INSERT INTO "public"."talleres" VALUES (64, 29, 20, NULL, NULL, 't', '2025-12-22 14:16:07', '2026-01-08 10:18:16', NULL);
INSERT INTO "public"."talleres" VALUES (63, 29, 19, NULL, NULL, 't', '2025-12-22 14:15:51', '2026-01-08 10:18:38', NULL);
INSERT INTO "public"."talleres" VALUES (62, 29, 3, NULL, NULL, 't', '2025-12-22 14:15:33', '2026-01-08 10:18:54', NULL);
INSERT INTO "public"."talleres" VALUES (65, 4, 27, NULL, NULL, 't', '2025-12-22 14:44:36', '2026-01-08 10:20:37', NULL);
INSERT INTO "public"."talleres" VALUES (61, 28, 23, NULL, NULL, 't', '2025-12-22 14:09:32', '2026-01-08 14:22:48', NULL);
INSERT INTO "public"."talleres" VALUES (60, 28, 22, NULL, NULL, 't', '2025-12-22 14:09:16', '2026-01-08 14:23:02', NULL);
INSERT INTO "public"."talleres" VALUES (22, 19, 29, NULL, NULL, 't', '2025-11-11 14:32:53', '2026-01-08 14:23:50', NULL);
INSERT INTO "public"."talleres" VALUES (23, 20, 27, NULL, NULL, 't', '2025-11-11 14:33:03', '2026-01-08 14:30:13', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "id" int8 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  "nombres" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "apellido_paterno" varchar(100) COLLATE "pg_catalog"."default",
  "apellido_materno" varchar(100) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "tipo_documento" varchar(3) COLLATE "pg_catalog"."default" NOT NULL,
  "numero_documento" varchar(8) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(320) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "password" varchar(255) COLLATE "pg_catalog"."default",
  "telefono" varchar(9) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "direccion" text COLLATE "pg_catalog"."default",
  "fecha_nacimiento" date,
  "role" "public"."users_role",
  "activo" bool NOT NULL DEFAULT true,
  "email_verified_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "remember_token" varchar(100) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "created_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "updated_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "deleted_at" timestamp(0) DEFAULT NULL::timestamp without time zone,
  "numero_conadis" varchar(255) COLLATE "pg_catalog"."default",
  "es_docente" bool DEFAULT false
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES (394, 'Encargado', 'De', 'Sede', 'DNI', '02020202', 'encargado@email.com', '$2y$12$m9ZnmPjhSanY5ZAhs5PbauKAnpaIqLCz6sdBbJAOlpi6OsIXas1gi', NULL, NULL, NULL, 'ENCARGADO_SEDE', 't', NULL, NULL, '2025-11-12 08:17:21', '2026-01-13 09:22:19', NULL, NULL, 'f');
INSERT INTO "public"."users" VALUES (1, 'Admin', 'Principal', 'Del Sistema', 'DNI', '10101010', 'admin@molinatalleres.com', '$2y$12$IkK6pZgh0uvkDaUhqK5q1.h5nLm2P1F1DTEZ1Vqyb7m7Q5Jh.jzli', NULL, NULL, NULL, 'ADMIN', 't', NULL, NULL, NULL, '2026-01-13 10:58:00', NULL, NULL, 'f');
INSERT INTO "public"."users" VALUES (391, 'Olga', 'Verástegui', NULL, 'DNI', '66666666', 'overastegui@email.com', '$2y$12$dcrRNXusg1cDVXBUfXw43.6K1TX3D7aNvYzDmuIhzyK08PzUxz45K', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2025-11-11 14:24:18', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (386, 'Óscar', 'Sánchez', NULL, 'DNI', '22222222', 'osanchez@email.com', '$2y$12$1cJ/N62ZnV1oSnJ4B80z5.dD1qGEDcnL0PIgH1NZ543nasgEINYFy', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2025-11-11 14:20:31', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (385, 'Hugo', 'Melgar', NULL, 'DNI', '11111111', 'hmelgar@email.com', '$2y$12$Nw.GqOSDfqbGQBghGNaa/O6nFAf/ZRSdTTU638c/gs26Ub4L8Nzji', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2025-11-11 14:17:37', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (392, 'Daniel', 'Molina', 'Rojas', 'DNI', '77777777', 'daniel@email.com', '$2y$12$xJusm6cC7wdrxTMxW1/03OuNHBKF6Gp/CXbvWgOzTIGmI0rad8lPa', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2025-11-11 14:24:48', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (389, 'Dany', NULL, NULL, 'DNI', '44444444', 'dany@email.com', '$2y$12$69RUgwg.0.Offwvi1dv5zeiLbu0632PUzOOnJgdImKhbEXie98Cfq', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2025-11-11 14:22:23', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (393, 'Pedro', 'Cárdenas', NULL, 'DNI', '88888888', 'pcardenas@email.com', '$2y$12$HwPn1hpasOnDLJ1hm9mPSuFqhRJsOWNY7rBDao.SgOPM9/L.CZmkS', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2025-11-11 14:25:24', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (387, 'Alejandro', 'Valdivia', NULL, 'DNI', '33333333', 'avaldivia@email.com', '$2y$12$d1z1wx34WE/UYUJuhU6ueOOayMtLWxArgCa30WlbBcHxAIPfwkany', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2025-11-11 14:21:24', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (499, 'DOCENTE2', 'APEDOCENTE', 'APEDOCENTE', 'DNI', '99999999', 'DOCENTE2@EMAIL.COM', '$2y$12$ZUUSMoNmXyV0cpIAX5mv3Omze2lPbJ2JLhAFbI8Lh8OzaOrUmO.R6', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2026-01-13 10:52:01', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (500, 'DOCENTE3', 'APEDOCENTE3A', 'APEDOCENTE3', 'DNI', '88888889', 'DOCENTE3@EMAIL.COM', '$2y$12$RMLvVAzCbRwRccYW793GzORxvdOwlAqgydeW1K2e2qZRpMJo7.ZDO', NULL, NULL, NULL, 'DOCENTE', 'f', NULL, NULL, '2026-01-13 10:55:09', '2026-01-14 17:46:42', NULL, NULL, 't');
INSERT INTO "public"."users" VALUES (390, 'Mitsuo', NULL, NULL, 'DNI', '55555555', 'mitsuo@email.com', '$2y$12$hCOcE4E6pVBxsw7G9n8WXu0HiPbROlxKZ0oT6Q1fsG5RGjDJEWQXe', NULL, NULL, NULL, 'DOCENTE', 't', NULL, NULL, '2025-11-11 14:23:35', '2026-01-14 17:46:42', NULL, NULL, 't');

-- ----------------------------
-- Procedure structure for p_reiniciar_sistema_pruebas
-- ----------------------------
DROP PROCEDURE IF EXISTS "public"."p_reiniciar_sistema_pruebas"();
CREATE OR REPLACE PROCEDURE "public"."p_reiniciar_sistema_pruebas"()
 AS $BODY$
BEGIN
    DELETE FROM pagos_niubiz;
    DELETE FROM pagos;
    DELETE FROM inscripciones;
    DELETE FROM inscripcion_alumnos;
    DELETE FROM inscripcion_apoderados;
    DELETE FROM users WHERE role IN ('ALUMNO', 'PADRE');
    
    RAISE NOTICE 'Datos eliminados correctamente';
END;
$BODY$
  LANGUAGE plpgsql;

-- ----------------------------
-- Function structure for trigger_set_timestamp
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."trigger_set_timestamp"();
CREATE OR REPLACE FUNCTION "public"."trigger_set_timestamp"()
  RETURNS "pg_catalog"."trigger" AS $BODY$
BEGIN
  NEW.updated_at = NOW();
  RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."asistencias_id_seq"
OWNED BY "public"."asistencias"."id";
SELECT setval('"public"."asistencias_id_seq"', 236, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."categorias_id_seq"
OWNED BY "public"."categorias"."id";
SELECT setval('"public"."categorias_id_seq"', 40, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."codigos_tusnes_id_seq"
OWNED BY "public"."codigos_tusnes"."id";
SELECT setval('"public"."codigos_tusnes_id_seq"', 69, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cronograma_pagos_id_seq"
OWNED BY "public"."cronograma_pagos"."id";
SELECT setval('"public"."cronograma_pagos_id_seq"', 251, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."disciplinas_deportivas_id_seq"
OWNED BY "public"."disciplinas_deportivas"."id";
SELECT setval('"public"."disciplinas_deportivas_id_seq"', 30, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."evaluaciones_id_seq"
OWNED BY "public"."evaluaciones"."id";
SELECT setval('"public"."evaluaciones_id_seq"', 4, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."failed_jobs_id_seq"
OWNED BY "public"."failed_jobs"."id";
SELECT setval('"public"."failed_jobs_id_seq"', 9, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."horarios_id_seq"
OWNED BY "public"."horarios"."id";
SELECT setval('"public"."horarios_id_seq"', 167, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."jobs_id_seq"
OWNED BY "public"."jobs"."id";
SELECT setval('"public"."jobs_id_seq"', 110, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."lugares_id_seq"
OWNED BY "public"."lugares"."id";
SELECT setval('"public"."lugares_id_seq"', 18, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."matriculas_id_seq"
OWNED BY "public"."matriculas"."id";
SELECT setval('"public"."matriculas_id_seq"', 147, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."migrations_id_seq"
OWNED BY "public"."migrations"."id";
SELECT setval('"public"."migrations_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orden_alumnos_id_seq"
OWNED BY "public"."inscripcion_alumnos"."id";
SELECT setval('"public"."orden_alumnos_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orden_apoderados_id_seq"
OWNED BY "public"."inscripcion_apoderados"."id";
SELECT setval('"public"."orden_apoderados_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pagos_docentes_id_seq"
OWNED BY "public"."pagos_docentes"."id";
SELECT setval('"public"."pagos_docentes_id_seq"', 5, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pagos_id_seq"
OWNED BY "public"."pagos"."id";
SELECT setval('"public"."pagos_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pagos_niubiz_id_seq"
OWNED BY "public"."pagos_niubiz"."id";
SELECT setval('"public"."pagos_niubiz_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."periodos_id_seq"
OWNED BY "public"."periodos"."id";
SELECT setval('"public"."periodos_id_seq"', 12, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pre_inscripcion_id_seq"
OWNED BY "public"."inscripciones"."id";
SELECT setval('"public"."pre_inscripcion_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."secciones_id_seq"
OWNED BY "public"."secciones"."id";
SELECT setval('"public"."secciones_id_seq"', 140, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."secciones_periodo_id_seq"
OWNED BY "public"."secciones"."periodo_id";
SELECT setval('"public"."secciones_periodo_id_seq"', 21, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."sesiones_id_seq"
OWNED BY "public"."sesiones"."id";
SELECT setval('"public"."sesiones_id_seq"', 1549, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."talleres_id_seq"
OWNED BY "public"."talleres"."id";
SELECT setval('"public"."talleres_id_seq"', 88, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."users_id_seq"
OWNED BY "public"."users"."id";
SELECT setval('"public"."users_id_seq"', 509, true);

-- ----------------------------
-- Indexes structure for table alumnos
-- ----------------------------
CREATE INDEX "idx_alumnos_padre_id" ON "public"."alumnos" USING btree (
  "padre_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table alumnos
-- ----------------------------
ALTER TABLE "public"."alumnos" ADD CONSTRAINT "alumnos_codigo_estudiante_key" UNIQUE ("codigo_estudiante");

-- ----------------------------
-- Primary Key structure for table alumnos
-- ----------------------------
ALTER TABLE "public"."alumnos" ADD CONSTRAINT "alumnos_pkey" PRIMARY KEY ("user_id");

-- ----------------------------
-- Triggers structure for table asistencias
-- ----------------------------
CREATE TRIGGER "set_timestamp_asistencias" BEFORE UPDATE ON "public"."asistencias"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table asistencias
-- ----------------------------
ALTER TABLE "public"."asistencias" ADD CONSTRAINT "asistencias_matricula_id_fecha_key" UNIQUE ("matricula_id", "fecha");

-- ----------------------------
-- Primary Key structure for table asistencias
-- ----------------------------
ALTER TABLE "public"."asistencias" ADD CONSTRAINT "asistencias_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table cache
-- ----------------------------
ALTER TABLE "public"."cache" ADD CONSTRAINT "cache_pkey" PRIMARY KEY ("key");

-- ----------------------------
-- Primary Key structure for table cache_locks
-- ----------------------------
ALTER TABLE "public"."cache_locks" ADD CONSTRAINT "cache_locks_pkey" PRIMARY KEY ("key");

-- ----------------------------
-- Triggers structure for table categorias
-- ----------------------------
CREATE TRIGGER "set_timestamp_categorias" BEFORE UPDATE ON "public"."categorias"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table categorias
-- ----------------------------
ALTER TABLE "public"."categorias" ADD CONSTRAINT "categorias_edad_min_edad_max_tiene_discapacidad_key" UNIQUE ("edad_min", "edad_max", "tiene_discapacidad");

-- ----------------------------
-- Primary Key structure for table categorias
-- ----------------------------
ALTER TABLE "public"."categorias" ADD CONSTRAINT "categorias_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table codigos_tusnes
-- ----------------------------
ALTER TABLE "public"."codigos_tusnes" ADD CONSTRAINT "codigos_tusnes_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cronograma_pagos
-- ----------------------------
CREATE INDEX "idx_cronograma_pagos_matricula_id" ON "public"."cronograma_pagos" USING btree (
  "matricula_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table cronograma_pagos
-- ----------------------------
CREATE TRIGGER "set_timestamp_cronograma_pagos" BEFORE UPDATE ON "public"."cronograma_pagos"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Primary Key structure for table cronograma_pagos
-- ----------------------------
ALTER TABLE "public"."cronograma_pagos" ADD CONSTRAINT "cronograma_pagos_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Triggers structure for table disciplinas_deportivas
-- ----------------------------
CREATE TRIGGER "set_timestamp_disciplinas_deportivas" BEFORE UPDATE ON "public"."disciplinas_deportivas"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table disciplinas_deportivas
-- ----------------------------
ALTER TABLE "public"."disciplinas_deportivas" ADD CONSTRAINT "disciplinas_deportivas_nombre_key" UNIQUE ("nombre");

-- ----------------------------
-- Primary Key structure for table disciplinas_deportivas
-- ----------------------------
ALTER TABLE "public"."disciplinas_deportivas" ADD CONSTRAINT "disciplinas_deportivas_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table docentes
-- ----------------------------
ALTER TABLE "public"."docentes" ADD CONSTRAINT "docentes_pkey" PRIMARY KEY ("user_id");

-- ----------------------------
-- Indexes structure for table evaluaciones
-- ----------------------------
CREATE INDEX "idx_evaluaciones_matricula_id" ON "public"."evaluaciones" USING btree (
  "matricula_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table evaluaciones
-- ----------------------------
CREATE TRIGGER "set_timestamp_evaluaciones" BEFORE UPDATE ON "public"."evaluaciones"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Primary Key structure for table evaluaciones
-- ----------------------------
ALTER TABLE "public"."evaluaciones" ADD CONSTRAINT "evaluaciones_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table failed_jobs
-- ----------------------------
ALTER TABLE "public"."failed_jobs" ADD CONSTRAINT "failed_jobs_uuid_unique" UNIQUE ("uuid");

-- ----------------------------
-- Primary Key structure for table failed_jobs
-- ----------------------------
ALTER TABLE "public"."failed_jobs" ADD CONSTRAINT "failed_jobs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table horarios
-- ----------------------------
CREATE INDEX "idx_horarios_seccion_id" ON "public"."horarios" USING btree (
  "seccion_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table horarios
-- ----------------------------
CREATE TRIGGER "set_timestamp_horarios" BEFORE UPDATE ON "public"."horarios"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table horarios
-- ----------------------------
ALTER TABLE "public"."horarios" ADD CONSTRAINT "horarios_seccion_id_dia_semana_hora_inicio_hora_fin_key" UNIQUE ("seccion_id", "dia_semana", "hora_inicio");

-- ----------------------------
-- Primary Key structure for table horarios
-- ----------------------------
ALTER TABLE "public"."horarios" ADD CONSTRAINT "horarios_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table inscripcion_alumnos
-- ----------------------------
ALTER TABLE "public"."inscripcion_alumnos" ADD CONSTRAINT "inscripcion_alumnos_email_key" UNIQUE ("email");
ALTER TABLE "public"."inscripcion_alumnos" ADD CONSTRAINT "inscripcion_alumnos_numero_documento_key" UNIQUE ("numero_documento");

-- ----------------------------
-- Primary Key structure for table inscripcion_alumnos
-- ----------------------------
ALTER TABLE "public"."inscripcion_alumnos" ADD CONSTRAINT "inscripcion_alumnos_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table inscripcion_apoderados
-- ----------------------------
ALTER TABLE "public"."inscripcion_apoderados" ADD CONSTRAINT "inscripcion_apoderados_email_key" UNIQUE ("email");
ALTER TABLE "public"."inscripcion_apoderados" ADD CONSTRAINT "inscripcion_apoderados_numero_documento_key" UNIQUE ("numero_documento");

-- ----------------------------
-- Primary Key structure for table inscripcion_apoderados
-- ----------------------------
ALTER TABLE "public"."inscripcion_apoderados" ADD CONSTRAINT "inscripcion_apoderados_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table inscripciones
-- ----------------------------
ALTER TABLE "public"."inscripciones" ADD CONSTRAINT "pre_inscripcion_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table job_batches
-- ----------------------------
ALTER TABLE "public"."job_batches" ADD CONSTRAINT "job_batches_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table jobs
-- ----------------------------
CREATE INDEX "jobs_queue_index" ON "public"."jobs" USING btree (
  "queue" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table jobs
-- ----------------------------
ALTER TABLE "public"."jobs" ADD CONSTRAINT "jobs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Triggers structure for table lugares
-- ----------------------------
CREATE TRIGGER "set_timestamp_lugares" BEFORE UPDATE ON "public"."lugares"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table lugares
-- ----------------------------
ALTER TABLE "public"."lugares" ADD CONSTRAINT "lugares_nombre_key" UNIQUE ("nombre", "direccion");

-- ----------------------------
-- Primary Key structure for table lugares
-- ----------------------------
ALTER TABLE "public"."lugares" ADD CONSTRAINT "lugares_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table matriculas
-- ----------------------------
CREATE INDEX "idx_matriculas_seccion_id" ON "public"."matriculas" USING btree (
  "seccion_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table matriculas
-- ----------------------------
CREATE TRIGGER "set_timestamp_matriculas" BEFORE UPDATE ON "public"."matriculas"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table matriculas
-- ----------------------------
ALTER TABLE "public"."matriculas" ADD CONSTRAINT "matriculas_alumno_id_seccion_id_key" UNIQUE ("alumno_id", "seccion_id");

-- ----------------------------
-- Primary Key structure for table matriculas
-- ----------------------------
ALTER TABLE "public"."matriculas" ADD CONSTRAINT "matriculas_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table migrations
-- ----------------------------
ALTER TABLE "public"."migrations" ADD CONSTRAINT "migrations_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Triggers structure for table padres
-- ----------------------------
CREATE TRIGGER "set_timestamp_padres" BEFORE UPDATE ON "public"."padres"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Primary Key structure for table padres
-- ----------------------------
ALTER TABLE "public"."padres" ADD CONSTRAINT "padres_pkey" PRIMARY KEY ("user_id");

-- ----------------------------
-- Indexes structure for table pagos
-- ----------------------------
CREATE INDEX "idx_pagos_cronograma_pago_id" ON "public"."pagos" USING btree (
  "cronograma_pago_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_pagos_tesoreria_id" ON "public"."pagos" USING btree (
  "tesoreria_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table pagos
-- ----------------------------
CREATE TRIGGER "set_timestamp_pagos" BEFORE UPDATE ON "public"."pagos"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table pagos
-- ----------------------------
ALTER TABLE "public"."pagos" ADD CONSTRAINT "pagos_codigo_operacion_key" UNIQUE ("codigo_operacion");

-- ----------------------------
-- Primary Key structure for table pagos
-- ----------------------------
ALTER TABLE "public"."pagos" ADD CONSTRAINT "pagos_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table pagos_docentes
-- ----------------------------
CREATE INDEX "idx_pagos_docentes_docente_id" ON "public"."pagos_docentes" USING btree (
  "docente_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_pagos_docentes_tesoreria_id" ON "public"."pagos_docentes" USING btree (
  "tesoreria_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table pagos_docentes
-- ----------------------------
CREATE TRIGGER "set_timestamp_pagos_docentes" BEFORE UPDATE ON "public"."pagos_docentes"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Checks structure for table pagos_docentes
-- ----------------------------
ALTER TABLE "public"."pagos_docentes" ADD CONSTRAINT "pagos_docentes_horas_dictadas_check" CHECK (horas_dictadas >= 0);

-- ----------------------------
-- Primary Key structure for table pagos_docentes
-- ----------------------------
ALTER TABLE "public"."pagos_docentes" ADD CONSTRAINT "pagos_docentes_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table pagos_niubiz
-- ----------------------------
ALTER TABLE "public"."pagos_niubiz" ADD CONSTRAINT "pagos_niubiz_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table password_reset_tokens
-- ----------------------------
ALTER TABLE "public"."password_reset_tokens" ADD CONSTRAINT "password_reset_tokens_pkey" PRIMARY KEY ("email");

-- ----------------------------
-- Uniques structure for table periodos
-- ----------------------------
ALTER TABLE "public"."periodos" ADD CONSTRAINT "periodos_ciclo_anio_key" UNIQUE ("ciclo", "anio");

-- ----------------------------
-- Primary Key structure for table periodos
-- ----------------------------
ALTER TABLE "public"."periodos" ADD CONSTRAINT "periodos_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table secciones
-- ----------------------------
CREATE INDEX "idx_secciones_docente_id" ON "public"."secciones" USING btree (
  "docente_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_secciones_lugar_id" ON "public"."secciones" USING btree (
  "lugar_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_secciones_periodo_id" ON "public"."secciones" USING btree (
  "periodo_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_secciones_taller_id" ON "public"."secciones" USING btree (
  "taller_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table secciones
-- ----------------------------
CREATE TRIGGER "set_timestamp_secciones" BEFORE UPDATE ON "public"."secciones"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table secciones
-- ----------------------------
ALTER TABLE "public"."secciones" ADD CONSTRAINT "secciones_taller_id_nombre_key" UNIQUE ("taller_id", "nombre", "periodo_id");

-- ----------------------------
-- Primary Key structure for table secciones
-- ----------------------------
ALTER TABLE "public"."secciones" ADD CONSTRAINT "secciones_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table sesiones
-- ----------------------------
ALTER TABLE "public"."sesiones" ADD CONSTRAINT "sesiones_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table talleres
-- ----------------------------
CREATE INDEX "idx_talleres_categoria_id" ON "public"."talleres" USING btree (
  "categoria_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_talleres_disciplina_id" ON "public"."talleres" USING btree (
  "disciplina_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table talleres
-- ----------------------------
CREATE TRIGGER "set_timestamp_talleres" BEFORE UPDATE ON "public"."talleres"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table talleres
-- ----------------------------
ALTER TABLE "public"."talleres" ADD CONSTRAINT "talleres_disciplina_id_categoria_id_key" UNIQUE ("disciplina_id", "categoria_id");

-- ----------------------------
-- Primary Key structure for table talleres
-- ----------------------------
ALTER TABLE "public"."talleres" ADD CONSTRAINT "talleres_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Triggers structure for table users
-- ----------------------------
CREATE TRIGGER "set_timestamp_users" BEFORE UPDATE ON "public"."users"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trigger_set_timestamp"();

-- ----------------------------
-- Uniques structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_email_key" UNIQUE ("email");
ALTER TABLE "public"."users" ADD CONSTRAINT "users_numero_documento_key" UNIQUE ("numero_documento");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table alumnos
-- ----------------------------
ALTER TABLE "public"."alumnos" ADD CONSTRAINT "alumnos_padre_id_fk" FOREIGN KEY ("padre_id") REFERENCES "public"."padres" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."alumnos" ADD CONSTRAINT "alumnos_user_id_fk" FOREIGN KEY ("user_id") REFERENCES "public"."users" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table asistencias
-- ----------------------------
ALTER TABLE "public"."asistencias" ADD CONSTRAINT "asistencias_matricula_id_fkey" FOREIGN KEY ("matricula_id") REFERENCES "public"."matriculas" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table codigos_tusnes
-- ----------------------------
ALTER TABLE "public"."codigos_tusnes" ADD CONSTRAINT "codigos_tusnes_taller_id_fkey" FOREIGN KEY ("taller_id") REFERENCES "public"."talleres" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table cronograma_pagos
-- ----------------------------
ALTER TABLE "public"."cronograma_pagos" ADD CONSTRAINT "cronograma_pagos_matricula_id_fkey" FOREIGN KEY ("matricula_id") REFERENCES "public"."matriculas" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table horarios
-- ----------------------------
ALTER TABLE "public"."horarios" ADD CONSTRAINT "horarios_seccion_id_fkey" FOREIGN KEY ("seccion_id") REFERENCES "public"."secciones" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table inscripciones
-- ----------------------------
ALTER TABLE "public"."inscripciones" ADD CONSTRAINT "inscripcion_seccion_id_fkey" FOREIGN KEY ("seccion_id") REFERENCES "public"."secciones" ("id") ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE "public"."inscripciones" ADD CONSTRAINT "inscripciones_inscripcion_alumno_id_fkey" FOREIGN KEY ("inscripcion_alumno_id") REFERENCES "public"."inscripcion_alumnos" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."inscripciones" ADD CONSTRAINT "inscripciones_inscripcion_apoderado_id_fkey" FOREIGN KEY ("inscripcion_apoderado_id") REFERENCES "public"."inscripcion_apoderados" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."inscripciones" ADD CONSTRAINT "inscripciones_user_id_fkey" FOREIGN KEY ("user_id") REFERENCES "public"."users" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table matriculas
-- ----------------------------
ALTER TABLE "public"."matriculas" ADD CONSTRAINT "matriculas_alumno_id_fkey" FOREIGN KEY ("alumno_id") REFERENCES "public"."alumnos" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."matriculas" ADD CONSTRAINT "matriculas_seccion_id_fkey" FOREIGN KEY ("seccion_id") REFERENCES "public"."secciones" ("id") ON DELETE NO ACTION ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table pagos
-- ----------------------------
ALTER TABLE "public"."pagos" ADD CONSTRAINT "pagos_cronograma_pago_id_fkey" FOREIGN KEY ("cronograma_pago_id") REFERENCES "public"."cronograma_pagos" ("id") ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------------
-- Foreign Keys structure for table pagos_niubiz
-- ----------------------------
ALTER TABLE "public"."pagos_niubiz" ADD CONSTRAINT "pagos_niubiz_cronograma_pago_id_fkey" FOREIGN KEY ("cronograma_pago_id") REFERENCES "public"."cronograma_pagos" ("id") ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------------
-- Foreign Keys structure for table secciones
-- ----------------------------
ALTER TABLE "public"."secciones" ADD CONSTRAINT "secciones_docente_id_fkey" FOREIGN KEY ("docente_id") REFERENCES "public"."docentes" ("user_id") ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE "public"."secciones" ADD CONSTRAINT "secciones_lugar_id_fkey" FOREIGN KEY ("lugar_id") REFERENCES "public"."lugares" ("id") ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE "public"."secciones" ADD CONSTRAINT "secciones_periodo_id_fkey" FOREIGN KEY ("periodo_id") REFERENCES "public"."periodos" ("id") ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE "public"."secciones" ADD CONSTRAINT "secciones_taller_id_fkey" FOREIGN KEY ("taller_id") REFERENCES "public"."talleres" ("id") ON DELETE NO ACTION ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table sesiones
-- ----------------------------
ALTER TABLE "public"."sesiones" ADD CONSTRAINT "sesiones_seccion_id_fkey" FOREIGN KEY ("seccion_id") REFERENCES "public"."secciones" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table talleres
-- ----------------------------
ALTER TABLE "public"."talleres" ADD CONSTRAINT "talleres_categoria_id_fkey" FOREIGN KEY ("categoria_id") REFERENCES "public"."categorias" ("id") ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE "public"."talleres" ADD CONSTRAINT "talleres_disciplina_id_fkey" FOREIGN KEY ("disciplina_id") REFERENCES "public"."disciplinas_deportivas" ("id") ON DELETE NO ACTION ON UPDATE CASCADE;
