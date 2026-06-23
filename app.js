let medicamentos = [];
let categorias = [];
let lotes = [];

let idCategoriaSeleccionada = null;
let numeroLoteSeleccionado = null;


let codigoMedicamentoSeleccionado = null;

function renderTablaMedicamentos() {
    const tbody = document.getElementById('tablaBodyMedicamentos');

    
    let medicamentosFiltrados = medicamentos;
    if (idCategoriaSeleccionada) {
        medicamentosFiltrados = medicamentos.filter(m => m.id_categoria == idCategoriaSeleccionada);
    }

    if (medicamentosFiltrados.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><p>No hay medicamentos para esta categoría.</p></div></td></tr>`;
        return;
    }

    tbody.innerHTML = medicamentosFiltrados.map(a => {
        const badgeClass = a.receta === 'VENTA LIBRE' ? 'badge badge-libre' : 'badge badge-requerida';
        const filaSeleccionada = a.codigo === codigoMedicamentoSeleccionado ? 'fila-seleccionada' : '';

        return `
        <tr class="${filaSeleccionada}" style="cursor:pointer;" onclick="seleccionarMedicamento('${a.codigo}')">
            <td class="td-codigo">${a.codigo}</td>
            <td class="td-nombre">${a.nombre_comercial}</td>
            <td class="td-forma">${a.forma}</td>
            <td class="td-conc">${a.concentracion}</td>
            <td><span class="${badgeClass}">${a.receta}</span></td>
        </tr>`;
    }).join('');
}

function renderTablaCategorias() {
    const tbody = document.getElementById('tablaBodyCategorias');

    if (categorias.length === 0) {
        tbody.innerHTML = `<tr><td><div class="empty-state"><p>No hay categorías registradas.</p></div></td></tr>`;
        return;
    }

    let categoriasFiltradas = categorias;
    if (codigoMedicamentoSeleccionado) {
        const medSeleccionado = medicamentos.find(m => m.codigo === codigoMedicamentoSeleccionado);
        if (medSeleccionado && medSeleccionado.id_categoria) {
            const filtradas = categorias.filter(c => c.id_categoria == medSeleccionado.id_categoria);
            if (filtradas.length > 0) {
                categoriasFiltradas = filtradas;
            }
        }
    }

    tbody.innerHTML = categoriasFiltradas.map(a => {
        const filaSeleccionada = a.id_categoria == idCategoriaSeleccionada ? 'fila-seleccionada' : '';

        return `
        <tr class="${filaSeleccionada}" style="cursor:pointer;" onclick="seleccionarCategoria('${a.id_categoria}')">
            <td>${a.nombre}</td>
        </tr>`;
    }).join('');
}

function renderTablaLotes() {
    const tbody = document.getElementById('tablaBodyLotes');

    
    let lotesFiltrados = lotes;
    if (codigoMedicamentoSeleccionado) {
        lotesFiltrados = lotes.filter(l => l.codigo === codigoMedicamentoSeleccionado);
    }

    if (lotesFiltrados.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8"><div class="empty-state"><p>No hay lotes para mostrar.</p></div></td></tr>`;
        return
        return 
        `<tr class="${a.numero == numeroLoteSeleccionado ? 'fila-seleccionada' : ''}" 
            style="cursor:pointer;" onclick="seleccionarLote(${a.numero})">
            ...
        </tr>`;
    }

    tbody.innerHTML = lotesFiltrados.map(a => {
        const estadoClases = {
            'OPTIMO':  'estado estado-optimo',
            'CRÍTICO': 'estado estado-critico',
            'CRITICO': 'estado estado-critico',
            'ESTABLE': 'estado estado-estable',
        };
        const estadoClass = estadoClases[a.estado?.toUpperCase()] ?? 'estado';

        const hoy = new Date();
        const fCad = new Date(a.caducidad);
        const diasRestantes = Math.ceil((fCad - hoy) / (1000 * 60 * 60 * 24));
        const caducidadClass = diasRestantes <= 30 ? 'td-caducidad-alerta' : '';
        const stockClass = Number(a.stock) < 50 ? 'td-stock-bajo' : 'td-bold';

        return `
        <tr>
            <td class="td-bold">${a.numero}</td>
            <td>${a.ingreso}</td>
            <td class="${caducidadClass}">${a.caducidad}</td>
            <td class="${stockClass}">${Number(a.stock).toLocaleString()}</td>
            <td><span class="ubicacion-pill">${a.ubicacion}</span></td>
            <td class="td-precio-compra">$${Number(a.pCompra).toFixed(2)}</td>
            <td class="td-precio-venta">$${Number(a.pVenta).toFixed(2)}</td>
            <td><span class="${estadoClass}">${a.estado}</span></td>
        </tr>`;
    }).join('');
}


function seleccionarMedicamento(codigo) {
    
    if (codigoMedicamentoSeleccionado === codigo) {
        codigoMedicamentoSeleccionado = null;
    } else {
        codigoMedicamentoSeleccionado = codigo;
    }

    
    renderTablaMedicamentos();
    renderTablaCategorias();
    renderTablaLotes();
}

function cargar_datos(v) {
    const fd = new FormData();
    fd.append('datos', v);

    fetch('cargar_datos.php', {
        method: 'POST',
        body: fd
    })
    .then(response => response.json())
    .then(data => {
        if (v === 'medicamentos') {
            medicamentos = data.map(row => ({
                codigo:           row.codigo,
                nombre_comercial: row.nombre_comercial,
                forma:            row.forma_farmaceutica,
                concentracion:    row.concentracion,
                receta:           row.receta,
                id_categoria:     row.id_categoria 
            }));
            renderTablaMedicamentos();

        } else if (v === 'categorias') {
            categorias = data.map(row => ({
                id_categoria: row.id_categoria, 
                nombre:       row.nombre
            }));
            renderTablaCategorias();

        } else if (v === 'lotes') {
            lotes = data.map(row => ({
                numero:    row.num_lote,
                ingreso:   row.f_ingreso,
                caducidad: row.f_caducidad,
                stock:     row.stock,
                ubicacion: row.ubi,
                pCompra:   row.p_compra,
                pVenta:    row.p_venta,
                estado:    row.estado,
                codigo:    row.codigo 
            }));
            renderTablaLotes();
        }
    })
    .catch(err => console.error('Error cargando datos:', err));
}

document.addEventListener('DOMContentLoaded', () => {
    cargar_datos('categorias');
    cargar_datos('medicamentos');
    cargar_datos('lotes');
});


function abrirModal(idModal) {
    const modal = document.getElementById(idModal);
    
    
    if (idModal === 'modalMedicamento') {
        const selectCat = document.getElementById('med_categoria');
        selectCat.innerHTML = '<option value="">Seleccione...</option>' + 
            categorias.map(c => `<option value="${c.id_categoria}">${c.nombre}</option>`).join('');
    }
    
    
    if (idModal === 'modalLote') {
        const selectMed = document.getElementById('lote_codigo');
        selectMed.innerHTML = '<option value="">Seleccione...</option>' + 
            medicamentos.map(m => `<option value="${m.codigo}">${m.nombre_comercial}</option>`).join('');
    }

    
    modal.showModal(); 
}

document.addEventListener('DOMContentLoaded', () => {
    
    document.getElementById('btnAbrirModalCategoria')?.addEventListener('click', () => abrirModal('modalCategoria'));
    document.getElementById('btnAbrirModalMedicamento')?.addEventListener('click', () => abrirModal('modalMedicamento'));
    document.getElementById('btnAbrirModalLote')?.addEventListener('click', () => abrirModal('modalLote'));

    
    configurarEnvio('formCategoria', 'categorias', 'modalCategoria');
    configurarEnvio('formMedicamento', 'medicamentos', 'modalMedicamento');
    configurarEnvio('formLote', 'lotes', 'modalLote');
});

function configurarEnvio(idFormulario, modulo, idModal) {
    const formulario = document.getElementById(idFormulario);
    if (!formulario) return;

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(formulario);
        formData.append('modulo', modulo); 

        fetch('guardar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            
            if (data.res === true) {
                alert('Registro guardado con éxito.');
                
                
                document.getElementById(idModal).close();
                formulario.reset();
                
                
                cargar_datos(modulo);
            } else {
                alert('Error: No se pudo guardar el registro en la base de datos.');
            }
        })
        .catch(err => {
            console.error('Error en la petición:', err);
            alert('Hubo un problema de conexión al guardar.');
        });
    });
}

function abrirModalEditar(modulo) {
    
    let idRegistro = null;
 
    if (modulo === 'medicamentos') {
        if (!codigoMedicamentoSeleccionado) {
            alert('Primero selecciona un medicamento haciendo clic en su fila.');
            return;
        }
        idRegistro = codigoMedicamentoSeleccionado;
    } else if (modulo === 'categorias') {
        
        if (!codigoMedicamentoSeleccionado) {
            alert('Primero selecciona un medicamento para ver su categoría.');
            return;
        }
        const med = medicamentos.find(m => m.codigo === codigoMedicamentoSeleccionado);
        if (!med?.id_categoria) { alert('El medicamento no tiene categoría asignada.'); return; }
        idRegistro = med.id_categoria;
    } else if (modulo === 'lotes') {
        
        
        if (!codigoMedicamentoSeleccionado) {
            alert('Primero selecciona un medicamento para filtrar sus lotes.');
            return;
        }
        const lote = lotes.find(l => l.codigo === codigoMedicamentoSeleccionado);
        if (!lote) { alert('No hay lotes para este medicamento.'); return; }
        idRegistro = lote.numero;
    }
 
    
    const fd = new FormData();
    fd.append('modulo', modulo);
    fd.append('accion', 'cargar');
 
    if (modulo === 'medicamentos') fd.append('codigo', idRegistro);
    else if (modulo === 'categorias') fd.append('id_categoria', idRegistro);
    else if (modulo === 'lotes') fd.append('num_lote', idRegistro);
 
    fetch('edit.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            if (!data || data.res === false) { alert('No se encontró el registro.'); return; }
 
            if (modulo === 'medicamentos') {
                const m = document.getElementById('modalMedicamentoEdit');
                m.querySelector('[name="codigo_original"]').value  = data.codigo;
                m.querySelector('[name="codigo"]').value           = data.codigo;
                m.querySelector('[name="nombre_comercial"]').value = data.nombre_comercial;
                m.querySelector('[name="nombre_generico"]').value  = data.nombre_generico  ?? '';
                m.querySelector('[name="forma_farmaceutica"]').value = data.forma_farmaceutica;
                m.querySelector('[name="concentracion"]').value    = data.concentracion;
                m.querySelector('[name="receta"]').value           = data.receta;
                
                const sel = m.querySelector('[name="id_categoria"]');
                sel.innerHTML = '<option value="">Seleccione...</option>' +
                    categorias.map(c => `<option value="${c.id_categoria}" ${c.id_categoria == data.id_categoria ? 'selected' : ''}>${c.nombre}</option>`).join('');
                abrirModal('modalMedicamentoEdit');
 
            } else if (modulo === 'categorias') {
    
            if (!idCategoriaSeleccionada) {
            alert('Primero selecciona una categoría haciendo clic en su fila.');
            return;
            }
            idRegistro = idCategoriaSeleccionada;

            } else if (modulo === 'lotes') {
            if (!numeroLoteSeleccionado) {
            alert('Primero selecciona un lote haciendo clic en su fila.');
            return;
            }
            idRegistro = numeroLoteSeleccionado;
            }
        })
        .catch(err => console.error('Error al cargar para editar:', err));
}
 



function configurarEnvio(idFormulario, modulo, idModal) {
    const formulario = document.getElementById(idFormulario);
    if (!formulario) return;
    formulario.addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(formulario);
        formData.append('modulo', modulo);
        fetch('guardar.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.res === true) {
                    alert('Registro guardado con éxito.');
                    document.getElementById(idModal).close();
                    formulario.reset();
                    cargar_datos(modulo);
                } else {
                    alert('Error: No se pudo guardar el registro.');
                }
            })
            .catch(err => { console.error(err); alert('Error de conexión al guardar.'); });
    });
}
 



function configurarEdicion(idFormulario, modulo, idModal) {
    const formulario = document.getElementById(idFormulario);
    if (!formulario) return;
    formulario.addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(formulario);
        formData.append('modulo', modulo);
        formData.append('accion', 'guardar'); 
        fetch('edit.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.res === true) {
                    alert('Registro actualizado con éxito.');
                    document.getElementById(idModal).close();
                    formulario.reset();
                    cargar_datos(modulo);
                } else {
                    alert('Error: No se pudo actualizar el registro.');
                }
            })
            .catch(err => { console.error(err); alert('Error de conexión al actualizar.'); });
    });
}
 



document.addEventListener('DOMContentLoaded', () => {
    cargar_datos('categorias');
    cargar_datos('medicamentos');
    cargar_datos('lotes');
 
    
    document.getElementById('btnAgregarCategoria')   ?.addEventListener('click', () => abrirModal('modalCategoria'));
    document.getElementById('btnAgregarMedicamento') ?.addEventListener('click', () => abrirModal('modalMedicamento'));
    document.getElementById('btnAgregarLote')        ?.addEventListener('click', () => abrirModal('modalLote'));
 
    
    document.getElementById('btnEditarCategoria')    ?.addEventListener('click', () => abrirModalEditar('categorias'));
    document.getElementById('btnEditarMedicamento')  ?.addEventListener('click', () => abrirModalEditar('medicamentos'));
    document.getElementById('btnEditarLote')         ?.addEventListener('click', () => abrirModalEditar('lotes'));

    
    document.getElementById('btnEliminarCategoria')?.addEventListener('click', () => {
        ejecutarEliminacion('categorias', idCategoriaSeleccionada, "la categoría seleccionada");
    });

    document.getElementById('btnEliminarMedicamento')?.addEventListener('click', () => {
        ejecutarEliminacion('medicamentos', codigoMedicamentoSeleccionado, "el medicamento seleccionado");
    });

    document.getElementById('btnEliminarLote')?.addEventListener('click', () => {
        ejecutarEliminacion('lotes', numeroLoteSeleccionado, "el lote seleccionado");
    });
 
    
    configurarEnvio('formCategoria',   'categorias',   'modalCategoria');
    configurarEnvio('formMedicamento', 'medicamentos', 'modalMedicamento');
    configurarEnvio('formLote',        'lotes',        'modalLote');
 
    
    configurarEdicion('formCategoriaEdit',   'categorias',   'modalCategoriaEdit');
    configurarEdicion('formMedicamentoEdit', 'medicamentos', 'modalMedicamentoEdit');
    configurarEdicion('formLoteEdit',        'lotes',        'modalLoteEdit');
});

function seleccionarCategoria(id) {
    
    if (idCategoriaSeleccionada == id) {
        idCategoriaSeleccionada = null;
    } else {
        idCategoriaSeleccionada = id;
    }
    
    
    codigoMedicamentoSeleccionado = null; 

    
    renderTablaCategorias();
    renderTablaMedicamentos();
    renderTablaLotes();
}

function seleccionarLote(numero) {
    numeroLoteSeleccionado = numeroLoteSeleccionado == numero ? null : numero;
    renderTablaLotes();
}

function ejecutarEliminacion(modulo, idRegistro, nombreAmigable) {
    
    if (!idRegistro) {
        alert(`Por favor, selecciona primero un registro en la tabla para poder eliminarlo.`);
        return;
    }

    
    const confirmar = confirm(`¿Estás completamente seguro de que deseas eliminar ${nombreAmigable}? Esta acción no se puede deshacer.`);
    if (!confirmar) return;

    
    const fd = new FormData();
    fd.append('modulo', modulo);
    fd.append('id', idRegistro);

    fetch('eliminar.php', {
        method: 'POST',
        body: fd
    })
    .then(response => response.json())
    .then(data => {
        if (data.res === true) {
            alert('El registro ha sido eliminado exitosamente.');

            
            if (modulo === 'categorias') idCategoriaSeleccionada = null;
            if (modulo === 'medicamentos') codigoMedicamentoSeleccionado = null;
            if (modulo === 'lotes') numeroLoteSeleccionado = null;

            
            cargar_datos(modulo);
        } else {
            
            alert(data.error || 'Error: No se pudo eliminar el registro.');
        }
    })
    .catch(err => {
        console.error('Error en la eliminación:', err);
        alert('Ocurrió un problema de red o conexión al intentar eliminar.');
    });
}