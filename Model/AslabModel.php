<?php 
    class AslabModel{
        /** 
         * function get berfungsi untuk mengambil seluruh data praktikan dari database
         */
        public function get($idaslab){
            $sql = "SELECT praktikan.id as idPraktikan, praktikan.nama as namaPraktikan,
            praktikan.npm as npmPraktikan, praktikan.nomor_hp as nohpPraktikan,
            praktikum.nama as namaPraktikum FROM praktikan 
            JOIN daftarprak ON daftarprak.praktikan_id = praktikan.id
            JOIN praktikum ON daftarprak.praktikum_id = praktikum.id
            WHERE daftarprak.status = 1
            AND daftarprak.aslab_id = $idaslab
            AND praktikum.status = 1";

            $query = koneksi()->query($sql);
            $hasil = [];
            while($data = $query->fetch_assoc())
            {
                $hasil[] = $data;
            }
            return $hasil;
        }
            /** 
            * funtion index berfungsi untuk mengatur tampilan awal
            */ 
            public function index()
            {
                $idAslab = $_SESSION['aslab']['id'];
                $data = $this->get($idAslab);
                extract($data);
                require_once("View/aslab/index.php");
            }
            
            /**
             * funtion get modul berfungsi untuk mengambil seluruh data modul  
             */
            public function getModul()
            {
                $sql = "SELECT modul.id as idModul, modul.nama as namaModul
                FROM modul JOIN praktikum ON praktikum.id = modul.praktikum_id
                WHERE praktikum.status = 1 ";
                $query = koneksi()->query($sql);
                $hasil = [];
                while($data = $query->fetch_assoc())
                {
                    $hasil[] = $data;
                }
                return $hasil;
            }

            /**
             * @param integer $idPraktikan berisi idPraktikan
             * funtion getNilaiPRaktikan berfungsi untuk mengambil seluruh data nilai praktikan dari database sesuai dengan idnya
             */
            public function getNilaiPraktikan($idPraktikan)
            {
                $sql = "SELECT * FROM nilai JOIN modul ON modul.id = nilai.modul_id
                WHERE praktikan_id = $idPraktikan ORDER BY modul.id";
                $query = koneksi()->query($sql);
                $hasil=[];
                while($data = $query->fetch_assoc())
                {
                    $hasil[] = $data;
                }
                return $hasil;
            }
            
            /**
             * function nilai berfungsi untuk mengatur tampilah halaman data nilai praktikan
             */
            public function nilai()
            {
                $idPraktikan = $_GET['id'];
                $modul = $this->getModul();
                $nilai = $this->getNilaiPraktikan($idPraktikan);
                extract($modul);
                extract($nilai);
                require_once("View/aslab/nilai.php");
            }

        
    }
    // $tes = new AslabModel();
    // var_export($tes->getNilaiPraktikan(1));
    // die();
?>