<?php

?>

<div class="single-about-container">
    <div class="container ">
        <div class="row">
            <div class="col">
                <div class="about-banner">
                    <h1 class="about-title"><?php echo get_the_title(); ?></h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col about-content-col">
                <?php the_content(); ?>
                <div >
                    <a href="<?php echo site_url('/about'); ?>" class="btn btn-primary about-back-button">Back to About Page</a>
                </div>
            </div>
        </div>
    </div>
</div>