<?php

require 'su-config.php';

// define db connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);

$url = DEFAULT_URL;

if (isset($_GET['s'])) {
    $short = $_GET['s'];
    $short = substr($short, 0, 2000);
    $short = preg_replace('/[^a-z0-9]/si', '', $short);

    $result = $mysqli->query("select longurl from shorturls where shorturl = '" . $short . "'");

    if ($result && $result->num_rows == 1) {
        $mysqli->query("update shorturls set hits = hits + 1 where shorturl = '" . $short . "'");
        $url = urldecode($result->fetch_object()->longurl);
    }

    mysqli_free_result($result);
}

header('Location: ' . $url, null, 301);

$attributeValue = htmlspecialchars($url);

?>
<meta http-equiv=refresh content="0;URL=<?php echo $attributeValue; ?>"><a href="<?php echo $attributeValue; ?>">Continue</a><script>location.href=<?php echo json_encode($url, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES); ?></script>
