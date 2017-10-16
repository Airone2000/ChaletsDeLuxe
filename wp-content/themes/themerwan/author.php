<?php

    $userID = get_queried_object()->data->ID;
    get_template_part('authors/default', $userID);