{*smarty*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    {include file="$pQnHeadTpl"}
</head>
<body>
<div class="main">
    <header>
        {include file="$pQnHeaderTpl"}
    </header>
    <nav>
        {include file="$pQnMenuTpl"}
    </nav>
    <section id="content">
        {include file=$pantalla}
    </section>
    <footer>
        {include file="$pQnFooterTpl"}
    </footer>
</div>
</body>
</html>