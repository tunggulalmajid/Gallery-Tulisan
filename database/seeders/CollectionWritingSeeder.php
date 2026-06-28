<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Writing;
use Illuminate\Database\Seeder;

class CollectionWritingSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            ['title' => 'Rindu yang Tak Pernah Pergi', 'slug' => 'rindu-yang-tak-pernah-pergi', 'description' => 'Kumpulan puisi tentang kerinduan yang menghuni sudut-sudut hati paling sunyi.'],
            ['title' => 'Hujan di Bulan Juni', 'slug' => 'hujan-di-bulan-juni', 'description' => 'Cerita dan puisi tentang hujan, kenangan basah, dan perasaan yang hanyut bersamanya.'],
            ['title' => 'Surat yang Tidak Pernah Terkirim', 'slug' => 'surat-yang-tidak-pernah-terkirim', 'description' => 'Kumpulan surat dalam bentuk puisi yang ditulis tapi tak pernah sampai ke tangan yang dituju.'],
            ['title' => 'Malam dan Bintang Semu', 'slug' => 'malam-dan-bintang-semu', 'description' => 'Puisi malam hari, tentang kesunyian, bintang, dan harapan yang menggantung di langit gelap.'],
            ['title' => 'Perempuan dan Musimnya', 'slug' => 'perempuan-dan-musimnya', 'description' => 'Puisi tentang perempuan, kekuatannya, lukanya, dan caranya bertahan melewati musim demi musim.'],
            ['title' => 'Tentang Pulang', 'slug' => 'tentang-pulang', 'description' => 'Refleksi tentang rumah, tempat asal, dan makna pulang yang sering lebih rumit dari yang dibayangkan.'],
            ['title' => 'Kopi dan Percakapan Pagi', 'slug' => 'kopi-dan-percakapan-pagi', 'description' => 'Prosa pendek tentang pagi hari, kopi, dan percakapan kecil yang justru bermakna besar.'],
            ['title' => 'Di Antara Kata yang Hilang', 'slug' => 'di-antara-kata-yang-hilang', 'description' => 'Puisi tentang hal-hal yang ingin diucapkan tapi selalu gagal menjadi kata-kata.'],
            ['title' => 'Laut dan Kepulangan', 'slug' => 'laut-dan-kepulangan', 'description' => 'Koleksi puisi tentang laut sebagai metafora kerinduan, kebebasan, dan perpisahan.'],
            ['title' => 'Musim Semi yang Terlambat', 'slug' => 'musim-semi-yang-terlambat', 'description' => 'Puisi tentang harapan yang datang terlambat, tapi tetap disambut dengan sepenuh hati.'],
            ['title' => 'Catatan dari Pinggir Jalan', 'slug' => 'catatan-dari-pinggir-jalan', 'description' => 'Prosa dan puisi pendek yang lahir dari pengamatan kehidupan sehari-hari di jalanan kota.'],
            ['title' => 'Doa yang Terlipat', 'slug' => 'doa-yang-terlipat', 'description' => 'Kumpulan puisi berbentuk doa, untuk diri sendiri, untuk orang-orang tercinta, untuk dunia.'],
            ['title' => 'Jarak dan Waktu', 'slug' => 'jarak-dan-waktu', 'description' => 'Puisi tentang jarak yang memisahkan dan waktu yang perlahan menyembuhkan.'],
            ['title' => 'Tubuh dan Ceritanya', 'slug' => 'tubuh-dan-ceritanya', 'description' => 'Eksplorasi puitis tentang tubuh, identitas, dan hubungan kita dengan diri sendiri yang paling dalam.'],
            ['title' => 'Sebelum Fajar Menyapa', 'slug' => 'sebelum-fajar-menyapa', 'description' => 'Puisi-puisi yang ditulis di dini hari, ketika dunia masih sunyi dan pikiran paling jujur.'],
        ];

        $templates = [
            [
                'type' => 'puisi',
                'titles' => ['Padamu Aku Kembali', 'Dalam Diam', 'Jejak yang Kau Tinggalkan', 'Sebuah Malam Tanpamu', 'Kata yang Tak Terucap'],
                'excerpts' => [
                    'Setiap malam aku kembali ke tempat yang sama, berharap jejakmu masih ada di sana.',
                    'Dalam diam aku menyimpan seribu kata yang tak pernah berani kuucapkan.',
                    'Kau pergi, tapi bayanganmu masih duduk di kursi yang sama setiap sore.',
                    'Malam ini terasa lebih panjang dari biasanya. Lebih sepi. Lebih dalam.',
                    'Ada kata yang ingin kusampaikan, tapi selalu gugur sebelum sampai ke bibirku.',
                ],
                'contents' => [
                    '<p>Setiap malam aku kembali ke tempat yang sama,<br>berharap jejakmu masih ada di sana.<br>Tapi angin sudah menyapu segalanya,<br>hanya kenangan yang bertahan.</p>',
                    '<p>Dalam diam aku menyimpan seribu kata<br>yang tak pernah berani kuucapkan.<br>Setiap kali kau menoleh,<br>semua kata itu bersembunyi di balik senyumku.</p>',
                    '<p>Kau pergi, tapi bayanganmu masih duduk<br>di kursi yang sama setiap sore.<br>Masih memegang cangkir teh yang sama,<br>hanya kau yang berbeda, kau tak ada.</p>',
                    '<p>Malam ini terasa lebih panjang dari biasanya.<br>Lebih sepi. Lebih dalam.<br>Seperti sumur tanpa dasar<br>yang terus mengisap setiap kenangan.</p>',
                    '<p>Ada kata yang ingin kusampaikan,<br>tapi selalu gugur sebelum sampai ke bibirku.<br>Mungkin kata-kata itu memang lebih indah<br>tinggal di dalam dada sebagai rahasia.</p>',
                ],
            ],
            [
                'type' => 'prosa',
                'titles' => ['Sore di Beranda', 'Pertemuan Terakhir', 'Kota yang Berubah', 'Memasak untuk Diri Sendiri', 'Jalan Pulang'],
                'excerpts' => [
                    'Sore itu berbeda. Langit jingga dan angin sepoi membawa aroma tanah basah.',
                    'Aku tidak tahu itu akan menjadi pertemuan terakhir kita.',
                    'Kota ini sudah berubah. Banyak yang pergi, banyak yang datang, tapi rasa ini tetap sama.',
                    'Memasak untuk diri sendiri ternyata punya kesedihan tersendiri.',
                    'Jalan pulang selalu terasa lebih panjang ketika kepala penuh dengan pertanyaan.',
                ],
                'contents' => [
                    '<p>Sore itu berbeda. Langit jingga dan angin sepoi membawa aroma tanah basah yang selalu kusukai sejak kecil. Aku duduk di beranda, secangkir teh di tangan, dan pikiran yang tidak mau diam.</p>',
                    '<p>Aku tidak tahu itu akan menjadi pertemuan terakhir kita. Kalau tahu, mungkin aku tidak akan terburu-buru. Mungkin aku akan duduk lebih lama dan mendengarkan setiap kata yang kau ucapkan.</p>',
                    '<p>Kota ini sudah berubah. Warung nasi di tikungan sudah digantikan minimarket. Pohon besar di alun-alun sudah ditebang. Tapi rasa ini tetap sama, rasa bahwa ini adalah rumahku.</p>',
                    '<p>Memasak untuk diri sendiri ternyata punya kesedihan tersendiri. Bukan karena lauknya kurang enak, tapi karena tidak ada yang perlu kuhidangkan dan tidak ada suara sendok selain milikku sendiri.</p>',
                    '<p>Jalan pulang selalu terasa lebih panjang ketika kepala penuh dengan pertanyaan. Di perempatan lampu merah menyala. Di sebelah kanan seorang anak berlari mengejar layang-layang. Dia tertawa. Pertanyaanku tiba-tiba terasa tidak sepenting tadi.</p>',
                ],
            ],
            [
                'type' => 'pantun',
                'titles' => ['Pantun Rindu', 'Pantun Pagi', 'Pantun Hujan', 'Pantun Ibu', 'Pantun Cinta'],
                'excerpts' => [
                    'Bunga melati harum semerbak, rindu ini tak terbendung lagi.',
                    'Embun pagi di ujung daun, semangat baru menyapa hari.',
                    'Hujan turun di hari Jumat, kenangan lama kembali hadir.',
                    'Kasih ibu sepanjang jalan, takkan habis meski dibagi.',
                    'Cinta bukan sekadar kata, tapi tindakan yang terasa nyata.',
                ],
                'contents' => [
                    '<p><em>Bunga melati harum semerbak,<br>ditanam di halaman rumah nan teduh.<br>Rindu ini tak terbendung lagi,<br>padamu hatiku selalu tertambat.</em></p>',
                    '<p><em>Embun pagi di ujung daun,<br>jatuh pelan ke tanah basah.<br>Semangat baru menyapa hari,<br>langkah kukuh menuju berkah.</em></p>',
                    '<p><em>Hujan turun di hari Jumat,<br>membasahi jalan yang berdebu.<br>Kenangan lama kembali hadir,<br>membawa serta wajahmu yang rindu.</em></p>',
                    '<p><em>Kasih ibu sepanjang jalan,<br>takkan habis meski dibagi seribu.<br>Air susu dibalas air tuba,<br>durhaka anak menjadi cerita pilu.</em></p>',
                    '<p><em>Cinta bukan sekadar kata,<br>tapi tindakan yang terasa nyata.<br>Bukan janji di bibir sahaja,<br>tapi hadir di saat yang susah.</em></p>',
                ],
            ],
        ];

        foreach ($collections as $index => $collData) {
            $collection = Collection::firstOrCreate(
                ['slug' => $collData['slug']],
                [
                    'title'        => $collData['title'],
                    'description'  => $collData['description'],
                    'is_published' => true,
                    'sort_order'   => $index + 3,
                ]
            );

            $template = $templates[$index % count($templates)];

            foreach (range(0, 4) as $i) {
                $slug = \Illuminate\Support\Str::slug($template['titles'][$i]) . '-' . ($index + 1);
                Writing::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'collection_id' => $collection->id,
                        'title'         => $template['titles'][$i],
                        'type'          => $template['type'],
                        'excerpt'       => $template['excerpts'][$i],
                        'content'       => $template['contents'][$i],
                        'is_published'  => true,
                        'sort_order'    => $i + 1,
                        'written_at'    => now()->subDays(rand(30, 730))->toDateString(),
                    ]
                );
            }
        }
    }
}