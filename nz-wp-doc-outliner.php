<?php

/*
 * Nz Document Outliner
 *
 * Plugin Name: Nz Document Outliner
 * Plugin URI:  https://www.nzlabs.es
 * Description: creates a top bar button to outline current page
 * Version:     0.1
 * Author:      Nadir Zenith
 * Author URI:  https://www.nzlabs.es
 * License:     MIT
 * Copyright:   2015 nzlabs
 *
 * Text Domain: nz-doc-outliner
 * Domain Path: /languages/
 */

/**
 * Plugin main class
 *
 * @author NadirZenith
 */
class NzDocOutliner
{

    private $version = '0.1.1';

    /**
     *  Init plugin if user is admin
     */
    public function __construct()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $this->adminAssets();
        $this->adminFilters();
    }

    /**
     *  Enqueue assets
     */
    public function adminAssets()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    public function enqueueStyles()
    {
        wp_enqueue_style('nz-doc-ouliner-plugin', plugins_url('/assets/css/nz-doc-outliner.css', __FILE__));
    }

    public function enqueueScripts()
    {
        wp_enqueue_script('nz-doc-outliner', plugins_url('/assets/js/h5o/outliner.min.js', __FILE__), [], $this->version, true);
        wp_enqueue_script('nz-doc-outliner-plugin', plugins_url('/assets/js/nz-doc-outliner.js', __FILE__), ['nz-doc-outliner', 'jquery'], $this->version, true);
    }

    /**
     * Hooks
     */
    private function adminFilters()
    {
        add_action('admin_bar_menu', [$this, 'outlinerMenu'], 1060);
    }
    
    public function outlinerMenu($wp_admin_bar)
    {
        $args = array(
            'id' => 'nz-doc-outliner',
            'title' => 'Outliner',
            'meta' => array('class' => 'nz-doc-outliner')
        );
        $wp_admin_bar->add_node($args);
    }
}

new NzDocOutliner();
