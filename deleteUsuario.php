<?php
include 'conexao.php';


// 2. Pega as informações que vieram da URL
$id = $_GET["id"];
$tabela = $_GET["tabela"];
$pagina = $_GET["pagina"];
 
// Monta o comando de apagar e executa direto
$sql = "DELETE FROM $tabela WHERE id = $id";
mysqli_query($conexao, $sql);
$idVisual -=1;

// 4. Volta para a página que pediu a exclusão
header("Location: $pagina");
exit;
?>