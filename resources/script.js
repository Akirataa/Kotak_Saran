 // Formulir pengiriman saran
 document.getElementById('suggestionForm').onsubmit = function(event) {
    event.preventDefault(); 

    const formData = new FormData(this);

    fetch('submit_saran.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        Swal.fire({
            title: 'Saran Dikirim',
            text: data,
            icon: 'success',
            confirmButtonText: 'OK'
        });
        this.reset();
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan saat mengirim saran.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
};

// Cek status saran
document.getElementById('checkStatus').onclick = function() {
    const id_saran = document.getElementById('id_saran').value;

    if (id_saran) {
        fetch(`lihat_status.php?id_saran=${id_saran}`)
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.type === 'success' ? 'Status Saran' : 'Kesalahan',
                    text: data.message,
                    icon: data.type === 'success' ? 'info' : 'error',
                    confirmButtonText: 'OK'
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengambil status.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    } else {
        Swal.fire({
            title: 'Peringatan!',
            text: 'Silakan masukkan ID saran.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    }
};

function updateDropdownColor(selectElement) {
    switch (selectElement.value) {
        case 'Dikirim':
            selectElement.style.backgroundColor = '#e9ecef';
            selectElement.style.color = '#6c757d';
            break;
        case 'Diproses':
            selectElement.style.backgroundColor = '#fff3cd';
            selectElement.style.color = '#856404';
            break;
        case 'Ditinjau':
            selectElement.style.backgroundColor = '#cce5ff';
            selectElement.style.color = '#004085';
            break;
        case 'Selesai':
            selectElement.style.backgroundColor = '#d4edda';
            selectElement.style.color = '#155724';
            break;
        default:
            selectElement.style.backgroundColor = '';
            selectElement.style.color = '';
    }
    selectElement.style.transition = 'background-color 0.3s ease, color 0.3s ease';
}
document.querySelectorAll('.form-select').forEach(select => {
    updateDropdownColor(select);
    select.addEventListener('change', function() {
        updateDropdownColor(this);
    });
});