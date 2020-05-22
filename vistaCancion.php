<?php
require_once 'includes/config.php';
use es\ucm\fdi\aw\classes\databaseClasses\Songs as Songs;
use es\ucm\fdi\aw\classes\classes\song as song;
use es\ucm\fdi\aw\classes\classes\user as user;

if (!es\ucm\fdi\aw\Application::getSingleton()->usuarioLogueado()) {
    header("Location: index.php");
}

function sidebar(){
    if (user::esGestor($_SESSION['idUser'])) require 'includes/handlers/sidebarLeftGestor.php';
    else require 'includes/handlers/sidebarLeft.php';
}

function muestraCancion($idCancion){
    $html = "";
    $song = song::buscaSongId($idCancion);
    $html .= "<div class=\"imagen\"><img src='images/Colores.jpg'></div><div class=\"titulo\">";
    $html .= $song->getTitle();
    $html .= '</div><div class="audio"><audio src="server/songs/' . $song->getId() . '.mp3" type="audio/mpeg" controls>Tu navegador no soporta el audio</audio></div>';
	if (user::esGestor($_SESSION['idUser']) || $_SESSION['idUser'] == $song->getIdUser()) $html .= '<a class="activado" id="' . $idCancion . '" onclick="eliminaCancion(\'' . $idCancion . '\')" placeholder="Eliminar">Eliminar</a>';

    return $html;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles-cancion.css"/>
    <link rel="stylesheet" type="text/css" href="css/styles-footer.css"/>
    <link rel="stylesheet" type="text/css" href="css/styles-navSidebarLeft.css"/>
    <script src="https://kit.fontawesome.com/9d868392d8.js"></script>
	<script type="text/javascript" src="includes/js/eliminarCancion.js"></script>
    <title>Cancion</title>
</head>
<body>
<div id="container" class="wrapper">

    <nav>
        <?php
        sidebar();
        ?>
    </nav>

    <section id="contents" class="contents">

        <?php
			$idCancion=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
			echo muestraCancion($idCancion);
        ?>
    </section>

    <?php
    require 'includes/handlers/footer.php';
    ?>

</div>

</body>
</html>