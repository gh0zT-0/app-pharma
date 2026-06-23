<?php
require_once 'conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['res' => false, 'error' => 'Método incorrecto']);
    exit;
}

$modulo = $_POST['modulo'] ?? '';
$id     = $_POST['id']     ?? '';

if (empty($modulo) || empty($id)) {
    echo json_encode(['res' => false, 'error' => 'Datos incompletos']);
    exit;
}

try {
    switch ($modulo) {
        case 'categorias':
            
            $stmt = $obcon->prepare("DELETE FROM categorias WHERE id_categoria = ?");
            $stmt->bind_param('i', $id);
            break;

        case 'medicamentos':
            
            $stmt = $obcon->prepare("DELETE FROM medicamentos WHERE codigo = ?");
            $stmt->bind_param('s', $id);
            break;

        case 'lotes':
            $stmt = $obcon->prepare("DELETE FROM lotes WHERE num_lote = ?");
            $stmt->bind_param('i', $id);
            break;

        default:
            echo json_encode(['res' => false, 'error' => 'Módulo no válido']);
            exit;
    }

    if ($stmt->execute()) {
        echo json_encode(['res' => true]);
    } else {
        echo json_encode(['res' => false, 'error' => $stmt->error]);
    }
    
    $stmt->close();
    $obcon->close();

} catch (Exception $e) {
    
    echo json_encode([
        'res' => false, 
        'error' => 'No se puede eliminar este registro porque está vinculado con otros datos en el sistema.'
    ]);
}
?>