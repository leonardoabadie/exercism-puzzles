<?php
class Game {
  public $frames = [];
  public $additionalThrows = [];
  public $shots = 0;
  public $tot_shots = 0;
  public $jumpFrame = false;

  public function checkInvalidCases($pins=0, $case="") : void {
    if ($pins < 0 || $pins > 10) {
      throw new Exception();
    }
    if (count($this->frames) === 10 && end($this->frames)->remainThrows === 0 && $case != "score") {
      throw new Exception();
    }
    if (count($this->frames) === 0 && $case === "score") {
      throw new Exception();
    }
    if (count($this->frames) === 10 && end($this->frames)->remainThrows > 0 && $case === "score" && end($this->frames)->scoring >= 10) {
      throw new Exception();
    }
  }

  public function checkRemainingFrames($pins) : void {
    if (!$this->additionalThrows) {
      return;
    }
    
    if ($this->additionalThrows[0]->remainThrows === 0) {
      array_shift($this->additionalThrows);
    }

    forEach($this->additionalThrows as $frame) {
      if ($frame === end($this->frames)) { 
        break; 
      }
      $frame->knockDown($pins);
    }
  }

  public function checkSpecialFrame() : void {
    if (end($this->frames)->status != "open" && end($this->frames) != "fill_ball") {
      $this->additionalThrows[] = end($this->frames);
      $this->jumpFrame = true;
    }   
  }

  public function score() : int {
    $this->checkInvalidCases(0, "score");
    $score = array_sum(array_map(fn($f): int => $f->scoring, $this->frames));
      
    if ($score === 0 && $this->tot_shots < 20) {
      throw new Exception();
    }
     
    return $score;
  }

  public function roll(int $pins) : void {
    $this->checkInvalidCases($pins);
    
    if (($this->shots % 2 === 0 || $this->jumpFrame) && count($this->frames) < 10) {
      $this->frames[] = new Frame(); 
      if (count($this->frames) === 10) {
        end($this->frames)->status = "fill_ball";
        end($this->frames)->remainThrows = 3;
      }            
    
      $this->jumpFrame = false;
      $this->shots = 0;
    }
   
    end($this->frames)->knockDown($pins);
    $this->checkSpecialFrame();
    $this->checkRemaningFrames($pins);
    $this->shots++;
    $this->tot_shots++;
  }
}

class Frame {
  public $scoring = 0;
  public $remainThrows = 2;
  public $status = "open";

  public function knockDown($points) : void {
    if ($this->scoring < 10 && $this->remainThrows === 1 && $this->status === "fill_ball") { 
      throw new Exception();
    }

    $this->scoring += $points;
    if ($this->scoring === 10 && $this->remainThrows <= 2 && $this->status != "fill_ball") {
      $this->remainThrows = $this->remainThrows === 2 ? 2 : 1;
      $this->status = $this->remainThrows === 2 ? "strike" : "spare";
      
      return;
    }
     
    $this->remainThrows--;
    if ($this->remainThrows === 0 && $this->scoring > 10 && $this->status === "open" || $this->remainThrows === 0 && $this->status === "fill_ball" && $this->scoring - 10 > 10 && $points < 10) {
      throw new Exception();
    }
  }
}
