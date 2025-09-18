<?php
/**
 * The template for displaying all pages
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                
                <?php if (!is_front_page()) : ?>
                    <header class="page-header">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <?php if (has_excerpt()) : ?>
                            <div class="page-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </header>
                <?php endif; ?>

                <div class="page-content-wrapper">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'wp-master-dev'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="page-comments">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
