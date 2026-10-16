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
    .catch(error=>console.error(error))
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
        afficherMatiere()
    })
    .catch(error=>console.log(error))
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





