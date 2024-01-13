<?php

namespace App\Models;

use CodeIgniter\Model;

class m_tanah extends Model
{
    protected $table = 'tanah';
    public function get_all_data()
    {
        $builder = $this->db->table('tanah');
        return $builder->get()->getResultArray();
    }

    public function caritanah()
    {
        $request = service('request');
        $keywordtanah = $request->getPost('keywordtanah');
    
        return $this->table('tanah')
                    ->like('pemilik', $keywordtanah);
    }
}
