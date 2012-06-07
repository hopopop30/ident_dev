//script jQuery à exécuter quand le DOM est chargé
$(document).ready(function(){
    //var folder = recupFolder();
    initUpload();
    $( "#inputDate" ).datepicker();
    autocopletionLieux();
});

//--Initailisé dans le cas ou aucun d"pot n'est créé"
var tempFolder = "../" + $('#hiddenTempFolder').val() + "depot_Anonyme";


function initUpload(){
    
    //--Initialisation du module
    $('#file_upload').uploadify({
        'uploader'    : '../content/UploadComponent/uploadify.swf',
        'script'      : '../content/UploadComponent/uploadify.php',
        'cancelImg'   : '../content/UploadComponent/cancel.png',
        'folder'      : '../' + tempFolder,
        'multi'       : true,
        'fileExt'     : '*.jpg;*.gif;*.png',
        'fileDesc'    : 'Image Files (.JPG, .GIF, .PNG)',  
        'buttonText'  : 'Selection photos',
        'onAllComplete' : function(event,data) {
            uploadCompleted(data);
        },
        'onError'     : function (event,ID,fileObj,errorObj) {
            //alert(errorObj.type + ' Erreur: ' + errorObj.info);
            notification(errorObj.type + ' Erreur: ' + errorObj.info, true);
        }
    });

    //editExtensions();
}

function editRepertoire(){

    var nav="recupFolder";
    var value = "nav="+nav;

    //--Lancement ajax
    $.ajax({
        type: 'POST',
        url: 'uploadPictures.behind.php',
        data: value,
        async: false,
        success: function(data) {
            var donnee = eval('('+ data +')');

            //--Initialisation du module
            $('#file_upload').uploadifySettings('folder', donnee);
            
            tempFolder = donnee;
        }
    });
}

function chargementPhotos(){
    viderNotification();
    if($('#selectOrdre').val() != "Choisissez un ordre"){
        if($('#inputDate').val() != "" && $('#inputLieu').val() != ""){

            //--Changement de répertoire à chaque chargement.
            editRepertoire();

            //--Upload des fichiers
            $('#file_upload').uploadifyUpload();
        }
        else {
            notification("Veuillez entrer une date et un lieu.", true);
        }
    }
    else{
        notification("Veuillez sélectionner un ordre.", true);
    }
}

function uploadCompleted(fichiers){
    //--Traitement des fichiers---------
    var nav="uploadCompleted";
    var ordreSel = $('#selectOrdre').val();
    var dateSel = $('#inputDate').val();
    var lieuSel = $('#inputLieu').val();
    var folder = tempFolder;

    var value = "nav="+nav+"&ordre="+ordreSel+"&date="+dateSel+"&lieu="+lieuSel+"&nbrPhotos="+fichiers.filesUploaded+"&tempFolder="+folder;

    //--Lancement ajax
    $.ajax({
        type: 'POST',
        url: 'uploadPictures.behind.php',
        data: value,
        async: false,
        success: function(data) {

            var donnee = eval('('+ data +')');
            var erreur = false;

            //--Parcours du tableau d'erreur
            for(var i = 0; i<5; i++){
                if(donnee[i] != 0){
                    erreur = true;
                }
            }
            //--Si le retour est ok
            if(erreur == false){
                //--Affichage succés
                notification(fichiers.filesUploaded + " fichier(s) chargé(s) avec succés !", false);
                document.getElementById('inputDate').value = "";
                document.getElementById('inputLieu').value = "";
                
            }
            else{
                //--Sinon
                notification("Un problème est survenu lors du traitement de vos photographies.", true);
            }
        }
    });
}

function autocopletionLieux() {

    var nav="autocompleteLieu";

    var value = "nav="+nav;

    //--Lancement ajax
    $.ajax({
        type: 'POST',
        url: 'uploadPictures.behind.php',
        data: value,
        async: false,
        success: function(data) {

            var donnee = eval('('+ data +')');

            var availableTags = [];
            for(var i=0; i<donnee.length; i++){
                availableTags[i] = donnee[i];
            }
            $( "#inputLieu" ).autocomplete({
                source: availableTags
            });
        }
    });
}

function notification(text, error){
    viderNotification();
    
    var not = document.getElementById("text_notification");
    not.appendChild(document.createTextNode(text));
    if(error){
        not.setAttribute("class", "red");
    }
    else{
        not.setAttribute("class", "green");
    }
}

function viderNotification(){
    noeud = document.getElementById('text_notification');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    document.getElementById("text_notification").setAttribute('class', "");
}