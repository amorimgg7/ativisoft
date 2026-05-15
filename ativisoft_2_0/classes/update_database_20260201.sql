







update tb_empresa set md_cameras = '222'




ALTER TABLE tb_empresa 
ADD md_caixa            boolean NOT NULL DEFAULT FALSE AFTER fatura_devida_empresa,
ADD md_assistencia      boolean NOT NULL DEFAULT FALSE AFTER md_caixa, 
ADD md_venda            boolean NOT NULL DEFAULT FALSE AFTER md_assistencia,
ADD md_patrimonio       boolean NOT NULL DEFAULT FALSE AFTER md_venda,
ADD md_folhaponto       boolean NOT NULL DEFAULT FALSE AFTER md_patrimonio,
ADD md_financeiro       boolean NOT NULL DEFAULT FALSE AFTER md_folhaponto,
ADD md_cadastro         boolean NOT NULL DEFAULT FALSE AFTER md_financeiro,
ADD md_pdv              boolean NOT NULL DEFAULT FALSE AFTER md_cadastro,
ADD md_cameras          boolean NOT NULL DEFAULT FALSE AFTER md_pdv;

ALTER TABLE tb_empresa 
ADD md_caixa_param            VARCHAR(40) DEFAULT NULL AFTER md_cameras,
ADD md_assistencia_param      VARCHAR(40) DEFAULT NULL AFTER md_caixa_param, 
ADD md_venda_param            VARCHAR(40) DEFAULT NULL AFTER md_assistencia_param,
ADD md_patrimonio_param       VARCHAR(40) DEFAULT NULL AFTER md_venda_param,
ADD md_folhaponto_param       VARCHAR(40) DEFAULT NULL AFTER md_patrimonio_param,
ADD md_financeiro_param       VARCHAR(40) DEFAULT NULL AFTER md_folhaponto_param,
ADD md_cadastro_param         VARCHAR(40) DEFAULT NULL AFTER md_financeiro_param,
ADD md_pdv_param              VARCHAR(40) DEFAULT NULL AFTER md_cadastro_param,
ADD md_cameras_param          VARCHAR(40) DEFAULT NULL AFTER md_pdv_param;






UPDATE tb_empresa
SET md_cameras_param = '1';







alter table tb_empresa add md_cameras varchar(3);


ALTER TABLE `rel_master`
  	ADD `acesso_cameras_0009` JSON NULL AFTER `acesso_pdv_0008`;



UPDATE rel_master
SET acesso_cameras_0009 = '[
    ["901", "Ver", "N"],
    ["902", "Cadastrar", "N"],
    ["903", "Editar", "N"],
    ["904", "Remover", "N"]
]';



UPDATE rel_master
 SET acesso_financeiro_0006 = JSON_ARRAY_APPEND(
    acesso_financeiro_0006,
    '$',
    JSON_ARRAY("605", "Ver Comissao", "N")
 );

UPDATE rel_master
 SET acesso_financeiro_0006 = JSON_ARRAY_APPEND(
    acesso_financeiro_0006,
    '$',
    JSON_ARRAY("606", "Lancar Comissao", "N")
 );

UPDATE rel_master
 SET acesso_financeiro_0006 = JSON_ARRAY_APPEND(
    acesso_financeiro_0006,
    '$',
    JSON_ARRAY("607", "Editar Comissao Cadastro", "N")
 );

UPDATE rel_master
 SET acesso_financeiro_0006 = JSON_ARRAY_APPEND(
    acesso_financeiro_0006,
    '$',
    JSON_ARRAY("608", "Editar Comissao Servico", "N")
 );

UPDATE rel_master
 SET acesso_financeiro_0006 = JSON_ARRAY_APPEND(
    acesso_financeiro_0006,
    '$',
    JSON_ARRAY("609", "Editar Comissao Venda", "N")
 );




UPDATE rel_master
   SET acesso_pdv_0008 = JSON_ARRAY_APPEND(
      acesso_pdv_0008,
      '$',
      JSON_ARRAY("813", "Iniciar Venda", "N")
   );

UPDATE rel_master
   SET acesso_pdv_0008 = JSON_ARRAY_APPEND(
      acesso_pdv_0008,
      '$',
      JSON_ARRAY("814", "Aplicar desconto", "N")
   );



-- DELETE FROM tb_contrato WHERE cd_empresa = '7';
-- DELETE FROM tb_movimento_financeiro WHERE cd_cliente_comercial = '7';
-- DELETE FROM tb_orcamento_servico WHERE cd_empresa = '7';
-- DELETE FROM tb_orcamento_venda WHERE cd_empresa = '7';
-- DELETE FROM tb_reserva WHERE cd_empresa = '7';
-- DELETE FROM tb_prod_serv WHERE cd_empresa = '7';
-- DELETE FROM tb_prod_serv WHERE cd_filial = '7';
-- DELETE FROM tb_atividade WHERE cd_empresa = '7';
-- DELETE FROM tb_servico WHERE cd_empresa = '7';
-- DELETE FROM tb_venda WHERE cd_empresa = '7';



DELETE a
FROM tb_atividade a
JOIN tb_servico s
  ON s.cd_servico = a.cd_servico
WHERE s.cd_empresa = 7;


DELETE a
FROM tb_movimento_financeiro a
JOIN tb_servico s
  ON s.cd_servico = a.cd_os_movimento
WHERE s.cd_empresa = 7;


