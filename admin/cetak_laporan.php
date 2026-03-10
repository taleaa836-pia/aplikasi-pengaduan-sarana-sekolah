<?php
if (session_status() === PHP_SESSION_NONE) {
    if (is_dir('/tmp') && is_writable('/tmp')) {
        session_save_path('/tmp');
    }
    session_start();
}

// Auto-restore session dari Cookie Terkonsolidasi (Solusi Vercel)
if (!isset($_SESSION['status']) && isset($_COOKIE['sopia_auth'])) {
    $auth = json_decode($_COOKIE['sopia_auth'], true);
    if ($auth && isset($auth['verif']) && $auth['verif'] === md5($auth['id'] . 'SOPIA_SALT')) {
        $_SESSION['id_user'] = $auth['id'];
        $_SESSION['role'] = $auth['role'];
        $_SESSION['nama'] = $auth['nama'];
        $_SESSION['status'] = "login";
    }
}

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['role'] != 'admin') {
    session_write_close();
    header("Location: ../auth/login.php?pesan=belum_login");
    exit;
}
include __DIR__ . '/../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengaduan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        @media print {
            @page { size: auto; margin: 20mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Laporan Data Pengaduan Sarana Sekolah</h2>
        <p>SMK TERPADU BINA INSAN</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Kategori</th>
                <th>Judul Pengaduan</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT p.*, k.nama_kategori, u.nama 
                      FROM pengaduan p 
                      JOIN kategori k ON p.id_kategori = k.id_kategori 
                      JOIN users u ON p.id_user = u.id_user 
                      ORDER BY p.tanggal DESC";
            
            $result = mysqli_query($koneksi, $query);
            $no = 1;
            
            if(mysqli_num_rows($result) > 0){
                while($d = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($d['tanggal'])); ?></td>
                        <td><?php echo htmlspecialchars($d['nama']); ?></td>
                        <td><?php echo htmlspecialchars($d['nama_kategori']); ?></td>
                        <td><?php echo htmlspecialchars($d['judul']); ?></td>
                        <td class="text-center">
                            <strong><?php echo strtoupper($d['status']); ?></strong>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Tidak ada data pengaduan.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
