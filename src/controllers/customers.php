<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use APP\models\customers as customerRequest;

class customers
{
    public function getAll(Request $request, Response $response)
    {
        $objetCustomersList = new customerRequest();
        $resultQueryAll = $objetCustomersList->getAll();

        //Return all the customers in an json object
        $encodeResult = json_encode($resultQueryAll, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getID(Request $request, Response $response, $arg)
    {
        $objetCustomerId = new customerRequest();
        $resultQueryId = $objetCustomerId->getId($arg['id']);

        //Check if the response from the DB is empty and return an error message in this case.
        if (empty($resultQueryId)) {
            $emptyResult = json_encode(
                [
                    'status' => 'error',
                    'Message' =>
                        'The item ' .
                        $arg['id'] .
                        ' you requested do not exist',
                ],
                JSON_PRETTY_PRINT
            );
            $response->getBody()->write($emptyResult);
            return $response->withHeader('Content-Type', 'application/json');
        }

        //Return the Customer ID in an json object
        $encodeResult = json_encode($resultQueryId, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
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
