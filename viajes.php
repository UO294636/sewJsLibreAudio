<?php
    class Carrusel{

        private $capital;
        private $pais;

        public function __construct($capital, $pais){
            $this->capital = $capital;
            $this->pais = $pais;
        }  

        public function obtenerImagenes(){
            $tag = $this->pais;
            $perPage = 10;

            // Fotos públicas recientes
            $url = 'https://api.flickr.com/services/feeds/photos_public.gne?';
            $url.= '&tags='.$tag;
            $url.= '&per_page='.$perPage;
            $url.= '&format=json';
            $url.= '&nojsoncallback=1';

            $respuesta = file_get_contents($url);
            $json = json_decode($respuesta);

            if($json==null) {
                echo "<h3>Error en el archivo JSON recibido</h3>";
            }

            //Pintamos las imagenes
            echo "<section role=carrusel>";
            echo "<h2>Carrusel de Imágenes</h2>";

            for($i=0;$i<$perPage;$i++) {
            
                $titulo = "Imagen del carrusel ".($i+1);
                $URLfoto = $json->items[$i]->media->m;

                print "<img src='".$URLfoto."' alt='".$titulo."'/>";
            }
            //Creo los botones con los que se va a pasar de imagen.
            echo "<button data-action='next'> > </button>";
            echo "<button data-action='prev'> < </button>";
            echo "</section>";
        }
    }
    
    class Moneda {

private $monedaLocal;
private $monedaCambio;

public function __construct($monedaLocal, $monedaCambio){
    $this->monedaLocal = $monedaLocal;
    $this->monedaCambio = $monedaCambio;
}
public function obtenerCambio(){
    $api_key = 'aaf6680166311f89c8f40de1';

    $url = "https://v6.exchangerate-api.com/v6/".$api_key."/latest/".$this->monedaCambio;

    $response = file_get_contents($url);

    if ($response) {
        $data = json_decode($response, true);
        
        if (isset($data['conversion_rates']['HUF'])) {
            echo "<h3>Cambio de moneda</h3>";
            $exchange_rate = $data['conversion_rates']['HUF'];
            echo "<p>1 ".$this->monedaCambio." equivale a ".$exchange_rate." ".$this->monedaLocal;
        } else {
            echo "<h2>Hubo un error al transcribir el valor de la tasa.</h2>";
        }
    } else {
        echo "<h2>Error al obtener los datos desde la API.</h2>";
    }
}
}
?>



<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <title>F1 DESKTOP Viajes</title>
    <link rel ="icon" href="multimedia/imagenes/favicon.ico" />
    <meta name = "author" content = "Sergio García Santamarina" />
    <meta name = "description" content = "Documento para utilizar en otros módulos de la asignatura" />
    <meta charset="UTF-8" />
    <meta name = "keywords" content = "por cambiar" /> <!--CAMBIAR-->
    <meta name = "viewport" content = "width= device-width, initial-scale=1.0" />
     <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="estilo/layout.css" />
    <link rel="stylesheet" type="text/css" href="https://api.mapbox.com/mapbox-gl-js/v3.0.0/mapbox-gl.css">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.0/mapbox-gl.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@mapbox/togeojson"></script>
    <script src="js/viajes.js"></script>
</head>

<body>
    <!-- Datos con el contenidos que aparece en el navegador -->
    <header>
    <h1>F1 Desktop</h1>
    <nav>
        <a href="index.html">Inicio</a> 
        <a href="piloto.html">Piloto</a> 
        <a href="noticias.html">Noticias</a> 
        <a href="calendario.html">Calendario</a> 
        <a href="meteorología.html">Meteorología</a> 
        <a href="circuito.html">Circuito</a> 
        <a href="viajes.php">Viajes</a> 
        <a href="juegos.html">Juegos</a> 
       </nav>
    </header>
    <p>Estás en: <strong><a href="index.html">Inicio</a> > > Viajes</strong></p>
    <aside>
    <?php
    $moneda = new Moneda("HUF","EUR");
    $moneda->obtenerCambio();
    ?>
    </aside>
    <section>
        <h2>Viajes</h2>
        <button>Generar mapa estático</button>
        <button>Generar mapa dinámico</button>
        <div>
        </div>
    </section>
    <?php
    $carrusel = new Carrusel("Budapest","Hungria");
    $carrusel->obtenerImagenes();
    ?>

    <script>
        var viajes = new Viajes();
    </script>
    
    
</body>
</html>