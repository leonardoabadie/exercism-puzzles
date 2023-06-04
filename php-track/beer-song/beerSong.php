<?php
class BeerSong {
  public function calcBottles(int $b, $minusOne = false): string {
    $b = $minusOne ? $b - 1 : $b;
    
    return $b > 1 ? 's' : '';
  }
  
  public function verse(int $b): string {
    if ($b == 0):    
      return "No more bottles of beer on the wall, no more bottles of beer.\nGo to the store and buy some more, 99 bottles of beer on the wall.";            
    endif;
    
    $t1 = $this->calcBottles($b);
    $t2 = $this->calcBottles($b, true);
    $takeBottleDown = $b == 1 ? "it" : "one";
    $remainVerse = $b - 1 > 0 ? $b-1 . " bottle$t2 of beer on the wall.\n" : "no more bottles of beer on the wall.\n";
    
    return "{$b} bottle{$t1} of beer on the wall, {$b} bottle{$t1} of beer.\n" . "Take " . $takeBottleDown . " down and pass it around, " . $remainVerse;
  }
  
  public function verses(int $stB, int $lastB): string {
    $verses = [];
    for ($b = $stB; $b >= $lastB; $b--):
      $verses[] = $this->verse($b);
    endfor;
    
    return implode("\n", $verses);
  }
  
  public function lyrics(): string {
    return $this->verses(99, 0);
  }
}
?>
