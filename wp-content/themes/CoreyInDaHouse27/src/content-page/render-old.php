<?php
?>
<div class="social-bento-grid">
    <!-- YouTube Video (Large) -->
    <div class="bento-card bento-youtube">
        <?php 
        $youtube = get_cached_youtube_data();
        if ($youtube): ?>
            <iframe src="https://www.youtube.com/embed/<?php echo $youtube['latest_video']['id']; ?>" 
                    allowfullscreen></iframe>
            <h3><?php echo $youtube['latest_video']['title']; ?></h3>
        <?php endif; ?>
    </div>

    <!-- Twitch (Medium) -->
    <div class="bento-card bento-twitch">
        <a href="https://twitch.tv/YOUR_USERNAME" target="_blank">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/twitch-preview.jpg" alt="Twitch">
            <div class="overlay">
                <i class="fab fa-twitch"></i>
                <span>Watch Live on Twitch</span>
            </div>
        </a>
    </div>

    <!-- Instagram Posts (Small Grid) -->
    <div class="bento-card bento-instagram">
        <?php $insta_posts = get_instagram_posts(4); // Get 4 posts
        foreach ($insta_posts as $post): ?>
            <a href="<?php echo $post['url']; ?>" target="_blank">
                <img src="<?php echo $post['thumbnail']; ?>" alt="Instagram">
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Twitter (Medium) -->
    <div class="bento-card bento-twitter">
        <blockquote class="twitter-tweet">
            <a href="https://twitter.com/YOUR_USERNAME"></a>
        </blockquote>
        <script async src="https://platform.twitter.com/widgets.js"></script>
    </div>

    <!-- Facebook (Small) -->
    <div class="bento-card bento-facebook">
        <a href="https://facebook.com/YOUR_PAGE" target="_blank">
            <i class="fab fa-facebook"></i>
            <span>Follow on Facebook</span>
        </a>
    </div>
</div>