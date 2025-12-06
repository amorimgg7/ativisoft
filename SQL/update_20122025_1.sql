
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
    ["102", "Fechamento de caixa", "N"],
    ["103", "Sangria", "N"],
    ["104", "Reforço de caixa", "N"],
    ["105", "Cancelar operação", "N"]
]';


UPDATE rel_master
SET acesso_assistencia_0002 = '[
    ["201", "Abrir ordem de serviço", "N"],
    ["202", "Alterar ordem de serviço", "N"],
    ["203", "Fechar ordem de serviço", "N"],
    ["204", "Adicionar peças", "N"],
    ["205", "Aprovar orçamento", "N"]
]';


UPDATE rel_master
SET acesso_venda_0003 = '[
    ["301", "Iniciar venda", "N"],
    ["302", "Aplicar desconto", "N"],
    ["303", "Cancelar venda", "N"],
    ["304", "Retornar item", "N"],
    ["305", "Gerar NF-e/NFC-e", "N"]
]';

UPDATE rel_master
SET acesso_venda_0003 = JSON_ARRAY_APPEND(
    acesso_venda_0003,
    '$',
    JSON_ARRAY("306", "Cadastro de Produto", "N")
);

UPDATE rel_master
SET acesso_patrimonio_0004 = '[
    ["401", "Cadastrar patrimônio", "N"],
    ["402", "Baixar patrimônio", "N"],
    ["403", "Depreciação", "N"],
    ["404", "Transferir patrimônio", "N"],
    ["405", "Emitir relatório patrimonial", "N"]
]';


UPDATE rel_master
SET acesso_folhaponto_0005 = '[
    ["501", "Registrar ponto manual", "N"],
    ["502", "Corrigir ponto", "N"],
    ["503", "Gerar folha mensal", "N"],
    ["504", "Cadastrar horário", "N"],
    ["505", "Aprovar horas extras", "N"]
]';

UPDATE rel_master
SET acesso_financeiro_0006 = '[
    ["601", "Lançar contas a pagar", "N"],
    ["602", "Lançar contas a receber", "N"],
    ["603", "Conciliar extrato", "N"],
    ["604", "Emitir relatório financeiro", "N"],
    ["605", "Cadastrar categorias", "N"]
]';

UPDATE rel_master
SET acesso_cadastro_0007 = '[
    ["701", "Cadastrar cliente", "N"],
    ["702", "Cadastrar produtos", "N"],
    ["703", "Cadastrar fornecedores", "N"],
    ["704", "Editar cadastros", "N"],
    ["705", "Excluir registros", "N"]
]';

UPDATE rel_master
SET acesso_pdv_0008 = '[
    ["801", "Acessar PDV", "N"],
    ["802", "Registrar venda rápida", "N"],
    ["803", "Acessar modo administrador", "N"],
    ["804", "Aplicar desconto no PDV", "N"],
    ["805", "Cancelar cupom", "N"]
]';
