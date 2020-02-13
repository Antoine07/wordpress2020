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

// agit sur l'extrait uniquement
// attention la fonction de callback récupère l'extrait
// il faut penser à le retourner
add_filter('the_excerpt', function($excerpt){

    $copyRight = "Copyright";

    return sprintf("%s <p>%s</p>", $excerpt, $copyRight) ;
});


// fonction de callback appelée par le hook
function al_add_svg( $excerpt ) {
    
    // on teste si on est dans la catégorie love
    if(is_category('love'))

        return $excerpt. '<svg xmlns="http://www.w3.org/2000/svg" 
        width="100%" 
        height="100" 
        viewBox="0 0 100 100" 
        preserveAspectRatio="none"><path d="M0 0 L50 25 L100 0 Z" />';

    // ailleurs
    return $excerpt;
}

/**
 * Custom post type event
 */

add_action('init', 'al_create_post_type' );

function al_create_post_type() {

  // définit le custom (post_type dans la table wp_posts MySQL)
  register_post_type( 'event',
   [
       // les labels permettent d'afficher des informations dans le CMS
      'labels' => [
        'name' => 'Événement',
        'singular_name' => 'Événement'
        ],

      'public' => true, // pour qu'il s'affiche dans l'administration
      // le support permet de définir les attributs du contenu 
      // ici nous il aura un titre, un éditeur et des images en avant
      'supports' => [
        'title',
        'editor',
        'thumbnail'
      ],
      'has_archive' => true // visible dans les archives
   ]
  );
}

// afficher les customs posts types en page d'accueil

add_filter( 'pre_get_posts', 'al_get_posts' );

function al_get_posts( $query ) {

// attention $query est globale donc pour éviter les effets de bord
// on précise que la query est bien la query principale : query de la boucle elle-même
 if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', [ 'event', 'post' ] );

 return $query;
}

// Affichage des derniers events dans la sidebar

// afficher les derniers événements
// création d'un hook
add_action('al_sidebar', 'al_get_events_list', 10, 1 );

function al_get_events_list(int $number){
    $args = [
        'post_type' => 'event',
        'posts_per_page' => $number
    ];

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) : ?>
    <ul class="list-group">
        <a href="#" class="list-group-item active">
            Liste des/du dernier(s) événement(s)
        </a>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<li class="list-group-item" ><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php endwhile; ?>
    </ul>
	<?php wp_reset_postdata(); // permet de réinitialiser la variable $post ?>

<?php else : ?>
	<p>Désolé pas d'évent en ce moment</p>
<?php endif; 

}

// Shortcode

/**
 * al_shortocde_event
 *
 * @param [type] $atts
 * @param [type] $content null permet éventuellement d'utiliser le content dans le code
 * @return void
 */
function al_shortocde_event( $atts, $content = null ) {

    $defaults = shortcode_atts( [
		'before' => date('Y') + 10, // on avance + 10 ans par défaut pour être sûr de les afficher tous par défaut 
		'after' => date('Y') - 10, // on recule de 10 ans pour être sûr de les afficher tous par défaut
		'limit' => -1, // tous les articles,
		'title' => 'Evénement(s)'
	], $atts );
	
	$args = [
		'post_type' => 'event',
		'post_status'=> ['future', 'publish'],
		'posts_per_page' => $defaults['limit'],
		'date_query' => [
			[
				'after'     => [
					'year' => $defaults['after']
					],
				'before'    => [
					'year' => $defaults['before']
					]
				],
			],
	];
	
	if(isset($atts['term'])){
		$terms = [
			'tax_query' => [
				[
					'taxonomy' => 'country',
					'field'    => 'slug',
					'terms'    => $atts['term'],
				],
			]
		];

		$args = array_merge($args, $terms);
		
	}

	$query = new WP_Query( $args );

	$date = '';
	if(isset($atts['after'])) $date = "Après : {$atts['after']}";
	if(isset($atts['before'])) $date = " Avant : {$atts['before']}";

	if ( $query->have_posts() ) : ?>
	<ul class="menu">
	<h2><?php echo $defaults['title']; ?> <?php echo $date; ?></h2>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		date de publication : <?php the_time('F Y'); ?></li>
	<?php endwhile; ?>
	</ul>

	<?php wp_reset_postdata(); // évite les effets de bord avec la global $posts
	endif;
}

add_shortcode( 'event_book', 'al_shortocde_event' );