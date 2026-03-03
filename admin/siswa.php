<?php include 'header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Siswa</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSiswa">
        <i class="bi bi-person-plus"></i> Tambah Siswa
    </button>
</div>

<?php if(isset($_GET['pesan'])): ?>
    <div class="alert alert-<?php echo in_array($_GET['pesan'], ['tambah_sukses', 'hapus_sukses', 'update_sukses']) ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
        <?php 
        if($_GET['pesan'] == 'tambah_sukses') echo "Siswa berhasil ditambahkan!";
        elseif($_GET['pesan'] == 'hapus_sukses') echo "Data siswa berhasil dihapus!";
        elseif($_GET['pesan'] == 'update_sukses') echo "Data siswa berhasil diperbarui!";
        elseif($_GET['pesan'] == 'username_ada') echo "Gagal! Username sudah digunakan.";
        else echo "Terjadi kesalahan.";
        ?>
        <button type="button" class="btn-close" data-bs-alert="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'siswa' ORDER BY nama ASC");
                    $no = 1;
                    $data_siswa = []; // Simpan data ke array untuk loop modal nanti
                    while($d = mysqli_fetch_assoc($result)):
                        $data_siswa[] = $d;
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($d['nama']); ?></td>
                        <td><?php echo htmlspecialchars($d['username']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSiswa<?php echo $d['id_user']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="proses_siswa.php?aksi=hapus&id=<?php echo $d['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Loop Modal Edit (Di luar tabel agar tidak kelap-kelip) -->
<?php foreach($data_siswa as $d): ?>
<div class="modal fade" id="editSiswa<?php echo $d['id_user']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="proses_siswa.php?aksi=update" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_user" value="<?php echo $d['id_user']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($d['nama']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($d['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru (Biarkan kosong jika tidak diganti)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahSiswa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="proses_siswa.php?aksi=tambah" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama lengkap siswa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password siswa" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
