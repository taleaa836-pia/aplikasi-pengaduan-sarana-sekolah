<?php include 'header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<?php
// Get statistics
$total_pengaduan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengaduan"));
$baru = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE status='baru'"));
$diproses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE status='diproses'"));
$selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE status='selesai'"));

// Get category stats
$kategori_stats = mysqli_query($koneksi, "SELECT k.nama_kategori, COUNT(p.id_pengaduan) as jumlah FROM kategori k LEFT JOIN pengaduan p ON k.id_kategori = p.id_kategori GROUP BY k.id_kategori");

?>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card p-3 h-100 bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-55">Total Pengaduan</h6>
                    <h3 class="mb-0 fw-bold"><?php echo $total_pengaduan; ?></h3>
                </div>
                <i class="bi bi-archive fs-1 text-black-50"></i>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card p-3 h-100 bg-warning text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-55">Menunggu Verifikasi</h6>
                    <h3 class="mb-0 fw-bold"><?php echo $baru; ?></h3>
                </div>
                <i class="bi bi-hourglass-split fs-1 text-black-50"></i>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card p-3 h-100 bg-info text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-55">Sedang Diproses</h6>
                    <h3 class="mb-0 fw-bold"><?php echo $diproses; ?></h3>
                </div>
                <i class="bi bi-tools fs-1 text-black-50"></i>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card p-3 h-100 bg-success text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-55">Selesai</h6>
                    <h3 class="mb-0 fw-bold"><?php echo $selesai; ?></h3>
                </div>
                <i class="bi bi-check-circle fs-1 text-black-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Pengaduan Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelapor</th>
                                <th>Judul</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent = mysqli_query($koneksi, "SELECT p.*, u.nama FROM pengaduan p JOIN users u ON p.id_user = u.id_user ORDER BY p.tanggal DESC LIMIT 5");
                            if(mysqli_num_rows($recent) > 0) {
                                while($row = mysqli_fetch_assoc($recent)) {
                                    $status_badge = '';
                                    if($row['status'] == 'baru') $status_badge = '<span class="badge bg-warning text-white">Baru</span>';
                                    elseif($row['status'] == 'diproses') $status_badge = '<span class="badge bg-info">Proses</span>';
                                    else $status_badge = '<span class="badge bg-success">Selesai</span>';
                                    
                                    echo "<tr>";
                                    echo "<td>".date('d/m/Y', strtotime($row['tanggal']))."</td>";
                                    echo "<td>".htmlspecialchars($row['nama'])."</td>";
                                    echo "<td>".htmlspecialchars($row['judul'])."</td>";
                                    echo "<td>$status_badge</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>Belum ada data pengaduan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-end">
                    <a href="pengaduan.php" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Statistik Kategori</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php
                    while($row = mysqli_fetch_assoc($kategori_stats)) {
                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                        echo htmlspecialchars($row['nama_kategori']);
                        echo '<span class="badge bg-primary rounded-pill">'.$row['jumlah'].'</span>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
