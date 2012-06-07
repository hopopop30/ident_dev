//script jQuery à exécuter quand le DOM est chargé
$(document).ready(function(){
	getTable();
});

function getTable(){
    noeud = document.getElementById('table_central_tbody');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    
    var data = "nav=getAllBadPics";
    var liste = ajaxSend(data);
    
    data = "nav=getAllOrders";
    var orders = ajaxSend(data);
    
    if(liste == "aucune_image"){
        notification("Aucune photo n'est sans ordre", false);
    }
    else{
    liste.forEach(function(i){
        var tr = document.createElement('TR');
        
        var tdLoupe = document.createElement('TD');
        var lienLight = document.createElement('A');
        var imdLoupe = document.createElement('IMG');
        imdLoupe.setAttribute('src', '../../content/images/loupe80.png');
        tdLoupe.setAttribute('class','tiny');
        var dir = document.getElementById('siteAddress').value  + document.getElementById('pictureDir').value;
        lienLight.setAttribute('href',dir+"/"+ i.chem);
        lienLight.setAttribute('class',"'light'");
        lienLight.setAttribute('rel', 'lightbox');
        lienLight.setAttribute('title', i.date + "-" + i.lieu);
        lienLight.appendChild(imdLoupe);
        tdLoupe.appendChild(lienLight);
        
        var tdUtil = document.createElement('TD');
        var util = document.createTextNode(i.util);
        tdUtil.setAttribute('class','big');
        tdUtil.appendChild(util);
        
        var tdDate = document.createElement('TD');
        var date = document.createTextNode(i.date);
        tdDate.setAttribute('class','small');
        tdDate.appendChild(date);
        
        var tdLieu = document.createElement('TD');
        var lieu = document.createTextNode(i.lieu);
        tdLieu.setAttribute('class','small');
        tdLieu.appendChild(lieu);
        
        var tdOrder = document.createElement('TD');
        var orderSelect = document.createElement('SELECT');
        orderSelect.setAttribute('id', "select_"+i.id);
        orderSelect.setAttribute('class', "selectAGauche");
        var option0 = document.createElement('OPTION');
        option0.appendChild(document.createTextNode("Sélectionnez"));
        orderSelect.appendChild(option0);
        var imgOk = document.createElement('IMG');
        imgOk.setAttribute('src', '../../content/images/ok.png');
        imgOk.setAttribute('class', 'imageADroite');
        imgOk.setAttribute('onclick', "validOrder('" + i.id +"'); getTable();");
        
        orders.forEach(function(o){
            var option = document.createElement('OPTION');
            option.setAttribute('value', o.id);
            option.setAttribute('id', 'select_'+i.id);
            option.appendChild(document.createTextNode(o.nom));
            orderSelect.appendChild(option);
        });
        
        tdOrder.setAttribute('class','medium');
        tdOrder.appendChild(orderSelect);
        tdOrder.appendChild(imgOk);
        
        var tdSup = document.createElement('TD');
        var imgSup = document.createElement('IMG');
        imgSup.setAttribute('src', '../../content/images/nok.png');
        imgSup.setAttribute('class', 'imgSup');
        imgSup.setAttribute('onclick', "deleteImage('" + i.id +"','"+ i.chem +"'); getTable();");
        tdSup.setAttribute('class','tiny');
        tdSup.appendChild(imgSup);
        
        tr.appendChild(tdLoupe);
        tr.appendChild(tdUtil);
        tr.appendChild(tdDate);
        tr.appendChild(tdLieu);
        tr.appendChild(tdOrder);
        tr.appendChild(tdSup);
        
        document.getElementById('table_central_tbody').appendChild(tr);
    });
    }
}
function ajaxSend(data){
    var donnee;
    $.ajax({
        type: 'POST',
        url: 'set_order_to_pics.behind.php',
        data: data,
        async: false,
        success: function(data) {
            donnee = eval('('+ data +')');
        }
    });
    return donnee;
}

function deleteImage(numPic, chem){
    var donnees = "nav=deleteImage&img="+numPic+"&chem="+chem;
    $.ajax({
        type: 'POST',
        url: 'set_order_to_pics.behind.php',
        data: donnees,
        async: false,
        success: function(data) {
            donnee = eval('('+ data +')');
            if(donnee == "supOk"){
                notification('Photo supprimée', false);
            }else{
                notification("Erreur lors de la suppression de la photo", true);
            }
        }
    });
}
function validOrder(id){
    var select = document.getElementById('select_'+id);
    if(select.value == "Sélectionnez"){
        alert("Sélectionnez un ordre");
    }
    else{
        data = "nav=validOrder&imgId="+id+"&orderId="+select.value;
        var ok = ajaxSend(data);
        if(ok == "updateOk"){
            notification("Le nouvel ordre à été mis à jour pour cette photo.", false)
        }else{
            notification("Erreur lors de la mise à jour du nouvel ordre.", true)
        }
    }
    
}

function notification(text, error){
    noeud = document.getElementById('text_notification');while (noeud.firstChild){noeud.removeChild(noeud.firstChild);}
    
    var not = document.getElementById("text_notification");
    not.appendChild(document.createTextNode(text));
    if(error == true){
        not.setAttribute("class", "red");
    }
    else{
        not.setAttribute("class", "green");
    }
}


