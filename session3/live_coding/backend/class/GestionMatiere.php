<?php
require_once __DIR__. "/Matiere.php";

class GestionMatiere{

    private string $datafile;
    public function __construct(){
        $this->datafile=__DIR__."/../database/gestionMatiere.json";
    }
 public function ajouterMatiere($matiere){
    $contont=file_get_contents($this->datafile);
    $data=json_decode($contont,true);
    $id=count($data)+1;
    $data[]=[
        "id"=>$id,
        "nom"=>$matiere->getNom(),
        "description"=>$matiere->getDescription()
    ];
  $contont=json_encode($data,JSON_PRETTY_PRINT);
  file_put_contents($this->datafile,$contont);

 }
}

?>