<?php

require "conexaoMySQL.php";
session_start();
$pdo = mysqlConnect();

$titulo = $_POST["titulo"] ?? "";
$preco = $_POST["preco"] ?? "";
$desc = $_POST["desc"] ?? "";
$estado = $_POST["estado"] ?? "";
$cep = $_POST["cep"] ?? "";
$cidade = $_POST["cidade"] ?? "";
$bairro = $_POST["bairro"] ?? "";
$categoria = $_POST["categoria"] ?? "";
$email = $_SESSION['emailUsuario'];

//Ver essa questao do nome da imagem
$nomeImg = $_FILES["imagem"]["name"];
/*$extension  = pathinfo($nomeImg, PATHINFO_EXTENSION );
$teste = "imagemDoAnuncio".".".$extension;
$novoNomeImg = rename($nomeImg,$teste);
$imgPath = "../images/";*/


try {

  $sql1 = <<<SQL
  SELECT codigo
  FROM Anunciante
  WHERE email = ?
  SQL;

  $sql2 = <<<SQL
  SELECT codigo
  FROM Categoria
  WHERE nome = ?
  SQL;

  $stmt1 = $pdo->prepare($sql1);
  $stmt1->execute([$email]);
  $codigoAnun = $stmt1->fetchColumn();

  $stmt2 = $pdo->prepare($sql2);
  $stmt2->execute([$categoria]);
  $codigoCat = $stmt2->fetchColumn();

  $pdo->beginTransaction();
  $stmt3 = $pdo->prepare('INSERT INTO Anuncio (titulo, descricao, preco, cep, bairro, cidade, estado, fk_codCat, fk_codAnunciante)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
  if (! $stmt3->execute([$titulo, $desc, $preco, $cep, $bairro, $cidade, $estado, $codigoCat, $codigoAnun]))
    throw new Exception('Falha na operação 1');

  $stmt4 = $pdo->prepare('INSERT INTO Foto (nomeArq)
  VALUES (?)');
  if (! $stmt4->execute([$nomeImg]))
    throw new Exception('Falha na operação 2');

  $pdo->commit();

  header("location: index.html");
  exit();
} 

catch (Exception $e) {  
  $pdo->rollBack();
  if ($e->errorInfo[1] === 1062)
    exit('Dados duplicados: ' . $e->getMessage());
  else
    exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
