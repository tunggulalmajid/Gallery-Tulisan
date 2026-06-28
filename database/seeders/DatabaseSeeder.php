<?php

namespace Database\Seeders;

use App\Models\AuthorProfile;
use App\Models\Collection;
use App\Models\HeroSection;
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

        // Hero section
        HeroSection::firstOrCreate(
            ['id' => 1],
            [
                'heading'    => 'Setiap Kata adalah Jejak Rasa',
                'subheading' => 'Karya pribadi Suci',
                'body'       => 'Kumpulan puisi, pantun, dan cerita yang lahir dari ruang paling sunyi — tempat di mana kata-kata tumbuh menjadi perasaan.',
                'cta_label'  => 'Jelajahi Karya',
                'cta_url'    => '/koleksi',
                'is_active'  => true,
            ]
        );

        // Sample collection
        $collection1 = Collection::firstOrCreate(
            ['slug' => 'rindu-yang-tertinggal'],
            [
                'title'        => 'Rindu yang Tertinggal',
                'description'  => 'Kumpulan puisi tentang kerinduan, jarak, dan kenangan yang tak pernah benar-benar pergi.',
                'is_published' => true,
                'sort_order'   => 1,
            ]
        );

        // Sample writing
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
    }
}
