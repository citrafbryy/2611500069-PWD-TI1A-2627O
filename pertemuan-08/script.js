// Navigasi responsif.
const navToggle = document.getElementById("navToggle");
const navMenu = document.getElementById("navMenu");

if (navToggle && navMenu) {
  navToggle.addEventListener("click", () => {
    const isOpen = navMenu.classList.toggle("nav-open");
    navToggle.setAttribute("aria-expanded", String(isOpen));
    navToggle.setAttribute(
      "aria-label",
      isOpen ? "Tutup navigasi" : "Buka navigasi",
    );
  });
}

// Validasi formulir Rencana Kegiatan Mahasiswa.
const activityForm = document.querySelector(
  'form[data-validation="rencana-kegiatan"]',
);

if (activityForm) {
  const formFeedback = activityForm.querySelector("[data-form-feedback]");
  const namaKegiatan = activityForm.elements.namedItem("nama_kegiatan");
  const kategoriKegiatan = activityForm.elements.namedItem("kategori_kegiatan");
  const tanggalPelaksanaan = activityForm.elements.namedItem(
    "tanggal_pelaksanaan",
  );
  const lokasiKegiatan = activityForm.elements.namedItem("lokasi_kegiatan");
  const deskripsiKegiatan = activityForm.elements.namedItem(
    "deskripsi_kegiatan",
  );
  const kategoriValid = [
    "akademik",
    "organisasi",
    "sosial",
    "olahraga",
    "seni-budaya",
    "lainnya",
  ];
  const hitungKarakter = (nilai) => Array.from(nilai).length;

  const tampilkanKesalahan = (pesan) => {
    if (formFeedback) {
      formFeedback.textContent = pesan;
      formFeedback.className = "form-feedback-error";
    }
  };

  const tanggalValid = (tanggal) => {
    const cocok = /^(\d{4})-(\d{2})-(\d{2})$/.exec(tanggal);
    if (!cocok) {
      return false;
    }

    const tahun = Number(cocok[1]);
    const bulan = Number(cocok[2]);
    const hari = Number(cocok[3]);
    const kabisat =
      tahun % 4 === 0 && (tahun % 100 !== 0 || tahun % 400 === 0);
    const jumlahHari = [
      31,
      kabisat ? 29 : 28,
      31,
      30,
      31,
      30,
      31,
      31,
      30,
      31,
      30,
      31,
    ];

    return (
      tahun >= 1 &&
      bulan >= 1 &&
      bulan <= 12 &&
      hari >= 1 &&
      hari <= jumlahHari[bulan - 1]
    );
  };

  activityForm.addEventListener("submit", (event) => {
    event.preventDefault();

    namaKegiatan.value = namaKegiatan.value.trim();
    kategoriKegiatan.value = kategoriKegiatan.value.trim();
    tanggalPelaksanaan.value = tanggalPelaksanaan.value.trim();
    lokasiKegiatan.value = lokasiKegiatan.value.trim();
    deskripsiKegiatan.value = deskripsiKegiatan.value.trim();

    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }

    if (
      hitungKarakter(namaKegiatan.value) < 3 ||
      hitungKarakter(namaKegiatan.value) > 100
    ) {
      tampilkanKesalahan("Nama kegiatan wajib diisi 3 sampai 100 karakter.");
      namaKegiatan.focus();
      return;
    }

    if (!kategoriValid.includes(kategoriKegiatan.value)) {
      tampilkanKesalahan("Pilih kategori kegiatan yang tersedia.");
      kategoriKegiatan.focus();
      return;
    }

    if (!tanggalValid(tanggalPelaksanaan.value)) {
      tampilkanKesalahan("Masukkan tanggal pelaksanaan yang valid.");
      tanggalPelaksanaan.focus();
      return;
    }

    if (
      hitungKarakter(lokasiKegiatan.value) < 2 ||
      hitungKarakter(lokasiKegiatan.value) > 150
    ) {
      tampilkanKesalahan("Lokasi kegiatan wajib diisi, maksimal 150 karakter.");
      lokasiKegiatan.focus();
      return;
    }

    if (
      hitungKarakter(deskripsiKegiatan.value) === 0 ||
      hitungKarakter(deskripsiKegiatan.value) > 1000
    ) {
      tampilkanKesalahan(
        "Deskripsi kegiatan wajib diisi dan maksimal 1000 karakter.",
      );
      deskripsiKegiatan.focus();
      return;
    }

    activityForm.submit();
  });

  activityForm.addEventListener("reset", (event) => {
    event.preventDefault();
    namaKegiatan.value = "";
    kategoriKegiatan.value = "";
    tanggalPelaksanaan.value = "";
    lokasiKegiatan.value = "";
    deskripsiKegiatan.value = "";

    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }

    activityForm
      .closest("#rencana-kegiatan-mahasiswa")
      ?.querySelector("[data-rencana-errors]")
      ?.remove();
  });

  activityForm.addEventListener("input", () => {
    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }
  });
}

// Validasi formulir Kontak.
// Selector menggunakan atribut/class, bukan ID formulir tertentu,
// sehingga formulir lain dapat ditambahkan dengan ID yang berbeda.
const contactForms = document.querySelectorAll(
  'form[data-validation="contact"]',
);

contactForms.forEach((contactForm) => {
  const formFeedback = contactForm.querySelector("[data-form-feedback]");

  const ambilInput = (nama) => contactForm.elements.namedItem(nama);

  contactForm.addEventListener("submit", (event) => {
    // Mencegah pengiriman otomatis sebelum seluruh validasi selesai.
    event.preventDefault();

    const namaInput = ambilInput("nama");
    const emailInput = ambilInput("email");
    const semesterInput = ambilInput("semester");
    const tanggalInput = ambilInput("tanggal");
    const prodiInput = ambilInput("prodi");
    const pesanInput = ambilInput("pesan");
    const jenisPesan = contactForm.querySelector(
      'input[name="jenis_pesan"]:checked',
    );
    const topikDipilih = contactForm.querySelectorAll(
      'input[name="minat[]"]:checked',
    );

    const nama = namaInput.value.trim();
    const email = emailInput.value.trim();
    const semester = Number(semesterInput.value);
    const tanggal = tanggalInput.value;
    const prodi = prodiInput.value;
    const pesan = pesanInput.value.trim();

    const tampilkanKesalahan = (pesanKesalahan) => {
      if (formFeedback) {
        formFeedback.textContent = pesanKesalahan;
        formFeedback.className = "form-feedback-error";
      }
    };

    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }

    if (nama.length < 3 || nama.length > 50) {
      tampilkanKesalahan("Nama lengkap harus diisi 3 sampai 50 karakter.");
      return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      tampilkanKesalahan("Masukkan alamat email yang valid.");
      return;
    }

    if (
      semesterInput.value.trim() === "" ||
      !Number.isInteger(semester) ||
      semester < 1 ||
      semester > 14
    ) {
      tampilkanKesalahan("Semester harus diisi dengan angka 1 sampai 14.");
      return;
    }

    if (tanggal === "") {
      tampilkanKesalahan("Tanggal kunjungan harus diisi.");
      return;
    }

    if (!jenisPesan) {
      tampilkanKesalahan("Pilih jenis pesan.");
      return;
    }

    if (topikDipilih.length === 0) {
      tampilkanKesalahan("Pilih minimal satu topik yang diminati.");
      return;
    }

    if (prodi === "") {
      tampilkanKesalahan("Pilih program studi.");
      return;
    }

    if (pesan.length === 0 || pesan.length > 300) {
      tampilkanKesalahan("Pesan harus diisi dan maksimal 300 karakter.");
      return;
    }

    // Mengirim formulir setelah seluruh validasi JavaScript berhasil.
    // HTMLFormElement.submit() tidak memicu event submit kembali.
    contactForm.submit();
  });

  contactForm.addEventListener("reset", () => {
    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }
  });

  contactForm.addEventListener("input", () => {
    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }
  });
});
