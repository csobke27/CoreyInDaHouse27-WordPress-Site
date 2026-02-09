<?php
// Fetch categories for filtering
$categories = get_categories(array(
    'taxonomy' => 'category',
    'hide_empty' => true,
    'orderby' => 'name',
    'order' => 'ASC'
));
// Get selected category from query parameters
$selectedCategory = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$page = get_query_var('paged') ? get_query_var('paged') : 1;
// if selectedCategory is not set, select the latest 4 posts from each category
$query = array(
    'post_type' => 'post',
    'posts_per_page' => 9,
    'paged' => $page,
    'orderby' => 'date',
    'order' => 'DESC'
);

if ($selectedCategory) {
    $query['category_name'] = $selectedCategory;
}
$postQuery = new WP_Query($query);
// Fetch posts based on the query
$posts = $postQuery->posts;
// Get total number of pages for pagination
$maxPages = $postQuery->max_num_pages;

?>
<div class="bloghome-container">
    <div class="container">
        <div class="align-items-center d-none d-lg-flex">
            <span class="me-3 blog-select-label">Categories:</span>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($selectedCategory === '') ? 'active' : ''; ?>" href="<?php echo esc_url(site_url('/blog')); ?>">All</a>
                </li>
                <?php foreach($categories as $category): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($selectedCategory === $category->slug) ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('category', $category->slug)); ?>">
                        <?php echo esc_html($category->name) . " (" . esc_html($category->count) . ")"; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="d-flex align-items-center d-lg-none mb-3">
            <label for="category-select" class="form-label me-2 mb-0 blog-select-label">Categories:</label>
            <select id="category-select" class="form-control" onchange="location = this.value;">
                <option value="<?php echo esc_url(site_url('/blog')); ?>">All Categories</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?php echo esc_url(add_query_arg('category', $category->slug)); ?>">
                        <?php echo esc_html($category->name) . " (" . esc_html($category->count) . ")"; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Blog post section -->
         <?php if (!$postQuery->have_posts()): ?>
            <p id="no-posts-message">No posts found in the category "<?php echo esc_html($selectedCategory); ?>".</p>
        <?php endif; ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 blog-posts-grid">
            <?php while ($postQuery->have_posts()): $postQuery->the_post(); ?>
            <div class="col blog-card">
                <div class="card h-100">
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php if ($maxPages > 1): ?>
            <div class="pagination-container">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo esc_url(add_query_arg('paged', max(1, $page - 1))); ?>" tabindex="-1">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $maxPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo esc_url(add_query_arg('paged', $i)); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $maxPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo esc_url(add_query_arg('paged', min($maxPages, $page + 1))); ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</div>