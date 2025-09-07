<?= $header ?>

<div class="container mt-4">
    <h2>Editar Recurso</h2>

    <form action="<?= base_url('recursos/actualizar/'.$recurso['idrecurso']) ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="<?= $recurso['titulo'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-control" required>
                <option value="FISICO" <?= ($recurso['tipo']=="FISICO")?'selected':'' ?>>Físico</option>
                <option value="DIGITAL" <?= ($recurso['tipo']=="DIGITAL")?'selected':'' ?>>Digital</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Año de publicación</label>
            <input type="number" name="apublicacion" class="form-control" min="1900" max="2099" value="<?= $recurso['apublicacion'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Editorial</label>
            <select name="ideditorial" class="form-control" required>
                <?php foreach($editoriales as $e): ?>
                    <option value="<?= $e['ideditorial'] ?>" <?= ($recurso['ideditorial']==$e['ideditorial'])?'selected':'' ?>>
                        <?= $e['empresa'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Subcategoría</label>
            <select name="idsubcategoria" class="form-control" required>
                <?php foreach($subcategorias as $s): ?>
                    <option value="<?= $s['idsubcategoria'] ?>" <?= ($recurso['idsubcategoria']==$s['idsubcategoria'])?'selected':'' ?>>
                        <?= $s['categoria'] ?> - <?= $s['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Portada existente -->
        <div class="mb-3">
            <label>Portada actual</label><br>
            <?php if(!empty($recurso['rutaportada'])): ?>
                <img src="<?= base_url($recurso['rutaportada']) ?>" alt="Portada" style="width:80px;">
            <?php else: ?>
                <span>No hay portada</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Subir nueva portada</label>
            <input type="file" name="rutaportada" class="form-control" accept="image/*">
        </div>

        <!-- Archivo PDF existente -->
        <?php if($recurso['tipo'] == 'DIGITAL'): ?>
        <div class="mb-3">
            <label>Archivo digital actual</label><br>
            <?php if(!empty($recurso['rutarecurso'])): ?>
                <a href="<?= base_url($recurso['rutarecurso']) ?>" target="_blank" class="btn btn-sm btn-info">Ver PDF</a>
            <?php else: ?>
                <span>No hay archivo</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Subir nuevo archivo PDF</label>
            <input type="file" name="rutarecurso" class="form-control" accept="application/pdf">
        </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="<?= base_url('recursos') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $footer ?>
