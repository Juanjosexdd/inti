<!--FORMULARIO VENTANA MODAL ANULAR-->
<div id="tramiteAnularModal" class="modal fade bd-example-modal-lg">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <form method="post" id="tramite_anular_recaudo_form">
        <div class="modal-content card-success card-outline">
            <div class="modal-header">
                <h4 class="modal-title">Anular Trámite</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            
            <div class="form-row">
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Ciudadano: <strong> <span id="spanciudadano_2"> </span> </strong> </li>
                    <li>Trámite:   <strong> <span id="spantramite_2">   </span> </strong> </li>
                    </ul>

                </div>
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Fecha:  <strong> <span id="spanfecha_2">  </span> </strong> </li>
                    <li>Sector: <strong> <span id="spansector_2"> </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12">

                    <ul style="font-size: 14px;">
                    <li>Observación:  <strong> <span id="spanobservacion_2">  </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12" style="text-align: center;">

                    <h4>¿Esta seguro de anular este trámite?</h4>

                </div>

            </div>

                <div class="form-row">

                    <div class="col-md-12 mb-12">
                        <label>Motivo:</label>
                        <input type="text" placeholder="Ingrese un motivo" required name="motivo" id="motivo" class="form-control" placeholder="" />
                    </div>
                </div>

                <div class="modal-footer">
                <input type="hidden" name="idtramite" id="idtramiteanular"/>
                <button type="submit" name="action" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
                <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
                </div>


        </div>
        </form>
    </div>
    </div>
</div>

<!--FORMULARIO VENTANA MODAL-->
<div  id="tramiteModal" class="modal fade bd-example-modal-lg">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <form method="post" id="tramite_form">
        <div class="modal-content card-success card-outline">
            <div class="modal-header">
            <h4 class="modal-title">Registrar Trámite</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            
            <div class="form-row">
                <div class="col-md-4 mb-4">
                <label>Trámite</label>
                    <select class="form-control" required name='codtramite' id='codtramite' class='selecs controlDisabled cursor-bloqueado' onchange="" >
                    <option value="" >Seleccione un trámite</option>
                    <?php 
                    
                    $opciones= "";
                    foreach ( $result_tramite as $key => $value ) {
                        $seleccionado = ""; //($result_tramite[$codigo]==$buscado)?"selected":""; 
                        $opciones    .= "<option value='".$result_tramite[$key]['codtramite']."' ".$seleccionado."> ".utf8_encode($result_tramite[$key]['nombre'])." </option>";
                    } echo $opciones;

                    ?>
                    </select>
                </div>

                <div class="col-md-4 mb-4">
                <label>Fecha Trámite</label>
                <input type="text" readonly name="fechainicio" id="fechainicio" class="form-control datepicker" placeholder="" required onKeyPress="" />
                </div>

                <div class="col-md-4 mb-4">
                <label>Ciudadano</label>
                    <select style="width:100%;" class="form-control js-example-basic-multiple" required name='cedulasolicitante' id='cedulasolicitante' class='selecs controlDisabled cursor-bloqueado' onchange="" >
                    <option value="" >Seleccione un ciudadano</option>
                    <?php 
                    
                    $opciones= "";
                    foreach ( $result_ciudadano as $key => $value ) {
                        $seleccionado = ""; //($result_ciudadano[$codigo]==$buscado)?"selected":""; 
                        $opciones    .= "<option value='".$result_ciudadano[$key]['cedula']."' ".$seleccionado."> CI: "
                        .utf8_encode($result_ciudadano[$key]['cedula'])." - "
                        .utf8_encode($result_ciudadano[$key]['primernombre'])." "
                        .utf8_encode($result_ciudadano[$key]['primerapellido'])." </option>";
                    } echo $opciones;

                    ?>
                    </select>
                </div>

            </div>


            <div class="form-row">
                <div class="col-md-4 mb-4">
                <label>Lote Terreno</label>
                <input type="text" name="loteterreno" id="nombrloteterrenoe" class="form-control" placeholder="" required  />
                </div>

                <div class="col-md-4 mb-4">
                <label>Superficie</label>
                <input type="text" name="superficie" id="superficie" class="form-control" placeholder="" required  />
                </div>

                <div class="col-md-4 mb-4">
                <label>País</label>
                    <select class="form-control" required name='codpais' id='codpais' class='selecs controlDisabled cursor-bloqueado' onchange="cargarCombo(this.value,this.name,'estado','codestado','nombre','')" >
                    <option value="" >Seleccione una opcion</option>
                    <?php 
                    
                    $opciones= "";
                    foreach ( $result_pais as $key => $value ) {
                        $seleccionado = ($value['codpais']=="")?"selected":""; 
                        $opciones    .= "<option value='".$result_pais[$key]['codpais']."' ".$seleccionado."> ".utf8_encode($result_pais[$key]['nombre'])." </option>";
                    } echo $opciones;

                    ?>
                    </select>
                </div>

            </div>

            <div class="form-row">
                <div class="col-md-4 mb-4">
                <label>Estado</label>
                <select class="form-control" id="codestado" name="codestado" required onchange="cargarCombo(this.value,this.name,'municipio','codmunicipio','nombre','')">
                    <option value="" >Seleccione una opcion</option>
                </select>
                </div>

                <div class="col-md-4 mb-4">
                <label>Municipio</label>
                <select class="form-control" id="codmunicipio" name="codmunicipio" required onchange="cargarCombo(this.value,this.name,'parroquia','codparroquia','nombre','')">
                    <option value="" >Seleccione una opcion</option>
                </select>
                </div>

                <div class="col-md-4 mb-4">
                <label>Parroquia</label>
                <select class="form-control" id="codparroquia" name="codparroquia" required onchange="cargarCombo(this.value,this.name,'sector','codsector','nombre','')">
                    <option value="" >Seleccione una opcion</option>
                </select>
                </div>
            </div>

            <div class="form-row">

                <div class="col-md-4 mb-4">
                <label>Sector</label>
                <select class="form-control" id="codsector" name="codsector" required>
                    <option value="" >Seleccione una opcion</option>
                </select>
                </div>

                <div class="col-md-8 mb-8">
                <label>Observación</label>
                <input type="text" name="observacion" id="observacion" class="form-control" placeholder=""  />
                </div>
            </div>
                
            </div>

            <div class="modal-footer">
            <input type="hidden" name="idtramite" id="idtramite"/>
            <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
            <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
            </div>
        </div>
        </form>
    </div>
    </div>
</div>

<!--FORMULARIO VENTANA MODAL ASOCIAR-->
<div id="tramiteRecaudoModal" class="modal fade bd-example-modal-lg">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <form method="post" id="tramite_asociar_recaudo_form">
        <div class="modal-content card-success card-outline">
            <div class="modal-header">
                <h4 class="modal-title">Asociar Recaudo Trámite</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            
            <div class="form-row">
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Ciudadano: <strong> <span id="spanciudadano"> </span> </strong> </li>
                    <li>Trámite:   <strong> <span id="spantramite">   </span> </strong> </li>
                    </ul>

                </div>
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Fecha:  <strong> <span id="spanfecha">  </span> </strong> </li>
                    <li>Sector: <strong> <span id="spansector"> </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12">

                    <ul style="font-size: 14px;">
                    <li>Observación:  <strong> <span id="spanobservacion">  </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12">

                    <table id="tramite_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                        <tr>
                        <th style='text-align: center;' >#</th>                           
                        <th style='text-align: center;'>Trámite</th>
                        <th style='text-align: center;' width="10%">Cantidad</th>
                        <th style='text-align: center;' width="15%">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tramite_data_tbody">

                    </tbody>
                    </table>

                </div>

            </div>
        </div>
        </form>
    </div>
    </div>
</div>



<!--FORMULARIO VENTANA MODAL PROCESAR-->
<div id="tramiteProcesarModal" class="modal fade bd-example-modal-lg">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <form method="post" id="tramite_procesar_tramite_form">
        <div class="modal-content card-success card-outline">
            <div class="modal-header">
            <h4 class="modal-title">Procesar Trámite</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            
            <div class="form-row">
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Ciudadano: <strong> <span id="spanciudadano_3"> </span> </strong> </li>
                    <li>Trámite:   <strong> <span id="spantramite_3">   </span> </strong> </li>
                    </ul>

                </div>
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Fecha:  <strong> <span id="spanfecha_3">  </span> </strong> </li>
                    <li>Sector: <strong> <span id="spansector_3"> </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12">

                    <ul style="font-size: 14px;">
                    <li>Observación:  <strong> <span id="spanobservacion_3">  </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12" style="text-align: center;">

                    <h4>¿Esta seguro de procesar este trámite?</h4>

                </div>

            </div>

                <div class="form-row">

                    <div class="col-md-12 mb-12">
                        <label>Observación:</label>
                        <input type="text" placeholder="Ingrese una observación" name="observacion" id="observacion" class="form-control" placeholder="" onKeyPress="" />
                    </div>
                </div>

                <div class="modal-footer">
                <input type="hidden" name="idtramite" id="idtramiteprocesar"/>
                <input type="hidden" name="estatus"   id="codestatusprocesar"/>
                <button type="submit" name="action" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
                <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
                </div>


        </div>
        </form>
    </div>
    </div>
</div>

