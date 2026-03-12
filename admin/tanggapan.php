<?php 
include 'header.php'; 

if(!isset($_GET['id'])){
    echo "<script>alert('Pilih pengaduan terlebih dahulu!'); window.location='pengaduan.php';</script>";
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT p.*, k.nama_kategori, u.nama FROM pengaduan p JOIN kategori k ON p.id_kategori = k.id_kategori JOIN users u ON p.id_user = u.id_user WHERE p.id_pengaduan='$id'");
$data = mysqli_fetch_assoc($query);

// Get responses
$tanggapan = mysqli_query($koneksi, "SELECT t.*, u.nama as nama_admin FROM tanggapan t JOIN users u ON t.id_admin = u.id_user WHERE t.id_pengaduan='$id' ORDER BY t.tanggal_tanggapan DESC");
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Beri Tanggapan</h1>
    <a href="pengaduan.php" class="btn btn-secondary">Kembali</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header fw-bold">
                Detail Pengaduan
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="20%">Pelapor</th>
                        <td>: <?php echo htmlspecialchars($data['nama']); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: <?php echo date('d F Y H:i', strtotime($data['tanggal'])); ?></td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <?php echo htmlspecialchars($data['nama_kategori']); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: <span class="badge <?php 
                            if($data['status']=='selesai') echo 'bg-success';
                            elseif($data['status']=='diproses') echo 'bg-info';
                            elseif($data['status']=='ditolak') echo 'bg-red';
                            else echo 'bg-warning text-white'; 
                        ?>"><?php echo ucfirst($data['status']); ?></span></td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>: <?php echo htmlspecialchars($data['judul']); ?></td>
                    </tr>
                    <tr>
                        <th>Isi</th>
                        <td>: <?php echo nl2br(htmlspecialchars($data['isi_pengaduan'])); ?></td>
                    </tr>
                </table>
                
                <?php if(!empty($data['gambar'])): ?>
                    <div class="mt-3">
                        <h6>Bukti Foto:</h6>
                        <img src="../uploads/<?php echo $data['gambar']; ?>" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-bold">
                Riwayat Tanggapan
            </div>
            <div class="card-body">
                <?php if(mysqli_num_rows($tanggapan) > 0): ?>
                    <ul class="list-group list-group-flush">
                    <?php while($t = mysqli_fetch_assoc($tanggapan)): ?>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold text-muted"><?php echo htmlspecialchars($t['nama_admin']); ?></span>
                                <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($t['tanggal_tanggapan'])); ?></small>
                            </div>
                            <p class="mb-0 mt-1"><?php echo nl2br(htmlspecialchars($t['isi_tanggapan'])); ?></p>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Belum ada tanggapan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header fw-bold bg-light">
                Form Tanggapan
            </div>
            <div class="card-body">
                <form action="proses_tanggapan.php" method="POST">
                    <input type="hidden" name="id_pengaduan" value="<?php echo $data['id_pengaduan']; ?>">
                    <input type="hidden" name="id_admin" value="<?php echo $_SESSION['id_user']; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Update Status</label>
                        <select name="status" class="form-select" required>
                            <option value="baru" <?php echo ($data['status']=='baru')?'selected':''; ?>>Baru</option>
                            <option value="diproses" <?php echo ($data['status']=='diproses')?'selected':''; ?>>Diproses</option>
                            <option value="selesai" <?php echo ($data['status']=='selesai')?'selected':''; ?>>Selesai</option>
                            <option value="ditolak" <?php echo ($data['status']=='ditolak')?'selected':''; ?>>Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Isi Tanggapan</label>
                        <textarea name="isi_tanggapan" class="form-control" rows="5" required placeholder="Tulis tanggapan anda..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send"></i> Kirim Tanggapan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
