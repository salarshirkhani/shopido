<?php get_header(); ?>
<main>
    <?php if (have_posts()) : ?>
        <div class="product-archive">
            <?php while (have_posts()) : the_post(); ?>
                <div class="product-item">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <div class="product-price"><?php woocommerce_template_loop_price(); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p><?php _e('No products found.', 'mytheme'); ?></p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
