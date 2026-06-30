-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2026 at 01:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sibago`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `konten` text DEFAULT NULL,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `slug`, `judul`, `konten`) VALUES
(1, 'identitas', 'Identitas SI-BAGO', 'SI-BAGO (Smart Innovative Boardgame Geometri) hadir sebagai manifestasi media pembelajaran modern yang secara radikal mengubah wajah pembelajaran matematika dari sekadar hafalan rumus menjadi sebuah pengalaman eksploratif yang imersif. Melalui format permainan papan yang dinamis, media ini membedah kekakuan konsep geometri abstrak dan mentransformasikannya ke dalam realitas fisik yang dapat disentuh serta dimanipulasi oleh siswa. Kehadiran SI-BAGO menciptakan jembatan kognitif yang kuat, di mana siswa diajak untuk menjadi arsitek logis yang harus menggunakan ketajaman numerasinya untuk menyelesaikan berbagai misi strategis terkait luas, volume, hingga sifat-sifat bangun ruang yang tersaji secara visual di atas papan permainan. Kekuatan utama yang membedakan SI-BAGO dengan media lainnya adalah integrasi mendalam terhadap nilai etnomatematika Jawa Tengah. Dengan menghadirkan unsur arsitektur tradisional seperti rumah Joglo dan ornamen lokal ke dalam desain permainan, SI-BAGO membuktikan bahwa matematika adalah bagian tak terpisahkan dari napas kebudayaan. Pendekatan ini tidak hanya memudahkan pemahaman konsep secara kontekstual, tetapi juga menumbuhkan rasa bangga dan kesadaran budaya pada diri siswa. Harmonisasi ini semakin diperkuat dengan sentuhan teknologi QR-Code yang menghubungkan interaksi fisik dengan platform digital informatif. Melalui sekali pindai, siswa akan diarahkan menuju portal web yang menyajikan informasi mendalam mengenai media pembelajaran ini, sekaligus membedah kekayaan kebudayaan Jawa Tengah dan keterkaitannya yang erat dengan prinsip-prinsip geometri, sehingga siswa mendapatkan wawasan sejarah yang lebih luas di tengah permainan. Lebih jauh lagi, SI-BAGO berperan aktif sebagai katalisator dalam menstimulasi kemampuan spasial dan kecerdasan visual siswa. Aktivitas manipulasi bidak serta eksplorasi jaring-jaring bangun ruang mengasah ketajaman persepsi dalam memahami posisi, rotasi, dan proyeksi objek secara akurat. Di balik keseruan permainannya, SI-BAGO secara sistematis membangun fondasi literasi dan numerasi yang kokoh melalui mekanisme gamifikasi yang menantang siswa untuk berpikir kritis dan solutif. Setiap langkah di atas papan permainan memerlukan analisis mendalam dan komunikasi matematis yang efektif, sehingga siswa tidak hanya cerdas secara individu, tetapi juga terlatih dalam berkolaborasi dan berkompetisi secara sehat. Sebagai solusi tuntas dalam mengatasi kecemasan matematika, SI-BAGO memastikan bahwa setiap sesi belajar meninggalkan kesan emosional yang positif dan bermakna. Dengan mengubah ruang kelas menjadi arena petualangan intelektual, media ini berhasil membangun motivasi belajar yang tinggi dan resiliensi siswa dalam menghadapi tantangan logika yang kompleks. SI-BAGO adalah wujud nyata dari pendidikan masa depan yang menghormati akar tradisi, merangkul kemajuan teknologi, dan memprioritaskan perkembangan kognitif serta karakter siswa secara holistik, menjadikan geometri sebagai ilmu yang hidup, menyenangkan, dan penuh makna bagi kehidupan mereka.'),
(2, 'logo', 'Filosofi Logo SI-BAGO', 'Logo SI-BAGO dirancang untuk melambangkan transformasi pembelajaran matematika yang kaku menjadi sebuah petualangan interaktif, di mana setiap elemen visualnya mencerminkan nilai edukasi, budaya, dan teknologi. 1) Wajah Penari Kretek Sebagai ikon khas Kudus yang sarat akan nilai historis, visualisasi wajah penari ini bukan sekadar elemen dekoratif, melainkan representasi mendalam bahwa pendidikan sejatinya harus bermuara pada pembentukan karakter siswa yang kokoh. Simbol ini mencerminkan ketekunan, kehalusan budi, dan kebanggaan yang berakar kuat pada identitas daerah, mengingatkan kita bahwa proses belajar mengajar tidak boleh melepaskan diri dari nilai-nilai kemanusiaan. Dalam perspektif SI-BAGO, belajar bukan hanya tentang penguasaan deretan angka atau rumus yang kaku, melainkan sebuah perjalanan untuk membentuk pribadi yang santun, memiliki integritas, serta menaruh hormat setinggi-tingginya terhadap warisan leluhur sebagai kompas moral di tengah kemajuan zaman. 2) Lampu Berdampingan dengan simbol tradisi tersebut, kehadiran lampu yang menyala terang menjadi representasi visual dari lahirnya sebuah ide baru dan pencerahan intelektual. Cahaya ini melambangkan komitmen SI-BAGO untuk mengubah paradigma belajar dari sekadar aktivitas menghafal pasif menjadi proses stimulasi mental yang aktif dan dinamis. Lampu yang berpijar mencerminkan momen \"eureka\" ketika seorang siswa berhasil memecahkan kebuntuan berpikir, sekaligus memicu kemampuan analisis kritis dalam membedah setiap tantangan. Secara filosofis, elemen ini menegaskan bahwa keberhasilan belajar diukur dari sejauh mana siswa mampu mengonstruksi pemikiran orisinal, menemukan solusi inovatif atas masalah yang kompleks, dan memiliki daya nalar yang tajam sebagai bekal kognitif mereka di masa depan. 3) Bentuk-Bentuk Geometri Kehadiran bentuk-bentuk geometris seperti kubus, kerucut, dan tabung dalam identitas visual ini bukanlah sekadar elemen estetika atau hiasan visual tanpa makna. Lebih dari itu, elemen-elemen tersebut merupakan representasi fundamental dari fokus utama SI-BAGO dalam mengonstruksi pemahaman matematis siswa secara komprehensif. Kehadiran berbagai bangun ruang ini melambangkan komitmen untuk memperkuat kemampuan numerasi melalui interaksi langsung, di mana siswa diajak untuk membedah setiap sisi, sudut, dan volume sebagai bagian dari strategi permainan. 4) Warna Emas Penggunaan warna Emas dalam logo ini melambangkan pancaran kejayaan, standar kualitas tinggi, dan puncak intelektualitas yang ingin dicapai melalui proses pembelajaran. Secara psikologis, warna ini berfungsi sebagai pemantik semangat bagi siswa untuk berani memasang target tinggi dan mengejar mimpi mereka setinggi langit tanpa rasa takut. Emas merefleksikan sebuah ambisi untuk menjadi unggul dalam penguasaan literasi matematika dan numerasi, sekaligus menyimbolkan nilai berharga dari ilmu pengetahuan yang diperoleh. Dalam konteks SI-BAGO, warna Emas adalah representasi dari kesuksesan kognitif dan prestasi gemilang yang lahir dari ketajaman berpikir serta dedikasi dalam belajar. 5) Warna Salem Warna Salem dihadirkan sebagai penyeimbang filosofis yang mewakili kelembutan hati, ketenangan, dan ketulusan kepribadian. Kehadiran warna ini membawa pesan bahwa setinggi apa pun pencapaian intelektual seseorang, mereka harus tetap berpijak di bumi dengan karakter yang mulia, penuh kasih, dan santun terhadap sesama. Salem mencerminkan sisi humanis dari pendidikan, di mana SI-BAGO tidak hanya berfokus pada kecerdasan logika, tetapi juga pada kematangan emosional dan etika. Warna ini adalah simbol dari kerendahan hati dan empati, memastikan bahwa setiap ilmu yang diraih digunakan dengan cara yang bijak dan memberikan kedamaian bagi lingkungan sekitarnya.'),
(3, 'etnomatematika', 'Etnomatematika Jawa Tengah', 'Etnomatematika dalam SI-BAGO hadir untuk membuktikan bahwa matematika bukanlah sekadar angka di atas kertas, melainkan napas budaya yang telah lama hidup dalam keseharian masyarakat Jawa Tengah. Melalui media ini, siswa diajak menelusuri jejak logika para leluhur yang tertuang dalam arsitektur megah, kelezatan kuliner, hingga artefak tradisional yang sarat akan nilai geometri. 1) Nasi Tumpeng (Kerucut) Bentuknya yang menjulang tinggi ke atas adalah contoh Kerucut. Bagian bawahnya bulat (lingkaran) dan ujungnya lancip. (Hampir di seluruh daerah Jawa Tengah). 2) Kue Wajik (Prisma Belah Ketupat) Kue manis ini dipotong miring supaya membentuk Prisma. Alasnya terlihat seperti jajar genjang atau belah ketupat. (Banyak ditemukan di Magelang dan Semarang). 3) Rumah Joglo (Limas Terpancung) Coba lihat atap paling atas rumah Joglo. Bentuknya seperti Limas yang dipotong bagian pucuknya. Jadi, bagian atasnya datar! (Rumah adat khas Jawa Tengah). 4) Kue Gabin Tapai (Balok) Dua biskuit kotak yang mengapit tapai ini membentuk Balok tipis. Ada sisi atas, bawah, dan samping yang semuanya berbentuk persegi panjang. (Camilan populer di Jawa Tengah). 5) Onde-onde (Bola) Jajanan bulat berbalur wijen ini adalah contoh Bola. Tidak punya sudut, hanya ada satu permukaan melengkung. (Sangat terkenal di daerah Mojokerto dan sekitarnya). 6) Kue Lapis Legit (Kubus atau Balok) Kue ini punya banyak lapisan warna. Kalau dipotong kotak sama panjang, jadilah Kubus yang cantik! (Sajian khas saat hari raya di Jawa Tengah). 7) Bedug Masjid (Tabung) Alat musik pukul di masjid ini bentuknya Tabung raksasa. Kulit sapinya berbentuk lingkaran, dan badannya melengkung panjang. (Contohnya ada di Masjid Agung Demak). 8) Gamelan Gender (Tabung & Prisma) Bilah logam yang dipukul itu berbentuk Prisma, sedangkan bambu panjang di bawahnya adalah Tabung untuk membuat suara jadi merdu. (Kesenian khas Jawa Tengah). 9) Lemper (Tabung) Nasi ketan isi ayam yang dibungkus daun pisang ini berbentuk Tabung kecil yang lucu. (Camilan wajib di daerah Solo dan Yogyakarta). 10) Lontong (Tabung) Mirip lemper tapi lebih panjang. Lontong adalah contoh Tabung yang tinggi. (Sering ditemukan sebagai teman makan sate di Jawa Tengah). 11) Caping Petani (Kerucut) Topi yang dipakai pak tani di sawah ini berbentuk Kerucut. Bagian dalamnya kosong supaya bisa dipakai di kepala. (Banyak dipakai petani di daerah Kudus dan sekitarnya). 12) Jadah (Balok) Ketan putih yang kenyal ini biasanya dipotong kotak-kotak berbentuk Balok yang rapi. (Sangat terkenal di daerah Selo, Boyolali). 13) Bakul Nasi / Tumbu (Limas Terpancung) Wadah nasi dari bambu ini unik. Bawahnya kotak (persegi), tapi atasnya melebar jadi lingkaran. Mirip Limas yang dipotong. (Alat dapur tradisional Jawa Tengah). 14) Kue Ku / Kue Thok (Setengah Bola) Kue merah yang kenyal ini bentuknya seperti Setengah Bola yang sedikit lonjong. (Sering ada di pasar tradisional Jawa Tengah). 15) Kentongan (Tabung Berongga) Terbuat dari batang bambu atau kayu yang dilubangi tengahnya. Bentuk dasarnya adalah Tabung. (Alat ronda di desa-desa Jawa Tengah). 16) Serabi Solo (Tabung Sangat Pendek) Bentuknya bulat dan tipis. Walaupun tipis, serabi tetap punya tinggi, jadi termasuk Tabung yang sangat pendek. (Makanan khas Solo). 17) Candi Borobudur (Limas Berundak) Kalau dilihat dari jauh, candi ini berbentuk Limas raksasa yang punya banyak tingkatan kotak. (Terletak di Magelang). 18) Stupa Candi (Campuran Setengah Bola & Kerucut) Stupa adalah gabungan dua bangun ruang. Bawahnya bulat seperti Setengah Bola, atasnya lancip seperti Kerucut. (Ada di Candi Borobudur). 19) Kue Putu (Tabung) Kue ini dimasak di dalam bambu kecil, jadi saat keluar bentuknya pasti Tabung mengikuti bambunya. (Banyak dijual keliling di Jawa Tengah). 20) Gapura Candi Bentar (Prisma Terbelah) Gapura pintu masuk ini seperti sebuah bangunan tinggi yang dibelah tengahnya. Setiap belahannya berbentuk Prisma. (Banyak di situs sejarah seperti di Demak atau Kudus).'),
(4, 'gladhen', 'Kartu Gladhen', 'To be continued..'),
(5, 'penyusun', 'Seputar Penyusun', '• Dr. Henry Suryo Bintoro, S. Pd., M. Pd. Dr. Henry Suryo Bintoro, S. Pd., M. Pd. lahir di • Galeh Febrian Agustino Galeh Febrian Agustino, lahir di Kudus 23 Februari 2005. Penulis merupakan seorang mahasiswa aktif di Program Studi Pendidikan Matematika, Fakultas Keguruan dan Ilmu Pendidikan, Universitas Muria Kudus. Adapun kegiatan kemahasiswaan yang diikuti antara Himpunan Mahasiswa Pendidikan Matematika (HIMATIKA). • Meutya Rahma Hakim Meutya Rahma Hakim, lahir di Kudus • Luqyana Rosyada • Muhammad Rifky Nur Rahman • Muhammad Fajar Maulana • Muhammad Azka Latif'),
(6, 'dokumentasi', 'Dokumentasi SI-BAGO', 'Dokumentasi ini merangkum perjalanan kreatif lahirnya SI-BAGO, sebuah media pembelajaran yang mengubah kerumitan geometri menjadi petualangan visual yang seru. Di sini, kami mencatat bagaimana matematika, budaya Jawa Tengah, dan teknologi bersatu untuk menciptakan pengalaman belajar yang nyata bagi siswa. Melalui catatan ini, kami ingin memperlihatkan bahwa belajar numerasi tidak harus kaku. Dengan SI-BAGO, setiap anak diajak untuk berpikir kritis, mengasah logika ruang, dan tetap mencintai warisan leluhur. Inilah wujud nyata komitmen kami untuk masa depan pendidikan yang lebih inovatif dan berkarakter.');

-- --------------------------------------------------------

--
-- Table structure for table `penyusun`
--

CREATE TABLE `penyusun` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyusun`
--

INSERT INTO `penyusun` (`id`, `nama`, `foto`, `bio`, `created_at`) VALUES
(1, 'Dr. Ahmad Santoso, M.Pd.', 'assets/img/default-avatar.png', 'Dosen Matematika di Universitas Pendidikan Indonesia dengan pengalaman 15 tahun dalam pengembangan kurikulum etnomatematika. Ahli dalam integrasi budaya lokal dengan pembelajaran matematika.', '2026-01-26 12:21:28'),
(2, 'Prof. Siti Nurhaliza, Ph.D.', 'assets/img/default-avatar.png', 'Professor Antropologi Budaya di Universitas Gajah Mada. Spesialis dalam kajian etnomatematika Jawa dan preservasi pengetahuan tradisional matematika masyarakat adat.', '2026-01-26 12:21:28'),
(3, 'Dr. Budi Prasetyo, M.T.', 'assets/img/default-avatar.png', 'Dosen Teknik Informatika dengan fokus pada pengembangan aplikasi edukasi interaktif. Pengembang Sistem Informasi BORI (Bahan Ajar Online Repository Interaktif).', '2026-01-26 12:21:28'),
(4, 'Dra. Maya Sari, M.Si.', 'assets/img/default-avatar.png', 'Peneliti di Pusat Penelitian Matematika dan Sains. Ahli dalam metodologi penelitian kualitatif untuk studi etnomatematika dan dokumentasi pengetahuan lokal.', '2026-01-26 12:21:28'),
(5, 'Dr. Rudi Hartono, M.Pd.', 'assets/img/default-avatar.png', 'Dosen Pendidikan Matematika di Universitas Negeri Jakarta. Kontributor utama dalam pengembangan modul pembelajaran etnomatematika berbasis proyek.', '2026-01-26 12:21:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penyusun`
--
ALTER TABLE `penyusun`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `penyusun`
--
ALTER TABLE `penyusun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
