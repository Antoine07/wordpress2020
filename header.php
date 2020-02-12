<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Book</title>
   <?php wp_head() ; ?>
</head>
<!-- body_class injecte des classes automatiquement en fonction de la page qu'il affiche -->
<body <?php body_class(); ?> >
<?php wp_nav_menu([
            'theme_location'  => 'main',
            'container'       => 'nav', // wrapper nav
            'container_class' => 'nav-main nav-collapse',
]); ?>
