/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : localhost:3306
 Source Schema         : piburger

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 11/09/2019 00:53:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for adicionales
-- ----------------------------
DROP TABLE IF EXISTS `adicionales`;
CREATE TABLE `adicionales`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `adicional` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipo_id` tinyint(3) UNSIGNED NOT NULL,
  `precio` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `adicional`(`adicional`) USING BTREE,
  INDEX `tipo_id`(`tipo_id`) USING BTREE,
  CONSTRAINT `adicionales_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of adicionales
-- ----------------------------
INSERT INTO `adicionales` VALUES (1, 'Classic Fries', 3, 85);
INSERT INTO `adicionales` VALUES (2, 'Cheese Fries', 3, 105);
INSERT INTO `adicionales` VALUES (3, 'Pi Fries', 3, 120);
INSERT INTO `adicionales` VALUES (4, 'Crispy Onions', 3, 99);
INSERT INTO `adicionales` VALUES (5, 'Nuggets', 3, 110);
INSERT INTO `adicionales` VALUES (6, 'Porrón Stella Artois.', 4, 97);
INSERT INTO `adicionales` VALUES (7, 'Porrón Stella Nior.', 4, 97);
INSERT INTO `adicionales` VALUES (8, 'Coca-Cola. 600cc', 4, 72);
INSERT INTO `adicionales` VALUES (9, 'Coca-Cola Light. 600cc', 4, 72);
INSERT INTO `adicionales` VALUES (10, 'Sprite. 600cc', 4, 72);
INSERT INTO `adicionales` VALUES (11, 'Sprite Zero. 600cc', 4, 72);
INSERT INTO `adicionales` VALUES (12, 'Fanta. 600cc', 4, 72);
INSERT INTO `adicionales` VALUES (13, 'Schweppes. 600cc', 4, 72);
INSERT INTO `adicionales` VALUES (14, 'Agua Eco de los Andes. 500cc', 4, 55);
INSERT INTO `adicionales` VALUES (15, 'Papas Pay', 2, 0);
INSERT INTO `adicionales` VALUES (16, 'Pepinillos', 1, 30);
INSERT INTO `adicionales` VALUES (17, 'Cebolla  caramelizada', 1, 30);
INSERT INTO `adicionales` VALUES (18, 'Panceta', 1, 30);
INSERT INTO `adicionales` VALUES (19, 'Jamón', 1, 30);
INSERT INTO `adicionales` VALUES (20, 'Chiles', 1, 30);
INSERT INTO `adicionales` VALUES (21, 'Queso azul', 1, 30);

-- ----------------------------
-- Table structure for ciudades
-- ----------------------------
DROP TABLE IF EXISTS `ciudades`;
CREATE TABLE `ciudades`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cd` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prov_id` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cd`(`cd`) USING BTREE,
  INDEX `prov_id`(`prov_id`) USING BTREE,
  CONSTRAINT `ciudades_ibfk_1` FOREIGN KEY (`prov_id`) REFERENCES `provincias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ciudades
-- ----------------------------
INSERT INTO `ciudades` VALUES (1, 'CABA', 1);
INSERT INTO `ciudades` VALUES (2, 'Avellaneda', 1);
INSERT INTO `ciudades` VALUES (3, 'Haedo', 1);
INSERT INTO `ciudades` VALUES (4, 'Ciudad de Córdoba', 2);

-- ----------------------------
-- Table structure for comentarios
-- ----------------------------
DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE `comentarios`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comentario` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `puntuacion` tinyint(1) NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `plato_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  INDEX `plato_id`(`plato_id`) USING BTREE,
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`plato_id`) REFERENCES `platos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for domicilios
-- ----------------------------
DROP TABLE IF EXISTS `domicilios`;
CREATE TABLE `domicilios`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `calle` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nro` tinyint(4) NOT NULL,
  `prov_id` tinyint(3) UNSIGNED NOT NULL,
  `cd_id` tinyint(3) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  INDEX `prov_id`(`prov_id`) USING BTREE,
  INDEX `cd_id`(`cd_id`) USING BTREE,
  CONSTRAINT `domicilios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `domicilios_ibfk_2` FOREIGN KEY (`prov_id`) REFERENCES `provincias` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `domicilios_ibfk_3` FOREIGN KEY (`cd_id`) REFERENCES `ciudades` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for estados
-- ----------------------------
DROP TABLE IF EXISTS `estados`;
CREATE TABLE `estados`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of estados
-- ----------------------------
INSERT INTO `estados` VALUES (1, 'Pendiente');
INSERT INTO `estados` VALUES (2, 'En preparación');
INSERT INTO `estados` VALUES (3, 'Enviado');
INSERT INTO `estados` VALUES (4, 'Entregado');
INSERT INTO `estados` VALUES (5, 'Anulado');

-- ----------------------------
-- Table structure for pedidos
-- ----------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plato_nro` int(11) NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `plato_id` int(10) UNSIGNED NOT NULL,
  `tipo_hamburguesa_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `adicionales_id` tinyint(3) UNSIGNED NULL DEFAULT NULL,
  `cantidad` tinyint(4) NOT NULL,
  `precio` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  INDEX `plato_id`(`plato_id`) USING BTREE,
  INDEX `tipo_hamburguesa_id`(`tipo_hamburguesa_id`) USING BTREE,
  INDEX `adicionales_id`(`adicionales_id`) USING BTREE,
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`plato_id`) REFERENCES `platos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`tipo_hamburguesa_id`) REFERENCES `tipos_hamburguesas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `pedidos_ibfk_4` FOREIGN KEY (`adicionales_id`) REFERENCES `adicionales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for pedidos_nro
-- ----------------------------
DROP TABLE IF EXISTS `pedidos_nro`;
CREATE TABLE `pedidos_nro`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `pedido` int(11) NOT NULL,
  `plato_nro` int(11) NOT NULL,
  `estado_id` tinyint(3) UNSIGNED NOT NULL,
  `precio` int(11) NOT NULL,
  `domicilio_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `calle` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nro` tinyint(4) NULL DEFAULT NULL,
  `prov_id` tinyint(3) UNSIGNED NULL DEFAULT NULL,
  `cd_id` tinyint(3) UNSIGNED NULL DEFAULT NULL,
  `tel_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `tel` tinyint(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  INDEX `estado_id`(`estado_id`) USING BTREE,
  INDEX `domicilio_id`(`domicilio_id`) USING BTREE,
  INDEX `prov_id`(`prov_id`) USING BTREE,
  INDEX `cd_id`(`cd_id`) USING BTREE,
  INDEX `tel_id`(`tel_id`) USING BTREE,
  CONSTRAINT `pedidos_nro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedidos_nro_ibfk_2` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `pedidos_nro_ibfk_3` FOREIGN KEY (`domicilio_id`) REFERENCES `domicilios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `pedidos_nro_ibfk_4` FOREIGN KEY (`prov_id`) REFERENCES `provincias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `pedidos_nro_ibfk_5` FOREIGN KEY (`cd_id`) REFERENCES `ciudades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `pedidos_nro_ibfk_6` FOREIGN KEY (`tel_id`) REFERENCES `telefonos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for platos
-- ----------------------------
DROP TABLE IF EXISTS `platos`;
CREATE TABLE `platos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `img` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipo_id` tinyint(3) UNSIGNED NOT NULL,
  `precio` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nombre`(`nombre`) USING BTREE,
  INDEX `tipo_id`(`tipo_id`) USING BTREE,
  CONSTRAINT `platos_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of platos
-- ----------------------------
INSERT INTO `platos` VALUES (1, 'Smoked Burger', 'Hamburguesa de carne con queso ahumado, bacon crocante, pepinillos y cebolla caramelizada. SIMPLE | DOBLE', 'smoked_burger.jpg', 1, 209);
INSERT INTO `platos` VALUES (2, 'Pi Burger', 'Hamburguesa con queso, lechuga, tomate, y salsa Pi. SIMPLE | DOBLE', 'pi_burger.jpg', 1, 169);
INSERT INTO `platos` VALUES (3, 'Pi Bacon', 'Hamburguesa con queso, panceta crocante, barbacoa, cebolla y salsa Pi. SIMPLE | DOBLE', 'pi_bacon.jpg', 1, 199);
INSERT INTO `platos` VALUES (4, 'Sweet Burger', 'Hamburguesa con queso, cebolla caramelizada, tomate y salsa Pi. SIMPLE | DOBLE', 'sweet_burger.jpg', 1, 173);
INSERT INTO `platos` VALUES (5, 'Mush Burger', 'Hamburguesa veggie de portobellos y champiñones crujientes, rellenos de queso, con lechuga, tomate y salsa Pi. SIMPLE', 'mush_burger.jpg', 1, 173);
INSERT INTO `platos` VALUES (6, 'Mush Doble', 'Hamburguesa de portobellos y champiñones crujientes, rellenos de queso, medallón de carne, lechuga, tomate y salsa Pi. DOBLE (Con carne)', 'mush_doble.jpg', 1, 220);
INSERT INTO `platos` VALUES (7, 'Chicken Burger', 'Hamburguesa casera de pollo, con selección de espinacas, parmesano, lechuga, tomate y salsa Pi. SIMPLE | DOBLE', 'chicken_burger.jpg', 1, 173);
INSERT INTO `platos` VALUES (8, 'Salmon Burger', 'Hamburguesa de salmón rosado fresco apanado, lechuga, tomate y salsa Tártara. SIMPLE', 'salmon_burger.jpg', 1, 219);
INSERT INTO `platos` VALUES (9, 'Pi HotDog', 'Cheddar, panceta y papas pay (opcional)', 'pi_hotdog.jpg', 2, 115);
INSERT INTO `platos` VALUES (10, 'Cheese Dog', 'Con nuestra salsa cheddar.', 'cheese_dog.jpg', 2, 95);
INSERT INTO `platos` VALUES (11, 'Spice Dog', 'Salsa picante de chiles, tomates y cebollas.', 'spice_dog.jpg', 2, 99);
INSERT INTO `platos` VALUES (12, 'Farm Dog', 'Mix de verduras frescas y seleccionadas. (Cebolla picada, Tomates, Pepinos, Pimientos y Choclo).', 'farm_dog.jpg', 2, 125);
INSERT INTO `platos` VALUES (13, 'Fries', 'Pi Fries: Con salsa cheddar y panceta crocante. \r\nCheese Fries: Con nuestra salsa cheddar.\r\nClassic Fries.', 'fries.jpg', 3, NULL);
INSERT INTO `platos` VALUES (14, 'Fries2', 'Pi Nuggets: Cubitos artesanales de pollo crocante.\r\nCrispy Onions: Cubitos crocantes de cebolla y queso.', 'fries2.jpg', 3, NULL);

-- ----------------------------
-- Table structure for provincias
-- ----------------------------
DROP TABLE IF EXISTS `provincias`;
CREATE TABLE `provincias`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `prov` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `prov`(`prov`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of provincias
-- ----------------------------
INSERT INTO `provincias` VALUES (1, 'Buenos Aires');
INSERT INTO `provincias` VALUES (2, 'Córdoba');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'admin');
INSERT INTO `roles` VALUES (2, 'user');
INSERT INTO `roles` VALUES (3, 'delivery');

-- ----------------------------
-- Table structure for tarjetas
-- ----------------------------
DROP TABLE IF EXISTS `tarjetas`;
CREATE TABLE `tarjetas`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nro` tinyint(4) NOT NULL,
  `vencimiento` date NOT NULL,
  `titular` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cvv` tinyint(4) NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `tipo_tajerta_id` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nro`(`nro`) USING BTREE,
  UNIQUE INDEX `cvv`(`cvv`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  INDEX `tipo_tajerta_id`(`tipo_tajerta_id`) USING BTREE,
  CONSTRAINT `tarjetas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarjetas_ibfk_2` FOREIGN KEY (`tipo_tajerta_id`) REFERENCES `tipos_tarjetas` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for telefonos
-- ----------------------------
DROP TABLE IF EXISTS `telefonos`;
CREATE TABLE `telefonos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tel` int(11) NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tel`(`tel`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  CONSTRAINT `telefonos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tipos
-- ----------------------------
DROP TABLE IF EXISTS `tipos`;
CREATE TABLE `tipos`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tipo`(`tipo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tipos
-- ----------------------------
INSERT INTO `tipos` VALUES (1, 'Burgers');
INSERT INTO `tipos` VALUES (4, 'Drinks');
INSERT INTO `tipos` VALUES (3, 'Fries');
INSERT INTO `tipos` VALUES (2, 'Grilled HotDogs');

-- ----------------------------
-- Table structure for tipos_hamburguesas
-- ----------------------------
DROP TABLE IF EXISTS `tipos_hamburguesas`;
CREATE TABLE `tipos_hamburguesas`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `precio` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tipos_hamburguesas
-- ----------------------------
INSERT INTO `tipos_hamburguesas` VALUES (1, 'Simple', NULL);
INSERT INTO `tipos_hamburguesas` VALUES (2, 'Doble', 47);

-- ----------------------------
-- Table structure for tipos_tarjetas
-- ----------------------------
DROP TABLE IF EXISTS `tipos_tarjetas`;
CREATE TABLE `tipos_tarjetas`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tipo`(`tipo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tipos_tarjetas
-- ----------------------------
INSERT INTO `tipos_tarjetas` VALUES (4, 'American Express');
INSERT INTO `tipos_tarjetas` VALUES (5, 'Cabal');
INSERT INTO `tipos_tarjetas` VALUES (7, 'Diners Club');
INSERT INTO `tipos_tarjetas` VALUES (6, 'Maestro');
INSERT INTO `tipos_tarjetas` VALUES (3, 'MasterCard');
INSERT INTO `tipos_tarjetas` VALUES (8, 'Shopping');
INSERT INTO `tipos_tarjetas` VALUES (1, 'Visa');
INSERT INTO `tipos_tarjetas` VALUES (2, 'Visa Débito');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `apellido` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `img` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usuario` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rol_id` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `usuario`(`usuario`) USING BTREE,
  INDEX `rol_id`(`rol_id`) USING BTREE,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, NULL, NULL, 'img/usuarios/user_img.png', 'psme@pamel', '$2y$10$oZcmbNL0DqNrp5WYPqFXBud9CZfTUNEGMWdLEVU.YBvq586oCY1Na', 'pi', 2);

SET FOREIGN_KEY_CHECKS = 1;
