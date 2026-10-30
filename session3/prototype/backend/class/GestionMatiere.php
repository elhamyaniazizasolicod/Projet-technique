<?php
require_once __DIR__ . "/Matiere.php";
class GestionMatiere{
    public static $dataFile= __DIR__ . "/../database/gestionMatiere.json";

    public function afficherMatiere(){
        $jsonData=file_get_contents(self::$dataFile);
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

    public function ajouterMatiere(MAtiere $matiere){
          $jsonData=file_get_contents(self::$dataFile);
            $data=json_decode($jsonData,true);
            $id=count($data)+1;
            $data[]=[
                "id"=>$id,
                "nom"=>$matiere->getNom(),
                "description"=>$matiere->getDescription()

            ];
            $jsonData=json_encode($data,JSON_PRETTY_PRINT);
            file_put_contents(self::$dataFile,$jsonData);
            
            
    }

}



?>