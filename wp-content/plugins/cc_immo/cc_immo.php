<?php

/*
 * Plugin Name: CC_Immo
 * Description: Extension développée pour permettre la gestion de biens immobiliers pour le compte de <strong>Chalets & Caviar</strong>
 * Author: Erwan GUILLOU
 * Version: 1.0
 */

    global $wpdb;
    define('CC_PLUGIN_BASENAME', __FILE__);
    define('CC_DIR_VIEW', __DIR__ . '/view/');
    define('CC_TABLE_BIENS', $wpdb->prefix.'cc_biens');

    /**
     * Ajout de biens depuis l'administration
     * Inutile de faire trop élaboré
     */
    require_once('class/cc_immo.php');
    require_once('class/shortcodes.php');
    require_once('class/inputs.php');
    require_once('class/biens.php');
    require_once('class/cc_table_biens.php');

    cc_immo::init();
    cc_immo::enable_shortcodes();
    cc_immo::set_admin_menu();

