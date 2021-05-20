<?php
class DaftarPrakModel{

     /** Function get berfungsi untuk mengambil seluruh data praktikan yang telah mendaftar praktikum */
    public function get(){
        $sql = "SELECT daftarprak.id as idDaftar , daftarprak.praktikan_id as is_Praktikan , praktikan.nama as namaPraktikan , daftarprak.status as status , praktikum.nama as namaPraktikum FROM daftarprak
        JOIN praktikan ON praktikan.id = daftarprak.praktikan_id
        JOIN praktikum ON praktikum.id = daftarprak.praktikum_id
        WHERE praktikum.status = 1";
        $query = koneksi()->query($sql);
        $hasil = [];
        while($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
        return $hasil;
    }

    /** Function get berfungsi untuk mengatur tampilan awal halaman daftar praktikum */
    public function index(){
        $data = $this->get();
        extract($data);
        require_once("View/daftarprak/index.php");
    }

    /**
     * @param integer id berisi id
     * @param integer idAslab berisi id aslab
     * Function prosesVerif berfungsi untuk mengupdate status pada database yang telah di verifikasi
     */
    public function prosesVerif($id, $idAslab){
        $sql = "UPDATE daftarprak SET status=1, aslab_id = $idAslab where id=$id";
        $query = koneksi()->query($sql);
        return $query;
    }

    /**
     * @param integer id berisi id
     * @param integer idPraktikan berisi id Praktikan
     * Function prosesUnVerif berfungsi untuk membatalkan status verifikasi
     */
    public function prosesUnVerif($id, $idPraktikan){
        $sqlDelete = "DELETE FROM nilai where praktikan_id = $idPraktikan";
        koneksi()->query($sqlDelete);
        $sqlUpdate = "UPDATE daftarprak SET status=0, aslab_id = NULL where id=$id";
        $query = koneksi()->query($sqlUpdate);
        return $query;
    }

    /**
     * function verif berfungsi untuk memverifikasi praktikan yang sudah mendaftar praktikum
     */
    public function verif(){
        $id = $_GET['id'];
        $idAslab = $_SESSION['aslab']['id'];
        if ($this->prosesVerif($id,$idAslab)){
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
        if ($this->prosesUnVerif($id,$idPraktikan)){
            header("location: index.php?page=daftarprak&aksi=view&pesan=Berhasil Un-Verif Praktikan");
        }else{
            header("location: index.php?page=daftarprak&aksi=view&pesan=Gagal Un-Verif Praktikan");
        }
    }
}

    // $tes = new daftarprakModel();
    // var_export($tes->prosesUnVerif(1,1));
    // die();
?>