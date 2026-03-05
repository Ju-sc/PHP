<?php
include 'conexao.php';


// 2. Pega as informações que vieram da URL
$id = $_GET["id"];
$tabela = $_GET["tabela"];
$pagina = $_GET["pagina"];


 // Buscar imagem para apagar o arquivo
 $sql = "SELECT imagem FROM $tabela WHERE id = '$id'";
 $res = mysqli_query($conexao, $sql);
 $prod = mysqli_fetch_assoc($res);

  // Apagar arquivo da imagem (se existir)
  if (!empty($prod["imagem"]) && file_exists("uploads/" . $prod["imagem"])) {
    $caminho = "uploads/" . $prod["imagem"];

echo "Imagem no banco: " . $prod["imagem"] . "<br>";
echo "Caminho resolvido: " . realpath($caminho) . "<br>";
echo "Arquivo existe? " . (file_exists($caminho) ? "SIM" : "NÃO") . "<br>";
    unlink("uploads/" . $prod["imagem"]);
}

// Monta o comando de apagar e executa direto
$sql = "DELETE FROM $tabela WHERE id = $id";
mysqli_query($conexao, $sql);
$idVisual -=1;

// 4. Volta para a página que pediu a exclusão
header("Location: $pagina");
exit;
?>