<?php
class AuthModel
{
    //Function index berfungsi untuk mengatur tampilan awal 
    public function index(){
        require_once("View/auth/index.php");
    }

     //Function login_aslab berfungsi untuk mengatur ke halaman login untuk aslab

     public function login_aslab(){
         require_once("View/auth/login_aslab.php");
     }

      //Function login_praktikan berfungsi untuk mengatur ke halaman login untuk praktikan

      public function login_praktikan(){
          require_once("View/auth/login_praktikan.php");
      }

       //Function daftar_praktikan berfungsi untuk mengatur tampilan daftar
       public function daftarpraktikan(){
          require_once("View/auth/daftar_praktikan.php"); 
       }

      public function prosesAuthAslab($npm,$password){
          $sql = "select * from aslab where npm='$npm' and password='$password'";
          $query = koneksi()->query($sql);
          return $query->fetch_assoc();
          
      } 
      //Function authAslab untuk authentication aslab
      public function authAslab()
      {
          $npm = $_POST['npm'];
          $password = $_POST['password'];
          $data = $this->prosesAuthAslab($npm,$password);
          if($data){
              $_SESSION['role'] = 'aslab';
              $_SESSION['aslab'] = $data;
              header("location:index.php?page=aslab&aksi=view&pesan=Berhasil Login");
          }else{
              header("location:index.php?page=auth&aksi=loginAslab&pesan=Password atau Npm anda salah !!");
          }
      }

      /** Function untuk cek dari database berdasarkan
       * @param String $npm berisi npm
       * @param String $password berisi password
       */
      public function prosesAuthPraktikan($npm,$password){
        $sql = "select * from praktikan where npm='$npm' and password='$password'";
        $query = koneksi()->query($sql);
        return $query->fetch_assoc();
      }
     
         /** Function authPraktikan untuk authentication praktikan */
        public function authPraktikan()
        {
            $npm = $_POST['npm'];
            $password = $_POST['password'];
            $data = $this->prosesAuthPraktikan($npm,$password);
            if($data){
                $_SESSION['role'] = 'praktikan';
                $_SESSION['praktikan'] = $data;
                header("location:index.php?page=praktikan&aksi=view&pesan=Berhasil Login");
            }else{
                header("location:index.php?page=auth&aksi=loginPraktikan&pesan=Password atau Npm anda salah !!");
            }
        }

        public function logout(){
            session_destroy();
            header("location:index.php?page=auth&aksi=view&pesan=Berhasil Logout !!");
        }

   /**
     * Function store berfungsi untuk menambahkan data ke database
     * @param String nama berisi data nama
     * @param String npm berisi data npm
     * @param String no_hp berisi data nomor_hp
     * @param String password berisi data password
     */
    public function prosesStorePraktikan($nama, $npm, $nohp, $password){
        $sql = "INSERT INTO praktikan(nama, npm, nomor_hp,password) VALUES('$nama','$npm','$nohp','$password')";
        return koneksi()->query($sql);
    }
    /**
     * Function ini berfungsi untuk memproses data untuk ditambahkan
     * Fungsi ini membutuhkan data nama,npm,no_hp,password dengan metode http request post
     */
    public function storePraktikan(){
        $nama = $_POST['nama'];
        $npm = $_POST['npm'];
        $no_hp = $_POST['no_hp'];
        $password = $_POST['password'];
        if ($this -> prosesStorePraktikan($nama,$npm,$no_hp,$password)){
            header("location: index.php?page=auth&aksi=view&pesan=Berhasil Daftar");
        }else{
            header("location: index.php?page=auth&aksi=daftarPraktikan&pesan=Gagal Daftar");
        }
    }

}
