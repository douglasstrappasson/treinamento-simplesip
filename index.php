<?php
    include('config/start.php');
    include('head.php');
?>
<body>
    <?php        
        if ($_SESSION['logged'] == true){
            if (isset($_GET['id'])){
                include config($_GET['id']);
            }else {
                include config(1);
            }            
        } else {
            print_r($_SESSION['btnLogin_1']);
            if (isset($_GET['id'])){
                include config($_GET['id']);
            }else {
                include config(5);
            }      
        }
    ?>
</body>
</html>
