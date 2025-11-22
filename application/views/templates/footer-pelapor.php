<script>
    // Logika untuk menampilkan SweetAlert (Flashdata)
    // Ini HANYA akan menangani pesan SUKSES atau GAGAL UPLOAD (setelah redirect)
    const flashdata = $('.flashdata').data('flashdata');
    const flashdata_success = $('.flashdata-success').data('flashdata');
    const flashdata_failed = $('.flashdata-failed').data('flashdata');

    if (flashdata) {
        Swal.fire({
            title: 'Berhasil!',
            text: flashdata,
            icon: 'success'
        });
    } else if (flashdata_success) {
        Swal.fire({
            title: 'Berhasil!',
            html: flashdata_success,
            icon: 'success'
        });
    } else if (flashdata_failed) {
        Swal.fire({
            title: 'Gagal!',
            html: flashdata_failed.replace(/<\/?p>/g, ''), // Membersihkan tag <p>
            icon: 'error'
        });
    }
    
    // Blok PHP yang rusak sudah dihapus dari sini.
</script>