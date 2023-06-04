<?php
class Robot
{
  public array $position;
  public string $direction;
  const DIRECTION_NORTH = "NORTH";
  const DIRECTION_EAST = "EAST";
  const DIRECTION_SOUTH = "SOUTH";
  const DIRECTION_WEST = "WEST";
  const ADVANCE = "A";
  const TURN_LEFT = "L";
  const TURN_RIGHT = "R";
  
  public function __construct(array $position, string $direction)
  {
    $this->position = $position;
    $this->direction = $direction;
  }
  
  public function instructions(string $commands) : self
  {
    foreach (str_split($commands) as $command) {
      $this->executeCommand($command);
    };
    
    return $this;
  }

  private function executeCommand($command) 
  {
    match ($command) {
      self::ADVANCE => $this->advance(),
      self::TURN_LEFT => $this->turnLeft(),
      self::TURN_RIGHT => $this->turnRight(),
      default => throw new \InvalidArgumentException()
    };
  }
  
  public function turnRight(): self
  {
    match ($this->direction) {
      self::DIRECTION_NORTH => $this->direction = self::DIRECTION_EAST,
      self::DIRECTION_EAST => $this->direction = self::DIRECTION_SOUTH,
      self::DIRECTION_SOUTH => $this->direction = self::DIRECTION_WEST,
      self::DIRECTION_WEST => $this->direction = self::DIRECTION_NORTH
    };
    
    return $this;
  }

  public function turnLeft(): self
  {
    match ($this->direction) {
      self::DIRECTION_NORTH => $this->direction = self::DIRECTION_WEST,
      self::DIRECTION_EAST => $this->direction = self::DIRECTION_NORTH,
      self::DIRECTION_SOUTH => $this->direction = self::DIRECTION_EAST,
      self::DIRECTION_WEST => $this->direction = self::DIRECTION_SOUTH
    };
    
    return $this;
  }
  
  public function advance(): self
  {
    match ($this->direction) {
      self::DIRECTION_NORTH => $this->incrementY(),
      self::DIRECTION_EAST => $this->incrementX(),
      self::DIRECTION_SOUTH => $this->decrementY(),
      self::DIRECTION_WEST => $this->decrementX()
    };
    
    return $this;
  }
  
  private function incrementX() : void {$this->position[0]++;}
  private function decrementX() : void {$this->position[0]--;}
  private function incrementY() : void {$this->position[1]++;}
  private function decrementY() : void {$this->position[1]--;}
}
