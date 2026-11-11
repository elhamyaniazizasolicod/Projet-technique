<?php
require_once __DIR__ . '/../class/Matiere.php';
class MatiereDAO{
    public static $dataFile= __DIR__ . "/../data/gestionMatiere.json";

    public function AfficherMatiere(){
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

    public function ajouterMatiere($nom,$description){
            $data=[];
            $genres=$this->AfficherMatiere();
            $id=count($genres)+1;
            if(trim($nom)=="" || trim($description)==""){
                throw new Error("tout les champs sont obligatoire");
            }
            else{
                $genres[]=new Matiere($id,$nom,$description);
                foreach ($genres as $genre){
                    $data[]=[
                        "id"=>$genre->getId(),
                        "nom"=>$genre->getNom(),
                        "description"=>$genre->getDescription(),
                    ];
                }

                file_put_contents(self::$dataFile,json_encode($data,JSON_PRETTY_PRINT));
            }
        }

}



?>