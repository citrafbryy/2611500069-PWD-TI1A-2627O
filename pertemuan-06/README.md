# P5 - JavaScript Dasar, DOM, Event, dan Validasi Sisi Klien

## Deskripsi

Dokumentasi pengembangan halaman web pada P5. Artefak P4 (struktur HTML dan tata
letak CSS responsif) digunakan sebagai baseline, kemudian ditambahkan perilaku
JavaScript: interaksi navigasi responsif, penanganan event, validasi formulir
sisi klien, dan umpan balik kepada pengguna.

Identitas:

- Nama: Surya Citra Febriyani
- NIM: 2611500069
- Kelas: TI1A

## Cara Menjalankan

Buka berkas `pertemuan-05/index.html` menggunakan peramban (dapat langsung dari
sistem berkas), lalu buka Browser DevTools (Console/Elements) bila diperlukan.

## Fitur dan Pengembangan

- **Navigasi responsif (hamburger):** Tombol `#navToggle` menambah/menghapus class
  `nav-open` pada `#navMenu` melalui `classList.toggle()`, serta memperbarui
  `aria-expanded` dan `aria-label`. Menu disembunyikan pada layar kecil dan
  ditampilkan pada lebar >= 768 px; tombol disembunyikan pada layar lebar.
- **Pengendalian submit:** `#contactForm` memakai atribut `novalidate`; event
  `submit` menjalankan `event.preventDefault()` lalu memeriksa data secara
  berurutan.
- **Validasi formulir:** nama (3-50 karakter), email (pola), semester (1-14),
  tanggal kunjungan (wajib), jenis pesan (radio wajib), topik minat (minimal satu
  checkbox), program studi (select wajib), dan pesan (wajib, maksimal 300
  karakter). Pemeriksaan berhenti pada kegagalan pertama.
- **Umpan balik:** Pesan ditampilkan pada `#formFeedback` dengan class
  `form-feedback-error` saat gagal dan `form-feedback-success` saat seluruh aturan
  terpenuhi. Pesan dikosongkan pada event `input` dan `reset`.

## Pengujian

Pengujian perilaku dijalankan otomatis pada Chrome headless melalui Chrome
DevTools Protocol, menggunakan skrip `../verify-p5.mjs` (Node, tanpa dependensi;
berada di luar folder submission `pertemuan-05/`). Hasil: **18/18 kasus lulus**.
Verifikasi statis: semua `id` yang dirujuk `script.js` tersedia di `index.html`,
`script.js` lolos `node --check`, dan `img/foto-profil.jpg.jpeg` tersedia.

| Kasus | Hasil yang diharapkan | Hasil aktual | Status |
| --- | --- | --- | --- |
| Navigasi buka | Menu tampil, `aria-expanded=true`, label "Tutup navigasi" | Sesuai | Lulus |
| Navigasi tutup | Menu tersembunyi, `aria-expanded=false`, label "Buka navigasi" | Sesuai | Lulus |
| Nama pendek ("Al") | "Nama lengkap harus diisi 3 sampai 50 karakter." | Sesuai, class `form-feedback-error` | Lulus |
| Email salah ("a@s") | "Masukkan alamat email yang valid." | Sesuai | Lulus |
| Semester kosong | "Semester harus diisi dengan angka 1 sampai 14." | Sesuai | Lulus |
| Semester 0 | Pesan validasi semester | Sesuai | Lulus |
| Semester 15 | Pesan validasi semester | Sesuai | Lulus |
| Tanggal kosong | "Tanggal kunjungan harus diisi." | Sesuai | Lulus |
| Jenis pesan kosong | "Pilih jenis pesan." | Sesuai | Lulus |
| Topik kosong | "Pilih minimal satu topik yang diminati." | Sesuai | Lulus |
| Prodi kosong | "Pilih program studi." | Sesuai | Lulus |
| Pesan kosong | "Pesan harus diisi." | Sesuai | Lulus |
| Pesan 300 karakter | Lolos validasi | "Form berhasil divalidasi." | Lulus |
| Pesan 301 karakter (guard JS) | "Pesan maksimal 300 karakter." | Sesuai | Lulus |
| Semua data valid | "Form berhasil divalidasi." | Sesuai, class `form-feedback-success` | Lulus |
| Hapus umpan balik saat input | Pesan lama terhapus | `textContent` kosong | Lulus |
| Hapus umpan balik saat reset | Pesan terhapus | `textContent` kosong | Lulus |

Catatan sesuai modul: atribut `maxlength="300"` membatasi masukan melalui
antarmuka normal, sehingga kondisi `pesan.length > 300` tidak dapat dipicu dengan
mengetik 301 karakter. Kasus 301 karakter diuji dengan menetapkan nilai secara
programatik untuk memverifikasi aturan JavaScript tersebut.

## Riwayat Pengembangan

Belum ada commit/push karena repositori Git belum disiapkan pada tahap ini.
Setelah pengujian di atas selesai dan hasilnya tercatat, langkah Git yang
direncanakan:

```
git status
git add .
git commit -m "Tambahkan interaksi navigasi, validasi, dan umpan balik P5"
git push
```

- `[commit]` Belum ada commit dibuat pada tahap ini.
