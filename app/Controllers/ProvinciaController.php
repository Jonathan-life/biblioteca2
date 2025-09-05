<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Provincia;

class ProvinciaController extends BaseController
{
    public function getProvinciasByDepartamento($iddepartamento = "")
    {  
       $this->response->setContentType('application/json');
       // return $this->response->setJSON(['message' => $iddepartamento]);

       $provincia = new Provincia();

       $listaProvincias = $provincia->where('iddepartamento', $iddepartamento)
                                    ->orderBy('provincia', 'ASC')
                                    ->findAll();

      return $this->response->setJSON($listaProvincias);
      
    }
}

