<?= $header ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Recursos</h2>
        <a href="<?= base_url('recursos/crear') ?>" class="btn btn-primary">+ Nuevo Recurso</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Portada</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Año</th>
                    <th>Editorial</th>
                    <th>Categoría</th>
                    <th>Subcategoría</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recursos as $r): ?>
                    <tr>
                        <td><?= $r['idrecurso'] ?></td>
                        <td>
                            <?php if(!empty($r['rutaportada'])): ?>
                                <img src="<?= base_url($r['rutaportada']) ?>" alt="Portada" class="img-thumbnail" style="width:50px; height:auto;">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $r['titulo'] ?></td>
                        <td>
                            <span class="badge <?= $r['tipo']=='DIGITAL' ? 'bg-success' : 'bg-info' ?>">
                                <?= $r['tipo'] ?>
                            </span>
                        </td>
                        <td><?= $r['apublicacion'] ?></td>
                        <td><?= $r['editorial'] ?></td>
                        <td><?= $r['categoria'] ?></td>
                        <td><?= $r['subcategoria'] ?></td>
                        <td>
                            <?php if($r['tipo'] == 'DIGITAL' && !empty($r['rutarecurso'])): ?>
                                <a href="<?= base_url($r['rutarecurso']) ?>" target="_blank" class="btn btn-sm btn-success">Ver PDF</a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="d-flex flex-column gap-1">
                            <a href="<?= base_url('recursos/editar/'.$r['idrecurso']) ?>" class="btn btn-sm btn-warning">✏️ Editar</a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $r['idrecurso'] ?>)">🗑 Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url("recursos/eliminar") ?>/' + id;
        }
    });
}
</script>

<?= $footer ?>
