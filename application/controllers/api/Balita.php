<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Balita extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct()
    {

        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Balita_model', 'balita');
    }

    public function index_get()
    {

        $id = $this->get('id_balita');

        if ($id === null) {
            $balita = $this->balita->getBalita();
            $this->response([
                'status' => true,
                'data' => $balita
            ], 200);
        } else {
            $balita = $this->balita->getBalita($id);
        }

        if ($balita) {
            $this->response([
                'status' => true,
                'data' => $balita,
                'message' => 'ID Di Temukan'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'ID Tidak di temukan'
            ], 404);
        }
    }

    public function index_delete()
    {
        $id_balita = $this->delete('id_balita');

        if ($id_balita === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ], 400);
        } else {
            if ($this->balita->deleteBalita($id_balita) > 0) {
                $this->response([
                    'status' => true,
                    'id_balita' => $id_balita,
                    'messsage' => 'Data Balita sudah di hapus.'
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Id Tidak Di Temukan'
                ], 404);
            }
        }
    }

    public function index_post()
    {

        $data = [
            'nama_balita' => $this->post('nama_balita'),
            'alamat_balita' => $this->post('alamat_balita'),
            'tgllahir_balita' => $this->post('tgllahir_balita'),
            'kelamin_balita' => $this->post('kelamin_balita'),
            'id_user' => $this->post('id_user')
        ];

        if ($this->balita->createBalita($data) > 0) {
            $this->response([
                'status' => true,
                'messsage' => 'Data Balita Terbaru Sudah Di Tambahkan'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Menambahkan Data Balita'
            ], 400);
        }
    }

    public function index_put()
    {
        $id_balita = $this->put('id_balita');

        $data = [
            'id_balita' => $this->put('id_balita'),
            'nama_balita' => $this->put('nama_balita'),
            'alamat_balita' => $this->put('alamat_balita'),
            'tgllahir_balita' => $this->put('tgllahir_balita'),
            'kelamin_balita' => $this->put('kelamin_balita'),
            'id_user' => $this->put('id_user')
        ];

        if ($this->balita->updateBalita($data, $id_balita) > 0) {
            $this->response([
                'status' => true,
                'messsage' => 'Data Balita Sudah Di Perbaharui'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Untuk Memperbaharui Data'
            ], 400);
        }
    }

    public function balitaId_get()
    {
        $id = $this->get('id_user');

        if ($id === null) {
            $balita = $this->balita->getBalitaById();
            $this->response([
                'status' => true,
                'data' => $balita
            ], 200);
        } else {
            $balita = $this->balita->getBalitaById($id);
        }

        if ($balita) {
            $this->response([
                'status' => true,
                'data' => $balita,
                'message' => 'ID User Di Temukan'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'ID User Tidak di temukan'
            ], 404);
        }
    }
}
