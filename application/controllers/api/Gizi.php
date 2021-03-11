<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Gizi extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct()
    {

        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Gizi_model', 'gizi');
    }

    public function index_get()
    {
        $id = $this->get('id_gizibbu');

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

    public function IdTabel_get()
    {

        $gizi = $this->gizi->getIdByTabel();
        $this->response([
            'status' => true,
            'data' => $gizi
        ], 200);
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

    // Ambil Data Berat Badan Berdasarkan Umur
    public function bbu_get()
    {
        $id_balita = $this->get('id_balita');
        if ($id_balita === null) {
            $gizi = $this->gizi->getGiziBbu();
            $this->response([
                'status' => true,
                'data' => $gizi
            ], 200);
        } else {
            $gizi = $this->gizi->getGiziBbu($id_balita);
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

    // Input Berat Badan Berdasarkan Umur
    public function bbu_post()
    {
        $kelamin = $this->post('kelamin');
        $umur = $this->post('umur');
        $berat_badan = $this->post('berat_badan');
        $update_bbu = $this->post('update_bbu');
        $id_balita = $this->post('id_balita');
        // $id_user = $this->post('id_user');


        $md = $this->gizi->getMedian($kelamin, $umur);
        foreach ($md as $m) {
            $median = $m['median'];
        }
        // $plus = $this->gizi->getPlus($kelamin, $umur);
        $ps = $this->gizi->getPlus($kelamin, $umur);
        foreach ($ps as $s) {
            $plus = $s['plus1SD'];
        }
        $mn = $this->gizi->getMin($kelamin, $umur);
        foreach ($mn as $nm) {
            $min = $nm['min1SD'];
        }

        // Jika bb lebih besar dari pada rata2 bb pada tabel maka
        if ($berat_badan >= $median) {
            $nis = $berat_badan - $median;
            $nbr = $plus - $median;
        } else {
            $nis = $berat_badan - $median;
            $nbr = $median - $min;
        }

        $zScore = $nis / $nbr;

        if ($zScore > -2 && $zScore <= 2) {
            $hasil = 'Gizi Baik';
        } else if ($zScore < -3) {
            $hasil = 'Gizi Buruk';
        } else if ($zScore > 2) {
            $hasil = 'Gizi Lebih';
        } else if ($zScore > -3 && $zScore <= -2) {
            $hasil = 'Gizi Kurang';
        }

        $data = [
            'kelamin' => $kelamin,
            'umur' => $umur,
            'berat_badan' => $berat_badan,
            'z-score' => $hasil,
            'update_bbu' => $update_bbu,
            'id_balita' => $id_balita
            // 'id_user' => $id_user
        ];
        if ($this->gizi->inputBBU($data) > 0) {
            $this->response([
                'status' => true,
                'messsage' => 'Data BB / U Terbaru Sudah Di Tambahkan'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Menambahkan Data BB / U'
            ], 400);
        }
    }

    // Ambil Data Tinggi Badan Berdasarkan Umur
    public function tbu_get()
    {

        $id_balita = $this->get('id_balita');
        if ($id_balita === null) {
            $gizi = $this->gizi->getGiziTbu();
            $this->response([
                'status' => true,
                'data' => $gizi
            ], 200);
        } else {
            $gizi = $this->gizi->getGiziTbu($id_balita);
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

    // Input Tinggi Badan Berdasarkan Umur
    public function tbu_post()
    {
        $kelamin = $this->post('kelamin');
        $umur = $this->post('umur');
        $tinggi_badan = $this->post('tinggi_badan');
        $update_tbu = $this->post('update_tbu');
        $id_balita = $this->post('id_balita');
        // $id_user = $this->post('id_user');


        $md = $this->gizi->getMedianTbu($kelamin, $umur);
        foreach ($md as $m) {
            $median = $m['median'];
        }
        // $plus = $this->gizi->getPlus($kelamin, $umur);
        $ps = $this->gizi->getPlusTbu($kelamin, $umur);
        foreach ($ps as $s) {
            $plus = $s['plus1SD'];
        }
        $mn = $this->gizi->getMinTbu($kelamin, $umur);
        foreach ($mn as $nm) {
            $min = $nm['min1SD'];
        }

        // Jika tb lebih besar dari pada rata2 tb pada tabel maka
        if ($tinggi_badan >= $median) {
            $nis = $tinggi_badan - $median;
            $nbr = $plus - $median;
        } else {
            $nis = $tinggi_badan - $median;
            $nbr = $median - $min;
        }

        $zScore = $nis / $nbr;

        if ($zScore > -2 && $zScore <= 2) {
            $hasil = 'Normal';
        } else if ($zScore < -3) {
            $hasil = 'Sangat Pendek';
        } else if ($zScore > 2) {
            $hasil = 'Tinggi';
        } else if ($zScore > -3 && $zScore <= -2) {
            $hasil = 'Pendek';
        }

        $data = [
            'kelamin' => $kelamin,
            'umur' => $umur,
            'tinggi_badan' => $tinggi_badan,
            'z-score' => $hasil,
            'update_tbu' => $update_tbu,
            'id_balita' => $id_balita
            // 'id_user' => $id_user
        ];
        if ($this->gizi->inputTBU($data) > 0) {
            $this->response([
                'status' => true,
                'messsage' => 'Data TB / U Terbaru Sudah Di Tambahkan'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Menambahkan Data TB / U'
            ], 400);
        }
    }

    // Ambil Data Berat Badan Berdasarkan Tinggi Badan
    public function bbtb_get()
    {

        $id_balita = $this->get('id_balita');
        if ($id_balita === null) {
            $gizi = $this->gizi->getGiziBbtb();
            $this->response([
                'status' => true,
                'data' => $gizi
            ], 200);
        } else {
            $gizi = $this->gizi->getGiziBbtb($id_balita);
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
    // Input Tinggi Badan Berdasarkan Umur
    public function bbtb_post()
    {
        $kelamin = $this->post('kelamin');
        $berat_badan = $this->post('berat_badan');
        $tinggi_badan = $this->post('tinggi_badan');
        $kat_umur = $this->post('kat_umur');
        $update_bbtb = $this->post('update_bbtb');
        $id_balita = $this->post('id_balita');
        // $id_user = $this->post('id_user');

        $md = $this->gizi->getMedianBbtb($kelamin, $kat_umur, $tinggi_badan);
        foreach ($md as $m) {
            $median = $m['median'];
        }
        // $plus = $this->gizi->getPlus($kelamin, $umur);
        $ps = $this->gizi->getPlusBbtb($kelamin, $kat_umur, $tinggi_badan);
        foreach ($ps as $s) {
            $plus = $s['plus1SD'];
        }
        $mn = $this->gizi->getMinBbtb($kelamin, $kat_umur, $tinggi_badan);
        foreach ($mn as $nm) {
            $min = $nm['min1SD'];
        }

        // Jika tb lebih besar dari pada rata2 tb pada tabel maka
        if ($berat_badan >= $median) {
            $nis = $berat_badan - $median;
            $nbr = $plus - $median;
        } else {
            $nis = $berat_badan - $median;
            $nbr = $median - $min;
        }

        $zScore = $nis / $nbr;

        if ($zScore > -2 && $zScore <= 2) {
            $hasil = 'Normal';
        } else if ($zScore < -3) {
            $hasil = 'Sangat Kurus';
        } else if ($zScore > 2) {
            $hasil = 'Gemuk';
        } else if ($zScore > -3 && $zScore <= -2) {
            $hasil = 'Kurus';
        }

        $data = [
            'kelamin' => $kelamin,
            'berat_badan' => $berat_badan,
            'tinggi_badan' => $tinggi_badan,
            'z-score' => $hasil,
            'update_bbtb' => $update_bbtb,
            'id_balita' => $id_balita
            // 'id_user' => $id_user
        ];
        if ($this->gizi->inputBBTB($data) > 0) {
            $this->response([
                'status' => true,
                'messsage' => 'Data BB / TB Terbaru Sudah Di Tambahkan'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal Menambahkan Data BB / TB'
            ], 400);
        }
    }
}
