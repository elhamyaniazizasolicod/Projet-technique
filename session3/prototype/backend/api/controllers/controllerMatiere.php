<?php
    require_once __DIR__ . "/../../class/GestionMatiere.php";

    header("Content-Type: application/json");

    class ControllerMatiere{
        public function afficherMatiere(){
            $gestionMatiere=new GestionMatiere();
            $Matieres=$gestionMatiere->afficherMatiere();
            $Matieres=[];
            foreach($Matieres as $Matiere){
                $Matieres[]=[
                    "id_matiere"=>$Matiere->getId(),
                    "nom_matiere"=>$Matiere->getNom(),
                    "description"=>$Matiere->getDescription()
                ];
            
            }
            echo json_encode($Matieres);
        }

        public function ajouterMatiere(){
            $jsonData=file_get_contents("php://input");
            $data=json_decode($jsonData,true);
            $gestionMatiere=new GestionMatiere();
            $Matieres=new MAtiere($data["nom_matiere"],$data["description"]);
            $gestionMatiere->ajouterMatiere($Matieres);
            echo json_encode($Matieres);

            
        }
    }

    // get o post
    $controller=new ControllerMatiere();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $controller->ajouterMatiere();
    }else{
        $controller->afficherMatiere();
    }


?>