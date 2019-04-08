$(function($) {
    function mostrarUsuarios(data) {
            if (data.usuarios.length>0) {
                $("#usuarios-similares").remove();

                var preguntar = $("<div id='usuarios-similares'></div>");
                $('body').append(preguntar);

                var lista = $("<ul id='usuarios'></ul>");
                preguntar.append(lista);

                $.each(data.usuarios, function (nro, usuario) {
                    var li = $("<li>"+ usuario.name + " (" + usuario.emailshow + ")</li>");
                    li.attr('user-name',usuario.name);
                    li.attr('user-email',usuario.email);
                    li.attr('user-phone',usuario.phone);
                /*    li.attr('user-address',usuario.address); */ /* MOISES hay que agregar */
                    li.attr('user-id',usuario.id);
                    lista.append(li);
                });

                preguntar.dialog({
                    title:"Encontramos usuarios similares",
                    close: function (e) {
                        $("#usuarios-similares").html('');
                    },
                    width:'auto'
                });
            }
    }
    $('#quiero-form textarea[name=ONGdescripcion]').ckeditor({toolbarGroups:[{name:'basicstyles'}]}); /*  MOISES PARA CREARLO COMO CKEDIDOR */
    $('#quiero-form').on('change','input[name=nombre],input[name=email]',function(e) {
        $('#quiero-form input[name=user_id]').remove();
        var inData = {nombre: $('input[name=nombre]').val(), email: $('input[name=email]').val()};
        pQn.fn.doAccion('Donacion', 'checkDonante', inData, mostrarUsuarios);
    });

    $('#quiero-form').on('click','input[name=ONG]',function(e) {
        $('#quiero-form input[name=institution_id]').remove();
        $('input[name=ONG],input[name=ONGemail],input[name=ONGtelef],input[name=ONGdireccion]').val('');
        //$('textarea[name=ONGdescripcion]').text('');
        CKEDITOR.instances.ONGdescripcion.setData('');
        $('#quiero-form input[readonly]').removeAttr('readonly');
       // CKEDITOR.instances.ONGdescripcion.removeAttr('readonly');
        CKEDITOR.instances.ONGdescripcion.setReadOnly(false);
    });

    $('#quiero-form input[name=ONG]').autocomplete({
        source: getAccionUrl('Donacion', 'checkONG', 'plain'),
        minLength:2,
        select: function(e, ui) {
            if($('#quiero-form input[name=institution_id]').length==0)
                $('#quiero-form').append($("<input type='hidden' name='institution_id'/>"));
            $('#quiero-form input[name=institution_id]').val(ui.item.id);

            $('#quiero-form input[name=ONGemail]').val(ui.item.email);
            $('#quiero-form input[name=ONGtelef]').val(ui.item.telef);
            $('#quiero-form input[name=ONGdireccion]').val(ui.item.direccion);
            CKEDITOR.instances.ONGdescripcion.setData(ui.item.descripcion);

            $('input[name=ONGemail],input[name=ONGtelef],input[name=ONGdireccion]').attr('readonly','readonly');
            CKEDITOR.instances.ONGdescripcion.readOnly = 'true';


        }
    });

    $('#quiero-form').on('click','#reset-quiero',function(e){
        e.preventDefault();
        $('#quiero-form')[0].reset();
        $('#quiero-form input[name=user_id]').remove();
        $('#quiero-form input[readonly]').removeAttr('readonly');
    });

    $('#quiero-form').on('click',"#send-quiero",function (e) {
        var formData = pQn.fn.getFormData('quiero-form');
         /* MOISES */
        if($('#quiero-form input[name=accion]')[0].value=='recibir')
             formData.set('ONGdescripcion',CKEDITOR.instances.ONGdescripcion.getData());
        e.preventDefault();

        var btnSendQuiero = $(this);
        $(this).html('Enviando <div class="loader"></div>').prop('disabled','disabled');

        $.ajax({
            url: '?mod=donacion',
            type: 'POST',
            data: formData,
            success: function (data) {
                if(data.status=='OK') {
                    $('#quiero-form').before($('<div id="msgResources"><h3>Detectamos los siguientes recursos</h3>' +
                        '<span>Para mejorar la información por favor ratifique y/o rectifique</span></div>'));
                    $('#quiero-form').remove();

                    if (data.recursos != null) {
                        for (i in data.recursos) {
                            var res = data.recursos[i];
                            $("#msgResources").append($("<div class='resourceRelated'>" + res.descripcion + " (" + res.cantidad + ")</div>"));
                        }
                    }
                }
                else
                    alert(data.errors);

            },
            cache: false,
            contentType: false,
            processData: false
        }).done(function(){btnSendQuiero.text('Enviar'); btnSendQuiero.removeProp('disabled')});
    });

    function insertUsuario(li) {
        $('input[name=nombre]').val(li.attr('user-name'))
        $('input[name=email]').val(li.attr('user-email'));
        $('input[name=telefono]').val(li.attr('user-phone'));
     /*   $('input[name=direccion]').val(li.attr('user-address')); */ /*MOISES hay que agregar */
        $('input[name=nombre],input[name=email],input[name=telefono]').attr('readonly','readonly');
        $('#quiero-form').append($("<input type='hidden' name='user_id' value='"+li.attr('user-id')+"' />"));
        $("#usuarios-similares").dialog("close");
    }

    $('body').on('click','ul#usuarios li',function() {
        var li = $(this).attr('selected','selected');
        $('ul#usuarios li:not([selected])').remove();
        $("#usuarios-similares").append($("<input type='password' placeholder='Confirme con su contraseña' name='password'/><input name='confirm-password' type='submit' value='Confirmar'/>"));
  });

    $('body').on('click','input[name=confirm-password]',function (e) {
        e.preventDefault();
        var li = $('ul#usuarios li[selected=selected]');
        li.attr('selected','');
        var data = {username:li.attr('user-email'),password:$("input[name='password']").val()};
        pQn.fn.doAccion('Donacion','checkUser',data,function(d){if(d.status=='success') insertUsuario(li); else alert("Clave incorrecta para el usuario")});
    });
});