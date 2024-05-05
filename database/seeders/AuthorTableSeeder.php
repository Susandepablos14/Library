<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            [
                'name' => 'Ernest Hemingway',
                'biography' => 'Ernest Hemingway fue un novelista, cuentista y periodista estadounidense, conocido por su estilo económico y sobrio.',
                'birthdate' => '1899-07-21',
                'country_id' => 1, // Estados Unidos
            ],
            [
                'name' => 'Leo Tolstoy',
                'biography' => 'Lev Tolstói fue un escritor ruso considerado uno de los más grandes autores de todos los tiempos.',
                'birthdate' => '1828-09-09',
                'country_id' => 24, // Rusia
            ],
            [
                'name' => 'Charles Dickens',
                'biography' => 'Charles Dickens fue un escritor y crítico social inglés. Creó algunos de los personajes ficticios más conocidos del mundo.',
                'birthdate' => '1812-02-07',
                'country_id' => 12, // Reino Unido
            ],
            [
                'name' => 'Jorge Luis Borges',
                'biography' => 'Jorge Luis Borges fue un escritor argentino, ensayista, poeta y traductor, y una figura clave en la literatura en español y universal.',
                'birthdate' => '1899-08-24',
                'country_id' => 5, // Argentina
            ],
            [
                'name' => 'Mark Twain',
                'biography' => 'Mark Twain fue un escritor, humorista, empresario, editor y conferenciante estadounidense. Es mejor conocido por sus novelas "Las aventuras de Tom Sawyer" y "Las aventuras de Huckleberry Finn".',
                'birthdate' => '1835-11-30',
                'country_id' => 1, // Estados Unidos
            ],
            [
                'name' => 'Virginia Woolf',
                'biography' => 'Virginia Woolf fue una escritora inglesa, considerada una de las autoras más importantes del siglo XX y una pionera en el uso del flujo de conciencia como dispositivo narrativo.',
                'birthdate' => '1882-01-25',
                'country_id' => 12, // Reino Unido
            ],
            [
                'name' => 'Haruki Murakami',
                'biography' => 'Haruki Murakami es un escritor japonés. Sus libros y cuentos han sido bestsellers en Japón e internacionalmente, siendo traducidos a 50 idiomas y vendiendo millones de copias fuera de su país natal.',
                'birthdate' => '1949-01-12',
                'country_id' => 29, // Japón
            ],
            [
                'name' => 'Gabriel García Márquez',
                'biography' => 'Gabriel García Márquez fue un novelista, cuentista, guionista y periodista colombiano, conocido cariñosamente como Gabo en toda América Latina.',
                'birthdate' => '1927-03-06',
                'country_id' => 8, // Colombia
            ],
            [
                'name' => 'Pablo Neruda',
                'biography' => 'Pablo Neruda fue un poeta chileno, considerado uno de los más grandes poetas de la lengua española del siglo XX.',
                'birthdate' => '1904-07-12',
                'country_id' => 6, // Chile
            ],
            [
                'name' => 'Agatha Christie',
                'biography' => 'Agatha Christie fue una escritora inglesa especializada en novelas de misterio y detectives. Es conocida como la "Reina del Crimen" por sus numerosas historias de detectives.',
                'birthdate' => '1890-09-15',
                'country_id' => 12, // Reino Unido
            ],
            [
                'name' => 'Miguel de Cervantes',
                'biography' => 'Miguel de Cervantes fue un escritor español, conocido principalmente por su obra maestra "Don Quijote de la Mancha", considerada una de las mejores novelas de la literatura universal.',
                'birthdate' => '1547-09-29',
                'country_id' => 11, // España
            ],
            [
                'name' => 'Emily Dickinson',
                'biography' => 'Emily Dickinson fue una poeta estadounidense, considerada una de las más importantes figuras de la poesía estadounidense del siglo XIX. Su obra se caracteriza por su estilo conciso y su exploración de temas como la muerte y la naturaleza.',
                'birthdate' => '1830-12-10',
                'country_id' => 1, // Estados Unidos
            ],
            [
                'name' => 'Friedrich Nietzsche',
                'biography' => 'Friedrich Nietzsche fue un filósofo, poeta, músico y filólogo alemán, conocido por sus obras que abordan temas como la moralidad, la religión, el poder y la cultura. Entre sus obras más destacadas se encuentran "Así habló Zaratustra" y "El Anticristo".',
                'birthdate' => '1844-10-15',
                'country_id' => 13, // Alemania
            ],
            [
                'name' => 'Chimamanda Ngozi Adichie',
                'biography' => 'Chimamanda Ngozi Adichie es una escritora nigeriana conocida por su estilo literario distintivo y su enfoque en temas como la identidad, el feminismo y la política nigeriana. Algunas de sus obras más conocidas incluyen "Hibisco morado" (Purple Hibiscus), "Medio sol amarillo" (Half of a Yellow Sun) y "Americanah". Adichie ha recibido numerosos premios y reconocimientos por su trabajo, y es considerada una de las voces más influyentes en la literatura contemporánea.',
                'birthdate' => '1977-09-15',
                'country_id' => 34, // Nigeria
            ],
            [
                'name' => 'William Shakespeare',
                'biography' => 'William Shakespeare fue un dramaturgo, poeta y actor inglés, ampliamente considerado como el escritor más grande en el idioma inglés y uno de los más grandes de la literatura mundial.',
                'birthdate' => '1564-04-23',
                'country_id' => 12, // Reino Unido
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
