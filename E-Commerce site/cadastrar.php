<?php

require "conexaoMySQL.php";
$pdo = mysqlConnect();

$nome = $_POST["cadnome"] ?? "";
$cpf = $_POST["cadcpf"] ?? "";
$email = $_POST["cademail"] ?? "";
$senha = $_POST["cadsenha"] ?? "";
$telefone = $_POST["cadtel"] ?? "";

$hashsenha = password_hash($senha, PASSWORD_DEFAULT);

try {

  $sql = <<<SQL

  INSERT INTO Anunciante (nome, cpf, email, senhaHash, telefone)
  VALUES (?, ?, ?, ?, ?)
  SQL;

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$nome, $cpf, $email, $hashsenha, $telefone]);

  header("location: index.html");
  exit();
} 
catch (Exception $e) {  
  if ($e->errorInfo[1] === 1062)
    exit('Dados duplicados: ' . $e->getMessage());
  else
    exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
