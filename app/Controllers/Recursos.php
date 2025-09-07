<?php
namespace App\Controllers;

use App\Models\RecursoModel;
use CodeIgniter\Controller;

class Recursos extends Controller
{
    // LISTAR RECURSOS
    public function index()
    {
        $db = db_connect();
        $recursos = $db->query("
            SELECT r.idrecurso, r.titulo, r.tipo, r.apublicacion,
                   e.empresa AS editorial, c.nombre AS categoria, s.nombre AS subcategoria,
                   r.rutaportada, r.rutarecurso
            FROM recursos r
            JOIN subcategorias s ON r.idsubcategoria = s.idsubcategoria
            JOIN categorias c ON s.idcategoria = c.idcategoria
            JOIN editoriales e ON r.ideditorial = e.ideditorial
        ")->getResultArray();

        $data = [
            'recursos' => $recursos,
            'header'   => view('Layouts/header'),
            'footer'   => view('Layouts/footer')
        ];

        return view('recursos/listar', $data);
    }

    // CREAR NUEVO RECURSO
    public function crear()
    {
        $db = db_connect();
        $data = [
            'editoriales'   => $db->table('editoriales')->get()->getResultArray(),
            'subcategorias' => $db->query("
                SELECT s.idsubcategoria, s.nombre, c.nombre AS categoria
                FROM subcategorias s
                JOIN categorias c ON s.idcategoria = c.idcategoria
            ")->getResultArray(),
            'header' => view('Layouts/header'),
            'footer' => view('Layouts/footer')
        ];

        return view('recursos/crear', $data);
    }

    // GUARDAR NUEVO RECURSO
    public function guardar()
    {
        $model = new RecursoModel();

        $rutaportada = $this->request->getFile('rutaportada');
        $rutarecurso = $this->request->getFile('rutarecurso');

        $data = [
            'titulo'        => $this->request->getPost('titulo'),
            'tipo'          => $this->request->getPost('tipo'),
            'apublicacion'  => $this->request->getPost('apublicacion'),
            'ideditorial'   => $this->request->getPost('ideditorial'),
            'idsubcategoria'=> $this->request->getPost('idsubcategoria'),
            'isbn'          => $this->request->getPost('isbn'),
            'numpaginas'    => $this->request->getPost('numpaginas'),
            'estado'        => 'BUENO',
            'creado'        => date('Y-m-d H:i:s')
        ];

        // Subir portada
        if ($rutaportada && $rutaportada->isValid() && !$rutaportada->hasMoved()) {
            $nombrePortada = $rutaportada->getRandomName();
            $rutaportada->move('uploads/portadas', $nombrePortada);
            $data['rutaportada'] = 'uploads/portadas/' . $nombrePortada;
        }

        // Subir recurso PDF si es DIGITAL
        if ($rutarecurso && $rutarecurso->isValid() && !$rutarecurso->hasMoved() && $this->request->getPost('tipo') == 'DIGITAL') {
            $nombreRecurso = $rutarecurso->getRandomName();
            $rutarecurso->move('uploads/recursos', $nombreRecurso);
            $data['rutarecurso'] = 'uploads/recursos/' . $nombreRecurso;
        }

        $model->insert($data);
        return redirect()->to(base_url('recursos'));
    }

    // EDITAR RECURSO
    public function editar($id)
    {
        $db = db_connect();
        $model = new RecursoModel();

        $data = [
            'recurso'       => $model->find($id),
            'editoriales'   => $db->table('editoriales')->get()->getResultArray(),
            'subcategorias' => $db->query("
                SELECT s.idsubcategoria, s.nombre, c.nombre AS categoria
                FROM subcategorias s
                JOIN categorias c ON s.idcategoria = c.idcategoria
            ")->getResultArray(),
            'header' => view('Layouts/header'),
            'footer' => view('Layouts/footer')
        ];

        return view('recursos/editar', $data);
    }

    // ACTUALIZAR RECURSO
    public function actualizar($id)
    {
        $model = new RecursoModel();

        $rutaportada = $this->request->getFile('rutaportada');
        $rutarecurso = $this->request->getFile('rutarecurso');

        $data = [
            'titulo'        => $this->request->getPost('titulo'),
            'tipo'          => $this->request->getPost('tipo'),
            'apublicacion'  => $this->request->getPost('apublicacion'),
            'ideditorial'   => $this->request->getPost('ideditorial'),
            'idsubcategoria'=> $this->request->getPost('idsubcategoria'),
            'isbn'          => $this->request->getPost('isbn'),
            'numpaginas'    => $this->request->getPost('numpaginas'),
            'modificado'    => date('Y-m-d H:i:s')
        ];

        // Subir portada si se reemplaza
        if ($rutaportada && $rutaportada->isValid() && !$rutaportada->hasMoved()) {
            $recurso = $model->find($id);
            if (!empty($recurso['rutaportada']) && file_exists($recurso['rutaportada'])) {
                @unlink($recurso['rutaportada']);
            }
            $nombrePortada = $rutaportada->getRandomName();
            $rutaportada->move('uploads/portadas', $nombrePortada);
            $data['rutaportada'] = 'uploads/portadas/' . $nombrePortada;
        }

        // Subir recurso PDF si es DIGITAL y se reemplaza
        if ($rutarecurso && $rutarecurso->isValid() && !$rutarecurso->hasMoved() && $this->request->getPost('tipo') == 'DIGITAL') {
            $recurso = $model->find($id);
            if (!empty($recurso['rutarecurso']) && file_exists($recurso['rutarecurso'])) {
                @unlink($recurso['rutarecurso']);
            }
            $nombreRecurso = $rutarecurso->getRandomName();
            $rutarecurso->move('uploads/recursos', $nombreRecurso);
            $data['rutarecurso'] = 'uploads/recursos/' . $nombreRecurso;
        }

        $model->update($id, $data);
        return redirect()->to(base_url('recursos'));
    }

    // ELIMINAR RECURSO
    public function eliminar($id)
    {
        $model = new RecursoModel();
        $recurso = $model->find($id);

        // Eliminar archivos si existen
        if (!empty($recurso['rutaportada']) && file_exists($recurso['rutaportada'])) {
            @unlink($recurso['rutaportada']);
        }
        if (!empty($recurso['rutarecurso']) && file_exists($recurso['rutarecurso'])) {
            @unlink($recurso['rutarecurso']);
        }

        $model->delete($id);
        return redirect()->to(base_url('recursos'));
    }
}
