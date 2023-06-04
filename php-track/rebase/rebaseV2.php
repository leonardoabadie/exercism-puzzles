<?php
function convertToDecimal(array $digits, int $from): array {
  $number = 0;
  foreach(array_reverse($digits) as $power => $digit) {
    $number += $digit * ($from**$power);
  }
  
  return array_map(fn($d): int => intval($d), str_split(strval($number)));
}

function convertDecimalTo(array $digits, int $base): array {
  $sequence = [];
  $q = intval(implode(array_map(fn($d): string => strval($d), $digits)));
  do {
    array_unshift($sequence, $q % $base);
    $q = intdiv($q, $base);
  } while ($q > 0);
  
  return $sequence;
}

function checkInvalidCase(array $digits, int $from, int $to): bool {
  return (!$digits || array_sum($digits)==0 || $digits[0]==0) || ($from < 2 || $to < 2 || min($digits) < 0 || max($digits) >= $from) ? true : false; 
}

function rebase(int $initialBase, array $digits, int $finalBase) {
  if (checkInvalidCase($digits, $initialBase, $finalBase)) return null; 

  return convertDecimalTo(convertToDecimal($digits, $initialBase), $finalBase);  
}
?>
