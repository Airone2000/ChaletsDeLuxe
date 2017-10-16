<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= get_bloginfo('charset') ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <title><?= get_bloginfo('name') ?></title>
        <?php wp_head() ?>
    </head>

    <body>

        <p class="hide-on-screen">
            <a id="hamburger" href="javascript:;" class="toggle-menu"><i class="icon-menu"></i></a>
            <?= !!LOGO_URI ? '<a href="'.home_url().'"><img id="main-logo-mobile" src="'.LOGO_URI.'" /></a>' : NULL ?>
        </p>

        <div id="level-1">
            <header id="main-header">

                <!-- Close the reponsive menu -->
                <a href="javascript:;" class="toggle-menu"><i class="icon-cancel"></i></a>

                <?= !!LOGO_URI ? '<a href="'.home_url().'"><img id="main-logo" src="'.LOGO_URI.'" /></a>' : NULL ?>
                <h1 id="site-name"><?= get_bloginfo('name') ?></h1>

                <?= wp_nav_menu([
                    'theme_name' => 'Menu principal',
                    'menu_id' => 'menu-nav',
                    'container_id' => 'menu-principal'
                ]) ?>

                <h2 id="head-zocial">Suivez-nous sur</h2>
                <div id="zocial">
                    <a href="https://www.facebook.com/" target="_blank" class="icon-facebook"></a>
                    <a href="https://www.linkedin.com" target="_blank" class="icon-linkedin"></a>
                    <a href="https://plus.google.com" target="_blank" class="icon-gplus"></a>
                    <a href="https://www.youtube.com" target="_blank" class="icon-youtube"></a>
                    <a href="https://twitter.com" target="_blank" class="icon-twitter"></a>
                </div>

            </header>

            <section id="main-section">
