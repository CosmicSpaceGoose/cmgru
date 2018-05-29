<?php
function pdoSet($allowed, &$values, $source = array()) {
  $set = '';
  $values = array();
  if (!$source) $source = &$_POST;
  foreach ($allowed as $field) {
    if (isset($source[$field])) {
      $set.="`".str_replace("`","``",$field)."`". "=:$field, ";
      $values[$field] = $source[$field];
    }
  }
  return substr($set, 0, -2); 
}

$allowed = array("name","surname","email");
echo "SET\n";
echo pdoSet($allowed, $values,  array('lol'=>"KEK",'surname'=>"BOBIKOFF",'email'=>"bobkin@mail.com"))."\n";
echo "VALUES\n";
print_r($values);
?>
