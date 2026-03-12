<?php include 'header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <h4 class="mb-3 fw-bold text-muted">Riwayat Pengaduan</h4>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $id_user = $_SESSION['id_user'];
                            $query = mysqli_query($koneksi, "SELECT p.*, k.nama_kategori FROM pengaduan p JOIN kategori k ON p.id_kategori = k.id_kategori WHERE p.id_user='$id_user' ORDER BY p.tanggal DESC");
                            $no = 1;
                            
                            if(mysqli_num_rows($query) > 0){
                                while($d = mysqli_fetch_assoc($query)){
                                    $status_class = match($d['status']) {
                                        'baru' => 'bg-warning text-white',
                                        'diproses' => 'bg-info',
                                        'selesai' => 'bg-success',
                                        'ditolak' => 'bg-red',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($d['tanggal'])); ?></td>
                                        <td><?php echo htmlspecialchars($d['judul']); ?></td>
                                        <td><?php echo htmlspecialchars($d['nama_kategori']); ?></td>
                                        <td><span class="badge <?php echo $status_class; ?>"><?php echo ucfirst($d['status']); ?></span></td>
                                        <td>
                                            <a href="detail.php?id=<?php echo $d['id_pengaduan']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Belum ada riwayat pengaduan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
