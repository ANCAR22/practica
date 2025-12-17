<?php

namespace Controllers\ControladoresDatosViajes;

use Controllers\PublicController;
use Utilities\Validators;
use Exception;
use Utilities\Site;
use Views\Renderer;
use Dao\DaoViajes\DaoViajes as dv;


const listaDatos = "index.php?page=ControladoresDatosViajes-DatosViaje";
const formDatos = "VistaDatosViajes/FormDatos";

class FormDatoisViaje extends PublicController
{
    private $modes = [
        "INS" => "Nuevos Datos de viaje",
        "UPD" => "Editando los Datos de viaje de %s",
        "DSP" => "Detalles de los Datos de viaje de %s",
        "DEL" => "Eliminando los Datos de viaje de %s",
    ];
    private string $validationToken = '';
    private string $mode = '';
    private array $errores = [];

    private int $id_viaje = 0;
    private string $destino = "";
    private string $medio_transporte = "";
    private int $duracion_dias = 0;
    private float $costo_total = 0;
    private string $fecha_inicio = "";

    private function generarTokenDeValidacion()
    {
        $this->validationToken = md5(gettimeofday(true) . $this->name . rand(1000, 9999));
        $_SESSION[$this->name . "_token"] = $this->validationToken;
    }

    public function run(): void
    {
        try {
            $this->page_init();
            if ($this->isPostBack()) {
                $this->errores = $this->validarPostData();
                if (count($this->errores) === 0) {
                    try {
                        switch ($this->mode) {
                            case "INS":
                                $affectedRows = dv::crearDatosViaje(
                                    $this->destino,
                                    $this->medio_transporte,
                                    $this->duracion_dias,
                                    $this->costo_total,
                                    $this->fecha_inicio
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(listaDatos, "✅ Nuevos Datos de viaje satisfactoriamente");
                                }
                                break;
                            case "UPD":
                                $affectedRows = dv::editarDatosViaje(
                                    $this->id_viaje,
                                    $this->destino,
                                    $this->medio_transporte,
                                    $this->duracion_dias,
                                    $this->costo_total,
                                    $this->fecha_inicio
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(listaDatos, "✅ Datos de viaje actualizados satisfactoriamente");
                                }
                                break;
                            case "DEL":
                                //Llamar a Dao para eliminar
                                $affectedRows = dv::eliminarDatosViaje(
                                    $this->id_viaje,
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(listaDatos, "✅ Datos de viaje eliminados satisfactoriamente");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0,);
                        $this->errores[] = $err;
                    }
                }
            }
            Renderer::render(formDatos, $this->preparar_datos_vista());
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(listaDatos, "❌ Sucedio un problema al cargar. Reintente nuevamente.");
        }
    }
    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tmpId = 0;
                if (isset($_GET["id_viaje"])) {
                    $tmpId = intval($_GET["id_viaje"]);
                } else {
                    throw new Exception("❌ Valor de id no es valido");
                }
                $tmpDatos = dv::obtenerUnDato($tmpId);
                if (count($tmpDatos) == 0) {
                    throw new Exception("❌ No se encontro registro");
                }
                $this->id_viaje = $tmpDatos["id_viaje"];
                $this->destino = $tmpDatos["destino"];
                $this->medio_transporte = $tmpDatos["medio_transporte"];
                $this->duracion_dias = $tmpDatos["duracion_dias"];
                $this->costo_total = $tmpDatos["costo_total"];
                $this->fecha_inicio = $tmpDatos["fecha_inicio"];
            }
        } else {
            throw new Exception("❌ Valor de mode no es valido");
        }
    }
    private function validarPostData(): array
    {
        $errors = [];
        $this->validationToken = $_POST["vlt"] ?? "";
        if (isset($_SESSION[$this->name . "_token"]) && $_SESSION[$this->name . "_token"] !== $this->validationToken) {
            throw new Exception('❌ Error de validacion de Token');
        }

        $this->id_viaje = intval($_POST["id_viaje"]) ?? 0;
        $this->destino = $_POST["destino"] ?? "";
        $this->medio_transporte = $_POST["medio_transporte"] ?? "";
        $this->duracion_dias = intval($_POST["duracion_dias"]) ?? 0;
        $this->costo_total = floatval($_POST["costo_total"]) ?? 0;
        $this->fecha_inicio = $_POST["fecha_inicio"] ?? "";


        if (Validators::IsEmpty($this->destino)) {
            $errors[] = "❌ Destino no puede ir vacio";
        }

        if (Validators::IsEmpty($this->medio_transporte)) {
            $errors[] = "❌ Medio de transporte no puede ir vacio";
        }

        if (Validators::IsEmpty($this->duracion_dias) && $this->duracion_dias === 0) {
            $errors[] = "❌ Dias no puede ir vacio o ser 0";
        }

        if (Validators::IsEmpty($this->costo_total) && $this->costo_total === 0) {
            $errors[] = "❌ Costo total no puede ir vacio o ser 0";
        }


        if (Validators::IsEmpty($this->fecha_inicio)) {
            $errors[] = "❌ Fecha de incio no puede ir vacio";
        }
        return $errors;
    }

    private function preparar_datos_vista()
    {
        $viewData = [];
        $viewData["mode"] = $this->mode;
        $viewData["modeDsc"] = $this->modes[$this->mode];
        if ($this->mode !== "INS") {
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->destino);
        }

        $viewData["id_viaje"] = $this->id_viaje;
        $viewData["destino"] = $this->destino;
        $viewData["medio_transporte"] = $this->medio_transporte;
        $viewData["duracion_dias"] = $this->duracion_dias;
        $viewData["costo_total"] = $this->costo_total;
        $viewData["fecha_inicio"] = $this->fecha_inicio;

        $viewData["errores"] = $this->errores;

        $viewData["hasErrores"] = count($this->errores) > 0;

        $viewData["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $this->generarTokenDeValidacion();

        $viewData["token"] = $this->validationToken;

        return $viewData;
    }
}
