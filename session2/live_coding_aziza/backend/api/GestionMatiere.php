<?php
 require_once "../class/matiere.php";
 header('Content-Type: aplication/json');
 class GestionMatiere{
    private string $path_file;

    public function __construct(string $path_file=""){
        $this->path_file=$path_file __DIR__ . "../database/gestionMatiere.json";
    }
    public function AjouterMatier(){
        $content=file_get_contents();
        $matiere=file_put_contents();
        
    }
    public function AfficherMatiere(){
        
    }

 }

 
?>