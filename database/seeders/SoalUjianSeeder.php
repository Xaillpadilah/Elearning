<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SoalUjian;
use App\Models\Ujian;

class SoalUjianSeeder extends Seeder
{
    public function run(): void
    {
        $ujians = Ujian::with('guruMapelKelas.mapel')->get();

        if ($ujians->isEmpty()) {
            $this->command->error('Belum ada data ujian. Jalankan UjianSeeder terlebih dahulu.');
            return;
        }

        $soalBank = $this->getSoalBank();

        foreach ($ujians as $ujian) {
            $mapelNama = strtolower($ujian->guruMapelKelas->mapel->nama_mapel ?? 'umum');

            $soals = $soalBank[$mapelNama] ?? $this->generateSoalUmum();

            if (count($soals) < 20) {
                $this->command->warn("Jumlah soal untuk mapel '$mapelNama' kurang dari 20. Mengisi sisanya dengan soal umum.");
                $soals = array_merge($soals, array_slice($this->generateSoalUmum(), 0, 20 - count($soals)));
            }

            $this->shuffleArray($soals);

            for ($i = 0; $i < 20; $i++) {
                $item = $soals[$i];

                SoalUjian::create([
                    'ujian_id' => $ujian->id,
                    'nomor' => $i + 1,
                    'pertanyaan' => $item['pertanyaan'],
                    'opsi_a' => $item['opsi'][0],
                    'opsi_b' => $item['opsi'][1],
                    'opsi_c' => $item['opsi'][2],
                    'opsi_d' => $item['opsi'][3],
                    'jawaban_benar' => $item['jawaban'],
                ]);
            }
        }

        $this->command->info('Seeder Soal Ujian selesai: 20 soal per ujian berhasil dibuat.');
    }

    private function shuffleArray(array &$array): void
    {
        for ($i = count($array) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$array[$i], $array[$j]] = [$array[$j], $array[$i]];
        }
    }

    private function generateSoalUmum(): array
    {
        $soal = [];
        for ($i = 1; $i <= 30; $i++) {
            $soal[] = [
                'pertanyaan' => "Soal umum ke-$i: Apa jawaban yang paling tepat?",
                'opsi' => ["A$i", "B$i", "C$i", "D$i"],
                'jawaban' => 'a'
            ];
        }
        return $soal;
    }

   private function getSoalBank(): array
{
   return [
    //jangan akar
   'matematika' => [
    [
        'pertanyaan' => "Hasil dari 36 × 24 adalah?",
        'opsi' => ["840", "864", "856", "852"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 480 ÷ 12 adalah?",
        'opsi' => ["36", "40", "42", "38"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 15 × 18 adalah?",
        'opsi' => ["270", "280", "260", "250"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Jika 84 ÷ x = 7, maka x = ...?",
        'opsi' => ["10", "12", "14", "16"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Hasil dari 125 × 8 adalah?",
        'opsi' => ["950", "975", "1000", "1025"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Hasil dari 560 ÷ 8 adalah?",
        'opsi' => ["60", "70", "75", "80"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 48 × 25 adalah?",
        'opsi' => ["1100", "1200", "1150", "1250"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Jika 324 ÷ 9 = x, maka x = ...?",
        'opsi' => ["34", "36", "38", "32"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 56 × 15 adalah?",
        'opsi' => ["830", "840", "850", "860"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 729 ÷ 9 adalah?",
        'opsi' => ["80", "81", "82", "83"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Jika 48 ÷ 1/2, hasilnya adalah?",
        'opsi' => ["24", "48", "96", "12"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Hasil dari 0,6 × 0,3 adalah?",
        'opsi' => ["0,18", "0,2", "0,16", "0,12"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Hasil dari 7/8 ÷ 1/4 adalah?",
        'opsi' => ["1 3/4", "2", "2 3/4", "3"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Jika 3/5 × x = 9, maka x = ...?",
        'opsi' => ["12", "15", "10", "13"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 0,25 ÷ 0,05 adalah?",
        'opsi' => ["4", "5", "6", "7"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 3/4 × 16 adalah?",
        'opsi' => ["12", "14", "10", "11"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Jika x ÷ 7 = 9, maka x = ...?",
        'opsi' => ["56", "63", "49", "72"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 0,9 × 0,6 adalah?",
        'opsi' => ["0,54", "0,56", "0,52", "0,50"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Jika 5/6 ÷ 1/2 = ...",
        'opsi' => ["5/12", "5/3", "10/6", "1/2"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hasil dari 2,4 ÷ 0,3 adalah?",
        'opsi' => ["7", "8", "8,5", "9"],
        'jawaban' => 'b'
    ],
],

       'pkn' => [
    [
        'pertanyaan' => "Apa makna lambang bintang pada Pancasila?",
        'opsi' => ["Ketuhanan Yang Maha Esa", "Kemanusiaan yang adil dan beradab", "Persatuan Indonesia", "Keadilan sosial"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Siapakah presiden pertama Republik Indonesia?",
        'opsi' => ["Soekarno", "Mohammad Hatta", "Soeharto", "Joko Widodo"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Apa dasar negara Indonesia menurut UUD 1945?",
        'opsi' => ["Pancasila", "UUD 1945", "Bhinneka Tunggal Ika", "Proklamasi Kemerdekaan"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Semboyan negara Indonesia adalah?",
        'opsi' => ["Garuda Pancasila", "Merdeka", "Bhinneka Tunggal Ika", "Pancasila Abadi"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Pada tanggal berapakah UUD 1945 disahkan?",
        'opsi' => ["17 Agustus 1945", "18 Agustus 1945", "20 Agustus 1945", "16 Agustus 1945"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Apa warna latar belakang perisai pada lambang Garuda Pancasila?",
        'opsi' => ["Merah Putih", "Emas", "Hitam", "Hijau"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Sila kedua dalam Pancasila berbunyi?",
        'opsi' => [
            "Ketuhanan Yang Maha Esa",
            "Kemanusiaan yang adil dan beradab",
            "Persatuan Indonesia",
            "Keadilan sosial bagi seluruh rakyat Indonesia"
        ],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Lambang sila ketiga Pancasila adalah?",
        'opsi' => ["Bintang", "Rantai", "Pohon Beringin", "Kepala Banteng"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Isi sila kelima Pancasila adalah?",
        'opsi' => [
            "Keadilan sosial bagi seluruh rakyat Indonesia",
            "Ketuhanan Yang Maha Esa",
            "Persatuan Indonesia",
            "Kerakyatan yang dipimpin oleh hikmat kebijaksanaan"
        ],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Apa pengertian demokrasi?",
        'opsi' => ["Kekuatan di tangan rakyat", "Kekuasaan absolut", "Sistem kerajaan", "Satu orang berkuasa"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Apa tugas utama DPR (Dewan Perwakilan Rakyat)?",
        'opsi' => ["Membuat undang-undang", "Menegakkan hukum", "Menjaga keamanan", "Mengadili perkara"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Siapa pencipta lagu kebangsaan 'Indonesia Raya'?",
        'opsi' => ["WR Supratman", "Soekarno", "Mohammad Hatta", "Ki Hajar Dewantara"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Bentuk negara Indonesia adalah?",
        'opsi' => ["Monarki", "Kerajaan", "Republik", "Federasi"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Apa yang dimaksud dengan hak asasi manusia (HAM)?",
        'opsi' => [
            "Hak milik pribadi",
            "Hak yang melekat pada setiap manusia",
            "Hak pemerintah",
            "Hak warisan"
        ],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Contoh kewajiban seorang siswa di sekolah adalah?",
        'opsi' => ["Membaca buku", "Belajar dengan rajin", "Mendapat nilai bagus", "Bermain saat pelajaran"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Lambang negara Indonesia adalah?",
        'opsi' => ["Singa", "Macan", "Garuda", "Elang"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Isi sila keempat Pancasila adalah?",
        'opsi' => [
            "Kerakyatan yang dipimpin oleh hikmat kebijaksanaan dalam permusyawaratan/perwakilan",
            "Kemanusiaan yang adil",
            "Persatuan Indonesia",
            "Keadilan sosial"
        ],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Bentuk pemerintahan Indonesia adalah?",
        'opsi' => ["Presidensial", "Monarki", "Parlementer", "Federasi"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Siapa wakil presiden pertama Indonesia?",
        'opsi' => ["Soeharto", "Mohammad Hatta", "BJ Habibie", "Soekarno"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Apa tugas utama Mahkamah Agung?",
        'opsi' => ["Mengadili perkara", "Membuat hukum", "Mengatur pemilu", "Membentuk kabinet"],
        'jawaban' => 'a'
    ],
],
       'bahasa indonesia' => [
    [
        'pertanyaan' => "Antonim dari kata 'besar' adalah?",
        'opsi' => ["Panjang", "Tinggi", "Kecil", "Rendah"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Kalimat tanya biasanya diawali dengan kata?",
        'opsi' => ["Apa", "Dan", "Karena", "Namun"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Sinonim kata 'pandai' adalah?",
        'opsi' => ["Bodoh", "Pintar", "Lemah", "Malas"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Kalimat yang mengandung ajakan disebut?",
        'opsi' => ["Kalimat berita", "Kalimat perintah", "Kalimat tanya", "Kalimat ajakan"],
        'jawaban' => 'd'
    ],
    [
        'pertanyaan' => "Huruf kapital digunakan untuk menulis?",
        'opsi' => ["Nama orang", "Nama benda", "Kata kerja", "Kata sifat"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Kalimat perintah biasanya diakhiri dengan tanda?",
        'opsi' => ["Seru (!)", "Tanya (?)", "Titik dua (:)", "Titik (.)"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Kata 'melempar' termasuk jenis kata?",
        'opsi' => ["Kata benda", "Kata sifat", "Kata kerja", "Kata keterangan"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Kata tanya 'mengapa' digunakan untuk menanyakan?",
        'opsi' => ["Tempat", "Waktu", "Alasan", "Jumlah"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Contoh kata sifat adalah?",
        'opsi' => ["Berlari", "Meja", "Tinggi", "Lompat"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Kalimat 'Ibu memasak di dapur' termasuk kalimat?",
        'opsi' => ["Kalimat berita", "Kalimat tanya", "Kalimat perintah", "Kalimat ajakan"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Kata ulang terdapat pada kata?",
        'opsi' => ["Berjalan", "Matahari", "Lari-lari", "Minum"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Sinonim kata 'indah' adalah?",
        'opsi' => ["Cantik", "Buruk", "Gelap", "Lemah"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Antonim kata 'tinggi' adalah?",
        'opsi' => ["Panjang", "Pendek", "Besar", "Kurus"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Kalimat yang biasa digunakan dalam iklan adalah kalimat?",
        'opsi' => ["Naratif", "Deskriptif", "Ajakan", "Eksposisi"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Kata baku dari 'nggak' adalah?",
        'opsi' => ["Enggak", "Tidak", "Nggak", "Tak"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Paragraf yang baik harus memiliki?",
        'opsi' => ["Banyak huruf kapital", "Kalimat acak", "Ide pokok", "Kata sulit"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Kata 'berlari' termasuk kata?",
        'opsi' => ["Kata benda", "Kata kerja", "Kata sifat", "Kata keterangan"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Contoh kata sapaan adalah?",
        'opsi' => ["Pohon", "Kamu", "Lari", "Merah"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Kalimat 'Ayo kita menjaga kebersihan!' termasuk kalimat?",
        'opsi' => ["Kalimat perintah", "Kalimat tanya", "Kalimat berita", "Kalimat ajakan"],
        'jawaban' => 'd'
    ],
    [
        'pertanyaan' => "Kalimat efektif adalah kalimat yang?",
        'opsi' => [
            "Panjang dan berbelit",
            "Mengandung banyak kata sulit",
            "Tepat dan mudah dipahami",
            "Selalu memakai kata baku"
        ],
        'jawaban' => 'c'
    ],
],

'bahasa inggris' => [
    [
        'pertanyaan' => "Translate: 'I eat an apple'",
        'opsi' => ["Saya makan apel", "Saya minum apel", "Saya lihat apel", "Saya bawa apel"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "What is the opposite of 'hot'?",
        'opsi' => ["Cool", "Cold", "Warm", "Heat"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Translate: 'She is my sister'",
        'opsi' => [
            "Dia adik laki-laki saya",
            "Dia ibu saya",
            "Dia saudara perempuan saya",
            "Dia teman saya"
        ],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "What color is the sky?",
        'opsi' => ["Green", "Red", "Blue", "Yellow"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "What is the plural of 'child'?",
        'opsi' => ["Childs", "Children", "Childes", "Childer"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Translate: 'They go to school'",
        'opsi' => [
            "Mereka makan di sekolah",
            "Mereka pergi ke sekolah",
            "Kami pergi ke sekolah",
            "Dia pergi ke sekolah"
        ],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "What is the opposite of 'big'?",
        'opsi' => ["Huge", "Tall", "Small", "Long"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Translate: 'Good morning'",
        'opsi' => ["Selamat malam", "Selamat pagi", "Selamat siang", "Selamat tidur"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Which one is a fruit?",
        'opsi' => ["Carrot", "Potato", "Apple", "Cabbage"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "What is the English word for 'buku'?",
        'opsi' => ["Pen", "Paper", "Book", "Bag"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Translate: 'I have a cat'",
        'opsi' => [
            "Saya melihat kucing",
            "Saya punya kucing",
            "Saya memberi kucing",
            "Saya suka kucing"
        ],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "What is the opposite of 'happy'?",
        'opsi' => ["Angry", "Sad", "Glad", "Joyful"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Which one is a part of the body?",
        'opsi' => ["Chair", "Hand", "Book", "Table"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Translate: 'He is reading a book'",
        'opsi' => [
            "Dia menulis buku",
            "Dia membaca buku",
            "Dia membawa buku",
            "Dia membuka buku"
        ],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "What is the English for 'anjing'?",
        'opsi' => ["Cat", "Rat", "Dog", "Pig"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "How do you say 'terima kasih' in English?",
        'opsi' => ["Goodbye", "Sorry", "Thank you", "Please"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "What day comes after Monday?",
        'opsi' => ["Sunday", "Wednesday", "Tuesday", "Friday"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Translate: 'The sun is bright'",
        'opsi' => [
            "Matahari panas",
            "Matahari cerah",
            "Langit cerah",
            "Cahaya bulan terang"
        ],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "What is 'sekolah' in English?",
        'opsi' => ["Class", "Building", "School", "Study"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Which one is a means of transportation?",
        'opsi' => ["Train", "Tree", "Cloud", "House"],
        'jawaban' => 'a'
    ],
],
      'ipa' => [
    [
        'pertanyaan' => "Air membeku pada suhu?",
        'opsi' => ["0°C", "25°C", "50°C", "100°C"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Planet terbesar di tata surya adalah?",
        'opsi' => ["Mars", "Venus", "Saturnus", "Jupiter"],
        'jawaban' => 'd'
    ],
    [
        'pertanyaan' => "Bagian tumbuhan yang berfungsi menyerap air adalah?",
        'opsi' => ["Daun", "Akar", "Batang", "Bunga"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Makhluk hidup yang dapat membuat makanannya sendiri adalah?",
        'opsi' => ["Manusia", "Hewan", "Tumbuhan", "Jamur"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Alat pernapasan pada ikan adalah?",
        'opsi' => ["Hidung", "Insang", "Paru-paru", "Kulit"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Zat yang dibutuhkan tumbuhan untuk fotosintesis adalah?",
        'opsi' => ["Oksigen", "Karbon dioksida", "Nitrogen", "Helium"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Perubahan air menjadi uap disebut?",
        'opsi' => ["Membeku", "Menguap", "Mencair", "Mengkristal"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Gaya yang menyebabkan benda jatuh ke bumi disebut?",
        'opsi' => ["Gesek", "Magnet", "Gravitasi", "Listrik"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Hewan pemakan tumbuhan disebut?",
        'opsi' => ["Karnivora", "Omnivora", "Herbivora", "Insektivora"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Energi panas matahari disebut juga?",
        'opsi' => ["Geotermal", "Surya", "Listrik", "Angin"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Organ pernapasan manusia adalah?",
        'opsi' => ["Paru-paru", "Kulit", "Jantung", "Hati"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Benda yang dapat ditarik magnet disebut?",
        'opsi' => ["Kayu", "Kertas", "Besi", "Plastik"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Wujud air yang paling ringan adalah?",
        'opsi' => ["Padat", "Cair", "Gas", "Es"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Sumber energi utama di bumi adalah?",
        'opsi' => ["Air", "Angin", "Matahari", "Minyak"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Planet terdekat dengan matahari adalah?",
        'opsi' => ["Venus", "Mars", "Merkurius", "Bumi"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Bagian mata yang berfungsi menangkap cahaya adalah?",
        'opsi' => ["Kornea", "Retina", "Lensa", "Pupil"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Contoh sumber daya alam yang dapat diperbarui adalah?",
        'opsi' => ["Minyak bumi", "Gas alam", "Batu bara", "Hutan"],
        'jawaban' => 'd'
    ],
    [
        'pertanyaan' => "Zat cair yang tidak memiliki bentuk tetap disebut?",
        'opsi' => ["Gas", "Cairan", "Plasma", "Uap"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Alat ukur suhu adalah?",
        'opsi' => ["Barometer", "Termometer", "Higrometer", "Altimeter"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Contoh perubahan fisika adalah?",
        'opsi' => ["Es mencair", "Besi berkarat", "Kayu dibakar", "Roti basi"],
        'jawaban' => 'a'
    ],
],

'sbk' => [
    [
        'pertanyaan' => "Alat musik angklung berasal dari daerah?",
        'opsi' => ["Sumatra", "Jawa Barat", "Bali", "Sulawesi"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Warna primer terdiri dari?",
        'opsi' => ["Merah, Biru, Kuning", "Hijau, Ungu, Oranye", "Putih, Hitam, Abu", "Merah, Hijau, Biru"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Tari Piring berasal dari daerah?",
        'opsi' => ["Aceh", "Sumatra Barat", "Kalimantan", "Papua"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Salah satu contoh karya seni rupa dua dimensi adalah?",
        'opsi' => ["Patung", "Lukisan", "Gerabah", "Vas bunga"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Properti tari kipas digunakan dalam tari dari daerah?",
        'opsi' => ["Jawa Tengah", "Sumatra Selatan", "Sulawesi Selatan", "Kalimantan Timur"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Teknik membentuk tanah liat dengan cara memijit, menarik, dan menekan disebut?",
        'opsi' => ["Butsir", "Memahat", "Mengukir", "Melukis"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Contoh alat musik ritmis adalah?",
        'opsi' => ["Gitar", "Piano", "Drum", "Biola"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Lagu 'Ampar-Ampar Pisang' berasal dari daerah?",
        'opsi' => ["Jawa", "Bali", "Kalimantan Selatan", "Papua"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Apa fungsi utama motif batik?",
        'opsi' => ["Menghias pakaian", "Menutupi kerusakan", "Mengikat pakaian", "Mengeringkan keringat"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Ragam hias yang biasa digunakan pada ukiran kayu disebut?",
        'opsi' => ["Relief", "Kaligrafi", "Ornamen", "Tekstur"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Tari Saman berasal dari daerah?",
        'opsi' => ["Aceh", "Jawa Barat", "Sumatra Selatan", "Papua"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Alat musik sasando berasal dari daerah?",
        'opsi' => ["NTB", "Papua", "Nusa Tenggara Timur", "Bali"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Bahan utama untuk membuat patung adalah?",
        'opsi' => ["Kertas", "Tanah liat", "Air", "Kaca"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Contoh warna sekunder adalah?",
        'opsi' => ["Merah", "Kuning", "Hijau", "Biru"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Lagu daerah 'Manuk Dadali' berasal dari daerah?",
        'opsi' => ["Bali", "Jawa Barat", "Sumatra Utara", "Sulawesi Tengah"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Teknik menggambar dengan arang atau pensil disebut?",
        'opsi' => ["Lukisan", "Sketsa", "Kolase", "Montase"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Wayang kulit merupakan seni tradisional dari daerah?",
        'opsi' => ["Jawa", "Sumatra", "Papua", "Bali"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Contoh karya seni rupa tiga dimensi adalah?",
        'opsi' => ["Lukisan", "Foto", "Patung", "Poster"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Motif batik Mega Mendung berasal dari daerah?",
        'opsi' => ["Solo", "Yogyakarta", "Cirebon", "Pekalongan"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Salah satu fungsi seni musik adalah?",
        'opsi' => ["Memasak", "Menghitung", "Hiburan", "Olahraga"],
        'jawaban' => 'c'
    ],
],
       'pjok' => [
    [
        'pertanyaan' => "Lari jarak pendek yang sering dilombakan di tingkat SMP disebut? ",
        'opsi' => ["Maraton", "Sprint", "Jogging", "Lari estafet"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Cabang olahraga bola besar yang sering dimainkan di sekolah adalah?",
        'opsi' => ["Tenis Meja", "Bola Voli", "Badminton", "Catur"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Jumlah pemain dalam satu tim sepak bola adalah?",
        'opsi' => ["11", "9", "7", "5"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Alat utama yang digunakan saat melakukan senam lantai adalah?",
        'opsi' => ["Aspal", "Matras", "Rumput", "Keramik"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Tujuan utama lompat jauh adalah mencapai?",
        'opsi' => ["Tinggi maksimal", "Jarak terjauh", "Kecepatan lari", "Keseimbangan"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Manfaat utama pemanasan sebelum olahraga adalah?",
        'opsi' => ["Menambah berat badan", "Mendinginkan tubuh", "Menghindari cedera", "Menambah rasa lapar"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Gaya renang dada sering disebut juga gaya?",
        'opsi' => ["Katak", "Bebas", "Punggung", "Kupu-kupu"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Gerakan sit up bermanfaat untuk melatih otot?",
        'opsi' => ["Lengan", "Kaki", "Perut", "Paha"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Dalam permainan bola basket, cara yang benar untuk menggerakkan bola adalah?",
        'opsi' => ["Menendang", "Memukul", "Melempar dan menangkap", "Menyeret bola"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Jumlah gawang dalam permainan sepak bola adalah?",
        'opsi' => ["2", "1", "4", "3"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Latihan push up melatih otot utama pada bagian?",
        'opsi' => ["Perut", "Kaki", "Punggung", "Lengan"],
        'jawaban' => 'd'
    ],
    [
        'pertanyaan' => "Melempar lembing termasuk dalam cabang olahraga?",
        'opsi' => ["Lompat", "Lari", "Lempar", "Senam"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Permainan bulu tangkis minimal dimainkan oleh berapa orang?",
        'opsi' => ["1", "2", "3", "4"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Olahraga yang dilakukan di air disebut?",
        'opsi' => ["Renang", "Senam", "Bola voli", "Lari estafet"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Istilah lain untuk peregangan otot adalah?",
        'opsi' => ["Cooling down", "Stretching", "Breathing", "Jogging"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Alat utama yang digunakan dalam permainan tenis meja adalah?",
        'opsi' => ["Bola besar", "Bola kecil", "Bet", "Raket"],
        'jawaban' => 'd'
    ],
    [
        'pertanyaan' => "Olahraga bela diri dari Jepang yang sering dipelajari di SMP adalah?",
        'opsi' => ["Karate", "Silat", "Taekwondo", "Kungfu"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Pukulan awal dalam permainan voli disebut?",
        'opsi' => ["Smash", "Servis", "Blok", "Passing"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Jumlah babak dalam pertandingan futsal adalah?",
        'opsi' => ["2", "3", "4", "1"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Sikap tubuh yang benar saat berdiri tegak disebut?",
        'opsi' => ["Sikap hormat", "Sikap lilin", "Sikap pasang", "Sikap sempurna"],
        'jawaban' => 'd'
    ],
],
'agama' => [
    [
        'pertanyaan' => "Kitab suci umat Islam adalah?",
        'opsi' => ["Injil", "Weda", "Al-Qur'an", "Taurat"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Berapa jumlah Rukun Islam yang harus dilaksanakan?",
        'opsi' => ["3", "4", "5", "6"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Rukun Iman yang pertama adalah?",
        'opsi' => ["Iman kepada Kitab", "Iman kepada Allah", "Iman kepada Rasul", "Iman kepada Hari Akhir"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Siapakah nabi terakhir yang diutus Allah?",
        'opsi' => ["Nabi Musa", "Nabi Isa", "Nabi Nuh", "Nabi Muhammad"],
        'jawaban' => 'd'
    ],
    [
        'pertanyaan' => "Berapa jumlah shalat wajib dalam sehari semalam?",
        'opsi' => ["3 waktu", "4 waktu", "5 waktu", "6 waktu"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Bulan suci umat Islam yang wajib diisi dengan puasa adalah?",
        'opsi' => ["Dzulhijjah", "Rajab", "Ramadhan", "Syawal"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Hari raya umat Islam yang menandai berakhirnya puasa Ramadhan adalah?",
        'opsi' => ["Idul Adha", "Idul Fitri", "Maulid Nabi", "Isra Miraj"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Siapa ayah dari Nabi Ibrahim?",
        'opsi' => ["Azar", "Abu Lahab", "Imran", "Abdullah"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Shalat Subuh terdiri dari berapa rakaat?",
        'opsi' => ["4", "3", "2", "1"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Wudhu adalah bersuci dari?",
        'opsi' => ["Hadats kecil", "Hadats besar", "Najis", "Dosa"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Zakat fitrah biasanya dikeluarkan pada bulan?",
        'opsi' => ["Dzulhijjah", "Ramadhan", "Muharram", "Rabiul Awal"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Berapa jumlah Rukun Iman?",
        'opsi' => ["4", "5", "6", "7"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Umat Islam menghadap kiblat ke arah?",
        'opsi' => ["Madinah", "Ka'bah", "Gunung Sinai", "Langit"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Malaikat yang menyampaikan wahyu kepada Nabi Muhammad adalah?",
        'opsi' => ["Mikail", "Jibril", "Israfil", "Izrail"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Rukun Islam yang kedua adalah?",
        'opsi' => ["Zakat", "Shalat", "Puasa", "Naik Haji"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Hukum melaksanakan puasa Ramadhan adalah?",
        'opsi' => ["Sunnah", "Mubah", "Wajib", "Makruh"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Kitab Taurat diturunkan kepada Nabi?",
        'opsi' => ["Muhammad", "Musa", "Isa", "Ibrahim"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Perilaku jujur termasuk akhlak?",
        'opsi' => ["Tercela", "Terpuji", "Buruk", "Haram"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Sikap saling membantu teman yang kesusahan disebut?",
        'opsi' => ["Hasad", "Sombong", "Tolong-menolong", "Iri hati"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Bacaan 'Bismillah' diucapkan pada saat?",
        'opsi' => ["Selesai makan", "Sebelum belajar", "Saat tidur", "Memulai sesuatu"],
        'jawaban' => 'd'
    ],
],
'tik' => [
    [
        'pertanyaan' => "Perangkat yang digunakan untuk mengetik di komputer disebut?",
        'opsi' => ["Monitor", "Mouse", "Keyboard", "Scanner"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Singkatan dari TIK adalah?",
        'opsi' => ["Teknologi Informasi dan Komunikasi", "Teknologi Inovasi Komputer", "Teknik Ilmu Komputer", "Tidak Itu Kok"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Perangkat lunak komputer biasa disebut?",
        'opsi' => ["Hardware", "Mouse", "Software", "Flashdisk"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Contoh sistem operasi yang sering digunakan adalah?",
        'opsi' => ["Microsoft Word", "Windows", "Google Chrome", "Excel"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Alat yang digunakan untuk mencetak dokumen ke kertas disebut?",
        'opsi' => ["Scanner", "Monitor", "Printer", "Mouse"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Perangkat keras komputer disebut juga dengan istilah?",
        'opsi' => ["Software", "Hardware", "Dataware", "Brainware"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Alat untuk menggerakkan kursor di layar komputer adalah?",
        'opsi' => ["Keyboard", "Mouse", "Monitor", "Printer"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Contoh aplikasi pengolah kata adalah?",
        'opsi' => ["Photoshop", "PowerPoint", "Microsoft Word", "Excel"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Tempat menyimpan file di komputer disebut?",
        'opsi' => ["Folder", "Keyboard", "Taskbar", "Window"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Yang termasuk media penyimpanan data adalah?",
        'opsi' => ["Flashdisk", "Monitor", "Mouse", "Speaker"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Perangkat output komputer yang berfungsi menampilkan gambar adalah?",
        'opsi' => ["Keyboard", "Mouse", "Monitor", "Scanner"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Perintah untuk menghapus file di komputer adalah?",
        'opsi' => ["Delete", "Open", "New", "Copy"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Perangkat yang digunakan untuk memasukkan gambar atau dokumen ke komputer adalah?",
        'opsi' => ["Monitor", "Printer", "Scanner", "Speaker"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Shortcut keyboard untuk menyimpan file adalah?",
        'opsi' => ["Ctrl + P", "Ctrl + S", "Ctrl + C", "Ctrl + V"],
        'jawaban' => 'b'
    ],
    [
        'pertanyaan' => "Fungsi utama CPU (Central Processing Unit) adalah?",
        'opsi' => ["Mencetak dokumen", "Menghubungkan internet", "Mengolah data", "Menampilkan gambar"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Browser digunakan untuk?",
        'opsi' => ["Mendengarkan musik", "Mencetak dokumen", "Mengetik surat", "Menjelajah internet"],
        'jawaban' => 'd'
    ],
    [
        'pertanyaan' => "Contoh nama browser yang sering digunakan adalah?",
        'opsi' => ["Google Chrome", "Word", "Excel", "Notepad"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Fungsi tombol 'Enter' pada keyboard adalah?",
        'opsi' => ["Menghapus", "Menyalin", "Memulai perintah atau membuat baris baru", "Menyimpan file"],
        'jawaban' => 'c'
    ],
    [
        'pertanyaan' => "Istilah untuk orang yang mengoperasikan komputer adalah?",
        'opsi' => ["Brainware", "Software", "Hardware", "Driver"],
        'jawaban' => 'a'
    ],
    [
        'pertanyaan' => "Contoh media sosial yang banyak digunakan adalah?",
        'opsi' => ["Facebook", "Excel", "Word", "Linux"],
        'jawaban' => 'a'
    ],
],

    ];
}
}
