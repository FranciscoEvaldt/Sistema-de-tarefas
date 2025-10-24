<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$erro = '';
$sucesso = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $senha2 = $_POST['senha2'] ?? '';

    if (!$nome || !$email || !$senha) {
        $erro = 'Preencha todos os campos.';
    } elseif ($senha !== $senha2) {
        $erro = 'As senhas não coincidem.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $erro = 'E-mail já cadastrado.';
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
            $stmt->execute([$nome, $email, $hash]);
            $sucesso = 'Cadastro realizado! Faça login.';
        }
    }
}
?>
<!doctype html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-dark text-light">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height:100vh;">
            <div class="col-12 col-md-6">
                <div class="card bg-secondary text-light shadow">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-3">Cadastro</h3>

                        <?php if ($erro): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                        <?php endif; ?>

                        <?php if ($sucesso): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
                        <?php endif; ?>

                        <form method="post" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmar senha</label>
                                <input type="password" name="senha2" class="form-control" required>
                            </div>
                            <button class="btn btn-success w-100">Cadastrar</button>
                        </form>

                        <hr class="border-light">
                        <p class="mb-0">Já tem conta? <a href="index.php">Entrar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>