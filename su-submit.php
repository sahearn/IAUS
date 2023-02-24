<?php
require 'su-config.php';

// define db connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);

$url = substr(strip_tags($_POST['postUrl']), 0, 2000);

if (!empty($url)) {
    // check db if long url already exists
    $result = $mysqli->query("select shorturl from shorturls where longurl = '" . urlencode($url) . "'");
    $row = $result->fetch_object();

    if ($result->num_rows == 1) {
        // if long url exists, send short url
        echo $row->shorturl;
    } else {
        // otherwise generate a new short, insert to the db, and send it back to caller
        $newShort = getNewShort();
        $iresult = insertNewRecord($newShort,$url);
        if ($iresult) {
            echo $newShort;
        } else {
            echo "INSERT_ERROR";
        }
    }

    // db cleanup
    unset($row);
    mysqli_free_result($result);
}

function getNewShort() {
    $newShort = generateNewShort();
    $alreadyExists = checkExisting($newShort);
    
    // keep trying to get a new short until we're sure it's unique
    while ($alreadyExists == true) {
        $newShort = generateNewShort();
        $alreadyExists = checkExisting($newShort);
    }
    
    return $newShort;
}

function checkExisting($short) {
    global $mysqli; // get global db connection
    // see if newly-generated short url already exists
    $cresult = $mysqli->query("select shorturl from shorturls where shorturl = '" . $short . "'");

    if ($cresult->num_rows == 1) {
        mysqli_free_result($cresult);
        return true;
    } else {
        mysqli_free_result($cresult);
        return false;
    }
}

function generateNewShort() {
    // intentionally removed lowercase L and o/O/0 to avoid visual confusion
    return substr(str_shuffle("abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHIJKLMNPQRSTUVWXYZ"),0,SHORT_LENGTH);
}

function insertNewRecord($newShort,$url) {
    global $mysqli; // get global db connection
    // insert a new record
    $iresult = $mysqli->query("insert into shorturls (shorturl,longurl,hits) values ('" . $newShort . "','" . urlencode($url) . "',0)");
    return $iresult;
}
?>