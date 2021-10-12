<?php namespace APP\libs;

class helpers
{

   //Errors array

   private $errorArray;

   public function __construct()
   {
       $this->errorArray = [
           'twoFiltersAllow' =>
               ' is too long, only 2 filters are allow',
           'ValidFilters' =>
               'Only like, status & category are valid parameters',
           'valuesNotEmpty' => 'The values can not be empty',
           'statusBinary' => 'status value can only be 0 or 1',
           'invalidArgument' => 'Invalid argument, the ID MUST be an number',
           'itemDoesntExist' => 'The item you requested do not exist',
       ];
   }


  //Helper Methods//
  public function filterThreeParams($response,$objetError)
  {
 
      //Return the error in json format
      return $objetError->error400response(
          $response,
          $this->errorArray['twoFiltersAllow']
      );
  }
}


