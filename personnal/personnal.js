//script jQuery à exécuter quand le DOM est chargé
$(document).ready(function(){
	
});


//--Envoi de l'inscription en ajax
function envoiInscription(){
    //--Navigation
    var nav='modification';

    //--Récupération des champs
    var nom = document.getElementById('nom').value;
    var prenom = document.getElementById('prenom').value;
    var site = document.getElementById('site').value;
    var dpt = document.getElementById('listDep').value;
    var photo = document.getElementById('hiddenPhoto').value;

    //--Vérification des champs obligatoires.
    if(nom == ""){ notification("Le champ 'Nom' est vide", true); }
    else if(prenom == ""){ notification("Le champ 'Prénom' est vide", true); }
    else if(dpt == "Sélectionnez"){ messageErreur("Sélectionnez un département"); }
    else{

        //--Contruction des parametres
        var value = 'nav='+nav
                    +'&nom='+nom
                    +'&prenom='+prenom
                    +'&site='+site
                    +'&dpt='+isoleNumDepartement(dpt)
                    +'&photo='+photo;

        //--Lancement ajax
        $.ajax({
            type: 'POST',
            url: 'personnal.behind.php',
            data: value,
            success: function(data) {
                var donnee = eval('('+ data +')');
                if(donnee == 'Ok'){ 
                    notification("Modification effectuée", false);
                }
                else{
                    notification("Erreur dans le traitement de la modification", true);
                }
            }
        });
    }
}

//--Isole le numero du département
function isoleNumDepartement(lachaine){

	// if(lachaine.charAt(2) == ':'){
		// return lachaine.substr(0, 2);
	// }
	// else{ return lachaine.substr(0, 3);}
	var spliter = lachaine.split(':');
	return spliter[0];
}

function notification(text, error){
    noeud = document.getElementById('text_notification');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    
    var not = document.getElementById("text_notification");
    not.appendChild(document.createTextNode(text));
    if(error){
        not.setAttribute("class", "red");
    }
    else{
        not.setAttribute("class", "green");
    }
    
}

/*
//--Envoi de mail à l'utilisateur
function envoiMail(log, mdp, mail, nom, prenom){
	var nav = 'envoiMail';

	//--Contruction des parametres
	var value = 'nav='+nav+'&log='+log+'&mdp='+mdp+'&mail='+mail+'&nom='+nom+'&prenom='+prenom;
	
	//--Lancement ajax
	$.ajax({
		type: 'POST',
		url: 'new_user.behind.php',
		data: value,
		success: function() {
			window.location = "confirm.php?envoi=envoi";
		}
	});
}*/
