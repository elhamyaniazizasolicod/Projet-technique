const API_URL="http://localhost:8000/backend/api/GestionMatiere.php";
const tablebody= document.getElementById("tablebody");
const btnAnnuler= document.getElementById("btnAnnuler");
const sectionForm= document.getElementById("sectionForm");
const btnAjouter=document.getElementById("btnAjouter");
const nom_matiere=document.getElementById("cat-nom");
const description=document.getElementById("description");
const form =document.getElementById("form");
function afficherMatiere(){
    fetch(API_URL)
    .then(response=>{
        if(!response.ok) throw new Error(`HTTP error: ${response.status}`);
        return response.json();
    })
    .then(data=>{
        tablebody.innerHTML="";
        data.forEach(element => {
            const row=document.createElement("tr");
            [element.id_matiere,element.nom_matiere,element.description].forEach(value=>{
                const cell=document.createElement("td");
                cell.textContent=value;
                row.appendChild(cell);
            });
            tablebody.appendChild(row);
        });
    })
    .catch(error=>console.error(error))
}
function ajouterMatiere(){
    fetch(API_URL,{
        method:"POST",
        headers:{'Content-Type':'application/json'},
        body :JSON.stringify({
            nom_matiere:nom_matiere.value,
            description:description.value
        })
    })
    .then(response=>{
        if(!response.ok) throw new Error(`HTTP error: ${response.status}`);
        return response.json();
    })
    .then(data=>{
        console.log(data)
        form.reset();
        sectionForm.classList.add("hidden");
        afficherMatiere()
    })
    .catch(error=>console.error(error))
}

form.addEventListener("submit",event=>{
    event.preventDefault();
    ajouterMatiere()
})
btnAjouter.addEventListener("click",()=>{
    sectionForm.classList.remove("hidden")
});
btnAnnuler.addEventListener("click",()=>{
    sectionForm.classList.add("hidden")
});
afficherMatiere();




