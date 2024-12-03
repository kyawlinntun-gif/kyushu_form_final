<?php
// Connect to Db
require('./../config/DB.php');
// Change data storage format and Store on database
$data = json_decode($_SESSION['data']);

$kyushuDb = [
    'main' => [
        'firstName' => htmlspecialchars($data->firstName, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'lastName' => htmlspecialchars($data->lastName, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'dob' => htmlspecialchars($data->dob, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'gRadio' => htmlspecialchars($data->gRadio, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'nationality' => $data->nationality === 'singaporean' ? htmlspecialchars($data->nationality, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5) : htmlspecialchars($data->nationalityInput, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'occupation' => htmlspecialchars($data->occupation, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'religion' => htmlspecialchars($data->religion, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'snsUsername' => htmlspecialchars($data->snsUsername, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'jpRadio' => htmlspecialchars($data->jpRadio, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'region' => $data->region ? array_map(function($item) {
            return htmlspecialchars($item, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
        }, $data->region) : '',
        'dietary' => htmlspecialchars($data->dietary, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'email' => htmlspecialchars($data->email, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'phone' => htmlspecialchars($data->phone, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
    ],
    'pt1' => [
        'tFirstName' => htmlspecialchars($data->tFirstName, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'tLastName' => htmlspecialchars($data->tLastName, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'tDob' => htmlspecialchars($data->tDob, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'sgRadio' => htmlspecialchars($data->sgRadio, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'tNationality' => $data->tNationality === 'singaporean' ? htmlspecialchars($data->tNationality, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5) : htmlspecialchars($data->tNationalityInput, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'relationship' => htmlspecialchars($data->relationship, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'tDietary' => htmlspecialchars($data->tDietary, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'uploadAvatar' => $data->uploadAvatar,
    ],
    'pt2' => [
        'gFirstName' => htmlspecialchars($data->gFirstName, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'gLastName' => htmlspecialchars($data->gLastName, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5),
        'tPeriod' => $data->tPeriod ? array_map(function($item) {
            return htmlspecialchars($item, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
        }, $data->tPeriod) : '',
        'uVideo' => $data->uVideo ? 'Uploaded' : 'Not Uploaded',
        'campaign' => $data->campaign ? array_map(function($item) use ($data) {
            return $item === 'other' ? htmlspecialchars($data->campaignInput, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5) : htmlspecialchars($item, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
        }, $data->campaign): ''
    ]
];
$kyushuJson = json_encode($kyushuDb);

$db = new DB();
$result = $db->insert('users_table', ['user_id' => 1, 'user_data' => $kyushuJson, 'flag' => 1]);

if($result) {
    unset($_SESSION['data']);
    unset($_SESSION['confirm']);
    $router->redirect('/complete');
}


function prepareToSore($input){
  return   htmlspecialchars(preg_replace('/\s+/', ' ', $input), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
}

function normalize($input){
    if(is_array($input)){
        return array_map('prepareToSore',$input);
    }else{
        return prepareToSore($input);
    }
}