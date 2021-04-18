<?php 
    class praktikumModel{
        /**
         * function get berfungsi untuk mengambil seluruh data dari database
         */
        public function get()
        {
            $sql ="SELECT * FROM praktikum";
            $query=koneksi()->query($sql);
            $hasil =[];
            while($data = $query->fetch_assoc())
            {
                $hasil[]= $data;
            }
            return $hasil;
        }

        /**
         * function index berfungsi untuk mengeatur tampilan awal
         */
        public function index()
        {
            $data = $this->get();
            extract($data);
            require_once("View/praktikum/index.php");
        }
    }
    // $tes = new praktikumModel();
    // var_export($tes->get());
    // die();
?>