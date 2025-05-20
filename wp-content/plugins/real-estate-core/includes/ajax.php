<?php
/**
 * Class-based AJAX handler for real estate filtering.
 */

class Real_Estate_Ajax_Filter {

    public static function init() {
        add_action( 'wp_ajax_real_estate_filter', [ __CLASS__, 'handle' ] );
        add_action( 'wp_ajax_nopriv_real_estate_filter', [ __CLASS__, 'handle' ] );
    }

    public static function handle() {
        $paged = isset( $_GET['paged'] ) ? max( 1, (int) $_GET['paged'] ) : 1;

        $meta_query = [ 'relation' => 'AND' ];
        $tax_query  = [];

        if ( ! empty( $_GET['district'] ) ) {
            $tax_query[] = [
                'taxonomy' => 'district',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $_GET['district'] ),
            ];
        }

        $acf_fields = [ 'eco_rating', 'building_type', 'number_of_floors' ];
        foreach ( $acf_fields as $field ) {
            if ( ! empty( $_GET[ $field ] ) ) {
                $meta_query[] = [
                    'key'     => $field,
                    'value'   => sanitize_text_field( $_GET[ $field ] ),
                    'compare' => '=',
                ];
            }
        }

        $args = [
            'post_type'      => 'real_estate',
            'posts_per_page' => -1,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
        ];

        $query         = new WP_Query( $args );
        $matched_posts = [];

        if ( $query->have_posts() ) {
            foreach ( $query->posts as $post ) {
                $rooms   = get_field( 'rooms', $post->ID );
                $matches = true;

                if ( ! empty( $_GET['room_count'] ) || ! empty( $_GET['balcony'] ) || ! empty( $_GET['bathroom'] ) ) {
                    $matches = false;

                    if ( is_array( $rooms ) ) {
                        foreach ( $rooms as $room ) {
                            $room_ok = true;

                            if ( ! empty( $_GET['room_count'] ) && (string) $room['room_count'] !== $_GET['room_count'] ) {
                                $room_ok = false;
                            }
                            if ( ! empty( $_GET['balcony'] ) && $room['balcony'] !== $_GET['balcony'] ) {
                                $room_ok = false;
                            }
                            if ( ! empty( $_GET['bathroom'] ) && $room['bathroom'] !== $_GET['bathroom'] ) {
                                $room_ok = false;
                            }

                            if ( $room_ok ) {
                                $matches = true;
                                break;
                            }
                        }
                    }
                }

                if ( $matches ) {
                    $matched_posts[] = $post;
                }
            }
        }

        $per_page      = 5;
        $total         = count( $matched_posts );
        $paged_results = array_slice( $matched_posts, ( $paged - 1 ) * $per_page, $per_page );

        if ( ! empty( $paged_results ) ) {
            foreach ( $paged_results as $post ) {
                $post_id        = $post->ID;
                $image          = get_field( 'main_image', $post_id );
                $eco_rating     = get_field( 'eco_rating', $post_id );
                $building_type  = get_field( 'building_type', $post_id );
                $floors         = get_field( 'number_of_floors', $post_id );
                $rooms          = get_field( 'rooms', $post_id );
                $room_total     = 0;

                if ( is_array( $rooms ) ) {
                    foreach ( $rooms as $room ) {
                        $room_total += (int) $room['room_count'];
                    }
                }

                ?>
                <div class="col">
                    <div class="card h-100">
                        <?php if ( $image ) : ?>
                            <img src="<?php echo esc_url( $image ); ?>" class="card-img-top real-estate-img" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                                    <?php echo esc_html( get_the_title( $post_id ) ); ?>
                                </a>
                            </h5>
                            <p class="card-text">
                                <?php
                                $terms = get_the_terms( $post_id, 'district' );
                                if ( $terms && ! is_wp_error( $terms ) ) {
                                    echo '<strong>District:</strong> ' . esc_html( implode( ', ', wp_list_pluck( $terms, 'name' ) ) ) . '<br>';
                                }
                                ?>
                                <strong>Eco Rating:</strong> <?php echo esc_html( $eco_rating ); ?><br>
                                <strong>Type:</strong> <?php echo esc_html( $building_type ); ?><br>
                                <strong>Floors:</strong> <?php echo esc_html( $floors ); ?><br>
                                <strong>Total Rooms:</strong> <?php echo esc_html( $room_total ); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }

            if ( ( $paged * $per_page ) >= $total ) {
                echo '<div id="end-of-results" data-last="true" style="display:none;"></div>';
            }
        } else {
            echo '<p>No results found.</p>';
        }

        wp_reset_postdata();
        wp_die();
    }
}

Real_Estate_Ajax_Filter::init();