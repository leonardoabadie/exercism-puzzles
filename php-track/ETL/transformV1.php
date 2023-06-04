<?php
function transform(array $legacyData): array {
  $newFormat = [];
  forEach($legacyData as $score => $letters) {
    forEach($letters as $k => $letter) {
      $newFormat[strtolower($letter)] = $score;
    }      
  }
  ksort($newFormat);
  
  return $newFormat;
}
?>
