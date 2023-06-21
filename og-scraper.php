<?php

class OpenGraphScraper {
    private $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function scrape() {
         // Récupérer le contenu HTML de l'URL
        $html = @file_get_contents($this->url);
         // Créer un tableau pour stocker les méta-données Open Graph
        $openGraphData = array();

        if ($html !== false) {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();

             // Récupérer toutes les balises meta du DOM
            $metaTags = $dom->getElementsByTagName('meta');

            // Parcourir les balises meta
            foreach ($metaTags as $tag) {
                 // Vérifier si le tag a un attribut property contenant "og:"
                if ($tag->hasAttribute('property') && strpos($tag->getAttribute('property'), 'og:') === 0) {
                    
                    // Récupérer le nom de la propriété Open Graph (enlever le préfixe "og:")
                    $property = str_replace('og:', '', $tag->getAttribute('property'));
                    // Récupérer la valeur de la propriété Open Graph
                    
                    $value = $tag->getAttribute('content');
                    
                    // Ajouter la propriété et sa valeur au tableau des méta-données Open Graph
                    $openGraphData[$property] = $value;
                }
            }
        } else {
            $openGraphData['error'] = 'Failed to retrieve HTML content';
        }

        if (empty($openGraphData)) {
            $openGraphData['error'] = 'No OpenGraph data found';
        }

        return $openGraphData;
    }
}

class OpenGraphApi {
    public function handleRequest() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        if (isset($_GET['url'])) {
            $url = $_GET['url'];

            if (!empty($url)) {
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $scraper = new OpenGraphScraper($url);
                    $openGraphMetadata = $scraper->scrape();

                    if (isset($openGraphMetadata['error'])) {
                        http_response_code(500);
                    } else {
                        http_response_code(200);
                    }

                    echo json_encode($openGraphMetadata);
                } else {
                    http_response_code(400);
                    echo json_encode(array('error' => 'Invalid URL'));
                }
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'URL parameter is missing'));
            }
        } else {
            http_response_code(400);
            echo json_encode(array('error' => 'URL parameter is missing'));
        }
    }
}

// Handle API request
$api = new OpenGraphApi();
$api->handleRequest();
