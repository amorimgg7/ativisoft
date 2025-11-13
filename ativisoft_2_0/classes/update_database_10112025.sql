
ALTER TABLE `tb_acesso` 
    ADD `md_comissao` VARCHAR(40) NULL DEFAULT NULL AFTER `md_folhaponto`, 
    ADD `md_financeiro` VARCHAR(40) NULL DEFAULT NULL AFTER `md_comissao`, 
    ADD `md_cadastros` VARCHAR(40) NULL DEFAULT NULL AFTER `md_financeiro`;

update tb_acesso set 
    md_comissao     =   "111",
    md_financeiro   =   "111",
    md_cadastro     =   "111" 