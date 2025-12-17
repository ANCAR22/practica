<section class="py-4 px-4 depth-2">
    <h2>Lista de Datos de los viajes</h2>
</section> 
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Destino</th>
                <th>Transporte</th>
                <th>Duracion /dias/</th>
                <th>Costo total</th>
                <th>Fecha de inicio</th>
                <th><a href="index.php?page=ControladoresDatosViajes-FormDatoisViaje&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach DatosViajes}}
            <tr>
                <td>{{id_viaje}}</td>
                <td>{{destino}}</td>
                <td>{{medio_transporte}}</td>
                <td>{{duracion_dias}}</td>
                <td>{{costo_total}}</td>
                <td>{{fecha_inicio}}</td>
                <td>
                    <a href="index.php?page=ControladoresDatosViajes-FormDatoisViaje&mode=UPD&id_viaje={{id_viaje}}">Editar</a>&nbsp;
                    <a href="index.php?page=ControladoresDatosViajes-FormDatoisViaje&mode=DEL&id_viaje={{id_viaje}}">Eliminar</a>&nbsp;
                    <a href="index.php?page=ControladoresDatosViajes-FormDatoisViaje&mode=DSP&id_viaje={{id_viaje}}">Ver</a>&nbsp;
                </td>
            </tr>
            {{endfor DatosViajes}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="right">
                    <strong>Registros de viajes: {{total}}</strong>
                </td>
            </tr>
        </tfoot>
    </table>
</section>