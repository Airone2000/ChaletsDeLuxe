<?php

        if(is_year())
            get_template_part('date/year');

        if(is_month())
            get_template_part('date/month');

        if(is_day())
            get_template_part('date/day');
