<?php
function rec_render_filter_form() {
    ob_start();

    $filters = [
        [
            'label' => 'District',
            'id'    => 'district',
            'name'  => 'district',
            'type'  => 'taxonomy',
            'taxonomy' => 'district',
            'width' => 2,
        ],
        [
            'label' => 'Eco Rating',
            'id'    => 'eco_rating',
            'name'  => 'eco_rating',
            'type'  => 'range',
            'min'   => 1,
            'max'   => 5,
            'width' => 1,
        ],
        [
            'label' => 'Building Type',
            'id'    => 'building_type',
            'name'  => 'building_type',
            'type'  => 'select',
            'options' => ['Panel', 'Brick', 'Foam block'],
            'width'   => 2,
        ],
        [
            'label' => 'Number of Floors',
            'id'    => 'number_of_floors',
            'name'  => 'number_of_floors',
            'type'  => 'range',
            'min'   => 1,
            'max'   => 20,
            'width' => 2,
        ],
        [
            'label' => 'Room Count',
            'id'    => 'room_count',
            'name'  => 'room_count',
            'type'  => 'range',
            'min'   => 1,
            'max'   => 10,
            'width' => 1,
        ],
        [
            'label' => 'Balcony',
            'id'    => 'balcony',
            'name'  => 'balcony',
            'type'  => 'select',
            'options' => ['Yes', 'No'],
            'width'   => 1,
        ],
        [
            'label' => 'Bathroom',
            'id'    => 'bathroom',
            'name'  => 'bathroom',
            'type'  => 'select',
            'options' => ['Yes', 'No'],
            'width'   => 1,
        ],
    ];
    ?>
    <form method="GET" id="real-estate-filter" class="real-estate-filter mb-4">
        <h3 class="mb-3">Filter Real Estate</h3>
        <div class="row g-3 align-items-end">
            <?php foreach ( $filters as $filter ) : ?>
                <div class="col-md-<?php echo esc_attr( $filter['width'] ); ?>">
                    <label for="<?php echo esc_attr( $filter['id'] ); ?>" class="form-label">
                        <?php echo esc_html( $filter['label'] ); ?>:
                    </label>
                    <select name="<?php echo esc_attr( $filter['name'] ); ?>" id="<?php echo esc_attr( $filter['id'] ); ?>" class="form-select">
                        <option value="">Any</option>
                        <?php
                        if ( $filter['type'] === 'taxonomy' ) {
                            $terms = get_terms( [
                                'taxonomy'   => $filter['taxonomy'],
                                'hide_empty' => false,
                            ] );
                            foreach ( $terms as $term ) {
                                printf(
                                    '<option value="%s">%s</option>',
                                    esc_attr( $term->slug ),
                                    esc_html( $term->name )
                                );
                            }
                        } elseif ( $filter['type'] === 'range' ) {
                            for ( $i = $filter['min']; $i <= $filter['max']; $i++ ) {
                                printf( '<option value="%1$d">%1$d</option>', $i );
                            }
                        } elseif ( $filter['type'] === 'select' ) {
                            foreach ( $filter['options'] as $option ) {
                                printf(
                                    '<option value="%s">%s</option>',
                                    esc_attr( $option ),
                                    esc_html( $option )
                                );
                            }
                        }
                        ?>
                    </select>
                </div>
            <?php endforeach; ?>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Apply</button>
            </div>
        </div>
    </form>

    <div id="real-estate-results" class="mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-4" id="real-estate-cards"></div>
    </div>

    <div id="load-more-wrapper" class="text-center mt-4" style="display: none;">
        <button id="load-more" class="btn btn-secondary">Load more</button>
    </div>
    <?php
    return ob_get_clean();
}