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

    $nome  = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $telefone = $_POST["telefone"];
    $cpf = $_POST["cpf"];
    $endereco_completo = $_POST["endereco_completo"];
    $foto = $_FILES["imagem"];
    $NomeImagem = "";
    
    if ($foto["error"] ==0){
    $tiposPerm = ["image/jpeg", "image/png", "image/webp"];

    if (!in_array($foto["type"], $tiposPerm)){
        $erro = "Tipo não permitido. Use JPEG, PNG ou WEBP";
    } 
    else {
         // echo '<br><pre>';
            // print_r($imagem);
            // die;
            // Extrair a extensao do arquivo original
            // Ex: "foto.jpg" -> pega so o "jpg"
        $extensao = pathinfo($foto["name"], PATHINFO_EXTENSION);
        $NomeImagem = "cliente". time(). ".". $extensao;
        move_uploaded_file($foto["tmp_name"], to: "uploads/" . $NomeImagem);
    }
}
    
    // Verificar se o email já existe
    $sql = "SELECT * FROM cliente WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $erro = "Este email já está cadastrado.";
    } else {
        // Criptografar a senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir o novo usuário
        $sql = "INSERT INTO cliente (nome, email, senha, telefone, cpf, endereco_completo, imagem) VALUES ('$nome', '$email', '$senhaHash', '$telefone', '$cpf', '$endereco_completo', '$NomeImagem')";

        if (mysqli_query($conexao, $sql)) {
            $sucesso = "Cliente cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar cliente.";
        }
    }
}

// Buscar todos os usuários para listar
$sql = "SELECT id, nome, email, telefone, cpf, endereco_completo, criado_em, imagem FROM cliente ORDER BY id DESC";
$cliente = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes — Projeto SENAI</title>

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
                <span class="mr-3">🤑</span>
                Cadastrar Cliente
            </a>
            
            <a href="cadastro_usuario.php" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                <span class="mr-3">👤</span>
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
            <h2 class="text-2xl font-bold text-gray-800">Cadastrar Cliente</h2>
            <p class="text-gray-500 mt-1">Preencha os dados abaixo para cadastrar um novo cliente.</p>
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
                    <label for="nome" class="block text-gray-700 font-medium mb-2">
                        Nome
                    </label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        required
                        placeholder="Digite o nome"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Campo Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        placeholder="Digite o email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Campo telefone -->
                <div class="mb-4">
                    <label for="telefone" class="block text-gray-700 font-medium mb-2">
                    Telefones
                    </label>
                    <input
                        type="text"
                        id="telefone"
                        name="telefone"
                        required
                        placeholder="Digite o telefone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Campo endereco -->
                <div class="mb-4">
                    <label for="endereco_completo" class="block text-gray-700 font-medium mb-2">
                    Endereço
                    </label>
                    <input
                        type="text"
                        id="endereco_completo"
                        name="endereco_completo"
                        required
                        placeholder="Digite o endereco_completo"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Campo Senha -->
                <div class="mb-6">
                    <label for="senha" class="block text-gray-700 font-medium mb-2">
                        Senha
                    </label>
                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        required
                        placeholder="Digite a senha"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!--campo cpf-->
                <div class="mb-4">
                    <label for="cpf" class="block text-gray-700 font-medium mb-2">
                    CPF
                    </label>
                    <input
                        type="text"
                        id="cpf"
                        name="cpf"
                        required
                        placeholder="Digite o cpf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <div class="mb-4">
                    <label for="imagem" class="block text-gray-700 font-medium mb-2">
                    Imagem
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

        <!-- Lista de Usuários -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Clientes Cadastrados</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-3 text-left rounded-tl-lg">ID</th>
                        <th class="px-4 py-3 text-left">Nome</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left rounded-tr-lg">Criado em</th>
                        <th class="px-4 py-3 text-left rounded-tl-lg">Foto Usuário</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($u = mysqli_fetch_assoc($cliente)): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3"><?php echo $u["id"]; ?></td>
                            <td class="px-4 py-3"><?php echo $u["nome"]; ?></td>
                            <td class="px-4 py-3"><?php echo $u["email"]; ?></td>
                            <td class="px-4 py-3 text-gray-500"><?php echo $u["criado_em"]; ?></td>
                            <td class="px-4 py-3">
                            <?php if (!empty($u["imagem"])): ?>
                                <img src="uploads/<?= $u["imagem"] ?>"
                                    width="60">
                            <?php else: ?>
                                Sem imagem
                            <?php endif; ?>
                        </td>
                            <td class="px-4 py-3">
                                <a href="delete.php?id=<?php echo $u['id']; ?>&tabela=cliente&pagina=cadastro_cliente.php" onclick="return confirm('Tem certeza?');" class="text-red-500 hover:text-red-700 text-lg">
                                🗑️
                            </a>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
