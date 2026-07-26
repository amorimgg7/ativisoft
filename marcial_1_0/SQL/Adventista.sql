
CREATE TABLE `tb_pessoa` (
  `cd_pessoa` int(11) NOT NULL,
  `pnome_pessoa` varchar(80) DEFAULT NULL,
  `snome_pessoa` varchar(80) DEFAULT NULL,
  `sexo_pessoa` varchar(40) DEFAULT NULL,
  `cpf_pessoa` varchar(40) DEFAULT NULL,
  `dt_nasc_pessoa` datetime DEFAULT NULL,
  `tel_pessoa` varchar(40) DEFAULT NULL,
  `email_pessoa` varchar(80) DEFAULT NULL,
  `grupo_pessoa` varchar(10) DEFAULT NULL,
  `dt_cad_pessoa` datetime DEFAULT NULL,
  `senha_pessoa` varchar(999) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `tb_pessoa`
  ADD PRIMARY KEY (`cd_pessoa`);

ALTER TABLE `tb_pessoa`
  MODIFY `cd_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `tb_pessoa` (`pnome_pessoa`, `snome_pessoa`, `sexo_pessoa`, `cpf_pessoa`, `dt_nasc_pessoa`, `tel_pessoa`, `email_pessoa`, `grupo_pessoa`, `dt_cad_pessoa`, `senha_pessoa`) VALUES
('Suporte', 'AtiviSoft', 'M', '123', '2000-09-27', '5521965543094', 'suporte@ativisoft.com.br', 'N0', '2024-06-02', 'asd123');

CREATE TABLE `tb_pedido_oracao` (
  `cd_pedido_oracao` int(11) NOT NULL,
  `cd_pessoa` int(11) NOT NULL,
  `tel_pedido_oracao` varchar(40) NOT NULL,
  `dt_pedido_oracao` datetime NOT NULL,
  `obs_pedido_oracao` varchar(999) NOT NULL,
  `dt_primeira_abertura_pedido_oracao` varchar(999) DEFAULT NULL,
  `dt_ultima_abertura_pedido_oracao` varchar(999) DEFAULT NULL,
  `cd_quem_abriu_primeiro` varchar(999) DEFAULT NULL,
  `cd_quem_abriu_ultimo` varchar(999) DEFAULT NULL  
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `tb_pedido_oracao`
  ADD PRIMARY KEY (`cd_pedido_oracao`);

ALTER TABLE `tb_pedido_oracao`
  MODIFY `cd_pedido_oracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


CREATE TABLE `tb_pedido_auxilio` (
  `cd_pedido_auxilio` int(11) NOT NULL,
  `cd_pessoa` int(11) NOT NULL,
  `tel_pedido_auxilio` varchar(999) NOT NULL,
  `dt_pedido_auxilio` datetime NOT NULL,
  `obs_pedido_auxilio` varchar(999) NOT NULL,
  `dt_primeira_abertura_pedido_auxilio` varchar(999) DEFAULT NULL,
  `dt_ultima_abertura_pedido_auxilio` varchar(999) DEFAULT NULL,
  `cd_quem_abriu_primeiro` varchar(999) DEFAULT NULL,
  `cd_quem_abriu_ultimo` varchar(999) DEFAULT NULL  
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `tb_pedido_auxilio`
  ADD PRIMARY KEY (`cd_pedido_auxilio`);

ALTER TABLE `tb_pedido_auxilio`
  MODIFY `cd_pedido_auxilio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `tb_visita` (
  `cd_visita` int(11) NOT NULL,
  `cd_pessoa` int(11) NOT NULL,
  `tel_visita` varchar(40) NOT NULL,
  `dt_visita_entrada` datetime NOT NULL,
  `dt_visita_saida` datetime NOT NULL,
  `obs_visita` varchar(999) NOT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `tb_visita`
  ADD PRIMARY KEY (`cd_visita`);

ALTER TABLE `tb_visita`
  MODIFY `cd_visita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--Pedido de teste
--INSERT INTO `tb_pedido_oracao` (`cd_pessoa`, `tel_pedido_oracao`, `dt_pedido_oracao`, `obs_pedido_oracao`) VALUES
--(1, '5521965543094', '2024-06-02', 'Pedido de teste'),

COMMIT;


