<?php namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    
    protected $allowedFields = ['nombre', 'apellido', 'telefono', 'correo'];

    protected $useTimestamps = 'true';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nombre'    => 'required|alpha_space|min_length[3]|max_lenght[75]',
        'apellido'  => 'required|alpha_space|min_length[3]|max_lenght[75]',
        'telefono'  => 'required|numeric|min_length[8]|max_lenght[8]',
        'correo'    => 'permit_empty|valid_email|max_lenght[85]',
    ];

    protected $validationMessage = [
        'correo' => [
            'valid_email' => 'Estimado usuario, debe ingresar un correo válido'
        ]
    ];

    protected $skipValidation = false;
}