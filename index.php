<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
   
</head>
<body>
    <header>
        <div class="almacenT">
            <p class="arriba">Almacen  >  <span>Gestión de Inventario</span></p>
        </div>

        <div class="titulo">
            <h1>Inventario General</h1>
        </div>
        
    </header>
    <main class = "container">

    <section class="grid-metricas">
        <article class="card">
            <div class="texto">STOCK TOTAL</div>
            <div class="numero">12,482</div>
            <div class="abajo"><img src="subir.png"><p>5.2% este mes</p></div>
        </article>
        <article class="card">
            <div class="texto">VENCIMIENTOS(30D)</div>
            <div class="numero">142</div>
            <div class="abajo"><img src="subir.png"><p>Acción Requerida</p></div>
        </article>
        <article class="card">
            <div class="texto">NUEVOS INGRESOS</div>
            <div class="numero1">28</div>
            <div class="abajo1"><p>Últimas 24 horas</p></div>
        </article>
        <article class="span-2-4">
            <div class="texto4-1">ESTADO DE PEDIDOS</div>
            <div class="texto4">Activo</div>
            <div class="abajo1-4"><p>92% eficiencia logística</p></div>
        </article>
    </section>

    <section class="grid-tablas">
        <article class="card span-5">
            <div class="amedicamentos">
                <h1>Medicamentos</h1>
                <button type="button" id="btnAbrirModalMedicamento" class="icono1" title="Agregar Medicamento">+</button>
                <button type="button" id="btnEditarMedicamento"  class="icono2" title="Editar">✎</button>
                <button type="button" id="btnEliminarMedicamento" class="icono3" title="Eliminar">🗑️</button>
            </div>
            <table id="medicamentosTable">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre comercial</th>
                        <th>Forma</th>
                        <th>Conc.</th>
                        <th>Receta</th>
                    </tr>
                </thead>
                <tbody id="tablaBodyMedicamentos"></tbody>
            </table>
        </article>

        <article class="card span-3">
            <div class="categorias">
                <h1>Categorias</h1>
                <button type="button" id="btnAbrirModalCategoria" class="icono1" title="Agregar Categoría">+</button>
                <button type="button" id="btnEditarCategoria"  class="icono2" title="Editar">✎</button>
                <button type="button" id="btnEliminarCategoria" class="icono3" title="Eliminar">🗑️</button>
            </div>
            <table id="categoriasTable">
                <thead>
                    <tr>
                        <th>Nombre de la categoria</th>
                    </tr>
                </thead>
                <tbody id="tablaBodyCategorias"></tbody>
            </table>
        </article>

        <article class="card span-full">
            <div class="alotes">
                <h1>Lotes</h1>
                <button type="button" id="btnAbrirModalLote" class="icono1" title="Agregar Lote">+</button>
                <button type="button" id="btnEditarLote"  class="icono2" title="Editar">✎</button>
                <button type="button" id="btnEliminarLote" class="icono3" title="Eliminar">🗑️</button>
            </div>
            <table id="lotesTable">
                <thead>
                    <tr>
                        <th>N° Lote</th>
                        <th>Ingreso</th>
                        <th>Caducidad</th>
                        <th>Stock</th>
                        <th>Ubicacion</th>
                        <th>P. Compra</th>
                        <th>P.Venta</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="tablaBodyLotes"></tbody>
            </table>
        </article>
    </section>
    <dialog id="modalCategoria">
    <div class="modal-header">
        <h2>Agregar Nueva Categoría</h2>
        <button class="modal-close" onclick="document.getElementById('modalCategoria').close()">&times;</button>
    </div>
    <form id="formCategoria">
        <div class="form-group">
            <label for="cat_nombre">Nombre de la Categoría:</label>
            <input type="text" id="cat_nombre" name="nombre" required>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancelar" onclick="document.getElementById('modalCategoria').close()">Cancelar</button>
            <button type="submit" class="btn-guardar">Guardar</button>
        </div>
    </form>
    </dialog>

    <dialog id="modalMedicamento">
    <div class="modal-header">
        <h2>Agregar Nuevo Medicamento</h2>
        <button class="modal-close" onclick="document.getElementById('modalMedicamento').close()">&times;</button>
    </div>
    <form id="formMedicamento">
        <div class="form-group">
            <label for="med_codigo">Código Único:</label>
            <input type="text" id="med_codigo" name="codigo" required>
        </div>
        <div class="form-group">
            <label for="med_nombre_comercial">Nombre Comercial:</label>
            <input type="text" id="med_nombre_comercial" name="nombre_comercial" required>
        </div>
        <div class="form-group">
            <label for="med_nombre_generico">Nombre Genérico:</label>
            <input type="text" id="med_nombre_generico" name="nombre_generico" required>
        </div>
        <div class="form-group">
            <label for="med_forma">Forma Farmacéutica:</label>
            <select id="med_forma" name="forma_farmaceutica" required>
                <option value="">Seleccione...</option>
                <option value="Tableta">Tableta</option>
                <option value="Jarabe">Jarabe</option>
                <option value="Ampolla">Ampolla</option>
                <option value="Cápsula">Cápsula</option>
            </select>
        </div>
        <div class="form-group">
            <label for="med_concentracion">Concentración:</label>
            <input type="text" id="med_concentracion" name="concentracion" required>
        </div>
        <div class="form-group">
            <label for="med_receta">Tipo de Venta (Receta):</label>
            <select id="med_receta" name="receta" required>
                <option value="VENTA LIBRE">VENTA LIBRE</option>
                <option value="REQUERIDA">REQUERIDA</option>
            </select>
        </div>
        <div class="form-group">
            <label for="med_categoria">Categoría Asignada:</label>
            <select id="med_categoria" name="id_categoria" required>
                </select>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancelar" onclick="document.getElementById('modalMedicamento').close()">Cancelar</button>
            <button type="submit" class="btn-guardar">Guardar</button>
        </div>
    </form>
    </dialog>

    <dialog id="modalLote">
    <div class="modal-header">
        <h2>Agregar Nuevo Lote</h2>
        <button class="modal-close" onclick="document.getElementById('modalLote').close()">&times;</button>
    </div>
    <form id="formLote">
        <div class="form-group">
            <label for="lote_num">Número de Lote:</label>
            <input type="number" id="lote_num" name="num_lote" required>
        </div>
        <div class="form-group">
            <label for="lote_ingreso">Fecha de Ingreso:</label>
            <input type="date" id="lote_ingreso" name="f_ingreso" required>
        </div>
        <div class="form-group">
            <label for="lote_caducidad">Fecha de Caducidad:</label>
            <input type="date" id="lote_caducidad" name="f_caducidad" required>
        </div>
        <div class="form-group">
            <label for="lote_stock">Cantidad en Stock:</label>
            <input type="number" id="lote_stock" name="stock" required>
        </div>
        <div class="form-group">
            <label for="lote_ubi">Ubicación en Almacén:</label>
            <select id="lote_ubi" name="ubi" required>
                <option value="estante">Estante</option>
                <option value="pasillo">Pasillo</option>
                <option value="nevera">Nevera</option>
            </select>
        </div>
        <div class="form-group">
            <label for="lote_pcompra">Precio de Compra ($):</label>
            <input type="number" id="lote_pcompra" name="p_compra" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="lote_pventa">Precio de Venta ($):</label>
            <input type="number" id="lote_pventa" name="p_venta" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="lote_codigo">Medicamento Asociado:</label>
            <select id="lote_codigo" name="codigo" required>
                </select>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancelar" onclick="document.getElementById('modalLote').close()">Cancelar</button>
            <button type="submit" class="btn-guardar">Guardar</button>
        </div>
    </form>
    </dialog>

    <dialog id="modalCategoriaEdit">
    <div class="modal-header">
        <h2>Editar Categoría</h2>
        <button class="modal-close" onclick="document.getElementById('modalCategoriaEdit').close()">&times;</button>
    </div>
    <form id="formCategoriaEdit">
        <input type="hidden" name="id_categoria">
        <div class="form-group"><label>Nombre de la Categoría:</label><input type="text" name="nombre" required></div>
        <div class="modal-actions">
            <button type="button" class="btn-cancelar" onclick="document.getElementById('modalCategoriaEdit').close()">Cancelar</button>
            <button type="submit" class="btn-guardar">Actualizar</button>
        </div>
    </form>
</dialog>
 
<dialog id="modalMedicamentoEdit">
    <div class="modal-header">
        <h2>Editar Medicamento</h2>
        <button class="modal-close" onclick="document.getElementById('modalMedicamentoEdit').close()">&times;</button>
    </div>
    <form id="formMedicamentoEdit">
        <input type="hidden" name="codigo_original"> 
        <div class="form-group"><label>Código Único:</label><input type="text" name="codigo" required></div>
        <div class="form-group"><label>Nombre Comercial:</label><input type="text" name="nombre_comercial" required></div>
        <div class="form-group"><label>Nombre Genérico:</label><input type="text" name="nombre_generico"></div>
        <div class="form-group">
            <label>Forma Farmacéutica:</label>
            <select name="forma_farmaceutica" required>
                <option value="">Seleccione...</option>
                <option>Tableta</option><option>Jarabe</option><option>Ampolla</option><option>Cápsula</option><option>Crema</option><option>Inhalador</option>
            </select>
        </div>
        <div class="form-group"><label>Concentración:</label><input type="text" name="concentracion" required></div>
        <div class="form-group">
            <label>Tipo de Venta:</label>
            <select name="receta" required>
                <option value="VENTA LIBRE">VENTA LIBRE</option>
                <option value="REQUERIDA">REQUERIDA</option>
            </select>
        </div>
        <div class="form-group"><label>Categoría:</label><select name="id_categoria" required></select></div>
        <div class="modal-actions">
            <button type="button" class="btn-cancelar" onclick="document.getElementById('modalMedicamentoEdit').close()">Cancelar</button>
            <button type="submit" class="btn-guardar">Actualizar</button>
        </div>
    </form>
</dialog>
 
<dialog id="modalLoteEdit">
    <div class="modal-header">
        <h2>Editar Lote</h2>
        <button class="modal-close" onclick="document.getElementById('modalLoteEdit').close()">&times;</button>
    </div>
    <form id="formLoteEdit">
        <input type="hidden" name="num_lote_original">
        <div class="form-group"><label>Número de Lote:</label><input type="number" name="num_lote" required></div>
        <div class="form-group"><label>Fecha de Ingreso:</label><input type="date" name="f_ingreso" required></div>
        <div class="form-group"><label>Fecha de Caducidad:</label><input type="date" name="f_caducidad" required></div>
        <div class="form-group"><label>Cantidad en Stock:</label><input type="number" name="stock" required></div>
        <div class="form-group">
            <label>Ubicación:</label>
            <select name="ubi" required><option value="estante">Estante</option><option value="pasillo">Pasillo</option><option value="nevera">Nevera</option></select>
        </div>
        <div class="form-group"><label>Precio de Compra ($):</label><input type="number" name="p_compra" step="0.01" required></div>
        <div class="form-group"><label>Precio de Venta ($):</label><input type="number" name="p_venta" step="0.01" required></div>
        <div class="form-group">
            <label>Estado:</label>
            <select name="estado" required>
                <option value="optimo">Óptimo</option>
                <option value="estable">Estable</option>
                <option value="critico">Crítico</option>
            </select>
        </div>
        <div class="form-group"><label>Medicamento Asociado:</label><select name="codigo" required></select></div>
        <div class="modal-actions">
            <button type="button" class="btn-cancelar" onclick="document.getElementById('modalLoteEdit').close()">Cancelar</button>
            <button type="submit" class="btn-guardar">Actualizar</button>
        </div>
    </form>
    </dialog>
    </main>
<script src="app.js"></script>
</body>
</html>