<?php
class ModulModel{

    /** Function get berfungsi untuk mengambil seluruh data modul */
    public function get(){
        $sql = "SELECT modul.id as id , praktikum.nama as praktikum , praktikum.status as status , modul.nama as nama
        FROM modul JOIN praktikum ON modul.praktikum_id = praktikum.id WHERE praktikum.status = 1";
        $query = koneksi()->query($sql);
        $hasil = [];
        while($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
        return $hasil;
    }

    /** Function get berfungsi untuk mengatur tampilan awal halaman modul */
    public function index(){
        $data = $this->get();
        extract($data);
        require_once("View/modul/index.php");
    }
    /**
     * function getLastData berfungsi untuk mengambil data modul
     */

     public function getLastData()
     {
         $sql = "SELECT modul.id as id , modul.nama as nama FROM modul
         JOIN praktikum ON modul.praktikum_id = praktikum.id
         WHERE praktikum.Status = 1
         ORDER BY id DESC LIMIT 1";
         $query = koneksi()->query($sql);
         return $query->fetch_assoc();
     }

     /**
     * Function prosesStore berfungsi untuk menambahkan data modul ke database
     * @param string modul berisi nama modul 
     * @param integer idPraktikum berisi idPraktikum
     */

    public function prosesStore($modul, $idPraktikum)
    {
        $sql = "INSERT INTO modul(nama,praktikum_id) VALUES ('$modul' , $idPraktikum)";
        return koneksi()->query($sql);
    }

    /**
     * Function prosesDelete berfungsi untuk menghapus data modul ke database
     * @param integer id berisi id
     */

    public function prosesDelete($id)
    {
        $sql = "DELETE FROM modul WHERE id=$id";
        return koneksi()->query($sql);
    }

    /** Function getPraktikum berfungsi untuk mengambil seluruh data pada database 
    * 
    */
    public function getPraktikum()
    {
        $sql = "SELECT * FROM praktikum WHERE status=1";
        $query = koneksi()->query($sql);
        $hasil = [];
        while ($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
        return $hasil;
    }

    /**
     * Function create berfungsi untuk mengatur ke halaman create modul 
     */

    public function create()
    {
        $data = $this->getPraktikum();

        extract($data);
        require_once("View/modul/create.php");
    }

    /**
     * Function store berfungsi untuk menyimpan data modul yang telah di inputkan oleh aslab
     */

    public function store()
    {
        $modul = $_POST['modul'];
        $praktikum = $_POST['praktikum'];
        $getLastData = $this->getLastData();

        if ($getLastData == null){
            for($i = 1; $i <= $modul; $i++){
                $nama = 'Modul ' . $i; //Modul 1
                $post = $this->prosesStore($nama, $praktikum);
            }
        } else{
            $modulLast = explode(" ", $getLastData['nama']);

            for($i = 1; $i <= $modul; $i++){
                $a = $modulLast['1'] += 1;
                $nama = 'Modul ' . $a;
                $post = $this->prosesStore($nama, $praktikum);
            }
        }

        if ($post){
            header("location: index.php?page=modul&aksi=view&pesan=Berhasil Menambah Data"); //Jangan ada spasi habis location
        }else{
            header("location: index.php?page=modul&aksi=create&pesan=Gagal Menambah Data"); //Jangan ada spasi habis location
        }
    }

    /**
     * Function delete berfungsi untuk menghapus modul
     */

    public function delete()
    {
        $id = $_GET['id'];
        if($this->prosesDelete($id)){
            header("location: index.php?page=modul&aksi=view&pesan=Berhasil Delete Data"); //Jangan ada spasi habis location
        }else{
            header("location: index.php?page=modul&aksi=view&pesan=Gagal Delete Data"); //Jangan ada spasi habis location
        }
    }
}

    // $tes = new ModulModel();
    // var_export($tes->store());
    // die();

?>