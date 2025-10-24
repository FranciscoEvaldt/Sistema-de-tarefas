<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$user_name = $_SESSION['user_name'] ?? 'Usuário';
?>
<!doctype html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minhas Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
        <div class="container">
            <a class="navbar-brand" href="#">Teste</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="me-3">Olá, <?php echo htmlspecialchars($user_name); ?></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="row">
            <div class="col-12 col-md-5">
                <div class="card bg-secondary text-light mb-3 shadow-sm">
                    <div class="card-body">
                        <h5>Adicionar tarefa</h5>
                        <form id="form-tarefa">
                            <div class="mb-2">
                                <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Título" required>
                            </div>
                            <div class="mb-2">
                                <textarea id="descricao" name="descricao" class="form-control" placeholder="Descrição (opcional)"></textarea>
                            </div>
                            <button class="btn btn-primary">Adicionar</button>
                        </form>
                    </div>
                </div>

                <div class="card bg-secondary text-light shadow-sm">
                    <div class="card-body">
                        <h6>Filtro</h6>
                        <select id="filtro-status" class="form-select">
                            <option value="">Todas</option>
                            <option value="pendente">Pendentes</option>
                            <option value="concluida">Concluídas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-7">
                <h5>Minhas tarefas</h5>
                <div id="lista-tarefas"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-editar" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editar-id" name="id">
                    <div class="mb-2">
                        <input type="text" id="editar-titulo" name="titulo" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <textarea id="editar-descricao" name="descricao" class="form-control"></textarea>
                    </div>
                    <div class="mb-2">
                        <select id="editar-status" name="status" class="form-select">
                            <option value="pendente">Pendente</option>
                            <option value="concluida">Concluída</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>