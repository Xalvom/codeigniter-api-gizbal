<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Bbu extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct()
    {

        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Bbu_model', 'gizi');
    }

    public function bbu_get()
    {
        $id = $this->get('id_bbu');

        if ($id === null) {
            $gizi = $this->gizi->getBbu();
            $this->response([
                'status' => true,
                'data' => $gizi
            ], 200);
        } else {
            $gizi = $this->gizi->getBbu($id);
        }

        if ($gizi) {
            $this->response([
                'status' => true,
                'data' => $gizi,
                'message' => 'ID Di Temukan'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'ID Tidak di temukan'
            ], 404);
        }
    }
}
