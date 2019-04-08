{*smarty*}
<div style='background-color: #aaaaaa; padding: 20px'>
    <div style='background-color: white;max-width: 60%; margin: auto; padding: 5px'>
        <div>
            <h2>Llegó un nuevo mensaje desde el sitio de Ayudarg</h2>
        </div>
        <div>
            <span style='font-weight: bold'>Nombre</span><span style='padding-left: 15px;'>{$nombre}</span>
        </div>
        <div>
            <span style='font-weight: bold'>Email</span><span style='padding-left: 15px;'>{$email}</span>
        </div>

        <div>
            <span style='font-weight: bold'>Teléfono</span><span style='padding-left: 15px;'>{$telefono}</span>
        </div>
        <div>
            <span style='font-weight: bold'>Mensaje</span>
        </div>
        <div>
            <div style='border: dotted 1px #3c3c3c; padding:10px'>{$mensaje}</div>
        </div>
    </div>
</div>