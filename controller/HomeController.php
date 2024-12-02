<?php

// Connect to db
require('./../config/DB.php');

class HomeController {
    public function index()
    {
        include VIEW . 'index.php';
    }
    public function create($router)
    {
        include VALIDATOR . 'CreateFormRequest.php';
    }
    public function store($router)
    {
        // Change data storage format and Store on database
        $data = json_decode($_SESSION['data']);
        $kyushuDb = [
            'main' => [
                'firstName' => prepareToStore($data->firstName),
                'lastName' => prepareToStore($data->lastName),
                'dob' => prepareToStore($data->dob),
                'gRadio' => prepareToStore($data->gRadio),
                'nationality' => $data->nationality === 'singaporean' ? prepareToStore($data->nationality) : prepareToStore($data->nationalityInput),
                'occupation' => prepareToStore($data->occupation),
                'religion' => prepareToStore($data->religion),
                'snsUsername' => prepareToStore($data->snsUsername),
                'jpRadio' => prepareToStore($data->jpRadio),
                'region' => $data->region ? normalize($data->region): '',
                'dietary' => prepareToStore($data->dietary),
                'email' => prepareToStore($data->email),
                'phone' => prepareToStore($data->phone),
            ],
            'pt1' => [
                'tFirstName' => prepareToStore($data->tFirstName),
                'tLastName' => prepareToStore($data->tLastName),
                'tDob' => prepareToStore($data->tDob),
                'sgRadio' => prepareToStore($data->sgRadio),
                'tNationality' => $data->tNationality === 'singaporean' ? prepareToStore($data->tNationality) : prepareToStore($data->tNationalityInput),
                'relationship' => prepareToStore($data->relationship),
                'tDietary' => prepareToStore($data->tDietary),
                'uploadAvatar' => $data->uploadAvatar,
            ],
            'pt2' => [
                'gFirstName' => prepareToStore($data->gFirstName),
                'gLastName' => prepareToStore($data->gLastName),
                'tPeriod' => $data->tPeriod ? normalize($data->tPeriod) : '',
                'uVideo' => $data->uVideo ? 'Uploaded' : 'Not Uploaded',
                'campaign' => $data->campaign ? array_map(function($item) use ($data) {
                    return $item === 'other' ? prepareToStore($data->campaignInput) : prepareToStore($item);
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
    }
    public function confirm($router) 
    {
        include VIEW . 'confirms/index.php';
        // Not allow user to enter without form submit
        if(!$_SESSION['confirm']) {
            $router->redirect('/');
        }
    }
    public function complete()
    {
        include VIEW . 'complete.php';
    }
}