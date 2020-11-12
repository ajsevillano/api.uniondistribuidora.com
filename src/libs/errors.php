<?php namespace APP\libs;

class errors
{
    public function generalError($errorMsg)
    {
        //Check if there are more than 2 filters.
        $error = json_encode(
            [
                'status' => 'error',
                'Message' => $errorMsg,
            ],
            JSON_PRETTY_PRINT
        );

        return $error;
    }

    public function fixRowNamesQuery($valueOfFirstKey)
    {
        // If block to match the database field names (to solve in a future)
        if ($valueOfFirstKey == 'like') {
            $filterName = 'destacado';
            return $filterName;
        } elseif ($valueOfFirstKey == 'status') {
            $filterName = 'activo';
            return $filterName;
        } else {
            $filterName = 'tipo';
            return $filterName;
        }
    }
}
