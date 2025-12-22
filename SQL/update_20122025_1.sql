
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
]';


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
]';


UPDATE rel_master
SET acesso_venda_0003 = '[
    ["301", "Iniciar venda", "N"],
    ["302", "Aplicar desconto", "N"],
    ["303", "Cancelar venda", "N"],
    ["304", "Cancelar item", "N"],
    ["305", "Gerar MEI", "N"],
    ["306", "Gerar NF-e/NFC-e", "N"]
]';

UPDATE rel_master
SET acesso_patrimonio_0004 = '[
    ["401", "Cadastrar patrimonio", "N"],
    ["402", "Baixar patrimonio", "N"],
    ["403", "Depreciacao", "N"],
    ["404", "Transferir patrimonio", "N"],
    ["405", "Emitir relatorio patrimonial", "N"]
]';


UPDATE rel_master
SET acesso_folhaponto_0005 = '[
    ["501", "Registrar ponto manual", "N"],
    ["502", "Corrigir ponto", "N"],
    ["503", "Gerar folha mensal", "N"],
    ["504", "Cadastrar horario", "N"],
    ["505", "Aprovar horas extras", "N"]
]';

UPDATE rel_master
SET acesso_financeiro_0006 = '[
    ["601", "Lancar contas a pagar", "N"],
    ["602", "Lancar contas a receber", "N"],
    ["603", "Lancar Pagamento Servico", "N"],
    ["604", "Emitir Mapa de Caixa", "N"]
]';

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
]';

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
]';


ALTER TABLE tb_venda MODIFY abertura_venda DATETIME;

alter table tb_venda add cd_vendedor int;
alter table tb_venda add vdesconto_venda decimal(10,2);
ALTER TABLE tb_venda 
    ADD CONSTRAINT fk_venda_1 FOREIGN KEY (cd_vendedor) REFERENCES tb_pessoa (cd_pessoa),
    ADD CONSTRAINT fk_venda_2 FOREIGN KEY (cd_cliente) REFERENCES tb_pessoa (cd_pessoa);


alter table tb_orcamento_venda add obs_orcamento varchar(999);