<?php get_header(); ?>

<main class="container py-5">

    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>

            <?php the_content(); ?>

            <h2 class="mt-5">Latest Blog Posts</h2>

            <?php
            $query = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 5
            ));

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post(); ?>
                    <article class="mb-4">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php the_excerpt(); ?></p>
                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No posts found.</p>';
            endif;
            ?>

        <?php endwhile;
    endif;
    ?>

</main>

<?php get_footer(); ?>