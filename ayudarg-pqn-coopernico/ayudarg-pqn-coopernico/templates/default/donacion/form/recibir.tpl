<div class="wrapper">DATOS DEL USUARIO</div>
<div class="wrapper">El usuario ingresado debe pertenecer a la institución y será el referente de la institución.</div>
<label><span class="text-form">{$formulario.nombre.label}</span>{$formulario.nombre.html}</label>
<label><span class="text-form">{$formulario.email.label}:</span>{$formulario.email.html}</label>
<label><span class="text-form">{$formulario.telefono.label}:</span>{$formulario.telefono.html}</label>
<div class="wrapper">DATOS DE LA INSTITUCION</div>
<div class="wrapper">La institución debe ser SIN FINES DE LUCRO o bien el proyecto por el cuál demanda recursos debe ser con fines de ayuda social.</div>
<label><span class="text-form">{$formulario.ONG.label}</span>{$formulario.ONG.html}</label>
<label><span class="text-form">{$formulario.ONGdireccion.label}</span>{$formulario.ONGdireccion.html}</label>
<label><span class="text-form">{$formulario.ONGemail.label}:</span>{$formulario.ONGemail.html}</label>
<label><span class="text-form">{$formulario.ONGtelef.label}:</span>{$formulario.ONGtelef.html}</label>
<div class="wrapper"><span class="text-form">{$formulario.ONGdescripcion.label}:</span>{$formulario.ONGdescripcion.html}
    <div class="wrapper">Por favor complete sobre el proyecto para el cual necesita ayuda</div>
</div>
<label><span class="text-form">{$formulario.ONGproyecto.label}:</span>{$formulario.ONGproyecto.html}</label>
<div class="wrapper">
    <span class="text-form">{$formulario.ONGdetalleproyecto.label}:</span>{$formulario.ONGdetalleproyecto.html}
</div>
<label><span class="text-form">{$formulario.startDate.label}:</span>{$formulario.startDate.html|replace:'text':'date'}</label>
<label><span class="text-form">{$formulario.endDate.label}:</span>{$formulario.endDate.html|replace:'text':'date'}</label>
<div class="wrapper"><div class="text-form">Quiero recibir...</div>{$formulario.mensaje.html}</div>
<input type="hidden" name="accion" value="recibir" />
