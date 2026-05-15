
ALTER TABLE `rel_master`
  DROP `acesso_caixa_0001`,
  DROP `acesso_assistencia_0002`,
  DROP `acesso_venda_0003`,
  DROP `acesso_patrimonio_0004`,
  DROP `acesso_folhaponto_0005`,
  DROP `acesso_financeiro_0006`,
  DROP `acesso_cadastro_0007`,
  DROP `acesso_pdv_0008`;


 ALTER TABLE `rel_master`
  	ADD `acesso_caixa_0001` JSON NULL AFTER `status_rel`,
    ADD `acesso_assistencia_0002` JSON NULL AFTER `acesso_caixa_0001`,
    ADD `acesso_venda_0003` JSON NULL AFTER `acesso_assistencia_0002`,   
    ADD `acesso_patrimonio_0004` JSON NULL AFTER `acesso_venda_0003`,
    ADD `acesso_folhaponto_0005` JSON NULL AFTER `acesso_patrimonio_0004`,
    ADD `acesso_financeiro_0006` JSON NULL AFTER `acesso_folhaponto_0005`,
    ADD `acesso_cadastro_0007` JSON NULL AFTER `acesso_financeiro_0006`,
    ADD `acesso_pdv_0008` JSON NULL AFTER `acesso_cadastro_0007`;




UPDATE rel_master
SET acesso_caixa_0001 = '[
    ["101", "Abertura de caixa", "N"],
    ["102", "Troca de Operador", "N"],
    ["103", "Fechamento de caixa Fiscal", "N"],
    ["104", "Sangria", "N"],
    ["105", "Suprimento", "N"],
    ["106", "Operações de caixa", "N"]
]' WHERE acesso_caixa_0001 is NULL;


UPDATE rel_master
SET acesso_assistencia_0002 = '[
    ["201", "Cadastrar ordem de servico", "N"],
    ["202", "Editar ordem de servico", "N"],
    ["203", "Orcamento Avulso", "N"],
    ["204", "Orcamento Cadastrado", "N"],
    ["205", "Atividades(EM ANDAMENTO)", "N"],
    ["206", "Atividades(FINALIZAR)", "N"],
    ["207", "Atividades(ENTREGAR/DEVOLVER)", "N"],
    ["208", "Atividades(REFAZER AGORA)", "N"],
    ["209", "Atividades(REFAZER DEPOIS)", "N"],
    ["210", "Atividades(ARQUIVAR)", "N"]
]'  WHERE acesso_assistencia_0002 is NULL;


UPDATE rel_master
SET acesso_venda_0003 = '[
    ["301", "Iniciar venda", "N"],
    ["302", "Aplicar desconto", "N"],
    ["303", "Cancelar venda", "N"],
    ["304", "Cancelar item", "N"],
    ["305", "Gerar MEI", "N"],
    ["306", "Gerar NF-e/NFC-e", "N"]
]'  WHERE acesso_venda_0003 is NULL;

UPDATE rel_master
SET acesso_patrimonio_0004 = '[
    ["401", "Cadastrar patrimonio", "N"],
    ["402", "Baixar patrimonio", "N"],
    ["403", "Depreciacao", "N"],
    ["404", "Transferir patrimonio", "N"],
    ["405", "Emitir relatorio patrimonial", "N"]
]'  WHERE acesso_patrimonio_0004 is NULL;


UPDATE rel_master
SET acesso_folhaponto_0005 = '[
    ["501", "Registrar ponto manual", "N"],
    ["502", "Corrigir ponto", "N"],
    ["503", "Gerar folha mensal", "N"],
    ["504", "Cadastrar horario", "N"],
    ["505", "Aprovar horas extras", "N"]
]'  WHERE acesso_folhaponto_0005 is NULL;

UPDATE rel_master
SET acesso_financeiro_0006 = '[
    ["601", "Lancar contas a pagar", "N"],
    ["602", "Lancar contas a receber", "N"],
    ["603", "Lancar Pagamento Servico", "N"],
    ["604", "Emitir Mapa de Caixa", "N"]
]'  WHERE acesso_financeiro_0006 is NULL;

UPDATE rel_master
SET acesso_cadastro_0007 = '[
    ["701", "Cadastrar Cliente", "N"],
    ["702", "Editar cliente", "N"],
    ["703", "Ver Cliente", "N"],
    ["704", "Cadastrar Produtos", "N"],
    ["705", "Editar Produtos", "N"],
    ["706", "Ver Produtos", "N"],
    ["707", "Cadastrar Colaborador", "S"],
    ["708", "Editar Colaborador", "S"],
    ["709", "Ver Colaboradores", "S"],
    ["710", "Excluir registros", "N"]
]' WHERE acesso_cadastro_0007 is NULL;

-- UPDATE rel_master
-- SET acesso_venda_0003 = JSON_ARRAY_APPEND(
--    acesso_venda_0003,
--    '$',
--    JSON_ARRAY("307", "Cadastro de Produto", "N")
-- );


UPDATE rel_master
SET acesso_pdv_0008 = '[
    ["801", "Acessar PDV Balcao", "N"],
    ["802", "Acessar PDV Mesa", "N"],
    ["803", "Acessar PDV Delivery", "N"],
    ["804", "Config. PDV Balcao", "N"],
    ["805", "Config. PDV Mesa", "N"],
    ["806", "Config. PDV Delivery", "N"],
    ["807", "Acessar modo administrador", "N"],
    ["808", "Aplicar desconto no PDV", "N"],
    ["809", "Cancelar venda", "N"],
    ["810", "Cancelar produto", "N"],
    ["811", "Cancelar MEI", "N"],
    ["812", "Cancelar NF-e/NFC-e", "N"]
]'  WHERE acesso_pdv_0008 is NULL;


ALTER TABLE tb_venda MODIFY abertura_venda DATETIME;


alter table tb_venda add cd_vendedor int;
alter table tb_venda add vdesconto_venda decimal(10,2);
ALTER TABLE tb_venda 
    ADD CONSTRAINT fk_venda_1 FOREIGN KEY (cd_vendedor) REFERENCES tb_pessoa (cd_pessoa),
    ADD CONSTRAINT fk_venda_2 FOREIGN KEY (cd_cliente) REFERENCES tb_pessoa (cd_pessoa);


alter table tb_orcamento_venda add obs_orcamento varchar(999),
ADD qtd_orcamento decimal(10,2),
ADD tipo_desconto varchar(1),
ADD vcusto_orcamento decimal(10,2),
ADD desconto_orcamento decimal(10,5);

alter table tb_venda add tipo_desconto varchar(1),
add desconto_venda decimal(10,5);

ALTER TABLE tb_reserva
  DROP cd_orcamento;

alter table tb_reserva
    add cd_orcamento_venda int,
    add cd_orcamento_servico int;

alter table tb_reserva
    ADD CONSTRAINT fk_reserva_1 FOREIGN KEY (cd_orcamento_servico) REFERENCES tb_orcamento_servico (cd_orcamento),
    ADD CONSTRAINT fk_reserva_2 FOREIGN KEY (cd_orcamento_venda) REFERENCES tb_orcamento_venda (cd_orcamento);



UPDATE tb_empresa e
JOIN (
    SELECT rm.cd_empresa, rm.cd_pessoa
    FROM rel_master rm
    JOIN (
        SELECT cd_empresa, MIN(cd_rel) AS cd_rel
        FROM rel_master
        GROUP BY cd_empresa
    ) x ON x.cd_empresa = rm.cd_empresa
       AND x.cd_rel = rm.cd_rel
) r ON r.cd_empresa = e.cd_empresa
SET e.cd_proprietario = r.cd_pessoa;


alter table tb_empresa
    add cd_cliente_padrao int;

alter table tb_empresa
    add constraint fk_empresa_1 foreign key (cd_proprietario) references tb_pessoa (cd_pessoa),
    add constraint fk_empresa_2 foreign key (cd_cliente_padrao) references tb_pessoa(cd_pessoa);



-- alter table tb_venda add cd_empresa int;
-- alter table tb_venda add constraint fk_venda_3 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa(cd_empresa);

-- alter table tb_orcamento_venda add cd_empresa int;
-- alter table tb_orcamento_venda add constraint fk_rel_orcamento_venda4 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa(cd_empresa);

-- alter table tb_reserva add cd_empresa int;
-- alter table tb_reserva add constraint fk_reserva_3 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa(cd_empresa);

-- alter table tb_reserva add cd_filial int;
-- alter table tb_reserva add constraint fk_reserva_4 FOREIGN KEY (cd_filial) REFERENCES tb_empresa(cd_empresa);

-- alter table tb_prod_serv add constraint fk_tb_prod_serv3 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa(cd_empresa);
-- alter table tb_prod_serv add constraint fk_tb_prod_serv4 FOREIGN KEY (cd_filial) REFERENCES tb_empresa(cd_empresa);

alter table tb_servico add cd_empresa int;
alter table tb_servico add constraint fk_rel_servico_1 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa(cd_empresa);

ALTER TABLE tb_venda ADD cd_venda_seq_1 INT NOT NULL AFTER cd_venda;
ALTER TABLE tb_servico ADD cd_servico_seq_1 INT NOT NULL AFTER cd_servico;

ALTER TABLE tb_orcamento_servico ADD cd_orcamento_seq_1 INT NOT NULL AFTER cd_orcamento;
ALTER TABLE tb_orcamento_venda ADD cd_orcamento_seq_1 INT NOT NULL AFTER cd_orcamento;

alter table tb_orcamento_servico add cd_empresa int;
alter table tb_orcamento_servico add constraint fk_rel_orcamento4 FOREIGN KEY (cd_empresa) REFERENCES tb_empresa(cd_empresa);



UPDATE tb_servico
SET cd_empresa = cd_filial;

UPDATE tb_venda
SET cd_empresa = cd_filial;

UPDATE tb_orcamento_servico
SET cd_empresa = cd_filial;
UPDATE tb_orcamento_venda
SET cd_empresa = cd_filial;



UPDATE tb_venda v
JOIN (
    SELECT
        cd_venda,
        ROW_NUMBER() OVER (
            PARTITION BY cd_empresa
            ORDER BY cd_venda
        ) AS nova_seq
    FROM tb_venda
) x ON x.cd_venda = v.cd_venda
SET v.cd_venda_seq_1 = x.nova_seq;


UPDATE tb_servico v
JOIN (
    SELECT
        cd_servico,
        ROW_NUMBER() OVER (
            PARTITION BY cd_empresa
            ORDER BY cd_servico
        ) AS nova_seq
    FROM tb_servico
) x ON x.cd_servico = v.cd_servico
SET v.cd_servico_seq_1 = x.nova_seq;

UPDATE tb_orcamento_servico v
JOIN (
    SELECT
        cd_orcamento,
        ROW_NUMBER() OVER (
            PARTITION BY cd_empresa
            ORDER BY cd_orcamento
        ) AS nova_seq
    FROM tb_orcamento_servico
) x ON x.cd_orcamento = v.cd_orcamento
SET v.cd_orcamento_seq_1 = x.nova_seq;

UPDATE tb_orcamento_venda v
JOIN (
    SELECT
        cd_orcamento,
        ROW_NUMBER() OVER (
            PARTITION BY cd_empresa
            ORDER BY cd_orcamento
        ) AS nova_seq
    FROM tb_orcamento_venda
) x ON x.cd_orcamento = v.cd_orcamento
SET v.cd_orcamento_seq_1 = x.nova_seq;



alter table tb_servico 
    add fl_retrabalho varchar(2),
    add dt_entrada_retrabalho varchar(20),
    add dt_prazo_retrabalho varchar(20),
    add obs_retrabalho varchar(999);

update tb_servico set fl_retrabalho = 'N';

UPDATE tb_venda SET status_venda = 'F' WHERE status_venda = '2';
UPDATE tb_venda SET status_venda = 'A' WHERE status_venda = '1'; 

ALTER TABLE tb_venda 
    add dt_cancelamento varchar(40),
    add colab_cancelamento integer;

alter table tb_movimento_financeiro
    add dt_cancelamento varchar(40),
    add colab_cancelamento integer;
--update tb_servico set fl_retrabalho = 'N' where fl_retrabalho in(null, '');