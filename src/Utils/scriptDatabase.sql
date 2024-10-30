
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(155) NOT null,
    email VARCHAR(255) UNIQUE NOT null,
    password VARCHAR(255) NOT null
);

CREATE TABLE IF NOT EXISTS endereco (
    id SERIAL PRIMARY KEY,
    logradouro VARCHAR(255),
    numero VARCHAR(10),
    cidade VARCHAR(100),
    estado VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS cliente (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    endereco_id INT,
    FOREIGN KEY (endereco_id) REFERENCES endereco(id)
);
