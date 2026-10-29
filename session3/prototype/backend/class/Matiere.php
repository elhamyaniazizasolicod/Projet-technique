<?php
class MAtiere{
    private int $id_matiere;
    private string $nom_matiere;
    private string $description;
    public function __construct(int $id_matiere,string $nom_matiere="", string $description=""){
        $this->id_matiere=$id_matiere;
        $this->nom_matiere=$nom_matiere;
        $this->description=$description;
    } 
    public function getId() : int {
        return $this->id_matiere;
    }
    public function getNom() : string {
        return $this->nom_matiere;
    }
    public function getDescription():string{
        return $this->description;
    }
    public function setId(int $id_matiere):void{
        $this->id_matiere=$id_matiere;

    }
    public function setNom(string $nom_matiere) : void {
        $this->nom_matiere=$nom_matiere;
        
    }
    public function setDescription(string $description):void{
        $this->description=$description;
    }
}
?>