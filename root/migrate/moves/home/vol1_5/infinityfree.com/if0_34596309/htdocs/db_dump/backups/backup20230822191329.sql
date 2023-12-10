
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
DROP TABLE IF EXISTS `fl_ponto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fl_ponto` (
  `token_alter` int(11) NOT NULL AUTO_INCREMENT,
  `cdcolab_ponto` int(11) DEFAULT NULL,
  `cdempresa_ponto` int(11) DEFAULT NULL,
  `pais_ponto` varchar(40) DEFAULT NULL,
  `estado_ponto` varchar(40) DEFAULT NULL,
  `cidade_ponto` varchar(40) DEFAULT NULL,
  `bairro_ponto` varchar(40) DEFAULT NULL,
  `data_ponto` varchar(40) DEFAULT NULL,
  `hora_ponto` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`token_alter`),
  KEY `fk_fl_ponto1` (`cdcolab_ponto`),
  KEY `fk_fl_ponto2` (`cdempresa_ponto`),
  CONSTRAINT `fk_fl_ponto1` FOREIGN KEY (`cdcolab_ponto`) REFERENCES `tb_colab` (`cd_colab`),
  CONSTRAINT `fk_fl_ponto2` FOREIGN KEY (`cdempresa_ponto`) REFERENCES `tb_empresa` (`cd_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `fl_ponto` WRITE;
/*!40000 ALTER TABLE `fl_ponto` DISABLE KEYS */;
/*!40000 ALTER TABLE `fl_ponto` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `rel_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rel_user` (
  `token_alter` int(11) NOT NULL AUTO_INCREMENT,
  `cd_seg` int(11) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `cd_estilo` int(11) DEFAULT NULL,
  `cd_funcao` int(11) DEFAULT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`token_alter`),
  KEY `fk_rel_user1` (`cd_seg`),
  KEY `fk_rel_user2` (`cd_colab`),
  KEY `fk_rel_user3` (`cd_estilo`),
  KEY `fk_rel_user4` (`cd_funcao`),
  KEY `fk_rel_user5` (`cd_empresa`),
  CONSTRAINT `fk_rel_user1` FOREIGN KEY (`cd_seg`) REFERENCES `tb_seguranca` (`cd_seg`),
  CONSTRAINT `fk_rel_user2` FOREIGN KEY (`cd_colab`) REFERENCES `tb_colab` (`cd_colab`),
  CONSTRAINT `fk_rel_user3` FOREIGN KEY (`cd_estilo`) REFERENCES `tb_estilo` (`cd_estilo`),
  CONSTRAINT `fk_rel_user4` FOREIGN KEY (`cd_funcao`) REFERENCES `tb_funcao` (`cd_funcao`),
  CONSTRAINT `fk_rel_user5` FOREIGN KEY (`cd_empresa`) REFERENCES `tb_empresa` (`cd_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `rel_user` WRITE;
/*!40000 ALTER TABLE `rel_user` DISABLE KEYS */;
INSERT INTO `rel_user` VALUES (1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `rel_user` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_atividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_atividade` (
  `cd_atividade` int(11) NOT NULL AUTO_INCREMENT,
  `cd_servico` int(11) DEFAULT NULL,
  `titulo_atividade` int(100) DEFAULT NULL,
  `obs_atividade` varchar(1000) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `inicio_atividade` varchar(40) DEFAULT NULL,
  `fim_atividade` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`cd_atividade`),
  KEY `fk_rel_colab1` (`cd_servico`),
  KEY `fk_rel_colab2` (`cd_colab`),
  CONSTRAINT `fk_rel_colab1` FOREIGN KEY (`cd_servico`) REFERENCES `tb_servico` (`cd_servico`),
  CONSTRAINT `fk_rel_colab2` FOREIGN KEY (`cd_colab`) REFERENCES `tb_colab` (`cd_colab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_atividade` WRITE;
/*!40000 ALTER TABLE `tb_atividade` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_atividade` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_cliente` (
  `cd_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `pnome_cliente` varchar(40) DEFAULT NULL,
  `snome_cliente` varchar(40) DEFAULT NULL,
  `cpf_cliente` varchar(40) DEFAULT NULL,
  `dtnasc_cliente` varchar(40) DEFAULT NULL,
  `sexo_cliente` varchar(40) DEFAULT NULL,
  `obs_cliente` varchar(40) DEFAULT NULL,
  `tel_cliente` varchar(40) DEFAULT NULL,
  `obs_tel_cliente` varchar(40) DEFAULT NULL,
  `email_cliente` varchar(40) DEFAULT NULL,
  `foto_cliente` varchar(1000) DEFAULT NULL,
  `senha_cliente` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`cd_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_cliente` WRITE;
/*!40000 ALTER TABLE `tb_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_cliente` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_colab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_colab` (
  `cd_colab` int(11) NOT NULL AUTO_INCREMENT,
  `pnome_colab` varchar(40) DEFAULT NULL,
  `snome_colab` varchar(40) DEFAULT NULL,
  `cpf_colab` varchar(40) DEFAULT NULL,
  `dtnasc_colab` varchar(40) DEFAULT NULL,
  `sexo_colab` varchar(40) DEFAULT NULL,
  `obs_colab` varchar(40) DEFAULT NULL,
  `tel_colab` varchar(40) DEFAULT NULL,
  `obs_tel_colab` varchar(40) DEFAULT NULL,
  `email_colab` varchar(40) DEFAULT NULL,
  `foto_colab` varchar(1000) DEFAULT NULL,
  `senha_colab` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`cd_colab`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_colab` WRITE;
/*!40000 ALTER TABLE `tb_colab` DISABLE KEYS */;
INSERT INTO `tb_colab` VALUES (1,'erp-Nuvemsoft',NULL,'1',NULL,NULL,NULL,NULL,NULL,'suporte@erp-nuvemsoft.com.br',NULL,'1');
/*!40000 ALTER TABLE `tb_colab` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_empresa` (
  `cd_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `rsocial_empresa` varchar(40) DEFAULT NULL,
  `nfantasia_empresa` varchar(40) DEFAULT NULL,
  `cnpj_empresa` int(11) DEFAULT NULL,
  `cd_ceo` int(11) DEFAULT NULL,
  `chave_auth` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`cd_empresa`),
  KEY `fk_rel_empresa1` (`cd_ceo`),
  CONSTRAINT `fk_rel_empresa1` FOREIGN KEY (`cd_ceo`) REFERENCES `tb_colab` (`cd_colab`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_empresa` WRITE;
/*!40000 ALTER TABLE `tb_empresa` DISABLE KEYS */;
INSERT INTO `tb_empresa` VALUES (1,'MARIA DA LUZ GOMES DA SILVA','MODA E ARTES',2147483647,1,'AUTH');
/*!40000 ALTER TABLE `tb_empresa` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_estilo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_estilo` (
  `cd_estilo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_estilo` varchar(40) DEFAULT NULL,
  `t_sidebar` varchar(200) DEFAULT NULL,
  `c_sidebar` varchar(200) DEFAULT NULL,
  `t_navbar` varchar(200) DEFAULT NULL,
  `c_navbar` varchar(200) DEFAULT NULL,
  `t_font` varchar(200) DEFAULT NULL,
  `c_font` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cd_estilo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_estilo` WRITE;
/*!40000 ALTER TABLE `tb_estilo` DISABLE KEYS */;
INSERT INTO `tb_estilo` VALUES (1,'Light-blue','padrão','style=\"background-color: #a7dbfb; color: #044167;\"','padrão','style=\"background-color: #23a5f6;\"','padrão','padrão'),(2,'Dark-blue','padrão','style=\"background-color: #191970; color: #8b8bbb;\"','padrão','style=\"background-color: #2727ec;\"','padrão','padrão');
/*!40000 ALTER TABLE `tb_estilo` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_filial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_filial` (
  `cd_filial` int(11) NOT NULL AUTO_INCREMENT,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_responsavel` int(11) DEFAULT NULL,
  `rsocial_filial` varchar(40) DEFAULT NULL,
  `nfantasia_filial` varchar(40) DEFAULT NULL,
  `cnpj_filial` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_filial`),
  KEY `fk_rel_filial1` (`cd_empresa`),
  KEY `fk_rel_filial2` (`cd_responsavel`),
  CONSTRAINT `fk_rel_filial1` FOREIGN KEY (`cd_empresa`) REFERENCES `tb_empresa` (`cd_empresa`),
  CONSTRAINT `fk_rel_filial2` FOREIGN KEY (`cd_responsavel`) REFERENCES `tb_colab` (`cd_colab`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_filial` WRITE;
/*!40000 ALTER TABLE `tb_filial` DISABLE KEYS */;
INSERT INTO `tb_filial` VALUES (1,1,1,'MARIA DA LUZ GOMES DA SILVA','MODA E ARTES',2147483647);
/*!40000 ALTER TABLE `tb_filial` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_funcao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_funcao` (
  `cd_funcao` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_funcao` varchar(200) DEFAULT NULL,
  `obs_funcao` varchar(200) DEFAULT NULL,
  `md_patrimonio` varchar(200) DEFAULT NULL,
  `md_fponto` varchar(200) DEFAULT NULL,
  `md_assistencia` varchar(200) DEFAULT NULL,
  `md_cliente` varchar(200) DEFAULT NULL,
  `md_fornecedor` varchar(200) DEFAULT NULL,
  `md_clientefornecedor` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cd_funcao`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_funcao` WRITE;
/*!40000 ALTER TABLE `tb_funcao` DISABLE KEYS */;
INSERT INTO `tb_funcao` VALUES (1,'MASTER','observações','style=\"display: block;\"','style=\"display: block;\"','style=\"display: block;\"','style=\"display: block;\"','style=\"display: block;\"','style=\"display: block;\"'),(2,'Cliente','observações','style=\"display: none;\"','style=\"display: none;\"','style=\"display: none;\"','style=\"display: block;\"','style=\"display: none;\"','style=\"display: none;\"'),(3,'Fornecedor','observações','style=\"display: none;\"','style=\"display: none;\"','style=\"display: none;\"','style=\"display: none;\"','style=\"display: block;\"','style=\"display: none;\"'),(4,'Cliente / Fornecedor','observações','style=\"display: none;\"','style=\"display: none;\"','style=\"display: none;\"','style=\"display: none;\"','style=\"display: none;\"','style=\"display: block;\"'),(5,'Assistente','observações','style=\"display: block;\"','style=\"display: block;\"','style=\"display: block;\"','style=\"display: none;\"','style=\"display: none;\"','style=\"display: none;\"');
/*!40000 ALTER TABLE `tb_funcao` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_seguranca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_seguranca` (
  `cd_seg` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_seg` varchar(200) DEFAULT NULL,
  `obs_seg` varchar(40) DEFAULT NULL,
  `cd_colab` varchar(40) DEFAULT NULL,
  `empresa` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`cd_seg`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_seguranca` WRITE;
/*!40000 ALTER TABLE `tb_seguranca` DISABLE KEYS */;
INSERT INTO `tb_seguranca` VALUES (1,'master','User Master','1','1');
/*!40000 ALTER TABLE `tb_seguranca` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tb_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_servico` (
  `cd_servico` int(11) NOT NULL AUTO_INCREMENT,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_servico` varchar(100) DEFAULT NULL,
  `obs_servico` varchar(1000) DEFAULT NULL,
  `prioridade_servico` varchar(10) DEFAULT NULL,
  `prazo_servico` varchar(40) DEFAULT NULL,
  `orcamento_servico` varchar(40) DEFAULT NULL,
  `vpag_servico` varchar(40) DEFAULT NULL,
  `status_servico` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cd_servico`),
  KEY `fk_rel_cliente` (`cd_cliente`),
  CONSTRAINT `fk_rel_cliente` FOREIGN KEY (`cd_cliente`) REFERENCES `tb_cliente` (`cd_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_servico` WRITE;
/*!40000 ALTER TABLE `tb_servico` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_servico` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

