<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autenticado']);
    exit;
}
$user_id = (int)$_SESSION['user_id'];
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
header('Content-Type: application/json; charset=utf-8');

try {
    if ($acao === 'listar') {
        $status = $_POST['status'] ?? '';
        if ($status && !in_array($status, ['pendente','concluida'])) $status = '';
        if ($status) {
            $stmt = $pdo->prepare('SELECT * FROM tarefas WHERE usuario_id = ? AND status = ? ORDER BY data_criacao DESC');
            $stmt->execute([$user_id, $status]);
        } else {
            $stmt = $pdo->prepare('SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY data_criacao DESC');
            $stmt->execute([$user_id]);
        }
        echo json_encode($stmt->fetchAll());
        exit;
    }

    if ($acao === 'adicionar') {
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        if (!$titulo) {
            echo json_encode(['success' => false, 'msg' => 'Título obrigatório']);
            exit;
        }
        $stmt = $pdo->prepare('INSERT INTO tarefas (usuario_id, titulo, descricao) VALUES (?, ?, ?)');
        $stmt->execute([$user_id, $titulo, $descricao]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($acao === 'editar') {
        $id = (int)($_POST['id'] ?? 0);
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $status = $_POST['status'] ?? 'pendente';
        if (!$id || !$titulo) {
            echo json_encode(['success' => false, 'msg' => 'Dados inválidos']);
            exit;
        }
        $stmt = $pdo->prepare('UPDATE tarefas SET titulo = ?, descricao = ?, status = ? WHERE id = ? AND usuario_id = ?');
        $stmt->execute([$titulo, $descricao, $status, $id, $user_id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($acao === 'concluir') {
        $id = (int)($_POST['id'] ?? 0);
        if (!$id) { echo json_encode(['success' => false]); exit; }
        $stmt = $pdo->prepare("UPDATE tarefas SET status = 'concluida' WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$id, $user_id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($acao === 'excluir') {
        $id = (int)($_POST['id'] ?? 0);
        if (!$id) { echo json_encode(['success' => false]); exit; }
        $stmt = $pdo->prepare('DELETE FROM tarefas WHERE id = ? AND usuario_id = ?');
        $stmt->execute([$id, $user_id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($acao === 'get') {
        $id = (int)($_GET['id'] ?? 0);
        $stmt = $pdo->prepare('SELECT * FROM tarefas WHERE id = ? AND usuario_id = ?');
        $stmt->execute([$id, $user_id]);
        echo json_encode($stmt->fetch() ?: []);
        exit;
    }

    echo json_encode(['error' => 'Ação inválida']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro no servidor', 'detail' => $e->getMessage()]);
}
