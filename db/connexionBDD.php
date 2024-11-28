<?php
$host = 'localhost'; 
$db = 'recettes1'; 
$user = 'root'; 
$pass = '';

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
  
    die("Erreur de connexion : " . $e->getMessage()); 
}
?>
