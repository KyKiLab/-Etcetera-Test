<?php

acf_add_local_field_group(array(
    'key' => 'group_real_estate_fields',
    'title' => 'Real Estate Details',
    'fields' => array(
        array(
            'key' => 'field_building_name',
            'label' => 'Building Name',
            'name' => 'building_name',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_main_image',
            'label' => 'Main Image',
            'name' => 'main_image',
            'type' => 'image',
            'return_format' => 'url',
        ),
        array(
            'key' => 'field_coordinates',
            'label' => 'Coordinates',
            'name' => 'coordinates',
            'type' => 'text',
            'instructions' => 'Format: latitude, longitude (e.g., 49.8397, 24.0297)',
        ),
        array(
            'key' => 'field_number_of_floors',
            'label' => 'Number of Floors',
            'name' => 'number_of_floors',
            'type' => 'select',
            'choices' => array_combine(range(1, 20), range(1, 20)),
        ),
        array(
            'key' => 'field_building_type',
            'label' => 'Building Type',
            'name' => 'building_type',
            'type' => 'radio',
            'choices' => array(
                'Panel' => 'Panel',
                'Brick' => 'Brick',
                'Foam block' => 'Foam block',
            ),
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_eco_rating',
            'label' => 'Eco Rating',
            'name' => 'eco_rating',
            'type' => 'select',
            'choices' => array(
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
            ),
        ),
        array(
            'key' => 'field_rooms',
            'label' => 'Rooms',
            'name' => 'rooms',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Room',
            'sub_fields' => array(
                array(
                    'key' => 'field_room_image',
                    'label' => 'Room Image',
                    'name' => 'room_image',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_area',
                    'label' => 'Area',
                    'name' => 'area',
                    'type' => 'text',
                    'instructions' => 'Example: 34 m²',
                ),
                array(
                    'key' => 'field_room_count',
                    'label' => 'Number of Rooms',
                    'name' => 'room_count',
                    'type' => 'radio',
                    'choices' => array_combine(range(1, 10), range(1, 10)),
                    'layout' => 'horizontal',
                ),
                array(
                    'key' => 'field_balcony',
                    'label' => 'Balcony',
                    'name' => 'balcony',
                    'type' => 'radio',
                    'choices' => array(
                        'Yes' => 'Yes',
                        'No'  => 'No',
                    ),
                ),
                array(
                    'key' => 'field_bathroom',
                    'label' => 'Bathroom',
                    'name' => 'bathroom',
                    'type' => 'radio',
                    'choices' => array(
                        'Yes' => 'Yes',
                        'No'  => 'No',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'real_estate',
            ),
        ),
    ),
));