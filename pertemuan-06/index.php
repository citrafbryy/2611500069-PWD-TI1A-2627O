<?php
// P6: PHP dasar dan pemrograman sisi peladen
// Bagian 1: Variabel dan konstanta
$nim = "2611500069";
$namaMahasiswa = "Surya Citra Febriyani";
$programStudi = "Teknik Informatika";
$tahunAkademik = "2026/2027";
$semesterAwal = 2;
$semester = $semesterAwal;
$semesterError = "";
if (isset($_GET["semester"])) {
  $semesterInput = $_GET["semester"];
  $semesterTerkirim = is_scalar($semesterInput)
    ? filter_var($semesterInput, FILTER_VALIDATE_INT)
    : false;

  if ($semesterTerkirim === false || $semesterTerkirim < 1 || $semesterTerkirim > 14) {
    $semesterError = "Semester harus berupa bilangan bulat antara 1 dan 14.";
  } else {
    $semester = $semesterTerkirim;
  }
}
$ipk = 3.75;
$statusAktif = true;
$catatanTambahan = null;
const NAMA_MATA_KULIAH = "Pemrograman Web Dasar";
const PROFIL_GITHUB = "citrafbryy";
// Bagian 2: Operator
$batasSemester = 8;
$sisaSemester = max(0, $batasSemester - $semester);
$semesterValid = $semester >= 1 && $semester <= $batasSemester;
$statusSemester = ($semesterValid && $statusAktif) ? "Sesuai rentang" : "Perlu diperiksa";
// Bagian 3: Percabangan if-elseif-else
if ($semester < 3) {
  $keteranganSemester = "Semester awal";
} elseif ($semester <= 6) {
  $keteranganSemester = "Semester menengah";
} else {
  $keteranganSemester = "Semester akhir";
}
$namaProdi = ($programStudi == "SI") ? "Sistem Informasi" : (($programStudi == "TI") ? "Teknik
Informatika" : "Lainnya");
// Bagian 4: Percabangan switch-case-default
switch ($programStudi) {
case "SI":
  $fokusProgramStudi = "Sistem informasi dan proses bisnis";
  break;
case "TI":
  $fokusProgramStudi = "Komputasi dan pengembangan perangkat lunak";
  break;
default:
  $fokusProgramStudi = "Belum ditentukan";
}

?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Mahasiswa</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
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
        <p>Halo, saya <strong><?php echo htmlspecialchars($namaMahasiswa, ENT_QUOTES, "UTF-8"); ?></strong>. Saya sedang mempelajari mata kuliah
       <strong><?php print NAMA_MATA_KULIAH; ?></strong> pada tahun akademik <?php echo htmlspecialchars($tahunAkademik, ENT_QUOTES, "UTF-8");
        ?>.</p>
        <img
          src="img/foto-profil.jpeg"
          alt="Foto profil <?php echo htmlspecialchars($namaMahasiswa, ENT_QUOTES, "UTF-8"); ?>"
        />
      </section>

      <section id="about" class="card">
        <h2>Tentang Saya</h2>
        <article>
          <h3>Profil Singkat</h3>
          <p>Program Studi: <?php echo htmlspecialchars($programStudi, ENT_QUOTES, "UTF-8"); ?></p>
          <p>Sisa semester hingga batas <?php echo $batasSemester; ?>: <?php echo $sisaSemester; ?></p>
          <p>Pemeriksaan rentang semester: <?php echo $statusSemester; ?></p>
          <p>Semester: <?php echo $semester . " (" . $keteranganSemester . ")"; ?></p>
          <p>Program Studi: <?php echo $namaProdi . " (" . $programStudi . ")"; ?></p>
          <p>Fokus Program Studi: <?php echo $fokusProgramStudi; ?></p>
          <p>Status mahasiswa: <?php echo $statusAktif ? "Aktif" : "Tidak aktif"; ?></p>

          <h3>Uji Perubahan Semester</h3>
          <p>Masukkan semester lalu kirim untuk memperbarui data profil.</p>
          <form action="index.php" method="get">
            <div class="form-group">
              <label for="semesterProfil">Semester (1-14)</label>
              <input
                class="input-form"
                type="number"
                id="semesterProfil"
                name="semester"
                min="1"
                max="14"
                step="1"
                value="<?php echo $semester; ?>"
                required
              />
            </div>
            <button type="submit">Perbarui Semester</button>
          </form>
          <?php if ($semesterError !== ""): ?>
            <p class="form-feedback-error" role="alert"><?php echo htmlspecialchars($semesterError, ENT_QUOTES, "UTF-8"); ?></p>
          <?php endif; ?>

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
          <a href="https://github.com/<?php echo PROFIL_GITHUB; ?>"
            >profil GitHub saya</a
          >.
        </p>

        <form id="contactForm" action="index.php" method="post" novalidate>
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
        <p>&copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($namaMahasiswa, ENT_QUOTES, "UTF-8"); ?> | NIM <?php echo htmlspecialchars($nim, ENT_QUOTES, "UTF-8"); ?></p>
      </div>
    </footer>
    <script src="script.js"></script>
  </body>
</html>
