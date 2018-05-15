<?php
/*
* plugin name: Subtitle
* Description: Adds a subtitle under the title for your posts.
* Version: 1.0
* Author: Tonke Bult
* Author URI: http://tonkebult.nl  
* 
*/
if (!defined('ABSPATH')) exit; // Security: Exit if accessed directly

class Subtitle {

    public function __construct() {
        add_action('admin_enqueue_scripts', array($this,'includes'));
        add_action('edit_form_after_title', array($this, 'addSubtitle'));
        add_action('save_post', array($this, 'savePost'));
        
    }

        
    public function includes() {
        wp_register_style('subtitle-style', plugin_dir_url(__FILE__).'admin/css/subtitle-style.css');
        wp_enqueue_style('subtitle-style');
    }
 

    public function addSubtitle() {
        echo " 
        <div id='subtitlefield'>
            <br>
            <input type='text' name='subtitle' placeholder='Enter subtitle here' id='subtitlefield'>
        </div>";
    }


    public function savePost($postID) {
        $postID = get_the_ID();
        $post_type = get_post_type($postID);
        if (current_user_can('editor') || current_user_can('administrator') ) {
            if (isset($_POST['subtitle'])){
                update_post_meta($postID, 'subtitle',  sanitize_text_field( $_POST['subtitle']));
            }
        }
    }

} // ./ class subtitle

$plugin = new Subtitle();