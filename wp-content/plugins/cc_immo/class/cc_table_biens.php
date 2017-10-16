<?php

    if(!class_exists('WP_List_Table')){
        require_once( ABSPATH . 'wp-admin/includes/class-wp-screen.php' );
        require_once( ABSPATH . 'wp-admin/includes/screen.php' );
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        require_once( ABSPATH . 'wp-admin/includes/template.php' );
    }

    class cc_table_biens extends WP_List_Table
    {

        function get_columns()
        {
            $columns = array(
                'bien_id' => '#',
                'bien_image' => 'Image',
                'bien_accroche' => 'Bien',
                'bien_mandat' => 'Mandat',
                'bien_prix' => 'Prix/Loyer',
                'bien_adresse' => 'Localisation'
            );
            return $columns;
        }

        function get_sortable_columns()
        {
            $columns = [
                'bien_id' => ['cc_bien_id', true],
                'bien_accroche' => ['cc_bien_accroche', false],
                'bien_mandat' => ['cc_bien_mandat', false],
                'bien_prix' => ['cc_bien_prix', false]
            ];
            return $columns;
        }

        function prepare_items()
        {
            $columns = $this->get_columns();
            $hidden = [];
            $sortable = $this->get_sortable_columns();;
            $this->_column_headers = array($columns, $hidden, $sortable);
            $this->items = biens::liste();
        }

        function column_default($item, $column_name)
        {
            switch($column_name)
            {
                case 'bien_image':
                    return '<img style="width:100px;" src="'.$item->bien_image.'" />';
                    break;

                case 'bien_mandat':
                    $mandats = inputs::mandat(inputs::TO_ARRAY);
                    return $mandats[$item->$column_name];
                    break;

                case 'bien_prix':
                    return number_format(htmlentities($item->bien_prix), 00, ',', ' ') . ' € <br>+'.htmlentities($item->bien_frais_agence).' %';
                    break;

                case 'bien_adresse':

                    $adresses = inputs::adresse(inputs::TO_ARRAY);
                    $villes = inputs::ville(inputs::TO_ARRAY);
                    $pays = inputs::pays(inputs::TO_ARRAY);

                    $adresse = [htmlentities($adresses[$item->bien_adresse] ?? NULL), htmlentities($villes[$item->bien_ville] ?? NULL), htmlentities($pays[$item->bien_pays] ?? NULL)];
                    return implode('<br>', $adresse);
                    break;
            }

            return htmlentities($item->$column_name);
        }

        function column_bien_accroche($item)
        {
            $actions = [
                'edit' => '<a href="'.admin_url('admin.php?page=chaletscaviar_ajouter&action=edit&bien='.$item->bien_id).'">Modifier</a>',
                'delete' => '<a href="'.admin_url('admin.php?page=chaletscaviar_ajouter&action=delete&bien='.$item->bien_id).'">Supprimer</a>'
            ];

            return sprintf('%1$s %2$s', '<strong>'.htmlentities($item->bien_accroche).'</strong> <br> <span class="description">'.htmlentities($item->bien_description).'</span>', $this->row_actions($actions));
        }

    }