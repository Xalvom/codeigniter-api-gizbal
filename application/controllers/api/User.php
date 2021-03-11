<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct()
    {

        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('User_model', 'user');
    }

    public function index_get()
    {

        $id = $this->get('id_user');

        if ($id === null) {
            $user = $this->user->getUser();
            $this->response([
                'status' => true,
                'data' => $user
            ], 200);
        } else {
            $user = $this->user->getUser($id);
        }

        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user,
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
        $id_user = $this->delete('id_user');

        if ($id_user === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ], 400);
        } else {
            if ($this->user->deleteUser($id_user) > 0) {
                $this->response([
                    'status' => true,
                    'id_user' => $id_user,
                    'messsage' => 'deleted.'
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], 404);
            }
        }
    }

    public function index_post()
    {

        $data = [
            'nama_user' => $this->post('nama_user'),
            'email_user' => $this->post('email_user'),
            'password_user' => md5($this->post('password_user')),
            'level_user' => $this->post('level_user'),
            'is_aktif' => 0
        ];

        if ($this->user->createUser($data) > 0) {
            $this->response([
                'status' => true,
                'messsage' => 'Data User Terbaru Sudah Di Tambahkan'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Menambahkan Data User'
            ], 400);
        }
    }

    public function index_put()
    {
        $id_user = $this->put('id_user');

        $data = [
            'nama_user' => $this->put('nama_user'),
            'email_user' => $this->put('email_user'),
            'password_user' => $this->put('password_user'),
            'level_user' => $this->put('level_user'),
            'is_aktif' => $this->put('is_aktif')
        ];

        if ($this->user->updateUser($data, $id_user) > 0) {
            $this->response([
                'status' => true,
                'messsage' => 'Data Balita Sudah Di Update'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Untuk Mengupdate Data'
            ], 400);
        }
    }

    public function login_get()
    {
        $email_user = $this->get('email_user');
        $password_user = md5($this->get('password_user'));

        $user = $this->user->loginUser($email_user);
        $userAp = $this->user->loginUserApp($email_user, $password_user);
        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user,
                'message' => 'Login Berhasil'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Login Gagal'
            ], 400);
        }
        if ($userAp) {
            $this->response([
                'status' => true,
                'data' => $user,
                'message' => 'Login Berhasil'
            ], 200);
        }
    }
    public function loginApp_get()
    {
        $email_user = $this->get('email_user');
        $password_user = md5($this->get('password_user'));

        $userAp = $this->user->loginUserApp($email_user, $password_user);
        foreach ($userAp as $m) {
            $level_user = $m['level_user'];
            $is_aktif = $m['is_aktif'];
        }
        if ($userAp) {
            if ($level_user === '2') {
                if ($is_aktif === '1') {
                    $this->response([
                        'status' => true,
                        'data' => $userAp,
                        'message' => 'Login Berhasil'
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Akun anda belum di aktifkan oleh admin'
                    ], 400);
                }
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Akun anda bukan sebagai member'
                ], 400);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Login Gagal'
            ], 400);
        }
    }

    public function role_get()
    {

        $user = $this->user->joinUser();
        $this->response([
            'status' => true,
            'data' => $user
        ], 200);
        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user,
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
