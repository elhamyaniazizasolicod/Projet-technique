<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../DAO/MatiereDAO.php';
header("Cantent-Type:application/json");

class MatiereService{
    
    public function ajouterMatiere(){
    $contont=file_get_contents("php://input");
    $matiere=json_decode($contont,true);
    $getionMatiere=new MatiereDAO();
    $matiere =new Matiere(0,$matiere["nom"],$matiere["description"]);
    $getionMatiere->ajouterMatiere($matiere);
    echo json_encode($matiere);
 }
 
 public function afficherMatiere(){
    try{
        http_response_code(200);

    }catch(Error $e){
        http_response_code(500);
       
    }
 }
 }
$Service = new MatiereService();
?>