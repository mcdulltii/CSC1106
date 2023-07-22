<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'form';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['form_id', 'form_blob', 'user_id'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getForms($user_id)
    {
        return $this->where(['user_id' => $user_id])->findAll();
    }

    public function getForm($form_id)
    {
        return $this->where(['form_id' => $form_id])->first();
    }

    public function updateForm($form_id, $data)
    {
        return $this->where(['form_id' => $form_id])->set($data)->update();
    }

    public function deleteForm($form_id)
    {
        return $this->where(['form_id' => $form_id])->delete();
    }
}
