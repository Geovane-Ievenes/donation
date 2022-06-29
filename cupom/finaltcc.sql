-- MariaDB dump 10.19  Distrib 10.4.20-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: finaltcc
-- ------------------------------------------------------
-- Server version	10.4.20-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbadm`
--

DROP TABLE IF EXISTS `tbadm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbadm` (
  `id_adm` int(11) NOT NULL AUTO_INCREMENT,
  `nome_adm` varchar(90) NOT NULL,
  `email_adm` varchar(90) NOT NULL,
  `senha_adm` varchar(40) NOT NULL,
  `data_cadastro_adm` date NOT NULL,
  PRIMARY KEY (`id_adm`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbadm`
--

LOCK TABLES `tbadm` WRITE;
/*!40000 ALTER TABLE `tbadm` DISABLE KEYS */;
INSERT INTO `tbadm` VALUES (1,'Administrador','adm@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','2021-10-05');
/*!40000 ALTER TABLE `tbadm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbcadastro_ong`
--

DROP TABLE IF EXISTS `tbcadastro_ong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcadastro_ong` (
  `id_cadastro_ong` int(11) NOT NULL AUTO_INCREMENT,
  `id_ong_cadastro` int(11) NOT NULL,
  `data_cadastro_ong` date NOT NULL,
  `id_tentativa_cadastro` int(11) NOT NULL,
  `id_adm_verificacao_ong` int(11) NOT NULL,
  PRIMARY KEY (`id_cadastro_ong`),
  KEY `fk_id_ong_cadastro` (`id_ong_cadastro`),
  KEY `fk_id_tentativa_cadastro` (`id_tentativa_cadastro`),
  KEY `fk_id_adm_verificacao` (`id_adm_verificacao_ong`),
  CONSTRAINT `fk_id_adm_verificacao` FOREIGN KEY (`id_adm_verificacao_ong`) REFERENCES `tbadm` (`id_adm`),
  CONSTRAINT `fk_id_ong_cadastro` FOREIGN KEY (`id_ong_cadastro`) REFERENCES `tbperfil_ong` (`id_perfil_ong`),
  CONSTRAINT `fk_id_tentativa_cadastro` FOREIGN KEY (`id_tentativa_cadastro`) REFERENCES `tbtentativa_cadastro` (`id_tentativa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcadastro_ong`
--

LOCK TABLES `tbcadastro_ong` WRITE;
/*!40000 ALTER TABLE `tbcadastro_ong` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbcadastro_ong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbcupons`
--

DROP TABLE IF EXISTS `tbcupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbcupons` (
  `id_cupom` int(11) NOT NULL AUTO_INCREMENT,
  `id_parceira_cupom` int(11) NOT NULL,
  `titulo_cupom` varchar(90) NOT NULL,
  `valor_coins_cupom` int(11) NOT NULL,
  `meta_dinheiro_cupom` decimal(5,2) NOT NULL,
  `desconto_cupom_descricao` text NOT NULL,
  `categoria_cupom` int(11) NOT NULL,
  `vezes_resgatado` int(11) NOT NULL DEFAULT 0,
  `inicio_ciclo_exibicao` date NOT NULL,
  `fim_ciclo_exibicao` date NOT NULL,
  `inicio_ciclo_hibernacao` date NOT NULL,
  `fim_ciclo_hibernacao` date NOT NULL,
  PRIMARY KEY (`id_cupom`),
  KEY `fk_id_parceira` (`id_parceira_cupom`),
  CONSTRAINT `fk_id_parceira` FOREIGN KEY (`id_parceira_cupom`) REFERENCES `tbparceiras` (`id_parceira`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcupons`
--

LOCK TABLES `tbcupons` WRITE;
/*!40000 ALTER TABLE `tbcupons` DISABLE KEYS */;
INSERT INTO `tbcupons` VALUES (1,1,'Cupom desconto 1',12,12.00,'descrição 1',1,0,'2021-10-04','2021-10-11','2021-10-12','2021-10-19'),(2,1,'Cupom desconto 2',14,13.00,'descrição 2',1,0,'2021-10-04','2021-10-11','2021-10-12','2021-10-19');
/*!40000 ALTER TABLE `tbcupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbdoacao`
--

DROP TABLE IF EXISTS `tbdoacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbdoacao` (
  `id_doacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_doador_doacao` int(11) NOT NULL,
  `cod_boleto` char(48) DEFAULT NULL,
  `id_cupom_doacao` int(11) DEFAULT NULL,
  `quantia_doacao` decimal(8,2) NOT NULL,
  `data_doacao` date NOT NULL,
  `forma_pagamento` varchar(90) NOT NULL,
  PRIMARY KEY (`id_doacao`),
  KEY `fk_id_cupom_doacao` (`id_cupom_doacao`),
  KEY `fk_id_doador_doacao` (`id_doador_doacao`),
  CONSTRAINT `fk_id_cupom_doacao` FOREIGN KEY (`id_cupom_doacao`) REFERENCES `tbcupons` (`id_cupom`),
  CONSTRAINT `fk_id_doador_doacao` FOREIGN KEY (`id_doador_doacao`) REFERENCES `tbusuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbdoacao`
--

LOCK TABLES `tbdoacao` WRITE;
/*!40000 ALTER TABLE `tbdoacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbdoacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbimagens`
--

DROP TABLE IF EXISTS `tbimagens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbimagens` (
  `id_imagem` int(11) NOT NULL AUTO_INCREMENT,
  `id_projeto_imagem` int(11) NOT NULL,
  `imagem_projeto` varchar(39) NOT NULL,
  `tipo_imagem` int(11) NOT NULL,
  PRIMARY KEY (`id_imagem`),
  KEY `fk_projeto_imagem` (`id_projeto_imagem`),
  CONSTRAINT `fk_projeto_imagem` FOREIGN KEY (`id_projeto_imagem`) REFERENCES `tbprojeto` (`id_projeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbimagens`
--

LOCK TABLES `tbimagens` WRITE;
/*!40000 ALTER TABLE `tbimagens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbimagens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbparceiras`
--

DROP TABLE IF EXISTS `tbparceiras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbparceiras` (
  `id_parceira` int(11) NOT NULL AUTO_INCREMENT,
  `nome_parceira` varchar(90) NOT NULL,
  `CNPJ_parceira` char(14) NOT NULL,
  `email_parceira` varchar(90) NOT NULL,
  `telefone_comercial_parceira` varchar(12) DEFAULT NULL,
  `celular_parceira` char(13) NOT NULL,
  `facebook_parceira` varchar(2048) DEFAULT NULL,
  `instagram_parceira` varchar(2048) DEFAULT NULL,
  `twitter_parceira` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`id_parceira`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbparceiras`
--

LOCK TABLES `tbparceiras` WRITE;
/*!40000 ALTER TABLE `tbparceiras` DISABLE KEYS */;
INSERT INTO `tbparceiras` VALUES (1,'Riachuelo','11111111111111','email','111111111111','1111111111111',NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbparceiras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbperfil_ong`
--

DROP TABLE IF EXISTS `tbperfil_ong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbperfil_ong` (
  `id_perfil_ong` int(11) NOT NULL AUTO_INCREMENT,
  `nome_ong` varchar(90) NOT NULL,
  `razao_ong` varchar(90) NOT NULL,
  `fundacao_ong` date NOT NULL,
  `descricao_ong` text NOT NULL,
  `CNPJ_ong` char(14) NOT NULL,
  `CPF_ong` char(11) NOT NULL,
  `CEP_ong` char(8) NOT NULL,
  `telefone_comercial_ong` char(12) DEFAULT NULL,
  `celular_ong` char(13) DEFAULT NULL,
  PRIMARY KEY (`id_perfil_ong`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbperfil_ong`
--

LOCK TABLES `tbperfil_ong` WRITE;
/*!40000 ALTER TABLE `tbperfil_ong` DISABLE KEYS */;
INSERT INTO `tbperfil_ong` VALUES (1,'123','123','1212-12-12','sdfdsfsf','11186828000100','07175060','07175060','111111111111','1111111111111');
/*!40000 ALTER TABLE `tbperfil_ong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbprojeto`
--

DROP TABLE IF EXISTS `tbprojeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbprojeto` (
  `id_projeto` int(11) NOT NULL AUTO_INCREMENT,
  `id_ong_projeto` int(11) NOT NULL,
  `nome_projeto` varchar(90) NOT NULL,
  `logo_projeto` varchar(37) NOT NULL,
  `meta_projeto` decimal(8,2) DEFAULT NULL,
  `descricao_projeto` text DEFAULT NULL,
  `email_projeto` varchar(90) DEFAULT NULL,
  `facebook_projeto` varchar(248) DEFAULT NULL,
  `instagram_projeto` varchar(248) DEFAULT NULL,
  `twitter_projeto` varchar(248) DEFAULT NULL,
  `ODS` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ODS`)),
  `temas_projeto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`temas_projeto`)),
  `qtd_sliders` int(11) NOT NULL,
  `data_criacao_projeto` date NOT NULL,
  PRIMARY KEY (`id_projeto`),
  KEY `fk_id_ong_projeto` (`id_ong_projeto`),
  CONSTRAINT `fk_id_ong_projeto` FOREIGN KEY (`id_ong_projeto`) REFERENCES `tbperfil_ong` (`id_perfil_ong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbprojeto`
--

LOCK TABLES `tbprojeto` WRITE;
/*!40000 ALTER TABLE `tbprojeto` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbprojeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbtentativa_cadastro`
--

DROP TABLE IF EXISTS `tbtentativa_cadastro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbtentativa_cadastro` (
  `id_tentativa` int(11) NOT NULL AUTO_INCREMENT,
  `id_ong_tentativa` int(11) NOT NULL,
  `data_tentativa` date NOT NULL,
  `dir_documentos_tentativa` varchar(32) NOT NULL,
  `situacao_tentativa` varchar(90) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tentativa`),
  KEY `fk_id_ong_tentativa` (`id_ong_tentativa`),
  CONSTRAINT `fk_id_ong_tentativa` FOREIGN KEY (`id_ong_tentativa`) REFERENCES `tbperfil_ong` (`id_perfil_ong`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbtentativa_cadastro`
--

LOCK TABLES `tbtentativa_cadastro` WRITE;
/*!40000 ALTER TABLE `tbtentativa_cadastro` DISABLE KEYS */;
INSERT INTO `tbtentativa_cadastro` VALUES (1,1,'2021-10-04','f33fb1c9cfd57864c636d7e0b8bdd793','0');
/*!40000 ALTER TABLE `tbtentativa_cadastro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbtroca_cupons_loja`
--

DROP TABLE IF EXISTS `tbtroca_cupons_loja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbtroca_cupons_loja` (
  `id_troca` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_troca` int(11) NOT NULL,
  `id_cupom_troca` int(11) NOT NULL,
  `data_troca` date NOT NULL,
  `codigo_cupom` varchar(40) NOT NULL,
  `resgatar_novamente` date DEFAULT NULL,
  `data_novo_resgate` date NOT NULL,
  PRIMARY KEY (`id_troca`),
  UNIQUE KEY `codigo_cupom` (`codigo_cupom`),
  KEY `fk_id_cupom_troca` (`id_cupom_troca`),
  KEY `fk_id_usuario_troca` (`id_usuario_troca`),
  CONSTRAINT `fk_id_cupom_troca` FOREIGN KEY (`id_cupom_troca`) REFERENCES `tbcupons` (`id_cupom`),
  CONSTRAINT `fk_id_usuario_troca` FOREIGN KEY (`id_usuario_troca`) REFERENCES `tbusuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbtroca_cupons_loja`
--

LOCK TABLES `tbtroca_cupons_loja` WRITE;
/*!40000 ALTER TABLE `tbtroca_cupons_loja` DISABLE KEYS */;
INSERT INTO `tbtroca_cupons_loja` VALUES (1,1,1,'2021-10-04','123','2021-10-05','2021-10-05');
/*!40000 ALTER TABLE `tbtroca_cupons_loja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbusuario`
--

DROP TABLE IF EXISTS `tbusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbusuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(90) NOT NULL,
  `email_usuario` varchar(90) NOT NULL,
  `senha_usuario` varchar(40) NOT NULL,
  `data_criacao_usuario` date NOT NULL,
  `nascimento_usuario` date NOT NULL,
  `sexo_usuario` char(1) NOT NULL,
  `qtd_coins_doador` int(11) DEFAULT 0,
  `tipo_perfil` varchar(90) NOT NULL,
  `cod_perfil_ong` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email_usuario` (`email_usuario`),
  UNIQUE KEY `cod_perfil_ong` (`cod_perfil_ong`),
  CONSTRAINT `fk_cod_perfil_ong` FOREIGN KEY (`cod_perfil_ong`) REFERENCES `tbperfil_ong` (`id_perfil_ong`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbusuario`
--

LOCK TABLES `tbusuario` WRITE;
/*!40000 ALTER TABLE `tbusuario` DISABLE KEYS */;
INSERT INTO `tbusuario` VALUES (1,'Ronaldo','email','123','2021-10-04','2004-05-17','M',0,'doador',NULL),(2,'ERNANI IEVENES','ernani.ievenes@gmail.com','ec7f1f65067126f3b2bd1037de8a18d0db2ec84b','2021-10-04','1212-12-12','M',0,'ong',1);
/*!40000 ALTER TABLE `tbusuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-05 15:21:13
