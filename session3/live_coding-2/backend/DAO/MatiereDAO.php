<?php
require_once __DIR__. "/../class/Matiere.php";

class MatiereDAO{

    private string $datafile;
    public function __construct(){
        $this->datafile=__DIR__."/../database/gestionMatiere.json";
    }

     public function afficherMatiere(){
        $jsonData=file_get_contents(self::$datafile);
        $data=json_decode($jsonData,true);
        $matieres=[];
        foreach($data as $index=>$item){
           $nom=$item["nom"] ?? $item["name"] ?? null;
           if(!is_string($nom)){
               throw new UnexpectedValueException("Missing subject name in JSON record " . ($index + 1));
           }
           $matiere=new MAtiere($item["id"],$nom,$item["description"]);
           $matieres[]=$matiere;
        }
           return $matieres;
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