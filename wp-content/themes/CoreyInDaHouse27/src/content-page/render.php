<?php
$channel_id = defined('YOUTUBE_CHANNEL_ID') ? YOUTUBE_CHANNEL_ID : '';
$api_key = defined('YOUTUBE_API_KEY') ? YOUTUBE_API_KEY : '';

if ($channel_id && $api_key) {
    $yt_data = get_youtube_channel_data($channel_id, $api_key);
    // echo print_r($yt_data, true);
}

// $facebook_page_id = defined('FACEBOOK_PAGE_ID') ? FACEBOOK_PAGE_ID : '';
// $facebook_access_token = defined('FACEBOOK_ACCESS_TOKEN') ? FACEBOOK_ACCESS_TOKEN : '';

// if ($facebook_page_id && $facebook_access_token) {
//     $fb_data = get_facebook_posts($facebook_page_id, $facebook_access_token);
//     echo print_r($fb_data, true);
// }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 text-center">
            <h1>Main Content</h1>
            <p>These are the primary platforms where I share my content.</p>
        </div>
    </div>
    <div class="horizontal-accordion-container">
        <div class="accordion-card collapsed social-color-youtube" id="youtube-card">
            <div class="card-header">
                <i class="fab fa-youtube fa-3x"></i>
                <h2>YouTube</h2>
            </div>
            <div class="card-content">
                <p>Subscribe to my YouTube channel for gaming videos and live streams!</p>
                <p>Subscribers: <?php echo isset($yt_data['subscriber_count']) ? $yt_data['subscriber_count'] : 'N/A'; ?></p>
                <!-- display latest video -->
                <?php if (isset($yt_data['latest_video'])): ?>
                    <div class="latest-video">
                        <h3>Latest Video: <?php echo esc_html($yt_data['latest_video']['title']); ?></h3>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo esc_attr($yt_data['latest_video']['id']); ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>
                <a href="https://www.youtube.com/@CoreyInDaHouse27?sub_confirmation=1" class="btn btn-primary" target="_blank">Visit YouTube Channel</a>
            </div>
        </div>
        <div class="accordion-card collapsed social-color-twitch" id="twitch-card">
            <div class="card-header">
                <i class="fab fa-twitch fa-3x"></i>
                <h2>Twitch</h2>
            </div>
            <div class="card-content">
                <p>Follow my Twitch channel for live gaming, jumpscares, and humorous content!</p>
                <?php 
                $parent = (strpos($_SERVER['HTTP_HOST'], 'local') !== false || $_SERVER['HTTP_HOST'] === 'localhost') 
                    ? 'localhost' 
                    : $_SERVER['HTTP_HOST']; 
                ?>
                <iframe src="https://player.twitch.tv/?channel=coreyindahouse27&parent=<?php echo $parent; ?>" frameborder="0" allowfullscreen="true" scrolling="no" height="300" width="400"></iframe>
                <!-- <iframe src="https://player.twitch.tv/?channel=coreyindahouse27&parent=coreyindahouse27-site.local" frameborder="0" allowfullscreen="true" scrolling="no" height="300" width="400"></iframe> -->
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 text-center">
            <h2>Socials / Short-Form Content</h2>
            <p>Follow me on my social media platforms for the latest updates and short-form content!</p>
        </div>
    </div>
    <div class="horizontal-accordion-container">
        <div class="accordion-card collapsed social-color-tiktok" id="tiktok-card">
            <div class="card-header">
                <i class="fab fa-tiktok fa-3x"></i>
                <h2>Tiktok</h2>
            </div>
            <div class="card-content">
                <p>Subscribe to my TikTok for short-form videos and updates!</p>
                <a href="https://www.tiktok.com/@coreyindahouse27" class="btn btn-primary" target="_blank">Visit TikTok Profile</a>
            </div>
        </div>
        <div class="accordion-card collapsed social-color-facebook" id="facebook-card">
            <div class="card-header">
                <i class="fab fa-facebook fa-3x"></i>
                <h2>Facebook</h2>
            </div>
            <div class="card-content">
                <p>Follow my Facebook page for the latest updates and community interactions!</p>
                <!-- <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FCoreyindahouse27&tabs=timeline&width=500&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1511575547133563" width="500" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe> -->
            </div>
        </div>
        <div class="accordion-card collapsed social-color-instagram" id="instagram-card">
            <div class="card-header">
                <i class="fab fa-instagram fa-3x"></i>
                <h2>Instagram</h2>
            </div>
            <div class="card-content">
                <p>Subscribe to my Instagram for photos, stories, and more!</p>
                <a href="https://www.instagram.com/coreyindahouse27" class="btn btn-primary" target="_blank">Visit Instagram Profile</a>
            </div>
        </div>
        <div class="accordion-card collapsed social-color-twitter" id="x-card">
            <div class="card-header">
                <i class="fab fa-x-twitter fa-3x"></i>
                <h2>Twitter</h2>
            </div>
            <div class="card-content">
                <p>Follow my X page for the latest updates and community interactions!</p>
            </div>
        </div>
    </div>
</div>

<script>
    const accordionCards = document.querySelectorAll('.accordion-card');
    
    accordionCards.forEach(card => {
        card.addEventListener('click', () => {
            const isExpanded = card.classList.contains('expanded');
            
            // Collapse all cards
            accordionCards.forEach(c => {
                c.classList.remove('expanded');
                c.classList.add('collapsed');
            });
            
            // Expand clicked card if it wasn't already expanded
            if (!isExpanded) {
                card.classList.remove('collapsed');
                card.classList.add('expanded');
            }
        });
    });
</script>