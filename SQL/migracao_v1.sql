-- bkp # faça isso antes de qualquer mudança
-- bkp mysqldump -u root -p --single-transaction --routines --triggers --events erp_123 > erp_123_pre_migration_$(date +%F_%H%M).sql

-- Use o BD correto
USE as_08057969;

-- Garante que o banco pode ser modificado
SET FOREIGN_KEY_CHECKS = 0;

-- Limpa a tb_pessoa e as tabelas de mapeamento temporárias do processo anterior
DROP TABLE IF EXISTS tb_pessoa;
DROP TEMPORARY TABLE IF EXISTS Temp_Map_Colab;
DROP TEMPORARY TABLE IF EXISTS Temp_Map_Cliente;

-- 1. RECRIA A TABELA TB_PESSOA
CREATE TABLE tb_pessoa(
    cd_pessoa integer PRIMARY KEY AUTO_INCREMENT,
    pnome_pessoa varchar(40),
    snome_pessoa varchar(40),
    cpf_pessoa varchar(40),
    dtnasc_pessoa varchar(40),
    obs_pessoa varchar(40),
    tel1_pessoa varchar(40),
    obs_tel1_pessoa varchar(40),
    tel2_pessoa varchar(40),
    obs_tel2_pessoa varchar(40),
    email_pessoa varchar(40),
    senha_pessoa varchar(40),
    id_google varchar(40),
    id_facebook varchar(40),
    tipo_pessoa varchar(40),
    subtipo_pessoa varchar(40)
);

-- 2. CRIAÇÃO DAS TABELAS TEMPORÁRIAS DE MAPA
CREATE TEMPORARY TABLE Temp_Map_Colab (
    old_cd_colab INTEGER PRIMARY KEY,
    new_cd_pessoa INTEGER
);

CREATE TEMPORARY TABLE Temp_Map_Cliente (
    old_cd_cliente INTEGER PRIMARY KEY,
    new_cd_pessoa INTEGER
);

-- 3. MIGRAÇÃO: INSERE COLABORADORES
INSERT INTO tb_pessoa (
    pnome_pessoa, snome_pessoa, cpf_pessoa, dtnasc_pessoa,
    obs_pessoa, tel1_pessoa, obs_tel1_pessoa, email_pessoa, senha_pessoa, tipo_pessoa
)
SELECT
    pnome_colab, snome_colab, cpf_colab, dtnasc_colab,
    obs_colab, tel_colab, obs_tel_colab, email_colab, senha_colab, 'colab'
FROM tb_colab;

-- 4. MIGRAÇÃO: INSERE CLIENTES QUE NÃO SÃO COLABORADORES
INSERT INTO tb_pessoa (
    pnome_pessoa, snome_pessoa, cpf_pessoa, dtnasc_pessoa,
    obs_pessoa, tel1_pessoa, obs_tel1_pessoa, email_pessoa, senha_pessoa, tipo_pessoa
)
SELECT
    tcl.pnome_cliente, tcl.snome_cliente, tcl.cpf_cliente, tcl.dtnasc_cliente,
    tcl.obs_cliente, tcl.tel_cliente, tcl.obs_tel_cliente, tcl.email_cliente, tcl.senha_cliente, 'cliente'
FROM tb_cliente tcl
LEFT JOIN tb_pessoa tp 
    ON tcl.cpf_cliente COLLATE latin1_swedish_ci = tp.cpf_pessoa COLLATE latin1_swedish_ci
    AND tcl.cpf_cliente != ''
WHERE tp.cd_pessoa IS NULL;

-- 5. ATUALIZAÇÃO: MARCA COMO 'AMBOS'
SET SQL_SAFE_UPDATES = 0;

UPDATE tb_pessoa tp
INNER JOIN tb_cliente tcl 
    ON tp.cpf_pessoa COLLATE latin1_swedish_ci = tcl.cpf_cliente COLLATE latin1_swedish_ci
INNER JOIN tb_colab tco 
    ON tp.cpf_pessoa COLLATE latin1_swedish_ci = tco.cpf_colab COLLATE latin1_swedish_ci
SET tp.tipo_pessoa = 'cliente'
WHERE tp.cpf_pessoa != '';

-- 6. MAPEAR COLABORADORES
INSERT INTO Temp_Map_Colab (old_cd_colab, new_cd_pessoa)
SELECT
    tco.cd_colab, tp.cd_pessoa
FROM tb_colab tco
INNER JOIN tb_pessoa tp 
    ON tco.cpf_colab COLLATE latin1_swedish_ci = tp.cpf_pessoa COLLATE latin1_swedish_ci
    AND tco.cpf_colab != ''

UNION ALL

SELECT
    tco.cd_colab, tp.cd_pessoa
FROM tb_colab tco
INNER JOIN tb_pessoa tp 
    ON tco.cd_colab = tp.cd_pessoa
WHERE tco.cpf_colab = '';

-- 7. MAPEAR CLIENTES
INSERT INTO Temp_Map_Cliente (old_cd_cliente, new_cd_pessoa)
SELECT
    tcl.cd_cliente, tp.cd_pessoa
FROM tb_cliente tcl
INNER JOIN tb_pessoa tp 
    ON tcl.cpf_cliente COLLATE latin1_swedish_ci = tp.cpf_pessoa COLLATE latin1_swedish_ci
    AND tcl.cpf_cliente != ''

UNION ALL

SELECT
    tcl.cd_cliente, tp.cd_pessoa
FROM tb_cliente tcl
INNER JOIN tb_pessoa tp 
    ON tcl.cd_cliente = (tp.cd_pessoa - (SELECT MAX(cd_pessoa) FROM tb_colab))
WHERE tcl.cpf_cliente = '';

-- 8. RESTRUTURAÇÃO DE TB_COLAB E TB_CLIENTE
RENAME TABLE tb_colab TO tb_colab_old;
RENAME TABLE tb_cliente TO tb_cliente_old;

CREATE TABLE tb_colab (
    cd_colab INTEGER PRIMARY KEY,
    FOREIGN KEY (cd_colab) REFERENCES tb_pessoa(cd_pessoa)
);

CREATE TABLE tb_cliente (
    cd_cliente INTEGER PRIMARY KEY,
    FOREIGN KEY (cd_cliente) REFERENCES tb_pessoa(cd_pessoa)
);

INSERT INTO tb_colab (cd_colab) SELECT new_cd_pessoa FROM Temp_Map_Colab;
INSERT INTO tb_cliente (cd_cliente) SELECT new_cd_pessoa FROM Temp_Map_Cliente;

-- 9. LIMPEZA E REATIVAÇÃO
DROP TEMPORARY TABLE Temp_Map_Colab;
DROP TEMPORARY TABLE Temp_Map_Cliente;

SET FOREIGN_KEY_CHECKS = 1;

-- COMPLEMENTAR FALTANTES

CREATE TABLE tb_acesso (
    cd_acesso INT AUTO_INCREMENT PRIMARY KEY,
    titulo_acesso VARCHAR(40),
    obs_acesso VARCHAR(40),
    vl_preco DECIMAL(10,2),
    vl_desconto_ano DECIMAL(10,2),
    md_caixa VARCHAR(40),
    md_assistencia VARCHAR(40),
    md_patrimonio VARCHAR(40),
    md_folhaponto VARCHAR(40)
);

INSERT INTO tb_acesso (titulo_acesso, obs_acesso, vl_preco, md_caixa, md_assistencia, md_patrimonio, md_folhaponto)
VALUES  
("Master", "Desenvolvimento/Suporte", "0", "999", "999", "999", "999"),
("Essencial", "Pacote de licença 1", "50", "111", "111", "111", "111");

CREATE TABLE rel_master(
    cd_rel integer PRIMARY KEY AUTO_INCREMENT,
    token_alter varchar(40),
    cd_pessoa integer,
    cd_estilo integer,
    cd_acesso integer,
    cd_empresa integer,
    status_rel varchar(40)
);

ALTER TABLE rel_master
ADD CONSTRAINT fk_rel_pessoa FOREIGN KEY (cd_pessoa) REFERENCES tb_pessoa (cd_pessoa),
ADD CONSTRAINT fk_rel_estilo FOREIGN KEY (cd_estilo) REFERENCES tb_estilo (cd_estilo),
ADD CONSTRAINT fk_rel_acesso FOREIGN KEY (cd_acesso) REFERENCES tb_acesso (cd_acesso),
ADD CONSTRAINT fk_rel_empresa FOREIGN KEY (cd_empresa) REFERENCES tb_empresa (cd_empresa);

ALTER TABLE rel_master 
ADD CONSTRAINT pessoas FOREIGN KEY (cd_pessoa) REFERENCES tb_pessoa(cd_pessoa) 
ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO rel_master (token_alter, cd_pessoa, cd_estilo, cd_acesso, cd_empresa, status_rel)
VALUES ('100001', 1, 1, 1, 1, 'ativo'),
       ('100001', 2, 1, 2, 1, 'ativo');

ALTER TABLE tb_empresa 
    ADD cd_proprietario integer NULL,
    ADD tipo_empresa VARCHAR(40) NULL,
    ADD iestadual_empresa VARCHAR(40) NULL,
    ADD imunicipal_empresa VARCHAR(40) NULL,
    ADD dt_abertura_empresa VARCHAR(40) NULL,
    ADD obs_empresa VARCHAR(40) NULL,
    ADD tel1_empresa VARCHAR(40) NULL,
    ADD obstel1_empresa VARCHAR(40) NULL,
    ADD tel2_empresa VARCHAR(40) NULL,
    ADD obstel2_empresa VARCHAR(40) NULL,
    ADD email_empresa VARCHAR(40) NULL,
    ADD endereco_empresa VARCHAR(40) NULL,
    ADD status_empresa VARCHAR(40) NULL,
    ADD saudacoes_empresa varchar(999) DEFAULT NULL,
    ADD tipo_mensagem varchar(40) DEFAULT NULL,
    ADD tipo_impressao varchar(40) DEFAULT NULL;

CREATE TABLE tb_contrato (
    cd_contrato INT AUTO_INCREMENT PRIMARY KEY,
    cd_empresa integer,
    cd_acesso integer,
    cd_contratante integer,
    dt_contrato DATETIME,
    dt_validade DATETIME,
    vl_contrato decimal(10,2),
    ds_contrato VARCHAR(40),
    status_contrato VARCHAR(1)
);

ALTER TABLE tb_contrato
ADD CONSTRAINT fk_contrato_1 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa (cd_empresa),
ADD CONSTRAINT fk_contrato_2 FOREIGN KEY (cd_acesso) REFERENCES tb_acesso (cd_acesso),
ADD CONSTRAINT fk_contrato_3 FOREIGN KEY (cd_contratante) REFERENCES tb_pessoa (cd_pessoa);

ALTER TABLE tb_caixa 
    ADD cd_filial integer NOT NULL DEFAULT '1';

ALTER TABLE tb_servico 
    ADD cd_filial integer NOT NULL DEFAULT '1',
    ADD cd_colab_resp int(11) DEFAULT NULL,
    ADD vl_comissao decimal(10,2) DEFAULT NULL,
    ADD pc_comissao decimal(10,2) DEFAULT NULL,
    ADD id_servico varchar(40) DEFAULT NULL;

ALTER TABLE tb_servico
ADD CONSTRAINT fk_servico_1 FOREIGN KEY (cd_colab_resp) REFERENCES tb_pessoa (cd_pessoa);

CREATE TABLE tb_comissao(
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

ALTER TABLE tb_pessoa ADD percent_comissao DECIMAL(10,2) NULL DEFAULT '0';

UPDATE tb_empresa SET cd_proprietario = '1' WHERE cd_empresa = 1;


ALTER TABLE tb_acesso
  DROP md_caixa,
  DROP md_assistencia,
  DROP md_patrimonio,
  DROP md_folhaponto;
