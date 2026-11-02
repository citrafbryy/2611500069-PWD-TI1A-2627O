pada p7, saya melakukan:

1. menyalin artefak P6 untuk menjadi baseline P7
2. menguji fitur pada P7, hasilnya jalan seperti P6.
3. meremark event.preventDefault(); pada script.js dan mencoba superglobal $\_GET untuk menangkap nilai yang diisikan pada formulir.
4. mencoba method post. hasilnya parameter tidak ditampilkan pada url, tetapi menggunakan echo superglobal $\_POST untuk menampilkan nilai dari input form.

Pada P8, formulir Rencana Kegiatan Mahasiswa menggunakan method POST. Data divalidasi di sisi klien dengan JavaScript dan di sisi peladen dengan PHP, dinormalisasi menggunakan `trim()`, lalu disimpan dalam session dengan pola Post-Redirect-Get (PRG). Data yang ditampilkan kembali di-escape menggunakan `htmlspecialchars()`. Halaman `indexGet.php` tetap digunakan sebagai contoh formulir GET dan menampilkan data dengan aman.
