
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
    ["001", "Abertura de caixa", "N"],
    ["002", "Fechamento de caixa", "N"],
    ["003", "Sangria", "N"],
    ["004", "Reforço de caixa", "N"],
    ["005", "Cancelar operação", "N"]
]';


UPDATE rel_master
SET acesso_assistencia_0002 = '[
    ["101", "Abrir ordem de serviço", "N"],
    ["102", "Alterar ordem de serviço", "N"],
    ["103", "Fechar ordem de serviço", "N"],
    ["104", "Adicionar peças", "N"],
    ["105", "Aprovar orçamento", "N"]
]';


UPDATE rel_master
SET acesso_venda_0003 = '[
    ["201", "Iniciar venda", "N"],
    ["202", "Aplicar desconto", "N"],
    ["203", "Cancelar venda", "N"],
    ["204", "Retornar item", "N"],
    ["205", "Gerar NF-e/NFC-e", "N"]
]';


UPDATE rel_master
SET acesso_venda_0003 = '[
    ["201", "Iniciar venda", "N"],
    ["202", "Aplicar desconto", "N"],
    ["203", "Cancelar venda", "N"],
    ["204", "Retornar item", "N"],
    ["205", "Gerar NF-e/NFC-e", "N"]
]';

UPDATE rel_master
SET acesso_patrimonio_0004 = '[
    ["301", "Cadastrar patrimônio", "N"],
    ["302", "Baixar patrimônio", "N"],
    ["303", "Depreciação", "N"],
    ["304", "Transferir patrimônio", "N"],
    ["305", "Emitir relatório patrimonial", "N"]
]';


UPDATE rel_master
SET acesso_folhaponto_0005 = '[
    ["401", "Registrar ponto manual", "N"],
    ["402", "Corrigir ponto", "N"],
    ["403", "Gerar folha mensal", "N"],
    ["404", "Cadastrar horário", "N"],
    ["405", "Aprovar horas extras", "N"]
]';

UPDATE rel_master
SET acesso_financeiro_0006 = '[
    ["501", "Lançar contas a pagar", "N"],
    ["502", "Lançar contas a receber", "N"],
    ["503", "Conciliar extrato", "N"],
    ["504", "Emitir relatório financeiro", "N"],
    ["505", "Cadastrar categorias", "N"]
]';

UPDATE rel_master
SET acesso_cadastro_0007 = '[
    ["601", "Cadastrar cliente", "N"],
    ["602", "Cadastrar produtos", "N"],
    ["603", "Cadastrar fornecedores", "N"],
    ["604", "Editar cadastros", "N"],
    ["605", "Excluir registros", "N"]
]';

UPDATE rel_master
SET acesso_pdv_0008 = '[
    ["701", "Acessar PDV", "N"],
    ["702", "Registrar venda rápida", "N"],
    ["703", "Acessar modo administrador", "N"],
    ["704", "Aplicar desconto no PDV", "N"],
    ["705", "Cancelar cupom", "N"]
]';
