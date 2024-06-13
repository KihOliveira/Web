CREATE TABLE Anunciante(
codigo int NOT NULL,
nome varchar(45) NOT NULL,
cpf varchar(9) NOT NULL,
email varchar(45),
senhaHash varchar(245),
telefone int,
PRIMARY KEY (codigo)
)

CREATE TABLE Endereco(
cep varchar(8) NOT NULL,
bairro varchar(45) NOT NULL,
cidade varchar(45) NOT NULL,
estado varchar(2) NOT NULL,
PRIMARY KEY (cep)
)

CREATE TABLE Categoria(
codigo int NOT NULL,
nome varchar(45) NOT NULL,
descricao varchar(245) NOT NULL,
PRIMARY KEY (codigo)
)


CREATE TABLE Foto(
codigoAnun int NOT NULL,
nomeArq varchar(245) NOT NULL
)

CREATE TABLE Anuncio(
codigo int NOT NULL,
titulo varchar(45) NOT NULL,
descricao varchar(245),
preco float NOT NULL,
cep varchar(8) NOT NULL,
bairro varchar(45) NOT NULL,
cidade varchar(45) NOT NULL,
estado varchar(2) NOT NULL,
PRIMARY KEY (codigo),
CONSTRAINT fk_codCat FOREIGN KEY (codigo) REFERENCES Categoria (codigo),
CONSTRAINT fk_codAnunciante FOREIGN KEY (codigo) REFERENCES Anunciante (codigo)
)


CREATE TABLE Interesse(
codigo int NOT NULL,
mensagem varchar(245) NOT NULL,
descricao varchar(245) NOT NULL,
PRIMARY KEY (codigo)
)