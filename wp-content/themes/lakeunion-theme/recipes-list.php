<?php if ( have_rows( 'recipe_list' ) ): ?>

  <?php while ( have_rows ( 'recipe_list' ) ) : the_row();

  //var
  $courtesy_link = get_sub_field('courtesy_link');

  ?>

    <div class="recipe_header">

      <h2><?php the_sub_field('recipe_title'); ?></h2>

    </div>

    <div class="recipes-content"> <!-- recipes class start -->

      <?php if(have_rows('ingredients_list') ) : ?>

        <div class="ingredients">

          <div class="recipe-title"><h3>Ingredients</h3></div>

          <ul>

            <?php while( have_rows('ingredients_list') ): the_row();

              //var
              $recipe_list = get_sub_field('recipe_list');

            ?>

            <li><?php echo $recipe_list; ?></li>

            <?php endwhile; ?>

          </ul>

        </div>

      <?php endif; ?>

      <?php if(have_rows('directions') ) : ?>

        <div class="directions">

          <div class="recipe-title"><h3>Directions</h3></div>

          <ol>

          <?php while( have_rows('directions') ): the_row();

            //var
            $steps = get_sub_field('steps');

          ?>

          <li><?php echo $steps; ?></li>

          <?php endwhile; ?>

        </ol>

        </div>

      <?php endif; ?>

      <div class="clearfix"></div>

    </div> <!-- recipes class ends -->

    <div class="courtesy-link">

      Recipe Courtesy Of: <a href="http://<?php echo $courtesy_link ?>" target="_blank"> <?php echo $courtesy_link ?> </a>

    </div>

  <?php endwhile; ?>

<?php endif; ?>
