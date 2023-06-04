<?php
function checkUppercase($t): bool {
  return (
    strlen($t) - similar_text($t, mb_strtolower($t)) >= 1 && !ctype_upper($t)
  ) ? true : false;
}

function checkSubTerms(string $term): string{
  $term = preg_replace('/[^\p{L}\-]/u','', $term);
  
  if (str_contains($term, "-")) {
    return "-";
  }
  if (checkUppercase(mb_substr($term, 1))) {
    return "upper";
  }
  
  return "";
}

function getSubTerms($t, $d): string{
  switch ($d) {
    case "-":
      return implode(array_map(
        fn($tmp_t): string => mb_substr($tmp_t, 0, 1) , explode("-", $t)
      ));            
    case "upper":
      return implode(array_filter(
        str_split($t), function($char) {return ctype_upper($char);}
      ));
  }
}

function acronym(string $text): string {
  if (!str_contains($text, " ")) {
    return "";
  }
  
  $tla = "";
  forEach(explode(" ", $text) as $term) {
    $delimiter = checkSubTerms($term);
    if ($delimiter) {
      $tla .= getSubTerms($term, $delimiter);          
      continue;
    }
 
    $tla .= mb_substr($term, 0, 1);
  }
 
 return mb_strtoupper($tla);
}
?>
