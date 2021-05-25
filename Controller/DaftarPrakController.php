<?php
    class DaftarPrakController{
        private $model;

        public function  __construct(){
            $this->model = new DaftarPrakModel();
        }
        /** Function get berfungsi untuk mengatur tampilan awal halaman daftar praktikum */
         public function index(){
        $data = $this->model->get();
        extract($data);
        require_once("View/daftarprak/index.php");
        }
         /**
         * function verif berfungsi untuk memverifikasi praktikan yang sudah mendaftar praktikum
         */
        public function verif(){
            $id = $_GET['id'];
            $idAslab = $_SESSION['aslab']['id'];
            if ($this->model->prosesVerif($id,$idAslab)){
                header("location: index.php?page=daftarprak&aksi=view&pesan=Berhasil Verif Praktikan");
            }else{
                header("location: index.php?page=daftarprak&aksi=view&pesan=Gagal Verif Praktikan");
            }
        }

        /**
         * function Unverif berfungsi untuk membatalkan verivikasi
         */
        public function unVerif(){
            $id = $_GET['id'];
            $idPraktikan = $_GET['idPraktikan'];
            if ($this->model->prosesUnVerif($id,$idPraktikan)){
                header("location: index.php?page=daftarprak&aksi=view&pesan=Berhasil Un-Verif Praktikan");
            }else{
                header("location: index.php?page=daftarprak&aksi=view&pesan=Gagal Un-Verif Praktikan");
            }
        }
    }
?>