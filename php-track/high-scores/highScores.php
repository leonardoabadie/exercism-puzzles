<?php
class HighScores
{
  public $scores;
  public $personalTopThree;
  public $personalBest;
  public $latest;
  public $orderedScores;

  public function __construct(array $scores)
  {
    $this->scores = $scores;
    $this->sortScores();
    $this->getHighestScores();
    $this->personalBest = $this->orderedScores[0];
    $this->latest = end($scores);
  }

  private function sortScores() 
  {
    $this->orderedScores = $this->scores;
    usort($this->orderedScores, function($a, $b) {
      return $a < $b;
    });
    
    return;
  }

  private function getHighestScores()
  {
    $length = count($this->scores);
    for ($i = 0; $i < $length; $i++) {
      if ($i > 2) {
        break;
      }
      $this->personalTopThree[] = $this->orderedScores[$i];
    }
    
    return;
  }
}
?>
