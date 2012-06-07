<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  		<link rel="stylesheet" media="screen" href="home.css" />
		<link rel="icon" type="image/png" href="content/images/favicon.ico" />
		
		<!--JQUERY-->
		<script language='JavaScript' src='scripts/jquery-ui-1.8.6.custom/js/jquery-1.4.4.min.js'></script>
		<script language='JavaScript' src='scripts/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" title="style" href="scripts/jquery-ui-1.8.6.custom/css/ui-darkness/jquery-ui-1.8.6.custom.css" />	
		<script language='JavaScript'>
		function envoiLogin(){
                    var nav = "envoiLogin";

                    var login = document.getElementById('login').value;
                    var pass = document.getElementById('mdp').value;

                    if(login == ""){
                        document.getElementById('divMessErreur').style.display = 'block';
                    }
                    else if (pass == ""){
                        document.getElementById('divMessErreur').style.display = 'block';
                    }
                    else{
                        var value = 'nav='+ nav +'&login=' + login + '&mdp=' + pass;

                        $.ajax({
                            type: 'POST',
                            url: 'home.behind.php',
                            data: value,
                            async:  false,
                            success: function(data) {
                                var donnee = eval('('+ data +')');
                                if(donnee == "error"){
                                    document.getElementById('divMessErreur').style.display = 'block';
                                }
                                else{
                                    window.location = "menu.php";
                                }
                            }
                        });
                    }
		}
		</script>
  		<title>
			Identificator - Connexion
		</title>
	</head>
	<body>
		<div id="divBanniere" >
			<img style="visibility:hidden;width:0px;height:0px;" border=0 width=0 height=0 src="http://c.gigcount.com/wildfire/IMP/CXNID=2000002.0NXC/bT*xJmx*PTEzMDkwMDIzMzg3NDImcHQ9MTMwOTAwMjM*NTA3OCZwPTQ1NTkzMiZkPSZnPTEmbz1jNjRhZTVkYmQ3MjM*ZDZjOTM*/MWRkNzJmMjVhZjA5OCZvZj*w.gif" /><object id="embededBannersnackFlash_abb78c0cc8a398375456edd3b2745858" type="application/x-shockwave-flash" data="http://files.bannersnack.net/app/swf2/EmbedPlayerV2.swf?hash_id=abb78c0cc8a398375456edd3b2745858&amp;bgcolor=#FFFFFF&amp;clickTag=null&amp;t=1309002248" width="728" height="90"><param name="allowScriptAccess" value="always" /><param name="movie" value="http://files.bannersnack.net/app/swf2/EmbedPlayerV2.swf?hash_id=abb78c0cc8a398375456edd3b2745858&amp;bgcolor=#FFFFFF&amp;clickTag=null&amp;t=1309002248" /><param name="allowFullScreen" value="true" /><param name="bgcolor" value="#FFFFFF" /></object><noscript>To view this animated banner you need to have Flash Player 9 or newer installed and JavaScript enabled. BannerSnack is a professional, easy to use <a href="http://www.bannersnack.com/" title="BannerSnack - Free flash banner maker">banner maker</a> application.</noscript>
		</div>
		<div id="divTextPromo" class="divCommunes">
		<br/>
                    <?php
                        include_once(dirname(__FILE__). "/core/presenters/home/class.Home_Presenter.php");
                        $pres = new Home_Presenter();
                        echo $pres->getTextPromo();
                        $_SESSION['home_pres'] = serialize($pres);
                    ?>
		</div>
		<div id="divAnim" class="divCommunes">
                    <img style="visibility:hidden;width:0px;height:0px;" border=0 width=0 height=0 src="http://c.gigcount.com/wildfire/IMP/CXNID=2000002.0NXC/bT*xJmx*PTEzMDkwMDk1Mjc5ODkmcHQ9MTMwOTAwOTUzMzM1MSZwPTQ1NTkzMiZkPSZnPTEmbz1jNjRhZTVkYmQ3MjM*ZDZjOTM*/MWRkNzJmMjVhZjA5OCZvZj*w.gif" /><object id="embededBannersnackFlash_942a542f5ffe265e0fc90396b2746028" type="application/x-shockwave-flash" data="http://files.bannersnack.net/app/swf2/EmbedPlayerV2.swf?hash_id=942a542f5ffe265e0fc90396b2746028&amp;bgcolor=#FFFFFF&amp;clickTag=null&amp;t=1309009460" width="728" height="300"><param name="allowScriptAccess" value="always" /><param name="movie" value="http://files.bannersnack.net/app/swf2/EmbedPlayerV2.swf?hash_id=942a542f5ffe265e0fc90396b2746028&amp;bgcolor=#FFFFFF&amp;clickTag=null&amp;t=1309009460" /><param name="allowFullScreen" value="true" /><param name="bgcolor" value="#FFFFFF" /></object><noscript>To view this animated banner you need to have Flash Player 9 or newer installed and JavaScript enabled. Create a <a href="http://www.bannersnack.com/" title="BannerSnack - Free flash banner maker">free animated GIF banner</a> online with BannerSnack.com! </noscript>
		</div>
		<div id="divFooter" >
                    <div id="divLogin" class="divCommunes">
                        <form onsubmit="return false">
                            <div id="formConnexion" class="formCentraux">
                                <div id="hautLog">
                                    <table id="tableauForm">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Identifiant : 
                                                </td>
                                                <td>
                                                    <input type="text" id="login" maxlength="32" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Mot de passe :
                                                </td>
                                                <td>
                                                    <input type="password" id="mdp" maxlength="32" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="divMessErreur">
                                            <img src='content/images/badLog.png' width='70px' height='70px'/>
                                    </div>
                                </div>
                                <br/>
                                <p align="center" id="boiteBouton">
                                    <input id="boutConnexion" class="boutonCentre" type="submit" value="Connexion" onclick="envoiLogin()" />
                                </p>
                            </div>
                        </form>
                    </div>
                    <a href="subscription/new_user.php">
                        <div id="divInscription" class="divCommunes">
                            <img src="content/images/Inscription.jpg" alt="Cliquez pour vous inscrire"/>
                        </div>
                    </a>
		</div>
	</body>
</html>
