<?php
// definice názvu webu (jako konstanta)
define("NAZEV_WEBU", "Cvičný web pro výuku PHP a SQL");


function polozky_menu() {
/*
Asociativni pole nazvu polozek v navigaci a nazvu souboru.
Prvky pole jsou ve tvaru:
"Název stránky v navigaci" => "nazev-souboru"
!!! za posledni polozkou uz neni carka !!!
*/
$menu = [
    "Domů" => "",
    "O nás" => "o-nas"
];

return $menu; //vraci pole nazvu pro jejich generovani 
}

//funkce presmerovani
function presmerovani()
{
  $redir = str_replace(array("index.php", ".php"), "", $_SERVER['REQUEST_URI']);
  if ($_SERVER['REQUEST_URI'] != $redir)
  {
    header("Location: $redir", 301);
  }
} //konec presmerovani


// zacatek hlavicka
function hlavicka($title) { 
  presmerovani();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= empty($title) ? NAZEV_WEBU : $title; echo " | " . $_SERVER['HTTP_HOST'];  ?></title>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
      
        <div class="hlavicka">
          <a href="./"><?= $_SERVER['HTTP_HOST']; ?></a>
          <p><?= NAZEV_WEBU; ?></p>
        </div> <!-- konec class="hlavicka" -->
        
        <?php menu($title) ?>
        
        <div class="telo">
<?php } // konec fce hlavicka ?>


<?php
// funkce zapati
function footer() { ?>
</div> <!-- konec class="telo" -->

<div class="zapati">
  <p><?= NAZEV_WEBU ?> | &copy; <?= date("Y") . " " . $_SERVER['HTTP_HOST']; ?> </p>
</div> <!-- konec class="zapati" -->

</body>
</html>
<?php } //konec zapati ?>


<?php
function menu($title) {
  ?>
  <div class="menu"> 
    <?php
    foreach (polozky_menu() as $nazev => $odkaz) { ?>
      <a href="./<?=$odkaz?>"<?=($nazev == $title) ? " class='active'" : ""?>><?=$nazev?></a>
      <?php } ?>
    </div> <!-- konec class="menu" -->
    <?php
    } //konec menu
    ?>

