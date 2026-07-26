
create database marcial_1_0;

use marcial_1_0;
SET NAMES utf8mb4;


-- ===============================
-- EMPRESA (SaaS)
-- ===============================
CREATE TABLE tb_empresa (
  cd_empresa INT AUTO_INCREMENT PRIMARY KEY,
  nome_empresa VARCHAR(100),
  cnpj VARCHAR(20),
  email VARCHAR(100),
  telefone VARCHAR(40),
  dt_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================
-- PESSOA
-- ===============================
CREATE TABLE tb_pessoa (
  cd_pessoa INT AUTO_INCREMENT PRIMARY KEY,
  pnome_pessoa VARCHAR(80),
  snome_pessoa VARCHAR(80),
  sexo_pessoa VARCHAR(20),
  cpf_pessoa VARCHAR(20),
  dt_nasc_pessoa DATE,
  tel_pessoa VARCHAR(40),
  email_pessoa VARCHAR(80),
  senha_pessoa VARCHAR(255),


  perfil ENUM('ADMIN','INSTRUTOR','ALUNO'),
  ativo TINYINT DEFAULT 1,

  dt_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
  dt_primeiro_login DATETIME,
  dt_ultimo_login DATETIME,

  UNIQUE KEY uk_cpf (cpf_pessoa),
  UNIQUE KEY uk_email (email_pessoa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ALTER TABLE `tb_pessoa` ADD `perfil` ENUM('ADMIN','INSTRUTOR','ALUNO') NOT NULL AFTER `dt_ultimo_login`;
-- ALTER TABLE tb_pessoa ADD ativo TINYINT DEFAULT 1 NOT NULL AFTER `dt_ultimo_login`
-- ===============================
-- USUÁRIO (LOGIN)
-- ===============================
CREATE TABLE tb_usuario (
  cd_usuario INT AUTO_INCREMENT PRIMARY KEY,
  cd_pessoa INT,
  login VARCHAR(100) UNIQUE,
  senha VARCHAR(255),
  perfil ENUM('ADMIN','INSTRUTOR','ALUNO'),
  ativo TINYINT DEFAULT 1,

  FOREIGN KEY (cd_pessoa) REFERENCES tb_pessoa(cd_pessoa)
) ENGINE=InnoDB;

-- ===============================
-- LOG DE ACESSO
-- ===============================
CREATE TABLE tb_log_acesso (
  cd_log INT AUTO_INCREMENT PRIMARY KEY,
  cd_usuario INT,
  data_acesso DATETIME DEFAULT CURRENT_TIMESTAMP,
  ip VARCHAR(50),

  FOREIGN KEY (cd_usuario) REFERENCES tb_usuario(cd_usuario)
) ENGINE=InnoDB;

-- ===============================
-- ARTE MARCIAL
-- ===============================
CREATE TABLE tb_arte_marcial (
  cd_arte_marcial INT AUTO_INCREMENT PRIMARY KEY,
  nome_arte VARCHAR(100),
  sigla VARCHAR(20),
  descricao VARCHAR(255)
) ENGINE=InnoDB;

-- ===============================
-- CENTRO DE TREINAMENTO
-- ===============================
CREATE TABLE tb_ct_marcial (
  cd_ct_marcial INT AUTO_INCREMENT PRIMARY KEY,
  cd_empresa INT,
  nome_ct VARCHAR(100),
  endereco VARCHAR(255),
  cidade VARCHAR(100),
  estado VARCHAR(50),
  pais VARCHAR(50),
  dt_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (cd_empresa) REFERENCES tb_empresa(cd_empresa)
) ENGINE=InnoDB;

-- ===============================
-- VÍNCULO (CORE DO SISTEMA)
-- ===============================
CREATE TABLE tb_vinculo (
  cd_vinculo INT AUTO_INCREMENT PRIMARY KEY,

  cd_pessoa INT NOT NULL,
  cd_arte_marcial INT NOT NULL,
  cd_ct_marcial INT NOT NULL,

  tipo_vinculo ENUM('ALUNO','INSTRUTOR','ATLETA'),

  dt_inicio DATETIME,
  dt_fim DATETIME,
  ativo TINYINT DEFAULT 1,

  FOREIGN KEY (cd_pessoa) REFERENCES tb_pessoa(cd_pessoa),
  FOREIGN KEY (cd_arte_marcial) REFERENCES tb_arte_marcial(cd_arte_marcial),
  FOREIGN KEY (cd_ct_marcial) REFERENCES tb_ct_marcial(cd_ct_marcial),

  INDEX (cd_pessoa),
  INDEX (cd_arte_marcial),
  INDEX (cd_ct_marcial)
) ENGINE=InnoDB;

-- ===============================
-- PROFESSOR TITULAR
-- ===============================
CREATE TABLE tb_professor_titular (
  cd_professor_titular INT AUTO_INCREMENT PRIMARY KEY,
  cd_vinculo INT,
  dt_inicio DATETIME,
  ativo TINYINT DEFAULT 1,

  FOREIGN KEY (cd_vinculo) REFERENCES tb_vinculo(cd_vinculo)
) ENGINE=InnoDB;

-- ===============================
-- GRADUAÇÃO
-- ===============================
CREATE TABLE tb_graduacao (
  cd_graduacao INT AUTO_INCREMENT PRIMARY KEY,
  cd_arte_marcial INT,
  nome_graduacao VARCHAR(50),
  ordem INT,
  cor VARCHAR(30),

  FOREIGN KEY (cd_arte_marcial) REFERENCES tb_arte_marcial(cd_arte_marcial)
) ENGINE=InnoDB;

-- ===============================
-- HISTÓRICO DE GRADUAÇÃO
-- ===============================
CREATE TABLE tb_aluno_graduacao (
  cd_aluno_graduacao INT AUTO_INCREMENT PRIMARY KEY,
  cd_vinculo INT,
  cd_graduacao INT,
  dt_conquista DATETIME,

  FOREIGN KEY (cd_vinculo) REFERENCES tb_vinculo(cd_vinculo),
  FOREIGN KEY (cd_graduacao) REFERENCES tb_graduacao(cd_graduacao)
) ENGINE=InnoDB;

-- ===============================
-- EXAME DE FAIXA
-- ===============================
CREATE TABLE tb_exame_graduacao (
  cd_exame INT AUTO_INCREMENT PRIMARY KEY,
  cd_arte_marcial INT,
  cd_ct_marcial INT,
  data_exame DATETIME,
  descricao VARCHAR(255),

  FOREIGN KEY (cd_arte_marcial) REFERENCES tb_arte_marcial(cd_arte_marcial),
  FOREIGN KEY (cd_ct_marcial) REFERENCES tb_ct_marcial(cd_ct_marcial)
) ENGINE=InnoDB;

-- ===============================
-- PARTICIPANTES DO EXAME
-- ===============================
CREATE TABLE tb_exame_participante (
  cd_exame_participante INT AUTO_INCREMENT PRIMARY KEY,
  cd_exame INT,
  cd_vinculo INT,
  cd_graduacao_destino INT,
  resultado ENUM('APROVADO','REPROVADO','PENDENTE'),
  observacao VARCHAR(255),

  FOREIGN KEY (cd_exame) REFERENCES tb_exame_graduacao(cd_exame),
  FOREIGN KEY (cd_vinculo) REFERENCES tb_vinculo(cd_vinculo),
  FOREIGN KEY (cd_graduacao_destino) REFERENCES tb_graduacao(cd_graduacao)
) ENGINE=InnoDB;

-- ===============================
-- AVALIADORES DO EXAME
-- ===============================
CREATE TABLE tb_exame_avaliador (
  cd_exame_avaliador INT AUTO_INCREMENT PRIMARY KEY,
  cd_exame INT,
  cd_pessoa INT,
  funcao VARCHAR(50),

  FOREIGN KEY (cd_exame) REFERENCES tb_exame_graduacao(cd_exame),
  FOREIGN KEY (cd_pessoa) REFERENCES tb_pessoa(cd_pessoa)
) ENGINE=InnoDB;

-- ===============================
-- TREINOS
-- ===============================
CREATE TABLE tb_treino (
  cd_treino INT AUTO_INCREMENT PRIMARY KEY,
  cd_ct_marcial INT,
  cd_arte_marcial INT,
  data_treino DATETIME,
  descricao VARCHAR(255),

  FOREIGN KEY (cd_ct_marcial) REFERENCES tb_ct_marcial(cd_ct_marcial),
  FOREIGN KEY (cd_arte_marcial) REFERENCES tb_arte_marcial(cd_arte_marcial)
) ENGINE=InnoDB;

-- ===============================
-- PRESENÇA
-- ===============================
CREATE TABLE tb_treino_presenca (
  cd_presenca INT AUTO_INCREMENT PRIMARY KEY,
  cd_treino INT,
  cd_vinculo INT,

  FOREIGN KEY (cd_treino) REFERENCES tb_treino(cd_treino),
  FOREIGN KEY (cd_vinculo) REFERENCES tb_vinculo(cd_vinculo)
) ENGINE=InnoDB;

-- ===============================
-- COMPETIÇÃO
-- ===============================
CREATE TABLE tb_competicao (
  cd_competicao INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  local VARCHAR(100),
  data_inicio DATETIME,
  data_fim DATETIME
) ENGINE=InnoDB;

-- ===============================
-- CATEGORIA COMPETIÇÃO
-- ===============================
CREATE TABLE tb_categoria_competicao (
  cd_categoria INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  idade_min INT,
  idade_max INT,
  peso_min DECIMAL(5,2),
  peso_max DECIMAL(5,2),
  sexo VARCHAR(20)
) ENGINE=InnoDB;

-- ===============================
-- PARTICIPANTES COMPETIÇÃO
-- ===============================
CREATE TABLE tb_competicao_participante (
  cd_participacao INT AUTO_INCREMENT PRIMARY KEY,
  cd_competicao INT,
  cd_vinculo INT,
  cd_categoria INT,
  resultado VARCHAR(50),

  FOREIGN KEY (cd_competicao) REFERENCES tb_competicao(cd_competicao),
  FOREIGN KEY (cd_vinculo) REFERENCES tb_vinculo(cd_vinculo),
  FOREIGN KEY (cd_categoria) REFERENCES tb_categoria_competicao(cd_categoria)
) ENGINE=InnoDB;

-- ===============================
-- CURSOS
-- ===============================
CREATE TABLE tb_curso (
  cd_curso INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  descricao VARCHAR(255),
  carga_horaria INT,
  cd_arte_marcial INT,

  FOREIGN KEY (cd_arte_marcial) REFERENCES tb_arte_marcial(cd_arte_marcial)
) ENGINE=InnoDB;

-- ===============================
-- TURMAS
-- ===============================
CREATE TABLE tb_curso_turma (
  cd_turma INT AUTO_INCREMENT PRIMARY KEY,
  cd_curso INT,
  cd_ct_marcial INT,
  data_inicio DATETIME,
  data_fim DATETIME,

  FOREIGN KEY (cd_curso) REFERENCES tb_curso(cd_curso),
  FOREIGN KEY (cd_ct_marcial) REFERENCES tb_ct_marcial(cd_ct_marcial)
) ENGINE=InnoDB;

-- ===============================
-- INSTRUTORES CURSO
-- ===============================
CREATE TABLE tb_curso_instrutor (
  cd_instrutor INT AUTO_INCREMENT PRIMARY KEY,
  cd_turma INT,
  cd_pessoa INT,

  FOREIGN KEY (cd_turma) REFERENCES tb_curso_turma(cd_turma),
  FOREIGN KEY (cd_pessoa) REFERENCES tb_pessoa(cd_pessoa)
) ENGINE=InnoDB;

-- ===============================
-- ALUNOS CURSO
-- ===============================
CREATE TABLE tb_curso_aluno (
  cd_curso_aluno INT AUTO_INCREMENT PRIMARY KEY,
  cd_turma INT,
  cd_vinculo INT,
  status ENUM('CURSANDO','CONCLUIDO','REPROVADO'),

  FOREIGN KEY (cd_turma) REFERENCES tb_curso_turma(cd_turma),
  FOREIGN KEY (cd_vinculo) REFERENCES tb_vinculo(cd_vinculo)
) ENGINE=InnoDB;

-- ===============================
-- CERTIFICADOS
-- ===============================
CREATE TABLE tb_certificado (
  cd_certificado INT AUTO_INCREMENT PRIMARY KEY,
  cd_curso_aluno INT,
  data_emissao DATETIME,
  codigo_validacao VARCHAR(100),

  FOREIGN KEY (cd_curso_aluno) REFERENCES tb_curso_aluno(cd_curso_aluno)
) ENGINE=InnoDB;

-- ===============================
-- PLANOS
-- ===============================
CREATE TABLE tb_plano (
  cd_plano INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  valor DECIMAL(10,2),
  descricao VARCHAR(255),
  ativo TINYINT DEFAULT 1
) ENGINE=InnoDB;

-- ===============================
-- MATRÍCULA
-- ===============================
CREATE TABLE tb_matricula (
  cd_matricula INT AUTO_INCREMENT PRIMARY KEY,
  cd_vinculo INT,
  cd_plano INT,
  data_inicio DATETIME,
  data_fim DATETIME,
  status ENUM('ATIVO','INATIVO','CANCELADO'),

  FOREIGN KEY (cd_vinculo) REFERENCES tb_vinculo(cd_vinculo),
  FOREIGN KEY (cd_plano) REFERENCES tb_plano(cd_plano)
) ENGINE=InnoDB;

-- ===============================
-- PAGAMENTO
-- ===============================
CREATE TABLE tb_pagamento (
  cd_pagamento INT AUTO_INCREMENT PRIMARY KEY,
  cd_matricula INT,
  valor DECIMAL(10,2),
  data_pagamento DATETIME,
  status ENUM('PAGO','PENDENTE','ATRASADO'),
  metodo VARCHAR(50),

  FOREIGN KEY (cd_matricula) REFERENCES tb_matricula(cd_matricula)
) ENGINE=InnoDB;

-- ===============================
-- ARQUIVOS
-- ===============================
CREATE TABLE tb_arquivo (
  cd_arquivo INT AUTO_INCREMENT PRIMARY KEY,
  cd_pessoa INT,
  nome_arquivo VARCHAR(255),
  caminho VARCHAR(255),
  tipo VARCHAR(50),
  data_upload DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (cd_pessoa) REFERENCES tb_pessoa(cd_pessoa)
) ENGINE=InnoDB;

-- ===============================
-- LOG DO SISTEMA
-- ===============================
CREATE TABLE tb_log_sistema (
  cd_log INT AUTO_INCREMENT PRIMARY KEY,
  tabela VARCHAR(100),
  acao VARCHAR(50),
  cd_registro INT,
  cd_usuario INT,
  data_log DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (cd_usuario) REFERENCES tb_usuario(cd_usuario)
) ENGINE=InnoDB;