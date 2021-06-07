<?php

function getMenuActive($patterns, $activeClass = "active")
{
    if (url_is('*administrator/' . $patterns)) {
        return $activeClass;
    }
}