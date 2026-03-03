<?php include 'header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h4 class="mb-0 fw-bold text-muted">Form Pengaduan</h4>
            </div>
            <div class="card-body">


                <form action="proses_pengaduan.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul Laporan</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: AC Kelas X RPL 1 Mati" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while($k = mysqli_fetch_assoc($kategori)){
                                echo "<option value='".$k['id_kategori']."'>".$k['nama_kategori']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Pengaduan</label>
                        <textarea name="isi_pengaduan" class="form-control" rows="5" placeholder="Jelaskan detail kerusakan atau keluhan..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bukti Foto</label>
                        <input type="file" name="gambar" class="form-control" accept=".jpg, .jpeg, .png" required>
                        <div class="form-text">Format: JPG, JPEG, PNG. Maksimal 2MB.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
