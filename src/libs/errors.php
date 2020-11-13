<?php namespace APP\libs;

class errors
{

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
