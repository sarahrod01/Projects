<?php
include_once '../class/classroom.php';
$r = new room();

    $commentid = $_GET['commentid'];
    $comment = $_GET['comment'];

    $result = $r->deleteaddbadword($commentid, $comment);
    echo $result;

?>
