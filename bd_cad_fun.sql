create database if not exists db_cad_fun;
use db_cad_fun;

/* Create table funcionarios */
create table if not exists tb_funcionarios(
id integer primary key auto_increment,
nome varchar(70) not null,
fone varchar(11) not null,
email varchar(150) not null,
cpf varchar(11) unique not null,
rg varchar(9) unique not null,
cep varchar(8) not null,
uf varchar(2) not null,
cidade varchar(70) not null,
endereco varchar(70) not null,
logradouro varchar(50) not null,
numero varchar(10) not null,
funcao varchar(50) not null,
foto varchar(100) not null,
obs text(1000));