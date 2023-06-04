<?php
class Tournament
{
  public function __construct() {}

  private function mergePointsTable(string $header, array $body) : string 
  {
    $completePointsTable = $header;
    $bodySize  = count($body);
        
    for ($i = 0; $i < $bodySize; $i++) {
      $completePointsTable .= $body[$i];
      if (!($i === $bodySize - 1)) {
        $completePointsTable .= "\n";    
      }
    }
    
    return $completePointsTable;
  }

  private function sortByChar(array $finalPointsTable) : array 
  {
    $lastIndex = count($finalPointsTable) - 1;
    for ($i = 0; $i < $lastIndex; $i++) {
      for ($j = $i + 1; $j < $lastIndex + 1; $j++) {
        $points = [$finalPointsTable[$i][-1], $finalPointsTable[$j][-1]];
              
        if (($points[0] === $points[1]) && ($finalPointsTable[$i] > $finalPointsTable[$j])) {
          $tmp = $finalPointsTable[$i];
          $finalPointsTable[$i] = $finalPointsTable[$j];
          $finalPointsTable[$j] = $tmp;
        }
      }
    }

    return $finalPointsTable;
  }

  private function sortByPoints(array $finalPointsTable) : array 
  {
    $lastIndex = count($finalPointsTable) - 1;
    for ($i = 0; $i < $lastIndex; $i++) {
      for ($j = $i + 1; $j < $lastIndex + 1; $j++) {
        $points = [$finalPointsTable[$i][-1], $finalPointsTable[$j][-1]];
            
        if (($points[0] < $points[1])) {
          $tmp = $finalPointsTable[$i];
          $finalPointsTable[$i] = $finalPointsTable[$j];
          $finalPointsTable[$j] = $tmp;
        }
      }
    }

    return $finalPointsTable;
  }

  private function sortPointsTable(array $table) : array
  {
    $finalPointsTable = [];
    $space = "                               ";

    foreach ($table as $team => $value) {
      $spaceLen = strlen($space) - strlen($table[$team]["T"]);
      $finalPointsTable[] = "{$table[$team]['T']}" . str_repeat(" ", $spaceLen) . "|  {$table[$team]['MP']} |  {$table[$team]['W']} |  {$table[$team]['D']} |  {$table[$team]['L']} |  {$table[$team]['P']}";
    }

    $finalPointsTable = $this->sortByPoints($finalPointsTable);
    $finalPointsTable = $this->sortByChar($finalPointsTable);

    return $finalPointsTable;
  }

  private function setPointsTable(array $matches, array $teams) : array 
  {
    $pt = []; // points table

    // filling the points table array
    foreach ($teams as $team) {
      $pt[$team] = ["T" => $team, "MP" => 0, "W" => 0, "D" => 0, "L" => 0, "P" => 0];
    };

    // getting the results of matches
    foreach ($matches as $match) {
      $teams_result = explode(";", $match);
      $resultOfMatch = $teams_result[2];
      $team1 = $teams_result[0];
      $team2 = $teams_result[1];

      $pt[$team1]["MP"]++;
      $pt[$team2]["MP"]++;

      if ($resultOfMatch === "win") {
        $pt[$team1]["W"]++;
        $pt[$team1]["P"] += 3;
        $pt[$team2]["L"]++;

      } else if ($resultOfMatch === "draw") {
        $pt[$team1]["D"]++;
        $pt[$team1]["P"]++;
        $pt[$team2]["D"]++;
        $pt[$team2]["P"]++;

      } else {
        $pt[$team2]["W"]++;
        $pt[$team2]["P"] += 3;
        $pt[$team1]["L"]++;
      }
    };

    return $pt;
  }

  private function getTeams(array $matches) : array
  {
    $teams = [];
    foreach ($matches as $match) {
      $t = explode(";", $match, -1); // teams...

      if (!(in_array($t[0], $teams))) {
        $teams[] = $t[0];
      }

      if (!(in_array($t[1], $teams))) {
        $teams[] = $t[1];
      }
    }

    return $teams;
  }

  private function getMatches(string $scores) : array 
  {
    return explode("\n", $scores);
  } 

  private function noTeams(string $scores) : bool
  {
    return strlen($scores) === 0;
  }

  public function tally(string $scores) : string 
  {
    if ($this->noTeams($scores)) {
      return "Team                           | MP |  W |  D |  L |  P";
    }

    $pointsTableHeader = "Team                           | MP |  W |  D |  L |  P\n";

    $matches = $this->getMatches($scores);
    $teams = $this->getTeams($matches);
    $pointsTable = $this->setPointsTable($matches, $teams);
    $pointsTable = $this->sortPointsTable($pointsTable, $pointsTableHeader);
    $result = $this->mergePointsTable($pointsTableHeader, $pointsTable);

    return $result;
  }
}
?>
