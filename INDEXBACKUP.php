<title>EVE Online Campaign Generator</title>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>


<h2 align="center">EVE Campaign Generator</h2>

<noscript><p>JavaScript is not enabled.  EVE Campaign Generator requires JavaScript to function.</p></noscript>



<div id="Main">
    <div id="Alliances" align="center" style="border-radius:10px;background-color:rgb(108, 129, 199);height:775px;margin-left:auto;margin-right:auto;max-width:700px;min-width:550px">
        <button onclick="removeAlliance(1)">Remove Last Alliance</button>
        <br />
        <div id="AllianceSide0" style="border-radius:5px;float:left;margin-left:50px;margin-right:10px ; margin-top:20px ; margin-bottom:10px; height:700px ; width : 250px;  background-color:cornflowerblue;overflow-y:scroll">



            <div style="margin-right:10px ;  margin-bottom:10px; ">
                <button onclick="addAlliance(0)">Add</button>
            </div>




            <div id="AllianceDIV1" style="border-radius:5px;width:170px;height:220px ;margin-left:10px ;margin-right:10px ; margin-top:20px ; margin-bottom:10px ; background-color:grey">
                <img id="AllianceLogoURL1" style="min-height:128px;min-width:128px" src="http://image.eveonline.com/Alliance/1_128.png" /><img id="AlliancePassed1" src="RedCross.png" style="margin-bottom:40px;width:30px;height:30px" />
                <br />
                <select onchange="IsAlliance(0,value)"><option value="1">Alliance</option><option value="0">Corp</option></select>
                1 ID<br />
                <input id="Alliance1" onblur="allianceTest(1)" />
                <p id="ADBFound1"></p>
            </div>


        </div>




        <div id="AllianceSide1" style="border-radius:5px;float: right;margin-right:50px ;margin-left:10px ; margin-top:20px ; margin-bottom:10px; height:700px ; width : 250px; background-color:indianred;overflow-y:scroll">



            <div style=" margin-left:10px ;  margin-bottom:10px ">
                <button onclick="addAlliance(1)">Add</button>
            </div>

            <div id="AllianceDIV2" style="border-radius:5px;width:170px;height:220px;margin-right:10px; margin-left:10px ; margin-top:20px ; margin-bottom:10px ; background-color:grey">
                <img id="AlliancePassed2" src="RedCross.png" style="margin-bottom:40px;width:30px;height:30px" /><img id="AllianceLogoURL2" style="min-height:128px;min-width:128px" src="http://image.eveonline.com/Alliance/1_128.png" /><br />
                <select onchange="IsAlliance(1,value)"><option value="1">Alliance</option><option value="0">Corp</option></select>
                2 ID<br />
                <input id="Alliance2" onblur="allianceTest(2)" />
                <p id="ADBFound2"></p>
            </div>



        </div>






    </div>



    <div style="padding-left:10px;padding-top:1px;border-radius:15px;height:200px;background-color:antiquewhite;margin-left:auto;margin-right:auto;max-width:700px;min-width:550px">

        <p>Year (YYYY)<input onblur="isReady()" oninput="isReady()" id="Year" /></p>

        <p>Month (MM)<input onblur="isReady()" oninput="isReady()" id="Month" /></p>

        <p>Day (DD)<input onblur="isReady()" oninput="isReady()" id="Day" /></p>

        <p>Hour (HH)<input onblur="isReady()" oninput="isReady()" id="Hour" /></p>


        <button id="StartButton" onclick="RunProgram()" disabled>Start!</button> <button onclick="ShowResults()">Results Page!</button>


    </div>



    <div id="SimpleResults" style="padding-left:10px;padding-top:1px;border-radius:15px;height:120px;background-color:aliceblue;margin-left:auto;margin-right:auto;max-width:700px;min-width:550px">

        <p id="Progress">Program not started yet.</p>
        <p id="Side0Kill">Blue side killed</p>
        <p id="Side1Kill">Red side killed</p>

    </div>


</div>

<div id="Result" style="display:none">

    <div id="ResultAlliances" align="center" style="border-radius:10px;background-color:rgb(108, 129, 199);height:775px;margin-left:auto;margin-right:auto;max-width:800px;min-width:550px">
        <button onclick="ShowMain()">Back To Main</button>
        <br />
        <div id="ResultAllianceSide0" style="border-radius:5px;float:left;margin-left:50px;margin-right:10px ; margin-top:20px ; margin-bottom:10px; height:700px ; width : 340px;  background-color:cornflowerblue;overflow-y:scroll">

        </div>

        <div id="ResultAllianceSide1" style="border-radius:5px;float: right;margin-right:50px ;margin-left:10px ; margin-top:20px ; margin-bottom:10px; height:700px ; width : 340px; background-color:indianred;overflow-y:scroll">


        </div>
    </div>


</div>

<script>
    var Characters = [];             //  character_id / iskLost / iskKilled /
    var System = []

    {
        var ZkillPageNumber = 1;

        var CurrentAllianceFetch = 0;

        var Allkillsfound = false;
        var Alllossesfound = false;

        var GetDataFinished = false;

        var Side0Kills = [];
        var Side1Kills = [];
        var Side0Losses = [];
        var Side1Losses = [];

        var FinalSide0Kills = [];
        var FinalSide1Kills = [];

        var GetAllianceInfo = false;

        var SortedData = false;

        var progressKillID;

        var HasPercentageUnder = false;

        var Timeout;


        var JSONString = "N/A";
        var date;
        var year;
        var month;
        var day;
        var hour;
        var killMailIDArray = [];
        var listEndTest = "NotUsedYet";
        var FetchKMURL;
        var FetchLossMailURL;
        var timeOut;
        var LossmailEnd;
        var lossMailIDArray = [];
        var totalKillValue = 0;
        var KillmailDate;
        var ESIURL;
        var ESIHash;
        var ESIKMID;
        var lossMailsAmount = 0;




        var PHPReturn;
        var previouslength = 0;

        var PHPzkb = new XMLHttpRequest();

        var timer;


        var LastAlliance = 2;

        var listofAlliances = new Array();                                      //          0              1               2                       3               4
        // Alliance number  /  Is ready  /   Side they're on      /  AllianceID    /  Is an alliance?     //
        var listofAlliances = [['Alliance1', 'false', 0, 0, 1], ['Alliance2', 'false', 1, 0, 1], ['Alliance3', 'false', 1, 0, 1], ['Alliance4', 'false', 1, 0, 1], ['Alliance5', 'false', 1, 0, 1], ['Alliance6', 'false', 1, 0, 1]];

    }

    function ShowResults() {
        $("#Main").fadeOut(function () { $("#Result").fadeIn(); });
    }
    function ShowMain() {
        $("#Result").fadeOut(function () { $("#Main").fadeIn(); });

    }

    function SortData() {

        var Side0Value = 0;
        var Side1Value = 0;

        var x = 0;
        var y = Side0Kills.length;

        var w = 0;
        var z = Side1Losses.length;
        while (x < y) {
            while (w < z) {
                if (Side0Kills[x].killmail_id == Side1Losses[w].killmail_id) {
                    FinalSide0Kills.push(Side0Kills[x]);
                }
                w++;
            }
            w = 0;
            x++;
        }

        var x = 0;
        var y = Side1Kills.length;

        var w = 0;
        var z = Side0Losses.length;

        while (x < y) {
            while (w < z) {
                if (Side1Kills[x].killmail_id == Side0Losses[w].killmail_id) {
                    FinalSide1Kills.push(Side1Kills[x]);
                }
                w++;
            }
            w = 0;
            x++;
        }
        var x = 0;
        var y = FinalSide0Kills.length;
        while (x < y) {
            Side0Value = Side0Value + FinalSide0Kills[x].zkb.totalValue;
            PopulateResults(x, 0);
            x = x + 1;
        }
        x = 0;
        y = FinalSide1Kills.length;
        while (x < y) {
            Side1Value = Side1Value + FinalSide1Kills[x].zkb.totalValue;
            PopulateResults(x, 1);
            x = x + 1;
        }
        var FormatValueSide0 = Side0Value.toLocaleString("en-US", { minimumFractionDigits: 2 });
        var FormatValueSide1 = Side1Value.toLocaleString("en-US", { minimumFractionDigits: 2 });

        document.getElementById("Side0Kill").innerHTML = "Blue side killed " + FormatValueSide0 + " isk";
        document.getElementById("Side1Kill").innerHTML = "Red side killed " + FormatValueSide1 + " isk";

    }

    function PopulateResults(x, side) {
        var KillID;
        var KillHash;
        if (side == 0) {
            KillID = FinalSide0Kills[x].killmail_id;
            KillHash = FinalSide0Kills[x].zkb.hash;
        }
        else {
            KillID = FinalSide1Kills[x].killmail_id;
            KillHash = FinalSide1Kills[x].zkb.hash;
        }

        var URL = "https://esi.evetech.net/latest/killmails/" + KillID + "/" + KillHash + "/?datasource=tranquility";
        var ResultspageHTTP = new XMLHttpRequest();
        ResultspageHTTP.onreadystatechange = function () {
            if (ResultspageHTTP.readyState == 4 && ResultspageHTTP.status == 200) {
                var ESIResult = JSON.parse(ResultspageHTTP.responseText);
                var AttackerLength = ESIResult.attackers.length;
                var q = 0;
                while (q < AttackerLength) {                                                                    ///ATTACKER INFO
                    var characterfound = false;
                    var characterID = ESIResult.attackers[q].character_id;
                    var y = 0;
                    var CharacterAlength = Characters.length;
                    while (y < CharacterAlength && characterfound == false) {
                        if (characterID == Characters[y].character_id) {
                            characterfound = true;
                        }
                        else {
                            y++;
                        }
                    }


                    if (characterfound == true && side == 0) {
                        Characters[y].iskKilled += FinalSide0Kills[x].zkb.totalValue;
                        ResultCharacterUpdate(y);
                    }
                    if (characterfound == true && side == 1) {
                        Characters[y].iskKilled += FinalSide1Kills[x].zkb.totalValue;
                        ResultCharacterUpdate(y);
                    }

                    if (characterfound == false && side == 0) {
                        var value = FinalSide0Kills[x].zkb.totalValue;
                        Characters.push({ character_id: characterID, iskKilled: value, iskLost: 0, corpID: ESIResult.attackers[q].corporation_id, allianceID: ESIResult.attackers[q].alliance_id, name: "N/A" })             ///Create new character
                        ResultCharacterCreate(y);
                    }
                    if (characterfound == false && side == 1) {
                        var value = FinalSide1Kills[x].zkb.totalValue;
                        Characters.push({ character_id: characterID, iskKilled: value, iskLost: 0, corpID: ESIResult.attackers[q].corporation_id, allianceID: ESIResult.attackers[q].alliance_id, name: "N/A" })             ///Create new character
                        ResultCharacterCreate(y);
                    }


                    q++;

                }

                var p = 0;                                                                                               //victim info
                var o = Characters.length;
                var victim_id = ESIResult.victim.character_id
                while (p < o && characterfound == false) {
                    var characterfound = false;
                    if (ESIResult.victim.character_id == Characters[p].character_id) {
                        characterfound = true;
                        if (side == 0) {
                            Characters[p].iskLost += FinalSide0Kills[x].zkb.totalValue;
                            ResultCharacterUpdate(p);
                        }
                        if (side == 1) {
                            Characters[p].iskLost += FinalSide1Kills[x].zkb.totalValue;
                            ResultCharacterUpdate(p);
                        }
                    }
                    p++;
                }
                if (characterfound == false && side == 0) {
                    var value = FinalSide0Kills[x].zkb.totalValue;
                    Characters.push({ character_id: victim_id, iskKilled: 0, iskLost: value, corpID: ESIResult.victim.corporation_id, allianceID: ESIResult.victim.alliance_id, name: "N/A" })             ///Create new character
                    ResultCharacterCreate(p);
                }
                if (characterfound == false && side == 1) {
                    var value = FinalSide1Kills[x].zkb.totalValue;
                    Characters.push({ character_id: victim_id, iskKilled: 0, iskLost: value, corpID: ESIResult.victim.corporation_id, allianceID: ESIResult.victim.alliance_id, name: "N/A" })             ///Create new character
                    ResultCharacterCreate(p);
                }
            }
        }

        ResultspageHTTP.open("GET", URL, true)
        ResultspageHTTP.send();
    }

    function ResultCharacterCreate(CharacterNum) {

        var side;
        var RCharacterID = Characters[CharacterNum].character_id
        var RAllianceID = Characters[CharacterNum].allianceID;
        var RCorpID = Characters[CharacterNum].corpID;
        var RIskKilled = Characters[CharacterNum].iskKilled;
        var RIskLost = Characters[CharacterNum].iskLost;

        CharInfoURL = "https://esi.evetech.net/latest/characters/" + RCharacterID + "/?datasource=tranquility"
        var CharInfoHTTP = new XMLHttpRequest();
        CharInfoHTTP.onreadystatechange = function () {
            if (CharInfoHTTP.readyState == 4 && CharInfoHTTP.status == 200) {

                var x = 0;
                var y = listofAlliances.length;
                while (x < y && listofAlliances[x][3] != 0) {
                    if (RAllianceID == listofAlliances[x][3]) {
                        side = listofAlliances[x][2];
                        break;
                    }
                    x++;
                }
                var JSONCharInfo = JSON.parse(CharInfoHTTP.responseText);
                Characters[CharacterNum].name = JSONCharInfo.name;

                var sideInfo;
                document.getElementById("ResultAllianceSide" + side).innerHTML += '<div id="R' + RCharacterID + '" style="border-radius: 5px;width: 300px;height:100px;background-color:gray;margin-bottom: 10px;margin-top: 10px"><img style="float: left;margin-top: 15px;" src="http://image.eveonline.com/Character/' + RCharacterID + '_64.jpg" /><div><p style="margin-top: 15px;border-top-width: 10px;padding-top: 5px">' + Characters[CharacterNum].name + '</p><p id="RK' + RCharacterID + '">Killed ' + RIskKilled.toLocaleString("en-US", { minimumFractionDigits: 2 }) + '</p><p id = "RL' + RCharacterID + '">Lost ' + RIskLost.toLocaleString("en-US", { minimumFractionDigits: 2 }) + '</p></div></div>';



            }
        }
        CharInfoHTTP.open("GET", CharInfoURL, false)                                                //Figure out Async!!
        CharInfoHTTP.send();



    }

    function ResultCharacterUpdate(CharacterNum) {
        var RCharacterID = Characters[CharacterNum].character_id
        var RAllianceID = Characters[CharacterNum].allianceID;
        var RCorpID = Characters[CharacterNum].corpID;
        var RIskKilled = Characters[CharacterNum].iskKilled;
        var RIskLost = Characters[CharacterNum].iskLost;

        document.getElementById("RK" + RCharacterID).innerHTML = "Killed " + RIskKilled.toLocaleString("en-US", { minimumFractionDigits: 2 });
        document.getElementById("RL" + RCharacterID).innerHTML = "Lost " + RIskLost.toLocaleString("en-US", { minimumFractionDigits: 2 });

    }


    function IsAlliance(number, istrue) {
        listofAlliances[number][4] = istrue;
        var checkstring = "Alliance" + (number + 1);
        var check = document.getElementById(checkstring).value;
        if (check != "") {
            allianceTest(number + 1)
        }
    }

    function addAlliance(input) {

        if (LastAlliance == 6) {

        }
        else {

            LastAlliance = LastAlliance + 1;
            var float;
            var side = input;
            if (side == 0) {
                info = '<div id="AllianceDIV' + LastAlliance + '" style="border-radius:5px;width:170px;height:220px;margin-left:10px;margin-right:10px  ; margin-top:20px ; margin-bottom:10px; background-color:grey"> <img id="AllianceLogoURL' + LastAlliance + '" style="min-height:128px;min-width:128px" src="http://image.eveonline.com/Alliance/1_128.png" />  <img id="AlliancePassed' + LastAlliance + '" src="RedCross.png" style="margin-bottom:40px;width:30px;height:30px"/>'
            }
            else {
                info = '<div id="AllianceDIV' + LastAlliance + '" style="border-radius:5px;width:170px;height:220px;margin-right:10px;margin-left:10px  ; margin-top:20px ; margin-bottom:10px; background-color:grey"> <img id="AlliancePassed' + LastAlliance + '" src="RedCross.png" style="margin-bottom:40px;width:30px;height:30px"/> <img id="AllianceLogoURL' + LastAlliance + '" style="min-height:128px;min-width:128px" src="http://image.eveonline.com/Alliance/1_128.png" />'
            }
            document.getElementById("AllianceSide" + side).innerHTML += '' + info + ' <br /><select onchange="IsAlliance(' + (LastAlliance - 1) + ',value)"><option value="1">Alliance</option><option value="0">Corp</option></select> ' + LastAlliance + ' ID<br />  <input id="Alliance' + LastAlliance + '" onblur="allianceTest(' + LastAlliance + ')" /> <p id="ADBFound' + LastAlliance + '"></p> </div>';

            var NewAllianceString = "Alliance" + LastAlliance;


            listofAlliances[LastAlliance - 1][2] = side;




        }


    }

    function removeAlliance(input) {

        if (LastAlliance == 1) {

        }
        else {

            var side = input;
            document.getElementById("AllianceDIV" + LastAlliance).remove();
            listofAlliances[LastAlliance - 1][1] = false;
            listofAlliances[LastAlliance - 1][2] = 0;
            listofAlliances[LastAlliance - 1][3] = 0;

            LastAlliance = LastAlliance - 1;


        }



    }

    function RunProgram() {

        resetVariables();


        date = document.getElementById("Year").value + document.getElementById("Month").value + document.getElementById("Day").value + document.getElementById("Hour").value + "00";

        year = document.getElementById("Year").value;
        month = document.getElementById("Month").value;
        day = document.getElementById("Day").value;
        hour = document.getElementById("Hour").value;




        getProgress();



        Controller();


    }

    function Controller() {


        if (GetDataFinished == false) {

            if (Allkillsfound == false && Alllossesfound == false) {
                setTimeout(function () { GetZKillData("kills"); }, 1);
            }

            if (Alllossesfound == false && Allkillsfound == true) {
                setTimeout(function () { GetZKillData("losses"); }, 1)
            }

            if (Allkillsfound == true && Alllossesfound == true) {
                CurrentAllianceFetch = CurrentAllianceFetch + 1;
                ZkillPageNumber = 1;
                Allkillsfound = false;
                Alllossesfound = false;
                try {
                    if (listofAlliances[CurrentAllianceFetch][3] == 0) {
                        GetDataFinished = true;
                    }
                }
                catch (err) { GetDataFinished = true; }
                finally {

                }



                Controller();
            }

        }
        if (GetDataFinished == true) {
            SortData();

        }

    };


    function GetZKillData(KorL) {
        var killmailsParsed
        var AorC;
        var allianceID = listofAlliances[CurrentAllianceFetch][3];

        if (listofAlliances[CurrentAllianceFetch][4] == 1) {
            AorC = 'alliance';
        }
        else {
            AorC = 'corporation'
        }

        var ConnectionURL = 'https://zkillboard.com/api/' + KorL + '/' + AorC + 'ID/' + allianceID + '/page/' + ZkillPageNumber + '/startTime/' + date + '/'



        var Connection = new XMLHttpRequest();
        Connection.open("GET", ConnectionURL, false);
        Connection.send();
        var ResponseJSON = JSON.parse(Connection.responseText)
        var arraysize = ResponseJSON.length;





        if (listofAlliances[CurrentAllianceFetch][2] == 0 && KorL == "kills" && arraysize != 0) {

            var x = 0;
            var y = arraysize;
            while (x < y) {
                Side0Kills.push(ResponseJSON[x]);
                x++;
            }
            killmailsParsed = Side0Kills.length

        }
        if (listofAlliances[CurrentAllianceFetch][2] == 1 && KorL == "kills" && arraysize != 0) {
            var x = 0;
            var y = arraysize;
            while (x < y) {
                Side1Kills.push(ResponseJSON[x]);
                x++;
            }
            killmailsParsed = Side1Kills.length
        }
        if (listofAlliances[CurrentAllianceFetch][2] == 0 && KorL == "losses" && arraysize != 0) {
            var x = 0;
            var y = arraysize;
            while (x < y) {
                Side0Losses.push(ResponseJSON[x]);
                x++;
            }
            killmailsParsed = Side0Losses.length
        }
        if (listofAlliances[CurrentAllianceFetch][2] == 1 && KorL == "losses" && arraysize != 0) {
            var x = 0;
            var y = arraysize;
            while (x < y) {
                Side1Losses.push(ResponseJSON[x]);
                x++;
            }
            killmailsParsed = Side1Losses.length
        }


        ZkillPageNumber = ZkillPageNumber + 1;




        if (HasPercentageUnder == false) {
            PercentageUnder = ResponseJSON[0].killmail_id - progressKillID;
            HasPercentageUnder = true;
        }



        if (ResponseJSON.length != 0) {
            var PercentageOver = ResponseJSON[0].killmail_id - progressKillID;
            var Percentage = PercentageOver / PercentageUnder
            var finalProgress = Math.round(100 - (Percentage * 100));

            document.getElementById("Progress").innerHTML = listofAlliances[CurrentAllianceFetch][0] + " " + KorL + " - " + finalProgress + "%";


        };



        if (arraysize < 200 && KorL == "kills") {
            Allkillsfound = true;
            ZkillPageNumber = 1;
            HasPercentageUnder = false;
        }
        if (arraysize < 200 && KorL == "losses") {
            Alllossesfound = true;
            ZkillPageNumber = 1;
            HasPercentageUnder = false;
        }


        Controller();

    }

    function getProgress() {

        var progressURL = "https://zkillboard.com/api/history/" + year + month + day + "/";             ////Start of progress info
        var progressHTTP = new XMLHttpRequest();
        progressHTTP.open("GET", progressURL, false);
        progressHTTP.send();

        var ProgressJSON = JSON.parse(progressHTTP.responseText)
        var progressArray = Object.keys(ProgressJSON);
        progressKillID = progressArray[0];


    }



    function allianceTest(Alliancetested) {

        var AorCimage;
        var AorCURL;
        if (listofAlliances[Alliancetested - 1][4] == 1) {
            AorCimage = "Alliance";
            AorCURL = "alliances";
        }
        else {
            AorCimage = "Corporation";
            AorCURL = "corporations"
        }


        var allianceID = document.getElementById("Alliance" + Alliancetested).value;
        var ESIURL = "http://image.eveonline.com/" + AorCimage + "/" + String(allianceID) + "_128.png";
        document.getElementById("AllianceLogoURL" + Alliancetested).src = ESIURL;
        var allianceURL;
        allianceURL = "https://esi.evetech.net/latest/" + AorCURL + "/" + document.getElementById("Alliance" + Alliancetested).value + "/?datasource=tranquility";



        var HTTPGet = new XMLHttpRequest();
        HTTPGet.onreadystatechange = function () {
            if (HTTPGet.readyState == 4) {
                var AllianceJSON = JSON.parse(HTTPGet.responseText);
                if (AllianceJSON.error == "Alliance not found" || AllianceJSON.error == "Corporation not found" || AllianceJSON.error == "Not found") {

                    listofAlliances[Alliancetested - 1][1] = false;
                    listofAlliances[Alliancetested - 1][3] = 0;
                    document.getElementById("AlliancePassed" + Alliancetested).src = "RedCross.png"
                }
                else {
                    listofAlliances[Alliancetested - 1][1] = true;
                    listofAlliances[Alliancetested - 1][3] = allianceID;
                    document.getElementById("AlliancePassed" + Alliancetested).src = "GreenTick.png";
                }



            }
        }
        HTTPGet.open("GET", allianceURL, true);
        HTTPGet.send();



        isReady();

    }


    function isReady() {
        var year = document.getElementById("Year").value;
        var month = document.getElementById("Month").value;
        var day = document.getElementById("Day").value;
        var hour = document.getElementById("Hour").value;

        var allAlliancesReady = true;

        var x = 0;
        var y = LastAlliance;
        while (x < y) {
            if (listofAlliances[x][1] == false) {
                allAlliancesReady = false;
            }
            x = x + 1;
        }


        if ((year > 2000) && (year < 2020) && (month < 13) && (String(month).length == 2) && (day < 34) && (String(day).length == 2) && (hour < 25) && (String(hour).length == 2) && (allAlliancesReady == true) && (LastAlliance > 1)) {
            document.getElementById("StartButton").disabled = "";
        }
        else {
            document.getElementById("StartButton").disabled = "disabled";
        }

    }

    function resetVariables() {

        Characters = [];             //  character_id / iskLost / iskKilled /
        System = []


        ZkillPageNumber = 1;

        CurrentAllianceFetch = 0;

        Allkillsfound = false;
        Alllossesfound = false;

        GetDataFinished = false;

        Side0Kills = [];
        Side1Kills = [];
        Side0Losses = [];
        Side1Losses = [];

        FinalSide0Kills = [];
        FinalSide1Kills = [];

        GetAllianceInfo = false;

        SortedData = false;


        JSONString = "N/A";
        date = 0;
        year = 0;
        month = 0;
        day = 0;
        hour = 0;
        killMailIDArray = [];
        listEndTest = "NotUsedYet";
        FetchKMURL = 0;
        FetchLossMailURL = 0;
        timeOut = 0;
        LossmailEnd = 0;
        lossMailIDArray = [];
        totalKillValue = 0;
        KillmailDate = 0;
        ESIURL = 0;
        ESIHash = 0;
        ESIKMID = 0;
        lossMailsAmount = 0;
        allKillMailsFound = false;
        allLossMailsFound = false;
        allianceOneReady = false;
        allianceTwoReady = false;
        allianceOneInDatabase = false;
        allianceTwoInDatabase = false;
        PHPReturn = 0;
        previouslength = 0;

        PHPzkb = new XMLHttpRequest();

        timer = 0;





    }

</script>

