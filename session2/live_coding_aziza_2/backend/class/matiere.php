<?php
class Matiere{
    private int $id;
    private string $nom_matiere;
    private string $description;
    
    public function __construct(int $id,string $nom_matiere="",string $description=""){
        $this->id=$id;
        $this->nom_matiere=$nom_matiere;
        $this->description=$description;
    }
    public function getId():int{
        return $this->id;
    }
    public function setId(int $id):void{
        $this->id=$id;
    }
    public function getNom():string {
        return $this->nom_matiere;
    }
    public function setNom(string $nom_matiere):void{
        $this->nom_matiere=$nom_matiere;
    }
    public function getDescription() :string {
        return $this->description;
    }
    public function setDescription(string $description):void{
        $this->description=$description;
    }
}
?>