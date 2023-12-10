INSERT INTO clientes (nome_cliente, sobrenome_cliente, idade_cliente)
VALUES
('Gabriel', 'Amorim', 21),
('Maria', 'da Luz Gomes da Silva', 50),
('Iranildo', 'Silva', 35);

INSERT INTO Casas (cep_casa, bairro_casa, rua_casa, numero_casa, complemento_casa)
VALUES ('22780-805', 'Curicica', 'Rua João Bruno Lobo', '291', 'Complemento A, casa 1');

INSERT INTO dispositivos (mac_dispositivo,nome_dispositivo,comodo_dispositivo)
VALUES ('a1:21:a1:a1:a1:a1:1a:a1', 'LUZES-2.0', 'Sala');

SELECT * FROM clientes, casas, dispositivos