const bodyTable=document.getElementById("bodyTable")
const api="http://localhost:8000/backend/api/GestionMatiere.php"
const nom_matiere =document.getElementById("nom_matiere")
const description=document.getElementById("description")
const sectionForm=document.getElementById("sectionForm")
const btnAjouter=document.getElementById("btnAjouter")
const btnAnnuler=document.getElementById("annulerBtn")
function afficherMatiere() {
    fetch(api)
        .then(response => {
            console.log("Status :", response.status);
            return response.json();
        })
        .then(data => {
            console.log("Data reçue :", data);

            bodyTable.innerHTML = "";

            data.forEach(element => {
                bodyTable.insertAdjacentHTML("beforeend", `
                    <tr>
                        <td>${element.id_matiere}</td>
                        <td>${element.nom_matiere}</td>
                        <td>${element.description}</td>
                    </tr>
                `);
            });
        })
        .catch(error => console.error("Erreur :", error));
}



function ajouterMatiere(){
    fetch(api,{
        method:"POST",
        headers:{'Content-Type': 'application/json'},
        body:JSON.stringify({
            nom_matiere:nom_matiere.value,
            description:description.value
        })
    }).then(response=>response.json())
    .then(data=>{
        console.log(data)
        document.getElementById("form").reset()
        bodyTable.innerHTML=""
        afficherMatiere()
    }
    ).catch(error=>console.error(error))
}

document.getElementById("form").addEventListener("submit",event=>{
    event.preventDefault()
    ajouterMatiere()
})

document.addEventListener("DOMContentLoaded",()=>afficherMatiere())

btnAjouter.addEventListener("click",()=>{
    sectionForm.classList.remove("hidden")
})

btnAnnuler.addEventListener("click",()=>{
    sectionForm.classList.add("hidden")
})