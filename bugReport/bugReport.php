<?php
	session_start();
        include_once(dirname(__FILE__). "/../core/managers/business/class.user.php");

        $user = unserialize($_SESSION["current_user"]);

        if(!isset($user) || $user == ""){
            //header('index.php');
            //echo "<script language='JavaScript'> window.location = '../home.php'; </script>";
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="bugReport.css" />
		<link rel="icon" type="image/png" href="../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
		<!--Autres scripts-->
		<script language='JavaScript' src='../scripts/generic.js'></script>
		<script language='JavaScript' src='../scripts/menu_manager.js'></script>
  		<title>
			Identificator - Déclaration de bug
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../generic/top.php");
			
			include_once(dirname(__FILE__). "/../core/presenters/bugreport/class.BugReport_Presenter.php");
                        if(!isset($user) || $user == ""){
                            $pres = new BugReport_Presenter(null);
                            echo "<script language='JavaScript'>
                                InitHeader('../content/images/email-icon.png', 'Signalez un bug', '', false);
                            </script>";
                        }else{
                            $pres = new BugReport_Presenter($user);
                            echo "<script language='JavaScript'>
                                InitHeader('../content/images/email-icon.png', 'Signalez un bug', '', true);
                            </script>";
                        }
			//echo $pres->getRegionList();
			$_SESSION['bugreport_pres'] = serialize($pres);
		?>
		
		 <div id="content">
                        <?php
                        if(!isset($user) || $user == ""){
                            $pres = new BugReport_Presenter(null);
                            echo "<div id='menu' class='menu'>
				 <img id='menuImg1' class='menuImg' src='../content/images/menus/fleche_accueil.png' onmouseover='javascript:itemMenuOver(this)' 
                                                                                                                    onmouseout='javascript:itemMenuOver(this)' 
                                                                                                                    style='cursor:pointer;'
                                                                                                                    onclick='javascript:window.location=\"../menu.php\"'/>";
                        }else{
                            $pres = new BugReport_Presenter($user);
                            echo "<div id='menu' class='menu'>
				 <img id='menuImg1' class='menuImg' src='../content/images/menus/fleche_menu.png' onmouseover='javascript:itemMenuOver(this)' 
                                                                                                                    onmouseout='javascript:itemMenuOver(this)' 
                                                                                                                    style='cursor:pointer;'
                                                                                                                    onclick='javascript:window.location=\"../home.php\"'/>";
                        }
			?>	
			</div>
			<div id="div_middle" class="div_middle">
				<span id='label_Info' class='label_Info'>
                                    
                                    Sur quelle page le bug s'est il produit ?
                                    <br />
                                    <select id="select_page" name="select_page" >
                                        <option>Accueil</option>
                                        <option>Inscription</option>
                                        <option>Menu</option>
                                        <option>Modification des informations personnelles</option>
                                        <option>Ajout de photos</option>
                                        <option>Identification</option>
                                        <option>Administration</option>
                                        <option>Autre</option>
                                    </select>
                                    <br />
                                    <br />
                                    
                                    Pour reproduire le bug et le corriger, nous devons savoir quelles sont les différentes étapes et données entrées,
                                    pouvez-vous les énumérer ? (n'hésitez pas a donner un maximum d'informations):
                                    <br />
                                    <textarea id ="area_description" name="area_description" rows="3" cols="50"></textarea>
                                    <br />
                                    <br />
                                    
                                    Envoi : <input type="button" value ="Envoi" onclick="envoi()"></input>
                                    
				</span><br />
				<span id="label_error" class="label_error"></span>
			</div>
		</div>
		<?php
			include_once(dirname(__FILE__). "/../generic/footer.php");
		?>
	</body>
    <script type="text/javascript" >
        function envoi(){
            var nav = "envoireport";
            var page = document.getElementById("select_page").value;
            var desc = document.getElementById("area_description").value;
            var value = 'nav='+ nav + '&desc='+ desc + '&page='+ page;
            $.ajax({
                type: 'POST',
                url: 'bugreport.behind.php',
                data: value,
                success: function(data) {
                    var donnee = eval('('+ data +')');
                    if(donnee == "error"){
                        document.getElementById('divMessErreur').style.display = 'block';
                    }
                    else{
                        window.location = "../menu.php";
                    }
                }
            });
        }
    </script>
</html>
