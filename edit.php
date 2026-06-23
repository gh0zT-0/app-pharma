<?php
require_once 'conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['res' => false, 'error' => 'Método incorrecto']);
    exit;
}

$modulo  = $_POST['modulo']  ?? '';
$accion  = $_POST['accion']  ?? 'cargar'; 

switch ($modulo) {

    
    case 'categorias':
        if ($accion === 'cargar') {
            $id = $_POST['id_categoria'] ?? '';
            $stmt = $obcon->prepare("SELECT id_categoria, nombre FROM categorias WHERE id_categoria = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            echo json_encode($row ?? ['res' => false]);
        } else {
            
            $id     = $_POST['id_categoria'] ?? '';
            $nombre = $_POST['nombre']       ?? '';
            $stmt = $obcon->prepare("UPDATE categorias SET nombre = ? WHERE id_categoria = ?");
            $stmt->bind_param('si', $nombre, $id);
            echo json_encode(['res' => $stmt->execute()]);
        }
        break;

    
    case 'medicamentos':
        if ($accion === 'cargar') {
            $codigo = $_POST['codigo'] ?? '';
            $stmt = $obcon->prepare("SELECT codigo, nombre_comercial, nombre_generico, forma_farmaceutica, concentracion, receta, id_categoria FROM medicamentos WHERE codigo = ?");
            $stmt->bind_param('s', $codigo);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            echo json_encode($row ?? ['res' => false]);
        } else {
            
            $codigo_original  = $_POST['codigo_original']   ?? '';
            $codigo           = $_POST['codigo']             ?? '';
            $nombre_comercial = $_POST['nombre_comercial']   ?? '';
            $nombre_generico  = $_POST['nombre_generico']    ?? '';
            $forma            = $_POST['forma_farmaceutica'] ?? '';
            $concentracion    = $_POST['concentracion']      ?? '';
            $receta           = $_POST['receta']             ?? '';
            $id_categoria     = $_POST['id_categoria']       ?? null;

            $stmt = $obcon->prepare("UPDATE medicamentos SET codigo=?, nombre_comercial=?, nombre_generico=?, forma_farmaceutica=?, concentracion=?, receta=?, id_categoria=? WHERE codigo=?");
            $stmt->bind_param('ssssssis', $codigo, $nombre_comercial, $nombre_generico, $forma, $concentracion, $receta, $id_categoria, $codigo_original);
            echo json_encode(['res' => $stmt->execute()]);
        }
        break;

    
    case 'lotes':
        if ($accion === 'cargar') {
            $num_lote = $_POST['num_lote'] ?? null;
            $stmt = $obcon->prepare("SELECT num_lote, f_ingreso, f_caducidad, stock, ubi, p_compra, p_venta, estado, codigo FROM lotes WHERE num_lote = ?");
            $stmt->bind_param('i', $num_lote);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            echo json_encode($row ?? ['res' => false]);
        } else {
            
            $num_lote_original = $_POST['num_lote_original'] ?? null;
            $num_lote    = $_POST['num_lote']    ?? null;
            $f_ingreso   = $_POST['f_ingreso']   ?? '';
            $f_caducidad = $_POST['f_caducidad'] ?? '';
            $stock       = $_POST['stock']       ?? null;
            $ubi         = $_POST['ubi']         ?? '';
            $p_compra    = $_POST['p_compra']    ?? 0.00;
            $p_venta     = $_POST['p_venta']     ?? 0.00;
            $estado      = $_POST['estado']      ?? '';
            $codigo      = $_POST['codigo']      ?? '';

            $stmt = $obcon->prepare("UPDATE lotes SET num_lote=?, f_ingreso=?, f_caducidad=?, stock=?, ubi=?, p_compra=?, p_venta=?, estado=?, codigo=? WHERE num_lote=?");
            $stmt->bind_param('ississddsi', $num_lote, $f_ingreso, $f_caducidad, $stock, $ubi, $p_compra, $p_venta, $estado, $codigo, $num_lote_original);
            echo json_encode(['res' => $stmt->execute()]);
        }
        break;

    default:
        echo json_encode(['res' => false, 'error' => 'Módulo no especificado']);
        break;
}

$obcon->close();
?>