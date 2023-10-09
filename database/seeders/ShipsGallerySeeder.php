<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShipsGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared("
            INSERT INTO `ships_gallery` (`id`, `ship_id`, `title`, `url`, `ordering`) VALUES
            (null, 1, 'MSC Musica', 'https://img.pac.ru/cruise/ships_gallery/Musica/msc-musica-1.jpg', 1),
            (null, 1, 'MSC Musica', 'https://img.pac.ru/cruise/ships_gallery/Musica/msc-musica-2.jpg', 2),
            (null, 1, 'Центральный холл и ресепшн', 'https://img.pac.ru/cruise/ships_gallery/Musica/centralnyy-holl-i-resepshn-3.jpg', 3),
            (null, 1, 'Экскурсионное бюро', 'https://img.pac.ru/cruise/ships_gallery/Musica/ekskursionnoe-byuro-4.jpg', 4),
            (null, 1, 'Основной ресторан Le Maxim\'s', 'https://img.pac.ru/cruise/ships_gallery/Musica/osnovnoy-restoran-le-maxim-s-5.jpg', 5),
            (null, 2, 'MSC Orchestra', 'https://img.pac.ru/cruise/ships_gallery/Orchestra/msc-orchestra-1.jpg', 1),
            (null, 2, 'MSC Orchestra', 'https://img.pac.ru/cruise/ships_gallery/Orchestra/msc-orchestra-2.jpg', 2),
            (null, 2, 'Центральный холл и ресепшн', 'https://img.pac.ru/cruise/ships_gallery/Orchestra/centralnyy-holl-i-resepshn-3.jpg', 3),
            (null, 2, 'Ресепшн', 'https://img.pac.ru/cruise/ships_gallery/Orchestra/resepshn-4.jpg', 4),
            (null, 2, 'Экскурсионное бюро', 'https://img.pac.ru/cruise/ships_gallery/Orchestra/ekskursionnoe-byuro-5.jpg', 5),
            (null, 3, 'MSC Armonia', 'https://img.pac.ru/cruise/ships_gallery/Armonia/msc-armonia-1.jpg', 1),
            (null, 3, 'MSC Armonia', 'https://img.pac.ru/cruise/ships_gallery/Armonia/msc-armonia-2.jpg', 2),
            (null, 3, 'Ресепшн', 'https://img.pac.ru/cruise/ships_gallery/Armonia/resepshn-3.jpg', 3),
            (null, 3, 'Основной ресторан Marco Polo', 'https://img.pac.ru/cruise/ships_gallery/Armonia/osnovnoy-restoran-marco-polo-4.jpg', 4),
            (null, 3, 'Основной ресторан Marco Polo', 'https://img.pac.ru/cruise/ships_gallery/Armonia/osnovnoy-restoran-marco-polo-5.jpg', 5);
        ");
    }
}
