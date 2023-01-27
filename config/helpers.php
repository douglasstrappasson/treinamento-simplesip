<?php
    function config($var){
        $page = include('pages.php');
        return $page[$var];
    }

    //tras todos os valores do POST para um array filtrado e limpo
    function isPostback() {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    //verifica se os campos estão vazios
    function verifyFields($fields){
        $errors = [];
        foreach($fields as $key => $value){
            if (empty($value)){
                $errors[] = $key;
            }
        }
        return $errors;
    }

    //deixa os campos dos formulários vazios com a borda vermelha
    function alertErrors($e, $verify){
		foreach ($verify as $key => $value) {
			if ($e == $value) {
                return 'is-invalid';
			} else {
                return '';
            }
        }
    }
    
    function insertDB($sqlQuery) {
        if (pg_query(open_database(), $sqlQuery)) {
            return true;
        } else {
            return false;
        }
    }

    function existsOnDB($sqlQuery){
        $sqlResult = pg_query(open_database(), $sqlQuery);
        if ($sqlResult) {
            if($columnResult = pg_fetch_assoc($sqlResult)){
                if ($columnResult['count'] > 0){
                    return true;
                }
            };
        }
    }
?>