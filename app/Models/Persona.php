<?php

namespace App\Models;
use CodeIgniter\Model;

class Persona extends Model
{
    protected $table      = 'personas';
    protected $primaryKey = 'idpersona';
    protected $allowedFields = ['dni','nombres', 'apellidos', 'telefono', 'iddistrito','direccion'];

        public function obtenerPersonasConUbigeo()
        {
            return $this->select('personas.*, distritos.distrito, provincias.provincia, departamentos.departamento')
                ->join('distritos', 'personas.iddistrito = distritos.iddistrito')
                ->join('provincias', 'distritos.idprovincia = provincias.idprovincia')
                ->join('departamentos', 'provincias.iddepartamento = departamentos.iddepartamento')
                ->findAll();
        }

}
