<?php

    # All is done !
    $category_nicename = get_queried_object()->category_nicename;
    get_template_part('categories/default', $category_nicename);
