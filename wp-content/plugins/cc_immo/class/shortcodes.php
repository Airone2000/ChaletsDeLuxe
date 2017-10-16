<?php


class shortcodes
{

    public static function get_contact_form($atts, $content)
    {
        $destinataire = get_bloginfo('admin_email');
        $expediteur = $_REQUEST['cc_contact_form_exp'] ?? NULL;
        $objet = $_REQUEST['cc_contact_form_obj'] ?? NULL;
        $message = $_REQUEST['cc_contact_form_msg'] ?? NULL;
        $redirect_uri = $_REQUEST['cc_redirect_for_contact'] ?? site_url();
        $output = null;
        $sent = false;

        $bien_id_ref = $_REQUEST['cc_reference_for_contact'] ?? NULL;
        if(!!$bien_id_ref)
        {
            $bien = biens::bien($bien_id_ref);
            if(!!$bien)
            {
                $objet = $objet ?? "Intérêt pour le bien #{$bien->bien_id}";
                $rn = "&#13;&#10;";
                $message = $message ?? "Bonjour Monsieur Erwan,{$rn}{$rn}Ce bien m'intéresse. Merci de prendre contact avec moi.{$rn}{$rn}A vous lire bientôt,{$rn}[NOM PRENOM]";
            }
        }

        # Expédier le mail
        if($_REQUEST['cc_contact_form_submit'] ?? NULL)
        {
            if(filter_var($expediteur, FILTER_VALIDATE_EMAIL))
            {
                if(!!trim($message))
                {
                    $message .= "\r\n\r\nRépondre à $expediteur";
                    $objet = trim($objet);
                    $destinataire = 'maels1991@gmail.com';
                    wp_mail($destinataire, $objet, $message, [
                        'from: Chalets et Caviar <contact@erwanguillou.com>'
                    ]);

                    $sent = true;
                }
            }
        }

        if(!$sent) {
            ob_start(); ?>

            <div id="cc-form-contact">
                <h2>Contacter <strong>Chalets & Caviar</strong></h2>
                <h3>Par téléphone</h3>
                <p class="by-phone">
                    <img src="http://vignette4.wikia.nocookie.net/uncyclopedia/images/b/b1/Call_centre_girl.png/revision/latest?cb=20100330043716" />
                    Noisette donne suite à vos appels <br> Du Lundi au Vendredi <br> De 9 heures à Midi <br> Au <a href="tel:0001234567890">+01 234 567 890</a> (Gratuit)
                </p>

                <h3>Par mail</h3>
                <form method="post">
                    <p>
                        <label>
                            <span>Votre adresse e-mail (obligatoire) :</span>
                            <input type="email" name="cc_contact_form_exp" value="<?= $expediteur ?>" required placeholder="Ex: nom@domaine" autofocus />
                        </label>
                    </p>

                    <p>
                        <label>
                            <span>Objet :</span>
                            <input type="text" name="cc_contact_form_obj" value="<?= $objet ?>" placeholder="Ex: Meilleurs voeux !"/>
                        </label>
                    </p>

                    <p>
                        <label>
                            <span>Votre message :</span>
                            <textarea name="cc_contact_form_msg" required><?= $message ?></textarea>
                        </label>
                    </p>

                    <input type="hidden" name="cc_redirect_for_contact" value="<?= $redirect_uri ?>" />
                    <input type="hidden" name="cc_reference_for_contact" value="<?= $bien_id_ref ?>" />
                    <input type="submit" name="cc_contact_form_submit" value="Expédier"/>
                </form>
            </div>
            <?php
        }
        else { ?>

            <div id="body" class="cc-contact-form">
            <div id="message-sent">
                <h2>Nous avons bien reçu votre message</h2>
                <p>Un collaborateur y donnera suite sous peu.</p>
                <p><a href='<?= $redirect_uri ?>'><?= !!$bien_id_ref ? 'Retour sur la fiche du bien' : 'Retour à l\'accueil' ?></a></p>
            </div>
            </div>

        <?php }
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public static function get_immovable($atts, $content)
    {
        global $wpdb;
        $output = null;
        $hasard = ($atts['random'] ?? false) == 'true';
        $bien_id = $atts['id'] ?? get_query_var('page') ?? null;
        $bien_id = (int)$bien_id;

        if($hasard && !$bien_id)
        {
            $q = $wpdb->get_results('SELECT bien_id FROM '.CC_TABLE_BIENS.' ORDER BY RAND() LIMIT 1');
            $bien_id = $q[0]->bien_id;
            $referer = site_url();
        }
        else
        {
            $referer = (wp_get_referer() ? wp_get_referer().'#bien-'.$bien_id : site_url());
        }


        $labels = inputs::INPUTS;

        if($bien_id > 0)
        {
            $bien = biens::bien($bien_id);
            if(!!$bien)
            {
                ob_start(); ?>

                    <div class="immovable-left">
                        <a href="<?= $referer ?>"><button><i class="icon-left"></i> Retour</button></a>
                        <img src="<?= $bien->bien_image ?>" />
                    </div>

                    <div class="immovable-right">
                        <h2><?= $bien->bien_accroche ?></h2>
                        <table>
                            <tbody>
                                <?php
                                    foreach($bien AS $key => $val)
                                    {
                                        if(in_array($key, ['bien_accroche', 'bien_image'])) continue;

                                            # Construire les valeurs
                                            switch($key)
                                            {
                                                case 'bien_prix':
                                                    $val = trim($val);
                                                    $val = $val == 0 ? 'Gratuit' : number_format($val, '00', ',', ' ').' €';
                                                    break;

                                                case 'bien_mandat':
                                                case 'bien_etat':
                                                    $method = substr($key, strpos($key, '_') + 1);
                                                    $values = call_user_func([inputs::class, $method], inputs::TO_ARRAY);
                                                    $val = $values[$val] ?? NULL;
                                                    break;
                                            }

                                            if(!!$val)
                                            {
                                                echo '<tr>';
                                                echo    '<th>'.$labels[$key].'</th>';
                                                echo    '<td>'.$val.'</td>';
                                                echo '</tr>';
                                            }
                                    }
                                ?>
                                <tr class="contact">
                                    <th><i class="icon-heart"></i> Vous aimez ?</th>
                                    <td>
                                        <form action="<?= site_url('contacter-notre-agence') ?>" method="post">
                                            <input type="hidden" name="cc_redirect_for_contact" value="<?= get_the_permalink() . $bien->bien_id ?>" />
                                            <input type="hidden" name="cc_reference_for_contact" value="<?= $bien->bien_id ?>" />
                                            <button type="submit">Contacter un conseiller</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                <?php $output = ob_get_contents();
                ob_end_clean();
            }
        }

        return $output;
    }

    public static function search_engine($atts, $content)
    {

        $mandat = $atts['default-mandat'] ?? NULL;

        ob_start(); ?>

        <form id="search-engine" method="post">
            <p class="cc-search-keyword">
                <label>
                    <span>Mot-clé : </span>
                   <input type="text" name="cc[keyword]" autocomplete="off" value="<?= trim($_REQUEST['cc']['keyword'] ?? $_SESSION['cc']['keyword'] ?? NULL) ?? NULL ?>" />
                </label>
            </p>

            <?php
                $inputs_existant = inputs::INPUTS;
                # Mon ordre
                $inputs = ['bien_mandat', 'bien_etat', 'bien_prix', 'bien_frais_agence', 'bien_adresse', 'bien_ville', 'bien_pays', 'bien_exposition', 'bien_transport', 'bien_commerce', 'bien_cuisine', 'bien_chambre'];
                $inputs = array_intersect_key(array_flip($inputs), $inputs_existant);
                $inputs = array_flip($inputs);

                foreach($inputs AS $input)
                {
                    switch($input)
                    {
                        case 'bien_image':
                        case 'bien_accroche':
                        case 'bien_description':
                            continue;
                            break;

                        case 'bien_mandat':
                            echo '<p style="display:none;"><label>' . $inputs_existant[$input];
                            echo inputs::mandat(false, $mandat);
                            echo '</label></p>';
                            break;

                        case 'bien_prix':
                        case 'bien_chambre':
                        case 'bien_frais_agence':

                            $value_min = $_REQUEST['cc']["{$input}_min"] ?? $_SESSION['cc']["{$input}_min"] ?? NULL;
                            $value_max = $_REQUEST['cc']["{$input}_max"] ?? $_SESSION['cc']["{$input}_max"] ?? NULL;

                            echo '<p class="cc-search-'.$input.'"><label><span>' . $inputs_existant[$input] .' : </span>';
                            echo '<input type="number" name="cc['.$input.'_min]" placeholder="Mini" value="'.$value_min.'" />';
                            echo '<input type="number" name="cc['.$input.'_max]" placeholder="Maxi" value="'.$value_max.'" />';
                            echo '</label></p>';
                            break;

                        default:
                            $method = substr($input, strpos($input, '_') + 1);
                            if(method_exists('inputs', $method))
                            {
                                echo '<p class="cc-search-'.$input.'">';
                                echo    '<label><span>';
                                echo        $inputs_existant[$input] .' : </span> '. call_user_func([inputs::class, $method]);
                                echo    '</label>';
                                echo '</p>';
                            }
                    }
                }
            ?>


            <input type="submit" value="Trouver" />

        </form>


        <?php $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * @param $atts
     * @param $content
     * @return string
     */
    public static function immovables_list($atts, $content)
    {
        $atts = array_filter((array)$atts);
        $searchable = ($atts['searchable'] ?? FALSE) == 'true';
        $identifiant = $atts['identifiant'] ?? NULL;
        $text_alt = $atts['alt'] ?? NULL;

        # Filtre depuis atts (défini explicitement = Prioritaire)
        $inputs = inputs::INPUTS;
        $criteres_bien = [];
        foreach($atts AS $key => $value)
        {
            if(array_key_exists($key, $inputs))
            {
                $criteres_bien[$key] = $value;
            }
            else
            {
                $_REQUEST[$key] = $value;
            }
        }
        $atts = $criteres_bien;

        # Filtre depuis recherche (défini par le client)
        $criteres_bien = [];
        $inputs_derives = inputs::INPUTS_DERIVES;
        if($searchable)
        {
            foreach(($_REQUEST['cc'] ?? []) AS $key => $value)
            {
                if(array_key_exists($key, $inputs) || array_key_exists($key, $inputs_derives))
                {
                    $criteres_bien[$key] = $value;
                }
            }

            $atts = array_merge(($_SESSION['cc'] ?? []), $criteres_bien, $atts);
            $_SESSION['cc'] = $atts;
        }


        $output = [];
        $biens = biens::liste($atts);
        $nb = 0;

        foreach($biens AS $bien)
        {
            ob_start(); ?>

            <a id="bien-<?= $bien->bien_id ?>" href="<?= site_url('bien/'.$bien->bien_id) ?>">
                <li style="background-image:url(<?= $bien->bien_image ?>)">
                    <h3><?= number_format($bien->bien_prix, '00', ',', ' ') ?> €</h3>
                    <h2><?= htmlentities($bien->bien_accroche) ?></h2>
                </li>
            </a>


            <?php $html = ob_get_contents(); ob_end_clean();
            $output[] = $html;
            $nb++;
        }

        return '<ul id="'.$identifiant.'" class="liste-biens">' . ($nb > 0 ? join("", $output) : '<li class="text-alt">'.$text_alt.'</li>') . '</ul>';
    }
}