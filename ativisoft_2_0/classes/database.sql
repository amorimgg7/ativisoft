
DROP DATABASE assistent_master;
CREATE DATABASE assistent_master;
use assistent_master;

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
    tipo_pessoa varchar(40),
    subtipo_pessoa varchar(40)
);
INSERT INTO tb_pessoa (cpf_pessoa, pnome_pessoa, snome_pessoa, email_pessoa, tipo_pessoa, senha_pessoa)
VALUES ('05185255544', 'Gabriel', 'Amorim', 'suporte@ativisoft.com.br', 'colab', 'asd,123');

CREATE TABLE tb_estilo(
    cd_estilo integer PRIMARY KEY AUTO_INCREMENT,
    titulo_estilo varchar(200),
    t_sidebar varchar(200),
    c_sidebar varchar(200),
    t_navbar varchar(200),
    c_navbar varchar(200),
    t_font varchar(200),
    c_font varchar(200)
);
INSERT INTO tb_estilo (titulo_estilo, t_sidebar,c_sidebar,t_navbar,c_navbar,t_font,c_font)
VALUES  ('Light-blue', 'padrão', 'style="background-color: #a7dbfb; color: #044167;"', 'padrão', 'style="background-color: #23a5f6;"', 'padrão', 'padrão'),
        ('Dark-blue', 'padrão', 'style="background-color: #191970; color: #8b8bbb;"', 'padrão', 'style="background-color: #2727ec;"', 'padrão', 'padrão'),
        ('Grafite', 'padrão', 'style=\"background-color: #a0a0a0; color: #fff;\"', 'padrão', 'style=\"background-color: #808080; color: #fff;\"', 'padrão', 'padrão', '', ''),
        ('Rosa-Pastel', 'padrão', 'style=\"background-color: #d88cc8; color: #000;\"', 'padrão', 'style=\"background-color: #b168a2; color: #000;\"', 'padrão', 'padrão', '', ''),
        ('Verde-Pastel', 'padrão', 'style=\"background-color: #9dbf5c; color: #000;\"', 'padrão', 'style=\"background-color: #5d7f1f; color: #000;\"', 'padrão', 'padrão', '', '');


drop table acesso_modulo;
drop table tb_acesso;





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
VALUES  ("Master", "Desenvolvimento/Suporte", "0", "999", "999", "999", "999"),
        ("Essencial", "Pacote de licença 1", "50", "111", "111", "111", "111"),
        ("Mediano", "Pacote de licença 2", "80", "222", "222", "222", "222"),
        ("Full", "Pacote de licença 3", "100", "333", "333", "333", "333"),
        ("Cliente", "Acesso ao cliente", "", "444", "333", "333", "333");


drop table acesso_modulo;
CREATE TABLE acesso_modulo (
    cd_rel INT AUTO_INCREMENT PRIMARY KEY,
    cd_acesso integer,
    ds_modulo VARCHAR(40)
);

ALTER TABLE acesso_modulo
ADD CONSTRAINT fk_acesso_modulo FOREIGN KEY (cd_acesso) REFERENCES tb_acesso (cd_acesso);



INSERT INTO acesso_modulo (cd_acesso, ds_modulo)
VALUES  (1, "Controla Caixa"),
        (1, "Assistencia"),
        (1, "Patrimônio"),
        (1, "Folha de Ponto"),
        (1, "Vendas"),
        (1, "Site"),
        (1, "PIX");


INSERT INTO acesso_modulo (cd_acesso, ds_modulo)
VALUES  (2, "Controla Caixa"),
        (2, "Assistencia"),
        (2, "Vendas");

INSERT INTO acesso_modulo (cd_acesso, ds_modulo)
VALUES  (3, "Controla Caixa"),
        (3, "Assistencia"),
        (3, "Vendas"),
        (3, "Site");

INSERT INTO acesso_modulo (cd_acesso, ds_modulo)
VALUES  (4, "Controla Caixa"),
        (4, "Assistencia"),
        (4, "Patrimônio"),
        (4, "Folha de Ponto"),
        (4, "Vendas"),
        (4, "Site"),
        (4, "PIX");

CREATE TABLE tb_empresa(
    cd_empresa integer PRIMARY KEY AUTO_INCREMENT,
    cd_matriz integer,
    cd_proprietario integer,
    tipo_empresa varchar(40),
    rsocial_empresa varchar(40),
    nfantasia_empresa varchar(40),
    cnpj_empresa varchar(40),
    iestadual_empresa varchar(40),
    imunicipal_empresa varchar(40),
    dt_abertura_empresa varchar(40),
    obs_empresa varchar(40),
    tel1_empresa varchar(40),
    obstel1_empresa varchar(40),
    tel2_empresa varchar(40),
    obstel2_empresa varchar(40),
    email_empresa varchar(40),
    endereco_empresa varchar(40),
    status_empresa varchar(40)
);

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

ALTER TABLE `rel_master` ADD CONSTRAINT `pessoas` FOREIGN KEY (`cd_pessoa`) REFERENCES `tb_pessoa`(`cd_pessoa`) ON DELETE RESTRICT ON UPDATE RESTRICT;




CREATE TABLE tb_servico(
    cd_servico integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer not null,
    cd_cliente integer,
    id_servico varchar(40),
    titulo_servico varchar(100),
    obs_servico varchar(1000),
    prioridade_servico varchar(10),
    entrada_servico varchar(40),
    prazo_servico varchar(40),
    orcamento_servico varchar(40),
    vpag_servico varchar(40),
    status_servico varchar(10)
);
ALTER TABLE tb_servico
ADD CONSTRAINT fk_rel_cliente FOREIGN KEY (cd_cliente) REFERENCES tb_pessoa (cd_pessoa);


CREATE TABLE tb_venda(
    cd_venda integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer not null,
    cd_cliente integer,
    id_venda varchar(40),
    titulo_venda varchar(100),
    abertura_venda varchar(40),
    fechamento_venda varchar(40),
    orcamento_venda varchar(40),
    vpag_venda varchar(40),
    status_venda varchar(10)
);
ALTER TABLE tb_venda
ADD CONSTRAINT fk_rel_cliente_venda FOREIGN KEY (cd_cliente) REFERENCES tb_pessoa (cd_pessoa);



CREATE TABLE tb_orcamento_servico(
    cd_orcamento integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer not null,
    cd_servico integer,
    cd_venda integer,
    cd_cliente integer,
    titulo_orcamento varchar(999),
    vcusto_orcamento varchar(40),
    vpag_orcamento varchar(40),
    vtotal_orcamento varchar(40),
    tipo_orcamento varchar(40),
    status_orcamento integer
);
ALTER TABLE tb_orcamento_servico
ADD CONSTRAINT fk_rel_orcamento1 FOREIGN KEY (cd_servico) REFERENCES tb_servico (cd_servico),
ADD CONSTRAINT fk_rel_orcamento2 FOREIGN KEY (cd_cliente) REFERENCES tb_pessoa (cd_pessoa);

CREATE TABLE tb_orcamento_venda(
    cd_orcamento integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer not null,
    cd_venda integer,
    cd_cliente integer,
    cd_produto integer,
    titulo_orcamento varchar(999),
    vcusto_orcamento varchar(40),
    vpag_orcamento varchar(40),
    qtd_orcamento varchar(40),
    vtotal_orcamento varchar(40),
    tipo_orcamento varchar(40),
    status_orcamento integer
);
ALTER TABLE tb_orcamento_venda
ADD CONSTRAINT fk_rel_orcamento_venda1 FOREIGN KEY (cd_venda) REFERENCES tb_venda (cd_venda),
ADD CONSTRAINT fk_rel_orcamento_venda2 FOREIGN KEY (cd_cliente) REFERENCES tb_pessoa (cd_pessoa),
ADD CONSTRAINT fk_rel_orcamento_venda3 FOREIGN KEY (cd_produto) REFERENCES tb_prod_serv (cd_prod_serv);


CREATE TABLE tb_atividade(
    cd_atividade integer PRIMARY KEY AUTO_INCREMENT,
    cd_servico integer,
    titulo_atividade varchar(10),
    obs_atividade varchar(1000),
    cd_colab integer,
    inicio_atividade varchar(40),
    fim_atividade varchar(40)
);

ALTER TABLE tb_atividade
ADD CONSTRAINT fk_rel_atividade1 FOREIGN KEY (cd_servico) REFERENCES tb_servico (cd_servico),
ADD CONSTRAINT fk_rel_atividade2 FOREIGN KEY (cd_colab) REFERENCES tb_pessoa (cd_pessoa);






CREATE TABLE tb_caixa(
    cd_caixa integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer NOT NULL,
    dt_abertura DATETIME NOT NULL,
    dt_fechamento DATETIME,
    cd_colab_abertura integer,
    cd_colab_fechamento integer,
    saldo_abertura decimal(10,2),
    total_movimento DECIMAL(10,2),
    saldo_fechamento DECIMAL(10,2),
    diferenca_caixa DECIMAL(10,2),
    fpag_dinheiro DECIMAL(10,2),
    fpag_debito DECIMAL(10,2),
    fpag_credito DECIMAL(10,2),
    fpag_pix DECIMAL(10,2),
    fpag_cofre DECIMAL(10,2),
    fpag_boleto DECIMAL(10,2),
    status_caixa INTEGER
);
ALTER TABLE tb_caixa
    ADD CONSTRAINT fk_tb_caixa1 FOREIGN KEY (cd_colab_abertura) REFERENCES tb_pessoa (cd_pessoa),
    ADD CONSTRAINT fk_tb_caixa2 FOREIGN KEY (cd_colab_fechamento) REFERENCES tb_pessoa (cd_pessoa);


CREATE TABLE tb_caixa_dia_fiscal(
    cd_caixa_dia_fiscal integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer NOT NULL,
    dt_abertura_dia_fiscal DATETIME NOT NULL,
    dt_fechamento_dia_fiscal DATETIME,
    movimento_analitico_dia_fiscal DECIMAL(10,2),
    movimento_conferido_dia_fiscal DECIMAL(10,2),
    total_analitico_dia_fiscal DECIMAL(10,2),
    total_conferido_dia_fiscal DECIMAL(10,2),
    diferenca_caixa_dia_fiscal DECIMAL(10,2),
    status_caixa_dia_fiscal INTEGER
);


CREATE TABLE tb_caixa_conferido(
    cd_caixa_conferido integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer NOT NULL,
    cd_caixa_analitico integer,
    dt_conferencia DATETIME,
    cd_colab_conferencia integer,
    obs_conferencia varchar(999),
    saldo_abertura_conferido DECIMAL(10,2),
    saldo_fechamento_conferido DECIMAL(10,2),
    diferenca_caixa_conferido DECIMAL(10,2),
    saldo_movimento_conferido DECIMAL(10,2),
    fpag_dinheiro_conferido DECIMAL(10,2),
    fpag_debito_conferido DECIMAL(10,2),
    fpag_credito_conferido DECIMAL(10,2),
    fpag_pix_conferido DECIMAL(10,2),
    fpag_cofre_conferido DECIMAL(10,2),
    fpag_boleto_conferido DECIMAL(10,2)
);
ALTER TABLE tb_caixa_conferido
    ADD CONSTRAINT fk_tb_caixa_conferido1 FOREIGN KEY (cd_caixa_analitico) REFERENCES tb_caixa (cd_caixa),
    ADD CONSTRAINT fk_tb_caixa_conferido2 FOREIGN KEY (cd_colab_conferencia) REFERENCES tb_pessoa (cd_pessoa);


create table tb_movimento_financeiro(
    cd_movimento integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer NOT NULL,
    cd_caixa_movimento integer,
    cd_colab_movimento integer,
    cd_cliente_movimento integer,
    tipo_movimento integer,
    cd_os_movimento integer,
    cd_venda_movimento integer,
    fpag_movimento varchar(999),
    valor_movimento DECIMAL(10,2),
    data_movimento DATETIME,
    obs_movimento varchar(999)
);
ALTER TABLE tb_movimento_financeiro
    ADD CONSTRAINT fk_tb_movimento_financeiro1 FOREIGN KEY(cd_caixa_movimento) REFERENCES tb_caixa (cd_caixa),
    ADD CONSTRAINT fk_tb_movimento_financeiro2 FOREIGN KEY(cd_colab_movimento) REFERENCES tb_pessoa (cd_pessoa),
    ADD CONSTRAINT fk_tb_movimento_financeiro3 FOREIGN KEY(cd_cliente_movimento) REFERENCES tb_pessoa (cd_pessoa),
    ADD CONSTRAINT fk_tb_movimento_financeiro4 FOREIGN KEY(cd_os_movimento) REFERENCES tb_servico (cd_servico),
    ADD CONSTRAINT fk_tb_movimento_financeiro5 FOREIGN KEY(cd_cliente_comercial) REFERENCES tb_empresa (cd_empresa);

                                          



create table tb_grupo(
    cd_grupo integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer NOT NULL,
    titulo_grupo varchar(40),
    obs_grupo varchar(999)
);


create table tb_classe_fiscal(
    cd_classe_fiscal integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer NOT NULL,
    titulo_classe_fiscal varchar(100),
    obs_classe_fiscal varchar(100),
    ncm_classe_fiscal integer,
    csosn_classe_fiscal integer,
    cst_classe_fiscal integer
);


create table tb_prod_serv(
    cd_prod_serv integer PRIMARY KEY AUTO_INCREMENT,
    cd_empresa integer,
    cd_filial integer,
    cd_classe_fiscal integer,
    cd_grupo integer,
    cdbarras_prod_serv varchar(999),
    titulo_prod_serv varchar(100),
    obs_prod_serv varchar(999),
    tipo_prod_serv integer,
    preco_prod_serv DECIMAL(10,2),
    custo_prod_serv DECIMAL(10,2),
    estoque_prod_serv integer,
    status_prod_serv integer
);

ALTER TABLE tb_prod_serv
    ADD CONSTRAINT fk_tb_prod_serv1 FOREIGN KEY(cd_classe_fiscal) REFERENCES tb_classe_fiscal (cd_classe_fiscal),
    ADD CONSTRAINT fk_tb_prod_serv2 FOREIGN KEY(cd_grupo) REFERENCES tb_grupo (cd_grupo);

 

CREATE TABLE tb_reserva (
  cd_reserva int PRIMARY KEY AUTO_INCREMENT,
  cd_empresa integer not null,
  cd_cliente int(11) DEFAULT NULL,
  cd_servico int(11) DEFAULT NULL,
  cd_orcamento int(11) DEFAULT NULL,
  cd_venda int(11) DEFAULT NULL,
  cd_prod_serv int(11) DEFAULT NULL,
  qtd_reservado int(11) DEFAULT NULL,
  qtd_efetivado int(11) DEFAULT NULL,
  dt_reservado varchar(40) DEFAULT NULL,
  dt_efetivado varchar(40) DEFAULT NULL
);



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



INSERT INTO tb_contrato (cd_contrato, cd_empresa, cd_acesso, cd_contratante, dt_contrato, dt_validade, vl_contrato, ds_contrato)
VALUES  (1, 11, 1, 1, '', '', 200, 'teste');




-- daqui para baixo, mudançaas a partir do mes 9

create table tb_comissao(
    cd_comissao integer PRIMARY KEY AUTO_INCREMENT,
    cd_filial integer,
    cd_colab integer,
    cd_servico integer,
    cd_venda integer,
    vl_comissao decimal(10,2),
    obs_comissao varchar(100),
    status_comissao integer
);

ALTER TABLE tb_comissao
    ADD CONSTRAINT fk_tb_comissao1 FOREIGN KEY(cd_servico) REFERENCES tb_servico (cd_servico),
    ADD CONSTRAINT fk_tb_comissao2 FOREIGN KEY(cd_venda) REFERENCES tb_venda (cd_venda),
    ADD CONSTRAINT fk_tb_comissao3 FOREIGN KEY(cd_colab) REFERENCES tb_pessoa (cd_pessoa);


INSERT INTO tb_comissao (cd_colab, cd_filial, cd_servico, vl_comissao, status_comissao)
VALUES  (21, 11, 33, 5, 0);


ALTER TABLE `tb_pessoa` ADD `cd_empresa` INT NULL DEFAULT NULL AFTER `subtipo_pessoa`;
ALTER TABLE `tb_pessoa` ADD `cd_filial` INT NULL DEFAULT NULL AFTER `cd_empresa`;
ALTER TABLE `tb_pessoa` ADD `vl_comissao_padrao` decimal(10,2) NULL DEFAULT NULL AFTER `subtipo_pessoa`;
ALTER TABLE `tb_pessoa` ADD `pc_comissao_padrao` decimal(10,2) NULL DEFAULT NULL AFTER `vl_comissao_padrao`;

ALTER TABLE tb_pessoa
    ADD CONSTRAINT fk_tb_pessoa1 FOREIGN KEY(cd_empresa) REFERENCES tb_empresa (cd_empresa),
    ADD CONSTRAINT fk_tb_pessoa2 FOREIGN KEY(cd_filial) REFERENCES tb_empresa (cd_empresa);

ALTER TABLE `tb_servico` ADD `cd_colab_resp` INT NULL DEFAULT NULL AFTER `cd_cliente`;
ALTER TABLE `tb_servico` ADD `vl_comissao` decimal(10,2) NULL DEFAULT NULL AFTER `cd_colab_resp`;
ALTER TABLE `tb_servico` ADD `pc_comissao` decimal(10,2) NULL DEFAULT NULL AFTER `vl_comissao`;
ALTER TABLE tb_servico
    ADD CONSTRAINT fk_tb_servico2 FOREIGN KEY(cd_colab_resp) REFERENCES tb_pessoa (cd_pessoa);



ALTER TABLE `tb_pessoa` ADD `status_pessoa` INT NULL DEFAULT 1 AFTER `cd_filial`;

