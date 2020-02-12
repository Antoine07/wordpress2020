<?php
// test si on a des articles à afficher
// syntaxe PHP : endif ou endwhile plus clair dans les templates
if (have_posts()) : ?>
<div class="container">
<?php
   // dépile les articiles récupérés dans la boucle
   // have_posts à chaque qu'il est appelé récupère un article
   while (have_posts()) :
      the_post(); // permet de récupérer l'article et d'avancer
      ?>
      <h1><a href="<?php the_permalink() ; ?>"><?php the_title() ; ?></a></h1>
      <div class="post">
         <?php the_content(); ?>
         <p><?php the_author_posts_link() ; ?></p>
      </div>
      <?php endwhile;
else : ?>
<p>Désolé pour l'instant il n'y a pas d'article </p>
<?php endif ; ?>
</div>
