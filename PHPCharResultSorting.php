<?php

$CharArrayString = file_get_contents('php://input');

$killers = $_GET["Killers"];

$CharArray = json_decode($CharArrayString,true);



if($killers == 1){
    usort($CharArray[0], function ($a, $b) {return $a['iskKilled'] < $b['iskKilled'];});
    usort($CharArray[1], function ($a, $b) {return $a['iskKilled'] < $b['iskKilled'];});

}
else{
    usort($CharArray[0], function ($a, $b) {return $a['iskLost'] < $b['iskLost'];});
    usort($CharArray[1], function ($a, $b) {return $a['iskLost'] < $b['iskLost'];});
}

echo json_encode($CharArray)

?>


