<?php
session_start();

$formDefaults = [
	"nama" => "",
	"email" => "",
	"semester" => "",
	"tanggal" => "",
	"jenis_pesan" => "",
	"minat" => [],
	"prodi" => "",
	"pesan" => "",
];

$escape = static function (string $value): string {
	return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
};

$pesanKesalahan = $_SESSION["pesanKesalahan"] ?? "";
$nilaiForm = $_SESSION["nilaiForm"] ?? $formDefaults;
$dataTerkirim = $_SESSION["dataTerkirim"] ?? null;
unset($_SESSION["pesanKesalahan"], $_SESSION["nilaiForm"], $_SESSION["dataTerkirim"]);

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
	$nilaiForm = $formDefaults;
	foreach (["nama", "email", "semester", "tanggal", "jenis_pesan", "prodi", "pesan"] as $field) {
		if (isset($_POST[$field]) && is_string($_POST[$field])) {
			$nilaiForm[$field] = trim($_POST[$field]);
		}
	}

	$minatDikirim = $_POST["minat"] ?? [];
	if (is_array($minatDikirim)) {
		$nilaiForm["minat"] = array_values(array_filter($minatDikirim, "is_string"));
	}

	$kesalahan = [];

	if (strlen($nilaiForm["nama"]) < 3 || strlen($nilaiForm["nama"]) > 50) {
		$kesalahan[] = "Nama lengkap harus diisi 3 sampai 50 karakter.";
	}

	if (filter_var($nilaiForm["email"], FILTER_VALIDATE_EMAIL) === false) {
		$kesalahan[] = "Masukkan alamat email yang valid.";
	}

	$semesterTerkirim = filter_var($nilaiForm["semester"], FILTER_VALIDATE_INT);
	if ($semesterTerkirim === false || $semesterTerkirim < 1 || $semesterTerkirim > 14) {
		$kesalahan[] = "Semester harus berupa bilangan bulat antara 1 dan 14.";
	}

	$tanggalTerkirim = DateTime::createFromFormat("!Y-m-d", $nilaiForm["tanggal"]);
	if ($tanggalTerkirim === false || $tanggalTerkirim->format("Y-m-d") !== $nilaiForm["tanggal"]) {
		$kesalahan[] = "Pilih tanggal kunjungan yang valid.";
	}

	if (!in_array($nilaiForm["jenis_pesan"], ["pertanyaan", "saran"], true)) {
		$kesalahan[] = "Pilih jenis pesan.";
	}

	if ($minatDikirim !== [] && !is_array($minatDikirim)) {
		$kesalahan[] = "Format pilihan topik tidak valid.";
	} elseif ($nilaiForm["minat"] === []) {
		$kesalahan[] = "Pilih minimal satu topik yang diminati.";
	} elseif (array_diff($nilaiForm["minat"], ["HTML", "CSS"]) !== []) {
		$kesalahan[] = "Pilihan topik tidak valid.";
	}

	if (!in_array($nilaiForm["prodi"], ["SI", "TI"], true)) {
		$kesalahan[] = "Pilih program studi.";
	}

	if ($nilaiForm["pesan"] === "" || strlen($nilaiForm["pesan"]) > 300) {
		$kesalahan[] = "Pesan wajib diisi dan maksimal 300 karakter.";
	}

	if ($kesalahan !== []) {
		$_SESSION["pesanKesalahan"] = implode(" ", $kesalahan);
		$_SESSION["nilaiForm"] = $nilaiForm;
	} else {
		$_SESSION["dataTerkirim"] = $nilaiForm;
	}

	header("Location: index.php");
	exit;
}

$pesanKesalahan = is_string($pesanKesalahan) ? $pesanKesalahan : "";
$nilaiForm = is_array($nilaiForm) ? array_merge($formDefaults, $nilaiForm) : $formDefaults;
$nilaiForm["minat"] = is_array($nilaiForm["minat"]) ? $nilaiForm["minat"] : [];
$dataTerkirim = is_array($dataTerkirim) ? $dataTerkirim : null;

$nim = "0344300002";
$namaMahasiswa = "Cantika Putih";
$programStudi = "SI";
$tahunAkademik = "2026/2027";
$semester = 4;
$ipk = 3.75;
$statusAktif = true;
$catatanTambahan = null;

const NAMA_MATA_KULIAH = "Pemrograman Web Dasar";
const PROFIL_GITHUB = "satpamal";

$batasSemester = 8;
$sisaSemester = $batasSemester - $semester;
$semesterValid = $semester >= 1 && $semester <= $batasSemester;
$statusSemester = ($semesterValid && $statusAktif) ? "Sesuai rentang" : "Perlu diperiksa";

if ($semester < 3) {
	$keteranganSemester = "Semester awal";
} elseif ($semester <= 6) {
	$keteranganSemester = "Semester menengah";
} else {
	$keteranganSemester = "Semester akhir";
}

$namaProdi = $programStudi === "SI"
	? "Sistem Informasi"
	: ($programStudi === "TI" ? "Teknik Informatika" : "Lainnya");

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
				<li><a href="#contact">Kontak</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<section id="home">
			<h2>Selamat Datang</h2>
			<p>
				Halo, saya <strong><?php echo $escape($namaMahasiswa); ?></strong>.
				Saya sedang mempelajari mata kuliah
				<strong><?php echo $escape(NAMA_MATA_KULIAH); ?></strong>
				pada tahun akademik <?php echo $escape($tahunAkademik); ?>.
			</p>
			<img src="img/foto-profil.jpg" alt="Foto profil <?php echo $escape($namaMahasiswa); ?>" />
		</section>

		<section id="about">
			<h2>Tentang Saya</h2>
			<article>
				<h3>Profil Singkat</h3>
				<p>Program Studi: <?php echo $escape($namaProdi . " (" . $programStudi . ")"); ?></p>
				<p>Fokus program studi: <?php echo $escape($fokusProgramStudi); ?></p>
				<p>Status mahasiswa: <?php echo $statusAktif ? "Aktif" : "Tidak aktif"; ?></p>
				<p>Semester: <?php echo $semester . " (" . $escape($keteranganSemester) . ")"; ?></p>
				<p>Sisa semester hingga batas: <?php echo $sisaSemester; ?></p>
				<p>Pemeriksaan rentang semester: <?php echo $escape($statusSemester); ?></p>
				<p>IPK: <?php echo number_format($ipk, 2, ",", "."); ?></p>
				<p>Catatan tambahan: <?php echo $catatanTambahan === null ? "Belum ada" : $escape($catatanTambahan); ?></p>

				<h3>Target Belajar (Perulangan for)</h3>
				<ol>
					<?php
					$targetBelajar = [
						"Memahami sintaks dasar PHP.",
						"Menggunakan variabel dan konstanta.",
						"Menerapkan operator dan percabangan.",
						"Menggunakan perulangan for dan while.",
					];
					for ($i = 1; $i <= 5; $i++) :
					?>
						<li>Target belajar ke-<?php echo $i; ?>:
							<?php echo $escape($targetBelajar[$i - 1] ?? "Belum dipetakan"); ?>
						</li>
					<?php endfor; ?>
				</ol>

				<h3>Semester (Perulangan while)</h3>
				<ol>
					<?php
					$nomorSemester = 1;
					while ($nomorSemester <= 3) :
					?>
						<li>Semester <?php echo $nomorSemester; ?></li>
					<?php
						$nomorSemester++;
					endwhile;
					?>
				</ol>
			</article>
		</section>

		<section id="contact">
			<h2>Kontak</h2>
			<p>
				Kunjungi
				<a target="_blank" rel="noopener noreferrer" href="https://github.com/<?php echo rawurlencode(PROFIL_GITHUB); ?>">profil GitHub saya</a>.
			</p>

			<?php if ($pesanKesalahan !== "") : ?>
				<p class="form-feedback-error" role="alert"><?php echo $escape($pesanKesalahan); ?></p>
			<?php endif; ?>

			<form id="contactForm" action="index.php" method="post" novalidate>
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
						value="<?php echo $escape((string) $nilaiForm["nama"]); ?>"
						required />
				</div>

				<div class="form-group">
					<label for="email">Email</label><br />
					<input
						class="input-form"
						type="email"
						id="email"
						name="email"
						placeholder="nama@email.com"
						value="<?php echo $escape((string) $nilaiForm["email"]); ?>"
						required />
				</div>

				<div class="form-group">
					<label for="semester">Semester</label><br />
					<input
						class="input-form"
						type="number"
						id="semester"
						name="semester"
						min="1"
						max="14"
						step="1"
						value="<?php echo $escape((string) $nilaiForm["semester"]); ?>"
						required />
				</div>

				<div class="form-group">
					<label for="tanggal">Tanggal Kunjungan</label><br />
					<input
						class="input-form"
						type="date"
						id="tanggal"
						name="tanggal"
						value="<?php echo $escape((string) $nilaiForm["tanggal"]); ?>"
						required />
				</div>

				<div class="form-group">
					<p>Jenis Pesan</p>
					<input
						type="radio"
						id="pertanyaan"
						name="jenis_pesan"
						value="pertanyaan"
						<?php echo $nilaiForm["jenis_pesan"] === "pertanyaan" ? "checked" : ""; ?>
						required />
					<label for="pertanyaan">Pertanyaan</label>
					<input
						type="radio"
						id="saran"
						name="jenis_pesan"
						value="saran"
						<?php echo $nilaiForm["jenis_pesan"] === "saran" ? "checked" : ""; ?> />
					<label for="saran">Saran</label>
				</div>

				<div class="form-group">
					<p>Topik yang Diminati</p>
					<input
						type="checkbox"
						id="minat-html"
						name="minat[]"
						value="HTML"
						<?php echo in_array("HTML", $nilaiForm["minat"], true) ? "checked" : ""; ?> />
					<label for="minat-html">HTML</label>
					<input
						type="checkbox"
						id="minat-css"
						name="minat[]"
						value="CSS"
						<?php echo in_array("CSS", $nilaiForm["minat"], true) ? "checked" : ""; ?> />
					<label for="minat-css">CSS</label>
				</div>

				<div class="form-group">
					<label for="prodi">Program Studi</label><br />
					<select class="input-form" id="prodi" name="prodi" required>
						<option value="">-- Pilih Program Studi --</option>
						<option value="SI" <?php echo $nilaiForm["prodi"] === "SI" ? "selected" : ""; ?>>Sistem Informasi</option>
						<option value="TI" <?php echo $nilaiForm["prodi"] === "TI" ? "selected" : ""; ?>>Teknik Informatika</option>
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
						required><?php echo $escape((string) $nilaiForm["pesan"]); ?></textarea>
				</div>

				<button type="submit">Kirim</button>
				<button type="reset">Batal</button>
				<p id="formFeedback" aria-live="polite"></p>
			</form>

			<?php if ($dataTerkirim !== null) : ?>
				<h3>Data yang Diterima Peladen</h3>
				<p>Nama: <?php echo $escape((string) $dataTerkirim["nama"]); ?></p>
				<p>Email: <?php echo $escape((string) $dataTerkirim["email"]); ?></p>
				<p>Semester: <?php echo $escape((string) $dataTerkirim["semester"]); ?></p>
				<p>Tanggal kunjungan: <?php echo $escape((string) $dataTerkirim["tanggal"]); ?></p>
				<p>Jenis pesan: <?php echo $escape((string) $dataTerkirim["jenis_pesan"]); ?></p>
				<p>Program studi: <?php echo $escape((string) $dataTerkirim["prodi"]); ?></p>
				<p>Topik yang diminati: <?php echo $escape(implode(", ", $dataTerkirim["minat"])); ?></p>
				<p>Pesan: <?php echo nl2br($escape((string) $dataTerkirim["pesan"])); ?></p>
			<?php endif; ?>
		</section>
	</main>

	<footer>
		<p>&copy; <?php echo date("Y"); ?> <?php echo $escape($namaMahasiswa); ?> [<?php echo $escape($nim); ?>]</p>
	</footer>
	<script src="script.js"></script>
</body>
</html>
