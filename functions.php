<?php

// J'arrête les scripts ...
// die('Je suis le fichier functions.php');

register_nav_menus([
    'main'    => 'Mon menu principal',
    'footer'    => 'Menu dans le footer',
]);


// Style et JS


// add_action('wp_enqueue_scripts', function(){

// });

// Hook permettant de charger les styles et script JS
// le Hook s'appelle wp_enqueue_scripts et la fonction al_setup_script est une fonction de callback
add_action('wp_enqueue_scripts', 'al_setup_script');

function al_setup_script()
{
    // premier paramètre une clé unique par style
    // deuxième paramètre l'adresse du fichier de style style.css
    // troisième paramètre les dépendances
    // quatrième parmètre la version de vos style
    wp_enqueue_style('book-style', get_stylesheet_uri(), [], '1.0.0');

    // Charge le fichier uniquement dans la catégorie Data
    if (is_category('Data')) {
        wp_enqueue_style('book-data', get_template_directory_uri() . '/assets/css/data.css');
     }
}

// Hook excerpt_more
add_filter('excerpt_more', 'al_read_more');

function al_read_more($more)
{
    global $post; // le post dans la boucle objet

//    var_dump($post);  // objet dans la boucle de WP

    return '<p><a href="' . get_permalink($post->ID) . '" >lire la suite</a></p>';
}