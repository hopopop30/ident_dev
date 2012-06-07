<?php
	session_start();
        
        include_once(dirname(__FILE__). "/../core/managers/business/class.user.php");
        include_once(dirname(__FILE__). "/../core/presenters/personnal/class.Personnal_Presenter.php");
        
        $user = unserialize($_SESSION["current_user"]);

        if(!isset($user) || $user == ""){
            //header('index.php');
            echo "<script language='JavaScript'> window.location = '../home.php'; </script>";
        }
        
        $pres = new Personnal_Presenter($user->getId(), $user->getLogin());

        $_SESSION['personnal_pres'] = serialize($pres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="personnal.css" />
		<link rel="icon" type="image/png" href="../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
		<!--Autres scripts-->
		<script language='JavaScript' src='../scripts/generic.js'></script>
		<script language='JavaScript' src='../scripts/menu_manager.js'></script>
		<script language='JavaScript' src='personnal.js'></script>
  		<title>
			Identificator - Page personnelle
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../generic/top.php");
                        
                        $user_picture_dir = "../".$pres->getUserPictureDirectory();
                        
			if($user->getPhotoProfil() != ""){
                            echo "<input type='hidden' id='photo_profil' value='".$user_picture_dir.$user->getPhotoProfil()."' />";
                        }
                        else echo "<input type='hidden' id='photo_profil' value='../content/images/Default_white.png' />";
		?>
		<script language='JavaScript'>
			InitHeader(document.getElementById('photo_profil').value, "Modifiez vos données personnelles", '');
		</script>
		<div id="content">
			<div id="menu" class="menu">
				<img id="menuImg1" class="menuImg" src="../content/images/menus/fleche_menu.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                    style="cursor:pointer;"
                                                                                                                    onclick="javascript:window.location='../menu.php'"/>
			
				<img id="menuImg2" class="menuImg" src="../content/images/menus/fleche_GestionProfil.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='personnal.php'"/>
                        </div>
			<form method="post" enctype="multipart/form-data" action="personnal.php">
				<div id="div_droite" class="div_droite" >
					<input type="file" name="FileUploadControl" id="FileUploadControl" style="width:135px;" accept="image/*" />
					<br />
					<div id="update_photo">
						<span id="StatusLabel" style="text-align:center;">
						<?php
                                                    $result = false;
                                                    $content_dir = "../".$pres->getDirTemp();
                                                    $user_picture_dir = "../".$pres->getUserPictureDirectory();
                                                    
                                                    if( isset($_POST['UploadButton']) ) // si formulaire soumis
                                                    {
                                                        $result = true;
                                                        
                                                        $tmp_file = $_FILES['FileUploadControl']['tmp_name'];//--Nom du fichier temporaire

                                                        if( !is_uploaded_file($tmp_file) ) //--SI le fichier à bien été chargé
                                                        {
                                                            echo("Le fichier est introuvable");
                                                            $result = false;
                                                        }

                                                        $name_file = $_FILES['FileUploadControl']['name'];// on copie le fichier dans le dossier de destination

                                                        if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name_file) )//vérification hacking
                                                        {
                                                            echo("Nom de fichier non valide");
                                                        }
                                                        else if( !move_uploaded_file($tmp_file, $content_dir . $name_file) && $result ) //--SI le fichier à bien été uploadé
                                                        {
                                                            echo("Impossible de copier le fichier dans $content_dir");
                                                            $result = false;
                                                        }

                                                        if($result){
                                                            echo "Le fichier est chargé";
                                                        }
                                                    }
                                                    else echo "Sélectionnez un fichier: taille < 2Mo";
						?>
						</span>
						<br />
						<div id="panel_photo" class="div_photo">
							<?php
							
							if($result){
                                                            echo "<img ID='img_photo' class='img_photo' src='".$content_dir.$_FILES['FileUploadControl']['name']."'/>";
                                                            echo "<input type='hidden' id='hiddenPhoto' value='".$_FILES['FileUploadControl']['name']."' />";
							}
                                                        else if($pres->getUser()->getPhotoProfil() != "" ){
                                                            echo "<img ID='img_photo' class='img_photo' src='".$user_picture_dir.$pres->getUser()->getPhotoProfil()."'/>";
                                                            echo "<input type='hidden' id='hiddenPhoto' value='".$pres->getUser()->getPhotoProfil()."' />";
                                                        }
							else {
                                                            echo "<img ID='img_photo' class='img_photo' src='../content/images/Default_Black.png' />";
                                                            echo "<input type='hidden' id='hiddenPhoto' value='Default_white.png' />";
							}
							?>
						</div>
					</div>
					<input type="submit" name="UploadButton" id="UploadButton" value="Charger" class="bouton boutonTest"/>
				</div>
			<div id="divFormInscription" class="divCommunes">
				<table>
					<tbody>
						<tr>
							<td>
								Login : * 
							</td>
							<td>
                                                            <?php
                                                                //--Si il y a un login dans le post
                                                                if(isset($_POST["login"])){
                                                                    echo "<input type='text' name='login' id='login' maxlength='255' disabled='disabled'  value='".$_POST["login"]."'/>";  
                                                                }//--Sinon rechercher dans la base
                                                                else if($pres->getUser()->getLogin() != ""){
                                                                    echo "<input type='text' name='login' id='login' maxlength='255' disabled='disabled' value='".$pres->getUser()->getLogin()."'/>";
                                                                }//--Sinon rien
                                                                else echo "<input type='text' name='login' id='login' maxlength='255' disabled='disabled' />";
                                                            ?>
								<span class="aideForm">Votre identifiant.</span>
							</td>
						</tr>
						<tr>
							<td>
								Nom : *
							</td>
							<td>
                                                            <?php
                                                                //--Si il y a un login dans le post
                                                                if(isset($_POST["nom"])){
                                                                    echo "<input type='text' name='nom' id='nom' maxlength='255' value='".$_POST["nom"]."'/>";  
                                                                }//--Sinon rechercher dans la base
                                                                else if($pres->getUser()->getNom() != ""){
                                                                    echo "<input type='text' name='nom' id='nom' maxlength='255' value='".$pres->getUser()->getNom()."'/>";
                                                                }//--Sinon rien
                                                                else echo "<input type='text' name='nom' id='nom' maxlength='255' />";
                                                            ?>
								<span class="aideForm"></span>
							</td>
						</tr>
						<tr>
							<td>
								Prénom : *
							</td>
							<td>
                                                            <?php
                                                                //--Si il y a un login dans le post
                                                                if(isset($_POST["prenom"])){
                                                                    echo "<input type='text' name='prenom' id='prenom' maxlength='255' value='".$_POST["prenom"]."'/>";  
                                                                }//--Sinon rechercher dans la base
                                                                else if($pres->getUser()->getPrenom() != ""){
                                                                    echo "<input type='text' name='prenom' id='prenom' maxlength='255' value='".$pres->getUser()->getPrenom()."'/>";
                                                                }//--Sinon rien
                                                                else echo "<input type='text' name='prenom' id='prenom' maxlength='255' />";
                                                            ?>
								<span class="aideForm"></span>
							</td>
						</tr>
                                                <tr>
							<td>
								Email :
							</td>
							<td>
                                                            <?php
                                                                //--Si il y a un login dans le post
                                                                if(isset($_POST["email"])){
                                                                    echo "<input type='text' name='email' id='email' disabled='disabled' maxlength='255' value='".$_POST["email"]."'/>";  
                                                                }//--Sinon rechercher dans la base
                                                                else if($pres->getUser()->getEmail() != ""){
                                                                    echo "<input type='text' name='email' id='email' maxlength='255' disabled='disabled' value='".$pres->getUser()->getEmail()."'/>";
                                                                }//--Sinon rien
                                                                else echo "<input type='text' name='email' id='email' maxlength='255' disabled='disabled' />";
                                                            ?>
								<span class="aideForm">Votre adresse email.</span>
							</td>
						</tr>
						<tr>
							<td>
								Site :
							</td>
							<td>
                                                            <?php
                                                                //--Si il y a un login dans le post
                                                                if(isset($_POST["site"])){
                                                                    echo "<input type='text' name='site' id='site' maxlength='255' value='".$_POST["site"]."'/>";  
                                                                }//--Sinon rechercher dans la base
                                                                else if($pres->getUser()->getSite() != ""){
                                                                    echo "<input type='text' name='site' id='site' maxlength='255' value='".$pres->getUser()->getSite()."'/>";
                                                                }//--Sinon rien
                                                                else echo "<input type='text' name='site' id='site' maxlength='255' />";
                                                            ?>
								<span class="aideForm">Si vous avez un site internet.</span>
							</td>
						</tr>
						<tr>
							<td>
								Département : *
							</td>
							<td>
								<select id="listDep" name="listDep"> 
								<?php
                                                                
									foreach($pres->getRegionList() as $region){
                                                                            if( $region->getId().": ".$region->getName() ==  $_POST["listDep"]){
                                                                                echo "<option id='region_".$region->getId()."' selected='selected'>".$region->getId().": ".$region->getName()."</option>";
                                                                            }
                                                                            else if ( $region->getId() ==  $pres->getUser()->getDepartement()){
                                                                                echo "<option id='region_".$region->getId()."' selected='selected'>".$region->getId().": ".$region->getName()."</option>";
                                                                            }
                                                                            else echo "<option id='region_".$region->getId()."'>".$region->getId().": ".$region->getName()."</option>";
									}
								?>
								</select>
								<span class="aideForm">votre département.</span>
							</td>
						</tr>
						<tr>
							<td>
								<span class="aideForm">* Champs obligatoires.</span>
							</td>
						</tr>
					</tbody>
				</table>
				<div id="boutons_traitement">
					<p align="center">
						<input type="button" class="bouton" id="but_submit" value="Valider" onclick="envoiInscription()">
						<span id="espace" style="width:50px;"></span>
						<input type="button" class="bouton" id="but_cancel" value="Annuler">
					</p>
				
				</div>
                            <div id="notification" >
                                <p id="text_notification" style="text-align:center;"></p>
                            </div>
			</div>
			</form>
                    
		</div>
		<?php
			include_once(dirname(__FILE__). "/../generic/footer.php");
		?>
	</body>
</html>
