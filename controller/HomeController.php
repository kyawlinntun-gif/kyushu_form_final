<?php

// Connect to db
require('./../config/DB.php');
require('./../config/ApplicantForm.php')
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
            $validator = new Validator();
            $kyushuDb = [
                'main' => [
                    'firstName' => $validator->prepareToStore($data->firstName),
                    'lastName' => $validator->prepareToStore($data->lastName),
                    'dob' => $validator->prepareToStore($data->dob),
                    'gRadio' => $validator->prepareToStore($data->gRadio),
                    'nationality' => $data->nationality === 'singaporean' ? $validator->prepareToStore($data->nationality) : $validator->prepareToStore($data->nationalityInput),
                    'occupation' => $validator->prepareToStore($data->occupation),
                    'religion' => $validator->prepareToStore($data->religion),
                    'snsUsername' => $validator->prepareToStore($data->snsUsername),
                    'jpRadio' => $validator->prepareToStore($data->jpRadio),
                    'region' => $data->region ? $validator->normalize($data->region): '',
                    'dietary' => $validator->prepareToStore($data->dietary),
                    'email' => $validator->prepareToStore($data->email),
                    'phone' => $validator->prepareToStore($data->phone),
                ],
                'pt1' => [
                    'tFirstName' => $validator->prepareToStore($data->tFirstName),
                    'tLastName' => $validator->prepareToStore($data->tLastName),
                    'tDob' => $validator->prepareToStore($data->tDob),
                    'sgRadio' => $validator->prepareToStore($data->sgRadio),
                    'tNationality' => $data->tNationality === 'singaporean' ? $validator->prepareToStore($data->tNationality) : $validator->prepareToStore($data->tNationalityInput),
                    'relationship' => $validator->prepareToStore($data->relationship),
                    'tDietary' => $validator->prepareToStore($data->tDietary),
                    'uploadAvatar' => $data->uploadAvatar,
                ],
                'pt2' => [
                    'gFirstName' => $validator->prepareToStore($data->gFirstName),
                    'gLastName' => $validator->prepareToStore($data->gLastName),
                    'tPeriod' => $data->tPeriod ? $validator->normalize($data->tPeriod) : '',
                    'uVideo' => $data->uVideo ? 'Uploaded' : 'Not Uploaded',
                    'campaign' => $data->campaign ? array_map(function($item) use ($data, $validator) {
                        return $item === 'other' ? $validator->prepareToStore($data->campaignInput) : $validator->prepareToStore($item);
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