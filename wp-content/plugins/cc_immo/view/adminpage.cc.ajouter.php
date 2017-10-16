<?php

    # Ajout ou modif
    $bien = biens::bien($_REQUEST['bien'] ?? NULL);
    $edition = !!$bien;

    $removing = ($_GET['action'] ?? NULL)  == 'delete' && !!$bien;
    if($removing)
    {
        biens::remove($bien->bien_id);
        echo '<script>';
        echo 'window.location.href = "'.admin_url('admin.php?page=chaletscaviar').'" ;';
        echo '</script>';
        exit;
    }


    # Traitement du formulaire si envoyé

    if( 'POST' === $_SERVER['REQUEST_METHOD'] )
    {

        $nouveau_bien = $_POST['cc'] ?? $bien ?? [];
        $accroche = false;
        $prix = false;
        $mandat = false;
        $image = false;
        $erreur = false;

        # Vérifications sommaires
        array_walk($nouveau_bien, function(&$val, $key, $check){

            switch($key)
            {
                case 'bien_prix':
                    $val = (int)$val;
                    $check['prix'] = $val > 0;

                    if(!$check['prix'])
                        echo '<div class="error notice">'.__("Prix obligatoire").'</div>';

                    break;

                case 'bien_accroche':
                    $val = trim($val);
                    $length = strlen($val);
                    $check['accroche'] = ($length > 0 && $length <= 100);

                    if(!$check['accroche'])
                        echo '<div class="error notice">'.__("Titre obligatoire").'</div>';

                    break;

                case 'bien_mandat':
                    $check['mandat'] = array_key_exists($val, inputs::mandat(inputs::TO_ARRAY));

                    if(!$check['mandat'])
                        echo '<div class="error notice">'.__("Type de mandat obligatoire").'</div>';

                    break;
            }
        }, [
            'accroche' => &$accroche,
            'mandat' => &$mandat,
            'prix' => &$prix
        ]);

        # Ajout image
        if($_FILES['cc_bien_image'] ?? false)
        {
            $inputs = wp_handle_upload($_FILES['cc_bien_image'], ['test_form' => false]);
            if(!!$inputs && !empty($inputs['url'])){
                $img_uri = $inputs['url'];
                $nouveau_bien['bien_image'] = $img_uri;
                $image = true;
            }
            else{
                if($edition)
                {
                    $nouveau_bien['bien_image'] = $bien->bien_image;
                    $image = true;
                }
                else
                {
                    echo '<div class="error notice">'.__("Image obligatoire").'</div>';
                }
            }
        }

        # Insertion
        if($accroche && $prix && $mandat && $image && !$erreur)
        {
            if($edition)
            {
                biens::modifier($bien->bien_id, $nouveau_bien);
            }
            else biens::sauver($nouveau_bien);

            echo '<script>';
            echo 'window.location.href = "'.admin_url('admin.php?page=chaletscaviar').'" ;';
            echo '</script>';
            exit;
        }
    }


?>



<div class="wrap">
    <h1><?= !$edition ? get_admin_page_title() : __('Modifier un bien') ?></h1>
    <p><?= !$edition ? "Ajouter un bien à votre collection" : "Vous modifiez un bien" ?></p>

    <form method="post" enctype="multipart/form-data">
        <table class="form-table">
            <tbody>
                <tr>
                    <td colspan="3"> <hr /></td>
                </tr>

                <tr class="form-field form-required">
                    <th scope="row">Accroche <span class="description">(obligatoire)</span></th>
                    <td><?= inputs::accroche($bien->bien_accroche ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr class="form-field">
                    <th>Description</th>
                    <td><?= inputs::description($bien->bien_description ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr class="form-field form-required">
                    <th scope="row">Illustration <span class="description">(obligatoire)</span></th>
                    <td><?= inputs::image($bien->bien_image ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr class="form-field form-required">
                    <th>Mandat <span class="description">(obligatoire)</span></th>
                    <td><?= inputs::mandat(0, $bien->bien_mandat ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="3"> <hr /></td>
                </tr>

                <tr class="form-field">
                    <th>Etat</th>
                    <td><?= inputs::etat(0, $bien->bien_etat ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="3"> <hr /></td>
                </tr>

                <tr class="form-field form-required">
                    <th>Prix <span class="description">(obligatoire)</span></th>
                    <td><?= inputs::prix($bien->bien_prix ?? NULL) ?></td>
                    <td>EUR</td>
                </tr>

                <tr class="form-field">
                    <th>Frais d'agence</th>
                    <td><?= inputs::frais_agence($bien->bien_frais_agence ?? NULL) ?></td>
                    <td>%</td>
                </tr>

                <tr>
                    <td colspan="3"> <hr /></td>
                </tr>

                <tr class="form-field">
                    <th>Adresse</th>
                    <td><?= inputs::adresse(0, $bien->bien_adresse ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr class="form-field">
                    <th>Ville</th>
                    <td><?= inputs::ville(0, $bien->bien_ville ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr class="form-field">
                    <th>Pays</th>
                    <td><?= inputs::pays(0, $bien->bien_pays ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr class="form-field">
                    <th>Exposition</th>
                    <td><?= inputs::exposition(0, $bien->bien_exposition ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="3"> <hr /></td>
                </tr>

                <tr class="form-field">
                    <th>Transports</th>
                    <td><?= inputs::transport(0, $bien->bien_transport ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr class="form-field">
                    <th>Commerces</th>
                    <td><?= inputs::commerce(0, $bien->bien_commerce ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="3"> <hr /></td>
                </tr>

                <tr class="form-field">
                    <th>Cuisine</th>
                    <td><?= inputs::cuisine(0, $bien->bien_cuisine ?? NULL) ?></td>
                    <td></td>
                </tr>

                <tr class="form-field">
                    <th>Nombre de chambres</th>
                    <td><?= inputs::chambre($bien->bien_chambre ?? NULL) ?></td>
                    <td></td>
                </tr>

            </tbody>
        </table>

        <?= get_submit_button('Ajouter') ?>
    </form>

</div>