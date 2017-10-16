<?php

    class inputs
    {
        const TO_ARRAY = true;
        const INPUTS = [
            'bien_id' => 'Référence',
            'bien_accroche' => 'Accroche',
            'bien_description' => 'Description',
            'bien_prix' => 'Prix',
            'bien_chambre' => 'Nombre de chambres',
            'bien_frais_agence' => 'Frais agence',
            'bien_mandat' => 'Type de mandat',
            'bien_adresse' => 'Rue',
            'bien_ville' => 'Ville',
            'bien_pays' => 'Pays',
            'bien_transport' => 'Transport',
            'bien_commerce' => 'Commerce',
            'bien_etat' => 'Etat',
            'bien_cuisine' => 'Type de cuisine',
            'bien_exposition' => 'Exposition',
            'bien_image' => 'Image principale'
        ];

        const INPUTS_DERIVES = [
            'keyword' => 'Mot clé',
            'bien_prix_min' => 'Prix Mini',
            'bien_prix_max' => 'Prix Maxi',
            'bien_frais_agence_min' => 'Prix Mini',
            'bien_frais_agence_max' => 'Prix Maxi',
            'bien_chambre_min' => 'Nombre de chambres (Mini)',
            'bien_chambre_max' => 'Nombre de chambres (Maxi)'
        ];

        public static function image($value = null)
        {
            $img = null;
            if(!!$value)
            {
                $img = '<img style="width:200px;" src="'.$value.'" /> <br />';
            }


            return $img . '<input type="file" name="cc_bien_image" />';
        }

        public static function accroche($value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_accroche'] ?? $_SESSION['cc']['bien_accroche'] ?? NULL;
            return '<input value="'.$value.'" type="text" name="cc[bien_accroche]" maxlength="100" />';
        }

        public static function description($value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_description'] ?? $_SESSION['cc']['bien_description'] ?? NULL;
            return '<textarea name="cc[bien_description]">'.$value.'</textarea>';
        }

        public static function prix($value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_prix'] ?? $_SESSION['cc']['bien_prix'] ?? NULL;
            return '<input value="'.$value.'" type="number" name="cc[bien_prix]" min="0" />';
        }

        public static function chambre($value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_chambre'] ?? $_SESSION['cc']['bien_chambre'] ?? NULL;
            return '<input value="'.$value.'" type="number" name="cc[bien_chambre]" min="0" />';
        }

        public static function frais_agence($value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_frais_agence'] ?? $_SESSION['cc']['bien_frais_agence'] ?? NULL;
            return '<input value="'.$value.'" type="number" name="cc[bien_frais_agence]" min="0" max="100" />';
        }

        public static function mandat($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_mandat'] ?? $_SESSION['cc']['bien_mandat'] ?? NULL;
            $mandats = ['1' => 'Vente', '2' => 'Location'];

            if($to_array) return $mandats;
            else
            {
                $output = '<select name="cc[bien_mandat]"><option></option>%s</select>';
                array_walk($mandats, function(&$val, $key, $value){
                  $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $mandats));
            }
        }

        public static function adresse($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_adresse'] ?? $_SESSION['cc']['bien_adresse'] ?? NULL;
            $arr = [
                '1' => 'Rue de Siam',
                '2' => 'Rue Bonaparte',
                '3' => 'Rue Jean Jaurès',
                '4' => 'Rue Yann Dargent',
                '5' => 'Avenue Arsène Tournay',
                '6' => 'Rue Nanon',
                '7' => 'Autre (voir description)'
            ];

            if($to_array) return $arr;
            else
            {
                $output = '<select name="cc[bien_adresse]"><option></option>%s</select>';
                array_walk($arr, function(&$val, $key, $value){
                    $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $arr));
            }
        }

        public static function ville($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_ville'] ?? $_SESSION['cc']['bien_ville'] ?? NULL;
            $arr = [
                '1' => 'Brest',
                '2' => 'Haguenau',
                '3' => 'Namur',
                '4' => 'Paris',
                '5' => 'Montréal',
                '6' => 'Autre (voir description)'
            ];

            if($to_array) return $arr;
            else
            {
                $output = '<select name="cc[bien_ville]"><option></option>%s</select>';
                array_walk($arr, function(&$val, $key, $value){
                    $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $arr));
            }
        }

        public static function pays($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_pays'] ?? $_SESSION['cc']['bien_pays'] ?? NULL;
            $arr = [
                '1' => 'France',
                '2' => 'Belgique',
                '3' => 'Allemagne',
                '4' => 'Luxembourg',
                '5' => 'Autre (voir description)'
            ];

            if($to_array) return $arr;
            else
            {
                $output = '<select name="cc[bien_pays]"><option></option>%s</select>';
                array_walk($arr, function(&$val, $key, $value){
                    $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $arr));
            }
        }

        public static function transport($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_transport'] ?? $_SESSION['cc']['bien_transport'] ?? NULL;
            $arr = [
                '1' => 'Oui',
                '2' => 'Non',
                '3' => 'Précisions (voir description)'
            ];

            if($to_array) return $arr;
            else
            {
                $output = '<select name="cc[bien_transport]"><option></option>%s</select>';
                array_walk($arr, function(&$val, $key, $value){
                    $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $arr));
            }
        }

        public static function commerce($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_commerce'] ?? $_SESSION['cc']['bien_commerce'] ?? NULL;
            $arr = [
                '1' => 'Oui',
                '2' => 'Non',
                '3' => 'Précisions (voir description)'
            ];

            if($to_array) return $arr;
            else
            {
                $output = '<select name="cc[bien_commerce]"><option></option>%s</select>';
                array_walk($arr, function(&$val, $key, $value){
                    $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $arr));
            }
        }

        public static function etat($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_etat'] ?? $_SESSION['cc']['bien_etat'] ?? NULL;
            $arr = [
                '1' => 'Neuf',
                '2' => 'Ancien',
                '3' => 'Rénové',
                '4' => 'Autre (voir description)'
            ];

            if($to_array) return $arr;
            else
            {
                $output = '<select name="cc[bien_etat]"><option></option>%s</select>';
                array_walk($arr, function(&$val, $key, $value){
                    $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $arr));
            }
        }

        public static function cuisine($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_cuisine'] ?? $_SESSION['cc']['bien_cuisine'] ?? NULL;
            $arr = [
                '1' => 'Américaine super-équipée',
                '2' => 'En U',
                '3' => 'En L',
                '4' => 'Inexistante',
                '5' => 'Autre (voir description)'
            ];

            if($to_array) return $arr;
            else
            {
                $output = '<select name="cc[bien_cuisine]"><option></option>%s</select>';
                array_walk($arr, function(&$val, $key, $value){
                    $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $arr));
            }
        }

        public static function exposition($to_array = false, $value = null)
        {
            $value = $value ?? $_REQUEST['cc']['bien_exposition'] ?? $_SESSION['cc']['bien_exposition'] ?? NULL;
            $arr = [
                '1' => 'Nord',
                '2' => 'Est',
                '3' => 'Ouest',
                '4' => 'Sud',
                '5' => 'Autre (voir description)'
            ];

            if($to_array) return $arr;
            else
            {
                $output = '<select name="cc[bien_exposition]"><option></option>%s</select>';
                array_walk($arr, function(&$val, $key, $value){
                    $val = "<option ".($value == $key ? "selected" : null)." value='$key'>$val</option>";
                }, $value);

                return sprintf($output, implode('', $arr));
            }
        }
    }