<?= $header; ?>
<style>
  .form-control:focus, .form-select:focus {
    background-color: aliceblue;
  }
</style>

<div class="container mt-2">
  <div class="my-2">
    <h4>Registro de Personas</h4>
    <a href="<?= base_url("personas"); ?>">Volver</a>
  </div>
  <form action="<?= base_url('personas/guardar'); ?>" method="POST">
    <div class="card">
      <div class="card-body">

        <div class="mb-2">
          <label for="dni">Buscador por DNI</label><small id="searching" class="d-none"> - Buscando datos</small>
          <div class="input-group">
            <input type="text" class="form-control" id="dni" name ="dni" maxlength="8" placeholder="DNI" required>
            <button class="btn btn-sm btn-outline-secondary" type="button" id="buscar-dni">Buscar</button>
          </div>
        </div>
        

        <div class="row g-2">
          <div class="col-md-6 mb-2">
            <label for="nombres">Nombres</label>
            <input type="text" class="form-control" id="nombres" name ="nombres" placeholder="Nombres" required>
          </div>
          <div class="col-md-6 mb-2">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name ="apellidos" placeholder="Apellidos" required>
          </div>
        </div>

        <div class="row g-2">
          <div class="col-md-3 mb-2">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name ="telefono" placeholder="Teléfono" required>
          </div>
          <div class="col-md-9 mb-2">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name ="direccion" placeholder="Dirección">
          </div>
        </div>

<div class="row g-2">
  <div class="col-md-4 mb-2">
    <label for="departamentos">Departamentos</label>
    <select name="departamentos" id="departamentos" class="form-select" required>
      <option value="">Seleccione un departamento</option>
      <?php foreach($departamentos as $dep): ?>
        <option value="<?= $dep['iddepartamento']; ?>"><?= $dep['departamento']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4 mb-2">
    <label for="provincias">Provincias</label>
    <select name="provincias" id="provincias" class="form-select" required>
      <option value="">Seleccione una provincia</option>
    </select>
  </div>
  <div class="col-md-4 mb-2">
    <label for="iddistrito">Distritos</label>
    <select name="distritos" id="distritos" class="form-select" required>
      <option value="">Seleccione un distrito</option>
    </select>   

  </div>
</div>


      </div>

      <div class="card-footer text-end">
    <button class="btn btn-sm btn-outline-secondary" type="button" onclick="window.location.href='<?= base_url('personas'); ?>'">Cancelar</button>
    <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
      </div>
    </div>
  </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const departamentos = document.querySelector("#departamentos");
  const provincias = document.querySelector("#provincias");
  const distritos = document.querySelector("#distritos");

  const botonBusqueda = document.querySelector("#buscar-dni");
  const dni = document.querySelector("#dni");
  const nombres = document.querySelector("#nombres");
  const apellidos = document.querySelector("#apellidos");
  const buscando = document.querySelector("#searching");

  // Carga provincias al cambiar departamento
  departamentos.addEventListener('change', async () => {
    const iddepartamento = departamentos.value;

    provincias.innerHTML = '<option value="">Seleccione una provincia</option>';
    distritos.innerHTML = '<option value="">Seleccione un distrito</option>';

    if (!iddepartamento) return;

    try {
      const response = await fetch(`<?= base_url('api/ubigeo/provincias/') ?>${iddepartamento}`, {
        method: 'GET',
        headers: { 'content-type': 'application/json' }
      });

      if (!response.ok) throw new Error('Error en la solicitud: ' + response.status);

      const data = await response.json();
      data.forEach(provincia => {
        provincias.innerHTML += `<option value="${provincia.idprovincia}">${provincia.provincia}</option>`;
      });
    } catch (error) {
      console.error('Error al cargar las provincias:', error);
    }
  });

  // Carga distritos al cambiar provincia
  provincias.addEventListener('change', async () => {
    const idprovincia = provincias.value;

    distritos.innerHTML = '<option value="">Seleccione un distrito</option>';

    if (!idprovincia) return;

    try {
      const response = await fetch(`<?= base_url('api/ubigeo/distritos/') ?>${idprovincia}`, {
        method: 'GET',
        headers: { 'content-type': 'application/json' }
      });

      if (!response.ok) throw new Error('Error en la solicitud: ' + response.status);

      const data = await response.json();
      data.forEach(distrito => {
        distritos.innerHTML += `<option value="${distrito.iddistrito}">${distrito.distrito}</option>`;
      });
    } catch (error) {
      console.error('Error al cargar los distritos:', error);
    }
  });

  // Buscador por DNI
  botonBusqueda.addEventListener("click", async () => {
    if (!dni.value) {
      alert('Por favor, ingrese un DNI válido.');
      return;
    }

    try {
      buscando.classList.remove('d-none');
      const response = await fetch(`<?= base_url('api/personas/buscardni/') ?>${dni.value}`, {
        method: 'GET',
        headers: {
          'Authorization': 'Bearer sk_10072.iEPfTIhBGJtcLVrHEelCO3CluNuwejz0',
          'Content-Type': 'application/json'
        }
      });

      if (!response.ok) throw new Error('Error en la solicitud: ' + response.status);

      const data = await response.json();
      buscando.classList.add('d-none');
      console.log(data);

      if (data.success) {
        apellidos.value = `${data.data.first_last_name || ''} ${data.data.second_last_name || ''}`.trim();
        nombres.value = data.data.first_name || '';
      }
    } catch (error) {
      buscando.classList.add('d-none');
      console.error('Error al buscar el DNI:', error);
    }
  });
});
</script>

<?= $footer; ?>