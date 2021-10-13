<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use APP\models\products as productsRequest;
use APP\libs\errors as errors;
use APP\libs\validators as validators;
use APP\libs\checkParams as checkParams;


class products
{
    private $errorArray;
    private $objetProductsList;
    private $objetValidator;
    private $objetError;


    public function __construct()
    {
        //Errors array
        $this->errorArray = [
            'twoFiltersAllow' =>
            'Only 2 filters are allowed',
            'ValidFilters' =>
                'Only like, status & category are valid parameters',
            'valuesNotEmpty' => 'The values can not be empty',
            'statusBinary' => 'status value can only be 0 or 1',
            'invalidArgument' => 'Invalid argument, the ID MUST be an number',
            'itemDoesntExist' => 'The item you requested do not exist',
        ];

        //Instanciate imported classes
        $this->objetProductsList = new productsRequest();
        $this->objetValidator = new validators();
        $this->objetError = new errors();
        $this->objectCheckParams = new checkParams();

    }



    public function getAll(Request $request, Response $response)
    {
        $params = $request->getQueryParams();
        $numberOfKeys = count($params);
        $firstParam = array_slice($params, 1);
        $secondParam = array_slice($params, 2);
        $valueOfFirstKey = key($firstParam);
        $valueOfSecondKey = key($secondParam);
        $allowedFilters = ['like', 'status', 'category'];
        $allowedSecondFilter = ['status'];

    
        //Return all the products in an json object (Main path, no filters)
        if ($numberOfKeys == 1) {
            $resultQueryAll = $this->objetProductsList->getAll();
            return $this->objetValidator->ValidResponse($response, $resultQueryAll);
        }
        //Check the number of params and their filters.
        else {
        return $this->objectCheckParams->paramsValidator($numberOfKeys,$response,$this->errorArray,$valueOfFirstKey,$allowedFilters,$valueOfSecondKey,$allowedSecondFilter,$params);
        }
    }



    public function getID(Request $request, Response $response, $arg)
    {
     
        //Validate if $arg['id'] is an int.
        if (is_numeric($arg['id']) === false) {
            
            //Return the error in json format
            return $this->objetError->error400response(
                $response,
                $this->errorArray['invalidArgument']
            );
        } 
            //Check if the response from the DB is empty and return an error message in this case.
            $objetProductId = new productsRequest();
            $resultQueryId = $objetProductId->getId($arg['id']);
            if (empty($resultQueryId)) {
                return $this->objetError->error400response(
                    $response,
                    $this->errorArray['itemDoesntExist']
                );
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

        $lastId = $this->objetProductsList->insertNewProduct(
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
                'lastID' => $lastId,
                'Message' =>
                    'The product ' .
                    $nombre . 'Last id inserted:' . 
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

        $this->objetProductsList->updateProduct(
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
                'Time' => $lastupdate,
            ],
            JSON_PRETTY_PRINT
        );
        $response->getBody()->write($encodeMsg);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
