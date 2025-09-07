<?= $header ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Registrar Recurso</h3>
        </div>
        <div class="card-body">
            <form id="formRecurso" action="<?= base_url('recursos/guardar') ?>" method="post" enctype="multipart/form-data">

                <!-- Título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Nombre del libro" required>
                </div>

                <!-- Tipo -->
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select" required>
                        <option value="">-- Seleccionar --</option>
                        <option value="FISICO">Físico</option>
                        <option value="DIGITAL">Digital</option>
                    </select>
                </div>

                <!-- Año de publicación -->
                <div class="mb-3">
                    <label for="apublicacion" class="form-label">Año de publicación</label>
                    <input type="number" id="apublicacion" name="apublicacion" class="form-control" min="1900" max="<?= date('Y') ?>" required>
                </div>

                <!-- ISBN -->
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="form-control" placeholder="Código ISBN">
                </div>

                <!-- Número de páginas -->
                <div class="mb-3">
                    <label for="numpaginas" class="form-label">Número de páginas</label>
                    <input type="number" id="numpaginas" name="numpaginas" class="form-control">
                </div>

                <!-- Editorial -->
                <div class="mb-3">
                    <label for="ideditorial" class="form-label">Editorial</label>
                    <select name="ideditorial" id="ideditorial" class="form-select" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach($editoriales as $e): ?>
                            <option value="<?= $e['ideditorial'] ?>"><?= $e['empresa'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Categoría -->
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select id="categoria" class="form-select" required>
                        <option value="">-- Seleccionar --</option>
                        <?php 
                        $categorias = array_unique(array_column($subcategorias, 'categoria'));
                        foreach($categorias as $cat): ?>
                            <option value="<?= $cat ?>"><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Subcategoría -->
                <div class="mb-3">
                    <label for="idsubcategoria" class="form-label">Subcategoría</label>
                    <select name="idsubcategoria" id="idsubcategoria" class="form-select" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach($subcategorias as $s): ?>
                            <option value="<?= $s['idsubcategoria'] ?>" data-categoria="<?= $s['categoria'] ?>">
                                <?= $s['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Portada -->
                <div class="mb-3">
                    <label for="rutaportada" class="form-label">Portada (imagen)</label>
                    <input type="file" id="rutaportada" name="rutaportada" class="form-control" accept="image/*" required>
                </div>

                <!-- PDF (solo Digital) -->
                <div class="mb-3" id="pdfDiv" style="display:none;">
                    <label for="rutarecurso" class="form-label">Archivo PDF (solo para DIGITAL)</label>
                    <input type="file" id="rutarecurso" name="rutarecurso" class="form-control" accept="application/pdf">
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="<?= base_url('recursos') ?>" class="btn btn-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const tipoSelect = document.getElementById('tipo');
    const pdfDiv = document.getElementById('pdfDiv');

    // Mostrar campo PDF solo si es digital
    tipoSelect.addEventListener('change', () => {
        pdfDiv.style.display = (tipoSelect.value === 'DIGITAL') ? 'block' : 'none';
    });

    // Filtrar subcategorías según categoría
    const categoriaSelect = document.getElementById('categoria');
    const subcategoriaSelect = document.getElementById('idsubcategoria');

    categoriaSelect.addEventListener('change', () => {
        const categoria = categoriaSelect.value;

        for (let option of subcategoriaSelect.options) {
            if(option.value === "") continue; // mantener placeholder
            option.style.display = (option.dataset.categoria === categoria) ? 'block' : 'none';
        }

        subcategoriaSelect.value = ""; // reset selección
    });

    // Validación de título
    document.getElementById('formRecurso').addEventListener('submit', function(e) {
        const titulo = this.titulo.value.trim();
        if(titulo === '') {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El título es obligatorio'
            });
        }
    });
</script>

<?= $footer ?>
