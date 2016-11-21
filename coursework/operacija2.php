<?php
include("include/session.php");
if ($session->logged_in) {
?>
<html>
    <head>  
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/> 
    <title>Mažinti paveikslėlį</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css" />
    </head>
        <body>
        <table class="center" ><tr><td>
        <img src="pictures/header.png"/>
        <?php
        //If user logged in
        include("include/meniu.php");
        ?>
        
        <table style="border-width: 2px; border-style: dotted;"><tr><td>
            Atgal į [<a href="index.php">Pradžia</a>]
            </td></tr></table>               
            <br> 
            <div style="text-align: center;">     

            <?php
            include("resize.php");
            ?>

            </div> 
            <br>  
            <tr><td>
            <?php
            include("include/footer.php");
            ?>
            </td></tr>      
            </table>
        </body>
    </html>
    <?php
    //if user offline redirected to main page
} else {
    header("Location: index.php");
}
?>