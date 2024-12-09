<?php
// Post Data
// List of expected POST fields
$postFields = [
    'firstName', 'lastName', 'dob', 'gRadio', 'nationality', 'nationalityInput',
    'occupation', 'religion', 'snsUsername', 'jpRadio', 'region', 'dietary',
    'email', 'phone', 'tFirstName', 'tLastName', 'tDob', 'sgRadio', 'tNationality',
    'tNationalityInput', 'relationship', 'tDietary', 'gFirstName', 'gLastName',
    'tPeriod', 'uVideo', 'campaign', 'campaignInput', 'policy'
];
// Data
// Initialize data array and sanitize fields
$data = [];
// Loop through each expected POST field
foreach ($postFields as $field) {
    if (isset($_POST[$field])) {
        if (is_array($_POST[$field])) {
            // If the value is an array, sanitize each element if it's not empty
            $data[$field] = !empty($_POST[$field]) ? array_map('htmlspecialchars', $_POST[$field], array_fill(0, count($_POST[$field]), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5)) : [];
        } else {
            // If the value is a string, sanitize it
            $data[$field] = htmlspecialchars($_POST[$field], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
        }
    } else {
        // Default to an empty string for undefined fields
        $data[$field] = '';
    }
}
// Handle file upload
$data['uploadAvatar'] = isset($_FILES['uploadAvatar']) ? $_FILES['uploadAvatar'] : '';
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
