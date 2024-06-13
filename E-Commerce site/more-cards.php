<?php
require "conexaoMySQL.php";
$pdo = mysqlConnect();

class Card
{
  public $id;
  public $name;
  public $price;
  public $imagePath;
  public $description;
  public $city;

  function __construct($id, $name, $price, $imagePath,$description,$city)
  {
    $this->id = $id;
    $this->name = $name; 
    $this->price = $price;
    $this->imagePath = $imagePath;
    $this->city = $city;
    $this->description = $description;
  }
}

$sql = <<<SQL
SELECT Anuncio.codigo, Anuncio.titulo , Anuncio.descricao, Anuncio.preco, Anuncio.cidade , Foto.nomeArq
FROM Anuncio, Foto
WHERE Anuncio.codigo = Foto.codigoAnun
SQL;

$stmt = $pdo->query($sql);

$products = [];

while ($row = $stmt->fetch()) {
  $products[] = new Card ($row['codigo'], $row['titulo'], $row['preco'], $row['nomeArq'], $row['descricao'], $row['cidade']);
}

 
$randProds = [
  $products[rand(0, 6)],
  $products[rand(0, 6)],
  $products[rand(0, 6)],
  $products[rand(0, 6)],
  $products[rand(0, 6)],
  $products[rand(0, 6)]
];

header('Content-type: application/json');
echo json_encode($randProds);

?>