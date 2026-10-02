<?php
class Matiere{
    private int $id_matiere;
    private string $nom_matiere;
    private string $description;

    public function __construct(int $id_matiere=0,string $nom="",string $description=""){
        $this->id_matiere=$id_matiere;
        $this->nom_matiere=$nom;
        $this->description=$description;
    }
    public function getNom() : string {
        return  $this->nom_matiere;
    }
    public function getDescription() : string {
        return $this->description;
    }
    public function setNom(string $value):void{
         $this->nom_matiere=$value;
    }
    public function setDescription(string $value) : void {
         $this->description=$value;
    }

}
?>