<?php

    class cc_immo
    {

        public static function init()
        {
            if(session_status() == PHP_SESSION_NONE)
            {
                session_start();
                session_regenerate_id();
            }

            # A exécuter lors de l'activation du plugin
            register_activation_hook(CC_PLUGIN_BASENAME, [self::class, 'activate']);
        }

        public static function activate()
        {
            global $wpdb;
            $wpdb->query('CREATE TABLE IF NOT EXISTS `'.CC_TABLE_BIENS.'` ( `bien_id` INT NOT NULL AUTO_INCREMENT , `bien_accroche` VARCHAR(100) NOT NULL , `bien_description` TEXT NOT NULL , `bien_mandat` TINYINT NOT NULL , `bien_image` TEXT NOT NULL, `bien_prix` INT NOT NULL , `bien_frais_agence` TINYINT NOT NULL , `bien_adresse` INT(100) NOT NULL , `bien_ville` INT(100) NOT NULL , `bien_pays` INT NOT NULL , `bien_transport` TINYINT NOT NULL , `bien_commerce` TINYINT NOT NULL , `bien_etat` TINYINT NOT NULL , `bien_chambre` SMALLINT NOT NULL , `bien_cuisine` TINYINT NOT NULL , `bien_exposition` TINYINT NOT NULL , PRIMARY KEY (`bien_id`)) ENGINE = InnoDB;');
        }

        public static function enable_shortcodes()
        {
            add_shortcode('cc_immo_search_engine', [shortcodes::class, 'search_engine']);
            add_shortcode('cc_immo_immovables_list', [shortcodes::class, 'immovables_list']);
            add_shortcode('cc_immo_immovable', [shortcodes::class, 'get_immovable']);
            add_shortcode('cc_immo_contact', [shortcodes::class, 'get_contact_form']);
        }

        public static function set_admin_menu()
        {
            add_action('admin_menu', function(){
                add_menu_page('Gestion de vos biens', 'Immo Chalets & Caviar', 'manage_options', 'chaletscaviar', function(){
                    include(CC_DIR_VIEW . 'adminpage.cc.liste.php');
                }, 'dashicons-admin-home', 4);

                add_submenu_page('chaletscaviar', 'Tous les biens', 'Tous les biens', 'manage_options', 'chaletscaviar');
                add_submenu_page('chaletscaviar', 'Ajouter un bien', 'Ajouter', 'manage_options', 'chaletscaviar_ajouter', function(){
                    include(CC_DIR_VIEW . 'adminpage.cc.ajouter.php');
                });
            });
        }
    }