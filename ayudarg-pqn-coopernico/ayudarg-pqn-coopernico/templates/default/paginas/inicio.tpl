<div class="row-3">
    <div class="slider-wrapper">
        <div class="slider">
            <ul class="items">
                <li><img src="images/slider-img3.jpg" alt="">
                    <strong class="banner">
                        <strong class="b1">Queremos ayudar a quienes</strong>
                        <strong class="b2">AYUDAN</strong>
                        <strong class="b3">Somos una ONG "puente" a las TICs.</strong>
                    </strong>
                </li>
                <li><img src="images/slider-img1.jpg" alt="">
                    <strong class="banner">
                        <strong class="b1">Ser Solidario es</strong>
                        <strong class="b2">ser feliz</strong>
                        <strong class="b3">La ayuda es obrar,<br> los resultados son buenos gestos.</strong>
                    </strong>
                </li>
                <li><img src="images/slider-img4.jpg" alt="">
                    <strong class="banner">
                        <strong class="b1">Hay que crear y edificar una cultura del</strong>
                        <strong class="b2">encuentro</strong>
                        <strong class="b3">Hay que hacer lio</strong>
                    </strong>
                </li>
            </ul>
            <a class="prev" href="#">prev</a>
            <a class="next" href="#">next</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.slider')._TMS({
            prevBu:'.prev',
            nextBu:'.next',
            playBu:'.play',
            duration:800,
            easing:'easeOutQuad',
            preset:'simpleFade',
            pagination:false,
            slideshow:3000,
            numStatus:false,
            pauseOnHover:true,
            banners:true,
            waitBannerAnimation:false,
            bannerShow:function(banner){
                banner
                    .hide()
                    .fadeIn(500)
            },
            bannerHide:function(banner){
                banner
                    .show()
                    .fadeOut(500)
            }
        });
    })
</script>