<?php

require('Validator.php');
// Post Data
$firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
$lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
$gRadio = isset($_POST['gRadio']) ? $_POST['gRadio'] : '';
$nationality = isset($_POST['nationality']) ? $_POST['nationality'] : '';
$nationalityInput = isset($_POST['nationalityInput']) ? trim($_POST['nationalityInput']) : '';
$occupation = isset($_POST['occupation']) ? trim($_POST['occupation']) : '';
$religion = isset($_POST['religion']) ? trim($_POST['religion']) : '';
$snsUsername = isset($_POST['snsUsername']) ? trim($_POST['snsUsername']) : '';
$jpRadio = isset($_POST['jpRadio']) ? $_POST['jpRadio'] : '';
$region = isset($_POST['region']) ? $_POST['region'] : '';
$dietary = isset($_POST['dietary']) ? trim($_POST['dietary']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$tFirstName = isset($_POST['tFirstName']) ? trim($_POST['tFirstName']) : '';
$tLastName = isset($_POST['tLastName']) ? trim($_POST['tLastName']) : '';
$tDob = isset($_POST['tDob']) ? $_POST['tDob'] : '';
$sgRadio = isset($_POST['sgRadio']) ? $_POST['sgRadio'] : '';
$tNationality = isset($_POST['tNationality']) ? $_POST['tNationality'] : '';
$tNationalityInput = isset($_POST['tNationalityInput']) ? trim($_POST['tNationalityInput']) : '';
$relationship = isset($_POST['relationship']) ? trim($_POST['relationship']) : '';
$tDietary = isset($_POST['tDietary']) ? trim($_POST['tDietary']) : '';
$uploadAvatar = isset($_FILES['uploadAvatar']) ? $_FILES['uploadAvatar'] : '';
$gFirstName = isset($_POST['gFirstName']) ? trim($_POST['gFirstName']) : '';
$gLastName = isset($_POST['gLastName']) ? trim($_POST['gLastName']) : '';
$tPeriod = isset($_POST['tPeriod']) ? $_POST['tPeriod'] : '';
$uVideo = isset($_POST['uVideo']) ? $_POST['uVideo'] : '';
$campaign = isset($_POST['campaign']) ? $_POST['campaign'] : '';
$campaignInput = isset($_POST['campaignInput']) ? trim($_POST['campaignInput']) : '';
$policy = isset($_POST['policy']) ? $_POST['policy'] : '';
// Data
$data = [
    'firstName' => $firstName,
    'lastName' => $lastName,
    'dob' => $dob,
    'gRadio' => $gRadio,
    'nationality' => $nationality,
    'nationalityInput' => $nationalityInput,
    'occupation' => $occupation,
    'religion' => $religion,
    'snsUsername' => $snsUsername,
    'jpRadio' => $jpRadio,
    'region' => $region,
    'dietary' => $dietary,
    'email' => $email,
    'phone' => $phone,
    'tFirstName' => $tFirstName,
    'tLastName' => $tLastName,
    'tDob' => $tDob,
    'sgRadio' => $sgRadio,
    'tNationality' => $tNationality,
    'tNationalityInput' => $tNationalityInput,
    'relationship' => $relationship,
    'tDietary' => $tDietary,
    'uploadAvatar' => $uploadAvatar,
    'gFirstName' => $gFirstName,
    'gLastName' => $gLastName,
    'tPeriod' => $tPeriod,
    'uVideo' => $uVideo,
    'campaign' => $campaign,
    'campaignInput' => $campaignInput,
    'policy' => $policy
];
// Rules
$rules = [
    'firstName' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'lastName' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'dob' => 'required|year|now|ageNotGreaterThan:120',
    'gRadio' => 'required',
    'nationality' => 'required',
    'nationalityInput' => 'nationalityOtherRequired|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'occupation' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'religion' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'snsUsername' => 'required|notContainNumber|lengthNotGreaterThan:128',
    'jpRadio' => 'required',
    'region' => 'regionCheckNotNever',
    'dietary' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'email' => 'required|email',
    'phone' => 'required|phoneNumber|phoneBetween:7,25',
    'tFirstName' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'tLastName' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'tDob' => 'required|year|now|ageNotGreaterThan:120',
    'sgRadio' => 'required',
    'tNationality' => 'required',
    'tNationalityInput' => 'nationalityOtherRequired|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'relationship' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'tDietary' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'uploadAvatar' => 'required|fileSize:5|image:jpeg,jpg,png,svg,gif,webp',
    'gFirstName' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'gLastName' => 'required|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'tPeriod' => 'required',
    'uVideo' => 'required',
    'campaign' => 'required',
    'campaignInput' => 'campaignOtherRequired|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'policy' => 'required'
];
$customMessages = [];
$validator = new Validator($data, $rules, $customMessages);
if ($validator->validate()) {
    $_SESSION['confirm'] = true;
    // Store and save image with name
    $avatar = $data['uploadAvatar'];
    $avatarName = time() . $avatar['name'];
    $avatarTmpname = $avatar['tmp_name'];
    $avatarPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/' . $avatarName;
    move_uploaded_file($avatarTmpname, $avatarPath);
    // Store image name only on data
    $data['uploadAvatar'] = $avatarName;
    $_SESSION['data'] = json_encode($data);
    // Go to confirm page
    $router->redirect('/confirm');
} else {
    // Store Data in session
    $_SESSION['data'] = json_encode($data);
    $errors = $validator->errors();
    $_SESSION['data'] = json_encode($data);
    $_SESSION['errors'] = json_encode($errors);
    // print_r($errors);
    $router->redirect('/');
}
