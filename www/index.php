<?php
session_start();
if(!(isset($_COOKIE["Person"]))){

setcookie("Person", "d", time()+3600);
}
if(!(isset($_COOKIE["Logined"]))){

setcookie("Logined", "", time()+3600);
}

$servername = "localhost";
$username = "pakhopav";
$password = "webove aplikace";
$data_baze="pakhopav";



error_reporting(0);
ini_set('display_errors', 0);


    $DB =  mysqli_connect($servername, $username, $password, $data_baze);



function checkLen($vari){
    $nvari = trim($vari);
    return(strlen($nvari)>= 5);
}

$cond = "";
if (isset($_POST['RegButton'])){

    $usn =mysqli_real_escape_string($DB, $_POST['username']);
    $usm =mysqli_real_escape_string($DB, $_POST['email']);
    $usp =mysqli_real_escape_string($DB, $_POST['password']);
    $uspr =mysqli_real_escape_string($DB, $_POST['passwordRep']);
    if((!(strpos($usn, " "))) && (!(strpos($usm, " "))) && (!(strpos($usp, " ")))){
        $avName = false;
        $avMail = false;
        $avPas = false;
        $avPasRep = false;
        if (!checkLen($usp) ){
            $cond = "Password is too short";
        }else{
            $avPas = true;
        }
        if ($uspr !=  $usp ){
            $cond = "Passwords are not same";
        }else{
            $avPasRep = true;
        }
        $result = mysqli_query($DB,"SELECT 1 FROM users WHERE username='$usn' LIMIT 1");
        if (mysqli_fetch_row($result)) {
            $cond = "This username is already used";
        }elseif(!checkLen($usn) ){
            $cond = "Username is too short";
        }else{
           $avName= true;

        }
        $result = mysqli_query($DB,"SELECT 1 FROM users WHERE mail='$usm' LIMIT 1");
        if (mysqli_fetch_row($result)) {
            $cond = "This email is already used";
        }elseif (!checkLen($usm) ){
            $cond = "Mail is too short";
        } else {
           $avMail= true;
        }
        if ($avMail && $avName){
            if (CRYPT_STD_DES == 1) {
                $newUsp = crypt($usp,'st');
            }
            $new = mysqli_query($DB, "INSERT INTO users (username, mail, password) VALUES ('$usn', '$usm','$newUsp')");
            $cond = "Your registration completed successfully";
        }
    }else {

         $cond =  "No white spaces available"  ;


    }


}
if (isset($_POST['WriteButton'])){
    $mes =mysqli_real_escape_string($DB, $_POST['message']);
    $usnF = $_COOKIE["Person"];
    $new = mysqli_query($DB, "INSERT INTO forum (user, message) VALUES ('$usnF', '$mes')");

}


if (isset($_POST['LogButton'])){

    $usnL =mysqli_real_escape_string($DB, $_POST['usernameLog']);

    $uspL =mysqli_real_escape_string($DB, $_POST['passwordLog']);
    if (CRYPT_STD_DES == 1) {
                $newUspL = crypt($uspL,'st');
            }

    $result = mysqli_query($DB,"SELECT * FROM users WHERE username='$usnL' AND password='$newUspL'");
    if (mysqli_fetch_row($result)) {
        setcookie("Logined", "yes", time()+3600);
        setcookie("Person", $usnL, time()+3600);



    } else {
       echo "<script>alert('wrong login or password');</script>";
    }
}
function vratZPost($co) {
if (isset($_POST[$co]))
return htmlspecialchars($_POST[$co]);
return "";
}

function showChat($DB){
    $test = mysqli_query($DB,"SELECT * FROM forum ");
    while($var = mysqli_fetch_assoc($test)){
        echo "<div class='media'>";
        echo "<img src='pics/whiteSquare.jpg' class='align-self-start mr-3' alt='...'>";
        echo "<div class='media-body'>";
        echo "<h5 class='mt-0'>".htmlspecialchars($var["user"])."</h5>";
        echo "<p>".htmlspecialchars($var["message"])."</p></div></div><br>";




    }
}








// Základy Webových Aplikací
// Semestrálny projekt

// Název projektu:
// MOLLY










// 2018/2019 LS                    Autor práce: Pavel Pakhomov
// Obsah
// Úvod    3
// 1   Implementáce    4
// 1.1 Zabezpečení 4
// 1.1.1   SQLi    4
// 1.1.2   XSS 4
// 1.1.3   Hesla   4
// 1.2 Zpracovaní dát  5
// 1.3 Knihovny a funkce   5
// 1.3.1   PHP funkce  5
// 1.3.2   JS funkce   5
// 2   Interface   7
// 2.1 UI  7
// 2.2 Manuál  7

// Úvod

// Cílem je vytvořit webstránku, věnovanou hudební skupině „Poshlaya Molly“ . Tato stránka musí obsahovat zakladní informace o skupíně(členy skupiny, historie vzniku, poslední aktuality). Navíc stránka bude poskytovat možnost registrace a přihlašení. Přihlašení bude nabízet speciální možnosti, jako možnost poslouchaní hudby a možnost měnit vzhled stránky.


// 1   Implementace
// Stránka je psána formou dynamického webu(jde o SPA, používá se cookies). Používá se skriptování jak na serverové straně, tak i na klientské. U klienta je to zejména grafika (animace), validace údajů, „pagination“ bloků kontentu a práce s cookie proměnnami. Na serverů je celý backend (přihlašování, zpracování dát, operace s databází).
// 1.1 Zabezpečení
// Byly použity bezpečnostní praktiky pro prevenci před útoky jako např. SQLi, XSS, CSRF. Hesla jsou uloženy v bezpečné podobě a požadovaná délka je alespoň 5 znaků.
// 1.1.1   SQLi
//    Odolnost proti SQL injection útoků zabezpečuje především funkce PHP "mysqli_reál_escape_string", která při skládání SQL dotazů provede syntaktické SQL znaky na jejich bezpečnou podobu. Tím pádem není možné dotaz významově ani funkčně upravit.
// 1.1.2   XSS
// Údaje které zadáné uživately na stránce vyskytujou jenom v poličkach „input“ a jsou zobrazené přes funkce „ htmlspecialchars( )“ , takže utočnik nebude schopen nějak poškodit kód.

// 1.1.3   Hesla
// Hesla jsou osolené, přepisané pomoci PHP funkce „crypt()“ a uložené v databáze.
// 1.2 Zpracování dát

// Data odeslané uživatelům jsou ověřovány pro správnost formátu ještě na klientské straně a pokud je vše v pořádku, tak se odešlou na server. Všechny získané údaje se znovu validovány na správnost. A pak se s nimi provede obvykle poptávka do databáze,jestli již uživatel s takovým jménem nebo mailem existuje. Veškera informace uložena v jedné tabulce se sloupce: „id“, „username“, „email“  a „password“. Login logika je provědena tím že server ověřuje schodnost uživatelem uvedených dát s těmi co má v databazích.
// 1.3 Knihovny a funkce
// V svém projektu jsem použival Bootstrap, proto jsem musel integrovat několik externích knihoven, pro zajištění správné funkce tohoto framework. Rovněž pro zajištění vlastní funkcionality bylo potřeba vytvořit vlastní funkce. Týká se to jazyků PHP a JS jejichž soubory se nacházejí respektive v jejich jednotlivých složkách.
// 1.3.1   PHP funkce
// Co se tyče PHP, veškerý kód se nachazí přimo v hlavním dokumentu „index.php“. V něm je naimplementovana logika pro validace formulařů, cryptovaní a solení hesel a odesilaní dát do databazí.
// 1.3.2   JS funkce
// Všechní funkce JS jsou v souboru „script.js“. Na jeho starostí je skoro veškera logika mého SPA. To jsou určování sučasného kontentu, sledovaní eventů, „pagination“, práce s COOKIE proměnnymi, validace formulařu na straně klienta, skinovatelnost webu a naimplementovaný média player.
// 2   Interface
// Můj projekt je SPA s použitím Bootstrap frameworku. Má minimalistický design v černobílých bárvach i když existuje možnost změnit témat na „noční“ (pro přihlašené uživatele). Bloky kódu se zobrazujou nebo skrzvají se podle stisknutí určitých tlačitek nebo jiných eventů, informace o „current“ stavu je uložena do COOKIES proměnnych. Taky je možnost poslouchat hudbu rock bandu „Poshlaza Molly“. V dáný okamžik je k dispozice 3 posledních alba skupiny.
// 2.1 UI
// Na hlavní stránce Vás čeká zakladní informace o skupině a tá krasně uspořadaná pomoci Bootstrap gridu. Stisknutím tlačitka “News“  budete přemístěny do bloku s zprávami o skupině za poslední půl roku. Tlačitka „Registrate“ a „Login“ jsou pro přihlašení. Uvidíte formy podle Bootstrapového šablonu. Pokud se přihlasite budete mít možnost skusit ještě 2 tlačitka: „Listen“ a „Day/Night“. První otevře média player, zatím co druhý bude měnit téma stránky.
// 2.2 Manuál
// Ovladaní stránkou je jednoduché. Uživatel vybíra blok kontentu který chce pomoci stisknutí spravného tlačitka na navigačním měnu. V jednotlivých blokách kontenta je možně pohybovat pomocí kolečka myši(nebo šipek nahoru/dolů). Pro první přihlašení musí přejit do bloku „Registration“, kde bude muset vyplnit všechni polička (všchní jsou povinné ). Heslo a jméno uživatele musí obsahovat aspoň 5 symbolů a žadné mezery. Mail musí být také validní podle všech požadavků(existence „@“ atd.). Pak, pokud registrace proběhla uspěšně uživatel se muže přihlasit v oddílu „Login“ s pravě vytvořenými údaje. Po přihlašení je možně využivat média player. Je potřeba nejprve vybrat album, a pak ovládat playerem pomoci tlačitek „minulý tack“, „play/stop“, „dalši track“. Taky je k dispozici nástroj pro změnu tématu stránky: tlačitko Day/Night.

?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css">
<title>MOLLI</title>
</head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <a href="#contentHome" id="Homebtn" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                <a href="#contentNews" id="Newsbtn" class="nav-link">News</a>
                </li>
                <li class="nav-item">
                <a href="#contentListen" id="Listenbtn" class="nav-link disabled">Listen</a>
                </li>
            </ul>
            <button class="btn btn-outline mr-sm-2 servB" id="Log">Login</button>
            <button class="btn btn-outline mr-sm-2 servB" id="Reg">Registrate</button>
            <button class="btn btn-outline mr-sm-2 servB" id="forum">Forum</button>
            </div>
        </nav>
        <?php
        if (mysqli_connect_errno()) {
            printf("Database connection error");

        }

        ?>
       <!--  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <a href="#" class="navbar-brand">
            SEMESTRALKA
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <a href="#contentHome" id="Homebtn" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                <a href="#contentNews" id="Newsbtn" class="nav-link">News</a>
                </li>
                <li class="nav-item">
                <a href="#contentListen" id="Listenbtn" class="nav-link disabled">Listen</a>
                </li>
                </ul>
                <button class="btn btn-outline mr-sm-2 servB" id="Log">Login</button>

                <button class="btn btn-outline mr-sm-2 servB" id="Reg">Registrate</button>
                <button class="btn btn-outline mr-sm-2 servB" id="forum">Forum</button>
            </div>
        </nav> -->

        <div id="DayNight">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary" id="Day">Day</button>
                <button type="button" class="btn btn-secondary" id="Night">Night</button>

            </div>
        </div>
        <div class="container-fluid contentPM" id="contentHome">
            <div id="home"></div>
            <div class="container-fluid mt-50">
            <div class="row justify-content-center">
            <div class="col-3"><h1>Poshlaya Molly</h1></div>
            </div>
            <div class="row" id="row-with-mt">
                <div class="col-2">
                </div>
                <div class="col-lg-5 col-12" >
                    <img src="pics/Homepic.jpg" class="img-fluid"
                    alt="KARTINKA">
                </div>
                <div class="col-lg-3 col-12">
                    <p>
                        "Dirty Molly" - Ukrainian pop punk band, founded by a musician from Kharkov
                        Cyril Tymoshenko, better known under the pseudonym Cyril Pale. <br>
                        The group is one of the most prominent representatives of synth-punk in Ukraine,
                        combining pop punk with electronic music. <br>
                        The leader of the group speaks of "The Dirty Molly" as a collective image of a spoiled
                        schoolgirls
                    </p>

                </div>
                <div class="col-2"></div>
            </div>
            <div id="sostav"></div>
            <div class="row justify-content-center mt-50" >
                <div class="col-3" >
                    <h1>Band members</h1>
                </div>
            </div>
            </div>
            <div class="container Band">
                <div class="row r1 mt-30" >
                    <div class="col-1"></div>
                    <div class="col-5 align-self-center names"><p>Cyril Pale - vocals, guitar, music</p>
                    </div>
                    <div class="col-5"><img src="pics/bled.jpg" alt="" class="img-fluid
                    rounded" ></div>
                    <div class="col-1"></div>
                </div>
                <div class="row r2">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <img src="pics/gonch.PNG" alt="" class="img-fluid rounded"  >
                     </div>
                    <div class="col-5 align-self-center names"><p>Dmitry Goncharenko - bass guitar</p></div>
                    <div class="col-1"></div>
                </div>
                <div class="row r1">
                    <div class="col-1"></div>
                    <div class="col-5 align-self-center names"><p>Konstantin Pyzhov - guitar</p></div>
                    <div class="col-5">
                        <img src="pics/pyz.jpg" alt="" class="img-fluid rounded" >
                    </div>
                    <div class="col-1"></div>
                </div>
                <div class="row r2">
                <div class="col-1"></div>
                <div class="col-5"><img src="pics/khol.jpg" alt="" class="img-fluid rounded"></div>
                <div class="col-5 align-self-center names"><p>Pavel Kholodiansky - drums</p></div>
                <div class="col-1"></div>
                </div>
                <div id="history"></div>
                <div class="row justify-content-center mt-30" >
                <div class="col-3"><h1>History</h1></div>
                </div>
                <div class="row mt-50" >
                <div class="col-1"></div>
                <div class="col-5"><img src="pics/koncert.jpg" class="img-fluid rounded" alt=""></div>
                <div class="col-5">
                    <p>
                        Kirill Timoshenko, the founder of the group, was born in the city of Zmiev,
                        Ukraine . The group was formed in February 2016. <br>
                        On February 24, 2017, the debut music album with eight compositions with
                        called “8 ways to quit jerking” , which quickly gained popularity, in
                        particulars in the social network VKontakte . June 9, 2017 released the first video
                        groups for the song “Your sister’s favorite song” , which scored several million
                        views on youtube. <br>
                        On January 29, 2018, a six-album mini-album entitled “Sad
                        a girl with eyes like a dog ”. A few days later came the video for the song
                        “A typical pool party” . <br>
                        November 23, 2018 released a mini-album of four tracks called "VERY
                        TERRIBLE MOLLY 3. Part 1 ".
                    </p>
                </div>
                <div class="col-1"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid contentPM" id="contentNews">
            <div class="container-fluid">
                <div class="row mt-30">
                    <div class="col-3">

                    </div>
                    <div class="col-6">
                        <div class="newsItem">
                            <div class="container-fluid">
                                <div class="row mt-30">
                                    <div class="col-9"><h4>Poshlaya Molli on Comedy Club</h4></div>
                                    <div class="col-3"><small>10.1.2019</small></div>
                                </div>
                                <div class="row ">
                                    <div class="col-7">
                                        <video  controls>
                                            <source src="pics/comclub.mp4" type="video/mp4">
                                        </video>
                                    </div>
                                    <div class="col-5" ><p>"Poshlaya Molly" attended a Russian stand-up comedy TV show "Comedy Club" on 21.12.2018. The band was welcomed very warmly by the hosts. Also the group was asked to explain lyrics of their new released song, because it caused a lot of controversy in the internet.</p>
                                    </div>
                                </div>
                            </div>




                        </div>
                    <div class="col-3"></div>
                </div>
                </div>
                <div class="row mt-30">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <div class="newsItem">
                            <div class="container-fluid">
                                <div class="row mt-30">
                                    <div class="col-9"><h4>New clip</h4></div>
                                    <div class="col-3"><small>6.12.2018</small></div>
                                </div>
                                <div class="row ">
                                    <div class="col-7">

                                            <iframe src="https://www.youtube.com/embed/c1mkb3HHmog"></iframe>

                                    </div>
                                    <div class="col-5" ><p>"Poshlaya Molly" released new clip for a song "CTRL+Zzz" from its last album VERY SCARY MOLLY (VOL. 1). On 13.1.2019 it has over 2 millions views and 90 thousands likes.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <div class="col-3"></div>
                </div>
                </div>
                <div class="row mt-30">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <div class="newsItem">
                             <div class="container-fluid">
                                <div class="row mt-30">
                                    <div class="col-9"><h4>EP</h4></div>
                                    <div class="col-3"><small>23.11.2018</small></div>
                                </div>
                                <div class="row ">
                                    <div class="col-7">

                                            <img src="pics/och.jpg" alt="">

                                    </div>
                                    <div class="col-5" ><p>After nearly 10 months from band's previous album, the new one got released. It's called VERY SCARY MOLLY (VOL. 1). We expect "Poshlaya Molly" to drop the second part of the EP(Extended play) in the near future.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-3"></div>
                </div>
                </div>



            </div>
        </div>
        <div id="Back"><img src="pics/backB.png" alt=""></div>
        <div class="container-fluid contentPM" id="contentListen">

            <div class="container">
                <div class="row justify-content-center mt-50" >
                    <div class="col-4"></div>
                    <div class="col-4 Listen">
                        <h1>Listen</h1>
                    </div>
                    <div class="col-4"></div>
                </div>
            </div>
            <div class="card mus hov bigBody" id="mus1" >
                <img
                src="pics/och.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="AlbomName"><p>Ochen strashnaya Molly</p></div>
                    <div class="Media">
                        <div class="SongName">Song </div>
                        <div class="Buttoms">
                            <div class="prev"><img src="pics/prevB.png" alt=""></div>
                            <div class="play"><img src="pics/playB.png" alt=""></div>
                            <div class="next"><img src="pics/nextB.png" alt=""></div>
                        </div>
                        <div class="Bar"><div class="Fill"></div></div>

                    </div>
                </div>
            </div>
            <div class="card mus hov bigBody" id="mus2" >
                <img
                src="pics/gru.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="AlbomName"><p>Grustnaya devochka </p></div>
                    <div class="Media">
                        <div class="SongName"><p>Song</p> </div>
                        <div class="Buttoms">
                            <div class="prev"><img src="pics/prevB.png" alt=""></div>
                            <div class="play"><img src="pics/playB.png" alt=""></div>
                            <div class="next"><img src="pics/nextB.png" alt=""></div>
                        </div>
                        <div class="Bar"><div class="Fill"></div></div>

                    </div>
                </div>
            </div>
            <div class="card mus hov bigBody" id="mus3" >
                <img
                src="pics/spos.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="AlbomName"><p>8 sposobov brosit drochit</p></div>
                    <div class="Media">
                        <div class="SongName"><p>Song</p> </div>
                        <div class="Buttoms">
                            <div class="prev"><img src="pics/prevB.png" alt=""></div>
                            <div class="play"><img src="pics/playB.png" alt=""></div>
                            <div class="next"><img src="pics/nextB.png" alt=""></div>
                        </div>
                        <div class="Bar"><div class="Fill"></div></div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container contentPM" id="Login">
            <div class="row mt-50">
                <div class="col-4"></div>
                <div class="col-4">
                    <form method="post" id="LogForm"   action="/~pakhopav/semestralka/#contentHome">
                        <div class="form-group">
                            <label for="usernameLog">Username</label>
                            <input type="text" class="form-control" id="usernameLog" name="usernameLog"  value="<?php echo vratZPost('usernameLog') ?>" placeholder="Enter Username">

                        </div>
                        <div class="form-group">
                            <label for="passwordLog">Password</label>
                            <input type="password" class="form-control" id="passwordLog" name="passwordLog"   value="<?php echo vratZPost('passwordLog') ?>" placeholder="Password">
                        </div>
                        <button type="submit" name="LogButton" class="btn btn-primary">Submit</button>
                    </form>

                </div>
                <div class="col-4"></div>
            </div>

        </div>
        <div class="container contentPM" id="Registrate">
            <div class="row mt-50">
                <div class="col-4"><p id="result"><?php echo "$cond"; ?></p></div>
                <div class="col-4">
                    <form method="post" id="RegForm"   action="#">
                            <div class="form-group ">
                                <label for="username">Username</label>
                                <input type="text" id="username" class="form-control" name="username" value="<?php echo vratZPost('username') ?>" placeholder="Enter Username" required>

                            </div>

                            <div class="form-group ">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo vratZPost('email') ?>" placeholder="Enter email" required>

                            </div>


                            <div class="form-group">

                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?php echo vratZPost('password') ?>"  placeholder="Password" required>

                            </div>



                            <div class="form-group">
                                <label for="passwordRep">Repeate Password</label>
                                <input type="password" class="form-control" id="passwordRep" value="<?php echo vratZPost('passwordRep') ?>" name="passwordRep" placeholder="Password" required>

                            </div>
                            <button type="submit" id="RegButton" name="RegButton" class="btn btn-primary mt-30 ">Submit</button>

                    </form>

                </div>
                <div class="col-4">
                    <div class="error">required</div>
                    <br>
                    <div class="error">required</div>
                    <br>
                    <div class="error">required</div>
                    <br>
                    <div class="error">required</div>
                </div>
            </div>
        </div>
        <div class="container contentPM" id="Forum">
            <div class="row">
                <div class="col-3">

                </div>
                <div class="col-6">
                    <div id="chatBlock">
                        <?php showChat($DB); ?>

                    </div>
                    <div id="chatForm">
                        <form action="#" method="post" id="ForumForm">
                            <input type="text" name="message" id="Message" placeholder="write message" required>
                            <button type="submit" name="WriteButton" id="WriteButton"  class="btn btn-secondary">Send</button>
                        </form>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
        <script src="script.js"></script>
        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
