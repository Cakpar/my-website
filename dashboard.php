<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard BPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Dashboard Marketing</h2>
            <button class="btn btn-danger" onclick="logout()">Logout</button>
        </div>
        <div id="data-container">
            <p>Memuat data...</p>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('api_token');
        if(!token){
            // Kalau belum login, redirect ke login
            window.location.href = '/index.html';
        }

        function logout(){
            localStorage.clear();
            window.location.href = '/index.html';
        }

        // Ambil data dari API
        fetch('http://36.88.35.205:2025/api/sales-tracking', {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('data-container');
            if(data.success && data.data.length > 0){
                let html = '<table class="table table-bordered"><thead><tr><th>ID</th><th>Nama Sales</th><th>Sekolah</th><th>Status</th></tr></thead><tbody>';
                data.data.forEach(item => {
                    html += `<tr>
                        <td>${item.id}</td>
                        <td>${item.sales_info ? item.sales_info.name : '-'}</td>
                        <td>${item.customer_info ? item.customer_info.school_name : '-'}</td>
                        <td>${item.check_out ? 'Check Out' : (item.visit ? 'Sedang Berkunjung' : (item.check_in ? 'Check In' : 'Belum Mulai'))}</td>
                    </tr>`;
                });
                html += '</tbody></table>';
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p>Tidak ada data.</p>';
            }
        })
        .catch(err => {
            document.getElementById('data-container').innerHTML = '<p>Gagal memuat data.</p>';
            console.error(err);
        });
    </script>
</body>
</html>
