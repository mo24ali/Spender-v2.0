<?php

    $isSend = $_GET['sendTransfer'];
    if(isset($isSend)){
        header("Location: ../mycard.php?send=true");
    }
?>  