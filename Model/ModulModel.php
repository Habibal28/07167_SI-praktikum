<?php
    class ModulModel{
        /**
         * function get berfungsi untuk mengambil seluruh data dari database
         */
        public function get()
        {
            $sql ="select modul.id as id , praktikum.nama as praktikum , praktikum.status as status , modul.nama as nama
            from modul JOIN praktikum on modul.praktikum_id = praktikum.id where praktikum.status=1"; 
            $query = koneksi()->query($sql);
            $hasil =[];
            while($data = $query->fetch_assoc())
            {
                $hasil[]= $data;
            }
            return $hasil;
        }

        /**
         * function index berfungsi untuk mengatur tampilan awal
         */
        public function index()
        {
            $data=$this->get();
            extract($data);
            require_once(View/modul/index.php);
        }
    }
    // $tes = new ModulModel();
    // var_export($tes->get());
    // die();
?>