<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Romance', 'description' => 'Relata historias de amor entre personajes, explorando relaciones, emociones y conflictos románticos.'],
            ['name' => 'Ficción contemporánea', 'description' => 'Refleja la realidad y las preocupaciones de la sociedad actual, explorando temas modernos y actuales.'],
            ['name' => 'Fantasía épica', 'description' => 'Se caracteriza por mundos imaginarios, magia, criaturas fantásticas y conflictos épicos entre el bien y el mal.'],
            ['name' => 'Ciencia ficción', 'description' => 'Explora conceptos científicos y tecnológicos especulativos, posibles futuros y sociedades alternativas.'],
            ['name' => 'Novela histórica', 'description' => 'Ambientada en épocas pasadas, mezcla hechos históricos con elementos ficticios para contar una historia.'],
            ['name' => 'Misterio y suspense', 'description' => 'Se centra en la resolución de un enigma o crimen, manteniendo la intriga y el suspenso hasta el final.'],
            ['name' => 'Literatura clásica', 'description' => 'Comprende obras que han resistido el paso del tiempo y son consideradas fundamentales en la literatura mundial.'],
            ['name' => 'Terror', 'description' => 'Busca provocar miedo y tensión en el lector a través de situaciones sobrenaturales, monstruos, y elementos macabros.'],
            ['name' => 'Poesía', 'description' => 'Utiliza un lenguaje estilizado y simbólico para expresar emociones, pensamientos y experiencias de manera artística.'],
            ['name' => 'Biografías y memorias', 'description' => 'Narra la vida y experiencias de personas reales, ofreciendo insights sobre sus logros, desafíos y aprendizajes.'],
            ['name' => 'Libros de autoayuda', 'description' => 'Proporcionan consejos prácticos y herramientas para mejorar aspectos personales, profesionales o emocionales.'],
            ['name' => 'Ciencia popular', 'description' => 'Explica conceptos científicos de manera accesible y entretenida para el público general.'],
            ['name' => 'Libros de viajes', 'description' => 'Documenta experiencias de viaje, destinos, culturas y aventuras alrededor del mundo.'],
            ['name' => 'Libros de cocina y gastronomía', 'description' => 'Ofrecen recetas, técnicas culinarias, historias sobre alimentos y gastronomía de diversas culturas.'],
            ['name' => 'Libros de arte y fotografía', 'description' => 'Exploran diferentes formas de expresión artística, técnicas y movimientos artísticos, así como obras y fotógrafos destacados.'],
            ['name' => 'Filosofía', 'description' => 'Examina cuestiones fundamentales sobre la existencia, el conocimiento, la ética y la realidad.'],
            ['name' => 'Religión y espiritualidad', 'description' => 'Trata sobre creencias religiosas, prácticas espirituales, mitología y el significado de la vida.'],
            ['name' => 'Política y sociedad', 'description' => 'Analiza temas políticos, sociales, económicos y culturales, así como debates y movimientos sociales.'],
            ['name' => 'Libros infantiles', 'description' => 'Dirigidos a niños y niñas, abarcan una amplia gama de géneros y temas adaptados a diferentes edades.'],
            ['name' => 'Libros de negocios y emprendimiento', 'description' => 'Ofrecen consejos, estrategias y casos de éxito relacionados con el mundo empresarial y la gestión.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
