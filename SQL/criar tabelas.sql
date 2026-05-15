CREATE TABLE clientes (
	cod_cliente SERIAL PRIMARY KEY,
	nome_cliente VARCHAR(20) NOT NULL,
	sobrenome_cliente VARCHAR(40) NOT NULL,
	email_cliente VARCHAR(40) NOT NULL,
	senha_cliente VARCHAR(40) NOT NULL,
	idade_cliente INT NOT NULL
);
CREATE TABLE casas(
	cod_casa SERIAL PRIMARY KEY,
	cep_casa  VARCHAR(9) NOT NULL,
	bairro_casa VARCHAR(40) NOT NULL,
	rua_casa VARCHAR(40) NOT NULL,
	numero_casa INT NOT NULL,
	complemento_casa VARCHAR NOT NULL
);
CREATE TABLE dispositivos(
	mac_dispositivo VARCHAR(17) NOT NULL,
	nome_dispositivo VARCHAR(10) NOT NULL,
	comodo_dispositivo VARCHAR(10) NOT NULL
);

SELECT * FROM clientes, casas, dispositivos