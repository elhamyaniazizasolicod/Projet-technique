<?php
require_once __DIR__ ."/../../class/GestionMatiere.php";
header("Cantent-Type:application/json");
class ControllerMatiere{
    public function ajouterMatiere(){
    $contont=file_get_contents("php://input");
    $matiere=json_decode($contont,true);
    $getionMatiere=new GestionMatiere();
    $matiere =new Matiere(0,$matiere["nom"],$matiere["description"]);
    $getionMatiere->ajouterMatiere($matiere);
    echo json_encode($matiere);
 }}
 $controller = new ControllerMatiere();

 if($_SERVER['REQUEST_METHOD']=="POST"){
    $controller->ajouterMatiere();
 }

?>