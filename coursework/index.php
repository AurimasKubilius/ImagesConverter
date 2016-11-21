<?php
include("include/session.php");
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/>
        <title>Paveikslėlių failų formatų konvertavimo sistema</title>
        <link href="include/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body>             
        <table class="center" ><tr><td>
            <center><img src="pictures/header.png"/></center>
            <?php
            //If user logged in
            if ($session->logged_in) {
                include("include/meniu.php");
                ?>
                <div style="text-align: center;color:grey">
                    <br><br>
                    <h1>Sveiki atvykę!<br>
                    Sistemoje galite:<br>
                    -kovertuoti paveikslėlius iš „jpg“, „jpeg“ arba „png“ į bet kurį iš paminėtų<br>
                    -V.I.P. nariai gali konvertuoti „gif“ formatus <br>
                    -mažinti paveikslėlių vaizdo išmatavimus(?x?)<br>
                    -matyti ar pateiktas failas turi GPS koordinates
                    </h1>
                </div><br>
                <?php
                //If user offline, redirect to log in form
                //If there are some errors, messages will be showed
            } else {
                echo "<div align=\"center\">";
                if ($form->num_errors > 0) {
                    echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                }
                echo "<table class=\"center\"><tr><td>";
                include("include/loginForm.php");
                echo "</td></tr></table></div><br></td></tr>";
            }
            echo "<tr><td>";
            include("include/footer.php");
            echo "</td></tr>";
            ?>
        </td></tr>
</table>
</body>
</html>