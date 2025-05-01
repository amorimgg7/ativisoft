
DROP DATABASE erp_123;
CREATE DATABASE erp_ativisoft;
use erp_ativisoft;

CREATE TABLE tb_pessoa(
    cd_pessoa integer PRIMARY KEY AUTO_INCREMENT,
    pnome_pessoa varchar(40),
    snome_pessoa varchar(40),
    cpf_pessoa varchar(40),
    dtnasc_pessoa varchar(40),
    obs_pessoa VARCHAR(40),
    tel1_pessoa
    obstel1_pessoa VARCHAR(40),
    tel2_pessoa
    obstel2_pessoa VARCHAR(40),
    email_pessoa VARCHAR(40),
    senha_pessoa VARCHAR(40),
    tipo_pessoa VARCHAR(40),
    subtipo_pessoa VARCHAR(40)
);
INSERT INTO tb_colab (cpf_colab, pnome_colab, email_colab, senha_colab)
VALUES ('1', 'erp-Nuvemsoft', 'suporte@erp-nuvemsoft.com.br', '1');

CREATE TABLE tb_empresa(
    cd_empresa integer PRIMARY KEY AUTO_INCREMENT,
    rsocial_empresa varchar(40),
    nfantasia_empresa varchar(40),
    cnpj_empresa integer,
    cd_ceo integer,
    chave_auth varchar(1000)
);
INSERT INTO tb_empresa (rsocial_empresa, nfantasia_empresa, cnpj_empresa, cd_ceo, chave_auth)
VALUES ('MARIA DA LUZ GOMES DA SILVA', 'MODA E ARTES', '34798614000182', 1, 'AUTH');
ALTER TABLE tb_empresa
ADD CONSTRAINT fk_rel_empresa1 FOREIGN KEY (cd_ceo) REFERENCES tb_colab (cd_colab);

DROP TABLE tb_filial;
CREATE TABLE tb_filial(
    cd_filial integer PRIMARY KEY AUTO_INCREMENT,
    cd_empresa integer,
    cd_responsavel integer,
    rsocial_filial varchar(999),
    nfantasia_filial varchar(999),
    cnpj_filial varchar(40),
    endereco_filial varchar(999),
    saudacoes_filial varchar(999)
);

ALTER TABLE tb_filial
ADD CONSTRAINT fk_rel_filial1 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa (cd_empresa),
ADD CONSTRAINT fk_rel_filial2 FOREIGN KEY (cd_responsavel) REFERENCES tb_colab (cd_colab);

INSERT INTO tb_filial (cd_empresa, cd_responsavel, rsocial_filial, nfantasia_filial, cnpj_filial, endereco_filial, saudacoes_filial)
VALUES (1, 1, 'MARIA DA LUZ GOMES DA SILVA', 'MODA & ARTES', '34798614000182', 'Rua João Bruno Lobo 291A Casa 1, Curicica', 'Prezado cliente, prazo de reclamação do serviço é de até 15 dias da data de entrega. Após confirmado conclusão do servico, retirada é de até 60 dias.');


CREATE TABLE tb_cliente(
    cd_cliente integer PRIMARY KEY AUTO_INCREMENT,
    pnome_cliente varchar(40),
    snome_cliente varchar(40),
    cpf_cliente varchar(40),
    dtnasc_cliente varchar(40),
    sexo_cliente varchar(40),
    obs_cliente varchar(40),
    tel_cliente varchar(40),
    obs_tel_cliente varchar(40),
    email_cliente varchar(40),
    foto_cliente varchar(1000),
    senha_cliente varchar(40)
);






CREATE TABLE tb_servico(
    cd_servico integer PRIMARY KEY AUTO_INCREMENT,
    cd_cliente integer,
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
ADD CONSTRAINT fk_rel_cliente FOREIGN KEY (cd_cliente) REFERENCES tb_cliente (cd_cliente);

CREATE TABLE tb_orcamento_servico(
    cd_orcamento integer PRIMARY KEY AUTO_INCREMENT,
    cd_servico integer,
    cd_venda integer,
    cd_cliente integer,
    titulo_orcamento varchar(999),
    vcusto_orcamento varchar(40),
    vpag_orcamento varchar(40),
    status_orcamento integer
);
ALTER TABLE tb_orcamento_servico
ADD CONSTRAINT fk_rel_orcamento1 FOREIGN KEY (cd_servico) REFERENCES tb_servico (cd_servico),
ADD CONSTRAINT fk_rel_orcamento2 FOREIGN KEY (cd_venda) REFERENCES tb_venda (cd_venda),
ADD CONSTRAINT fk_rel_orcamento3 FOREIGN KEY (cd_cliente) REFERENCES tb_cliente (cd_cliente);



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
ADD CONSTRAINT fk_rel_colab1 FOREIGN KEY (cd_servico) REFERENCES tb_servico (cd_servico),
ADD CONSTRAINT fk_rel_colab2 FOREIGN KEY (cd_colab) REFERENCES tb_colab (cd_colab);



CREATE TABLE tb_estilo(
    cd_estilo integer PRIMARY KEY AUTO_INCREMENT,
    titulo_estilo varchar(40),	
    t_sidebar varchar(200),
    c_sidebar varchar(200),
    t_navbar varchar(200),
    c_navbar varchar(200),
    t_font varchar(200),
	c_font varchar(200),
    t_font varchar(200),
	c_body varchar(200)
);
INSERT INTO tb_estilo (titulo_estilo, t_sidebar,c_sidebar,t_navbar,c_navbar,t_font,c_font)
VALUES ('Light-blue', 'padrão', 'style="background-color: #a7dbfb; color: #044167;"', 'padrão', 'style="background-color: #23a5f6;"', 'padrão', 'padrão');

INSERT INTO tb_estilo (titulo_estilo, t_sidebar,c_sidebar,t_navbar,c_navbar,t_font,c_font)
VALUES ('Dark-blue', 'padrão', 'style="background-color: #191970; color: #8b8bbb;"', 'padrão', 'style="background-color: #2727ec;"', 'padrão', 'padrão');







CREATE TABLE tb_seguranca(
    cd_seg integer PRIMARY KEY AUTO_INCREMENT,	
    titulo_seg varchar(200),
    obs_seg varchar(40),
    cd_colab varchar(40),
	empresa varchar(40)
);

INSERT INTO tb_seguranca (titulo_seg,obs_seg, cd_colab, empresa)
VALUES ('master', 'User Master', '1', '1');


CREATE TABLE tb_funcao(
    cd_funcao integer PRIMARY KEY AUTO_INCREMENT,	
    titulo_funcao varchar(200),
    obs_funcao varchar(200),
    md_patrimonio varchar(200),
    md_fponto varchar(200),
	md_assistencia varchar(200),
    md_cliente varchar(200),
    md_fornecedor varchar(200),
    md_clientefornecedor varchar(200)
);
INSERT INTO tb_funcao (titulo_funcao, obs_funcao, md_patrimonio, md_fponto, md_assistencia, md_cliente, md_fornecedor, md_clientefornecedor)
VALUES('MASTER', 'observações', 'style="display: block;"', 'style="display: block;"', 'style="display: block;"', 'style="display: block;"', 'style="display: block;"', 'style="display: block;"'),

('Cliente', 'observações', 'style="display: none;"', 'style="display: none;"', 'style="display: none;"', 'style="display: block;"', 'style="display: none;"', 'style="display: none;"'),

('Fornecedor', 'observações', 'style="display: none;"', 'style="display: none;"', 'style="display: none;"', 'style="display: none;"', 'style="display: block;"', 'style="display: none;"'),

('Cliente / Fornecedor', 'observações', 'style="display: none;"', 'style="display: none;"', 'style="display: none;"', 'style="display: none;"', 'style="display: none;"', 'style="display: block;"'),

('Assistente', 'observações', 'style="display: block;"', 'style="display: block;"', 'style="display: block;"', 'style="display: none;"', 'style="display: none;"', 'style="display: none;"');




CREATE TABLE rel_user(
    token_alter integer PRIMARY KEY AUTO_INCREMENT,
    cd_seg integer,
    cd_colab integer,
    cd_estilo integer,
    cd_funcao integer,
    cd_empresa integer,
    cd_status integer
);
ALTER TABLE rel_user
ADD CONSTRAINT fk_rel_user1 FOREIGN KEY (cd_seg) REFERENCES tb_seguranca (cd_seg),
ADD CONSTRAINT fk_rel_user2 FOREIGN KEY (cd_colab) REFERENCES tb_colab (cd_colab),
ADD CONSTRAINT fk_rel_user3 FOREIGN KEY (cd_estilo) REFERENCES tb_estilo (cd_estilo),
ADD CONSTRAINT fk_rel_user4 FOREIGN KEY (cd_funcao) REFERENCES tb_funcao (cd_funcao),
ADD CONSTRAINT fk_rel_user5 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa (cd_empresa);


INSERT INTO rel_user (cd_seg,cd_colab,cd_estilo, cd_empresa, cd_funcao, cd_status)
VALUES ('1', '1', '1', '1', '1', '1');


CREATE TABLE rel_master (
    token_alter integer PRIMARY KEY AUTO_INCREMENT,
    cd_pessoa integer,
    cd_empresa integer,
    cd_seg integer,
    cd_funcao integer,
    cd_estilo integer,
    cd_status integer
);
ALTER TABLE rel_user
ADD CONSTRAINT fk_rel_user1 FOREIGN KEY (cd_pessoa) REFERENCES tb_pessoa (cd_pessoa),
ADD CONSTRAINT fk_rel_user2 FOREIGN KEY (cd_colab) REFERENCES tb_colab (cd_colab),
ADD CONSTRAINT fk_rel_user3 FOREIGN KEY (cd_estilo) REFERENCES tb_estilo (cd_estilo),
ADD CONSTRAINT fk_rel_user4 FOREIGN KEY (cd_funcao) REFERENCES tb_funcao (cd_funcao),
ADD CONSTRAINT fk_rel_user5 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa (cd_empresa);


INSERT INTO rel_user (cd_seg,cd_colab,cd_estilo, cd_empresa, cd_funcao, cd_status)
VALUES ('1', '1', '1', '1', '1', '1');





CREATE TABLE fl_ponto(
    token_alter integer PRIMARY KEY AUTO_INCREMENT,
    cdcolab_ponto integer,
    cdempresa_ponto integer,
    pais_ponto varchar(40),
    estado_ponto varchar(40),
    cidade_ponto varchar(40),
    bairro_ponto varchar(40),
    data_ponto varchar(40),
    hora_ponto varchar(40)
    
);
ALTER TABLE fl_ponto
ADD CONSTRAINT fk_fl_ponto1 FOREIGN KEY (cdcolab_ponto) REFERENCES tb_colab (cd_colab),
ADD CONSTRAINT fk_fl_ponto2 FOREIGN KEY (cdempresa_ponto) REFERENCES tb_empresa (cd_empresa);



CREATE TABLE tb_caixa(
    cd_caixa integer PRIMARY KEY AUTO_INCREMENT,
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
    ADD CONSTRAINT fk_tb_caixa1 FOREIGN KEY (cd_colab_abertura) REFERENCES tb_colab (cd_colab),
    ADD CONSTRAINT fk_tb_caixa2 FOREIGN KEY (cd_colab_fechamento) REFERENCES tb_colab (cd_colab);

ALTER TABLE tb_caixa
    ADD fpag_cofre DECIMAL(10,2) AFTER fpag_pix;
ALTER TABLE tb_caixa_conferido
    ADD fpag_cofre_conferido DECIMAL(10,2) AFTER fpag_pix_conferido;

CREATE TABLE tb_caixa_dia_fiscal(
    cd_caixa_dia_fiscal integer PRIMARY KEY AUTO_INCREMENT,
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
    ADD CONSTRAINT fk_tb_caixa_conferido2 FOREIGN KEY (cd_colab_conferencia) REFERENCES tb_colab (cd_colab);


create table tb_movimento_financeiro(
    cd_movimento integer PRIMARY KEY AUTO_INCREMENT,
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
    ADD CONSTRAINT fk_tb_movimento_financeiro2 FOREIGN KEY(cd_colab_movimento) REFERENCES tb_colab (cd_colab),
    ADD CONSTRAINT fk_tb_movimento_financeiro3 FOREIGN KEY(cd_cliente_movimento) REFERENCES tb_cliente (cd_cliente),
    ADD CONSTRAINT fk_tb_movimento_financeiro4 FOREIGN KEY(cd_os_movimento) REFERENCES tb_servico (cd_serico);

insert into tb_caixa(dt_abertura, cd_colab_abertura, saldo_abertura, status_caixa) VALUES('2023-08-12T13:00','1','10','0');
insert into tb_caixa_dia_fiscal(dt_abertura_dia_fiscal, status_caixa_dia_fiscal) VALUES('2023-08-12T13:00','0');
insert into tb_movimento_financeiro(cd_caixa_movimento, cd_colab_movimento, cd_cliente_movimento, tipo_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES('10','1','3','1', 'PIX', '35', '2023-08-16 01:21:00', 'Cliente pagou'),
('1','1','3','1', 'DINHEIRO', '40', '2023-08-16 01:21:00', 'Cliente pagou'),
('1','1','10','1', 'DEBITO', '20', '2023-08-16 01:21:00', 'Cliente pagou'),
('1','1','11','1', 'CREDITO', '23', '2023-08-16 01:21:00', 'Cliente pagou'),
('1','1','12','1', 'PIX', '53', '2023-08-16 01:21:00', 'Cliente pagou'),
('1','1','13','1', 'CREDITO', '150', '2023-08-16 01:21:00', 'Cliente pagou'),
('1','1','14','1', 'DINHEIRO', '230', '2023-08-16 01:21:00', 'Cliente pagou'),
('1','1','15','1', 'COFRE', '61', '2023-08-16 01:21:00', 'Cliente pagou');                                            



create table tb_grupo(
    cd_grupo integer PRIMARY KEY AUTO_INCREMENT,
    titulo_grupo varchar(40),
    obs_grupo varchar(999)
);
insert into tb_grupo(titulo_grupo, obs_grupo) 
    VALUES('Grupo 1','Grupo destinado as primeiras coisas'),
    ('Grupo 2','Grupo destinado as segundas coisas'),
    ('Grupo 3','Grupo destinado as terceiras coisas');

create table tb_classe_fiscal(
    cd_classe_fiscal integer PRIMARY KEY AUTO_INCREMENT,
    titulo_classe_fiscal varchar(100),
    obs_classe_fiscal varchar(100),
    ncm_classe_fiscal integer,
    csosn_classe_fiscal integer,
    cst_classe_fiscal integer
);
insert into tb_classe_fiscal(titulo_classe_fiscal, obs_classe_fiscal, ncm_classe_fiscal, csosn_classe_fiscal, cst_classe_fiscal) 
    VALUES('Classe Geral','Classe fiscal para coisas em geral', '00000000', '105', '500');

create table tb_prod_serv(
    cd_prod_serv integer PRIMARY KEY AUTO_INCREMENT,
    cd_classe_fiscal integer,
    cd_grupo integer,
    cdbarras_prod_serv varchar(999),
    titulo_prod_serv varchar(100),
    obs_prod_serv varchar(999),
    tipo_prod_serv integer,
    preco_prod_serv DECIMAL(10,2),
    custo_prod_serv DECIMAL(10,2),
    status_prod_serv integer
);

ALTER TABLE tb_prod_serv
    ADD CONSTRAINT fk_tb_prod_serv1 FOREIGN KEY(cd_classe_fiscal) REFERENCES tb_classe_fiscal (cd_classe_fiscal),
    ADD CONSTRAINT fk_tb_prod_serv2 FOREIGN KEY(cd_grupo) REFERENCES tb_grupo (cd_grupo);
insert into tb_prod_serv(cd_classe_fiscal, cd_grupo, cdbarras_prod_serv, titulo_prod_serv, obs_prod_serv, tipo_prod_serv, preco_prod_serv, custo_prod_serv) 
    VALUES(1,1,'789123123789', 'produto 1', 'primeira linha de produto', 1, '50', '25'),
    (1,1,'789123123790', 'produto 2', 'primeira linha de produto', 1, '20', '10'),
    (1,2,'789123123791', 'produto 3', 'Segunda linha de produto', 1, '40', '20'),
    (1,2,'789123123792', 'produto 4', 'Segunda linha de produto', 1, '80', '40'),
    (1,3,'789123123793', 'produto 5', 'Terceira linha de produto', 1, '90', '45'),
    (1,3,'789123123794', 'produto 6', 'Terceira linha de Servico', 2, '30', '15');
    
CREATE TABLE tb_carrinho(
    cd_carrinho integer PRIMARY KEY AUTO_INCREMENT,
    cd_prod_serv_carrinho integer,
    qtd_prod_serv_carrinho integer,
    cd_cliente_carrinho  integer,
    dt_add_carrinho datetime,
    dt_status_carrinho datetime,
    dt_compra_carrinho datetime,
    status_carrinho integer
);


create table tb_comodo(
    cd_comodo integer PRIMARY KEY AUTO_INCREMENT,
    cd_empresa_comodo integer,
    cd_filial_comodo integer,
    cd_colab_comodo integer,
    ds_comodo varchar(100),
    obs_comodo varchar(999)
);
--ALTER TABLE tb_comodo
--    ADD CONSTRAINT fk_tb_comodo1 FOREIGN KEY(cd_empresa_comodo) REFERENCES tb_empresa (cd_empresa),
--    ADD CONSTRAINT fk_tb_comodo2 FOREIGN KEY(cd_filial_comodo) REFERENCES tb_filial (cd_filial),
--    ADD CONSTRAINT fk_tb_comodo3 FOREIGN KEY(cd_colab_comodo) REFERENCES tb_colab (cd_colab);
    


create table tb_patrimonio(
    cd_patrimonio integer PRIMARY KEY AUTO_INCREMENT,
    cd_empresa_patrimonio integer,
    cd_filial_patrimonio integer,
    cd_comodo_patrimonio integer,
    cd_colab_patrimonio integer,
    numserie_patrimonio varchar(999),
    tipo_patrimonio varchar(100),
    fabricante_patrimonio varchar(100),
    marca_patrimonio varchar(100),
    modelo_patrimonio varchar(100),
    versao_patrimonio varchar(100),
    ds_patrimonio varchar(100),
    obs_patrimonio varchar(999),
    dt_compra_patrimonio DATETIME,
    dt_venda_patrimonio DATETIME,
    vl_compra_patrimonio DECIMAL(10,2),
    vl_venda_patrimonio DECIMAL(10,2),
    link_compra_patrimonio varchar(999),
    link_venda_patrimonio varchar(999)
);
--ALTER TABLE tb_patrimonio
--    ADD CONSTRAINT fk_tb_patrimonio FOREIGN KEY(cd_empresa_patrimonio) REFERENCES tb_empresa (cd_empresa),
--    ADD CONSTRAINT fk_tb_patrimonio FOREIGN KEY(cd_filial_patrimonio) REFERENCES tb_filial (cd_filial),
--    ADD CONSTRAINT fk_tb_patrimonio FOREIGN KEY(cd_comodo_patrimonio) REFERENCES tb_colab (cd_colab),
--    ADD CONSTRAINT fk_tb_patrimonio FOREIGN KEY(cd_colab_patrimonio) REFERENCES tb_colab (cd_colab);

