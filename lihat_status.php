<?php
include 'db.php'; 

header('Content-Type: application/json'); // Set header untuk JSON

if (isset($_GET['id_saran'])) {
    $id_saran = mysqli_real_escape_string($conn, $_GET['id_saran']);
    
    if (!is_numeric($id_saran)) {
        echo json_encode([
            'type' => 'error',
            'message' => 'ID saran tidak valid.'
        ]);
        exit;
    }

    $query = "SELECT * FROM saran WHERE id = '$id_saran'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $saran = mysqli_fetch_assoc($result);
            echo json_encode([
                'type' => 'success',
                'message' => 'Saran Anda: ' . $saran['isi_saran'] . ' | Status: ' . $saran['status']
            ]);
        } else {
            echo json_encode([
                'type' => 'error',
                'message' => 'ID saran tidak ditemukan.'
            ]);
        }
    } else {
        echo json_encode([
            'type' => 'error',
            'message' => 'Terjadi kesalahan saat mengambil data: ' . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        'type' => 'error',
        'message' => 'ID saran tidak disediakan.'
    ]);
}
?>
