// Récupération des éléments du DOM
const bodyTable = document.getElementById("bodyTable");
const sectionForm = document.getElementById("sectionForm");
const form = document.getElementById("form");
const formTitle = document.getElementById("formTitle");
const id_matiere = document.getElementById("id_matiere");
const nom_matiere = document.getElementById("nom_matiere");
const description = document.getElementById("description");
const btnAjouter = document.getElementById("btnAjouter");
const btnAnnuler = document.getElementById("annulerBtn");

// URL de l'API PHP
const api = "http://localhost:8000/backend/api/GestionMatiere.php";

// 1. Fonction pour afficher la liste des matières (GET)
function afficherMatiere() {
    fetch(api)
        .then(response => {
            if (!response.ok) {
                throw new Error("Erreur réseau : " + response.status);
            }
            return response.json();
        })
        .then(data => {
            bodyTable.innerHTML = "";

            if (!Array.isArray(data) || data.length === 0) {
                bodyTable.innerHTML = `
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            Aucune matière enregistrée pour le moment.
                        </td>
                    </tr>
                `;
                return;
            }

            data.forEach(element => {
                const tr = document.createElement("tr");
                tr.className = "border-b border-gray-200 hover:bg-gray-50 transition";

                tr.innerHTML = `
                    <td class="p-4 font-mono">${element.id_matiere}</td>
                    <td class="p-4 font-semibold text-gray-800">${escapeHtml(element.nom_matiere)}</td>
                    <td class="p-4 text-gray-600">${escapeHtml(element.description)}</td>
                    <td class="p-4 text-center space-x-2">
                        <button class="btn-modifier bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded text-sm transition">
                            Modifier
                        </button>
                        <button class="btn-supprimer bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm transition">
                            Supprimer
                        </button>
                    </td>
                `;

                // Événements sur les boutons d'action
                tr.querySelector(".btn-modifier").addEventListener("click", () => {
                    preparerModification(element);
                });

                tr.querySelector(".btn-supprimer").addEventListener("click", () => {
                    supprimerMatiere(element.id_matiere);
                });

                bodyTable.appendChild(tr);
            });
        })
        .catch(error => console.error("Erreur lors de la récupération des matières :", error));
}

// 2. Fonction pour enregistrer une matière (Ajout via POST ou Modification via PUT)
function enregistrerMatiere() {
    const id = id_matiere.value;
    const estModification = id !== "";

    const donnees = {
        nom_matiere: nom_matiere.value.trim(),
        description: description.value.trim()
    };

    let methode = "POST";
    if (estModification) {
        methode = "PUT";
        donnees.id_matiere = parseInt(id, 10);
    }

    fetch(api, {
        method: methode,
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(donnees)
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            reinitialiserFormulaire();
            afficherMatiere();
        })
        .catch(error => console.error("Erreur lors de l'enregistrement :", error));
}

// 3. Fonction pour préparer le formulaire en mode modification
function preparerModification(matiere) {
    id_matiere.value = matiere.id_matiere;
    nom_matiere.value = matiere.nom_matiere;
    description.value = matiere.description;

    formTitle.textContent = "Modifier la Matière #" + matiere.id_matiere;
    sectionForm.classList.remove("hidden");
    nom_matiere.focus();
}

// 4. Fonction pour supprimer une matière (DELETE)
function supprimerMatiere(id) {
    if (!confirm("Voulez-vous vraiment supprimer cette matière ?")) {
        return;
    }

    fetch(`${api}?id=${id}`, {
        method: "DELETE"
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            afficherMatiere();
        })
        .catch(error => console.error("Erreur lors de la suppression :", error));
}

// 5. Réinitialisation et masquage du formulaire
function reinitialiserFormulaire() {
    form.reset();
    id_matiere.value = "";
    formTitle.textContent = "Ajouter une Matière";
    sectionForm.classList.add("hidden");
}

// Évite l'injection de code HTML involontaire (sécurité XSS)
function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text ?? "";
    return div.innerHTML;
}

// Gestionnaires d'événements
form.addEventListener("submit", event => {
    event.preventDefault();
    enregistrerMatiere();
});

btnAjouter.addEventListener("click", () => {
    reinitialiserFormulaire();
    sectionForm.classList.remove("hidden");
    nom_matiere.focus();
});

btnAnnuler.addEventListener("click", () => {
    reinitialiserFormulaire();
});

// Chargement initial des données
document.addEventListener("DOMContentLoaded", () => {
    afficherMatiere();
});