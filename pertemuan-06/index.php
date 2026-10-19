<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Mahasiswa</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <?php
// Pengujian awal eksekusi PHP.
   echo "Keluaran menggunakan print.";
//  ?>

    <header class="site-header">
      <div class="container">
        <div class="header-top">
          <h1>Profil Mahasiswa</h1>
          <button
            class="nav-toggle"
            id="navToggle"
            type="button"
            aria-label="Buka navigasi"
            aria-controls="navMenu"
            aria-expanded="false"
          >
            &#9776;
          </button>
        </div>
        <nav aria-label="Navigasi utama">
          <ul id="navMenu">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#contact">Kontak</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main class="container">
      <section id="home" class="card">
        <h2>Selamat Datang</h2>
        <p>
          Halo, saya <strong>Surya Citra Febriyani</strong>. Saya sedang
          mempelajari Pemrograman Web Dasar.
        </p>
        <img
          src="img/foto-profil.jpeg"
          alt="Foto profil Surya Citra Febriyani"
        />
      </section>

      <section id="about" class="card">
        <h2>Tentang Saya</h2>
        <article>
          <h3>Profil Singkat</h3>
          <p>Saya mahasiswa Program Studi Teknik Informatika.</p>

          <h3>Target Belajar</h3>
          <ol>
            <li>Memahami struktur HTML5.</li>
            <li>Menyusun halaman web semantik.</li>
            <li>Memvalidasi dokumen HTML.</li>
          </ol>
        </article>
      </section>

      <section id="contact" class="card">
        <h2>Kontak</h2>
        <p>
          Kunjungi
          <a href="https://github.com/citrafbryy/2611500069-PWD-TI1A-2627O"
            >profil GitHub saya</a
          >.
        </p>

        <form id="contactForm" action="index.html" method="get" novalidate>
          <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input
              class="input-form"
              type="text"
              id="nama"
              name="nama"
              placeholder="Masukkan nama lengkap"
              minlength="3"
              maxlength="50"
              required
            />
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input
              class="input-form"
              type="email"
              id="email"
              name="email"
              placeholder="nama@email.com"
              required
            />
          </div>

          <div class="form-group">
            <label for="semester">Semester</label>
            <input
              class="input-form"
              type="number"
              id="semester"
              name="semester"
              min="1"
              max="14"
              required
            />
          </div>

          <div class="form-group">
            <label for="tanggal">Tanggal Kunjungan</label>
            <input
              class="input-form"
              type="date"
              id="tanggal"
              name="tanggal"
              required
            />
          </div>

          <div class="form-group radio-group">
            <p>Jenis Pesan</p>
            <label>
              <input
                type="radio"
                name="jenis_pesan"
                value="pertanyaan"
                required
              />
              Pertanyaan
            </label>
            <label>
              <input type="radio" name="jenis_pesan" value="saran" />
              Saran
            </label>
          </div>

          <div class="form-group checkbox-group">
            <p>Topik yang Diminati</p>
            <label>
              <input type="checkbox" name="minat" value="HTML" />
              HTML
            </label>
            <label>
              <input type="checkbox" name="minat" value="CSS" />
              CSS
            </label>
          </div>

          <div class="form-group">
            <label for="prodi">Program Studi</label>
            <select class="input-form" id="prodi" name="prodi" required>
              <option value="">-- Pilih Program Studi --</option>
              <option value="SI">Sistem Informasi</option>
              <option value="TI">Teknik Informatika</option>
            </select>
          </div>

          <div class="form-group">
            <label for="pesan">Pesan</label>
            <textarea
              class="input-form"
              id="pesan"
              name="pesan"
              rows="5"
              maxlength="300"
              placeholder="Tulis pesan Anda"
              required
            ></textarea>
          </div>

          <div class="button-row">
            <button type="submit">Kirim</button>
            <button type="reset" class="secondary">Batal</button>
          </div>

          <p id="formFeedback" role="status" aria-live="polite"></p>
        </form>
      </section>
    </main>

    <footer class="site-footer">
      <div class="container">
        <p>&copy; 2026 Surya Citra Febriyani | NIM 2611500069</p>
      </div>
    </footer>
    <script src="script.js"></script>
  </body>
</html>
