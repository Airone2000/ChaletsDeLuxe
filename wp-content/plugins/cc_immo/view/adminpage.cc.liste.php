<?php

    $liste = new cc_table_biens();
    $liste->prepare_items();

?>

<div class="wrap">
    <h1><?= get_admin_page_title() ?> <a href="<?= admin_url('admin.php?page=chaletscaviar_ajouter') ?>" class="page-title-action">Ajouter</a></h1>
    <p>Gérer l'ensemble de vos biens.</p>

    <?php
        $liste->display();
    ?>

    <br>
    <hr />
    <p><strong>Page modifiable - Nous contacter pour plus d'info.</strong></p>

</div>
