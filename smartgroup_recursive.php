<?php
function condition_parser($query) {
$condition = $query['condition'];
$j=0;
$statement ="(";
foreach ($query['rules'] as $rule) {
if ($j>0) $statement .=  " $condition ";
if ($rule['id']) {
$statement .=  $rule['field'];
$statement .=  " ";
$statement .=  $rule['operator'];
$statement .=  " ";
$statement .=  $rule['value'];
}
else if ($rule['rules']) {
$statement .= condition_parser($rule);
}


$j++;
}
$statement .= ")";
return $statement;


}


 $json='{
  "condition": "AND",
  "rules": [
    {
      "id": "email_value",
      "field": "email_value",
      "type": "string",
      "input": "text",
      "operator": "contains",
      "value": "45"
    },
{
      "id": "email_value",
      "field": "email_value",
      "type": "string",
      "input": "text",
      "operator": "begins_with",
      "value": "45"
    },
{
      "id": "email_value",
      "field": "email_value",
      "type": "string",
      "input": "text",
      "operator": "ends_with",
      "value": "org"
    }


  ]
}';


$json2 = '{
  "condition": "AND",
  "rules": [
    {
      "id": "name",
      "field": "name",
      "type": "string",
      "input": "text",
      "operator": "contains",
      "value": "smith"
    },
    {
      "condition": "OR",
      "rules": [
        {
          "id": "name",
          "field": "name",
          "type": "string",
          "input": "text",
          "operator": "contains",
          "value": "mary"
        },
        {
          "id": "name",
          "field": "name",
          "type": "string",
          "input": "text",
          "operator": "contains",
          "value": "barber"
        }
      ]
    }
  ]
}';


$email = '45john45@dumasisd.org';//Email id based on google group


//Check field into parser based on json operator value
$query = json_decode(utf8_encode($json), true);


$str = condition_parser( $query);


echo "final: $str \n";




function contains($field, $value) {
  return preg_match("/$value/", $field);
}
function starts_with($field, $value) {
return preg_match("/^$value/", $field);
 }
function ends_with($field, $value) {
return preg_match("/$value$/", $field);
 }


