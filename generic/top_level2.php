<div>
    <script type="text/javascript" >
        function redirectUserPage(){
            self.location.href = "../../personnal/personnal.hp";
        }
        function redirectDisconnexionPage(){
            self.location.href = "../../personnal/disconnection.php";
        }
    </script> 
    <div id="div_header">
        <div id="sub_header">
            <img id="user_icon">
            <div id="user_link">
                <input type="button" id="bout_profil" value="Profil" class="bouton" onclick="redirectUserPage()"/><br />
                <br />
                <input type="button" id="bout_deco" value="Deconnexion" class="bouton" onclick="redirectDisconnexionPage()"/>
            </div>
            <hr id="barreseparation_user" class="separationVerticale" />
            <div id="userInformations">
                <span id="userName"></span>
                <span id="userLocation"></span>
            </div>
            <div id="otherInformations">
                <div id="hautGauche">
                    <span id="OI_line1"></span>
                    <span id="OI_line2"></span>
                </div>
                <div id="hautDroit">
                <hr id="barreseparation" class="separationVerticale" />
                    <p id="OI_line3" ></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content_big">
