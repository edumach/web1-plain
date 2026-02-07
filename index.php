<?php
    include "spolecny.php";
    $nazev = "Domů";
    hlavicka($nazev);
    echo "<h1>$nazev</h1>";
?>

<p>Cvičný web. Vodorovná navigace, responzivní, stylovaný pomocí CSS.</p> 

<h3>Jak přidat novou stránku</h3>

<p>Přidání nové stránky se provádí ve <b>třech krocích</b>:</p>

<hr>

<p><b>(1)</b> Do souboru <code>spolecny.php</code> do pole <code>$menu</code> přidejte další položku. V ukázce to je soubor "<b>nabidka.php</b>", který bude v&nbsp;navigaci dostupný pod názvem "<b>Co nabízíme</b>":</p>


<p>Před přidáním:
<pre>
$menu = [
    "Domů" => "",
    "O nás" => "o-nas"
];
</pre>
</p>

<p>Po přidání:
<pre>
$menu = [
    "Domů" => "",
    "O nás" => "o-nas",         //zde pribude carka
    "Co nabízíme" => "nabidka"  //zde uz carka neni
];
</pre>
</p>

<hr>

<p><b>(2)</b> Vytvoření souboru <code>nabidka.php</code>. Podmínkou je, že se musí jmenovat stejně, jako položka v navigaci (pole <code>$menu</code>).</p>

<hr>

<p><b>(3)</b> Vložení kostry kódu do souboru <code>nabidka.php</code>:</p>

<pre>
&lt;?php
    include "spolecny.php";
    $nazev = "Co nabízíme"; //stejny text jako v poli $menu
    hlavicka($nazev);
    echo "&lt;h1>$nazev&lt;/h1>";
?>

&lt;!-- zde bude obsah stránky -->

&lt;?php footer(); ?>
</pre>

<hr>


<?php footer() ?>