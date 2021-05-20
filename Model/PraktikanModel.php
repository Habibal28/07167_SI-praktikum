<?php
class PraktikanModel
{
    /**
     * Function get berfungsi untuk mengambil seluruh data praktikan 
     * @param integer $idPraktikan berisi id praktikan
    */
 public function get($id){
    $sql = "SELECT * FROM praktikan WHERE id = $id";
    $query = koneksi()->query($sql);
    return $query->fetch_assoc();
 }   
    // Function index berfungsi untuk mengatur tampilan awal halaman praktikan
 public function index(){
     $id = $_SESSION['praktikan']['id'];
     $data = $this->get($id);
     extract($data);
     require_once("View/praktikan/index.php");
 }
    //Funtion getPraktikum berfungsi untuk mengambil seluruh data praktikum yang aktif
 public function getPraktikum(){
     $sql = "SELECT * FROM praktikum WHERE status = 1";
     $query = koneksi()->query($sql);
    $hasil = [];
    while($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
    return $hasil;
 }
 //Function dadftarPraktikum berfungsi untuk mengatur tampilan awal halaman daftar praktikum
 public function daftarPraktikum(){
     $data = $this->getPraktikum();
     extract($data);
     require_once("View/praktikan/daftarPraktikum.php");
 }

 /**
  *  Function getPendaftarnPraktikum berfungsi untuk mengambil data pendaftaran praktikum praktikan
  * @param integer $idPraktikan berisi idpraktikan
 */
 public function getPendaftaranPraktikum($idPraktikan){
     $sql = "SELECT daftarprak.id as idDaftar , praktikum.nama as namaPraktikum ,
     praktikum.id as idPraktikum , daftarprak.status FROM daftarprak 
     JOIN praktikum on praktikum.id = daftarprak.praktikum_id 
     WHERE daftarprak.praktikan_id = $idPraktikan";

      $query = koneksi()->query($sql);
      $hasil = [];
      while($data = $query->fetch_assoc()){
              $hasil[] = $data;
          }
      return $hasil;
 }

 //Function praktikum berfungsi untuk mengatur tampilan awal halaman praktikum 
 public function praktikum(){
    $idPraktikan = $_SESSION['praktikan']['id'];
    $data = $this->getPendaftaranPraktikum($idPraktikan);
    extract($data);
    require_once("View/praktikan/praktikum.php");
 }

 //Function getModul berfungsi untuk mengambil data praktikum aktif
 public function getModul(){
     $sql = "SELECT modul.id as idModul , modul.nama as namaModul FROM modul 
     JOIN praktikum on praktikum.id = modul.praktikum_id
     WHERE praktikum.status = 1";
     $query = koneksi()->query($sql);
     $hasil = [];
     while($data = $query->fetch_assoc()){
             $hasil[] = $data;
         }
     return $hasil;
 }

 /**
  * Function getNilaiPraktikan berfungsi untuk mengambil data nilai praktikan di tiap - tiap praktikum 
  * @param $idPraktikan isinya yaitu idpraktikan
  * @param $idPraktikum isinya yaitu idpraktikum
 */
 public function getNilaiPraktikan($idPraktikan,$idPraktikum){
  $sql = "SELECT * FROM nilai JOIN modul on modul.id = nilai.modul_id 
  WHERE praktikan_id = $idPraktikan 
  AND praktikum_id = $idPraktikum
  ORDER BY modul.id";

  $query = koneksi()->query($sql);
  $hasil = [];
  while($data = $query->fetch_assoc()){
          $hasil[] = $data;
      }
  return $hasil;
 } 

 // Function nilaiPraktikan berfungsi untuk mengatur halaman nilai praktikum */
 public function nilaiPraktikan(){
     $idPraktikan = $_SESSION['praktikan']['id'];
     $idPraktikum = $_GET['idPraktikum'];
     $modul = $this->getModul();
     $nilai = $this->getNilaiPraktikan($idPraktikan,$idPraktikum);
     extract($modul);
     extract($nilai);
     require_once("View/praktikan/nilaiPraktikan.php");
 }

    /**
         * Function update berfungsi untuk update data praktikan pada database
         * @param String nama berisi nama praktikan
         * @param String npm berisi npm praktikan
         * @param String password berisi password praktikan
         * @param String no_hp berisi nomor telepon
         * @param Intefer id berisi id praktikan
         */
        public function prosesUpdate($nama,$npm,$password,$no_hp,$id){
            $sql = "UPDATE praktikan SET nama='$nama', npm='$npm', password='$password', nomor_hp='$no_hp' WHERE id='$id'";
            $query = koneksi()->query($sql);
            return $query;
        }
        /**
         * Function updae berfungsi untuk menyimpah hasil edit
         */
        public function update(){
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $npm = $_POST['npm'];
            $no_hp = $_POST['no_hp'];
            $password = $_POST['password'];
            if($this->prosesUpdate($nama,$npm,$password,$no_hp,$id)){
                header("location: index.php?page=praktikan&aksi=view&pesan=Berhasil Ubah Data");
            }else{
                header("location: index.php?page=praktikan&aksi=edit&pesan=Gagal Ubah Data");
            }
        }
        /**
         * Function edit berfungsi untuk menampilkan form edit
         */
        public function edit(){
            $id = $_SESSION['praktikan']['id'];
            $data = $this->get($id);
            extract($data);
            require_once("view/praktikan/edit.php");
        }
        /**
         * Function StorePraktikum berfungsi untuk input data daftar praktikum ke database
         * @param Integer idPraktikan berisi id praktikan
         * @param Integerr idPraktikum berisi id praktikum
         */
        public function prosesStorePraktikum($idPraktikan,$idPraktikum){
            $sql="INSERT INTO daftarprak(praktikan_id,praktikum_id,status) VALUES($idPraktikan,$idPraktikum,0)";
            $query = koneksi()->query($sql);
            return $query;        
        }
        /**
         * Function storePraktikan berfungsi untuk memproses data praktikum yang dipilih untuk di tambahkan
         */
        public function storePraktikum(){
            $idPraktikum = $_POST['praktikum'];
            $idPraktikan = $_SESSION['praktikan']['id'];
            if($this->prosesStorePraktikum($idPraktikan,$idPraktikum)){
                header("location: index.php?page=praktikan&aksi=praktikum&pesan=Berhasil daftar Praktikum");
            }else{
                header("location: index.php?page=praktikan&aksi=daftarPraktikum&pesan=Gagal daftar Praktikum");
            }
        }
    }
    // $tes = new PraktikanModel();
    // var_export($tes->prosesStorePraktikum(1,1));
    // die();
?>