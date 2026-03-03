<?php 
include 'header.php'; 

if(!isset($_GET['id'])){
    echo "<script>window.location='riwayat.php';</script>";
    exit;
}

$id = $_GET['id'];
$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT p.*, k.nama_kategori FROM pengaduan p JOIN kategori k ON p.id_kategori = k.id_kategori WHERE p.id_pengaduan='$id' AND p.id_user='$id_user'");

if(mysqli_num_rows($query) == 0){
    echo "<script>alert('Data tidak ditemukan!'); window.location='riwayat.php';</script>";
    exit;
}

$data = mysqli_fetch_assoc($query);

// Get responses
$tanggapan = mysqli_query($koneksi, "SELECT t.*, u.nama as nama_admin FROM tanggapan t JOIN users u ON t.id_admin = u.id_user WHERE t.id_pengaduan='$id' ORDER BY t.tanggal_tanggapan ASC");
?>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Detail Pengaduan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge <?php echo ($data['status']=='selesai'?'bg-success':($data['status']=='diproses'?'bg-info':'bg-warning text-white')); ?>"><?php echo ucfirst($data['status']); ?></span>
                    <small class="text-muted ms-2"><?php echo date('d F Y H:i', strtotime($data['tanggal'])); ?></small>
                </div>
                <h4 class="fw-bold"><?php echo htmlspecialchars($data['judul']); ?></h4>
                <p class="text-muted mb-4">Kategori: <?php echo htmlspecialchars($data['nama_kategori']); ?></p>
                
                <p><?php echo nl2br(htmlspecialchars($data['isi_pengaduan'])); ?></p>
                
                <?php if(!empty($data['gambar'])): ?>
                    <hr>
                    <label class="fw-bold mb-2">Bukti Foto:</label><br>
                    <img src="../uploads/<?php echo $data['gambar']; ?>" class="img-fluid rounded" style="max-height: 400px;">
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Tanggapan Admin</h5>
            </div>
            <div class="card-body">
                <?php if(mysqli_num_rows($tanggapan) > 0): ?>
                    <ul class="list-unstyled">
                    <?php while($t = mysqli_fetch_assoc($tanggapan)): ?>
                        <li class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold text-muted"><?php echo htmlspecialchars($t['nama_admin']); ?></span>
                                <small class="text-muted" style="font-size: 0.8rem;"><?php echo date('d/m/y H:i', strtotime($t['tanggal_tanggapan'])); ?></small>
                            </div>
                            <p class="mb-0 small bg-light p-2 rounded"><?php echo nl2br(htmlspecialchars($t['isi_tanggapan'])); ?></p>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-chat-dots fs-1"></i>
                        <p class="mt-2">Belum ada tanggapan dari admin.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
