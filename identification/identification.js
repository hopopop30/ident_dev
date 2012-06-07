//script jQuery à exécuter quand le DOM est chargé
$(document).ready(function(){
	ListeSuperFamille();
	ListeFamilleSansSuperFamille();
});

//--------------------------------------------------------------Fonciton génériques------------------------------------------------------*/
function reinit(){
    ListeSuperFamille();
    ListeFamilleSansSuperFamille();

    var noeud = document.getElementById('photoNumber');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    noeud = document.getElementById('photoTotal');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    //--Vide tous les champs en aval
    noeud = document.getElementById('select_sousfamille');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    noeud = document.getElementById('select_tribu');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    noeud = document.getElementById('select_genre');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    noeud = document.getElementById('select_sousGenre');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    noeud = document.getElementById('select_espece');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    noeud = document.getElementById('span_date');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    noeud = document.getElementById('span_lieu');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
        
    document.getElementById("champ_descripteur").value= "";
    document.getElementById("champ_annee").value= "";
    document.getElementById("champ_nomVernaculaire").value= "";
    
       $('#notification_photo').attr("style", "display:none;");
   /*document.getElementById("num_leraut_97").setAttribute("value", "");
    document.getElementById("num_robineau").setAttribute("value", "");
    document.getElementById("num_karsholt_96").setAttribute("value", "");*/
}
function ajaxSend(data){
    var donnee;
    $.ajax({
        type: 'POST',
        url: 'identification.behind.php',
        data: data,
        async: false,
        success: function(data) {
            donnee = eval('('+ data +')');
        }
    });
    return donnee;
}

function rempliSelect(nomSelect, ident, liste, effacerOuiNon, fonctionCascade){
    var select = document.getElementById(nomSelect);
    if(effacerOuiNon == true){
        while (select.firstChild){select.removeChild(select.firstChild);}
    }
    //--Si remplacement
    if(effacerOuiNon == true){
        //--Si laliste contient des éléments
        if(!(liste == null || (liste.length == 1 && liste[0]['id'] == null))){
            
            //--Si la liste contient plus d'un élément
            if(liste.length > 1){
                var optionSelectionnez = document.createElement('OPTION');
                optionSelectionnez.setAttribute('id', ident + '_Sélectionnez');
                optionSelectionnez.appendChild(document.createTextNode('Sélectionnez'));
                select.appendChild(optionSelectionnez);
            }
            
            for(var i = 0; i < liste.length; i++){
                var option = document.createElement('OPTION');
                option.setAttribute('id', ident + '_' + liste[i]['id']);
                option.setAttribute('value', liste[i]['id']);
                option.appendChild(document.createTextNode(liste[i]['nom']));
                select.appendChild(option);
            }
        }
        //--Si la liste est vide
        else{
            var optionAucun = document.createElement('OPTION');
            optionAucun.setAttribute('id', ident + '_Aucun résultat');
            optionAucun.appendChild(document.createTextNode('Aucun résultat'));
            select.appendChild(optionAucun);
        }
        
        if(liste.length == 1 && fonctionCascade != null){
            fonctionCascade();
        }
    }
    //--Si pas remplecement: sélection
    else{
        var optionSelected = document.getElementById(ident + '_' + liste[0]['id']);
        optionSelected.setAttribute('selected', 'selected');
    }
}

//----------------------------IDENTIFICATION--------------------------
function ListeSuperFamille(){
    var data = "nav=superFamille";
    var listeSuperFamille = ajaxSend(data);
    
    rempliSelect('select_superfamille', 'supFam', listeSuperFamille, true, null);
}

function ListeSuperFamilleParFamille(){
    var idFam = document.getElementById("fam_" + document.getElementById('select_famille').value).value;
    var data = "nav=superFamilleParFamille&idFam="+idFam;
    var listeSuperFamille = ajaxSend(data);
    
    rempliSelect('select_superfamille', 'supFam', listeSuperFamille, true, null);
}

function ListeFamilleSansSuperFamille(){
    var data = "nav=FamilleSeules";
    var listeFamille = ajaxSend(data);
    
    rempliSelect('select_famille', 'fam', listeFamille, true, null);
}

function ListeFamille(){
    ///--Efface les champs inférieur
    var select = document.getElementById("select_sousfamille"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_tribu"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_genre"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_sousGenre"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_espece"); while (select.firstChild){select.removeChild(select.firstChild);}
    document.getElementById("champ_descripteur").value= "";
    document.getElementById("champ_annee").value= "";
    document.getElementById("champ_nomVernaculaire").value= "";
    
    var idFam = document.getElementById("supFam_" + document.getElementById('select_superfamille').value).value;
    var data = "nav=Famille&idFam="+idFam;
    var listeFamille = ajaxSend(data);
    
    rempliSelect('select_famille', 'fam', listeFamille, true, ListeSousFamille);
}

function ListesSuperFamilleEtSousFamille(){
    ListeSuperFamilleParFamille();
    ListeSousFamille();
}

function ListeSousFamille(){
    ///--Efface les champs inférieur
    var select = document.getElementById("select_tribu"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_genre"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_sousGenre"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_espece"); while (select.firstChild){select.removeChild(select.firstChild);}
    document.getElementById("champ_descripteur").value= "";
    document.getElementById("champ_annee").value= "";
    document.getElementById("champ_nomVernaculaire").value= "";
    
    var idSupFam = document.getElementById("supFam_" + document.getElementById('select_superfamille').value).value;
    var idFam = document.getElementById("fam_" + document.getElementById('select_famille').value).value;
    var data = "nav=sousFamille&idFam="+idFam+"&idSupFam="+idSupFam;
    var listeFamille = ajaxSend(data);
    
    rempliSelect('select_sousfamille', 'sousFam', listeFamille, true, ListeTribu);
}
function ListeTribu(){
    ///--Efface les champs inférieur
    var select = document.getElementById("select_genre"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_sousGenre"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_espece"); while (select.firstChild){select.removeChild(select.firstChild);}
    document.getElementById("champ_descripteur").value= "";
    document.getElementById("champ_annee").value= "";
    document.getElementById("champ_nomVernaculaire").value= "";
    
    var idSousFam = document.getElementById("sousFam_" + document.getElementById('select_sousfamille').value).value;
    var data = "nav=tribu&idSousFam="+idSousFam;
    var listeTribu = ajaxSend(data);
    
    rempliSelect('select_tribu', 'tribu', listeTribu, true, ListeGenre);
}

function ListeGenre(){
    ///--Efface les champs inférieur
    var select = document.getElementById("select_sousGenre"); while (select.firstChild){select.removeChild(select.firstChild);}
    select = document.getElementById("select_espece"); while (select.firstChild){select.removeChild(select.firstChild);}
    document.getElementById("champ_descripteur").value= "";
    document.getElementById("champ_annee").value= "";
    document.getElementById("champ_nomVernaculaire").value= "";
    
    var idTribu = document.getElementById("tribu_" + document.getElementById('select_tribu').value).value;
    var data = "nav=genre&idTribu="+idTribu;
    var listeGenre = ajaxSend(data);
    
    rempliSelect('select_genre', 'genre', listeGenre, true, ListeSousGenre);
}

function ListeSousGenre(){
    ///--Efface les champs inférieur
    var select = document.getElementById("select_espece"); while (select.firstChild){select.removeChild(select.firstChild);}
    document.getElementById("champ_descripteur").value= "";
    document.getElementById("champ_annee").value= "";
    document.getElementById("champ_nomVernaculaire").value= "";
    
    var idGenre = document.getElementById("genre_" + document.getElementById('select_genre').value).value;
    var data = "nav=sousGenre&idGenre="+idGenre;
    var listeSsGenre = ajaxSend(data);
    
    rempliSelect('select_sousGenre', 'sousGenre', listeSsGenre, true, ListeEspece);
}

function ListeEspece(){
    ///--Efface les champs inférieur
    document.getElementById("champ_descripteur").value= "";
    document.getElementById("champ_annee").value= "";
    document.getElementById("champ_nomVernaculaire").value= "";
    
    var idSsGenre = document.getElementById("sousGenre_" + document.getElementById('select_sousGenre').value).value;
    var data = "nav=espece&idSousGenre="+idSsGenre;
    var listeEspece = ajaxSend(data);
    
    rempliSelect('select_espece', 'espece', listeEspece, true, rempliInfos);
}

function rempliInfos(){
    var idEspece = document.getElementById("espece_" + document.getElementById('select_espece').value).value;
    var data = "nav=infos&idEspece="+idEspece;
    var Infos = ajaxSend(data);
    
    document.getElementById('champ_descripteur').value = Infos['Descripteur'];
    document.getElementById('champ_annee').value = Infos['annee'];
    document.getElementById('champ_nomVernaculaire').value = Infos['nomVernaculaire'];
    
    
    //rempliSelect('select_espece', 'espece', listeEspece, true, rempliInfos);
}

//--Validation ou mauvais ordre
function validation(){
    //--Controle de surface, vérification que tous les champs soient bien remplis
    if(document.getElementById('select_superfamille').value == "" 
        || document.getElementById('select_superfamille').value == "Sélectionnez"
        || document.getElementById('select_superfamille').value == "Aucun résultat"){alert("Sélectionnez une superfamille");}
    else if(document.getElementById('select_famille').value == "" 
        || document.getElementById('select_famille').value == "Sélectionnez"
        || document.getElementById('select_famille').value == "Aucun résultat"){alert("Sélectionnez une famille");}
    else if(document.getElementById('select_sousfamille').value == "" 
        || document.getElementById('select_sousfamille').value == "Sélectionnez"
        || document.getElementById('select_sousfamille').value == "Aucun résultat"){alert("Sélectionnez une sous-famaille");}
    else if(document.getElementById('select_tribu').value == "" 
        || document.getElementById('select_tribu').value == "Sélectionnez"
        || document.getElementById('select_tribu').value == "Aucun résultat"){alert("Sélectionnez une tribu");}
    else if(document.getElementById('select_genre').value == "" 
        || document.getElementById('select_genre').value == "Sélectionnez"
        || document.getElementById('select_genre').value == "Aucun résultat"){alert("Sélectionnez un genre");}
    else if(document.getElementById('select_sousGenre').value == "" 
        || document.getElementById('select_sousGenre').value == "Sélectionnez"
        || document.getElementById('select_sousGenre').value == "Aucun résultat"){alert("Sélectionnez un sous-genre");}
    else if(document.getElementById('select_espece').value == "" 
        || document.getElementById('select_espece').value == "Sélectionnez"
        || document.getElementById('select_espece').value == "Aucun résultat"){alert("Sélectionnez une espèce");}
    else{
        //--traitements
        var nav = "nav=valid";
        var test = ajaxSend(nav);
        if(test == "Ok"){
            alert("La photo à étée identifiée.");
            nextPic();
        }
        else{
            alert("Une erreur est survenue lors du traitement de la validation.");
        }
    }
    
}
function mauvaisOrdre(){
    if(confirm("Etes-vous sur de vouloir déclarer cette photo comme étant de mauvais ordre ?")){
        var nav = "nav=badOrder";
        var test = ajaxSend(nav);
        if(test == "Ok"){
            alert("La photo va prochainement être déplacée vers l'ordre qui lui correspond.");
            nextPic();
        }
        else{
            alert("Une erreur est survenue lors du traitement de la déclaration de mauvais ordre.");
        }
    }
}

//--------------------------------------------------------------gestion des fleches et des images------------------------------------------------------*/
function check_vue_change(){
    var check = document.getElementById('check_photos_vues').checked;
    
    var nav = "nav=rechargerliste&nonVue="+check;
    var retour = ajaxSend(nav);
    
    reinit();
    
    chargementPhoto(retour);
}
function nextPic(){
    var nav = "nav=nextPic";
    var retour = ajaxSend(nav);
    
    reinit();
    
    chargementPhoto(retour);
}
function prevPic(){
    var nav = "nav=prevPic";
    var retour = ajaxSend(nav);
    
    reinit();
    
    chargementPhoto(retour);
}
function chargementPhoto(retour){
    if(retour != "empty"){
        var img = retour['img'];
        var lieu = retour['lieu'];
        var date = retour['date'];
        var ident = retour['ident'];
        
        var nbrPhoto = retour['nbr'];
        var totalPhoto = retour['total'];

        if(ident == 1){
            $('#notification_photo').attr("style", "display:block;");
        }
        var dir = document.getElementById('siteAddress').value  + document.getElementById('pictureDir').value;
        $('#lien_img_principale').attr("href", dir+"/"+img);
        $('#lien_img_principale').attr('rel', 'lightbox');
        $('#img_pricipale').attr("src", dir+"/"+img);
        
        $('#span_date').append(document.createTextNode(date));
        $('#span_lieu').append(document.createTextNode(lieu)); 
        $('#photoNumber').append(document.createTextNode(nbrPhoto)); 
        $('#photoTotal').append(document.createTextNode(totalPhoto)); 
    }
    else {
        $('#img_pricipale').attr("src", "../content/images/folder_empty.png");
        $('#photoNumber').append(document.createTextNode("0")); 
        $('#photoTotal').append(document.createTextNode("0")); 
    }
}
function flecheOverD(){	
	$('#flecheD').attr("src", "../content/images/droite_papillon.png");
}
function flecheOverG(){	
	$('#flecheG').attr("src", "../content/images/gauche_papillon.png");
}
function flecheOutD(){
	$('#flecheD').attr("src", "../content/images/droite_simple.png");
}
function flecheOutG(){
	$('#flecheG').attr("src", "../content/images/gauche_simple.png");
}


