<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use APP\models\products as productsRequest;

class products
{
    public function getAll(Request $request, Response $response)
    {
        $objetProductsList = new productsRequest();
        $resultQueryAll = $objetProductsList->getAll();

        //Return all the products in an json object
        $encodeResult = json_encode($resultQueryAll, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getID(Request $request, Response $response, $arg)
    {
        $objetProductId = new productsRequest();
        $resultQueryId = $objetProductId->getId($arg['id']);

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

        //Return the Product ID in an json object
        $encodeResult = json_encode($resultQueryId, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function CreateNewProduct(Request $request, Response $response, $arg)
    {
        //Get the date in timestamp format
        $currentDate = new \DateTime();

        //Get the data from the POST request in json and decode it.
        $getDataFromPut = json_decode($request->getBody());

        //Filter and store the post data into variables
        $tipo = htmlspecialchars($getDataFromPut->tipo);
        $marca = htmlspecialchars($getDataFromPut->marca);
        $tamano = htmlspecialchars($getDataFromPut->tamano);
        $nombre = htmlspecialchars($getDataFromPut->nombre);
        $estado = htmlspecialchars($getDataFromPut->activo);
        $lastupdate = $currentDate->getTimestamp();

        //Instance the model class
        $objetProductsList = new productsRequest();
        $objetProductsList->insertNewProduct(
            $nombre,
            $tamano,
            $marca,
            $tipo,
            $estado,
            $lastupdate
        );

        //Return a json objet confirming the product has been added to the db
        $encodeMsg = json_encode(
            [
                'status' => 'ok',
                'Message' =>
                    'The product ' .
                    $nombre .
                    ' has been added to the data base',
            ],
            JSON_PRETTY_PRINT
        );
        $response->getBody()->write($encodeMsg);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function UpdateProduct(Request $request, Response $response, $arg)
    {
        //Get the date in timestamp format
        $currentDate = new \DateTime();

        //Get the data from the POST request in json and decode it.
        $getDataFromPut = json_decode($request->getBody());

        //Filter and store the post data into variables
        $Theid = htmlspecialchars($getDataFromPut->id);
        $tipo = htmlspecialchars($getDataFromPut->tipo);
        $marca = htmlspecialchars($getDataFromPut->marca);
        $tamano = htmlspecialchars($getDataFromPut->tamano);
        $nombre = htmlspecialchars($getDataFromPut->nombre);
        $estado = htmlspecialchars($getDataFromPut->activo);
        $lastupdate = $currentDate->getTimestamp();

        //Instance the model class
        $objetProductsList = new productsRequest();
        $objetProductsList->updateProduct(
            $Theid,
            $tipo,
            $nombre,
            $estado,
            $tamano,
            $marca,
            $lastupdate
        );

        //Return a json objet confirming the product has been added to the db
        $encodeMsg = json_encode(
            [
                'status' => 'ok',
                'Message' => 'The product ' . $Theid . ' has been updated',
            ],
            JSON_PRETTY_PRINT
        );
        $response->getBody()->write($encodeMsg);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
