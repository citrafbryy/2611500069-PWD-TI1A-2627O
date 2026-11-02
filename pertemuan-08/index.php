<?php
session_start();

$kategoriKegiatanOptions = [
	"akademik" => "Akademik",
	"penelitian" => "Penelitian",
	"kepanitiaan" => "Kepanitiaan",
	"olahraga" => "Olahraga",
	"seni-budaya" => "Seni Budaya",
	"keagamaan" => "Keagamaan",
];

// Memproses rencana kegiatan, lalu mengarahkan kembali ke halaman (PRG).
if (
	$_SERVER["REQUEST_METHOD"] === "POST"
	&& ($_POST["form_type"] ?? "") === "rencana_kegiatan"
) {
	$inputRencana = [];
	foreach (["nama_kegiatan", "kategori_kegiatan", "tanggal_pelaksanaan", "lokasi_kegiatan", "deskripsi_kegiatan"] as $field) {
		$value = $_POST[$field] ?? "";
		$inputRencana[$field] = is_string($value) ? trim($value) : "";
	}

	$errorsRencana = [];
	unset($_SESSION["rencanaKegiatanResult"]);
	$hitungKarakter = static function (string $value): int {
		$count = preg_match_all('/./us', $value);
		return $count === false ? 0 : $count;
	};

	$panjangNama = $hitungKarakter($inputRencana["nama_kegiatan"]);
	if ($panjangNama < 3 || $panjangNama > 100) {
		$errorsRencana[] = "Nama kegiatan wajib diisi 3 sampai 100 karakter.";
	}
	if (!array_key_exists($inputRencana["kategori_kegiatan"], $kategoriKegiatanOptions)) {
		$errorsRencana[] = "Pilih kategori kegiatan yang tersedia.";
	}

	$tanggalParts = explode("-", $inputRencana["tanggal_pelaksanaan"]);
	$tanggalValid = count($tanggalParts) === 3
		&& preg_match('/^\d{4}-\d{2}-\d{2}$/D', $inputRencana["tanggal_pelaksanaan"]) === 1
		&& checkdate((int) ($tanggalParts[1] ?? 0), (int) ($tanggalParts[2] ?? 0), (int) ($tanggalParts[0] ?? 0));
	if (!$tanggalValid) {
		$errorsRencana[] = "Tanggal pelaksanaan tidak valid.";
	}

	$panjangLokasi = $hitungKarakter($inputRencana["lokasi_kegiatan"]);
	if ($panjangLokasi < 2 || $panjangLokasi > 150) {
		$errorsRencana[] = "Lokasi kegiatan wajib diisi 2 sampai 150 karakter.";
	}
	$panjangDeskripsi = $hitungKarakter($inputRencana["deskripsi_kegiatan"]);
	if ($panjangDeskripsi < 1 || $panjangDeskripsi > 1000) {
		$errorsRencana[] = "Deskripsi kegiatan wajib diisi dan maksimal 1000 karakter.";
	}

	if ($errorsRencana) {
		$_SESSION["rencanaKegiatanInput"] = $inputRencana;
		$_SESSION["rencanaKegiatanErrors"] = $errorsRencana;
	} else {
		$_SESSION["rencanaKegiatanResult"] = $inputRencana;
		unset($_SESSION["rencanaKegiatanInput"], $_SESSION["rencanaKegiatanErrors"]);
	}

	header("Location: index.php#rencana-kegiatan-mahasiswa");
	exit;
}

// P7: Memproses data formulir dan menyimpannya ke dalam session.
if (
	$_SERVER["REQUEST_METHOD"] === "POST"
	&& ($_POST["form_type"] ?? "") === "contact"
) {
	$nama = trim((string) ($_POST["nama"] ?? ""));
	$email = trim((string) ($_POST["email"] ?? ""));
	$semesterForm = trim((string) ($_POST["semester"] ?? ""));
	$tanggal = trim((string) ($_POST["tanggal"] ?? ""));
	$jenisPesan = trim((string) ($_POST["jenis_pesan"] ?? ""));
	$minat = $_POST["minat"] ?? [];
	$prodi = trim((string) ($_POST["prodi"] ?? ""));
	$pesan = trim((string) ($_POST["pesan"] ?? ""));

	// Checkbox dapat mengirimkan lebih dari satu nilai.
	if (!is_array($minat)) {
		$minat = [];
	}

	// Menyimpan setiap nilai formulir ke dalam session secara terpisah.
	$_SESSION["nama"] = $nama;
	$_SESSION["email"] = $email;
	$_SESSION["semester"] = $semesterForm;
	$_SESSION["tanggal"] = $tanggal;
	$_SESSION["jenis_pesan"] = $jenisPesan;
	$_SESSION["minat"] = $minat;
	$_SESSION["prodi"] = $prodi;
	$_SESSION["pesan"] = $pesan;

	// PRG: mencegah pengiriman POST berulang ketika halaman dimuat ulang.
	header("Location: index.php#contact");
	exit;
}

// Mengamankan data sebelum ditampilkan kembali ke halaman HTML.
// P6: PHP dasar dan pemrograman sisi peladen
// Bagian 1: Variabel dan konstanta
$nim = "1126500069";
$namaMahasiswa = "Surya Citra Febriyani";
$programStudi = "TI";
$tahunAkademik = "2026/2027";
$semester = 1;
$ipk = 3.75;
$statusAktif = true;
$catatanTambahan = null;

const NAMA_MATA_KULIAH = "Pemrograman Web Dasar";
const PROFIL_GITHUB = "satpamal";

// Bagian 2: Operator
$batasSemester = 8;
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

$namaProdi = ($programStudi == "TI") ? "Teknik Informatika" : (($programStudi == "TI") ? "Teknik Informatika" : "Lainnya");

// Bagian 4: Percabangan switch-case-default
switch ($programStudi) {
	case "TI":
		$fokusProgramStudi = "TEKNIK INFORMATIKA";
		break;
	case "TI":
		$fokusProgramStudi = "Komputasi dan pengembangan perangkat lunak";
		break;
	default:
		$fokusProgramStudi = "Belum ditentukan";
}

$rencanaKegiatanInput = $_SESSION["rencanaKegiatanInput"] ?? [];
$rencanaKegiatanErrors = $_SESSION["rencanaKegiatanErrors"] ?? [];
$rencanaKegiatanResult = $_SESSION["rencanaKegiatanResult"] ?? null;
unset($_SESSION["rencanaKegiatanInput"], $_SESSION["rencanaKegiatanErrors"]);
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
	<header>
		<div class="header-top">
			<h1>Profil Mahasiswa</h1>

			<button
				class="nav-toggle"
				id="navToggle"
				type="button"
				aria-label="Buka navigasi"
				aria-controls="navMenu"
				aria-expanded="false">
				&#9776;
			</button>
		</div>

		<nav>
			<ul id="navMenu">
				<li><a href="#home">Beranda</a></li>
				<li><a href="#about">Tentang</a></li>
				<li><a href="#rencana-kegiatan-mahasiswa">Rencana Kegiatan</a></li>
				<li><a href="#contact">Kontak</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<section id="home">
			<h2>Selamat Datang</h2>
			<p>Halo, saya <strong><?= htmlspecialchars($namaMahasiswa, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></strong>, mahasiswa Program Studi <?= htmlspecialchars($namaProdi, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>. Saat ini saya sedang mempelajari <strong><?= htmlspecialchars(NAMA_MATA_KULIAH, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></strong> untuk tahun akademik <?= htmlspecialchars($tahunAkademik, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>.</p>

			<img src="img/foto-profil.jpg" alt="Foto profil <?= htmlspecialchars($namaMahasiswa, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>" />
		</section>

		<section id="about">
			<h2>Tentang Saya</h2>

			<article>
				<h3>Profil Singkat</h3>
				<dl class="profile-details">
					<dt>Nama Lengkap</dt>
					<dd><?= htmlspecialchars($namaMahasiswa, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></dd>
					<dt>NIM</dt>
					<dd><?= htmlspecialchars($nim, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></dd>
					<dt>Program Studi</dt>
					<dd><?= htmlspecialchars($namaProdi . " (" . $programStudi . ")", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></dd>
					<dt>Fokus Program Studi</dt>
					<dd><?= htmlspecialchars($fokusProgramStudi, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></dd>
					<dt>Status Mahasiswa</dt>
					<dd><?= $statusAktif ? "Aktif" : "Tidak aktif" ?></dd>
					<dt>Tahun Akademik</dt>
					<dd><?= htmlspecialchars($tahunAkademik, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></dd>
					<dt>Semester</dt>
					<dd><?= htmlspecialchars($semester . " (" . $keteranganSemester . ")", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></dd>
					<dt>Pemeriksaan Semester</dt>
					<dd><?= htmlspecialchars($statusSemester, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></dd>
					<dt>IPK</dt>
					<dd><?= number_format($ipk, 2, ",", ".") ?></dd>
					<dt>Catatan Tambahan</dt>
					<dd><?= htmlspecialchars($catatanTambahan ?? "Belum ada", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></dd>
				</dl>

				<h3>Target Belajar</h3>
				<ol>
					<?php
					// Perulangan for tanpa array; materi larik dibahas pada P9.
					for ($i = 1; $i <= 5; $i++) {
						echo "<li>Target belajar ke-" . $i . ": ";
						switch ($i) {
							case 1:
								echo "Memahami sintaks dasar PHP.";
								break;
							case 2:
								echo "Menggunakan variabel dan konstanta.";
								break;
							case 3:
								echo "Menerapkan operator dan percabangan.";
								break;
							case 4:
								echo "Menggunakan perulangan for dan while.";
								break;
							default:
								echo "Belum dipetakan";
								break;
						}
						echo "</li>";
					}
					?>
				</ol>

				<h3>Semester:</h3>
				<ol>
					<?php
					$nomorSemester = 1;
					while ($nomorSemester <= 3) {
						echo "<li>Semester " . $nomorSemester . "</li>";
						$nomorSemester++; // operator penugasan
					}
					?>
				</ol>
			</article>
		</section>

		<section id="rencana-kegiatan-mahasiswa">
			<h2>Rencana Kegiatan Mahasiswa</h2>

			<?php if ($rencanaKegiatanErrors): ?>
				<div class="form-feedback-error" data-rencana-errors role="alert">
					<ul>
						<?php foreach ($rencanaKegiatanErrors as $error): ?>
							<li><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<form id="rencanaKegiatanForm" action="index.php" method="post" data-validation="rencana-kegiatan" novalidate>
				<input type="hidden" name="form_type" value="rencana_kegiatan" />
				<div class="form-group">
					<label for="namaKegiatan">Nama Kegiatan</label><br />
					<input
						class="input-form"
						type="text"
						id="namaKegiatan"
						name="nama_kegiatan"
						minlength="3"
						maxlength="100"
						value="<?= htmlspecialchars($rencanaKegiatanInput["nama_kegiatan"] ?? "", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>"
						required />
				</div>

				<div class="form-group">
					<label for="kategoriKegiatan">Kategori Kegiatan</label><br />
					<select class="input-form" id="kategoriKegiatan" name="kategori_kegiatan" required>
						<option value="">-- Pilih Kategori --</option>
						<?php foreach ($kategoriKegiatanOptions as $value => $label): ?>
							<option value="<?= htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>" <?= ($rencanaKegiatanInput["kategori_kegiatan"] ?? "") === $value ? "selected" : "" ?>>
								<?= htmlspecialchars($label, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="tanggalPelaksanaan">Tanggal Pelaksanaan</label><br />
					<input
						class="input-form"
						type="date"
						id="tanggalPelaksanaan"
						name="tanggal_pelaksanaan"
						value="<?= htmlspecialchars($rencanaKegiatanInput["tanggal_pelaksanaan"] ?? "", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>"
						required />
				</div>

				<div class="form-group">
					<label for="lokasiKegiatan">Lokasi Kegiatan</label><br />
					<input
						class="input-form"
						type="text"
						id="lokasiKegiatan"
						name="lokasi_kegiatan"
						maxlength="150"
						value="<?= htmlspecialchars($rencanaKegiatanInput["lokasi_kegiatan"] ?? "", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>"
						required />
				</div>

				<div class="form-group">
					<label for="deskripsiKegiatan">Deskripsi Kegiatan</label><br />
					<textarea
						class="input-form"
						id="deskripsiKegiatan"
						name="deskripsi_kegiatan"
						maxlength="1000"
						rows="4"
						required><?= htmlspecialchars($rencanaKegiatanInput["deskripsi_kegiatan"] ?? "", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></textarea>
				</div>

				<button type="submit">Kirim</button>
				<button type="reset">Batal</button>
				<p class="form-feedback" data-form-feedback aria-live="polite"></p>
			</form>

			<?php if (is_array($rencanaKegiatanResult)): ?>
				<article class="submission-result" aria-live="polite">
					<h3>Rencana Kegiatan Terkirim</h3>
					<div class="table-wrap">
						<table class="data-table">
							<tbody>
								<tr>
									<th scope="row">Nama Kegiatan</th>
									<td><?= htmlspecialchars($rencanaKegiatanResult["nama_kegiatan"], ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></td>
								</tr>
								<tr>
									<th scope="row">Kategori Kegiatan</th>
									<td><?= htmlspecialchars($kategoriKegiatanOptions[$rencanaKegiatanResult["kategori_kegiatan"]] ?? "", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></td>
								</tr>
								<tr>
									<th scope="row">Tanggal Pelaksanaan</th>
									<td><?= htmlspecialchars($rencanaKegiatanResult["tanggal_pelaksanaan"], ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></td>
								</tr>
								<tr>
									<th scope="row">Lokasi Kegiatan</th>
									<td><?= htmlspecialchars($rencanaKegiatanResult["lokasi_kegiatan"], ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></td>
								</tr>
								<tr>
									<th scope="row">Deskripsi Kegiatan</th>
									<td><?= nl2br(htmlspecialchars($rencanaKegiatanResult["deskripsi_kegiatan"], ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8")) ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</article>
			<?php endif; ?>

		</section>
				
		<section id="contact">
			<h2>Kontak</h2>

			<p>
				Kunjungi
				<a target="_blank" href="https://github.com/<?= PROFIL_GITHUB ?>">profil GitHub saya</a>.
			</p>

			<form id="contactForm" class="js-contact-form" data-validation="contact" action="index.php" method="post" novalidate>
				<input type="hidden" name="form_type" value="contact" />
				<div class="form-group">
					<label for="nama">Nama Lengkap</label><br />

					<input
						class="input-form"
						type="text"
						id="nama"
						name="nama"
						placeholder="Masukkan nama lengkap"
						minlength="3"
						maxlength="50"
						required />
				</div>

				<div class="form-group">
					<label for="email">Email</label><br />

					<input class="input-form" type="email" id="email" name="email" placeholder="nama@email.com" required />
				</div>

				<div class="form-group">
					<label for="semester">Semester</label><br />

					<input class="input-form" type="number" id="semester" name="semester" min="1" max="14" required />
				</div>

				<div class="form-group">
					<label for="tanggal">Tanggal Kunjungan</label><br />

					<input class="input-form" type="date" id="tanggal" name="tanggal" required />
				</div>

				<div class="form-group">
					<p>Jenis Pesan</p>

					<input type="radio" id="pertanyaan" name="jenis_pesan" value="pertanyaan" required />
					<label for="pertanyaan">Pertanyaan</label>

					<input type="radio" id="saran" name="jenis_pesan" value="saran" />
					<label for="saran">Saran</label>
				</div>

				<div class="form-group">
					<p>Topik yang Diminati</p>

					<input type="checkbox" id="minat-html" name="minat[]" value="HTML" />
					<label for="minat-html">HTML</label>

					<input type="checkbox" id="minat-css" name="minat[]" value="CSS" />
					<label for="minat-css">CSS</label>
				</div>

				<div class="form-group">
					<label for="prodi">Program Studi</label><br />

					<select class="input-form" id="prodi" name="prodi" required>
						<option value="">-- Pilih Program Studi --</option>
						<option value="SI">Sistem Informasi</option>
						<option value="TI">Teknik Informatika</option>
					</select>
				</div>

				<div class="form-group">
					<label for="pesan">Pesan</label><br />

					<textarea
						class="input-form"
						id="pesan"
						name="pesan"
						maxlength="300"
						placeholder="Tulis pesan Anda"
						required></textarea>
				</div>

				<button type="submit">Kirim</button>
				<button type="reset">Batal</button>
				<p class="form-feedback" data-form-feedback aria-live="polite"></p>
			</form>

			<?php if (isset($_SESSION["nama"])): ?>
				<article id="hasilKontak" class="submission-result" aria-live="polite">
					<h3>Data Formulir yang Dikirim</h3>
					<p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($_SESSION["nama"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Email:</strong> <?= htmlspecialchars($_SESSION["email"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Semester:</strong> <?= htmlspecialchars($_SESSION["semester"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Tanggal Kunjungan:</strong> <?= htmlspecialchars($_SESSION["tanggal"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Jenis Pesan:</strong> <?= htmlspecialchars($_SESSION["jenis_pesan"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Topik yang Diminati:</strong>
						<?= htmlspecialchars(implode(", ", $_SESSION["minat"] ?? []), ENT_QUOTES, "UTF-8") ?>
					</p>
					<p><strong>Program Studi:</strong> <?= htmlspecialchars($_SESSION["prodi"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Pesan:</strong> <?= nl2br(htmlspecialchars($_SESSION["pesan"] ?? "", ENT_QUOTES, "UTF-8")) ?></p>
				</article>
			<?php endif; ?>
		</section>
	</main>

	<footer>
		<p>&copy; <?= date("Y") ?> <?php echo $namaMahasiswa; ?> [<?= $nim ?>]</p>
	</footer>
	<script src="script.js"></script>
</body>

</html>