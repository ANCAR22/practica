<?php

namespace Controllers\ControladoresDatosViajes;

use Controllers\PublicController;
use Dao\DaoViajes\DaoViajes as dv;
use Views\Renderer;

class DatosViaje extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["DatosViajes"] = dv::obtenerDatosViajes();
        $viewData["Total"] = count($viewData["DatosViajes"]);
        Renderer::render("VistaDatosViajes/listadatos", $viewData);
    }
}
