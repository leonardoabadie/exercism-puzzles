<?php
function transform(array $ipt): array {
  $ans = [];
  forEach($ipt as $k => $v) {
    $ans += array_fill_keys($v, $k);
  }
  
  return array_change_key_case($ans);
}
?>
