<?php

function checkPassword($pdo, $email, $senha)
{
  $sql = <<<SQL
    SELECT senhaHash
    FROM Anunciante
    WHERE email = ?
    SQL;

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $senhaHash = $stmt->fetchColumn();
    
    if (!$senhaHash) 
      return false;

    if (!password_verify($senha, $senhaHash))
      return false;
      
    return $senhaHash;
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

function checkLogged($pdo)
{
  if (!isset($_SESSION['emailUsuario'], $_SESSION['loginString']))
    return false;

  $email = $_SESSION['emailUsuario'];

  $sql = <<<SQL
    SELECT senhaHash
    FROM Anunciante
    WHERE email = ?
    SQL;

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $senhaHash = $stmt->fetchColumn();
    
    if (!$senhaHash) 
      return false;

    $loginStringCheck = hash('sha512', $senhaHash . $_SERVER['HTTP_USER_AGENT']);
    if (!hash_equals($loginStringCheck, $_SESSION['loginString']))
      return false;

    return true;
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

function exitWhenNotLogged($pdo)
{
  if (!checkLogged($pdo)) {
    header("Location: index.html");
    exit();
  }
}

function sessionEnd(){
  session_unset();
  session_destroy();
}
