<?php
function squareOfSum(int $max): int
{
  $r = 0;
  for ($i = 1; $i <= $max; $i++) {
    $r += $i;
  }
  
  return $r ** 2;
}

function sumOfSquares(int $max): int
{
  $r = 0;
  for ($i = 1; $i <= $max; $i++) {
    $r += $i ** 2;
  }
  
  return $r;
}

function difference(int $max): int
{
  return abs(squareOfSum($max) - sumOfSquares($max));
}
