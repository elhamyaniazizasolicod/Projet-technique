<?php
$host="localhost";
$dbname="plateforme_de_cours";
$username="root";
$password="ADMINE2345";

try{
    $conn=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo"ERREUR :".$e->getMessage();
}
