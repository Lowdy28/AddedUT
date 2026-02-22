<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noticia;
use App\Models\Usuario;
use Carbon\Carbon;

class NoticiaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Usuario::first();
        $adminId = $admin ? $admin->id_usuario : 1;

        $noticias = [
            [
                'titulo' => 'Campaña de Vacunación en la UTTEC',
                'contenido' => "La Universidad Tecnológica de Tecámac invita a la comunidad universitaria a participar en la Campaña de Vacunación.\n\nSe aplicarán las siguientes vacunas:\n- Sarampión-Rubéola\n- COVID-19\n- Influenza\n\nFecha: Lunes 23 y martes 24 de febrero.\nHorario: 09:00 a 15:00 horas.\nLugar: Bahía de la UTTEC.\n\nRequisitos:\n- Uso de cubrebocas\n- Identificación oficial\n- Número de Seguridad Social (si estás afiliado al IMSS)\n- Cartilla de Vacunación y/o Carnet\n- CURP\n\nNota: El horario permanecerá vigente hasta agotar la disponibilidad de dosis.",
                'categoria' => 'Salud',
                'imagen' => 'noticias/vacunacion.jpg',
                'publicada' => true,
                'publicado_por' => $adminId,
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'titulo' => 'Tequios en la UTTEC: cuando la comunidad se une, el cambio se nota ✨🤝',
                'contenido' => "En la UTTEC vivimos el espíritu de tequios: ese trabajo comunitario que nace del corazón y se hace en equipo para mejorar lo que es de todos. 🦉🌿\n\nCon la participación de la comunidad universitaria sumamos manos, energía y compromiso para cuidar y dignificar nuestros espacios deportivos, fortaleciendo la convivencia y el orgullo de pertenecer. 🧹🏫\n\n¡Gracias, Lechuzos, por demostrar que unidos llegamos más lejos! 🦉🚀\n\n#ElPoderDeServir #Tequios #OrgulloUTTEC #Lechuzos #TrabajoEnEquipo",
                'categoria' => 'Comunidad',
                'imagen' => 'noticias/tequios.jpg',
                'publicada' => true,
                'publicado_por' => $adminId,
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'titulo' => 'Convocatoria "Corre en Pareja UTTEC"',
                'contenido' => "¡Ven y corre con el amor, la amistad y el espíritu universitario!\n\nFecha: viernes 13 de febrero de 2026.\nHorario: 08:30 horas.\nLugar: Explanada Cívica de la Universidad.\n\n¿Quiénes pueden participar?\nEstudiantes, docentes y personal administrativo de la UT Tecámac. La dinámica es en parejas, así que elige a tu compañero: tu mejor amigo, tu pareja o alguien de tu clase.\n\nModalidad:\n- Enfoque divertido y recreativo con pequeños retos.\n- ¡Pueden participar con disfraces o atuendos alusivos al 14 de febrero!\n\nInscripciones abiertas en el Departamento de Actividades Culturales y Deportivas.",
                'categoria' => 'Deportes',
                'imagen' => 'noticias/pareja.jpg',
                'publicada' => true,
                'publicado_por' => $adminId,
                'created_at' => Carbon::now(),
            ],
        ];

        foreach ($noticias as $noticia) {
            Noticia::create($noticia);
        }
    }
}