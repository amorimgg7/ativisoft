--ALTER TABLE `tb_orcamento_servico` ADD `cd_produto` int(11) NULL DEFAULT NULL;


--ALTER TABLE `tb_orcamento_servico` ADD CONSTRAINT `fk_rel_orcamento3` FOREIGN KEY (`cd_produto`) REFERENCES `tb_prod_serv`(`cd_prod_serv`) ON DELETE RESTRICT ON UPDATE RESTRICT;


UPDATE tb_orcamento_servico
SET vtotal_orcamento = vcusto_orcamento
WHERE vtotal_orcamento IS NULL;


CREATE TABLE `tb_reserva` (
  `cd_reserva` int(11),
  `cd_cliente` int(11) DEFAULT NULL,
  `cd_servico` int(11) DEFAULT NULL,
  `cd_orcamento` int(11) DEFAULT NULL,
  `cd_venda` int(11) DEFAULT NULL,
  `cd_prod_serv` int(11) DEFAULT NULL,
  `qtd_reservado` int(11) DEFAULT NULL,
  `qtd_efetivado` int(11) DEFAULT NULL,
  `dt_reservado` varchar(40) DEFAULT NULL,
  `dt_efetivado` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `tb_reserva` ADD PRIMARY KEY (`cd_reserva`);
ALTER TABLE `tb_reserva`
  MODIFY `cd_reserva` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `tb_funcao` ADD `md_hospedagem` VARCHAR(200) NULL DEFAULT 'style="display: none;"';
