<?php
include 'header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom no-print">
  <h1 class="h2">Cetak Laporan</h1>
</div>

<div class="card shadow mb-4 no-print">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="cetak_laporan.php" class="row g-3">
            <div class="col-md-3">
                <label for="tgl_mulai" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="<?php echo isset($_GET['tgl_mulai']) ? htmlspecialchars($_GET['tgl_mulai']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <label for="tgl_selesai" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" value="<?php echo isset($_GET['tgl_selesai']) ? htmlspecialchars($_GET['tgl_selesai']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="0" <?php echo (isset($_GET['status']) && $_GET['status'] === '0') ? 'selected' : ''; ?>>Menunggu</option>
                    <option value="proses" <?php echo (isset($_GET['status']) && $_GET['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                    <option value="selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                    <option value="ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-end mb-3 no-print">
    <button onclick="window.print()" class="btn btn-success me-2"><i class="bi bi-printer"></i> Cetak Laporan</button>
    <button onclick="exportPDF()" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
</div>

<div class="card shadow mb-4" id="print-area">
    <div class="card-body">
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                #print-area, #print-area * {
                    visibility: visible;
                }
                #print-area {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    border: none;
                }
                .no-print {
                    display: none !important;
                }
                table { margin-bottom: 0 !important; width: 100% !important; border-collapse: collapse !important; }
                table th, table td { border: 1px solid #000 !important; padding: 5px !important; }
            }
            .kop-surat { text-align: center; margin-bottom: 20px; }
            .kop-surat h2 { margin: 0; font-weight: bold; font-size: 24px; text-transform: uppercase; }
            .kop-surat p { margin: 5px 0; font-size: 16px; }
            .filter-info { margin-top: 10px; font-size: 14px; font-style: italic; }
            .garis-bawah { border-top: 3px solid #000; border-bottom: 1px solid #000; height: 2px; margin-top: 10px; margin-bottom: 20px; }
        </style>

        <div class="kop-surat">
            <h2>Laporan Data Pengaduan Sarana Sekolah</h2>
            <p>SMK TERPADU BINA INSAN</p>
            <?php
            $filter_texts = [];
            if (isset($_GET['tgl_mulai']) && !empty($_GET['tgl_mulai'])) {
                $filter_texts[] = "Dari Tanggal: " . date('d/m/Y', strtotime($_GET['tgl_mulai']));
            }
            if (isset($_GET['tgl_selesai']) && !empty($_GET['tgl_selesai'])) {
                $filter_texts[] = "Sampai Tanggal: " . date('d/m/Y', strtotime($_GET['tgl_selesai']));
            }
            if (isset($_GET['status']) && $_GET['status'] != "") {
                $status_labels = [
                    '0' => 'Menunggu',
                    'proses' => 'Proses',
                    'selesai' => 'Selesai',
                    'ditolak' => 'Ditolak'
                ];
                $status_dipilih = isset($status_labels[$_GET['status']]) ? $status_labels[$_GET['status']] : $_GET['status'];
                $filter_texts[] = "Status: " . $status_dipilih;
            }

            if (count($filter_texts) > 0) {
                echo "<div class='filter-info'>Filter: " . implode(" | ", $filter_texts) . "</div>";
            }
            ?>
            <div class="garis-bawah"></div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead class="table-light">
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
                    $conditions = [];
                    
                    if (isset($_GET['tgl_mulai']) && !empty($_GET['tgl_mulai'])) {
                        $tgl_mulai = mysqli_real_escape_string($koneksi, $_GET['tgl_mulai']);
                        $conditions[] = "DATE(p.tanggal) >= '$tgl_mulai'";
                    }
                    if (isset($_GET['tgl_selesai']) && !empty($_GET['tgl_selesai'])) {
                        $tgl_selesai = mysqli_real_escape_string($koneksi, $_GET['tgl_selesai']);
                        $conditions[] = "DATE(p.tanggal) <= '$tgl_selesai'";
                    }
                    if (isset($_GET['status']) && $_GET['status'] != "") {
                        $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                        $conditions[] = "p.status = '$status'";
                    }
                    
                    $where_clause = "";
                    if (count($conditions) > 0) {
                        $where_clause = " WHERE " . implode(" AND ", $conditions);
                    }

                    $query = "SELECT p.*, k.nama_kategori, u.nama 
                              FROM pengaduan p 
                              JOIN kategori k ON p.id_kategori = k.id_kategori 
                              JOIN users u ON p.id_user = u.id_user" 
                              . $where_clause . 
                              " ORDER BY p.tanggal DESC";
                    
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
                                    <?php 
                                    if($d['status'] == '0') {
                                        echo 'Menunggu';
                                    } else {
                                        echo ucfirst($d['status']);
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Tidak ada data pengaduan yang sesuai dengan filter.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function exportPDF() {
    const element = document.getElementById('print-area');
    const opt = {
      margin:       10,
      filename:     'Laporan_Pengaduan.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2, useCORS: true },
      jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
    };
    html2pdf().set(opt).from(element).save();
}
</script>

<?php include 'footer.php'; ?>
