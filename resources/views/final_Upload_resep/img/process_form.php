<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai inputan dari formulir
    $namaResep = $_POST['nama_resep'];
    $deskripsiResep = $_POST['deskripsi_resep'];
    $waktuPenyajian = $_POST['waktu_penyajian'];
    $porsi = $_POST['porsi'];
    $videoYoutube = $_POST['video_youtube'];
    $bahan = $_POST['bahan'];
    $langkahMasak = $_POST['langkah_masak'];

    // Lakukan proses yang diinginkan dengan data yang diterima
    // Contoh: Simpan ke database, kirim email, dll.
    // Mengupload gambar
    $gambar = $_FILES["upload-input"]["name"];
    $gambar_tmp = $_FILES["upload-input"]["tmp_name"];
    $gambar_path = "path_ke_folder_upload/" . $gambar;
    move_uploaded_file($gambar_tmp, $gambar_path);
    // Redirect ke halaman lain setelah proses selesai
    header("Location: halaman_lain.php");
    exit();
}
?>
