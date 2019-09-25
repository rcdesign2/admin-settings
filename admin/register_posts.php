<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2019-08-26
 * Time: 10:26
 */

/*
 * This will register the custom post type we need.
 * We will also tackle the custom fields
 */



function rc_register_social_posts()
{
    register_post_type('rc_social_post',
        array(
            'labels'      => array(
                'name'          => __('Social Posts'),
                'singular_name' => __('Social Post'),
            ),
            'public'      => true,
            'has_archive' => false,
            'supports'    => array('title','custom-fields'),
        )
    );
    remove_post_type_support('rc_social_post','editor');
}
add_action('init', 'rc_register_social_posts');



if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
        'key' => 'rc_social_fields',
        'title' => 'RC Social Post Fields',
        'fields' => array (
            array (
                'key' => 'rc_social_data',
                'label' => 'Social Data',
                'name' => 'rc_social_data',
                'type' => 'text',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'readonly' => 1,
                'disabled' => 0,
            ),
            array(
                'key' => 'rc_social_content',
                'label' => 'Social Content',
                'name' => 'rc_social_content',
                'type' => 'text',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'readonly' => 1,
                'disabled' => 0,
            ),
            array(
                'key' => 'rc_social_image',
                'label' => 'Social Image',
                'name' => 'rc_social_image',
                'type' => 'image',
                'return_format' => 'url',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'readonly' => 1,
                'disabled' => 0,
            )

        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'rc_social_post',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ));

endif;