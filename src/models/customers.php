<?php namespace APP\models;
use APP\config\db as connection;

class customers
{
    public function getAll()
    {
        $sql = "
		  SELECT
		    id, tipo, marca, nombre, activo, destacado,last_update
		  FROM bares
		  ORDER by id ASC, nombre ASC
		";
        $dbh = new connection();
        $pdoContent = $dbh->obtenerPDO();
        $consulta = $pdoContent->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getId($theId)
    {
        $sql = "
		  SELECT
		    id, tipo, marca, nombre, activo, destacado,last_update
		  FROM bares
		  WHERE id = :id
		  ORDER by id ASC, nombre ASC
		";
        $dbh = new connection();
        $pdoContent = $dbh->obtenerPDO();
        $consulta = $pdoContent->prepare($sql);
        $consulta->bindValue(':id', $theId, \PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertNewCustomer(
        $tipo,
        $marca,
        $nombre,
        $estado,
        $lastupdate
    ) {
        $sql = "
      INSERT INTO bares 
      (id, tipo, marca, nombre, activo, destacado, last_update)
      VALUES (:id, :tipo, :marca, :nombre, :estado, :destacado, :lastupdate)
  ";

        $dbh = new connection();
        $pdoContent = $dbh->obtenerPDO();
        $consulta = $pdoContent->prepare($sql);
        $consulta->bindValue(':id', null, \PDO::PARAM_INT);
        $consulta->bindValue(':tipo', $tipo, \PDO::PARAM_STR);
        $consulta->bindValue(':marca', $marca, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':estado', $estado, \PDO::PARAM_INT);
        $consulta->bindValue(':destacado', 0, \PDO::PARAM_INT);
        $consulta->bindValue(':lastupdate', $lastupdate, \PDO::PARAM_INT);
        $consulta->execute();
    }

    public function updateCustomer(
        $Theid,
        $tipo,
        $marca,
        $nombre,
        $estado,
        $lastupdate
    ) {
        $sql = "
              UPDATE bares 
              SET tipo = :tipo, marca = :marca, nombre = :nombre, activo = :estado, last_update = :lastupdate
              WHERE id = :id
          ";

        $dbh = new connection();
        $pdoContent = $dbh->obtenerPDO();
        $consulta = $pdoContent->prepare($sql);
        $consulta->bindValue(':id', $Theid, \PDO::PARAM_INT);
        $consulta->bindValue(':tipo', $tipo, \PDO::PARAM_STR);
        $consulta->bindValue(':marca', $marca, \PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $nombre, \PDO::PARAM_STR);
        $consulta->bindValue(':estado', $estado, \PDO::PARAM_INT);
        $consulta->bindValue(':lastupdate', $lastupdate, \PDO::PARAM_INT);
        $consulta->execute();
    }
}
