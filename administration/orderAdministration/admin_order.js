function update(id){
    var login = document.getElementById("login_"+id).value;
    var email = document.getElementById("email_"+id).value;
    var nom = document.getElementById("nom_"+id).value;
    var prenom = document.getElementById("prenom_"+id).value;
    var site = document.getElementById("site_"+id).value;
    var dep = document.getElementById("dep_"+id).value;
    var check = document.getElementById("checkActif_"+id).checked;
    var check2 = document.getElementById("checkAdmin_"+id).checked;
    
    dep = dep.split(":")[0];
    
    var donnee;
    var data = "nav=modif&id="+id+"&login="+login+"&email="+email+"&nom="+nom+"&prenom="+prenom+"&site="+site+"&dep="+dep+"&check="+check+"&check2="+check2;
    
    $.ajax({
        type: 'POST',
        url: 'admin_users.behind.php',
        data: data,
        async: false,
        success: function(data) {
            donnee = eval('('+ data +')');
           
        }
    });
}

function del(id){
    if(confirm("Etes-vous sur de vouloir supprimer cet utilisateur ?")){
        var bloc = $("#user_"+id);
        var data = "nav=delete&id="+id;
    
        $.ajax({
            type: 'POST',
            url: 'admin_users.behind.php',
            data: data,
            async: false,
            success: function(data) {
                donnee = eval('('+ data +')');
                if(donnee == "Ok"){
                    bloc.fadeOut();
                }
            }
        });
        
    }
}
