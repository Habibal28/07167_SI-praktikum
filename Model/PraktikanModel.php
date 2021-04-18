<?php 
    class PraktikanModel{
        /**
         * function get berfungsi untuk mengambil seluruh data praktikan
         * @param integer id berisi id praktikan
         */
        public function get($id)
        {
            $sql = "SELECT * FROM praktikan WHERE id = $id";
            $query = koneksi()->query($sql);
            return $query->fetch_assoc();
        }

        /**
         * function index berfungsi untuk mengatur tampilan awal halaman praktikan
         */
        public function index()
        {
            $id = $_SESSION['praktikan']['id'];
            $data = $this->get($id);
            extract($data);
            require_once("View/praktikan/index.php");
        }

        /**
         * function getPraktikum berfungsi untuk mengambil seluruh data praktikum yang aktif
         */
        public function getPraktikum()
        {
            $sql = "SELECT * FROM praktikum WHERE status = 1";
            $query = koneksi()->query($sql);
            $hasil=[];
            while($data = $query->fetch_assoc())
            {
                $hasil[]= $data;
            }
            return $hasil;
        }

        /**
         * function daftarPraktikum berfungsi untuk mengatur tampilan halaman daftar praktikum 
         */
        public function daftarpraktikum()
        {
            $data = $this->getPraktikum();
            extract($data);
            require_once("View/praktikan/daftarPraktikum.php");
        }

        /**
         * function getPendaftaranPraktikum berfungsi untuk mengambil data pendaftaran praktikum praktikan
         */
        public function getPendaftaranPraktikum($idPraktikan)
        {
            $sql = "SELECT daftarprak.id as idDaftar, praktikum.nama as namaPraktikum,
            praktikum.id as idPraktikum, daftarprak.status as status FROM daftarprak
            JOIN praktikum ON praktikum.id = daftarprak.praktikum_id
            WHERE daftarprak.praktikan_id = $idPraktikan"; 
            $query = koneksi()->query($sql);
            $hasil=[];
            while($data = $query->fetch_assoc())
            {
                $hasil[]= $data;
            }
            return $hasil;
        }

        /**
         * function praktikum berfungsi untuk mengatur tampilan halaman praktikum praktikan
         */
        public function praktikum()
        {
            $idPraktikan=$_SESSION['praktikan']['id'];
            $data = $this->getPendaftaranPraktikum($idPraktikan);
            extract($data);
            require_once("View/praktikan/praktikum.php");
        }

        /**
         * function getModul berfungsi untuk mengambil data modul dari praktikum yang aktif
         */
        public function getModul()
        {
            $sql="SELECT modul.id as idModul, modul.nama as namaModul FROM modul
            JOIN praktikum ON praktikum.id=modul.praktikum_id
            WHERE praktikum.status = 1";
            $query = koneksi()->query($sql);
            $hasil=[];
            while($data = $query->fetch_assoc())
            {
                $hasil[]= $data;
            }
            return $hasil;
        }

        /**
         * funtion getNilaiPraktikan berfungsi untuk mengambil data nilai praktikan di tiap-tiap praktikum
         * @param integer idPraktikan berisi id praktikan
         * @param integer idPraktikum berisi id praktikum
         */
        public function getNilaiPraktikan($idPraktikan,$idPraktikum)
        {
            $sql = "SELECT * FROM nilai JOIN modul ON modul.id = nilai.modul_id
            WHERE praktikan_id = $idPraktikan AND praktikum_id = $idPraktikum
            ORDER BY modul.id";
            $query = koneksi()->query($sql);
            $hasil=[];
            while($data = $query->fetch_assoc())
            {
                $hasil[]= $data;
            }
            return $hasil;
        }

        /**
         * function nilaiPraktikum berfungsi untuk mengatur halaman nilai praktikum praktikum
         */
        public function nilaiPraktikan()
        {
            $idPraktikan = $_SESSION['praktikan']['id'];
            $idPraktikum = $_GET[idPraktikum];
            $modul = $this->getModul();
            $nilai = $this->getNilaiPraktikan($idPraktikan,$idPraktikum);
            extract($modul);
            extract($nilai);
            require_once("View/praktikan/nilaiPraktikan.php");
        }
       
    }
    // $tes = new praktikanModel();
    // var_export($tes->nilaiPraktikan());
    // die();
?>