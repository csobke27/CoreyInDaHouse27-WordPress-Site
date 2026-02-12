<header>
    <nav class="navbar navbar-expand-xl navbar-light header">
        <a class="navbar-brand mb-0 h1" href="<?php echo esc_url(site_url()) ?>">
                <img src="<?php echo get_theme_file_uri('/images/logo.png'); ?>" width="50" height="50"  alt="">
                <span>CoreyInDaHouse27<span>
            </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarHeader">
            
            <ul class="navbar-nav ml-auto  mt-2 mt-xl-0">
            <li class="nav-item">
                <a class="nav-link header-nav <?php if (is_page('about')) echo  "active" ?>" href="<?php echo esc_url(site_url('/about')); ?>">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link header-nav <?php if (is_page('blog')) echo  "active" ?>" href="<?php echo esc_url(site_url('/blog')); ?>">Blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link header-nav <?php if (is_page('content')) echo  "active" ?>" href="<?php echo esc_url(site_url('/content')); ?>">Content</a>
            </li>
            <li class="nav-item">
                <a class="nav-link header-nav disabled" href="#">Merch</a>
            </li>
            <li class="nav-item">
                <a class="nav-link header-nav disabled" href="#">Game extensions</a>
            </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <!-- this is a placeholder for the twitch live notification. API needed -->
    <?php
        $twitch_is_live = false; // This would be determined by an actual Twitch API call
        if($twitch_is_live): ?>
        <div class="twitch-live-notification">
            CoreyInDaHouse27 is LIVE on Twitch! <a href="https://www.twitch.tv/coreyindahouse27" target="_blank">Click here to watch!</a>
        </div>
    <?php endif; ?>
</header>