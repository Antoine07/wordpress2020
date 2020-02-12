<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Book</title>
   <?php wp_head() ; ?>
</head>
<body>
<?php
$categories = get_categories([
    'orderby' => 'name',
    'exclude' => 1
]);

echo '<ul>';
foreach($categories as $category){

    echo sprintf(
        '<li class="nav-item">
            <a href="%s" alt="%s" >%s</a>
        </li>',
        esc_url(get_category_link($category->term_id) ),
        esc_attr(get_category_link($category->name) ),
        esc_html($category->name )
    );
}

echo sprintf(
    '<li class="nav-item">
        <a href="%s" alt="Home" >
            %s
        </a>
    </li>',
    esc_url( get_bloginfo('url') ),
    "Page d'accueil"
);

$page = get_page_by_title('Qui sommes-nous ?') ;

// var_dump($page);
echo sprintf(
    '<li class="nav-item">
        <a href="%s" alt="Home" >
            %s
        </a>
    </li>',
    get_permalink($page->ID),
    'Qui sommes-nous ?'
);
echo '</ul>';
