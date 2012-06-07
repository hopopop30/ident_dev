//script jQuery à exécuter quand le DOM est chargé
$(document).ready(function(){
	
});


//--Envoi de l'inscription en ajax
function envoiInscription(){
	//--Navigation
	var nav='inscription';
	
	//--Récupération des champs
	var login = document.getElementById('login').value;
	var mdp = document.getElementById('mdp').value;
	var mdpConf = document.getElementById('mdpConfirm').value;
	var nom = document.getElementById('nom').value;
	var prenom = document.getElementById('prenom').value;
	var mail = document.getElementById('mail').value;
	var mailConf = document.getElementById('mailConfirm').value;
	var site = document.getElementById('site').value;
	var dpt = document.getElementById('listDep').value;
	var photo = document.getElementById('hiddenPhoto').value;
	
	//--Vérification des champs obligatoires.
	if(login == ""){ messageErreur("Le champ 'login' est vide"); }
	else if(mdp == ""){ messageErreur("Le champ 'mot de passe' est vide"); }
	else if(mdpConf == "" || mdpConf != mdp){ messageErreur("Mots de passes différents"); }
	else if(nom == ""){ messageErreur("Le champ 'nom' est vide"); }
	else if(prenom == ""){ messageErreur("Le champ 'Prénom' est vide"); }
	else if(mail == ""){ messageErreur("Le champ 'email' est vide"); }
	else if(mailConf == "" || mailConf != mail){ messageErreur("Emails différents"); }
	else if(dpt == "Sélectionnez"){ messageErreur("Sélectionnez un département"); }
	else{
	
		//--Contruction des parametres
		var value = 'nav='+nav
					+'&login='+login
					+'&mdp='+mdp
					+'&nom='+nom
					+'&prenom='+prenom
					+'&mail='+mail
					+'&site='+site
					+'&dpt='+isoleNumDepartement(dpt)
					+'&photo='+photo;

		//--Lancement ajax
		$.ajax({
			type: 'POST',
			url: 'new_user.behind.php',
			data: value,
			success: function(data) {
				var donnee = eval('('+ data +')');
				if(donnee == 'erreurLogin'){ messageErreur("Login déja existant"); }
				else if(donnee == 'erreurMail'){ messageErreur("Email déja existant"); }
				else if(donnee == 'mailInvalide'){ messageErreur("Email invalide"); }
				else if(donnee == 'Ok'){ envoiMail(login, mdp, mail, nom, prenom); }
			}
		});
	}
}

//--Affiche un message dans la div erreurmessage
function messageErreur(message){
	//--Effacement du message précédent
	var noeud = document.getElementById('divMessageErreur');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
	//--Création du texte
	document.getElementById('divMessageErreur').appendChild(document.createTextNode(message));
	//--Apparition de la div erreur
	document.getElementById('divMessageErreur').style.display = 'block';
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
}
