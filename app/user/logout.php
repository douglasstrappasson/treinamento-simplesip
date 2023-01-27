<?php
    session_start();
    session_destroy();
    session_unset();
    echo '<script>document.location.href="../index.php";</script>';
?>