<?php

require "more-cards.php";
require "conexaoMySQL.php";
$pdo = mysqlConnect();

$titulo = $_GET['titulo'] ?? '';


$sql = <<<SQL

SELECT Anuncio.codigo, Anuncio.titulo , Anuncio.descricao, Anuncio.preco, Anuncio.cidade , Foto.nomeArq
FROM Anuncio, Foto
WHERE Anuncio.codigo = Foto.codigoAnun 
AND Anuncio.titulo LIKE %?%
LIMIT 6
SQL;

$products = [];

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo]);
    while ($row = $stmt->fetch()) {
        $products[] = new Card ($row['codigo'], $row['titulo'], $row['preco'], $row['nomeArq'], $row['descricao'], $row['cidade']);
      }
}

catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
}

header('Content-type: application/json');
echo json_encode($products);

?>