<?php
function encode($t) {
  $plain = "abcdefghijklmnopqrstuvwxyz";
  $cipher = strrev($plain);
  $encoded = [];
  $result = [];
  $partialCode = "";    
  
  foreach (str_split($t) as $c) {
    if (is_numeric($c)) {
      $encoded[] = $c;
    } else if (in_array(strtolower($c), str_split($plain))) {
      $encoded[] = $cipher[array_search(strtolower($c), str_split($plain))];
    } else {
      $encoded[] = '';
    }
  };

  foreach($encoded as $c) {
    if ($partialCode && (strlen($partialCode) % 5 === 0)) {
      $result[] = $partialCode;
      $partialCode = "";
    }
    $partialCode .= $c;
  };
  $result[] = $partialCode;

  return trim(implode(' ', $result));
}
