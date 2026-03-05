// Verificar se o usuário está logado
<?php

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}


?>