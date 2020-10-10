<?php namespace APP\config;


/* Main db class */
class db
{
    private $configuracion = [
        'dsn' => 'mysql:host=localhost;dbname=db775411928;charset=utf8',
        'usuario' => 'root',
        'clave' => '',
    ];

    private $conexion = false;
    public function obtenerPDO()
    {
        if ($this->conexion === false) {
            $this->conexion = new \PDO(
                $this->configuracion['dsn'],
                $this->configuracion['usuario'],
                $this->configuracion['clave']
            );
            $this->conexion->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
        }
        return $this->conexion;
    }
}
