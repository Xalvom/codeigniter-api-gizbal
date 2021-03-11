<?php 
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends CI_Controller{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Mahasiswa_model','mhs');

        $this->methods['index_get']['limit'] = 5;
    }
    public function index_get(){
        
        $id = $this->get('id');
        if($id === null){
            $mhs = $this->mhs->getMhs();
        }else{
            $mhs = $this->mhs->getMhs($id);

        }

        if($mhs){
           $this->response($mhs, 200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], 404);
        }
        
    }

    public function index_delete(){

        $id = $this->delete('id');

        if($id === null){
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ], 400);
        }else{
            if($this->mhs->deleteMahasiswa($id) > 0){
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'messsage' => 'deleted.'
                ], 204);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], 404);
            }
        }
    }

    public function index_post(){
        
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if($this->mhs->createMahasiswa($data)>0){
            $this->response([
                'status' => true,
                'messsage' => 'new mahasiswa has been created'
            ], 201);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed to create new data'
            ], 400);
        }
    }

    public function index_put(){
        $id = $this->put('id');

        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if( $this->mhs->updateMahasiswa($data, $id ) >0 ){
            $this->response([
                'status' => true,
                'messsage' => 'new mahasiswa has been updated'
            ], 204);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed to create update data'
            ], 400);
        }
    }
}

?>