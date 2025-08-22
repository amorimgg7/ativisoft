

create table tb_comissao(
    cd_comissao integer PRIMARY KEY AUTO_INCREMENT,
    cd_colab integer,
    cd_servico integer,
    vl_comissao decimal(10,2),
    percent_comissao decimal(10,2),
    status_comissao integer


);

ALTER TABLE tb_comissao
    ADD CONSTRAINT fk_tb_comissao1 FOREIGN KEY(cd_servico) REFERENCES tb_servico (cd_servico),
    ADD CONSTRAINT fk_tb_comissao2 FOREIGN KEY(cd_colab) REFERENCES tb_pessoa (cd_pessoa);





ALTER TABLE `tb_pessoa` ADD `percent_comissao` DECIMAL(10,2) NULL DEFAULT '0';


