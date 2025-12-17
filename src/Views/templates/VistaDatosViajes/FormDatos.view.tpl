<section class="container">
    <section class="deplth-2">
        <h2>{{modeDsc}}</h2>
    </section>
    {{if hasErrores}}
    <ul>
        {{foreach errores}}
        <li>{{this}}</li>
        {{endfor errores}}
    </ul>
    {{endif hasErrores}}

    <form action="index.php?page=ControllerDatosViajes-FormDatoisViaje&mode={{mode}}&id_viaje={{id_viaje}}" method="post">
        <div>
            <label for="id_viaje">Id de Viaje:</label><br/>
            <input type="text" name="id_viaje" id="id_viaje" value="{{id_viaje}}" readonly />
            <input type="hidden" name="vlt" value="{{token}}" >
        </div><br/>
        <div>
            <label for="destino">Destino:</label><br/>
            <input type="text" size="40" name="destino" id="destino" value="{{destino}}" {{readonly}} />
        </div><br/>
        <div>
        <div>
            <label for="medio_transporte">Medio de transporte:</label><br/>
            <input type="text" size="30" name="medio_transporte" id="medio_transporte" value="{{medio_transporte}}" {{readonly}} />
        </div><br/>
        <div>
        <div>
            <label for="duracion_dias">Duracion en dias:</label><br/>
            <input type="number" min="1" name="duracion_dias" id="duracion_dias" value="{{duracion_dias}}" {{readonly}} />
        </div><br/>
        <div>
            <label for="costo_total">Costo Total:</label><br/>
            <input type="number" min="1" name="costo_total" id="costo_total" value="{{costo_total}}" {{readonly}} placeholder="150" />
        </div><br/>
        <div>
            <label for="fecha_inicio">Fecha de inicio:</label><br/>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{fecha_inicio}}" {{readonly}}/>
        </div><br/>
        <div>
        <div>
            <button id="btnCancelar">Cancelar</button>
            {{ifnot isDisplay}}
                <button id="btnConfirmar" type="submit">Confirmar</button>
            {{endifnot isDisplay}}
        </div>
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("btnCancelar").addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=ControladoresDatosViajes-DatosViaje");
        })
    })
</script>