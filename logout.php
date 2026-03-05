<?php
// ============================================
// Arquivo: logout.php
// Função: Encerrar a sessão e redirecionar para o login
// ============================================

// Iniciar a sessão
session_start();

// Destruir todos os dados da sessão
session_destroy();

// Redirecionar para a tela de login
header("Location: login.php");
exit;
