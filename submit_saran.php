<?php
include 'db.php';

$nama = isset($_POST['nama']) ? mysqli_real_escape_string($conn, $_POST['nama']) : '';
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
$isi_saran = isset($_POST['isi_saran']) ? mysqli_real_escape_string($conn, $_POST['isi_saran']) : '';


if (!empty($isi_saran)) {
    $query = "INSERT INTO saran (nama, email, isi_saran, status, tanggal_kirim) VALUES ('$nama', '$email', '$isi_saran', 'Dikirim', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "Saran berhasil dikirim. ID saran Anda adalah " . mysqli_insert_id($conn);
    } else {
        echo "Gagal mengirim saran: " . mysqli_error($conn);
    }
} else {
    echo "Isi saran tidak boleh kosong!";
}
?>
