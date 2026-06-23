<?php
    
    require_once 'conexion.php';

    header('Content-Type: application/json');

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $modulo = $_POST['modulo'] ?? '';

        switch ($modulo) {
            case 'categorias':
                $nombre = $_POST['nombre'] ?? '';
                
                $stmt = $obcon->prepare("INSERT INTO categorias (nombre) VALUES (?)");
                $stmt->bind_param('s', $nombre);
                
                if ($stmt->execute()) {
                    echo json_encode(['res' => true]);
                } else {
                    echo json_encode(['res' => false]);
                }
                $stmt->close();
                break;

            case 'medicamentos':
                $codigo = $_POST['codigo'] ?? '';
                $nombre_comercial = $_POST['nombre_comercial'] ?? '';
                $nombre_generico = $_POST['nombre_generico'] ?? '';
                $forma_farmaceutica = $_POST['forma_farmaceutica'] ?? '';
                $concentracion = $_POST['concentracion'] ?? '';
                $receta = $_POST['receta'] ?? '';
                $id_categoria = $_POST['id_categoria'] ?? null;

                $stmt = $obcon->prepare("INSERT INTO medicamentos (codigo, nombre_comercial, nombre_generico, forma_farmaceutica, concentracion, receta, id_categoria) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('ssssssi', $codigo, $nombre_comercial, $nombre_generico, $forma_farmaceutica, $concentracion, $receta, $id_categoria);
                
                if ($stmt->execute()) {
                    echo json_encode(['res' => true]);
                } else {
                    echo json_encode(['res' => false]);
                }
                $stmt->close();
                break;

            case 'lotes':
                $num_lote = $_POST['num_lote'] ?? null;
                $f_ingreso = $_POST['f_ingreso'] ?? '';
                $f_caducidad = $_POST['f_caducidad'] ?? '';
                $stock = $_POST['stock'] ?? null;
                $ubi = $_POST['ubi'] ?? '';
                $p_compra = $_POST['p_compra'] ?? 0.00;
                $p_venta = $_POST['p_venta'] ?? 0.00;
                $codigo = $_POST['codigo'] ?? ''; 

                $stmt = $obcon->prepare("INSERT INTO lotes (num_lote, f_ingreso, f_caducidad, stock, ubi, p_compra, p_venta, codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('issisdds', $num_lote, $f_ingreso, $f_caducidad, $stock, $ubi, $p_compra, $p_venta, $codigo);
                
                if ($stmt->execute()) {
                    echo json_encode(['res' => true]);
                } else {
                    echo json_encode(['res' => false]);
                }
                $stmt->close();
                break;

            default:
                echo json_encode(['res' => false, 'error' => 'Modulo no especificado']);
                break;
        }

        $obcon->close();
    } else {
        echo json_encode(['res' => false, 'error' => 'Metodo incorrecto']);
    }
?>