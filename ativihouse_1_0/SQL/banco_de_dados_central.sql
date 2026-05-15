



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE tb_seguranca(
    `cd_seg` integer PRIMARY KEY AUTO_INCREMENT,	
    `titulo_seg` varchar(200),
    `obs_seg` varchar(40),
    `cd_colab` varchar(40),
	`empresa` varchar(40)
);

INSERT INTO tb_seguranca (titulo_seg,obs_seg, cd_colab, empresa)
VALUES ('master', 'User Master', '1', '1');




CREATE TABLE `tb_pessoa` (
  `cd_pessoa` integer PRIMARY KEY AUTO_INCREMENT,
  `pnome_pessoa` varchar(40) DEFAULT NULL,
  `snome_pessoa` varchar(40) DEFAULT NULL,
  `cpf_pessoa` varchar(40) DEFAULT NULL,
  `dtnasc_pessoa` varchar(40) DEFAULT NULL,
  `sexo_pessoa` varchar(40) DEFAULT NULL,
  `obs_pessoa` varchar(40) DEFAULT NULL,
  `tel_pessoa` varchar(40) DEFAULT NULL,
  `obs_tel_pessoa` varchar(40) DEFAULT NULL,
  `email_pessoa` varchar(40) DEFAULT NULL,
  `foto_pessoa` varchar(1000) DEFAULT NULL,
  `senha_pessoa` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_pessoa` (`cd_pessoa`, `pnome_pessoa`, `snome_pessoa`, `cpf_pessoa`, `dtnasc_pessoa`, `sexo_pessoa`, `obs_pessoa`, `tel_pessoa`, `obs_tel_pessoa`, `email_pessoa`, `foto_pessoa`, `senha_pessoa`) VALUES
(1, 'Usuário', 'Mestre', '05185255544', NULL, 'M', 'Criador e prestador de suporte mestre', '5521965543094', 'telefone do suporte', 'amorimgg7@gmail.com', '', 'asd,123');




CREATE TABLE `tb_estilo` (
  `cd_estilo` integer PRIMARY KEY AUTO_INCREMENT,
  `titulo_estilo` varchar(40) DEFAULT NULL,
  `t_sidebar` varchar(200) DEFAULT NULL,
  `c_sidebar` varchar(200) DEFAULT NULL,
  `t_navbar` varchar(200) DEFAULT NULL,
  `c_navbar` varchar(200) DEFAULT NULL,
  `t_font` varchar(200) DEFAULT NULL,
  `c_font` varchar(200) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_estilo` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`) VALUES
(1, 'Light-blue', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão'),
(2, 'Dark-blue', 'padrão', 'style=\"background-color: #191970; color: #8b8bbb;\"', 'padrão', 'style=\"background-color: #2727ec;\"', 'padrão', 'padrão');




CREATE TABLE `tb_funcao` (
  `cd_funcao` integer PRIMARY KEY AUTO_INCREMENT,
  `titulo_funcao` varchar(200) DEFAULT NULL,
  `obs_funcao` varchar(200) DEFAULT NULL,
  `md_cadastro_hw` varchar(40) DEFAULT NULL,
  `md_edicao_hw` varchar(40) DEFAULT NULL,
  `md_cadastro_pessoa` varchar(40) DEFAULT NULL,
  `md_edita_pessoa` varchar(40) DEFAULT NULL,
  `md_permite_pessoa` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_funcao` (`cd_funcao`, `titulo_funcao`, `obs_funcao`, `md_cadastro_hw`, `md_edicao_hw`, `md_cadastro_pessoa`, `md_edita_pessoa`, `md_permite_pessoa`) VALUES
(1, 'Root', 'Tudo liberado', '2', '2', '2', '2', '2');




CREATE TABLE tb_casa(
  cd_casa integer PRIMARY KEY AUTO_INCREMENT,
  cd_anfitriao int(11) DEFAULT NULL,
  titulo_casa varchar(100) DEFAULT NULL,
  obs_casa varchar(1000) DEFAULT NULL,
  iptu_casa varchar(100) DEFAULT NULL,
  cd_endereco int(11) DEFAULT NULL,
  status_casa varchar(10) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_casa (titulo_casa, obs_casa, status_casa)
VALUES ('Casa teste', 'Testes', '0');




CREATE TABLE tb_endereco(
  cd_endereco integer PRIMARY KEY AUTO_INCREMENT,
  cep_endereco varchar(100) DEFAULT NULL,
  pais_endereco varchar(100) DEFAULT NULL,
  estado_endereco varchar(100) DEFAULT NULL,
  municipio_endereco varchar(100) DEFAULT NULL,
  bairro_endereco varchar(100) DEFAULT NULL,
  logradouro_endereco varchar(100) DEFAULT NULL,
  complemento_endereco varchar(100) DEFAULT NULL,
  tipo_endereco varchar(100) DEFAULT NULL,
  status_endereco varchar(100) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_endereco(cep_endereco, pais_endereco, estado_endereco, municipio_endereco, bairro_endereco, logradouro_endereco, complemento_endereco, tipo_endereco, status_endereco)
VALUES ('22780805', 'BRASIL', 'RJ', 'RIO DE JANEIRO', 'CURICICA', 'RUA JOÃO BRUNO LOBO, 291', 'LOTE A, CASA 1', 'RESIDENCIAL', '0');




CREATE TABLE tb_dispositivo(
    cd_dispositivo integer PRIMARY KEY AUTO_INCREMENT,
    cd_casa_dispositivo integer,
    mac_dispositivo varchar(99),
    ip_dispositivo varchar(9999),
    mascara_dispositivo varchar(40),
    gateway_dispositivo varchar(40),
    marca_dispositivo varchar(40),
    modelo_dispositivo varchar(40),
    versao_dispositivo varchar(40),
    titulo_dispositivo varchar(40),
    local_dispositivo varchar(40),
    status_dispositivo varchar(40),
    dt_status_dispositivo DATETIME NOT NULL,
    canal_1 varchar(40),
    canal_2 varchar(40),
    canal_3 varchar(40),
    canal_4 varchar(40),
    canal_5 varchar(40),
    canal_6 varchar(40),
    canal_7 varchar(40),
    canal_8 varchar(40)
);




CREATE TABLE `rel_user` (
  `cd_rel` integer PRIMARY KEY AUTO_INCREMENT,
  `token_alter` int(11) NOT NULL,
  `cd_seg` int(11) DEFAULT NULL,
  `cd_pessoa` int(11) DEFAULT NULL,
  `cd_estilo` int(11) DEFAULT NULL,
  `cd_funcao` int(11) DEFAULT NULL,
  `cd_casa` int(11) DEFAULT NULL,
  `ds_status` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `rel_user` (`cd_seg`, `cd_pessoa`, `cd_estilo`, `cd_funcao`, `cd_casa`, `ds_status`) VALUES
(1, 1, 1, 1, 1, 1);

ALTER TABLE `rel_user`
  ADD KEY `fk_rel_user1` (`cd_pessoa`),
  ADD KEY `fk_rel_user2` (`cd_estilo`),
  ADD KEY `fk_rel_user3` (`cd_funcao`),
  ADD KEY `fk_rel_user4` (`cd_casa`);

ALTER TABLE `rel_user`
  ADD CONSTRAINT `fk_rel_user1`   FOREIGN KEY (`cd_pessoa`)   REFERENCES `tb_pessoa`  (`cd_pessoa`),
  ADD CONSTRAINT `fk_rel_user2`   FOREIGN KEY (`cd_estilo`)   REFERENCES `tb_estilo`  (`cd_estilo`),
  ADD CONSTRAINT `fk_rel_user3`   FOREIGN KEY (`cd_funcao`)   REFERENCES `tb_funcao`  (`cd_funcao`),
  ADD CONSTRAINT `fk_rel_user4`   FOREIGN KEY (`cd_casa`)     REFERENCES `tb_casa`    (`cd_casa`);

CREATE TABLE clima_tempo (
  `dt_clima_tempo` DATETIME NOT NULL,
  `mac_dispositivo_clima_tempo` int(11) NOT NULL,
  `temperatura_clima_tempo` varchar(40),
  `umidade_clima_tempo` varchar(40)
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE clima_tempo
  ADD KEY fk_clima_tempo (`mac_dispositivo_clima_tempo`);
