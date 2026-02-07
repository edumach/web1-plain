# Cvičný web pro výuku PHP a SQL

🌐 Živá ukázka: [https://php.edumach.cz/web1-plain/](https://php.edumach.cz/web1-plain/)

Pro malé weby, např. webové prezentace živnostníků nebo zájmových spolků může být jednodušší a z hlediska výkonu i následné správy výhodnější nepoužívat rozsáhlý a “těžkotonážní” redakční systém, např. WordPress.

Na druhou stranu psát vše v čistém HTML a ručně kopírovat společné části není také nic moc.

Nabízí se třetí cesta: skládání stránek pomocí příkazů jazyka PHP.

Existuje mnoho různých technik a způsobů, jak dynamický web nakódovat. Tento je jedním z nich.

---

Pomocí klonování repozitáře si v adresáři webového serveru TuX zprovozněte tento web:

```
$ cd www
$ git clone https://github.com/edumach/web1-plain
```

a vyzkoušejte, zda funguje:

```
https://tux.panska.cz/~10XPrijmeniJ/web1-plain
```

---

## Ne zcela běžné PHP

V kódu jsou použité ne zcela běžné konstrukce. Nejprve se s nimi důkladně seznamte, abyste kódu rozuměli:

**(1) Zkrácená definice ostrůvku** `<?= ?>`

Kódy obsahují mnoho HTML značek a PHP ostrůvků, někdy opravdu minimalistických – řádkových. Jen v souboru `spolecny.php` jich je přes dvacet. V takovém případě je výhodnější (a přehlednější) použít zkrácenou variantu ostrůvku:

```
<?= ... ?>
```

která nahrazuje klasický zápis:

```
<?php echo ...; ?>
```

Znak `=` nahrazuje `echo`. Dokonce před koncem ostrůvku není vyžadován středník. Nic se však nestane, pokud tam bude.

**(2) Konstanty v PHP**

Jako každý jazyk, má i PHP možnost definovat konstanty, tedy proměnné, jejichž hodnota se nikdy nemění. Např. v C se definuje:

```c
const int N = 50;
```

V PHP je totéž:

```php
define("N", 50);
define("NAZEV_WEBU", "Ukázkový web");
```
- Zvláštností konstant v PHP je, že nezačíná znakem `$`.
- Jak v C, tak PHP je zvykem psát je velkými písmeny.


**(3) Podmíněný výraz (ternární)**

Je zkrácená varianta `if-else`. Příklad:

```php
$title = (empty($title)) ? HLAVNI_STRANA : $title;
```
je stejný jako:

```php
if (empty($title)) //jak znamo, vraci True nebo False
{
    $title = HLAVNI_STRANA;
}
else
{
    $title = $title;
}  
```

Za znakem `?` je větev `True`, za `:` `False`. Svou konstrukcí se podobá funkci `KDYŽ()` v Excelu.

**(4) Asociativní pole v PHP**

Jak známo, běžné pole je indexované číselně. V PHP existuje ještě tzv. asociativní pole, kde indexem je první hodnota (ta před `=>`) a hodnotou je druhá položka. Běžně se využívá pro čtení/zápis dat do databázových tabulek. Zde se skvěle hodí pro definici párů hodnot v menu:

```php
$menu = array
(
  HLAVNI_STRANA => "",
  "Druhá stránka" => "druha",
  "Třetí stránka" => "treti"
);
```
nebo i takto pomocí hranatých závorek

```php
$menu =
[
  HLAVNI_STRANA => "",
  "Druhá stránka" => "druha",
  "Třetí stránka" => "treti"
];
```

---

## Popis skriptů

### Princip generování webové stránky

Principem skládání je opakující se části uložit v do jednoho společného souboru. V tomto konkrétním konceptu v podobě podprogramů. Tento soubor se na každé stránce připojí a společné funkce se jednoduše zavolají.

Výsledný HTML kód každé stránky typicky sestává ze:

- společného obsahu **před** samotným obsahem – typicky `<!doctype html>`, `<meta>` značky, hlavička, popřípadě menu,
- společného obsahu **za** samotným obsahem – typicky patička.

Například samotná stránka stranka.php potom bude vypadat nějak takto (schematicky):

```php
<?php
    include "spolecny.php";
    $nazev = "Domů";
    hlavicka($nazev);
    echo "<h1>$nazev</h1>";
?>

<p>Obsah hlavní strany</p>

<?php footer() ?>
```

Soubor `spolecne.php` bude v začátku jen definovat funkce hlavicka a paticka.

### Hlavička (`spolecny.php`)

```php
<?php
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
```

Tato funkce provede následující:

- vypíše HTML 5 hlavičku,
- pokud bude předán titulek, tak nastaví `<title>` na "Název stránky – Název webu"
- připojí CSS a vůbec všechen společný obsah (hlavičku, navigaci atd.).

☝️ Některé HTML značky v rámci této funkce zůstanou neuzavřené – uzavře je až funkce `paticka()`.

### Patička (`spolecny.php`)

Tato funkce je o poznání jednodušší. Stačí v ní v podstatě akorát vypsat běžné HTML (uzavření otevřených značek a vypsání patičky).

```php
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
```

## Hezké adresy

Soubor `.htaccess`

> Pokud soubor nevidíte je to tím, že v Unixu má status skrytý (tečka na začátku). Aby byl vidět, musíte zobrazování skrytých souborů zapnout. Např. ve WinSCP se zapíná/vypíná zkratkou Ctrl+Alt+H. V aplikaci Cyberduck zkratkou ⇧⌘R.

Tento postup řešení skládání stránek sám o sobě nabízí relativně rozumnou podobu adres: `example.com/novinky.php`. Nicméně, můžeme adresy ještě trochu vylepšit přepisem v souboru `.htaccess` na podobu `example.com/novinky` (bez přípony `.php`):

```
RewriteEngine On
Options +FollowSymLinks -MultiViews

# podstrceni PHP, prepsat pouze na existujici skript
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^([^.]+)$    $1.php    [L]

# chybova zprava pri nespravne URL
ErrorDocument 404 "<h1>Error 404: Stranka neexisuje</h1><p><a href='./'>Domu</a></p>"
```

Poslední řádek souboru `.hraccess` slouží k zobrazení chybového hlášení o neexistující stránce. Řešení je velmi primitivní, ale funkční a pro naše potřeby dostačující.


## Přesměrování `.php` adres

K tomu je "čisticí" funkce `presmerovani()`, která se přidá do hlavičky (do funkce `hlavicka()`):

```php
//funkce presmerovani
function presmerovani()
{
  $redir = str_replace(array("index.php", ".php"), "", $_SERVER['REQUEST_URI']);
  if ($_SERVER['REQUEST_URI'] != $redir)
  {
    header("Location: $redir", 301);
  }
} //konec presmerovani
```

## Položky menu a adresy stránek

Položky menu a adresy stránek zajišťuje funkce `polozky_menu()`. Návratovou hodnotou je **pole** `$menu`.

```php
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
?>
```
To si převezme funkce `menu()` a provede jeho výpis:

```php
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
```

Tato funkce `menu()` se zavolá z funkce `hlavicka()` a předá se zadaný titulek, ten se porovná a v případě shody s některou z položek se přidá CSS třída `active`.

Ta je definována v souboru style.css:

```css
.menu a.active {
    background-color: blue;
    color: white;
}
```

## Ostatní CSS třídy

Celý web je ostylovaný pokud možno co nejjednodušeji - obsahuje pouze minimum tříd. Jako bonus je responzivní - to zajišťuje poslední sekce CSS (`@media screen and (max-width: 800px)`):

```css
body {
    max-width: 1000px;
    margin: auto;
    font-family: "Arial", sans-serif;
  }

div.hlavicka {
    margin: 12px 0px 0px 0px;
    text-align: center;
    background-color: lightgray;
    padding: 1em;
}

div.hlavicka a {
    font-size: 2em;
    text-decoration: none;
    color: black;
}

.menu {
    margin: 0;
    padding: 0px 0px 0px 0px;
    background-color: #f1f1f1;
    overflow: auto;
}

.menu a {
    /* display: block; */
    color: black;
    padding: 12px;
    text-decoration: none;
    line-height: 3em;
}

.menu a.active {
    background-color: blue;
    color: white;
}

.menu a:hover:not(.active) {
    background-color: #555;
    color: white;
}

div.telo {
    padding: 1px 16px;
    min-height: 360px;
}

div.zapati {
    padding: 12px 0px 12px 0px;
    text-align: center;
    background-color: lightgray;
}

@media screen and (max-width: 800px) {
    .menu {
        width: 100%;
        height: auto;
        position: relative;
    }
    .menu a {
        display: block;
        padding: 0px 0px 0px 1em;
    }
}
```

---

## Jak přidat novou stránku

Přidání nové stránky se provádí ve třech krocích:

**(1)** Do souboru `spolecny.php` do pole `$menu` přidejte další položku. V ukázce to je soubor `nabidka.php`, který bude v navigaci dostupný pod názvem "Co nabízíme":

Před přidáním:

```php
$menu = [
    "Domů" => "",
    "O nás" => "o-nas"
];
```
Po přidání:
```php
$menu = [
    "Domů" => "",
    "O nás" => "o-nas",         //zde pribude carka
    "Co nabízíme" => "nabidka"  //zde uz carka neni
];
```
**(2)** Vytvoření souboru `nabidka.php`. Podmínkou je, že se musí jmenovat stejně, jako položka v navigaci (pole `$menu`).

**(3)** Vložení kostry kódu do souboru `nabidka.php`:
```php
<?php
    include "spolecny.php";
    $nazev = "Co nabízíme"; //stejny text jako v poli $menu
    hlavicka($nazev);
    echo "<h1>$nazev</h1>";
?>

<!-- zde bude obsah stránky -->

<?php footer(); ?>
```

## 💾 Samostatný úkol


## Obsah webu – fiktivní IT firma

Web bude prezentací malé lokální firmy, která nabízí IT služby (internet, servis, zabezpečení apod.). Texty mohou být krátké, ale musí odpovídat zadání.

Například:

| Firma          | Město   | Založena | Specializace        |
| -------------- | ------- | -------- | ------------------- |
| NetPoint       | Kladno  | 2018     | bezdrátový internet |
| DataLine       | Kolín   | 2016     | správa sítí         |
| SafeNet        | Nymburk | 2020     | zabezpečení         |
| IT-Servis Plus | Beroun  | 2015     | servis PC           |


### 1. O nás (doplnění stávající stránky)

Stránka bude obsahovat:

* **Krátké představení firmy**
  (3–5 vět: čím se firma zabývá, komu poskytuje služby, kde působí – město může být smyšlené)

* **Podnadpis „Naše zaměření“**

* **Odrážkový seznam alespoň 4 položek**, např.:

  * připojení k internetu
  * servis počítačů
  * zabezpečení sítí
  * správa serverů

* **Jednu větu na závěr**, např. o zkušenostech nebo spolehlivosti.


### 2. Služby

Stránka bude obsahovat:

* Úvodní větu (1–2 věty), že firma nabízí IT služby.

* **Tři až čtyři služby**, každá ve struktuře:

  * název služby jako podnadpis,
  * krátký popis (1–2 věty).

Například struktura:

* Připojení k internetu – krátký popis
* Servis počítačů – krátký popis
* Zabezpečení sítí – krátký popis


### 3. Kontakt

Stránka bude obsahovat:

* Název firmy
* Adresu (může být smyšlená, ale realistická)
* Telefon (ve formátu telefonního čísla)
* E-mail jako klikací odkaz
* Otevírací dobu ve formě seznamu nebo krátkého přehledu

Na závěr krátká věta typu: „Těšíme se na spolupráci.“


### Společné požadavky

* každá stránka musí mít hlavní nadpis,
* text musí být rozdělen do odstavců,
* použijte alespoň jeden seznam na každé stránce.



