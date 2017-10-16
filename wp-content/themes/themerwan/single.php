<?php

    get_header();

        while(have_posts())
        {
            the_post();

            # Page back
            $page_back = wp_get_referer() ?? NULL;
            if($page_back)
            {
                $page_back = '<a id="posts-back" href="'.$page_back.'"><i class="icon-left"></i> Retour aux articles</a>';
            }

            # Image
            $image = get_the_post_thumbnail_url() ?? NULL;
            if(!!$image)
            {
                $image = '<div id="post-img"><img src="'.$image.'" /></div>';
            }




            echo '<div id="very-post">';
            echo    $page_back;
            echo    '<h2 id="post-title">'.get_the_title().'</h2>';
            echo    $image;
            echo    '<div id="post-content">'.nl2br(get_the_content()).'</div>';
            echo '</div>';

        }


    get_footer();