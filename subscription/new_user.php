<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="../generic/generic.css" />
  		<link rel="stylesheet" media="screen" href="new_user.css" />
		<link rel="icon" type="image/png" href="../content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='../scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="../scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		
		<!--Autres scripts-->
		<script language='JavaScript' src='../scripts/generic.js'></script>
		<script language='JavaScript' src='../scripts/menu_manager.js'></script>
		<script language='JavaScript' src='new_user.js'></script>
  		<title>
			Identificator - Inscription
		</title>
	</head>
	<body onload="Hour();">
                <img id="image_fond" src="../content/images/background/fond.png" style="width:99%; height:99%;"/>
		<?php
			include_once(dirname(__FILE__). "/../generic/top.php");
			
			include_once(dirname(__FILE__). "/../core/presenters/subscription/class.NewUser_Presenter.php");
			$pres = new NewUser_Presenter();
                        
			$_SESSION['newuser_pres'] = serialize($pres);
		?>
		<script language='JavaScript'>
			InitHeader('../content/images/NewUser.png', "Bonjour, veuillez remplir les informations pour procéder à l'inscription", '', false);
		</script>
		<div id="content">
			<div id="menu" class="menu">
				<img id="menuImg1" class="menuImg" src="../content/images/menus/fleche_accueil.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                    onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                    style="cursor:pointer;"
                                                                                                                    onclick="javascript:window.location='../home.php'"/>
			
				<img id="menuImg2" class="menuImg" src="../content/images/menus/fleche_inscription.png" onmouseover="javascript:itemMenuOver(this)" 
                                                                                                                        onmouseout="javascript:itemMenuOver(this)" 
                                                                                                                        style="cursor:pointer;"
                                                                                                                        onclick="javascript:window.location='new_user.php'"/>
				<img id="menuImg3" class="menuImg" src="../content/images/menus/fleche_mail_disabled.png" />			
			</div>
			<form method="post" enctype="multipart/form-data" action="new_user.php">
				<div id="div_droite" class="div_droite" >
					<input type="file" name="FileUploadControl" id="FileUploadControl" style="width:135px;" accept="image/*" />
					<br />
					<div id="update_photo">
						<span id="StatusLabel" style="text-align:center;">
						<?php
						$result = false;
						if( isset($_POST['UploadButton']) ) // si formulaire soumis
							{
								$result = true;
								$content_dir = "../".$pres->getDirTemp();
								//$content_dir = '../content/TempToDelete/'; // dossier où sera déplacé le fichier
								
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
							else {
								echo "<img ID='img_photo' class='img_photo' src='../content/images/Default_black.png' />";
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
								<input type="text" name="login" id="login" maxlength="255" value="<?php echo $_POST["login"]; ?>"/>  
								<span class="aideForm">Votre identifiant.</span>
							</td>
						</tr>
						<tr>
							<td>
								Mot de passe : * 
							</td>
							<td>
								<input type="password" id="mdp" maxlength="32" name="mdp" value="<?php echo $_POST["mdp"]; ?>"/>
								<!--<asp:TextBox runat="server" ID="mdp" MaxLength="32" TextMode="Password"></asp:TextBox>-->
								<span class="aideForm">Votre mot de passe.</span>
							</td>
						</tr>
						<tr>
							<td>
								Confirmation : *
							</td>
							<td>
								<input type="password" id="mdpConfirm" maxlength="32" name="mdpConfirm" value="<?php echo $_POST["mdpConfirm"]; ?>" />
								<!--<asp:TextBox runat="server" ID="mdpConfirm" MaxLength="32" TextMode="Password"></asp:TextBox>-->
								<span class="aideForm">Répétez votre mot de passe.</span>
							</td>
						</tr>
						<tr>
							<td>
								Nom : *
							</td>
							<td>
								<input type="text" id="nom" maxlength="32"  name="nom" value="<?php echo $_POST["nom"]; ?>" />
								<!--<asp:TextBox runat="server" ID="nom" maxlength="32"></asp:TextBox>-->
								<span class="aideForm"></span>
							</td>
						</tr>
						<tr>
							<td>
								Prénom : *
							</td>
							<td>
								<input type="text" id="prenom" maxlength="32"  name="prenom" value="<?php echo $_POST["prenom"]; ?>" />
								<!--<asp:TextBox runat="server" ID="prenom" maxlength="32"></asp:TextBox>-->
								<span class="aideForm"></span>
							</td>
						</tr>
						<tr>
							<td>
								Adresse email : *
							</td>
							<td>
								<input type="text" id="mail" maxlength="64"  name="mail" value="<?php echo $_POST["mail"]; ?>" />
								<!--<asp:TextBox runat="server" ID="mail" maxlength="64"></asp:TextBox>-->
								<span class="aideForm">Une adresse email valide.</span>
							</td>
						</tr>
						<tr>
							<td>
								Confirmation : *
							</td>
							<td>
								<input type="text" id="mailConfirm" maxlength="32" name="mailConfirm" value="<?php echo $_POST["mailConfirm"]; ?>"  />
								<!--<asp:TextBox runat="server" ID="mailConfirm" maxlength="64"></asp:TextBox>-->
								<span class="aideForm">Répétez votre adresse email.</span>
							</td>
						</tr>
						<tr>
							<td>
								Site :
							</td>
							<td>
								<input type="text" id="site" maxlength="64" name="site" value="<?php echo $_POST["site"]; ?>"  />
								<!--<asp:TextBox runat="server" ID="site" maxlength="64"></asp:TextBox>-->
								<span class="aideForm">Si vous avez un site internet.</span>
							</td>
						</tr>
						<tr>
							<td>
								Département : *
							</td>
							<td>
								<!--<asp:DropDownList ID="listDep" runat="server"></asp:DropDownList>-->
								<select id="listDep" name="listDep"> 
								<?php
									foreach($pres->getRegionList() as $region){
                                                                            if( $region->getId().": ".$region->getName() ==  $_POST["listDep"]){
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
				<div id="updateDate">
					<p align="center">
						<input type="button" class="bouton" id="but_submit" value="Valider" onclick="envoiInscription()">
						<span id="espace" style="width:50px;"></span>
						<input type="button" class="bouton" id="but_cancel" value="Annuler">
					</p>
				
					<div id="divMessageErreur" class="divMessageErreur" style="display:none">
						
					</div>
				</div>
			</div>
			</form>
		</div>
		<?php
			include_once(dirname(__FILE__). "/../generic/footer.php");
		?>
	</body>
</html>
