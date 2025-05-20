<?php get_header(); ?>

<main id="main" class="site-main container py-5">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <h1 class="mb-4 text-primary display-5 fw-bold"><?php the_title(); ?></h1>

    <div class="row g-4 align-items-start mb-5">
    <div class="col-md-6">
            <?php if (get_field('main_image')) : ?>
                <img src="<?php echo esc_url(get_field('main_image')); ?>" alt="<?php the_title(); ?>" class="w-100" style="max-height: 600px; object-fit: contain;">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Building Name:</strong> <?php the_field('building_name'); ?></li>
                <li class="list-group-item"><strong>Coordinates:</strong> <?php the_field('coordinates'); ?></li>
                <li class="list-group-item"><strong>Number of Floors:</strong> <?php the_field('number_of_floors'); ?></li>
                <li class="list-group-item"><strong>Building Type:</strong> <?php the_field('building_type'); ?></li>
                <li class="list-group-item"><strong>Eco Rating:</strong> <?php the_field('eco_rating'); ?></li>
                <li class="list-group-item"><strong>District:</strong>
                    <?php
                    $terms = get_the_terms( get_the_ID(), 'district' );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $term_names = wp_list_pluck( $terms, 'name' );
                        echo esc_html( implode( ', ', $term_names ) );
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>

    <?php if ( have_rows('rooms') ) : ?>
        <h2 class="mb-3">Rooms</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ( have_rows('rooms') ) : the_row(); ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if ( get_sub_field('room_image') ) : ?>
                            <div class="overflow-hidden" style="height: 220px;">
                                <img src="<?php echo esc_url(get_sub_field('room_image')); ?>" class="card-img-top h-100 w-100" alt="Room Image" style="object-fit: cover;">
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <p class="card-text mb-1"><strong>Area:</strong> <?php the_sub_field('area'); ?></p>
                            <p class="card-text mb-1"><strong>Rooms:</strong> <?php the_sub_field('room_count'); ?></p>
                            <p class="card-text mb-1"><strong>Balcony:</strong> <?php the_sub_field('balcony'); ?></p>
                            <p class="card-text"><strong>Bathroom:</strong> <?php the_sub_field('bathroom'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</article>

<?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
