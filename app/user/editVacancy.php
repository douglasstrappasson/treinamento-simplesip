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
            $description = $fields['inputDescription'];
            $profession = $fields['inputProfession'];
            $contract = $fields['inputContract'];
            $city = $fields['inputCity'];
            $requirements = $fields['inputRequirements'];
            $wage = $fields['inputWage'];
            $userSession = $_SESSION['id'];
            $activeVacancy = $vacancyEdit['active'] == 't' ? 'checked' : '';   
            $activeVacancyEdit = $fields['checkActive'] ?? 0;  
            
            
            if ($fields['btnExec'] == 1){
                $sqlQuery = "update vacancy set vacancy = '$vacancy', id_profession = '$profession', contract='$contract', id_city='$city', wage='$wage', requirements='$requirements', active='$activeVacancyEdit', id_user= '$userSession' where id = '$idVacancy'";
                $erroMsg = ('Cadastrado com sucesso!');
                if(insertDB($sqlQuery)){
                    $erroMsg = '<div class="mt-2 alert alert-success" role="alert">Atualizado com sucesso!</div>';
                    $sqlQuery = "SELECT * FROM vacancy inner join professions
                    on vacancy.id_profession = professions.id
                    and vacancy.id = $idVacancy";
                    $sqlResult = pg_query(open_database(), $sqlQuery); 
                    $vacancyEdit = pg_fetch_array($sqlResult);
                } else {
                    $erroMsg =  '<div class="mt-2 alert alert-danger" role="alert">Não foi possivel Atualizar!</div>';
                }	
            }
        }

?>

<fieldset>
    EDITOR DE VAGAS
    <div class="mb-3">
        <legend class="mb-0" aria-describedby="legendlHelp">Edite uma vaga existente</legend>
        <p class="form-text">Preencha os campos abaixo</p>
    </div>
    <?php if (isset($erroMsg) && !empty($erroMsg) && $fields['btnExec'] == 1){
        echo $erroMsg;
        }
    ?>
    <div class="mb-3">
        <label for="inputVacancy" class="form-label">Vaga</label>
        <input value="<?= $vacancyEdit['vacancy'] ?>" type="text"
            class="form-control <?= alertErrors('inputVacancy', $verify)?>" id="inputVacancy"
            placeholder="digite um nome para a vaga" name="inputVacancy">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3">
        <label for="inputDescription" class="form-label">Descreva a vaga</label>
        <input type="text" class="form-control <?= alertErrors('inputDescription', $verify)?>" id="inputDescription"
            placeholder="digite uma breve descrição sobre a vaga" name="inputDescription"
            value="<?= $vacancyEdit['description']?>">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3">
        <label for="inputProfession" class="form-label">Profissão</label>
        <select id="inputProfession" class="<?= alertErrors('inputProfession', $verify)?> form-select form-control"
            name="inputProfession">
            <option value="">selecione uma profissão</option>
            <?php
												$sqlCode = "SELECT id, profession FROM professions";
												$sqlQuery = pg_query(open_database(), $sqlCode); 
												while($professions = pg_fetch_array($sqlQuery)) { ?>
            <option class="" value="<?= $professions['id'] ?>"
                <?= $vacancyEdit['id_profession'] == $professions['id'] && !$clearFields ? 'selected' : '' ?>>
                <?= $professions['profession'] ?>
            </option> <?php } 
											?>
        </select>
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3">
        <label for="inputContract" class="form-label">Tipo do contrato</label>
        <input type="text" class="form-control <?= alertErrors('inputContract', $verify)?>" id="inputContract"
            placeholder="digite o tipo de contrato para a vaga" name="inputContract"
            value="<?= $vacancyEdit['contract']; ?>">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3">
        <label for="inputCity" class="form-label">Cidade da vaga</label>
        <select id="inputCity" class="<?= alertErrors('inputCity', $verify)?> form-select form-control"
            name="inputCity">
            <option value="">selecione uma cidade</option>
            <?php
                $sqlCode = "SELECT cities.id AS id, cities.city || ' - ' || states.sf AS city FROM cities INNER JOIN states ON cities.id_sf = states.id";
                $sqlQuery = pg_query(open_database(), $sqlCode) or $erroMsg = 'Falha na execuçã do código SQL!'; 
                while($cities = pg_fetch_array($sqlQuery)) { ?>
                <option class="" value="<?= $cities['id'] ?>"
                    <?= $vacancyEdit['id_city'] == $cities['id'] && !$clearFields ? 'selected' : '' ?>>
                    <?= $cities['city'] ?>
                </option> 
            <?php } ?>
        </select>
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3">
        <label for="inputRequirements" class="form-label">Requisitos para a Vaga</label>
        <input type="text" class="form-control <?= alertErrors('inputRequirements', $verify)?>" id="inputRequirements"
            placeholder="digite os requisitos necessários para a vaga" name="inputRequirements"
            value="<?= $vacancyEdit['requirements']; ?>">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3">
        <label for="inputWage" class="form-label">Faixa salarial</label>
        <input type="text" class="form-control <?= alertErrors('inputWage', $verify)?>" id="inputWage"
            placeholder="digite os requisitos necessários para a vaga" name="inputWage"
            value="<?= $vacancyEdit['wage']; ?>">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class=" form-check-input" id="checkActive" name="checkActive"
            <?= $activeVacancy ?>>
        <label class="form-check-label" for="checkActive">Vaga Ativa</label>
    </div>
    <button name="btnExec" id="btnExec" value="1" type="submit" class="btn btn-primary">
        Salvar
    </button>
    </div>
</fieldset>