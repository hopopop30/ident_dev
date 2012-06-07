</div>
<div id="div_footer">
	<div id="sub_footer">
            <?php 
                include_once(dirname(__FILE__). "/../core/presenters/class.Default_Presenter.php");
                $presversion = new Default_Presenter($userId);
                $versEnv = $presversion->getVersionAndEnvironment();
               // print_r($versEnv);
            ?>
            <span id="version"><?php echo $versEnv['env'].": ".$versEnv['version'];?></span>
            <a href="../inBuild/inbuild.php">A propos</a>
            <a href="../inBuild/inbuild.php">Nous contacter</a>
            <input type="button" id="boutonBug" class="bouton" value="Signaler un bug" onclick="redirectBugReport()" />
	</div>
    <script type="text/javascript" >
        function redirectBugReport(){
            self.location.href = "../bugReport/bugReport.php";
        }
    </script>
</div>