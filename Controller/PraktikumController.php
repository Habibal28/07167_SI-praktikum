<?php
    class PraktikumController{
        public function __construct()
        {
            $this->model = new PraktikumModel();
        }
        // Function index berfungsi untuk mengatur tampilan awal 
        public function index(){
        $data = $this->model->get();
        extract($data);
        require_once("View/praktikum/index.php");
            }
       // Function create berfungsi untuk mengatur tmapilan tambah data
         public function create()
         {
        require_once("View/praktikum/create.php"); 
         }
        /**
        * Function store berfungsi untuk memproses data untuk ditambahkan
        * Fungsi ini membutuhkan nama, tahun dengan metode http request POST
        */
        public function store()
        {
            $nama = $_POST['nama'];
            $tahun = $_POST['tahun'];
            if($this->model->prosesStore($nama,$tahun)){
                header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil Menambah Data"); //Jangan ada spasi setelah location
            } else {
                header("location: index.php?page=praktikum&aksi=create&pesan=Gagal Menambah Data"); //Jangan ada spasi setelah location
            }
        }
             /**
             * Function ini berfungsi untuk menampilkan halaman edit
             * juga mengambil data dari database berdasarkan id
             * function membutuhkan data id dengen metode http request GET
             */
            public function edit()
            {
                $id = $_GET['id'];
                $data = $this->model->getById($id);
                extract($data);
                require_once("View/praktikum/edit.php");
            }
        /**
          * Function update berfungsi untuk memproses data untuk di update
          * Fungsi ini membutuhkan data nama, tahun dengan metode http request POST
          */
          public function update()
          {
              $id = $_POST['id'];
              $nama = $_POST['nama'];
              $tahun = $_POST['tahun'];
  
              if($this->model->storeUpdate($nama,$tahun,$id)){
                    header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil Mengubah Data"); //Jangan ada spasi setelah location
              } else {
                    header("location: index.php?page=praktikum&aksi=edit&pesan=Gagal Mengubah Data"); //Jangan ada spasi setelah location
              }
          }
          /**
             * Function befungsi untuk memproses update salah satu field data
             * Function ini membutuhkan data id dengan metode http request GET
             */
          public function aktifkan()
          {
              $id = $_GET['id'];
              if($this->model->prosesAktifkan($id)){
                  header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil Men-Aktifkan Data"); //Jangan ada spasi setelah location
              }else{
                  header("location: index.php?page=praktikum&aksi=view&pesan=Gagal Men-Aktifkan Data"); //Jangan ada spasi setelah location
              }
          }
          /**
              * Function befungsi untuk memproses update salah satu field data
              * Function ini membutuhkan data id dengan metode http request GET
              */
              public function nonAktifkan()
              {
                  $id = $_GET['id'];
              if($this->model->prosesnonAktifkan($id)){
                  header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil non-Aktifkan Data"); //Jangan ada spasi setelah location
              }else{
                  header("location: index.php?page=praktikum&aksi=view&pesan=Gagal non-Aktifkan Data"); //Jangan ada spasi setelah location
                  }
              }
            }

?>