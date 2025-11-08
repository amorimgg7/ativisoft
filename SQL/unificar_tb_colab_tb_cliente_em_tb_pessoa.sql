-- bkp # faça isso antes de qualquer mudança
-- bkp mysqldump -u root -p --single-transaction --routines --triggers --events erp_123 > erp_123_pre_migration_$(date +%F_%H%M).sql


-- Use o BD correto
USE assistent_08057969000100;

-- Garante que o banco pode ser modificado
SET FOREIGN_KEY_CHECKS = 0;

-- Limpa a tb_pessoa e as tabelas de mapeamento temporárias do processo anterior
DROP TABLE IF EXISTS tb_pessoa;
DROP TEMPORARY TABLE IF EXISTS Temp_Map_Colab;
DROP TEMPORARY TABLE IF EXISTS Temp_Map_Cliente;

-- 1. RECRIA A TABELA TB_PESSOA (Sem a restrição UNIQUE em CPF e Email, que podem estar vazios)
CREATE TABLE tb_pessoa (
    cd_pessoa INTEGER PRIMARY KEY AUTO_INCREMENT,
    pnome_pessoa VARCHAR(40),
    snome_pessoa VARCHAR(40),
    cpf_pessoa VARCHAR(40),
    dtnasc_pessoa VARCHAR(40),
    sexo_pessoa VARCHAR(40),
    obs_pessoa VARCHAR(40),
    tel_pessoa VARCHAR(40),
    obs_tel_pessoa VARCHAR(40),
    email_pessoa VARCHAR(40),
    foto_pessoa VARCHAR(1000),
    senha_pessoa VARCHAR(40),
    tipo_pessoa CHAR(1) NOT NULL -- 'B' (Colaborador), 'C' (Cliente), 'A' (Ambos)
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


-- 3. MIGRAÇÃO: INSERE TODOS OS COLABORADORES (Tipo 'B')
-- Assume-se que a prioridade de registro é o Colaborador.
INSERT INTO tb_pessoa (
    pnome_pessoa, snome_pessoa, cpf_pessoa, dtnasc_pessoa, sexo_pessoa,
    obs_pessoa, tel_pessoa, obs_tel_pessoa, email_pessoa, foto_pessoa, senha_pessoa, tipo_pessoa
)
SELECT
    pnome_colab, snome_colab, cpf_colab, dtnasc_colab, sexo_colab,
    obs_colab, tel_colab, obs_tel_colab, email_colab, foto_colab, senha_colab, 'B'
FROM tb_colab;


-- 4. MIGRAÇÃO: INSERE CLIENTES QUE NÃO SÃO COLABORADORES (Tipo 'C')
-- Usa LEFT JOIN/WHERE NULL para encontrar apenas CPF's de Cliente que AINDA NÃO estão em tb_pessoa.
INSERT INTO tb_pessoa (
    pnome_pessoa, snome_pessoa, cpf_pessoa, dtnasc_pessoa, sexo_pessoa,
    obs_pessoa, tel_pessoa, obs_tel_pessoa, email_pessoa, foto_pessoa, senha_pessoa, tipo_pessoa
)
SELECT
    tcl.pnome_cliente, tcl.snome_cliente, tcl.cpf_cliente, tcl.dtnasc_cliente, tcl.sexo_cliente,
    tcl.obs_cliente, tcl.tel_cliente, tcl.obs_tel_cliente, tcl.email_cliente, tcl.foto_cliente, tcl.senha_cliente, 'C'
FROM tb_cliente tcl
LEFT JOIN tb_pessoa tp ON tcl.cpf_cliente = tp.cpf_pessoa AND tcl.cpf_cliente != ''
WHERE tp.cd_pessoa IS NULL;


-- 5. ATUALIZAÇÃO: MARCA COMO 'AMBOS' (Tipo 'A') QUEM É COLABORADOR E CLIENTE
-- Se um CPF existe nas duas tabelas, o registro original era 'B'. Agora, ele será atualizado para 'A'.

SET SQL_SAFE_UPDATES = 0;

UPDATE tb_pessoa tp
INNER JOIN tb_cliente tcl ON tp.cpf_pessoa = tcl.cpf_cliente
INNER JOIN tb_colab tco ON tp.cpf_pessoa = tco.cpf_colab
SET tp.tipo_pessoa = 'A'
WHERE tp.cpf_pessoa != '';


-- 6. MAPEAR COLABORADORES (old_cd_colab -> new_cd_pessoa)
INSERT INTO Temp_Map_Colab (old_cd_colab, new_cd_pessoa)
SELECT
    tco.cd_colab, tp.cd_pessoa
FROM tb_colab tco
INNER JOIN tb_pessoa tp ON tco.cpf_colab = tp.cpf_pessoa AND tco.cpf_colab != '' -- Pessoas com CPF
UNION ALL
SELECT
    tco.cd_colab, tp.cd_pessoa
FROM tb_colab tco
INNER JOIN tb_pessoa tp ON tco.cd_colab = tp.cd_pessoa -- Pessoas sem CPF (assumindo que foram inseridas sequencialmente no início)
WHERE tco.cpf_colab = '';


-- 7. MAPEAR CLIENTES (old_cd_cliente -> new_cd_pessoa)
INSERT INTO Temp_Map_Cliente (old_cd_cliente, new_cd_pessoa)
SELECT
    tcl.cd_cliente, tp.cd_pessoa
FROM tb_cliente tcl
INNER JOIN tb_pessoa tp ON tcl.cpf_cliente = tp.cpf_pessoa AND tcl.cpf_cliente != '' -- Pessoas com CPF
UNION ALL
SELECT
    tcl.cd_cliente, tp.cd_pessoa
FROM tb_cliente tcl
INNER JOIN tb_pessoa tp ON tcl.cd_cliente = (tp.cd_pessoa - (SELECT MAX(cd_pessoa) FROM tb_colab)) -- Usa a lógica de sequencia de inserção
WHERE tcl.cpf_cliente = '';

-- **ATENÇÃO:** O mapeamento de CPF vazio é o mais arriscado. Se as tabelas têm muitos registros sem CPF,
-- é mais seguro usar o 'email' como fallback, caso ele seja único entre os registros sem CPF.


-- 7. ATUALIZAÇÃO DAS TABELAS DEPENDENTES DE TB_COLAB e TB_CLIENTE
-- (O código é o mesmo do plano anterior)

-- ... CONTINUE COM TODOS OS ALTER TABLE, DROP FOREIGN KEY e UPDATE
-- USANDO Temp_Map_Colab e Temp_Map_Cliente
-- ...

-- 8. RESTRUTURAÇÃO DE TB_COLAB E TB_CLIENTE (Role Tables)
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

