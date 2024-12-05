<?php

// Connect to db
require('./../config/DB.php');

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