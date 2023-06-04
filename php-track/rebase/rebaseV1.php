<?php
function convertToStr($d) {return strval($d);}
function convertDigit($d) {return intval($d);}

function convertToDecimal(array $digits, int $from): array {
  $number = $i = 0;
  for ($p=count($digits)-1; $p >= 0; $p--):
    $number += $digits[$i] * ($from**$p);
    $i++;
  endfor;
  
  return array_map('convertDigit', str_split(strval($number)));
}

function convertDecimalTo(array $digits, int $base): array {
  $sequence = [];
  $number = intval(implode(array_map('convertToStr', $digits)));
  $q = intdiv($number, $base);
 
  while ($q > 0):
    array_unshift($sequence, $number % $base);
    $number = $q;
    $q = intdiv($number, $base);
  endwhile;
  array_unshift($sequence, $number % $base);

  return $sequence;
}

function checkDecimalBase(array $digits, int $from, int $to): array {
  return $from == 10 ? convertDecimalTo($digits, $to) : convertToDecimal($digits, $from);
}

function checkInvalidCase(array $digits, int $from, int $to): bool {
  if (count($digits)==0 || array_sum($digits)==0) return true;
  else if ($digits[0]==0) return true;
  else if ($from == 0 || $from == 1 || $from < 0) return true;
  else if ($to == 0 || $to == 1 || $to < 0) return true;
  else if (array_filter($digits, function($digit) {return $digit < 0;})) return true;
  else if (array_filter($digits, function($digit) use($from) {return $digit >= $from;})) return true;
  
  return false;
}

function rebase(int $initialBase, array $digits, int $finalBase) {
  if (checkInvalidCase($digits, $initialBase, $finalBase)) return null; 
  if ($initialBase == 10 || $finalBase == 10) return checkDecimalBase($digits, $initialBase, $finalBase);
  
  return convertDecimalTo(convertToDecimal($digits, $initialBase), $finalBase);  
}
?>
