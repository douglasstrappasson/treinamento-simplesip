<?php 
    function open_database(){
        try {
            $conect = pg_connect(sprintf("host=%s port=%s dbname=%s user=%s password=%s ", CONF_DB_HOST, CONF_DB_PORT, CONF_DB_DATABASE, CONF_DB_USER, CONF_DB_PASSWORD));
            return $conect;
        } catch (Exception $e) {
            die('Não foi possivel conectar ao servidor de dados!' . pg_last_error($conect));
            return null;
        }
    }

    function close_database($conect) {
        try {
            pg_close($conect);
        } catch (Exception $e) {
            echo $e = ('Não foi possivel encerrar a conectar ao servidor de dados!');
        }
    }
?>