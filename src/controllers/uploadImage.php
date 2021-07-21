<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Factory\AppFactory;


class uploadImage
{

public function getImage (Request $request, Response $response) {
 
  $directory =  __DIR__ . '/../../../management-app/img/Thumbnails';
  print_r($directory);
  $uploadedFiles = $request->getUploadedFiles();

  // handle single input with single file upload
  $uploadedFile = $uploadedFiles['file'];

  if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
      $filename = $this->moveUploadedFile($directory, $uploadedFile);
      $encodeMsg = json_encode(
        [
            'status' => 'ok',
            'Message' =>
                'The image ' .
                $filename . 
                ' has been uploaded',
        ],
        JSON_PRETTY_PRINT
    );
    $response->getBody()->write($encodeMsg);
  }
  
  return $response;
}

public function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
{
    $filename = $uploadedFile->getClientFilename();
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
    return $filename;
}

}