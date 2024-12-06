<?php
// Post Data
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
$gRadio = isset($_POST['gRadio']) ? $_POST['gRadio'] : '';
$nationality = isset($_POST['nationality']) ? $_POST['nationality'] : '';
$nationalityInput = isset($_POST['nationalityInput']) ? $_POST['nationalityInput'] : '';
$occupation = isset($_POST['occupation']) ? $_POST['occupation'] : '';
$religion = isset($_POST['religion']) ? $_POST['religion'] : '';
$snsUsername = isset($_POST['snsUsername']) ? $_POST['snsUsername'] : '';
$jpRadio = isset($_POST['jpRadio']) ? $_POST['jpRadio'] : '';
$region = isset($_POST['region']) ? $_POST['region'] : '';
$dietary = isset($_POST['dietary']) ? $_POST['dietary'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$tFirstName = isset($_POST['tFirstName']) ? $_POST['tFirstName'] : '';
$tLastName = isset($_POST['tLastName']) ? $_POST['tLastName'] : '';
$tDob = isset($_POST['tDob']) ? $_POST['tDob'] : '';
$sgRadio = isset($_POST['sgRadio']) ? $_POST['sgRadio'] : '';
$tNationality = isset($_POST['tNationality']) ? $_POST['tNationality'] : '';
$tNationalityInput = isset($_POST['tNationalityInput']) ? $_POST['tNationalityInput'] : '';
$relationship = isset($_POST['relationship']) ? $_POST['relationship'] : '';
$tDietary = isset($_POST['tDietary']) ? $_POST['tDietary'] : '';
$uploadAvatar = isset($_FILES['uploadAvatar']) ? $_FILES['uploadAvatar'] : '';
$gFirstName = isset($_POST['gFirstName']) ? $_POST['gFirstName'] : '';
$gLastName = isset($_POST['gLastName']) ? $_POST['gLastName'] : '';
$tPeriod = isset($_POST['tPeriod']) ? $_POST['tPeriod'] : '';
$uVideo = isset($_POST['uVideo']) ? $_POST['uVideo'] : '';
$campaign = isset($_POST['campaign']) ? $_POST['campaign'] : '';
$campaignInput = isset($_POST['campaignInput']) ? $_POST['campaignInput'] : '';
$policy = isset($_POST['policy']) ? $_POST['policy'] : '';

// Data
$data = [
    'firstName' => htmlspecialchars($firstName),
    'lastName' => htmlspecialchars($lastName),
    'dob' => htmlspecialchars($dob),
    'gRadio' => htmlspecialchars($gRadio),
    'nationality' => htmlspecialchars($nationality),
    'nationalityInput' => htmlspecialchars($nationalityInput),
    'occupation' => htmlspecialchars($occupation),
    'religion' => htmlspecialchars($religion),
    'snsUsername' => htmlspecialchars($snsUsername),
    // 'snsUsername' => sanitize_js_input($snsUsername),
    'jpRadio' => htmlspecialchars($jpRadio),
    'region' => $region,
    'dietary' => htmlspecialchars($dietary),
    'email' => htmlspecialchars($email),
    'phone' => htmlspecialchars($phone),
    'tFirstName' => htmlspecialchars($tFirstName),
    'tLastName' => htmlspecialchars($tLastName),
    'tDob' => htmlspecialchars($tDob),
    'sgRadio' => htmlspecialchars($sgRadio),
    'tNationality' => htmlspecialchars($tNationality),
    'tNationalityInput' => htmlspecialchars($tNationalityInput),
    'relationship' => htmlspecialchars($relationship),
    'tDietary' => htmlspecialchars($tDietary),
    'uploadAvatar' => $uploadAvatar,
    'gFirstName' => htmlspecialchars($gFirstName),
    'gLastName' => htmlspecialchars($gLastName),
    'tPeriod' => $tPeriod,
    'uVideo' => htmlspecialchars($uVideo),
    'campaign' => $campaign,
    'campaignInput' => htmlspecialchars($campaignInput),
    'policy' => htmlspecialchars($policy)
];
// Rules
$rules = [
    'firstName' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'lastName' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'dob' => 'required|year|now|ageNotGreaterThan:120',
    'gRadio' => 'required',
    'nationality' => 'required',
    'nationalityInput' => 'nationalityOtherRequired|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'occupation' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'religion' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'snsUsername' => 'required|notNumber|notContainNumber|lengthNotGreaterThan:128',
    'jpRadio' => 'required',
    'region' => 'regionCheckNotNever',
    'dietary' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'email' => 'required|email',
    'phone' => 'required|phoneNumber|phoneBetween:7,25',
    'tFirstName' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'tLastName' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'tDob' => 'required|year|now|ageNotGreaterThan:120',
    'sgRadio' => 'required',
    'tNationality' => 'required',
    'tNationalityInput' => 'nationalityOtherRequired|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'relationship' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'tDietary' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:400',
    'uploadAvatar' => 'required|fileSize:5|image:jpeg,jpg,svg,gif,webp,png',
    'gFirstName' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'gLastName' => 'required|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'tPeriod' => 'required',
    'uVideo' => 'required',
    'campaign' => 'required',
    'campaignInput' => 'campaignOtherRequired|notNumber|notContainNumber|specialCharacter|lengthNotGreaterThan:128',
    'policy' => 'required'
];
$customMessages = [];
$validator = new Validator($data, $rules, $customMessages);
if ($validator->validate()) {
    $_SESSION['confirm'] = 'create';
    // Store and save image with name
    $avatar = $data['uploadAvatar'];
    $avatarName = time() . $avatar['name'];
    $avatarTmpname = $avatar['tmp_name'];
    $avatarPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/upload/' . $avatarName;
    move_uploaded_file($avatarTmpname, $avatarPath);
    // Store image name only on data
    $data['uploadAvatar'] = $avatarName;
    $_SESSION['data'] = json_encode($data);
    // Go to confirm page
    $router->redirect('/confirm');
} else {
    // Store Data in session
    $errors = $validator->errors();
    $_SESSION['data'] = json_encode($data);
    $_SESSION['errors'] = json_encode($errors);
    $router->redirect('/');
}
