<?php

namespace Database\Seeders;

use App\Models\AuthorProfile;
use App\Models\Collection;
use App\Models\User;
use App\Models\Writing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@sucipuisi.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Author profile
        AuthorProfile::firstOrCreate(
            ['name' => 'Suci'],
            [
                'tagline'   => 'Menulis adalah cara saya bernafas.',
                'bio'       => 'Seorang penulis yang jatuh cinta pada kata-kata. Setiap tulisan adalah sepotong jiwa yang dituangkan di atas kertas.',
                'instagram' => 'sucipuisi',
                'email'     => 'suci@sucipuisi.com',
            ]
        );

        // Sample collections
        $collection1 = Collection::firstOrCreate(
            ['slug' => 'rindu-yang-tertinggal'],
            [
                'title'        => 'Rindu yang Tertinggal',
                'description'  => 'Kumpulan puisi tentang kerinduan, jarak, dan kenangan yang tak pernah benar-benar pergi.',
                'is_published' => true,
                'sort_order'   => 1,
            ]
        );

        $collection2 = Collection::firstOrCreate(
            ['slug' => 'hujan-dan-cerita'],
            [
                'title'        => 'Hujan dan Cerita',
                'description'  => 'Cerita pendek dan prosa tentang hujan, waktu, dan pertemuan yang tak terduga.',
                'is_published' => true,
                'sort_order'   => 2,
            ]
        );

        // Sample writings for collection 1
        Writing::firstOrCreate(
            ['slug' => 'surat-untuk-waktu'],
            [
                'collection_id' => $collection1->id,
                'title'         => 'Surat untuk Waktu',
                'type'          => 'puisi',
                'excerpt'       => 'Kepada waktu yang selalu berlari, izinkan aku berhenti sejenak...',
                'content'       => '<p>Kepada waktu yang selalu berlari,<br>izinkan aku berhenti sejenak</p><p>di antara detik yang jatuh satu per satu<br>aku kehilangan jejakmu, juga jejakku sendiri</p><p>Surat ini mungkin tidak akan sampai<br>tapi setidaknya aku sudah mencoba<br>memanggil namamu dengan kata-kata<br>yang selama ini kusimpan dalam diam</p>',
                'is_published'  => true,
                'sort_order'    => 1,
                'written_at'    => '2024-01-15',
            ]
        );

        Writing::firstOrCreate(
            ['slug' => 'rumah-di-antara-kata'],
            [
                'collection_id' => $collection1->id,
                'title'         => 'Rumah di Antara Kata',
                'type'          => 'puisi',
                'excerpt'       => 'Kubangun rumah dari kata-kata yang kau tinggalkan...',
                'content'       => '<p>Kubangun rumah dari kata-kata yang kau tinggalkan<br>dindingnya dari janji-janji yang belum sempat terucap<br>atapnya dari mimpi yang kita rajut bersama</p><p>Di sini aku masih tinggal<br>menunggu kau pulang<br>ke rumah yang kita sebut rindu</p>',
                'is_published'  => true,
                'sort_order'    => 2,
                'written_at'    => '2024-02-20',
            ]
        );

        Writing::firstOrCreate(
            ['slug' => 'pantun-musim-semi'],
            [
                'collection_id' => $collection1->id,
                'title'         => 'Pantun Musim Semi',
                'type'          => 'pantun',
                'excerpt'       => 'Bunga mekar di musim semi, indah warnanya menyapa pagi...',
                'content'       => '<p>Bunga mekar di musim semi,<br>indah warnanya menyapa pagi.<br>Hatiku mekar bertemu kembali,<br>senyummu hangatkan hari ini.</p><p>Pergi ke pasar membeli rempah,<br>pulang membawa harum bunga.<br>Cinta ini tak pernah lempah,<br>makin dalam makin terjaga.</p>',
                'is_published'  => true,
                'sort_order'    => 3,
                'written_at'    => '2024-03-10',
            ]
        );

        // Sample writings for collection 2
        Writing::firstOrCreate(
            ['slug' => 'ketika-hujan-bercerita'],
            [
                'collection_id' => $collection2->id,
                'title'         => 'Ketika Hujan Bercerita',
                'type'          => 'cerita',
                'excerpt'       => 'Ada yang berbeda dari hujan malam ini. Bukan rintiknya, bukan suaranya...',
                'content'       => '<p>Ada yang berbeda dari hujan malam ini. Bukan rintiknya, bukan suaranya. Tapi cara dia jatuh, seolah tahu bahwa ada seseorang di balik jendela yang sedang menunggunya.</p><p>Aku duduk di kursi rotan tua, secangkir teh di tangan, dan mata yang tak bisa berpaling dari tetes-tetes itu. Mungkin hujan memang selalu punya cerita. Dan malam ini, giliran aku yang mendengarkannya.</p><p>Dia berbisik tentang waktu. Tentang semua orang yang pernah berdiri di tempat yang sama, mungkin dengan perasaan yang sama, menatap langit yang sama. Dan entah kenapa, itu membuatku merasa tidak terlalu sendirian.</p>',
                'is_published'  => true,
                'sort_order'    => 1,
                'written_at'    => '2024-04-05',
            ]
        );
    }
}
