const API_URL="http://localhost:8000/backend/api/GestionMatiere.php";
const tablebody=document.getElementById("tablebody");
const btnAjouter=document.getElementById("btnAjouter");
const sectionForm=document.getElementById("sectionForm");
const form=document.getElementById("form");
const id_matiere=document.getElementById("id_matiere");
const nom_matiere=document.getElementById("nom_matiere");
const description=document.getElementById("description");
function afficherMatiere(){
    fetch(API_URL)
    .then(Response=>Response.json())
    .then(data=>{
        data.forEach(element => {
            tablebody.insertAdjacentHTML("beforeend",`
                <tr>
                <td>${element.id_matiere}</td>
                <td>${element.nom_matiere}</td>
                <td>${element.description}</td>
                </tr>
            `)
        });
    })
}
function ajouterMatiere(){
    fetch(API_URL,{
        method:"POST",
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({
            nom_matiere:nom_matiere.value,
            description:description.value
        })
    })
    .then(Response=>Response.json())
    .then(data=>{
        console.log(data)
        document.getElementById("form")
        tablebody.innerHTML=""
        form.reset()
        afficherMatiere()
    })
}
form.addEventListener("submit",event=>{
    event.preventDefault()
    ajouterMatiere()
})
afficherMatiere()