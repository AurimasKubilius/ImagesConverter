<?php
//Formuojamas meniu.
if (isset($session) && $session->logged_in) {
    $path = "";
    if (isset($_SESSION['path'])) {
        $path = $_SESSION['path'];
        unset($_SESSION['path']);
    }
    ?>
    <table width=100% border="0" cellspacing="1" cellpadding="3" class="meniu">
        <?php
        echo "<tr><td>";
        echo "Prisijungęs vartotojas: <b>$session->username</b> <br>";
        echo "</td></tr><tr><td>";
        echo "<a href=\"". $path . "userinfo.php?user=$session->username\"><img src=\"" . $path . "pictures/manopaskyra.png\"></a>"
        . "<a href=\"" . $path . "useredit.php\"><img src=\"" . $path . "pictures/redaguotipaskyra.png\"></a>"
        . "<a href=\"" . $path . "operacija1.php\"><img src=\"" . $path . "pictures/konvertuoti.png\"></a>"
        . "<a href=\"" . $path . "operacija2.php\"><img src=\"" . $path . "pictures/mazinti.png\"></a>";
        //Administratoriaus sąsaja rodoma tik administratoriui
        if ($session->isAdmin()) {
            echo "<a href=\"" . $path . "admin/admin.php\"><img src=\"" . $path . "pictures/administratoriauspaskyra.png\"></a>";
        }
        echo "<a href=\"" . $path . "process.php\"><img src=\"" . $path . "pictures/atsijungti.png\"></a>";
        echo "</td></tr>";
        ?>
    </table>
    <?php
}//Meniu baigtas
?>
