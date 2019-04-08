<div class="wrapper margin-bot contacto">
    <div class="col-3">
        <div class="indent">
            {if $enviado!==true }
            <h2 class="p0">Formulario de Contacto</h2>
                {if $enviado===false }
                    <h3 style='color:red'>Hubo un error enviando el mensaje</h3>
                    <p>
                        {KoinoniaEmailsMod::$lastError}
                    </p>
                {/if}
            <form id="contact-form" action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <label><span class="text-form">Nombre</span><input name="nombre" type="text" /></label>
                    <label><span class="text-form">Email:</span><input name="email" type="text" /></label>
                    <label><span class="text-form">Teléfono:</span><input name="telefono" type="text" /></label>
                    <div class="wrapper"><div class="text-form">Mensaje</div><textarea name="mensaje"></textarea></div>
                    <div class="buttons">
                        <a class="button-2" href="#" onClick="document.getElementById('contact-form').reset()">Borrar</a>
                        <a class="button-2" href="#" onClick="document.getElementById('contact-form').submit()">Enviar</a>
                    </div>
                    <input type="hidden" name="mod" value="paginas"/>
                    <input type="hidden" name="accion" value="contacto"/>
                </fieldset>
            </form>
            {else}
                <h2>Muchas gracias</h2>
                <div>
                    Tu mensaje fue enviado correctamente, pronto nos comunicaremos con vos.
                </div>
            {/if}

        </div>

    </div>
    <div class="col-4">
        <div class="block-news">
            <h3 class="color-4 indent-bot2">Contactos</h3>
            <dl class="contact p3">
                <dt><span>Dirección:</span>Salceda 1995-Tandil</dt>
                <dd><span>Teléfono:</span>+54 0249 4 446817</dd>
                <dd><span>E-mail:</span><a href="#">info@proyectokoinonia.org.ar</a></dd>
            </dl>
            <h3 class="color-4 indent-bot2">Nota</h3>
            <p class="text-1">Lo que complete en el formulario es de caracter confidencial.  A la brevedad nos pondremos en contacto.</p>
        </div>
    </div>
</div>