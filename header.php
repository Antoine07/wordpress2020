<?php

$categories = get_categories([
    'orderby' => 'name',
    'exclude' => 1
]);


echo '<ul>';
foreach($categories as $category){

    echo sprintf(
        '<li class="nav-item">
            <a href="%s" alt="%s" >
                %s
            </a>
        </li>',
        esc_url(get_category_link($category->term_id) ),
        esc_attr(get_category_link($category->name) ),
        esc_html(get_category_link($category->name) )
    );

    echo sprintf(
        '<li class="nav-item">
            <a href="%s" alt="Home" >
                %s
            </a>
        </li>',
        esc_url( get_bloginfo('url') ),
        "Page d'accueil"
    );
}

echo '</ul>';