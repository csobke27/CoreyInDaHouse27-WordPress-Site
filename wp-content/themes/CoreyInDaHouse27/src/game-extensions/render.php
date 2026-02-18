<?php
// pull game extensions content for game extensions page
$games = new WP_Query( array(
    'post_type' => 'game-extensions',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    
) );
$game_modes = array();
foreach($games->posts as $game) {
    $modes = new WP_Query( array(
        'post_type' => 'game-extension-mode',
        'meta_query' => array(
            array(
                'key' => 'game_extension_relation',
                'value' => '"' . $game->ID . '"',
                'compare' => 'LIKE'
            )
        )
    ) );
    $game_modes[$game->ID] = $modes->posts;
}
?>

<div class="game-extensions-container">
    <div class="container">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php if ( $games->have_posts() ) : ?>
                    <?php while ( $games->have_posts() ) : $games->the_post(); ?>
                        <div class="swiper-slide" id="<?php the_ID(); ?>">
                            <div class="picture">
                                <?php $game_cover = get_field('game_cover'); ?>
                                <img src="<?php echo $game_cover['url']; ?>" alt="<?php echo $game_cover['alt']; ?>" />
                            </div>
                            <div class="detail">
                                <h3><?php the_title(); ?></h3>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-scrollbar"></div>
        </div>
        <div class="game-mode-list">
        </div>
    </div>
</div>

<script>
// Pass game modes data to JavaScript
window.gameModesData = <?php 
    $output = array();
    foreach($game_modes as $game_id => $modes) {
        $output[$game_id] = array();
        foreach($modes as $mode) {
            $output[$game_id][] = array(
                'id' => $mode->ID,
                'title' => $mode->post_title,
                'content' => $mode->post_content,
                'game_mode_page_link' => get_field('game_mode_page_link', $mode->ID)
            );
        }
    }
    echo json_encode($output);
?>;
</script>