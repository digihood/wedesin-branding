<?php 

//return english 
function is_eng_wds( ) {
    $lang = get_bloginfo('language');
    if ( $lang == "en-GB" || $lang == "en-US" || $lang == "en-AU" || $lang == "en-CA" || $lang == "en-NZ" || $lang == "en-ZA" ) {
        return true;
    } else {
        return false;
    }
}