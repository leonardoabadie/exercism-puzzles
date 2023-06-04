<?php
// pure ENUM
enum Direction
{
  case NORTH;
  case EAST;
  case SOUTH;
  case WEST;
}

// backed ENUMs
enum PossibleMovement : string 
{
  case Advance = "A";
  case Left = "L";
  case Right = "R";
  
  public function getMovement() : string {return $this->value;}
}

enum Clockwise : string 
{
  case NORTH = "EAST";
  case EAST = "SOUTH";
  case SOUTH = "WEST";
  case WEST = "NORTH";

  public function getDirection() : string {return $this->name;}
  public function getNewDirection() : string {return $this->value;}
}

enum CounterClockwise : string
{
  case NORTH = "WEST";
  case EAST = "NORTH";
  case SOUTH = "EAST";
  case WEST = "SOUTH";

  public function getDirection() : string {return $this->name;}
  public function getNewDirection() : string {return $this->value;}
}

class Robot
{
  public array $position;
  public string $direction;
  public string $instructions;
  public const DIRECTION_NORTH = "NORTH";
  public const DIRECTION_WEST = "WEST";
  public const DIRECTION_SOUTH = "SOUTH";
  public const DIRECTION_EAST = "EAST";

  public function __construct(array $position, string $direction)
  {
    $this->position = $position;
    $this->direction = $direction;
  }

  public function instructions(string $steps) : self
  {
    $this->setInstructions($steps);
    $this->newPosition();
    
    return $this;
  }

  private function newPosition() : void
  {
    for ($i = 0; $i < strlen($this->instructions); $i++) {
      match($this->instructions[$i]) {
        PossibleMovement::Advance->getMovement() => $this->advance(),
        PossibleMovement::Left->getMovement() => $this->turnLeft(),
        PossibleMovement::Right->getMovement() => $this->turnRight()
      };
    }
  }

	// clockwise
	public function turnRight() : self
	{
		match($this->direction) {
			Clockwise::NORTH->getDirection() => $this->direction = Clockwise::NORTH->getNewDirection(),
			Clockwise::WEST->getDirection() => $this->direction = Clockwise::WEST->getNewDirection(),
			Clockwise::SOUTH->getDirection() => $this->direction = Clockwise::SOUTH->getNewDirection(),
			Clockwise::EAST->getDirection() => $this->direction = Clockwise::EAST->getNewDirection()
		};
		
    return $this;
	}
	
  // counterclockwise
  public function turnLeft(): self
  {
    match ($this->direction) {
      CounterClockwise::NORTH->getDirection() => $this->direction = CounterClockwise::NORTH->getNewDirection(),
      CounterClockwise::WEST->getDirection() => $this->direction = CounterClockwise::WEST->getNewDirection(),
      CounterClockwise::SOUTH->getDirection() => $this->direction = CounterClockwise::SOUTH->getNewDirection(),
      CounterClockwise::EAST->getDirection() => $this->direction = CounterClockwise::EAST->getNewDirection()
    };

    return $this;
  }

  public function advance(): self
  {
    match ($this->direction) {
      Direction::NORTH->name => $this->incrementY(),
      Direction::EAST->name => $this->incrementX(),
      Direction::SOUTH->name => $this->decrementY(),
      Direction::WEST->name => $this->decrementX()
    };

    return $this;
  }

  private function incrementX() : void {$this->position[0]++;}
  private function decrementX() : void {$this->position[0]--;}
  private function incrementY() : void {$this->position[1]++;}
  private function decrementY() : void {$this->position[1]--;}

  private function setInstructions($s) : void
  {
    for($i = 0; $i < strlen($s); $i++) {
      if (!($s[$i]==PossibleMovement::Advance->getMovement()) && !($s[$i]==PossibleMovement::Left->getMovement()) && !($s[$i]==PossibleMovement::Right->getMovement())) {
        throw new InvalidArgumentException();
      }
      
      $this->instructions = $s;
    }
  }
}
