const API_URL="/backend/api/controllers/controllerMatiere.php";
const tbody=document.getElementById("table-categories-body")
const form=document.getElementById("form-categorie")
const nom=document.getElementById("nom")
const description=document.getElementById("description")
const btnshowform=document.getElementById("btn-show-form")
const formSection=document.getElementById("section-form")
const btnSubmit=document.getElementById("btn-submit")
const btnTxt=document.getElementById("btn-text")
const spinner=document.getElementById("spinner")

function afficherMatiere(){
    fetch(API_URL)
    .then(response=>response.json())
    .then(data=>{
        console.log(data)
        tbody.innerHTML=""
        data.forEach(data => {
            tbody.innerHTML+=`
            <tr>
            <td>${data.id}</td>
            <td>${data.nom}</td>
            <td>${data.description}</td>

            </tr>`
        });
    })
    .catch(error=>console.log(error))
}
function showToast(message,Type="succes"){
    const container =document.getElementById("toast-container");
    const toast=document.createElement("div");
    toast.classList="p-5 m-4 rounded"

    if(Type=="success"){
        toast.classList.add("bg-green-500")
    }else{
        toast.classList.add("bg-red-500")
    }
    toast.textContent=message;
    container.appendChild(toast)
    setTimeout(()=>{
        toast.remove()
    },3000)
}


 
form.addEventListener("submit",function(e){
    e.preventDefault();
    const data={
        nom:nom.value,
        description:description.value
    }
    spinner.classList.remove("hidden")
    btnTxt.textContent="Enregistrer en cours..."
    btnSubmit.disabled=true

    fetch(API_URL,{
        method:"POST",
        headers:{
            "Content-Type":"application/json"

        },
        body:JSON.stringify(data)   
    })
    .then(response=>response.json())
    .then(()=>{
        showToast("added success","success")
        form.reset()
        afficherMatiere()
    }).catch(error=>{
        showToast(error.message,"error")
    }).finally(()=>{
        spinner.classList.add("hidden")
    })

})

btnshowform.addEventListener("click",function(){
    formSection.classList.remove("hidden")
    btnTxt.textContent="Enregistrer"
    btnSubmit.disabled=false

})
document.addEventListener("DOMContentLoaded",afficherMatiere())
afficherMatiere()