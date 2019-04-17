function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

setCookie("currContent" ,"contentHome", 1);
setCookie("DayOrNight" ,"day", 1);
var array = document.getElementsByClassName("contentPM");
var chatBox = document.getElementById("chatBlock");
document.body.onload = function () {


    if (getCookie("Logined") == "yes"){
        chatBox.scrollTo(0,chatBox.scrollHeight);

        privilegii();


        if (getCookie("praveLogin") == "true"){
            document.cookie = "currContent=contentHome";
            alert("Welcome back, bandit! Now you can listen to music and change page theme. Enjoy:) ");
            document.cookie = "praveLogin=false";

        }

        document.getElementById("Log").textContent = "Logout";
        document.getElementById("Listenbtn").classList.remove("disabled");
    }else {
        Noprivilegii();
        document.getElementById("Log").textContent = "Login";
        document.getElementById("Listenbtn").classList.add("disabled");

    }

    if (getCookie("DayOrNight") === "day")  {
        Dayf();
    }
    else {
        Nightf();
    }


    for (var i = 0; i < array.length; i++ ){

        if(array[i].id == getCookie("currContent")) {

            array[i].style.display = 'block';

        }

        else{

            array[i].style.display = 'none';

        }

    }

}
function Dayf() {
    document.body.style.backgroundColor = "#FFFFFF";
    var p = document.querySelectorAll("p");
    for(i = 0; i< p.length; i++){
        p[i].style.color = "black";
    }
    var r1 = document.getElementsByClassName("r1");
    for(i = 0; i< r1.length; i++){
        r1[i].style.background= "#F4F4F4";
    }
    var newsItem = document.getElementsByClassName("newsItem");
    for(i = 0; i< newsItem.length; i++){
        newsItem[i].style.background= "rgba(219, 219, 219, 0.6)";
    }
    var h1 = document.querySelectorAll("h1");
    for(i = 0; i< h1.length; i++){
        h1[i].style.color = "black";
    }
    var h3 = document.querySelectorAll("h3");
    for(i = 0; i< h3.length; i++){
        h3[i].style.color = "black";
    }
    var h4 = document.querySelectorAll("h4");
    for(i = 0; i< h4.length; i++){
        h4[i].style.color = "black";
    }
}
function Nightf() {
    document.body.style.backgroundColor = "#606060";
    var p = document.querySelectorAll("p");
    for(i = 0; i< p.length; i++){
        p[i].style.color = "#FF7500";
    }
    var h1 = document.querySelectorAll("h1");
    for(i = 0; i< h1.length; i++){
        h1[i].style.color = "#FF7500";
    }
    var h3 = document.querySelectorAll("h3");
    for(i = 0; i< h3.length; i++){
        h3[i].style.color = "#FF7500";
    }
    var h4 = document.querySelectorAll("h4");
    for(i = 0; i< h4.length; i++){
        h4[i].style.color = "#FF7500";
    }
    var r1 = document.getElementsByClassName("r1");
    for(i = 0; i< r1.length; i++){
        r1[i].style.background= "#6F6F6F";
    }
    var newsItem = document.getElementsByClassName("newsItem");
    for(i = 0; i< newsItem.length; i++){
        newsItem[i].style.background= "rgba(111, 111, 111, 0.8)";
    }
}
setCookie("praveLogin", "false");
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}



var HomeButton = document.getElementById("Homebtn");

HomeButton.onclick = function(){
    document.cookie = "currContent=contentHome";
    var array = document.getElementsByClassName("contentPM");

    for (var i = 0; i < array.length; i++ ){

        if(array[i].id == "contentHome") {

            array[i].style.display = 'block';

        }

        else{

            array[i].style.display = 'none';

        }

    }

};

var NewsButton = document.getElementById("Newsbtn");

NewsButton.onclick = function(){
    document.cookie = "currContent=contentNews";
    var array = document.getElementsByClassName("contentPM");

    for (var i = 0; i < array.length; i++ ){

        if(array[i].id == "contentNews") {

            array[i].style.display = 'block';

        }

        else{

            array[i].style.display = 'none';

        }

    }

};
var LogButton = document.getElementById("Log");

LogButton.onclick = function(){
    if(getCookie("Logined") == "no"){
        document.cookie = "currContent=Login";
        var array = document.getElementsByClassName("contentPM");
        document.cookie = "praveLogin=true";

        for (var i = 0; i < array.length; i++ ){

            if(array[i].id == "Login") {

                array[i].style.display = 'block';

            }

            else{

                array[i].style.display = 'none';

            }

        }
    }else {
        document.cookie = "Logined=no";
        this.textContent = "Login";
        Noprivilegii();
        document.cookie = "currContent=contentHome";
        document.cookie = "DayOrNight=day";
        location.reload();

    }


};
var RegButton = document.getElementById("Reg");

RegButton.onclick = function(){
    document.cookie = "currContent=Registrate";
    var array = document.getElementsByClassName("contentPM");

    for (var i = 0; i < array.length; i++ ){

        if(array[i].id == "Registrate") {

            array[i].style.display = 'block';

        }

        else{

            array[i].style.display = 'none';

        }

    }

};

var ListenButton = document.getElementById("Listenbtn");

ListenButton.onclick = function(){
    document.cookie = "currContent=contentListen";
    var array = document.getElementsByClassName("contentPM");

    for (var i = 0; i < array.length; i++ ){

        if(array[i].id == "contentListen") {

            array[i].style.display = 'block';

        }

        else{

            array[i].style.display = 'none';

        }

    }

};
var ForumButton = document.getElementById("forum");

ForumButton.onclick = function(){
    document.cookie = "currContent=Forum";
    var array = document.getElementsByClassName("contentPM");

    for (var i = 0; i < array.length; i++ ){

        if(array[i].id == "Forum") {

            array[i].style.display = 'block';

        }

        else{

            array[i].style.display = 'none';

        }

    }

};
var name_of_mus ;
var number_of_mus = -1;
var openedCard= false;
var mus1Button = document.getElementById("mus1");

mus1Button.onclick = function(){
    if(!openedCard){
        currentSong = 0;
        number_of_mus = 0;
        SongName[0].textContent = parseSongName();
        song.src = songs[0][currentSong];

        name_of_mus = "mus1";

        this.classList.add('horizTranslate');

        var Mus2 = document.getElementById("mus2");

        var Mus3 = document.getElementById("mus3");

        Mus2.style.display= 'none';

        Mus3.style.display= 'none';

        this.classList.remove('hov');
        var card = this.children;
        var card_body = card[1].children;
        card_body[0].style.display = "none";
        card_body[1].style.display = "block";
        openedCard= true;

        card[1].style.height = "8vw";
        var back = document.getElementById("Back");
        back.style.display = "block";

    }


}

var mus2Button = document.getElementById("mus2");

mus2Button.onclick = function(){
    if(!openedCard){
        currentSong = 0;
        number_of_mus = 1;
        SongName[1].textContent = parseSongName();
        song.src = songs[1][currentSong];
        name_of_mus = "mus2";


        var Mus1 = document.getElementById("mus1");

        var Mus3 = document.getElementById("mus3");

        Mus1.style.display= 'none';

        Mus3.style.display= 'none';

        this.classList.remove('hov');
        var card = this.children;
        var card_body = card[1].children;
        card_body[0].style.display = "none";
        card_body[1].style.display = "block";
        openedCard= true;
        card[1].style.height = "8vw";
        var back = document.getElementById("Back");
        back.style.display = "block";

    }
}
var mus3Button = document.getElementById("mus3");

mus3Button.onclick = function(){
    if(!openedCard){
        currentSong = 0;
        number_of_mus = 2;
        SongName[2].textContent = parseSongName();
        song.src = songs[2][currentSong];
        name_of_mus = "mus3";
        this.classList.add('horizTranslate');

        var Mus1 = document.getElementById("mus1");

        var Mus2 = document.getElementById("mus2");

        Mus1.style.display= 'none';

        Mus2.style.display= 'none';

        this.classList.remove('hov');
        var card = this.children;
        var card_body = card[1].children;
        card_body[0].style.display = "none";
        card_body[1].style.display = "block";
        openedCard= true;
        this.classList.add('bigBody');
        card[1].style.height = "8vw";
        var back = document.getElementById("Back");
        back.style.display = "block";

    }
}
var back = document.getElementById("Back");
back.onclick = function () {
    var Mus1 = document.getElementById("mus1");
    var Mus2 = document.getElementById("mus2");
    var Mus3 = document.getElementById("mus3");
    var curr = document.getElementById(name_of_mus);
    Mus1.style.display= 'block';

    Mus2.style.display= 'block';
    Mus3.style.display= 'block';
    var card = curr.children;
    var card_body = card[1].children;
    card_body[0].style.display = "block";
    card_body[1].style.display = "none";
    card[1].style.height = "2.5vw";
    curr.classList.remove('horizTranslate');
    curr.classList.add('hov');
    openedCard = false;
    song.pause();
    this.style.display="none";
    PlayButton[number_of_mus].src ="pics/pauseB.png";

}
var play_or_not = true;
var songs = [
    ["audios/pornhab-krismas-klab.mp3","audios/ctrl-zzz.mp3", "audios/lol.mp3"],
    ["audios/budu-tvoim-pesikom.mp3", "audios/glass.mp3", "audios/rayskie-cvety.mp3", "audios/tipichnaya-vecherinka-s-baseynom.mp3", "audios/vse-hotyat-menya-pocelovat.mp3", "audios/znachit-druzhba.mp3"],
    ["audios/dazhe-moya-beybi-ne-znaet.mp3", "audios/hannamontana.mp3", "audios/lyubimaya-pesnya-tvoey-sestry.mp3", "audios/molli.mp3", "audios/non-stop.mp3", "audios/paki-pusi.mp3","audios/supermarket.mp3", "audios/tmsts.mp3",  ]
];

var song = new Audio();

var  currentSong = 0;

var SongName = document.getElementsByClassName("SongName");

var PlayButton = document.getElementsByClassName("play");
var NextButton = document.getElementsByClassName("next");
var PrevButton = document.getElementsByClassName("prev");
for (i = 0 ; i< PlayButton.length; i++){
    PlayButton[i].addEventListener("click", PlaySongButton);
}
function PlaySongButton() {
    if(play_or_not){

        song.play();

        this.children[0].src ="pics/pauseB.png";
        play_or_not = false;
    }
    else{
        song.pause();
        this.children[0].src ="pics/playB.png";
        play_or_not = true;
    }

}

for (i = 0 ; i< NextButton.length; i++){
    NextButton[i].addEventListener("click", NextSongButton);
}
function NextSongButton(){
    song.pause();
    inc();
    song.src = songs[number_of_mus][currentSong];
    song.play();
    SongName[number_of_mus].textContent = parseSongName();
    PlayButton[number_of_mus].children[0].src ="pics/pauseB.png";
    play_or_not = false;


}
for (i = 0 ; i< PrevButton.length; i++){
    PrevButton[i].addEventListener("click", PrevSongButton);
}
function PrevSongButton(){
    song.pause();
    currentSong--;
    if (currentSong == -1){
        currentSong = songs[number_of_mus].length-1;
    }
    SongName[number_of_mus].textContent = parseSongName();
    song.src = songs[number_of_mus][currentSong];
    song.play();

    PlayButton[number_of_mus].children[0].src ="pics/pauseB.png";
    play_or_not = false;
}

var FillBar = document.getElementsByClassName("Fill");
song.addEventListener("timeupdate", function () {
    var pos = song.currentTime / song.duration;

    FillBar[number_of_mus].style.width = pos *100 +'%';
    f();




})
function f() {
    if (song.currentTime == song.duration) {
        NextSongButton();
    }
}

function inc() {
    currentSong++;
    if(currentSong == songs[number_of_mus].length ){
        currentSong = 0;
    }

}
function parseSongName() {
    var res =songs[number_of_mus][currentSong].slice(7, -4);
    return res;

}

var Night = document.getElementById("Night");

Night.onclick = function () {
    document.cookie = "DayOrNight=night";
    Nightf();

}
var Day = document.getElementById("Day");

Day.onclick = function () {
    document.cookie = "DayOrNight=day";
    Dayf();

}
var form = document.querySelector("form");
form[0].addEventListener("submit"
    , function(e) {
        e.preventDefault(); // formuláø nebude odeslán
    });

var ValidUsername = false;
var ValidUsernameLog = false;
var ValidEmail = false;
var ValidPassword = false;
var ValidPasswordLog = false;
var ValidPasswordRep = false;
var errors = document.getElementsByClassName("error");

var userNameInput= document.getElementById("username");
if (userNameInput.value.length != 0){
    errors[0].style.visibility= "hidden";
    if (userNameInput.value.length >= 5){
        ValidUsername = true;
    }
}
userNameInput.addEventListener("keyup",
    function () {
        if (this.value.length < 5){

            errors[0].style.visibility = "visible";
            errors[0].textContent = "Username should be at least 5 symbols";
            ValidUsername = false;
        }else {
            errors[0].style.visibility = "hidden";
            errors[0].textContent = "required";
            ValidUsername = true;
        }
        if (this.value.length == 0){
            errors[0].textContent = "required";
            errors[0].style.visibility = "visible";
        }

    })
var userMailInput= document.getElementById("email");
if (userMailInput.value.length != 0){
    errors[1].style.visibility= "hidden";
    if ((userMailInput.value.indexOf('@') != -1) && (userMailInput.value.indexOf('@') != userMailInput.value.length-1)) {
        ValidEmail = true;
    }
}
userMailInput.addEventListener("keyup",
    function () {
        if (this.value.indexOf('@') == -1){
            errors[1].style.visibility = "visible";
            errors[1].textContent = "Mail address should contain '@'";
            ValidEmail = false;
        }else if (this.value.indexOf('@') == this.value.length-1){
            errors[1].style.visibility = "visible";
            errors[1].textContent = "Mail address shouldn`t end with '@'";
            ValidEmail = false;

        }else {
            errors[1].style.visibility = "hidden";
            errors[1].textContent = "required";
            ValidEmail = true;
        }
        if (this.value.length == 0){
            errors[1].textContent = "required";
            errors[1].style.visibility = "visible";
        }

    })
var userPasInput = document.getElementById("password");
if (userPasInput.value.length != 0){
    errors[2].style.visibility= "hidden";
    if (userPasInput.value.length >= 5){
        ValidPassword = true;
    }
}
userPasInput.addEventListener("keyup",
    function () {
        var userPasRepInput = document.getElementById("passwordRep");
        if (this.value.length < 5){
            errors[2].style.visibility = "visible";
            errors[2].textContent = "Password should be at least 5 symbols";
            ValidPassword = false;

        }else {
            errors[2].style.visibility= "hidden";
            errors[2].textContent = "required";
            ValidPassword = true;


        }
        if (this.value.length == 0){
            errors[2].textContent = "required";
            errors[2].style.visibility = "visible";
        }

    })
var userPasRepInput = document.getElementById("passwordRep");
if (userPasRepInput.value.length != 0){
    errors[3].style.visibility= "hidden";
    var userPasInput = document.getElementById("password");
    if (userPasRepInput.value == userPasInput.value){
        ValidPasswordRep = true;
    }
}
userPasRepInput.addEventListener("keyup",
    function () {
        var userPasInput = document.getElementById("password");

        if (this.value != userPasInput.value){
            errors[3].style.visibility = "visible";
            errors[3].textContent = "Passwords should be the same";
            ValidPasswordRep = false;
        }else {
            errors[3].style.visibility= "hidden";
            errors[3].textContent = "required";
            ValidPasswordRep = true;
        }
        if (this.value.length == 0){
            errors[3].textContent = "required";
            errors[3].style.visibility = "visible";
        }

    })
var Res = document.getElementById("result");
if(Res.textContent == "Your registration completed successfully."){
    Res.style.color = "green";

}else if (Res.textContent == "."){
    Res.style.color = "white";
}else {
    Res.style.color = "red";
}
var RegForm = document.getElementById("RegForm");
RegForm.addEventListener("submit",
    function (e) {
        if (!(ValidEmail && ValidPassword && ValidUsername && ValidPasswordRep)){
            e.preventDefault();



        }
    })

var usernameLogInput = document.getElementById("usernameLog");
if (usernameLogInput.value.length != 0){
    ValidUsernameLog  = true;
}
usernameLogInput.addEventListener("blur",
    function () {


        if (this.value.length == 0){

            ValidUsernameLog = false;
        }else {
            ValidUsernameLog = true;
        }

    })
var passwordLogInput = document.getElementById("passwordLog");
if (passwordLogInput.value.length != 0){
    ValidPasswordLog  = true;
}
passwordLogInput.addEventListener("blur",
    function () {


        if (this.value.length == 0){

            ValidPasswordLog = false;
        }else {
            ValidPasswordLog  = true;
        }

    })
var LogForm = document.getElementById("LogForm");
LogForm.addEventListener("submit",
    function (e) {
        if (!(ValidPasswordLog && ValidUsernameLog)){
            e.preventDefault();



        }
    })
var mess = document.getElementById("Message");

var ChatForm = document.getElementById("ForumForm");

ChatForm.addEventListener("submit",
    function (e) {
        if (mess.value == 0 ){
            e.preventDefault();



        }
    })

if ( getCookie("Logined") == "yes"){
    privilegii();
}else {
    Noprivilegii();
}

function privilegii() {
    var DayOrNightButton = document.getElementById("DayNight");
    DayOrNightButton.style.display = "block";
    ForumButton.style.display = "block";
}
function Noprivilegii() {
    var DayOrNightButton = document.getElementById("DayNight");
    DayOrNightButton.style.display = "none";
    ForumButton.style.display = "none";
}
