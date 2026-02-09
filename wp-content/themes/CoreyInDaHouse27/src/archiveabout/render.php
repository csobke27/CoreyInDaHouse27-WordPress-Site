<?php
// pull child page content for about sections
$childPages = new WP_Query( array(
    'post_type' => 'page',
    'post_parent' => get_the_ID(),
    'orderby' => 'menu_order',
    'order' => 'ASC'
) );
?>

<div class="archive-about-container">
    <div class="container ">

        <?php foreach ( $childPages->posts as $childPage){?>
        <?php $imgUrl = get_the_post_thumbnail_url( $childPage->ID, 'full' ) ?: 'https://placehold.co/400'; ?>
        <div class="d-none d-lg-block">
            <div class="row category-container">
                <div class="col-lg-6">
                    <img src="<?php echo esc_url( $imgUrl ); ?>" alt="CoreyInDaHouse27" class="about-preview-image">
                </div>
                <div class="col-lg-6">
                    <h2><?php echo get_the_title( $childPage->ID ); ?></h2>
                    <p><?php if(has_excerpt( $childPage->ID )) { echo get_the_excerpt( $childPage->ID ); } else { echo apply_filters( 'the_content', $childPage->post_content ); } ?></p>
                    <div class="d-flex justify-content-end">
                        <a href="<?php echo get_permalink( $childPage->ID ); ?>" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-lg-none card-container">
            <div class="card text-center">
                <img src="<?php echo esc_url( $imgUrl ); ?>" alt="CoreyInDaHouse27">
                <div class="card-body">
                    <h5 class="card-title"><?php echo get_the_title( $childPage->ID ); ?></h5>
                    <p class="card-text"><?php if(has_excerpt( $childPage->ID )) { echo get_the_excerpt( $childPage->ID ); } else { echo apply_filters( 'the_content', $childPage->post_content ); } ?></p>
                    <a href="<?php echo get_permalink( $childPage->ID ); ?>" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>

        <?php } ?>

    </div>
</div>