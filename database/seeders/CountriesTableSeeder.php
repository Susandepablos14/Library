<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['name' => 'Estados Unidos', 'nationality' => 'Americano/a'],
            ['name' => 'Canadá', 'nationality' => 'Canadiense'],
            ['name' => 'México', 'nationality' => 'Mexicano/a'],
            ['name' => 'Brasil', 'nationality' => 'Brasileño/a'],
            ['name' => 'Argentina', 'nationality' => 'Argentino/a'],
            ['name' => 'Chile', 'nationality' => 'Chileno/a'],
            ['name' => 'Perú', 'nationality' => 'Peruano/a'],
            ['name' => 'Colombia', 'nationality' => 'Colombiano/a'],
            ['name' => 'Venezuela', 'nationality' => 'Venezolano/a'],
            ['name' => 'Ecuador', 'nationality' => 'Ecuatoriano/a'],
            ['name' => 'España', 'nationality' => 'Español/a'],
            ['name' => 'Francia', 'nationality' => 'Francés/a'],
            ['name' => 'Alemania', 'nationality' => 'Alemán/a'],
            ['name' => 'Reino Unido', 'nationality' => 'Británico/a'],
            ['name' => 'Italia', 'nationality' => 'Italiano/a'],
            ['name' => 'Portugal', 'nationality' => 'Portugués/a'],
            ['name' => 'Países Bajos', 'nationality' => 'Neerlandés/a'],
            ['name' => 'Bélgica', 'nationality' => 'Belga'],
            ['name' => 'Suiza', 'nationality' => 'Suizo/a'],
            ['name' => 'Suecia', 'nationality' => 'Sueco/a'],
            ['name' => 'Noruega', 'nationality' => 'Noruego/a'],
            ['name' => 'Dinamarca', 'nationality' => 'Danés/a'],
            ['name' => 'Finlandia', 'nationality' => 'Finlandés/a'],
            ['name' => 'Rusia', 'nationality' => 'Ruso/a'],
            ['name' => 'China', 'nationality' => 'Chino/a'],
            ['name' => 'Japón', 'nationality' => 'Japonés/a'],
            ['name' => 'Corea del Sur', 'nationality' => 'Surcoreano/a'],
            ['name' => 'India', 'nationality' => 'Indio/a'],
            ['name' => 'Australia', 'nationality' => 'Australiano/a'],
            ['name' => 'Nueva Zelanda', 'nationality' => 'Neozelandés/a'],
            ['name' => 'Sudáfrica', 'nationality' => 'Sudafricano/a'],
            ['name' => 'Nigeria', 'nationality' => 'Nigeriano/a'],
            ['name' => 'Egipto', 'nationality' => 'Egipcio/a'],
            ['name' => 'Kenia', 'nationality' => 'Keniano/a'],
            ['name' => 'Ghana', 'nationality' => 'Ghanés/a'],
            ['name' => 'Marruecos', 'nationality' => 'Marroquí'],
            ['name' => 'Túnez', 'nationality' => 'Tunecino/a'],
            ['name' => 'Argelia', 'nationality' => 'Argelino/a'],
            ['name' => 'Turquía', 'nationality' => 'Turco/a'],
            ['name' => 'Irán', 'nationality' => 'Iraní'],
            ['name' => 'Arabia Saudita', 'nationality' => 'Saudí'],
            ['name' => 'Emiratos Árabes Unidos', 'nationality' => 'Emiratí'],
            ['name' => 'Israel', 'nationality' => 'Israelí'],
            ['name' => 'Corea del Norte', 'nationality' => 'Norcoreano/a'],
            ['name' => 'Indonesia', 'nationality' => 'Indonesio/a'],
            ['name' => 'Malasia', 'nationality' => 'Malasio/a'],
            ['name' => 'Singapur', 'nationality' => 'Singapurés/a'],
            ['name' => 'Filipinas', 'nationality' => 'Filipino/a'],
            ['name' => 'Bangladés', 'nationality' => 'Bangladesí'],
        ];
        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
