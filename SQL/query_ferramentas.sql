
--CONSULTA MOVIMENTOS FINANCEIROS DUPLICADOS
SELECT t1.* FROM tb_movimento_financeiro t1 JOIN tb_movimento_financeiro t2 ON t1.valor_movimento = t2.valor_movimento WHERE t1.cd_os_movimento = t2.cd_os_movimento AND t1.fpag_movimento = t2.fpag_movimento AND (t1.cd_movimento = t2.cd_movimento + 1 OR t1.cd_movimento = t2.cd_movimento - 1) LIMIT 1000;


