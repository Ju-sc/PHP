<?php
// ============================================
// Arquivo: cadastro_cliente hp
// Função: Cadastro de clientes (área restrita)
// ============================================

// Iniciar a sessão
session_start();


// Incluir o arquivo de conexão com o banco
require_once "conexao.php";

// Variáveis para mensagens
$sucesso = "";
$erro = "";

// Verificar se o formulário de cadastro foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $NomeProd  = $_POST["NomeProd"];
    $preco = $_POST["preco"];
    $estoque = $_POST["estoque"];
    $codbar = $_POST["codbar"];
    $descricao = $_POST["descricao"];
    $imagem = $_FILES["imagem"];
    $NomeImagem ="";
  

    $tiposPerm = ["image/jpeg", "image/png", "image/webp"];

if (!in_array($imagem["type"], $tiposPerm)){
    $erro = "Tipo não permitido. Use JPEG, PNG ou WEBP";
} 
else {
     // echo '<br><pre>';
        // print_r($imagem);
        // die;
        // Extrair a extensao do arquivo original
        // Ex: "foto.jpg" -> pega so o "jpg"
    $extensao = pathinfo($imagem["name"], PATHINFO_EXTENSION);
    $NomeImagem = "produto_". time(). ".". $extensao;
    move_uploaded_file($imagem["tmp_name"], to: "uploads/" . $NomeImagem);
}

    // Verificar se o email já existe
    $sql = "SELECT * FROM produtos WHERE codbar = '$codbar'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $erro = "Este produto já está cadastrado.";
    } else {
        

        // Inserir o novo usuário
        $sql = "INSERT INTO produtos (NomeProd, preco, estoque, descricao, imagem, codbar) VALUES ('$NomeProd', '$preco', '$estoque', '$descricao', '$NomeImagem', '$codbar')";

        if (mysqli_query($conexao, $sql)) {
            $sucesso = "Produto cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar produto.";
        }
    }
}




// Buscar todos os usuários para listar
$sql = "SELECT id, NomeProd, preco, estoque, criado_em, descricao, imagem, codbar FROM produtos ORDER BY id DESC";
$produtos = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos — Projeto SENAI</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- ========== MENU LATERAL (Sidebar) ========== -->
    <aside class="w-64 bg-gray-800 min-h-screen fixed left-0 top-0">

        <!-- Logo / Título -->
        <div class="bg-gray-900 px-6 py-4">
            <h1 class="text-white font-bold text-lg">Projeto SENAI</h1>
        </div>

        <!-- Navegação -->
        <nav class="mt-6">
            <a href="cadastro_cliente.php" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                <span class="mr-3">🤑   </span>
                Cadastrar Cliente
            </a>
            
            <a href="cadastro_usuario.php" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                <span class="mr-3">👤   </span>
                Cadastrar Usuário
            </a>
            <a href="cadastro_produtos.php" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                <span class="mr-3">📋</span>
                Cadastrar Produtos
            </a>
        
            <a href="logout.php" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                <span class="mr-3">🚪</span>
                Sair
            </a>
        </nav>

        <!-- Usuário logado -->
        <div class="absolute bottom-0 w-full px-6 py-4 bg-gray-900">
            <p class="text-gray-400 text-xs">Logado como:</p>
            <p class="text-white text-sm font-medium"><?php echo $_SESSION["usuario_nome"]; ?></p>
        </div>

    </aside>

    <!-- ========== CONTEÚDO PRINCIPAL ========== -->
    <main class="ml-64 flex-1 p-8">

        <!-- Cabeçalho da página -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Cadastrar Produtos</h2>
            <p class="text-gray-500 mt-1">Preencha os dados abaixo para cadastrar um novo produto.</p>
        </div>

        <!-- Mensagem de sucesso -->
        <?php if (!empty($sucesso)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo $sucesso; ?>
            </div>
        <?php endif; ?>

        <!-- Mensagem de erro -->
        <?php if (!empty($erro)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <!-- Formulário de Cadastro -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 max-w-xl">
            <form method="POST" enctype="multipart/form-data">
                <!-- Campo Nome -->
                <div class="mb-4">
                    <label for="NomeProd" class="block text-gray-700 font-medium mb-2">
                        Nome
                    </label>
                    <input
                        type="text"
                        id="NomeProd"
                        name="NomeProd"
                        required
                        placeholder="Digite o nome"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Campo Email -->
                <div class="mb-4">
                    <label for="preco" class="block text-gray-700 font-medium mb-2">
                        Preço
                    </label>
                    <input
                        type="text"
                        id="preco"
                        name="preco"
                        required
                        placeholder="Digite o valor"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Campo telefone -->
                <div class="mb-4">
                    <label for="qtd" class="block text-gray-700 font-medium mb-2">
                    Estoque
                    </label>
                    <input
                        type="text"
                        id="estoque"
                        name="estoque"
                        required
                        placeholder="Digite a quantidade"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Campo endereco -->
                <div class="mb-4">
                    <label for="codbar" class="block text-gray-700 font-medium mb-2">
                    Código de barras
                    </label>
                    <input
                        type="text"
                        id="codbar"
                        name="codbar"
                        required
                        placeholder="Digite o código de barras"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700 font-medium mb-2">
                    Descrição
                    </label>
                    <input
                        type="text"
                        id="descricao"
                        name="descricao"
                        placeholder="Digite a descrição do produto"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <div class="mb-4">
                    <label for="imagem" class="block text-gray-700 font-medium mb-2">
                    Foto
                    </label>
                    <input
                        type="file"
                        id="imagem"
                        name= "imagem"
                        required
                        placeholder="Anexeh"
                        accept=".jpg,.png,.webp"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                
                
                <!-- Botão Cadastrar -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-200"
                >
                    Cadastrar
                </button>

            </form>
        </div>

        <!-- Lista de produtos -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Produtos Cadastrados</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-3 text-left rounded-tl-lg">ID</th>
                        <th class="px-4 py-3 text-left">Nome</th>
                        <th class="px-4 py-3 text-left rounded-tl-lg">Imagem</th>
                        <th class="px-4 py-3 text-left rounded-tr-lg">Criado em</th>
                        <th class="px-4 py-3 text-left">Preço</th>
                        <th class="px-4 py-3 text-left">Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php  while ($u = mysqli_fetch_assoc($produtos)): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3"><?php echo $idVisual +=1; ?></td>
                            <td class="px-4 py-3"><?php echo $u["NomeProd"]; ?></td>
                            <td class="px-4 py-3">
                            <?php if (!empty($u["imagem"])): ?>
                                <img src="uploads/<?= $u["imagem"] ?>"
                                    width="60">
                            <?php else: ?>
                                Sem imagem
                            <?php endif; ?>
                        </td>
                            <td class="px-4 py-3 text-gray-500"><?php echo $u["criado_em"]; ?></td>
                            <td class="px-4 py-3 text-gray-500"><?php echo $u["preco"]; ?></td>
                            <td class="px-4 py-3 ">
                            <a href="delete.php?id=<?php echo $u['id']; ?>&tabela=produtos&pagina=cadastro_produtos.php" onclick="return confirm('Tem certeza?');" 
                            class="flex items-center px-6 py-3 text-red-900 hover:text-red-700 tex t-lg">
                                🗑️
                                Excluir
                                </a>
                                <a href="editar.php?id=<?= $u['id']?>"
                                class="flex items-center px-6 py-3 text-blue-600 hover:text-red-500">
                                📝 
                                Editar
                            </a>
                            </td>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

</body>
</html>
