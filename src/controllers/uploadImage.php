<?php namespace APP\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Factory\AppFactory;


class uploadImage
{

public function getImage (Request $request, Response $response) {
 
  $directory =  __DIR__ . '/uploads';
  $uploadedFiles = $request->getUploadedFiles();

  // handle single input with single file upload
  $uploadedFile = $uploadedFiles['file'];
  if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
      $filename = $this->moveUploadedFile($directory, $uploadedFile);
      $response->getBody()->write('Uploaded: ' . $filename . '<br/>');
  }

  return $response;
}

public function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8));
  
    $filename = sprintf('%s.%0.8s', 'id234', $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

}