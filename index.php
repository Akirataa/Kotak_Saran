<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>I-TECH</title>
</head>
<body>
    <nav>
        <a href="admin/login.php">Login</a>
    </nav>
    <h1>Kotak Saran</h1>

    <?php if ($message) : ?>
        <script>
            alert("<?php echo htmlspecialchars($message); ?>");
            if (history.replaceState) {
                history.replaceState(null, null, window.location.pathname);
            }
        </script>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />

        <label for="isi_saran">Saran:</label>
        <textarea id="isi_saran" name="isi_saran" required></textarea>

        <button type="submit">Kirim Saran</button>
    </form>

    <h2>Lihat Status Saran</h2>
    <label for="id_saran">ID Saran:</label>
    <input type="number" id="id_saran" name="id_saran" required />
    <button type="button" onclick="checkStatus()">Lihat Status Saran</button>

    <p id="status_message" style="display: none;"></p> <!-- Pesan status -->

    <!-- Menempatkan skrip JavaScript di sini -->
    <script>
        // Fungsi untuk mengambil status saran menggunakan AJAX
        function checkStatus() {
            const id_saran = document.getElementById('id_saran').value;
            const statusMessage = document.getElementById('status_message');
            
            if (id_saran) {
                fetch(`lihat_status.php?id_saran=${id_saran}`)
                    .then(response => response.json())
                    .then(data => {
                        statusMessage.textContent = data.message; // Menampilkan pesan status saran
                        statusMessage.style.color = (data.type === 'success') ? 'green' : 'red'; // Menyesuaikan warna pesan
                        statusMessage.style.display = 'block'; // Menampilkan elemen pesan
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        statusMessage.textContent = "Terjadi kesalahan saat mengambil status.";
                        statusMessage.style.color = 'red'; // Mengatur warna merah untuk kesalahan
                        statusMessage.style.display = 'block'; // Menampilkan elemen pesan
                    });
            } else {
                statusMessage.textContent = "Silakan masukkan ID saran.";
                statusMessage.style.color = 'orange'; // Mengatur warna kuning untuk peringatan
                statusMessage.style.display = 'block'; // Menampilkan elemen pesan
            }
        }
    </script>
</body>
</html>
