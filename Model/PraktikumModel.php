<?php
class PraktikumModel{
     /** Function get berfungsi untuk mengambil seluruh data pada database */
     public function get(){
        $sql = "SELECT * FROM praktikum";
        $query = koneksi()->query($sql);
        $hasil = [];
        while($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
        return $hasil;
     }

     /** Function index berfungsi untuk mengatur tampilan awal */
     public function index(){
        $data = $this->get();
        extract($data);
        require_once("View/praktikum/index.php");
     }
     /**
     * function prosesStore berfungsi untuk input data praktikum
     * @param String $nama berisi nama praktikum
     * @param String $tahun berisi tahun praktikum
     */

     public function prosesStore($nama , $tahun)
     {
         $sql = "INSERT INTO praktikum(nama,tahun) VALUES('$nama' ,'$tahun')";
         return koneksi()->query($sql);
     }
     /**
     * function update berfungsi untuk mengubah data di database
     * @param String $nama berisi data nama
     * @param String $tahun berisi data tahun 
     * @param Integer $id berisi id dari suatu data di database
     */

     public function storeUpdate($nama , $tahun , $id)
     {
         $sql = "UPDATE praktikum SET nama='$nama' , tahun='$tahun' WHERE id=$id";
         return koneksi()->query($sql);
     }

     /**
     * function aktifkan ini untuk merubah salah satu field
     * @param Integer $id berisi id dari suatu data di database
     */

     public function prosesAktifkan($id)
     {
         koneksi()->query(("UPDATE praktikum SET status=0"));//merubah status praktikum yak aktif menjadi tidak aktif
         $sql = "UPDATE praktikum SET status=1 WHERE id=$id";
         return koneksi()->query($sql);
     }

     /**
     * function nonAktifkan ini untuk merubah salah satu field
     * @param Integer $id berisi id dari suatu data di database
     */

     public function prosesNonAktifkan($id)
     {
        $sql = "UPDATE praktikum SET status=0 WHERE id=$id";
        return koneksi()->query($sql);
     }

     /**
     * function create ini untuk mengatur tampilan tambah data
     */
     public function create()
     {
        require_once("View/praktikum/create.php");
     }

     /**
     * function store berfungsi untuk memproses data untuk di tambahkan
     * function ini membutuhkan nama ,tahun dengan metode http request POST
     */

     public function store()
     {
         $nama = $_POST['nama'];
         $tahun = $_POST['tahun'];

         if($this->prosesStore($nama,$tahun))
         {
             header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil Menambahkan Data");//jangan ada spasi habis location
         }else{
            header("location: index.php?page=praktikum&aksi=create&pesan=Gagal Menambahkan Data");//jangan ada spasi habis location
         }
     }

     /**
     * function getById berfungsi untuk mengambil satu data dari database
     * @param Integer $id berisi id dari suatu data di database
     */

     public function getById($id)
     {
         $sql = "SELECT * FROM praktikum WHERE id=$id";
         $query = koneksi()->query($sql);
         return $query->fetch_assoc();
     }

     /**
     * function update berfungsi memproses data untuk di update
     * function ini membutuhkan nama ,tahun dengan metode http request POST
     */

    public function update()
     {
        $id = $_POST['$id'];
        $nama = $_POST['nama'];
        $tahun = $_POST['tahun'];

        if($this->storeUpdate($nama,$tahun,$id))
        {
            header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil Mengubah Data");//jangan ada spasi habis location
        }else{
            header("location: index.php?page=praktikum&aksi=edit&pesan=Gagal Mengubah Data");//jangan ada spasi habis location
        }
     }

     /**
     * function ini berfungsi untuk memproses update salah satu field data
     * function ini membutuhkan data id dengan metode http request GET
     */

     public function aktifkan()
     {
         $id = $_GET['$id'];
         if ($this->prosesAktifkan($id)){
            header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil Men-Aktifkan Data");//jangan ada spasi habis location
        }else{
            header("location: index.php?page=praktikum&aksi=view&pesan=Gagal Men-Aktifkan Data");//jangan ada spasi habis location
         }
     }

     /**
     * function ini berfungsi untuk memproses update salah satu field data
     * function ini membutuhkan data id dengan metode http request GET
     */

     public function nonAktifkan()
     {
        $id = $_GET['$id'];
        if ($this->prosesNonAktifkan($id)){
           header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil non-Aktifkan Data");//jangan ada spasi habis location
        }else{
           header("location: index.php?page=praktikum&aksi=view&pesan=Gagal non-Aktifkan Data");//jangan ada spasi habis location
        }
     }
     /**
     * function ini berfungsi untuk menampilkan halaman edit
     * juga mengambil salah satu dari database
     * function ini membutuhkan data id dengan metode http request GET
     */

     public function edit()
     {
         $id = $_GET['id'];
         $data = $this->getById($id);
         extract($data);
         require_once("View/praktikum/edit.php");
     }
}
