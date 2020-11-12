<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use APP\models\products as productsRequest;
use APP\libs\errors as errors;
use APP\libs\validators as validators;

class products
{
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

        //Responses
        $error400Response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');

        //Instanciate classes
        $objetProductsList = new productsRequest();
        $objetValidator = new validators();
        $objetError = new errors();
        
        //If there are more than 2 parameters
        if ($numberOfKeys >= 4) {
            //Return the error in json format
            $errorMsg ='The search filter is too long, only 2 filters are allow';
            $resultError = $objetError->generalError($errorMsg);
            $response->getBody()->write($resultError);
            return $error400Response;
        }

        //If there are 2 parameters
        if ($numberOfKeys == 3) {
            //Check that only the parameters allowed in $allowedFilters and $allowedSecondFilter are found
            if (
                $objetValidator->CheckIfAllParamsAllowed($valueOfFirstKey,$allowedFilters,$valueOfSecondKey, $allowedSecondFilter)
            ) {
                $errorMsg ='Only like, status & category are valid first parameters and status valid second parameter';
                $resultError = $objetError->generalError($errorMsg);
                $response->getBody()->write($resultError);
                return $error400Response;
            }

           //Check values of the 2 params are not empty
            if (
                $objetValidator->CheckValuesNotEmpty($params[$valueOfFirstKey],$params[$valueOfSecondKey])
            ) {
                //Return the error in json format
                $errorMsg = 'The values can not be empty';
                $resultError = $objetError->generalError($errorMsg);
                $response->getBody()->write($resultError);
                return $error400Response;
            }

            //Check second parameter (status) value is 0 or 1
            if (
                $objetValidator->CheckValueSecondParam($params[$valueOfSecondKey])
            ) {
                //Return the error in json format
                $errorMsg = 'status value can only be 0 or 1';
                $resultError = $objetError->generalError($errorMsg);
                $response->getBody()->write($resultError);
                return $error400Response;
            }

            //Fix the name of the query agains the actual names in the DB.
            $filterName = $objetError->fixRowNamesQuery($valueOfFirstKey);

            //Return the filtered info from the DB.
            $resultQueryAll = $objetProductsList->getFilterWithTwoParams(
                $filterName,
                $params[$valueOfFirstKey],
                $params[$valueOfSecondKey]
            );
            $encodeResult = json_encode($resultQueryAll, JSON_PRETTY_PRINT);
            $response->getBody()->write($encodeResult);
            return $response->withHeader('Content-Type', 'application/json');
        }

        //If there is 1 parameter
        if ($numberOfKeys == 2) {
            
            //Check if the param is one of the allowed one in $allowedFilters;
            if ($objetValidator->CheckIfFirstParamAllowed($valueOfFirstKey,$allowedFilters)) {
                $errorMsg = 'Only like, status & category are valid parametes';
                $resultError = $objetError->generalError($errorMsg);
                $response->getBody()->write($resultError);
                return $error400Response;
            }
            
            if (
                //Check if the value of the param is empty or !=0;
                empty($params[$valueOfFirstKey]) &&
                $params[$valueOfFirstKey] != '0'
            ) {
                $errorMsg ='The value of ' . $valueOfFirstKey . ' can not be empty';
                $resultError = $objetError->generalError($errorMsg);
                $response->getBody()->write($resultError);
                return $error400Response;
            }

            //Fix the name of the query agains the actual names in the DB.
            $filterName = $objetError->fixRowNamesQuery($valueOfFirstKey);

            $resultQueryAll = $objetProductsList->getFilter(
                $filterName,
                $params[$valueOfFirstKey]
            );
            //Return the filtered info from the DB.
            $encodeResult = json_encode($resultQueryAll, JSON_PRETTY_PRINT);
            $response->getBody()->write($encodeResult);
            return $response->withHeader('Content-Type', 'application/json');
        }

        //Return all the products in an json object (Main path, no filters)
        if ($numberOfKeys == 1) {
            $resultQueryAll = $objetProductsList->getAll();
            $encodeResult = json_encode($resultQueryAll, JSON_PRETTY_PRINT);
            $response->getBody()->write($encodeResult);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function getID(Request $request, Response $response, $arg)
    {
        //Validate if $arg['id'] is an int.
        if (is_numeric($arg['id']) === false) {
            $emptyResult = json_encode(
                [
                    'status' => 'error',
                    'Message' => 'Invalid argument, the ID MUST be an number',
                ],
                JSON_PRETTY_PRINT
            );
            $response->getBody()->write($emptyResult);
            return $error400Response;
        } else {
            //Check if the response from the DB is empty and return an error message in this case.
            $objetProductId = new productsRequest();
            $resultQueryId = $objetProductId->getId($arg['id']);
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
                return $error400Response;
            }

            //Return the Product ID in an json object
            $encodeResult = json_encode($resultQueryId, JSON_PRETTY_PRINT);
            $response->getBody()->write($encodeResult);
            return $response->withHeader('Content-Type', 'application/json');
        }
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
