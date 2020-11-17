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

    public function error400response($response, $errorMsg)
    {
                //Response: error
                $error = json_encode(
                    [
                        'status' => 'error',
                        'Message' => $errorMsg,
                    ],
                    JSON_PRETTY_PRINT
                );
                $response->getBody()->write($error);
                $error400Response = $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
                return $error400Response;
    }
}
