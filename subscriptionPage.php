<?php 
    $fields = isPostback();
    $verify = verifyFields($fields);
    
   
    $idVacancy = $_SESSION['vacancy'] = isset($_GET['vacancy']) ? $_GET['vacancy'] : NULL;

    $sqlQuery = "SELECT * FROM vacancy inner join professions
    on vacancy.id_profession = professions.id
    and vacancy.id = $idVacancy";
    $sqlResult = pg_query(open_database(), $sqlQuery); 
    $vacancyEdit = pg_fetch_array($sqlResult);  
  

    if (empty($verify)){
        $vacancy = $fields['inputVacancy'];
        $inputCadidate = $fields['inputCadidate'];
        $inputEmail = $fields['inputEmail'];
        $userSession = $_SESSION['id']; 

        if(isset($_POST['upload'])){
            $file = $_FILES['arquivo'];
            $dirUpload = 'uploads/';
            $date = date("Y-m-d-H-i-s");
            $file_extension = pathinfo(basename($file['name']), PATHINFO_EXTENSION);
            $file_size = filesize(basename($file['name']));
            $tamanho = 1024 * 1024 * 30; //30MB
            $extensao = 'pdf';
            $arquivo = md5($inputEmail . $date).'.'.$extensao;

            $errors = [
                0 => '<div class="mt-2 alert alert-success" role="alert">Upload realizado com sucesso!</div>',
                1 => '<div class="mt-2 alert alert-danger" role="alert">O arquivo do upload é muito grande!</div>',
                2 => '<div class="mt-2 alert alert-danger" role="alert">A extensão do arquivo é inválido!</div>',
                3 => '<div class="mt-2 alert alert-warning" role="alert">Por favor faça upload do arquivo!</div>',
                4 => '<div class="mt-2 alert alert-warning" role="alert">Já existe inscrição deste email nesta vaga!</div>',
                5 => '<div class="mt-2 alert alert-success" role="alert">Inscrição realizada com sucesso!</div>',
                6 => '<div class="mt-2 alert alert-danger" role="alert"> Não foi possivel Inscrever! </div>',
                7 => '<div class="mt-2 alert alert-danger" role="alert"> Endereço de e-mail inválido! </div>'
            ];

            if (filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
                if(move_uploaded_file($file['tmp_name'] , $dirUpload . $arquivo)){
                    if ($file_extension != $extensao){
                        $erroMsg = $errors[2];
                    } elseif ($file_size > $tamanho){
                        $erroMsg = $errors[1];
                    } else {
                        $sqlQuery = "SELECT count(candidate) as count FROM candidates WHERE id_vacancy = '$idVacancy' AND email = '$inputEmail'";       
                        if (existsOnDB($sqlQuery)){
                            $erroMsg = $errors[4];
                        } else {
                            $sqlQuery = "insert into candidates (candidate, email, archive, id_vacancy) values ('$inputCadidate', '$inputEmail', '$arquivo', '$idVacancy')";
                            if(insertDB($sqlQuery)){
                                $erroMsg = $errors[5];
                            } else {
                                $erroMsg = $errors[6];
                            }	
                        }
                    }
                }  else {
                    $erroMsg = $errors[3];
                } 
            } else {
                $erroMsg = $errors[7];
            }
        }    
    }
?>

<fieldset>
    <div class="mb-3">
        <legend class="mb-0" aria-describedby="legendlHelp">Inscreva-se para a vaga:
            <span> <?= $vacancyEdit['vacancy'] ?> </span>
        </legend>
        <p class="form-text">Preencha os campos abaixo</p>
    </div>
    <?php if (isset($erroMsg) && !empty($erroMsg) && $fields['upload'] != null){
            echo $erroMsg;
            }
        ?>
    <div class="mb-3">
        <label for="inputCadidate" class="form-label">Nome Completo</label>
        <input value="<?= $clearFields ? '' : $_POST['inputCadidate']?>" type="text" class="form-control <?= alertErrors('inputCadidate', $verify)?>"
            id="inputCadidate" placeholder="digite seu nome completo" name="inputCadidate">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>

    <div class="mb-3">
        <label for="inputEmail" class="form-label">E-mail</label>
        <input value="<?= $clearFields ? '' : $_POST['inputEmail']?>" type="text" class="form-control <?= alertErrors('inputEmail', $verify)?>" id="inputEmail"
            placeholder="digite seu nome completo" name="inputEmail">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>

    <div class="mb-3">
        <label>Arquivo:</label>
        <div class="<?= alertErrors('arquivo', $verify)?>">
            <input type="file" name="arquivo" class="form-control mb-2 " />
        </div>
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
        <input type="submit" name="upload" value="Inscrever" class="btn btn-primary" />
    </div>
</fieldset>