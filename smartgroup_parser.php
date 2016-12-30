<?php
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

$email = '45john45@dumasisd.org';//Email id based on google group

//Check field into parser based on json operator value
condition_parser($email, $json);

function condition_parser($field, $json)
{
	$conditions = json_decode(utf8_encode($json), true);
	echo "<pre>";
	print_r($conditions);
	echo '</pre>';
	if(array_key_exists('condition', $conditions)) {
		$arrRes = [];
		foreach($conditions['rules'] as $index => $rule) {
				switch($rule['id'])
				{
						case 'email_value':
							//$equation .= '&& ends_with($email,$rule["value"])';
							//$equation .= '&& contains($email,$rule["value"])';
							//$equation .= '&& contains("18john@dumasisd.org",$value3)';
							//eval('$result = '.$equation.';');
							if($rule['operator'] == 'begins_with'){
								$arrRes[$index] =  starts_with($field, $rule['value']);
							}
							if($rule['operator'] == 'contains'){
								$arrRes[$index] = contains($field, $rule['value']);
							}
							if($rule['operator'] == 'ends_with'){
								$arrRes[$index] = ends_with($field, $rule['value']);
							}
						break;
				}
		}
		print_r($arrRes);
		if(in_array(0, $arrRes)){
			echo 'FALSE';
		}else{
			echo 'TRUE';
			}
		}
}

function contains($field, $value) {
  return preg_match("/$value/", $field);
}
function starts_with($field, $value) {
	return preg_match("/^$value/", $field);
 }
function ends_with($field, $value) {
	 return preg_match("/$value$/", $field);
 }
