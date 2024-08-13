<?php
// Lista de URLs de los enlaces a simular clic
$urls = array(
    'https://subirpartidos.claudio168.com/subirpremierleaguefixtures',
    'https://subirpartidos.claudio168.com/subirLaligafixtures',
    'https://subirpartidos.claudio168.com/subirElCalcioFixtures',
    'https://subirpartidos.claudio168.com/subirLaBundesligaFixtures',
    'https://subirpartidos.claudio168.com/subirPrimeiraLigaFixture',
    'https://subirpartidos.claudio168.com/subirLigue1fixture',
    'https://subirpartidos.claudio168.com/subirLigaColombia',
    'https://subirpartidos.claudio168.com/subirLigaEredivisie',
    'https://subirpartidos.claudio168.com/subirLigaArgentina',
    'https://subirpartidos.claudio168.com/subirLigaBrasil',
    'https://subirpartidos.claudio168.com/subirLigaChile',
    'https://subirpartidos.claudio168.com/subirLigaMexico',

    // Agrega los demás enlaces aquí
);

// Recorre la lista de URLs y simula clics
foreach ($urls as $url) {
    try {
        // Realizar la solicitud GET
        $response = file_get_contents($url);

        // Verificar la respuesta
        if ($response !== false) {
            echo "Clic en el enlace ($url) realizado con éxito<br>";
        } else {
            echo "Error al realizar el clic en el enlace ($url)<br>";
        }
    } catch (Exception $e) {
        echo "Error al acceder a la URL ($url): " . $e->getMessage() . "<br>";
    }

    // Esperar 1 minuto antes de continuar al siguiente enlace
    sleep(60);
}
