<?php
require_once __DIR__ ."/../Services/MatiereService.php";
 $Service = new MatiereService();

 if($_SERVER['REQUEST_METHOD']=="POST"){
    $Service->ajouterMatiere();
 }
 if($_SERVER['REQUEST_METHOD']=="GIT"){
   $Service->afficherMatiere();
 }

?>