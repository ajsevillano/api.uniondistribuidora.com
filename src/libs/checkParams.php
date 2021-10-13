<?php namespace APP\libs;

use APP\libs\errors as errors;
use APP\libs\validators as validators;
use APP\models\products as productsRequest;


class checkParams
{

  private $objetValidator;
  private $objetError;
  private $objetProductsList;

  public function __construct()
  {
    //Instanciate imported classes
    $this->objetValidator = new validators();
    $this->objetError = new errors();
    $this->objetProductsList = new productsRequest();
  }

  public function paramsValidator($numberOfKeys,$response,$errorArray,$valueOfFirstKey,$allowedFilters,$valueOfSecondKey,$allowedSecondFilter,$params) {
    switch (true) {
      //If there is 1 parameter
      case ($numberOfKeys == 2):
           //Check if the param is one of the allowed one in $allowedFilters;
           if (
            $this->objetValidator->validateAllowedParams(
                $valueOfFirstKey,
                $allowedFilters,
                $valueOfSecondKey=null,
                $allowedSecondFilter=null
            )
        ) {
            return $this->objetError->error400response(
                $response,
                $errorArray['ValidFilters']
            );
        }

        if (
            //Check if the value of the param is empty or !=0;
            empty($params[$valueOfFirstKey]) &&
            $params[$valueOfFirstKey] != '0'
        ) {
            $errorMsg =
                'The value of ' . $valueOfFirstKey . ' can not be empty';
            return $this->objetError->error400response(
                $valueOfFirstKey,
                $response,
                $errorMsg
            );
        }

        //Fix the name of the query agains the actual names in the DB.
        $filterName = $this->objetError->fixRowNamesQuery($valueOfFirstKey);
        $resultQueryAll = $this->objetProductsList->getFilter(
            $filterName,
            $params[$valueOfFirstKey]
        );
        //Return the filtered info from the DB.
        return $this->objetValidator->ValidResponse($response, $resultQueryAll);
          break;
      case ($numberOfKeys == 3):
           //Check that only the parameters allowed in $allowedFilters and $allowedSecondFilter are found
           if (
            $this->objetValidator->validateAllowedParams(
                $valueOfFirstKey,
                $allowedFilters,
                $valueOfSecondKey,
                $allowedSecondFilter
            )
        ) {
            return $this->objetError->error400response(
                $response,
                $this->errorArray['ValidFilters']
            );
        }

        //Check if the values of the 2 params are empty
        if (
            $this->objetValidator->validateNoEmptyParams(
                $params[$valueOfFirstKey],
                $params[$valueOfSecondKey]
            )
        ) {
            return $this->objetError->error400response(
                $response,
                $this->errorArray['valuesNotEmpty']
            );
        }

        //Check second parameter (status) value is 0 or 1
        if (
            $this->objetValidator->validateSecondParam(
                $params[$valueOfSecondKey]
            )
        ) {
            return $this->objetError->error400response(
                $response,
                $this->errorArray['statusBinary']
            );
        }

        //Fix the name of the query against the actual names in the DB.
        $filterName = $this->objetError->fixRowNamesQuery($valueOfFirstKey);

        //Return the filtered info from the DB.
        $resultQueryAll = $this->objetProductsList->getFilterWithTwoParams(
            $filterName,
            $params[$valueOfFirstKey],
            $params[$valueOfSecondKey]
        );
        return $this->objetValidator->ValidResponse($response, $resultQueryAll);
          break;
      case ($numberOfKeys >= 4):
          return $this->objetError->error400response(
          $response,
          $errorArray['twoFiltersAllow']);
    }
 
  }



 }