<div class="wrapper noticias">
    <div class="col-3">
        <div class="indent">
            <h2>Proyectos</h2>
            {$hay=0}
            {foreach from=$proyectos item=p}
                {$cantEstadosRecursos=$p->getCantEstadosRecursos()}
                {$carencia = 0}
                {$obtenido = 0}
                {if $cantEstadosRecursos>0}
                {$carencia = number_format(($p->getCantCarencia() * 100) / $cantEstadosRecursos, 2, '.', '')}
                {$obtenido = number_format(($p->getCantObtenido() * 100) / $cantEstadosRecursos, 2, '.', '')}
                {/if}
                <div class="indent-bot">

                            <div>
                                <h6>{foreach from=$p->getInstitutionsNames() item=instName}{$instName} {/foreach}</h6>
                                <h3>  {$p->getName()} <canvas style="float: right" id="canvas{$hay}" height="80" width="80"></canvas></h3>
                                <div class="intro">{$p->getDescription()}</div>
                                <div class='progress_info'>

                                    {$legend='<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'}
                                <script>
                                    var options{$hay} = {
                                        //Boolean - Whether we should show a stroke on each segment
                                        segmentShowStroke : true,
                                        //String - The colour of each segment stroke
                                        segmentStrokeColor : "#fff",
                                        //Number - The width of each segment stroke
                                        segmentStrokeWidth : 2,
                                        //Number - The percentage of the chart that we cut out of the middle
                                        percentageInnerCutout : 50, // This is 0 for Pie charts
                                        //Number - Amount of animation steps
                                        animationSteps : 100,
                                        //String - Animation easing effect
                                        animationEasing : "easeOutBounce",
                                        //Boolean - Whether we animate the rotation of the Doughnut
                                        animateRotate : true,
                                        //Boolean - Whether we animate scaling the Doughnut from the centre
                                        animateScale : false,
                                        //String - A legend template
                                        legendTemplate : "{$legend}"
                                     };

                                    var data{$hay} = [
                                        {
                                            value: {$carencia},
                                            color:"#F7464A",
                                            highlight: "#FF5A5E",
                                            label: "FALTA"
                                    },
                                    {
                                        value: {$obtenido},
                                        color: "#46BFBD",
                                        highlight: "#5AD3D1",
                                        label: "HAY"
                                    }
                                    ];

                                    // For a pie chart
                                    var myPieChart = new Chart(document.getElementById("canvas{$hay}").getContext("2d")).Pie(data{$hay},options{$hay});

                                    // And for a doughnut chart
                                    var myDoughnutChart = new Chart(document.getElementById("canvas{$hay}").getContext("2d")).Doughnut(data{$hay},options{$hay++});

                                </script>
                                </div>
                            </div>


                </div>

            {/foreach}

            <div class="clear"></div>
        </div>
    </div>

    <div class="col-4">
        <div class="block-news">
            <h3 class="color-4 p2">Ofrecimientos</h3>
            <div class="wrapper indent-bot">
                <ul class="list-2">
                    {foreach from=$recursosInstit item=recInst}
                        <li>{$recInst->getResource()->getName()}</li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="block-news">
            <h3 class="color-4 p2">Solicitudes</h3>
            <div class="wrapper indent-bot">
                <ul class="list-2">
                    {foreach from=$recursosSubpro item=recInst}
                        <li>{$recInst->getResource()->getName()}</li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="block-news">
            <h3 class="color-4 p2">Instituciones</h3>
            <div class="wrapper indent-bot">
                <ul class="list-2">
                    {foreach from=$institutions item=instit}
                        <li><a href='{$instit->getWebsite()}' target="_blank">{$instit->getNamemostrar()}</a></li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>
</div>