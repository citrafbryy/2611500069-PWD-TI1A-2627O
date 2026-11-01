# Pertemuan 7 - Form Handling, Validasi Server-Side, dan Event Prevent Default

## Tujuan
Pada pertemuan ini, artefak dari pertemuan sebelumnya digunakan sebagai baseline untuk mengembangkan halaman web agar lebih interaktif dan aman dalam menangani input pengguna.

## Pengembangan yang Dilakukan
1. Menyalin artefak pertemuan 6 untuk dijadikan bahan awal pengembangan pertemuan 7.
2. Menerapkan validasi data form dengan PHP pada sisi server.
3. Menangani event `submit` dengan `event.preventDefault()` agar formulir tidak langsung dikirim sebelum validasi selesai.
4. Menampilkan pesan error dan nilai input yang pernah dikirim kembali agar user experience lebih baik.
5. Menggunakan session untuk menyimpan pesan error dan data yang terkirim agar tetap tersedia setelah redirect.

## Artefak
- `index.php` - halaman utama yang menampilkan profil dan form kontak.
- `indexGet.php` - berkas tambahan untuk latihan pengolahan data form dengan metode GET.
- `script.js` - file JavaScript untuk validasi dan interaksi form.
- `style.css` - file styling yang melengkapi tampilan.

## Hasil Praktikum
Formulir di sisi server mengecek apakah data yang dikirim memenuhi aturan yang ditetapkan. Jika input tidak valid, halaman akan menampilkan pesan kesalahan dan mempertahankan nilai yang sudah diisi. Jika valid, data dapat diterima dan diproses lebih lanjut.

## Kesimpulan
Pertemuan 7 menegaskan pentingnya kombinasi validasi sisi klien dan sisi server agar aplikasi web lebih aman, lebih rapi, dan lebih mudah dipelihara.
