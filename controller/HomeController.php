<?php

// Connect to ApplicantForm
require('./../config/ApplicantForm.php');
require(VALIDATOR . 'Validator.php');
class HomeController {
    public function index()
    {
        include VIEW . 'index.php';
    }
    /**
     * create go to request
     */
    public function create($router)
    {
        include REQUEST . 'createFormRequest.php';
    }
    /**
     * Store data to the database
     */
    public function store($router)
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] === 'store')
        {
            // Change data storage format and Store on database
            $data = json_decode($_SESSION['data']);
            $kyushuDb = [
                'main' => [
                    'firstName' => $data->firstName,
                    'lastName' => $data->lastName,
                    'dob' => $data->dob,
                    'gRadio' => $data->gRadio,
                    'nationality' => $data->nationality === 'singaporean' ? $data->nationality : $data->nationalityInput,
                    'occupation' => $data->occupation,
                    'religion' => $data->religion,
                    'snsUsername' => $data->snsUsername,
                    'jpRadio' => $data->jpRadio,
                    'region' => $data->region ? $data->region : '',
                    'dietary' => $data->dietary,
                    'email' => $data->email,
                    'phone' => $data->phone,
                ],
                'pt1' => [
                    'tFirstName' => $data->tFirstName,
                    'tLastName' => $data->tLastName,
                    'tDob' => $data->tDob,
                    'sgRadio' => $data->sgRadio,
                    'tNationality' => $data->tNationality === 'singaporean' ? $data->tNationality : $data->tNationalityInput,
                    'relationship' => $data->relationship,
                    'tDietary' => $data->tDietary,
                    'uploadAvatar' => $data->uploadAvatar,
                ],
                'pt2' => [
                    'gFirstName' => $data->gFirstName,
                    'gLastName' => $data->gLastName,
                    'tPeriod' => $data->tPeriod ? $data->tPeriod : '',
                    'uVideo' => $data->uVideo ? 'Uploaded' : 'Not Uploaded',
                    'campaign' => $data->campaign ? array_map(function($item) use ($data) {
                        return $item === 'other' ? $data->campaignInput : $item;
                    }, $data->campaign): ''
                ]
            ];
            $kyushuJson = json_encode($kyushuDb);
            $db = new ApplicantForm();
            $result = $db->insert($kyushuJson);
            if($result) {
                unset($_SESSION['data']);
                $_SESSION['confirm'] = 'store';
                $router->redirect('/complete');
            }
        }
    }
    /**
     * not allow to enter without confirm = create and data
     */
    public function confirm($router) 
    {
        if(!(isset($_SESSION['confirm']) && $_SESSION['confirm'] === 'create' && isset($_SESSION['data']) && $_SESSION['data'])) {
            $router->redirect('/');
        }
        include VIEW . 'confirms/index.php';
    }
    /**
     *not allow to enter without confirm and data 
     */
    public function complete($router)
    {
         // not allow to enter without confirm and data 
         if(!($_SESSION['confirm'] && $_SESSION['confirm'] === 'store')) {
            $router->redirect('/');
        }
        include VIEW . 'complete.php';
    }
}