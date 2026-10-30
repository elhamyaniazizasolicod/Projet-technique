<?php
    require_once __DIR__ . "/../../class/GestionMatiere.php";

    header("Content-Type: application/json");

    class controllerMatiere{
        public function afficherMatiere(){
            $gestionMatiere= new GestionMatiere();
            $matieres=$gestionMatiere->afficherMatiere();
            $result=[];
            foreach($matieres as $matiere){
                $result[]=[
                    "id"=>$matiere->getId(),
                    "nom"=>$matiere->getNom(),
                    "description"=>$matiere->getDescription()
                ];
            
            }
            echo json_encode($result);
        }

        public function ajouterMatiere(){
            $jsonData=file_get_contents("php://input");
            $data=json_decode($jsonData,true);
            $gestionMatiere=new GestionMatiere();
            $matiere=new MAtiere(0,$data["nom"],$data["description"]);
            $gestionMatiere->ajouterMatiere($matiere);
            echo json_encode($matiere);

            
        }
    }

    // get o post
    $controller=new controllerMatiere();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $controller->ajouterMatiere();
    }else{
        $controller->afficherMatiere();
    }


?>