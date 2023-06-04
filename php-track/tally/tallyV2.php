<?php
enum Points : int
{
  case Won = 3;
  case Draw =  1;
  case Loss = 0;

  public function getPoints() : int { return $this->value ; }
}

enum MatchResult : string
{
  case Won = "win";
  case Draw = "draw";
  case Loss = "loss";
}

enum TableField : string
{
  case PlayedMatches = "MP";
  case Score = "P";
  case Won = "W";
  case Draw = "D";
  case Loss = "L";

  public function getAbbreviation() : string { return $this->value ; }
}

class Tournament
{
  protected string $scores = "";
  protected array $matches = [];
  protected array $teams = [];
  protected PointsTable $table;

  public function __construct() { $this->table = new PointsTable() ; }

  private function setTeams() : void 
  {
    foreach ($this->matches as $match) {
      [$team1, $team2, $outcome] = explode(';', $match);  // $match ~> 'Team1';'Team2';'Outcome'
      
      $this->teams[$team1] ??= new Team($team1);
      $this->teams[$team2] ??= new Team($team2);

      $this->parseMatch($this->teams[$team1], $this->teams[$team2], $outcome);
    }

    foreach ($this->teams as $name => $team) {
      $team->setPlayedMatches();
      $team->setTotalPoints();
    }
  }
  
  private function setMatches() : void
  {
    $this->matches = explode("\n", $this->scores);  // ("match1\n match2\n match3\n and so on")
  }

  private function createPointsTable() : void
  {
    foreach ($this->teams as $name => $team) {
      $this->table->addRow(
        $team->getName(),
        $team->getPlayed(),
        $team->getWins(),
        $team->getDraws(),
        $team->getLosses(),
        $team->getScore()
      );
    };
  }
  
  private function wins(Team $t1, Team $t2) : void
  {
    $t1->wins();
    $t2->lost();
  }
    
  private function tie(Team $t1, Team $t2) : void
  {   
    $t1->draw();
    $t2->draw();
  }
    
  private function parseMatch(Team $team1, Team $team2, string $outcome) : void
  {
    match ($outcome) {
      MatchResult::Won->value => $this->wins($team1, $team2),
      MatchResult::Draw->value => $this->tie($team1, $team2),
      MatchResult::Loss->value => $this->wins($team2, $team1)
    };
  }

  private function sortTeams() : void 
  {
    usort($this->teams, function(Team $t1, Team $t2){
      return $t1->getScore() === $t2->getScore() ? $t1->getName() <=> $t2->getName() : $t2->getScore() <=> $t1->getScore();
    });
  }
  
  public function tally(string $scores) : string
  {   
    if (!$scores) {
      return $this->table->getHead();
    }
    
    $this->scores = $scores;
    $this->setMatches();
    $this->setTeams();
    $this->sortTeams();
    $this->createPointsTable();
    $this->table->setPointsTable();

    return $this->table->getPointsTable();
  }
}

class PointsTable
{
  protected string $pointsTable = "";
  protected string $head = "";
  protected string $textOffset = "                              ";
  protected array $rows = [];
  protected $matchesField = TableField::PlayedMatches;
  protected $scoreField = TableField::Score;
  protected $wonField = TableField::Won;
  protected $drawField = TableField::Draw;
  protected $lossField = TableField::Loss;

  public function __construct() {
    $this->head = "Team                           | ".$this->matchesField->getAbbreviation()." |  ".$this->wonField->getAbbreviation()." |  ".$this->drawField->getAbbreviation()." |  ".$this->lossField->getAbbreviation()." |  ".$this->scoreField->getAbbreviation(); 
    $this->rows[] = $this->head;    
  }

  public function getPointsTable() : string { return $this->pointsTable ; }
  public function getHead() : string { return $this->head ; }
  
  public function setPointsTable() : void
  {
    $this->pointsTable = implode("\n", $this->rows);
  }
  
  public function addRow(string $name, int $played, int $wins, int $draws, int $losses, int $score) : void 
  {
    $newOffset = str_repeat(" ", strlen($this->textOffset) - strlen($name) + 1);
    $this->rows[] = $name.$newOffset."|  ".$played." |  ".$wins." |  ".$draws." |  ".$losses." |  ".$score;
  }   
}

class Team
{
  protected string $name;
  protected int $played = 0;
  protected int $score = 0;
  protected int $wins = 0;
  protected int $draws = 0;
  protected int $losses = 0;
  protected $won = Points::Won;
  protected $draw = Points::Draw;

  public function __construct($name) { $this->name = $name ; }

  public function getLosses() : int {return $this->losses ; }
  public function getDraws() : int { return $this->draws ; }
  public function getWins() : int { return $this->wins ; }
  public function getPlayed() : int { return $this->played ; }
  public function getScore() : int { return $this->score ; }
  public function getName() : string { return $this->name ; }
  
  public function setPlayedMatches() : void
  {
    $this->played = $this->wins + $this->draws + $this->losses;
  }

  public function setTotalPoints() : void
  {
    $this->score = ($this->wins * $this->won->getPoints()) + ($this->draws * $this->draw->getPoints());
  }
  
  public function wins() : void { $this->wins++ ; }
  public function draw() : void { $this->draws++ ; }
  public function lost() : void { $this->losses++ ; }
}
?>
