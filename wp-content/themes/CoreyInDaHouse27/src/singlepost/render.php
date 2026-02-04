<?php

// pageBanner();
// get featured image for the post
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
?>

<div class="page-banner">
  <!--  function needs to be created to dynamically pick a background image based on post category  -->
    <div class="page-banner__bg-image" style="background-image: url(
        <?php echo $featured_image?>)">
    </div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo get_the_title();?></h1>
        <div class="page-banner__intro">
          <p>Posted on <?php the_time('n/j/y'); ?></p>
          <p>By <?php the_author(); ?></p>
        </div>
    </div>
</div>
    
<div class="container container--narrow page-section">
  <!-- <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></span></p>
  </div> -->
  <div class="row">
    <div class="blog-content col"><?php the_content(); ?></div>
  </div>

</div>