<?php include 'header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Pengaduan</h1>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control form-control-sm" value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    <?php
                    $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($k = mysqli_fetch_assoc($kategori)){
                        $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori']) ? 'selected' : '';
                        echo "<option value='".$k['id_kategori']."' $selected>".$k['nama_kategori']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Siswa</label>
                <select name="siswa" class="form-select form-select-sm">
                    <option value="">Semua Siswa</option>
                    <?php
                    $siswa = mysqli_query($koneksi, "SELECT id_user, nama FROM users WHERE role = 'siswa' ORDER BY nama ASC");
                    while($s = mysqli_fetch_assoc($siswa)){
                        $selected = (isset($_GET['siswa']) && $_GET['siswa'] == $s['id_user']) ? 'selected' : '';
                        echo "<option value='".$s['id_user']."' $selected>".htmlspecialchars($s['nama'])."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="baru" <?php echo (isset($_GET['status']) && $_GET['status'] == 'baru') ? 'selected' : ''; ?>>Baru</option>
                    <option value="diproses" <?php echo (isset($_GET['status']) && $_GET['status'] == 'diproses') ? 'selected' : ''; ?>>Diproses</option>
                    <option value="selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                    <option value="ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm w-100 me-2">Filter</button>
                <a href="pengaduan.php" class="btn btn-secondary btn-sm w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $where = " WHERE 1=1 ";
                    if(isset($_GET['tanggal']) && !empty($_GET['tanggal'])){
                        $where .= " AND DATE(p.tanggal) = '".$_GET['tanggal']."'";
                    }
                    if(isset($_GET['kategori']) && !empty($_GET['kategori'])){
                        $where .= " AND p.id_kategori = '".$_GET['kategori']."'";
                    }
                    if(isset($_GET['siswa']) && !empty($_GET['siswa'])){
                        $where .= " AND p.id_user = '".$_GET['siswa']."'";
                    }
                    if(isset($_GET['status']) && !empty($_GET['status'])){
                        $where .= " AND p.status = '".$_GET['status']."'";
                    }

                    $query = "SELECT p.*, k.nama_kategori, u.nama 
                              FROM pengaduan p 
                              JOIN kategori k ON p.id_kategori = k.id_kategori 
                              JOIN users u ON p.id_user = u.id_user 
                              $where 
                              ORDER BY p.tanggal DESC";
                    
                    $result = mysqli_query($koneksi, $query);
                    $no = 1;
                    
                    if(mysqli_num_rows($result) > 0){
                        while($d = mysqli_fetch_assoc($result)){
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
                                <td><?php echo htmlspecialchars($d['nama']); ?></td>
                                <td><?php echo htmlspecialchars($d['nama_kategori']); ?></td>
                                <td><?php echo htmlspecialchars($d['judul']); ?></td>
                                <td><span class="badge <?php echo $status_class; ?>"><?php echo ucfirst($d['status']); ?></span></td>
                                <td>
                                    <a href="tanggapan.php?id=<?php echo $d['id_pengaduan']; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i> Tanggapi
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Tidak ada data pengaduan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
