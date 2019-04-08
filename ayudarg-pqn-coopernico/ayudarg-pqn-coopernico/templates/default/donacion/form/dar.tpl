<label><span class="text-form">{$formulario.nombre.label}</span>{$formulario.nombre.html}</label>
<label><span class="text-form">{$formulario.email.label}:</span>{$formulario.email.html}</label>
<label><span class="text-form">{$formulario.telefono.label}:</span>{$formulario.telefono.html}</label>
<!-- <label><span class="text-form">{$formulario.direccion.label}:</span>{$formulario.direccion.html}</label> --> <!-- MOISES hay que agregarlo-->
<div class="wrapper"><div class="text-form">Quiero dar...</div>{$formulario.mensaje.html}</div>
<input type="hidden" name="accion" value="dar" />