
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `fl_ponto` (
  `token_alter` int(11) NOT NULL,
  `cdcolab_ponto` int(11) DEFAULT NULL,
  `cdempresa_ponto` int(11) DEFAULT NULL,
  `pais_ponto` varchar(40) DEFAULT NULL,
  `estado_ponto` varchar(40) DEFAULT NULL,
  `cidade_ponto` varchar(40) DEFAULT NULL,
  `bairro_ponto` varchar(40) DEFAULT NULL,
  `data_ponto` varchar(40) DEFAULT NULL,
  `hora_ponto` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `rel_user` (
  `token_alter` int(11) NOT NULL,
  `cd_seg` int(11) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `cd_estilo` int(11) DEFAULT NULL,
  `cd_funcao` int(11) DEFAULT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_status` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `rel_user` (`token_alter`, `cd_seg`, `cd_colab`, `cd_estilo`, `cd_funcao`, `cd_empresa`, `cd_status`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(2, 1, 2, 1, 5, 1, 1);



CREATE TABLE `tb_atividade` (
  `cd_atividade` int(11) PRIMARY KEY AUTO_INCREMENT,
  `cd_servico` int(11) DEFAULT NULL,
  `titulo_atividade` varchar(10) DEFAULT NULL,
  `obs_atividade` varchar(1000) DEFAULT NULL,
  `cd_colab` int(11) DEFAULT NULL,
  `inicio_atividade` varchar(40) DEFAULT NULL,
  `fim_atividade` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tb_caixa` (
  `cd_caixa` int(11) PRIMARY KEY AUTO_INCREMENT,
  `dt_abertura` datetime NOT NULL,
  `dt_fechamento` datetime DEFAULT NULL,
  `cd_colab_abertura` int(11) DEFAULT NULL,
  `cd_colab_fechamento` int(11) DEFAULT NULL,
  `saldo_abertura` decimal(10,2) DEFAULT NULL,
  `total_movimento` decimal(10,2) DEFAULT NULL,
  `saldo_fechamento` decimal(10,2) DEFAULT NULL,
  `diferenca_caixa` decimal(10,2) DEFAULT NULL,
  `fpag_dinheiro` decimal(10,2) DEFAULT NULL,
  `fpag_debito` decimal(10,2) DEFAULT NULL,
  `fpag_credito` decimal(10,2) DEFAULT NULL,
  `fpag_pix` decimal(10,2) DEFAULT NULL,
  `fpag_cofre` decimal(10,2) DEFAULT NULL,
  `fpag_boleto` decimal(10,2) DEFAULT NULL,
  `status_caixa` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tb_caixa_conferido` (
  `cd_caixa_conferido` int(11) PRIMARY KEY AUTO_INCREMENT,
  `cd_caixa_analitico` int(11) DEFAULT NULL,
  `dt_conferencia` datetime DEFAULT NULL,
  `cd_colab_conferencia` int(11) DEFAULT NULL,
  `obs_conferencia` varchar(999) DEFAULT NULL,
  `saldo_abertura_conferido` decimal(10,2) DEFAULT NULL,
  `saldo_fechamento_conferido` decimal(10,2) DEFAULT NULL,
  `diferenca_caixa_conferido` decimal(10,2) DEFAULT NULL,
  `saldo_movimento_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_dinheiro_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_debito_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_credito_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_pix_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_cofre_conferido` decimal(10,2) DEFAULT NULL,
  `fpag_boleto_conferido` decimal(10,2) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tb_caixa_dia_fiscal` (
  `cd_caixa_dia_fiscal` int(11) PRIMARY KEY AUTO_INCREMENT,
  `dt_abertura_dia_fiscal` datetime NOT NULL,
  `dt_fechamento_dia_fiscal` datetime DEFAULT NULL,
  `movimento_analitico_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `movimento_conferido_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `total_analitico_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `total_conferido_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `diferenca_caixa_dia_fiscal` decimal(10,2) DEFAULT NULL,
  `status_caixa_dia_fiscal` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tb_cliente` (
  `cd_cliente` int(11) PRIMARY KEY AUTO_INCREMENT,
  `pnome_cliente` varchar(40) DEFAULT NULL,
  `snome_cliente` varchar(40) DEFAULT NULL,
  `cpf_cliente` varchar(40) DEFAULT NULL,
  `dtnasc_cliente` varchar(40) DEFAULT NULL,
  `sexo_cliente` varchar(40) DEFAULT NULL,
  `obs_cliente` varchar(40) DEFAULT NULL,
  `tel_cliente` varchar(40) DEFAULT NULL,
  `obs_tel_cliente` varchar(40) DEFAULT NULL,
  `email_cliente` varchar(40) DEFAULT NULL,
  `foto_cliente` varchar(1000) DEFAULT NULL,
  `senha_cliente` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `tb_cliente_comercial` (
  `cd_cliente_comercial` int(11) PRIMARY KEY AUTO_INCREMENT,
  `cd_matriz_comercial` int(11),
  `rsocial_cliente_comercial` varchar(40) DEFAULT NULL,
  `nfantasia_cliente_comercial` varchar(40) DEFAULT NULL,
  `cnpj_cliente_comercial` varchar(40) DEFAULT NULL,
  `dtcadastro_cliente_comercial` datetime NOT NULL,
  `dtvalidlicenca_cliente_comercial` datetime NOT NULL,
  `obs_cliente_comercial` varchar(40) DEFAULT NULL,
  `tel_cliente_comercial` varchar(40) DEFAULT NULL,
  `obs_tel_cliente_comercial` varchar(40) DEFAULT NULL,
  `email_cliente_comercial` varchar(40) DEFAULT NULL,
  `fatura_prevista_cliente_fiscal` decimal(10,2) DEFAULT NULL,
  `fatura_devida_cliente_fiscal` decimal(10,2) DEFAULT NULL,
  `senha_cliente_comercial` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
INSERT INTO `tb_cliente_comercial` (`cd_matriz_comercial`, `rsocial_cliente_comercial`, `nfantasia_cliente_comercial`, `cnpj_cliente_comercial`, `dtcadastro_cliente_comercial`, `dtvalidlicenca_cliente_comercial`, `obs_cliente_comercial`, `tel_cliente_comercial`, `obs_tel_cliente_comercial`, `email_cliente_comercial`, `fatura_prevista_cliente_fiscal`, `fatura_devida_cliente_fiscal`, `senha_cliente_comercial`) VALUES
(1, 'AtiviSoft', 'AtiviSoft', '123', '2024-03-15T00:00', '2024-04-13T00:00', '', '21970071218', '', 'sc46cs@gmail.com', 80.00, 0.00, ''),
(2, 'OFICINA DA ROUPA', 'OFICINA DA ROUPA', '08057969000100', '2023-08-12T00:00', '2024-05-05T00:00', '', '21992048913', '', 'marcia.oficinadaroupa@gmail.com', 80.00, 0.00, ''),
(3, 'AMORIMFOR TEC', 'AMORIMFOR TEC', '37719768000120', '2024-01-05T00:00', '2024-04-13T00:00', '', '21965543094', '', 'amorimgg7@gmail.com', 80.00, 0.00, ''),
(4, 'MARIA DA LUZ GOMES DA SILVA', 'MALUÊ', '34798614000182', '2023-08-20T00:00', '2024-04-13T00:00', '', '21982803278', '', 'malu.atelie.moda.praia@gmail.com', 80.00, 0.00, ''),
(5, 'SONIA CRISTINA DA CONCEICAO SILVA', 'FESTAS E EVENTOS', '31273120000196', '2024-03-15T00:00', '2024-04-13T00:00', '', '21970071218', '', 'sc46cs@gmail.com', 80.00, 0.00, '');


CREATE TABLE `tb_colab` (
  `cd_colab` int(11) PRIMARY KEY AUTO_INCREMENT,
  `pnome_colab` varchar(40) DEFAULT NULL,
  `snome_colab` varchar(40) DEFAULT NULL,
  `cpf_colab` varchar(40) DEFAULT NULL,
  `dtnasc_colab` varchar(40) DEFAULT NULL,
  `sexo_colab` varchar(40) DEFAULT NULL,
  `obs_colab` varchar(40) DEFAULT NULL,
  `tel_colab` varchar(40) DEFAULT NULL,
  `obs_tel_colab` varchar(40) DEFAULT NULL,
  `email_colab` varchar(40) DEFAULT NULL,
  `foto_colab` varchar(1000) DEFAULT NULL,
  `senha_colab` varchar(40) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_colab` (`cd_colab`, `pnome_colab`, `snome_colab`, `cpf_colab`, `dtnasc_colab`, `sexo_colab`, `obs_colab`, `tel_colab`, `obs_tel_colab`, `email_colab`, `foto_colab`, `senha_colab`) VALUES
(1, 'erp-Nuvemsoft', '', '1', NULL, NULL, NULL, '', NULL, 'suporte@ativisoft.com.br', NULL, 'asd,123'),
(2, 'Sonia', 'Silva', '', '', '', NULL, '21970071218', NULL, 'sc46cs@gmail.com', NULL, '1');


CREATE TABLE `tb_empresa` (
  `cd_empresa` int(11) PRIMARY KEY AUTO_INCREMENT,
  `rsocial_empresa` varchar(100) DEFAULT NULL,
  `nfantasia_empresa` varchar(100) DEFAULT NULL,
  `cnpj_empresa` int(100) DEFAULT NULL,
  `cd_ceo` int(11) DEFAULT NULL,
  `chave_auth` varchar(1000) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_empresa` (`cd_empresa`, `rsocial_empresa`, `nfantasia_empresa`, `cnpj_empresa`, `cd_ceo`, `chave_auth`) VALUES
(1, 'SONIA CRISTINA DA CONCEICAO SILVA', 'FESTAS E EVENTOS', 31273120000196, 2, 'AUTH');



CREATE TABLE `tb_estilo` (
  `cd_estilo` int(11) PRIMARY KEY AUTO_INCREMENT,
  `titulo_estilo` varchar(40) DEFAULT NULL,
  `t_sidebar` varchar(200) DEFAULT NULL,
  `c_sidebar` varchar(200) DEFAULT NULL,
  `t_navbar` varchar(200) DEFAULT NULL,
  `c_navbar` varchar(200) DEFAULT NULL,
  `t_font` varchar(200) DEFAULT NULL,
  `c_font` varchar(200) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_estilo` (`cd_estilo`, `titulo_estilo`, `t_sidebar`, `c_sidebar`, `t_navbar`, `c_navbar`, `t_font`, `c_font`) VALUES
(1, 'Light-blue', 'padrão', 'style=\"background-color: #a7dbfb; color: #044167;\"', 'padrão', 'style=\"background-color: #23a5f6;\"', 'padrão', 'padrão'),
(2, 'Dark-blue', 'padrão', 'style=\"background-color: #191970; color: #8b8bbb;\"', 'padrão', 'style=\"background-color: #2727ec;\"', 'padrão', 'padrão');

CREATE TABLE tb_seguranca(
    `cd_seg` int(11) NOT NULL,	
    `titulo_seg` varchar(200),
    `obs_seg` varchar(40),
    `cd_colab` varchar(40),
	`empresa` varchar(40)
);

INSERT INTO tb_seguranca (titulo_seg,obs_seg, cd_colab, empresa)
VALUES ('master', 'User Master', '1', '1');


CREATE TABLE `tb_servico` (
  `cd_servico` int(11) PRIMARY KEY AUTO_INCREMENT,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_servico` varchar(100) DEFAULT NULL,
  `obs_servico` varchar(1000) DEFAULT NULL,
  `prioridade_servico` varchar(10) DEFAULT NULL,
  `entrada_servico` varchar(40) NOT NULL,
  `prazo_servico` varchar(40) DEFAULT NULL,
  `orcamento_servico` decimal(10,2) DEFAULT NULL,
  `vpag_servico` decimal(10,2) DEFAULT NULL,
  `status_servico` varchar(10) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tb_filial` (
  `cd_filial` int(11) NOT NULL,
  `cd_empresa` int(11) DEFAULT NULL,
  `cd_responsavel` int(11) DEFAULT NULL,
  `rsocial_filial` varchar(999) DEFAULT NULL,
  `nfantasia_filial` varchar(999) DEFAULT NULL,
  `cnpj_filial` varchar(40) DEFAULT NULL,
  `endereco_filial` varchar(999) DEFAULT NULL,
  `saudacoes_filial` varchar(999) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `tb_filial` (`cd_filial`, `cd_empresa`, `cd_responsavel`, `rsocial_filial`, `nfantasia_filial`, `cnpj_filial`, `endereco_filial`, `saudacoes_filial`) VALUES
(1, 1, 1, 'SONIA CRISTINA DA CONCEICAO SILVA', 'FESTAS E EVENTOS', '31273120000196', 'Rua..., Número, Cidade, RJ(21) 9 7007 1218 horário de - a - das - as - e - de - as -', 'Saudações.');



CREATE TABLE `tb_funcao` (
  `cd_funcao` int(11) NOT NULL,
  `titulo_funcao` varchar(200) DEFAULT NULL,
  `obs_funcao` varchar(200) DEFAULT NULL,
  `md_patrimonio` varchar(200) DEFAULT NULL,
  `md_fponto` varchar(200) DEFAULT NULL,
  `md_assistencia` varchar(200) DEFAULT NULL,
  `md_cliente` varchar(200) DEFAULT NULL,
  `md_fornecedor` varchar(200) DEFAULT NULL,
  `md_clientefornecedor` varchar(200) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `tb_funcao` (`cd_funcao`, `titulo_funcao`, `obs_funcao`, `md_patrimonio`, `md_fponto`, `md_assistencia`, `md_cliente`, `md_fornecedor`, `md_clientefornecedor`) VALUES
(1, 'Assistente', 'observações', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: block;\"', 'style=\"display: none;\"', 'style=\"display: none;\"', 'style=\"display: none;\"');



CREATE TABLE `tb_movimento_financeiro` (
  `cd_movimento` int(11) NOT NULL,
  `cd_caixa_movimento` int(11) DEFAULT NULL,
  `cd_colab_movimento` int(11) DEFAULT NULL,
  `cd_cliente_movimento` int(11) DEFAULT NULL,
  `tipo_movimento` int(11) DEFAULT NULL,
  `cd_os_movimento` int(11) DEFAULT NULL,
  `fpag_movimento` varchar(999) DEFAULT NULL,
  `valor_movimento` decimal(10,2) DEFAULT NULL,
  `data_movimento` datetime DEFAULT NULL,
  `obs_movimento` varchar(999) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `tb_orcamento_servico` (
  `cd_orcamento` int(11) ,
  `cd_servico` int(11) DEFAULT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `titulo_orcamento` varchar(999) DEFAULT NULL,
  `vcusto_orcamento` varchar(40) DEFAULT NULL,
  `vpag_orcamento` varchar(40) DEFAULT NULL,
  `status_orcamento` int(11) DEFAULT NULL
)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tb_frases` (
  `cd_frase` int(11) NOT NULL,
  `texto_frase` varchar(900) DEFAULT NULL,
  `autor_frase` varchar(200) DEFAULT NULL,
  `vida_autor` varchar(200) DEFAULT NULL,
  `biografia_autor` varchar(999) DEFAULT NULL,
  `data_inicio_frase` varchar(10) DEFAULT NULL,
  `data_fim_frase` varchar(10) DEFAULT NULL,
  `dia_inicio` int(11) NOT NULL,
  `dia_fim` int(11) NOT NULL,
  `prioridade_frase` int(11) NOT NULL

)  DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `tb_frases` (`cd_frase`, `texto_frase`, `autor_frase`, `vida_autor`, `biografia_autor`, `data_inicio_frase`, `data_fim_frase`, `dia_inicio`, `dia_fim`) VALUES
(1, 'frase de efeito', 'autor da frase', '2000 a 2024', 'O Autor viveu na galiléia e dedicou a sua vida em ajudar os necessitados', '01-01-2000', '01-01-2030', 1, 6),
(2, 'As oportunidades multiplicam-se à medida que são agarradas!', 'Sun Tzu', '544 a.C. - 496 a.C', 'Sun Tzu foi um estrategista militar chinês, filósofo e autor do tratado militar clássico "A Arte da Guerra". Pouco se sabe sobre sua biografia com precisão histórica, mas é amplamente aceito que ele viveu durante o século IV a.C., durante o período conhecido como os Reinos Combatentes da China antiga. Sun Tzu serviu como general no exército do estado de Wu e é creditado por suas contribuições para as estratégias militares que ajudaram Wu a alcançar vitórias sobre seus rivais. Seu trabalho mais famoso, "A Arte da Guerra", é uma obra seminal sobre estratégia militar, que oferece conselhos atemporais sobre táticas, planejamento e liderança.  Além de suas habilidades militares, Sun Tzu é considerado um filósofo cujas ideias transcenderam o campo da guerra, sendo aplicadas em diversos campos, como negócios, política e esportes. Sua obra continua a ser estudada e admirada até os dias de hoje, influenciando estrategistas e líderes em todo o mundo.', '01-01-2000', '01-01-2030', 7, 20);
(3, 'Você não pode impor a produtividade, você deve fornecer as ferramentas para permitir que as pessoas se transformem no seu melhor.”', 'Steve Jobs', '', '', '', '', 1, 1, 1);
(4, 'Não tente se tornar uma pessoa de sucesso, prefira tentar se tornar uma pessoa de valor.”', 'Albert Einstein', '', '', '', '', 1, 1, 1);
(5, 'Sempre que te perguntarem se você pode fazer um trabalho, diga-lhes: – Certamente eu posso! – Em seguida, fique muito ocupado e descubra como fazê-lo.”', 'Theodore Roosevelt', '', '', '', '', 1, 1, 1);
(6, 'Não é problema reclamar do trabalho. Mas trabalhe antes, só assim suas queixas terão fundamento.”', 'Sócrates', '', '', '', '', 1, 1, 1);
(7, 'Melhorando a qualidade, automaticamente você estará melhorando a produtividade.”', 'W. Edwards Deming', '', '', '', '', 1, 1, 1);
(8, 'O insucesso é apenas uma oportunidade para recomeçar de novo com mais inteligência.”', 'Henry Ford', '', '', '', '', 1, 1, 1);
(9, 'Nos momentos finais do mês, reflita sobre suas realizações com gratidão e prepare-se para receber as novas oportunidades que o próximo ciclo trará."', 'Paulo Coelho', '', '', '', '', 1, 1, 1);





INSERT INTO `tb_frases` (`texto_frase`, `autor_frase`, `vida_autor`, `biografia_autor`, `data_inicio_frase`, `data_fim_frase`, `dia_inicio`, `dia_fim`, `prioridade_frase`) VALUES
('frase de efeito', 'autor da frase', '2000 a 2024', 'O Autor viveu na galiléia e dedicou a sua vida em ajudar os necessitados', '', '', 1, 6, 1),
('As oportunidades multiplicam-se à medida que são agarradas!', 'Sun Tzu', '544 a.C. - 496 a.C', 'Sun Tzu foi um estrategista militar chinês, filósofo e autor do tratado militar clássico "A Arte da Guerra". Pouco se sabe sobre sua biografia com precisão histórica, mas é amplamente aceito que ele viveu durante o século IV a.C., durante o período conhecido como os Reinos Combatentes da China antiga. Sun Tzu serviu como general no exército do estado de Wu e é creditado por suas contribuições para as estratégias militares que ajudaram Wu a alcançar vitórias sobre seus rivais. Seu trabalho mais famoso, "A Arte da Guerra", é uma obra seminal sobre estratégia militar, que oferece conselhos atemporais sobre táticas, planejamento e liderança.  Além de suas habilidades militares, Sun Tzu é considerado um filósofo cujas ideias transcenderam o campo da guerra, sendo aplicadas em diversos campos, como negócios, política e esportes. Sua obra continua a ser estudada e admirada até os dias de hoje, influenciando estrategistas e líderes em todo o mundo.', '01-01-2000', '01-01-2030', 7, 20, 1),
('Você não pode impor a produtividade, você deve fornecer as ferramentas para permitir que as pessoas se transformem no seu melhor.”', 'Steve Jobs', '', '', '', '', 1, 1, 1),
('Não tente se tornar uma pessoa de sucesso, prefira tentar se tornar uma pessoa de valor.”', 'Albert Einstein', '', '', '', '', 1, 1, 1),
('Sempre que te perguntarem se você pode fazer um trabalho, diga-lhes: – Certamente eu posso! – Em seguida, fique muito ocupado e descubra como fazê-lo.”', 'Theodore Roosevelt', '', '', '', '', 1, 1, 1),
('Não é problema reclamar do trabalho. Mas trabalhe antes, só assim suas queixas terão fundamento.”', 'Sócrates', '', '', '', '', 1, 1, 1),
('Melhorando a qualidade, automaticamente você estará melhorando a produtividade.”', 'W. Edwards Deming', '', '', '', '', 1, 1, 1),
('O insucesso é apenas uma oportunidade para recomeçar de novo com mais inteligência.”', 'Henry Ford', '', '', '', '', 1, 1, 1),
('Nos momentos finais do mês, reflita sobre suas realizações com gratidão e prepare-se para receber as novas oportunidades que o próximo ciclo trará."', 'Paulo Coelho', '', '', '', '', 1, 1, 1);




ALTER TABLE `tb_frases`
  ADD PRIMARY KEY (`cd_frase`);

ALTER TABLE `fl_ponto`
  ADD PRIMARY KEY (`token_alter`),
  ADD KEY `fk_fl_ponto1` (`cdcolab_ponto`),
  ADD KEY `fk_fl_ponto2` (`cdempresa_ponto`);


ALTER TABLE `rel_user`
  ADD PRIMARY KEY (`token_alter`),
  ADD KEY `fk_rel_user1` (`cd_seg`),
  ADD KEY `fk_rel_user2` (`cd_colab`),
  ADD KEY `fk_rel_user3` (`cd_estilo`),
  ADD KEY `fk_rel_user4` (`cd_funcao`),
  ADD KEY `fk_rel_user5` (`cd_empresa`);


ALTER TABLE `tb_atividade`
  ADD PRIMARY KEY (`cd_atividade`),
  ADD KEY `fk_rel_colab1` (`cd_servico`),
  ADD KEY `fk_rel_colab2` (`cd_colab`);


ALTER TABLE `tb_caixa`
  ADD PRIMARY KEY (`cd_caixa`),
  ADD KEY `fk_tb_caixa1` (`cd_colab_abertura`),
  ADD KEY `fk_tb_caixa2` (`cd_colab_fechamento`);


ALTER TABLE `tb_caixa_conferido`
  ADD PRIMARY KEY (`cd_caixa_conferido`),
  ADD KEY `fk_tb_caixa_conferido1` (`cd_caixa_analitico`),
  ADD KEY `fk_tb_caixa_conferido2` (`cd_colab_conferencia`);


ALTER TABLE `tb_caixa_dia_fiscal`
  ADD PRIMARY KEY (`cd_caixa_dia_fiscal`);


ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`cd_cliente`);


ALTER TABLE `tb_colab`
  ADD PRIMARY KEY (`cd_colab`);


ALTER TABLE `tb_empresa`
  ADD PRIMARY KEY (`cd_empresa`),
  ADD KEY `fk_rel_empresa1` (`cd_ceo`);


ALTER TABLE `tb_estilo`
  ADD PRIMARY KEY (`cd_estilo`);


ALTER TABLE `tb_filial`
  ADD PRIMARY KEY (`cd_filial`),
  ADD KEY `fk_rel_filial1` (`cd_empresa`),
  ADD KEY `fk_rel_filial2` (`cd_responsavel`);


ALTER TABLE `tb_funcao`
  ADD PRIMARY KEY (`cd_funcao`);


ALTER TABLE `tb_movimento_financeiro`
  ADD PRIMARY KEY (`cd_movimento`),
  ADD KEY `fk_tb_movimento_financeiro1` (`cd_caixa_movimento`),
  ADD KEY `fk_tb_movimento_financeiro2` (`cd_colab_movimento`),
  ADD KEY `fk_tb_movimento_financeiro3` (`cd_cliente_movimento`),
  ADD KEY `fk_tb_movimento_financeiro4` (`cd_os_movimento`);


ALTER TABLE `tb_orcamento_servico`
  ADD PRIMARY KEY (`cd_orcamento`),
  ADD KEY `fk_rel_orcamento1` (`cd_servico`),
  ADD KEY `fk_rel_orcamento2` (`cd_cliente`);


ALTER TABLE `tb_seguranca`
  ADD PRIMARY KEY (`cd_seg`);


ALTER TABLE `tb_servico`
  ADD KEY `fk_rel_cliente` (`cd_cliente`);




ALTER TABLE `fl_ponto`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `rel_user`
  MODIFY `token_alter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `tb_atividade`
  MODIFY `cd_atividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7288;


ALTER TABLE `tb_caixa`
  MODIFY `cd_caixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;


ALTER TABLE `tb_caixa_conferido`
  MODIFY `cd_caixa_conferido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;


ALTER TABLE `tb_caixa_dia_fiscal`
  MODIFY `cd_caixa_dia_fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;


ALTER TABLE `tb_cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1521;


ALTER TABLE `tb_colab`
  MODIFY `cd_colab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `tb_empresa`
  MODIFY `cd_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_estilo`
  MODIFY `cd_estilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `tb_filial`
  MODIFY `cd_filial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_funcao`
  MODIFY `cd_funcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `tb_movimento_financeiro`
  MODIFY `cd_movimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3227;


ALTER TABLE `tb_orcamento_servico`
  MODIFY `cd_orcamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5837;


ALTER TABLE `tb_seguranca`
  MODIFY `cd_seg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tb_servico`
  MODIFY `cd_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2993;
COMMIT;


