const form=document.getElementById("form-matiere")
const sectionForm=document.getElementById("section-form")
const btnAjouter=document.getElementById("btn-show-form")
const btnAnnuler=document.getElementById("btn-cancel-form")
const tbody=document.getElementById("table-matiere-body")
const btnEnregister=document.getElementById("enregister")
const api="http://localhost:8000/backend/api/api.php"


function Loading(isloading){
    if(isloading){
        btnEnregister.disabled=true
        btnEnregister.textContent="En cours ..."
    }
    else{
        btnEnregister.disabled=false
        btnEnregister.textContent="Enregistrer"
    }
}

function Toast(message,type="success"){
    const toastContainer=document.getElementById("toast-container")
    const toast=document.createElement("div")
    const color=type=="success"?'bg-green-500':'bg-red-500'

    toast.className=`
        ${color} px-5 py-4 text-white transition-opacity duration-500
    `

    toast.textContent=`${message}`
    toastContainer.appendChild(toast)
    setTimeout(()=>{
        toast.style.opacity=0
        setTimeout(()=>{
            toast.remove()
        },500)
    },3000)
}

async function AfficherMatieres(){
    try {
        const response = await fetch(api)
        const data = await response.json()

        if (!response.ok) {
            throw new Error(data.message || "Impossible de charger les matieres")
        }

        tbody.innerHTML=""
        data.forEach(matiere=>{
            const tr=document.createElement("tr")
            tr.innerHTML=`
                <td class="px-4 py-3"></td>
                <td class="px-4 py-3"></td>
                <td class="px-4 py-3"></td>
            `
            tr.children[0].textContent=matiere["id_matiere"]
            tr.children[1].textContent=matiere["nom_matiere"]
            tr.children[2].textContent=matiere["description"]
            tbody.appendChild(tr)
        })
    }
    catch(error){
        console.error(error)
        Toast(error.message,"failed")
    }
}


document.addEventListener("DOMContentLoaded",()=>{
    AfficherMatieres()
    form.addEventListener("submit",(e)=>{
        e.preventDefault()
        Loading(true)
        fetch(api,{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify({
                nom_matiere:document.getElementById("nom_matiere").value,
                description:document.getElementById("description").value
            })
        }).then(async response=>{
            const data=await response.json()
            if(!response.ok || !data.success){
                throw new Error(data.message || "Une erreur est survenue")
            }
            Loading(false)
            Toast(data.message)
            form.reset()
            sectionForm.classList.add("hidden")
            AfficherMatieres()
        }).catch(error=>{
            Loading(false)
            Toast(error.message,"failed")
        })
    })
})


btnAjouter.addEventListener("click",()=>sectionForm.classList.remove("hidden"))
btnAnnuler.addEventListener("click",()=>{
    sectionForm.classList.add("hidden")
    form.reset()
})