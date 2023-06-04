<?php
class School {
  public $grades = [];

  public function add(string $name, int $grade): void {
    if (!in_array($grade, array_keys($this->grades))){
      $this->grades[$grade] = new Grade();
    }
   
    $this->grades[$grade]->setStudent($name);
  }
  
  public function grade(int $grade) {
    if (!in_array($grade, array_keys($this->grades))){
      return;
    }
 
    return $this->grades[$grade]->getStudents();
  }

  public function studentsByGradeAlphabetical(): array {
    $allStudents = [];
    ksort($this->grades);
    foreach($this->grades as $grade => $grade_obj) {
      $allStudents[$grade] = $this->grade($grade);
    }
    
    return $allStudents;
  }
}

class Grade {
  public $students = [];

  public function setStudent($student): void {
    $this->students[] = $student;
  }
  
  public function getStudents(): array {
    sort($this->students);
    return $this->students;
  }
}
?>
