<?php
	session_start();
        include_once(dirname(__FILE__). "/../../core/managers/business/class.user.php");
	include_once(dirname(__FILE__). "/../../core/presenters/administration/userAdministration/class.userAdministration_Presenter.php");

        $user = unserialize($_SESSION["current_user"]);

        if((!isset($user) || $user == "")|| $user->getAdmin() == 0){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = '../../home.php'; </script>";
        }
        $pres = new UserAdministration_Presenter($user->getId());
        $_SESSION['useradmin_pres'] = serialize($pres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="admin_users.css" />
		<link rel="icon" type="image/png" href="../../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
		<!--Autres scripts-->
		<script language='JavaScript' src='../../scripts/generic.js'></script>
		<script language='JavaScript' src='../../scripts/menu_manager.js'></script>
		<script language='JavaScript' src='admin_users.js'></script>
  		<title>
			Identificator - Administration des utilisateurs
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../../generic/top_level2.php");
			
                        $user_picture_dir = "../../".$pres->getUserPictureDirectory();
                        
			if($user->getPhotoProfil() != ""){
                            echo "<input type='hidden' id='photo_profil' value='".$user_picture_dir.$user->getPhotoProfil()."' />";
                        }
                        else echo "<input type='hidden' id='photo_profil' value='../../content/images/Default_white.png' />";
		?>
		<script language='JavaScript'>
			InitHeader(document.getElementById('photo_profil').value, "Administration des utilisateurs ...", '... voici la liste des utilisateurs', true);
		</script>
		 <div id="content">
			<div id="menu" class="menu">
				<img id="menuImg1" class="menuImg" src="../../content/images/menus/fleche_menu.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                    style="cursor:pointer;"
                                                                                                                    onclick="javascript:window.location='../../menu.php'"/>
			
				<img id="menuImg2" class="menuImg" src="../../content/images/menus/fleche_admin.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='../administration.php'"/>
			
				<img id="menuImg2" class="menuImg" src="../../content/images/menus/fleche_utilisateurs.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='admin_users.php'"/>
			</div>
			<div id="div_middle" class="div_middle">
				<span id='label_Info' class='label_Info'>
                                    
				</span>
                            
                                <?php
                                    $userList = $pres->getAllUser();
                                    
                                    foreach($userList as $user){
                                        echo "<div class='user' id='user_".$user->getId()."'>
                                                <div class='photo_usr'>
                                                    <img src='".$user_picture_dir.$user->getPhotoProfil()."'/>
                                                    <div class='infos_usr'>
                                                        <table class='table_pres'><tbody>
                                                            <tr><td>Login : </td><td><input id='login_".$user->getId()."' value='".$user->getLogin()."' /></td>
                                                                <td>Email : </td><td><input id='email_".$user->getId()."' value='".$user->getEmail()."' /></td></tr>
                                                            <tr><td>Nom : </td><td><input id='nom_".$user->getId()."' value='".$user->getNom()."' /></td>
                                                                <td>Prénom : </td><td><input id='prenom_".$user->getId()."' value='".$user->getPrenom()."' /></td></tr>
                                                            <tr><td>Inscription : </td><td><input id='datecrea_".$user->getId()."' value='".$user->getDateCreation()."' disabled='disabled' /></td>
                                                                <td>Site : </td><td><input id='site_".$user->getId()."' value='".$user->getSite()."' /></td></tr>
                                                            <tr><td>Département : </td><td><select id='dep_".$user->getId()."' id='listDep' name='listDep'> ";
                                                            foreach($pres->getRegionList() as $region){
                                                                if( $region->getId() ==  $user->getDepartement()){
                                                                    echo "<option id='region_".$region->getId()."' selected='selected'>".$region->getId().": ".$region->getName()."</option>";
                                                                }
                                                                else{
                                                                    echo "<option id='region_".$region->getId()."'>".$region->getId().": ".$region->getName()."</option>";
                                                                }
                                                            }
                                                    echo "</select></td></tr></tbody></table> 
                                                    </div>
                                                    <div class='traitement_usr'>
                                                        Est actif : ";
                                                        if($user->getActif() == 1){
                                                            echo "<input id='checkActif_".$user->getId()."' type='checkbox' checked='checked'/> ";
                                                        }
                                                        else{
                                                            echo "<input id='checkActif_".$user->getId()."' type='checkbox' /> ";
                                                        }
                                                       echo "Est admin : ";
                                                        if($user->getAdmin() == 1){
                                                            echo "<input id='checkAdmin_".$user->getId()."' type='checkbox' checked='checked'/> ";
                                                        }
                                                        else{
                                                            echo "<input id='checkAdmin_".$user->getId()."' type='checkbox' /> ";
                                                        }
                                             echo "     <input type='button' id='mod_".$user->getId()."' onclick='update(".$user->getId().")' Value='Modifier' class='bouton bout_sup' /> 
                                                        <input type='button' id='sup_".$user->getId()."' onclick='del(".$user->getId().")' Value='Supprimer' class='bouton bout_mod' />      
                                                    </div>
                                                    
                                                </div>
                                              </div>";
                                    }
                                ?>
                            
				<span id="label_error" class="label_error"></span>
			</div>
		</div>
		<?php
			include_once(dirname(__FILE__). "/../../generic/footer_level2.php");
		?>
	</body>
</html>
