<?php

function palindrome($word, $reverse)
{
    return $word == strrev($reverse) ? "Pogi" : "pangit";
}

echo palindrome("pogi", "igop");

?>