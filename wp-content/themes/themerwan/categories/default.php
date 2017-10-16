<?php

        get_header();

            echo '<ul id="liste-posts">';
                while(have_posts())
                {
                    the_post();

                    $image = get_the_post_thumbnail_url();
                    if(!!$image)
                    {
                        $image = '<img src="'.$image.'" />';
                    }
                    else $image = null;

                    echo '<li>';
                    echo    '<h2 class="head-post">'.get_the_title().'</h2>';
                    echo    $image;
                    echo    '<p class="excerpt-post">'.get_the_excerpt().'</p>';
                    echo    '<p class="foot-post"><span>Publié le '.get_the_date().'</span> <a class="btn-read" href="'.get_the_permalink().'">Lire</a></p>';
                    echo '</li>';
                }

            echo '</ul>';

        get_footer();