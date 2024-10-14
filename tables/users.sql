# Host: localhost  (Version: 5.5.5-10.6.17-MariaDB-1:10.6.17+maria~ubu2004)
# Date: 2024-10-14 14:35:05
# Generator: MySQL-Front 5.3  (Build 4.249)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_nome` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_celular` varchar(30) DEFAULT NULL,
  `user_cpf_cnpj` varchar(20) DEFAULT NULL,
  `user_perfil` int(11) DEFAULT NULL,
  `user_token` varchar(255) DEFAULT NULL,
  `user_token_gen` datetime DEFAULT NULL,
  `user_incdate` datetime DEFAULT NULL,
  `user_upddate` datetime DEFAULT NULL,
  `user_delete` char(1) DEFAULT NULL,
  `user_deldate` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'Admin','admin@admin.com','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3Mjg5MjUyNDMsImV4cCI6MTcyODkyODg0MywiZGF0YSI6eyJ1c2VySWQiOjEsInJvbGUiOjF9fQ.wbYgy84POCGhrOfjPP8kiqNAkAL8bubJ-pUW5W592uU','2024-10-14 14:00:43',NULL,NULL,'',NULL);
