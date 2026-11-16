# pertemuan 09

pada P9, yang saya lakukan adalah:

1. menyalin artefak bahan pertemuan 08 sebagai baseline pertemuan 09, dan mengunci tampilan http://localhost/pwd/2611500069-PWD-TI1A-2627O/pertemuan-09/ dimana hasilnya masih sama dengan artefak bahan pertemuan 08.
2. membuat fungsi bersihkan(teks) untuk membatalkan eksekusi skrip html atau javascrip sebelum output dihasilkan. tanpa fungsi bersihkan(), output akan dieksekusi contohnya <h1>teks</h1> membuat teks menjadi heading, dengan fungsi bersihkan output menjadi <h1>teks</h1> tanpa membuat teks menjadi heading.
3. membuat file dengan nama fungsi.php, berisi fungsi bersihkan() yang dipindahkan dari index.php, pada index.php baris fungsi diganti dengan include("fungsi.php"); setelah pengujian hasilnya tetap sama antara pemulihan fungsi bersihkan() langsung di index.php maupun setelah fungsi bersihkan dipindahkan ke fungsi.php.
4. membuat 1 session array assosiatif untuk menampung data dari form ($\_SESSION["form_data"]) dan outputnya dengan for each.
