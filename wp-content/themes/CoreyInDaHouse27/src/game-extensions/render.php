<?php
// pull game extensions content for game extensions page
$games = new WP_Query( array(
    'post_type' => 'game-extensions',
    'orderby' => 'menu_order',
    'order' => 'ASC'
) );
// echo print_r($games, true);
?>

<div class="game-extensions-container">
    <div class="container ">
    <!-- loop through $games and show the game cover -->
    <?php if ( $games->have_posts() ) : ?>
        <?php while ( $games->have_posts() ) : $games->the_post(); ?>
            <div class="game-cover">
                <?php $game_cover = get_field('game_cover'); ?>
                <img width="260"  src="<?php echo $game_cover['url']; ?>" alt="<?php echo $game_cover['alt']; ?>" />
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    </div>
</div>