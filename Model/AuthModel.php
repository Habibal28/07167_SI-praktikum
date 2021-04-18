<?php 
    class AuthModel{
        
        // Function index berfungsi untuk mengatur tampilan awal
        public function index()
        {
            require_once("view/auth/index.php");
        }

        //function login_aslab berfungsi untuk mengatur halaman login aslab
        public function login_aslab()
        {
            require_once("view/auth/login_aslab.php");
        }

        //function login_praktikan berfungsi untuk mengatur halaman login praktikan
        public function login_praktikan()
        {
            require_once("view/auth/login_praktikan.php");
        }

        //function daftarpraktikan berfungsi untuk mengatur tampilah daftar
        public function daftarpraktikan()
        {
            require_once("view/auth/daftar_praktikan.php");
        }

        public function prosesAuthAslab($npm,$password)
        {
            $sql = "SELECT * FROM aslab WHERE npm ='$npm' and password = '$password'";
            $query = koneksi()->query($sql);
            return $query->fetch_assoc();
        }

        //function authaslab untuk authentication aslab
        public function authAslab()
        {
           $npm = $_POST['npm'];
           $password = $_POST['password'];
           $data = $this->prosesAuthAslab($npm,$password);

            if ($data)
            {
                $_SESSION['role'] ='aslab';
                $_SESSION['aslab'] ='$data';
                header('location:index.php?page=aslab&aksi=view & pesan=Berhasil Login');
            }else{
                header('location:index.php?page=auth&aksi=loginAslab & pesan=password atau npmm anda salah !!');
            }
        }
        
        /** Function untuk cek data dari database berdasarkan 
         * @param String $npm berisi npm
         * @param String $password berisi password
         */
        public function prosesAuthPraktikan($npm,$password){
            $sql = "SELECT * FROM praktikan WHERE npm ='$npm' and password = '$password'";
            $query = koneksi()->query($sql);
            return $query->fetch_assoc();
        }

         //function authaslab untuk authentication praktikan
        public function authPraktikan()
        {
            $npm = $_POST['npm'];
            $password = $_POST['password'];
            $data = $this->prosesAuthPraktikan($npm,$password);

            if ($data)
            {
                $_SESSION['role'] ='praktikan';
                $_SESSION['praktikan'] ='$data';
                header('location:index.php?page=praktikan&aksi=view & pesan=Berhasil Login');
            }else{
                header('location:index.php?page=auth&aksi=loginPraktikan & pesan=password atau npmm anda salah !!');
            }
        }

        public function logout(){
            session_destroy();
            header('location:index.php?page=auth&aksi=view & pesan=Berhasil Logout');
        }
    }
    // $coba = new AuthModel();
    // var_export($coba->prosesAuthAslab('06.2018.1.07002','123'));
    // die();
?>