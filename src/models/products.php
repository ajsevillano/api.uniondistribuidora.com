<?php  namespace APP\models;
use APP\config\db as connection;

class products
{
 
	public function hola()
	{
		return 3;
	}

	public function getAll() {

		$sql = "
		  SELECT
		    id, tipo, marca, tamano, nombre, activo, destacado,last_update
		  FROM catalogo
		  ORDER by id ASC, nombre ASC
		";
		$dbh = new connection;
		$pdoContent = $dbh->obtenerPDO();
		$consulta = $pdoContent->prepare($sql);
		$consulta->execute();
		return $consulta->fetchAll(\PDO::FETCH_OBJ);
	}
	
	public function getId($theId) {

		$sql = "
		  SELECT
		    id, tipo, marca, tamano, nombre, activo, destacado,last_update
		  FROM catalogo
		  WHERE id = :id
		  ORDER by id ASC, nombre ASC
		";
		$dbh = new connection;
		$pdoContent = $dbh->obtenerPDO();
		$consulta = $pdoContent->prepare($sql);
		$consulta->bindValue(':id', $theId, \PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->fetchAll(\PDO::FETCH_ASSOC);
	}

}