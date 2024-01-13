<?php

namespace App\Controllers;
use App\Models\m_tanah;

class Home extends BaseController
{
    protected $db;
    protected $m_tanah;

    public function __construct()
    {
        $this->m_tanah = new m_tanah();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = array(
            'title' => 'WebGIS',
            'tanah' => $this->m_tanah->get_all_data(),
            'isi' => 'v_home'
        );
        $data['idtanah'] = null;

        echo view('template/v_wrapper', $data);
    }
}
