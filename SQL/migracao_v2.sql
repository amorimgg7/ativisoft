/* =========================================================
   MIGRAÇÃO VERSIONADA – UNIFICAÇÃO DE PESSOAS COMPLETA
   Versão: 2026.01.23_v2.4.0
   Objetivo: Unificar tb_colab e tb_cliente em tb_pessoa
             Corrigir todos os vínculos de serviços, orçamentos,
             movimentos financeiros, comissões e contratos
   ========================================================= */

START TRANSACTION;

-- =========================
-- 0. CONTROLE DE MIGRAÇÃO
-- =========================
CREATE TABLE IF NOT EXISTS schema_migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version VARCHAR(30) NOT NULL,
    description VARCHAR(255),
    executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO schema_migrations (version, description)
VALUES ('2026.01.23_v2.4.0', 'Unificação completa tb_colab e tb_cliente em tb_pessoa com colunas corretas de movimentos financeiros');

-- =========================
-- 1. TABELA PRINCIPAL
-- =========================
CREATE TABLE IF NOT EXISTS tb_pessoa (
    cd_pessoa INT AUTO_INCREMENT PRIMARY KEY,
    pnome_pessoa VARCHAR(40),
    snome_pessoa VARCHAR(40),
    cpf_pessoa VARCHAR(40),
    dtnasc_pessoa VARCHAR(40),
    obs_pessoa VARCHAR(40),
    tel1_pessoa VARCHAR(40),
    obs_tel1_pessoa VARCHAR(40),
    tel2_pessoa VARCHAR(40),
    obs_tel2_pessoa VARCHAR(40),
    email_pessoa VARCHAR(40),
    senha_pessoa VARCHAR(40),
    tipo_pessoa ENUM('colab','cliente','ambos'),
    percent_comissao DECIMAL(10,2) DEFAULT 0
);

-- =========================
-- 2. MAPAS FIXOS
-- =========================
DROP TABLE IF EXISTS map_colab_pessoa;
DROP TABLE IF EXISTS map_cliente_pessoa;

CREATE TABLE map_colab_pessoa (
    cd_colab INT PRIMARY KEY,
    cd_pessoa INT NOT NULL
);

CREATE TABLE map_cliente_pessoa (
    cd_cliente INT PRIMARY KEY,
    cd_pessoa INT NOT NULL
);

-- =========================
-- 3. MIGRA COLABORADORES
-- =========================
INSERT INTO tb_pessoa (
    pnome_pessoa, snome_pessoa, cpf_pessoa, dtnasc_pessoa,
    obs_pessoa, tel1_pessoa, obs_tel1_pessoa,
    email_pessoa, senha_pessoa, tipo_pessoa
)
SELECT
    pnome_colab, snome_colab, cpf_colab, dtnasc_colab,
    obs_colab, tel_colab, obs_tel_colab,
    email_colab, senha_colab, 'colab'
FROM tb_colab;

INSERT IGNORE INTO map_colab_pessoa (cd_colab, cd_pessoa)
SELECT c.cd_colab, p.cd_pessoa
FROM tb_colab c
JOIN tb_pessoa p
  ON (c.cpf_colab <> '' AND CONVERT(c.cpf_colab USING latin1) = CONVERT(p.cpf_pessoa USING latin1))
     OR (c.cpf_colab = '' 
         AND CONVERT(c.pnome_colab USING latin1) = CONVERT(p.pnome_pessoa USING latin1)
         AND CONVERT(c.snome_colab USING latin1) = CONVERT(p.snome_pessoa USING latin1)
         AND CONVERT(c.tel_colab USING latin1) = CONVERT(p.tel1_pessoa USING latin1));

-- =========================
-- 4. MIGRA CLIENTES
-- =========================
INSERT INTO tb_pessoa (
    pnome_pessoa, snome_pessoa, cpf_pessoa, dtnasc_pessoa,
    obs_pessoa, tel1_pessoa, obs_tel1_pessoa,
    email_pessoa, senha_pessoa, tipo_pessoa
)
SELECT
    c.pnome_cliente, c.snome_cliente, c.cpf_cliente, c.dtnasc_cliente,
    c.obs_cliente, c.tel_cliente, c.obs_tel_cliente,
    c.email_cliente, c.senha_cliente, 'cliente'
FROM tb_cliente c
LEFT JOIN tb_pessoa p
  ON CONVERT(c.cpf_cliente USING latin1) = CONVERT(p.cpf_pessoa USING latin1)
WHERE p.cd_pessoa IS NULL;

INSERT IGNORE INTO map_cliente_pessoa (cd_cliente, cd_pessoa)
SELECT c.cd_cliente, p.cd_pessoa
FROM tb_cliente c
JOIN tb_pessoa p
  ON (c.cpf_cliente <> '' AND CONVERT(c.cpf_cliente USING latin1) = CONVERT(p.cpf_pessoa USING latin1))
     OR (c.cpf_cliente = '' 
         AND CONVERT(c.pnome_cliente USING latin1) = CONVERT(p.pnome_pessoa USING latin1)
         AND CONVERT(c.snome_cliente USING latin1) = CONVERT(p.snome_pessoa USING latin1)
         AND CONVERT(c.tel_cliente USING latin1) = CONVERT(p.tel1_pessoa USING latin1));

-- =========================
-- 5. AJUSTA PESSOAS "AMBOS"
-- =========================
UPDATE tb_pessoa p
JOIN map_colab_pessoa mc ON mc.cd_pessoa = p.cd_pessoa
JOIN map_cliente_pessoa ml ON ml.cd_pessoa = p.cd_pessoa
SET p.tipo_pessoa = 'ambos';

-- =========================
-- 6. ADICIONA COLAB_RESP se não existir
-- =========================
ALTER TABLE tb_servico
ADD COLUMN IF NOT EXISTS cd_colab_resp INT NULL;

-- =========================
-- 7. CORREÇÃO DE VÍNCULOS

-- Serviços: responsável (colab)
UPDATE tb_servico s
JOIN map_colab_pessoa mc ON mc.cd_colab = s.cd_colab_resp
SET s.cd_colab_resp = mc.cd_pessoa
WHERE s.cd_colab_resp IS NOT NULL;

-- Serviços: cliente
UPDATE tb_servico s
JOIN map_cliente_pessoa ml ON ml.cd_cliente = s.cd_cliente
SET s.cd_cliente = ml.cd_pessoa
WHERE s.cd_cliente IS NOT NULL;

-- Orçamentos: cliente
UPDATE tb_orcamento_servico os
JOIN map_cliente_pessoa ml ON ml.cd_cliente = os.cd_cliente
SET os.cd_cliente = ml.cd_pessoa
WHERE os.cd_cliente IS NOT NULL;

-- Movimentos financeiros: colab
UPDATE tb_movimento_financeiro mf
JOIN map_colab_pessoa mc ON mc.cd_colab = mf.cd_colab_movimento
SET mf.cd_colab_movimento = mc.cd_pessoa
WHERE mf.cd_colab_movimento IS NOT NULL;

-- Movimentos financeiros: cliente
UPDATE tb_movimento_financeiro mf
JOIN map_cliente_pessoa ml ON ml.cd_cliente = mf.cd_cliente_movimento
SET mf.cd_cliente_movimento = ml.cd_pessoa
WHERE mf.cd_cliente_movimento IS NOT NULL;

-- Comissões: colab
-- UPDATE tb_comissao cm
-- JOIN map_colab_pessoa mc ON mc.cd_colab = cm.cd_colab
-- SET cm.cd_colab = mc.cd_pessoa
-- WHERE cm.cd_colab IS NOT NULL;

-- Contratos: contratante
-- UPDATE tb_contrato ct
-- JOIN map_cliente_pessoa ml ON ml.cd_cliente = ct.cd_contratante
-- SET ct.cd_contratante = ml.cd_pessoa
-- WHERE ct.cd_contratante IS NOT NULL;

-- =========================
-- 8. RECRIA TABELAS FINAIS
-- =========================
RENAME TABLE tb_colab TO tb_colab_old;
RENAME TABLE tb_cliente TO tb_cliente_old;

CREATE TABLE tb_colab (
    cd_colab INT PRIMARY KEY,
    CONSTRAINT fk_colab_pessoa FOREIGN KEY (cd_colab) REFERENCES tb_pessoa(cd_pessoa)
);

CREATE TABLE tb_cliente (
    cd_cliente INT PRIMARY KEY,
    CONSTRAINT fk_cliente_pessoa FOREIGN KEY (cd_cliente) REFERENCES tb_pessoa(cd_pessoa)
);

INSERT INTO tb_colab
SELECT cd_pessoa FROM tb_pessoa
WHERE tipo_pessoa IN ('colab','ambos');

INSERT INTO tb_cliente
SELECT cd_pessoa FROM tb_pessoa
WHERE tipo_pessoa IN ('cliente','ambos');

-- =========================
-- 9. VALIDAÇÕES FINAIS
-- =========================
SELECT p.* FROM tb_pessoa p
LEFT JOIN tb_colab c ON c.cd_colab = p.cd_pessoa
LEFT JOIN tb_cliente l ON l.cd_cliente = p.cd_pessoa
WHERE c.cd_colab IS NULL AND l.cd_cliente IS NULL;

SELECT s.* FROM tb_servico s
LEFT JOIN tb_pessoa p1 ON p1.cd_pessoa = s.cd_cliente
LEFT JOIN tb_pessoa p2 ON p2.cd_pessoa = s.cd_colab_resp
WHERE p1.cd_pessoa IS NULL OR p2.cd_pessoa IS NULL;

SELECT os.* FROM tb_orcamento_servico os
LEFT JOIN tb_pessoa p ON p.cd_pessoa = os.cd_cliente
WHERE p.cd_pessoa IS NULL;

SELECT mf.* FROM tb_movimento_financeiro mf
LEFT JOIN tb_pessoa p ON p.cd_pessoa = mf.cd_colab_movimento
WHERE p.cd_pessoa IS NULL;

COMMIT;

/* =========================================================
   FIM DA MIGRAÇÃO COMPLETA v2.4.0
   ========================================================= */


/*
teste final   
*/
select * from tb_pessoa where tb_pessoa.tel1_pessoa = '5521976632878';
select * from tb_cliente_old where tb_cliente_old.tel_cliente = '5521976632878';