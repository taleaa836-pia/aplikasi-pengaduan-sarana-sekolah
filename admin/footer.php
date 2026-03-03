    </main>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/script.js"></script>

    <?php if (isset($_GET['pesan'])): ?>
    <script>
        const pesan = "<?php echo $_GET['pesan']; ?>";
        if (pesan === 'berhasil') {
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: 'Selamat datang di Aplikasi Pengaduan Sarana Sekolah!',
                timer: 2000,
                showConfirmButton: false
            });
        } else if (pesan === 'sukses') {
             Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil diproses!',
                timer: 2000,
                showConfirmButton: false
            });
        } else if (pesan === 'hapus') {
             Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil dihapus!',
                timer: 2000,
                showConfirmButton: false
            });
        }
    </script>
    <?php endif; ?>
</body>
</html>
