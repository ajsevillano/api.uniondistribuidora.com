<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use APP\models\customers as customerRequest;
use APP\libs\errors as errors;
use APP\libs\validators as validators;
use APP\libs\checkParams as checkParams;

class customers
{
    public function getAll(Request $request, Response $response)
{
    // Initialize necessary objects
    $objetValidator = new validators();
    $objetError = new errors();
    $objectCheckParams = new checkParams();
    $objetCustomersList = new customerRequest();

    // Error messages array
    $errorArray = [
        'twoFiltersAllow' => 'Only 2 filters are allowed',
        'ValidFilters' =>
            'Only like, status & category are valid parameters',
        'valuesNotEmpty' => 'The values can not be empty',
        'statusBinary' => 'status value can only be 0 or 1',
        'invalidArgument' => 'Invalid argument, the ID MUST be an number',
        'itemDoesntExist' => 'The item you requested do not exist',
    ];

    $params = $request->getQueryParams();
    $numberOfKeys = count($params);
    $firstParam = array_slice($params, 1);
    $secondParam = array_slice($params, 2);
    $valueOfFirstKey = key($firstParam);
    $valueOfSecondKey = key($secondParam);
    $allowedFilters = ['like', 'status', 'category'];
    $allowedSecondFilter = ['status'];

    //Return all the customers in an json object (Main path, no filters)
    if ($numberOfKeys == 1) {
        $resultQueryAll = $objetCustomersList->getAll();
        return $objetValidator->ValidResponse(
            $response,
            $resultQueryAll
        );
    }
    //Check the number of params and their filters.
    else {
        return $objectCheckParams->paramsValidator(
            $objetCustomersList,
            $numberOfKeys,
            $response,
            $errorArray,
            $valueOfFirstKey,
            $allowedFilters,
            $valueOfSecondKey,
            $allowedSecondFilter,
            $params
        );
    }
}

    public function CreateNewcustomer(
        Request $request,
        Response $response,
        $arg
    ) {
        //Get the date in timestamp format
        $currentDate = new \DateTime();

        //Get the data from the POST request in json and decode it.
        $getDataFromPut = json_decode($request->getBody());

        //Filter and store the post data into variables
        $tipo = htmlspecialchars($getDataFromPut->tipo);
        $marca = htmlspecialchars($getDataFromPut->marca);
        $nombre = htmlspecialchars($getDataFromPut->nombre);
        $estado = htmlspecialchars($getDataFromPut->activo);
        $lastupdate = $currentDate->getTimestamp();

        //Instance the model class
        $objetCustomersList = new customerRequest();
        $objetCustomersList->insertNewcustomer(
            $tipo,
            $marca,
            $nombre,
            $estado,
            $lastupdate
        );

        //Return a json objet confirming the customer has been added to the db
        $encodeMsg = json_encode(
            [
                'status' => 'ok',
                'Message' =>
                    'The customer ' .
                    $nombre .
                    ' has been added to the data base',
            ],
            JSON_PRETTY_PRINT
        );
        $response->getBody()->write($encodeMsg);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function Updatecustomer(Request $request, Response $response, $arg)
    {
        //Get the date in timestamp format
        $currentDate = new \DateTime();

        //Get the data from the POST request in json and decode it.
        $getDataFromPut = json_decode($request->getBody());

        //Filter and store the post data into variables
        $Theid = htmlspecialchars($getDataFromPut->id);
        $tipo = htmlspecialchars($getDataFromPut->tipo);
        $marca = htmlspecialchars($getDataFromPut->marca);
        $nombre = htmlspecialchars($getDataFromPut->nombre);
        $estado = htmlspecialchars($getDataFromPut->activo);
        $lastupdate = $currentDate->getTimestamp();

        //Instance the model class
        $objetCustomersList = new customerRequest();
        $objetCustomersList->updateCustomer(
            $Theid,
            $tipo,
            $marca,
            $nombre,
            $estado,
            $lastupdate
        );

        //Return a json objet confirming the customer has been added to the db
        $encodeMsg = json_encode(
            [
                'status' => 'ok',
                'Message' => 'The customer ' . $Theid . ' has been updated',
            ],
            JSON_PRETTY_PRINT
        );
        $response->getBody()->write($encodeMsg);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
