<?php

    class biens
    {
        public static function sauver($data)
        {
            global $wpdb;
            $wpdb->insert(CC_TABLE_BIENS, $data);
            return true;
        }

        public static function bien($id = null)
        {
            $bien_id = $id ?? $_GET['bien'] ?? NULL;

            if(!!$bien_id)
            {
                global $wpdb;
                $bien_id = (int)$bien_id;
                return $wpdb->get_row('SELECT * FROM '.CC_TABLE_BIENS.' WHERE bien_id = "'.$bien_id.'"');
            }

            return [];
        }

        public static function remove($id)
        {
            global $wpdb;
            $wpdb->delete(CC_TABLE_BIENS, [
                'bien_id' => $id
            ]);

            return true;
        }

        public static function modifier($id, $data)
        {
            global $wpdb;
            $wpdb->update(CC_TABLE_BIENS, $data, [
                'bien_id' => $id
            ]);
            return true;
        }

        public static function liste($criteres = [])
        {
            global $wpdb;

            $q = 'SELECT * FROM '.CC_TABLE_BIENS . ' WHERE 1 ';
            $w = []; $v = [];

            $criteres = array_filter($criteres);

            array_walk($criteres, function($val, $field, $comp){

                switch($field)
                {
                    case 'keyword':
                        $comp['w'][] = '(bien_accroche LIKE %s OR bien_description LIKE %s)';
                        $comp['v'][] = '%'.trim($val).'%';
                        $comp['v'][] = '%'.trim($val).'%';
                        break;

                    case 'bien_prix_min':
                    case 'bien_frais_agence_min':
                    case 'bien_chambre_min':
                        $field = explode('_', $field);
                        unset($field[count($field) - 1]);
                        $field = implode('_', $field);

                        $comp['w'][] = $field.' >= %s';
                        $comp['v'][] = $val;

                        break;

                    case 'bien_prix_max':
                    case 'bien_frais_agence_max':
                    case 'bien_chambre_max':
                        $field = explode('_', $field);
                        unset($field[count($field) - 1]);
                        $field = implode('_', $field);

                        $comp['w'][] = $field.' <= %s';
                        $comp['v'][] = $val;

                        break;

                    case 'bien_accroche':
                        $comp['w'][] = $field.' LIKE %s ';
                        $comp['v'][] = "%$val%";
                        break;

                    default:
                        $comp['w'][] = $field.' = %s';
                        $comp['v'][] = $val;
                }


            }, ['w' => &$w, 'v' => &$v]);

            $w = implode(' AND ', $w);
            $q = implode(' AND ', array_filter([$q, $w]));

            $cols = inputs::INPUTS;

            $orderby = $_REQUEST['orderby'] ?? 'bien_id';
            $order = $_REQUEST['order'] ?? 'asc';
            $order = array_key_exists($orderby, $cols) && in_array($order, ['asc', 'desc']) ? " ORDER BY $orderby $order " : NULL;
            $q .= $order;

            $limit = $_REQUEST['nb'] ?? 0;
            $limit = (int)$limit;
            $q .= ($limit > 0) ? ' LIMIT '.$limit : NULL;

            if(!!$v) $q = $wpdb->prepare($q, $v);

            $biens = $wpdb->get_results($q);
            return $biens;
        }

    }