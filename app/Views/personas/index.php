<?= $header; ?>

<div class="container mt-2">
  <div class="my-2">
    <h4>Lista de Personas</h4>
    <a href="<?= base_url("personas/crear"); ?>" class="btn btn-sm btn-info">Registrar</a>
  </div>

  <div class="table-resposive">
    <table class="table table-sm table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Distrito</th>
        <th>Provincia</th>
        <th>Departamento</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($personas as $persona) { ?>
        <tr>
          <td><?= $persona['idpersona']; ?></td>
          <td><?= $persona['nombres']; ?></td>
          <td><?= $persona['apellidos']; ?></td>
          <td><?= $persona['telefono']; ?></td>
          <td><?= $persona['distrito']; ?></td>
          <td><?= $persona['provincia']; ?></td>
          <td><?= $persona['departamento']; ?></td>
          <td>
            <a href="<?= base_url('personas/editar/'.$persona['idpersona']); ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="<?= base_url('personas/eliminar/'.$persona['idpersona']); ?>" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>

    </table>
  </div>

</div>

<?= $footer; ?>