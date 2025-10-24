<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!$email || !$senha) {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $stmt = $pdo->prepare('SELECT id, nome, senha FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['user_name'] = $user['nome'];
            header('Location: dashboard.php');
            exit;
        } else {
            $erro = 'E-mail ou senha inválidos.';
        }
    }
}
?>
<!doctype html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-dark text-light">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height:100vh;">
            <div class="col-12 col-md-6">
                <div class="card bg-secondary text-light shadow">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-3">Entrar</h3>
                        <?php if ($erro): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                        <?php endif; ?>
                        <form method="post" novalidate>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                            <button class="btn btn-primary w-100">Entrar</button>
                        </form>
                        <hr class="border-light">
                        <p class="mb-0">Ainda não tem conta? <a href="register.php">Cadastre-se</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>