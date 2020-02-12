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
