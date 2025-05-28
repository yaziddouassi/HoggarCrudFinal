<?php

namespace Hoggarcrud\Hoggar\Utils;
use Illuminate\Support\Str;

class TransformString
{

public function transformDatabase($input) {
    $result = Str::snake(Str::plural($input));

    return $result;
    }

public function transformLink($input) {
    $words = Str::of($input)->snake(' ');

    // Step 2: Capitalize each word
    $capitalized = Str::title($words);

    // Step 3: Pluralize the last word
    $wordsArray = explode(' ', $capitalized);
    $lastWord = array_pop($wordsArray);
    $pluralizedLastWord = Str::plural($lastWord);

    // Step 4: Reassemble the words
    $wordsArray[] = $pluralizedLastWord;
    return implode(' ', $wordsArray);

}


public function transformUrl($input) {
    
   $result = Str::plural(Str::kebab($input));

   return $result;

}
    


}