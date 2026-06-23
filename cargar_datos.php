<?php
    require_once 'conexion.php';

    $datos = $_POST['datos'];

    switch ($datos) {
        case 'categorias':
            $stmt = $obcon->prepare('SELECT id_categoria, nombre FROM categorias');
            break;

        case 'medicamentos':
            
            $stmt = $obcon->prepare('SELECT codigo, nombre_comercial, forma_farmaceutica, concentracion, receta, id_categoria FROM medicamentos');
            break;
        
        case 'lotes':
            
            $stmt = $obcon->prepare('SELECT num_lote, f_ingreso, f_caducidad, stock, ubi, p_compra, p_venta, estado, codigo FROM lotes');
            break;

        default:
            $stmt = $obcon->prepare('SELECT * FROM lotes');
            break;
    }

    
    $stmt->execute();
    $results = $stmt->get_result();

    
    $res = [];
    foreach($results as $row)
        $res[] = $row;

    echo json_encode($res);