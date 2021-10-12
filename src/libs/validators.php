<?php namespace APP\libs;

class validators
{
    public function CheckIfFirstParamAllowed($valueOfFirstKey, $allowedFilters)
    {
        return !in_array($valueOfFirstKey, $allowedFilters);
    }

    public function validateAllowedParams(
        $valueOfFirstKey,
        $allowedFilters,
        $valueOfSecondKey,
        $allowedSecondFilter
    ) {
        return !in_array($valueOfFirstKey, $allowedFilters) ||
            !in_array($valueOfSecondKey, $allowedSecondFilter);
    }

    public function validateNoEmptyParams($firstValue, $secondValue)
    {
        return (empty($firstValue) && $firstValue != '0') ||
            (empty($secondValue) && $secondValue != '0');
    }

    public function validateSecondParam($secondValue)
    {
        return $secondValue != '1' && $secondValue != '0';
    }

    public function ValidResponse($response, $resultQueryAll)
    {
        $encodeResult = json_encode($resultQueryAll, JSON_PRETTY_PRINT);
        $response->getBody()->write($encodeResult);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
