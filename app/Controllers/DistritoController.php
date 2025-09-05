<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Distrito;

class DistritoController extends BaseController
{
    public function getDistritosByProvincia($idprovincia = "")
    {
        $this->response->setContentType('application/json');

        $distrito = new Distrito();

        $listaDistritos = $distrito->where('idprovincia', $idprovincia)
                                   ->orderBy('distrito', 'ASC')
                                   ->findAll();

        return $this->response->setJSON($listaDistritos);
    }
}
