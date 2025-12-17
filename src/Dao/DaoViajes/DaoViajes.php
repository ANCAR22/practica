<?php

namespace Dao\DaoViajes;

use Dao\Table;

class DaoViajes extends Table
{
    public static function obtenerDatosViajes()
    {
        $sql = "select * from DatosViajes;";
        return self::obtenerRegistros($sql, []);
    }
    public static function ObtenerUnDato(int $id_viaje)
    {
        $sql = "select * from DatosViajes where id_viaje = :id_viaje;";
        return self::obtenerUnRegistro($sql, [":id_viaje" => $id_viaje]);
    }
    public static function crearDatosViaje(
        String $destino,
        string $medio_transporte,
        int $duracion_dias,
        float $costo_total,
        string $fecha_inicio
    ) {
        $sqlinsert = "insert into DatosViajes (destino, medio_transporte, duracion_dias, costo_total, fecha_inicio)
                      values (:destino, :medio_transporte, :duracion_dias, :costo_total, :fecha_inicio);";
        $insertData = [
            ":destino" => $destino,
            ":medio_transporte" => $medio_transporte,
            ":duracion_dias" => $duracion_dias,
            ":costo_total" => $costo_total,
            ":fecha_inicio" => $fecha_inicio
        ];
        return self::executeNonQuery($sqlinsert, $insertData);
    }
}
