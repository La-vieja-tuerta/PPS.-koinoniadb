<div class="wrapper margin-bot donacion">
    <div class="col-3">
        <div class="indent">
            <div>
                <div class="box {$quiero}">
                    <div class="pad">
                        <div class="wrapper">
                            <strong class="numb img-indent2">{$nro}</strong>
                            <div class="extra-wrap">
                                <h3 class="{$quiero}"><strong>Quiero</strong>{$quiero|ucfirst}</h3>
                                <h3>{$frase}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="indent-bot2 intro">

                {include file=$introDonacion}

            </div>

            {if $enviado!==true }
                {if $enviado===false }
                    <h3 style='color:red'>Hubo un error enviando el mensaje</h3>
                    <p>
                        {KoinoniaEmailsMod::$lastError}
                    </p>
                {/if}
                <form id="quiero-form" {$formulario.attributes}>
                    <fieldset>
                    {include file=$formDonacion}
                        {$formulario.hidden}
                        <div class="buttons">
                            <a class="button-2" href="#" id="reset-quiero">Borrar</a>
                            <a class="button-2" href="#" id="send-quiero">Enviar</a>
                        </div>
                    </fieldset>
                </form>
            {else}
                Su mensaje ha sido enviado con éxito! Muchas gracias
            {/if}
            <BR>
            <dl class="contact p3">
                <dt>
                Si desea puede operar directamente a través del sistema AYUDARG a través del siguiente link <a class="link" target="_blank" href="/operativa/">SISTEMA AYUDARG</a>.
                </dt>
            </dl>
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