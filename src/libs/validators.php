<?php namespace APP\libs;

class validators
{
    public function CheckIfFirstParamAllowed($valueOfFirstKey, $allowedFilters)
    {
        return !in_array($valueOfFirstKey, $allowedFilters);
    }

    public function CheckIfAllParamsAllowed(
        $valueOfFirstKey,
        $allowedFilters,
        $valueOfSecondKey,
        $allowedSecondFilter
    ) {
        return !in_array($valueOfFirstKey, $allowedFilters) ||
            !in_array($valueOfSecondKey, $allowedSecondFilter);
    }

    public function CheckValuesNotEmpty($firstValue, $secondValue)
    {
        return (empty($firstValue) && $firstValue != '0') ||
            (empty($secondValue) && $secondValue != '0');
    }

    public function CheckValueSecondParam($secondValue)
    {
        return $secondValue != '1' && $secondValue != '0';
    }
}
