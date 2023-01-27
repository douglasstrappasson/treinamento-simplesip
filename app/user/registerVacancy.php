<?php
    $fields = isPostback();
    $verify = verifyFields($fields);

    if (empty($verify)){
            $vacancy = $fields['inputVacancy'];
            $description = $fields['inputDescription'];
            $profession = $fields['inputProfession'];
            $contract = $fields['inputContract'];
            $city = $fields['inputCity'];
            $requirements = $fields['inputRequirements'];
            $wage = $fields['inputWage'];
            $userSession = $_SESSION['id'];
            $activeVacancy = $fields['checkActive'] ?? 0;
            
            if ($fields['btnExec'] == 1){
                $sqlQuery = "SELECT count(vacancy) FROM vacancy WHERE vacancy = '$vacancy' AND active = '$activeVacancy'";
                
                if (existsOnDB($sqlQuery)){
                        $erroMsg =  '<div class="mt-2 alert alert-warning" role="alert">Já existe uma vaga com o mesmo nome!</div>';
                } else {
                    $sqlQuery = "INSERT INTO vacancy (vacancy, id_profession, contract, id_city, wage, requirements, description, n_candidate, active, id_user)
                    VALUES ('$vacancy', $profession, '$contract', $city, '$wage', '$requirements', '$description', 0, '$activeVacancy', $userSession)";
                        $erroMsg = ('Cadastrado com sucesso!');
                    if(insertDB($sqlQuery)){
                        $erroMsg = '<div class="mt-2 alert alert-success" role="alert">Cadastrado com sucesso!</div>';
                        $clearFields = true;
                    } else {
                        $erroMsg =  '<div class="mt-2 alert alert-danger" role="alert">Não foi possivel cadastrar!</div>';
                    }	
                }
            }
        }
?>

<fieldset>
    <div class="mb-3">
        <legend class="mb-0" aria-describedby="legendlHelp">Cadastre uma nova Vaga
        </legend>
        <p class="form-text">Preencha os campos abaixo</p>
    </div>
    <?php if (isset($erroMsg) && !empty($erroMsg) && $fields['btnExec'] == 1){
            echo $erroMsg;
          }
    ?>
    <div class="mb-3">
        <label for="inputVacancy" class="form-label">Vaga</label>
        <input value="<?= $clearFields ? '' : $_POST['inputVacancy']; ?>" type="text"
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
            value="<?= $clearFields ? '' : $_POST['inputDescription']?>">
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
                <?= $fields['inputProfession'] == $professions['id'] && !$clearFields ? 'selected' : '' ?>>
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
            value="<?= $clearFields ? '' : $_POST['inputContract']; ?>">
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
                $sqlQuery = pg_query(open_database(), $sqlCode); 
                while($cities = pg_fetch_array($sqlQuery)) { ?>
            <option class="" value="<?= $cities['id'] ?>"
                <?= $fields['inputCity'] == $cities['id'] && !$clearFields ? 'selected' : '' ?>>
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
            value="<?= $clearFields ? '' : $_POST['inputRequirements']; ?>">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3">
        <label for="inputWage" class="form-label">Faixa salarial</label>
        <input type="text" class="form-control <?= alertErrors('inputWage', $verify)?>" id="inputWage"
            placeholder="digite os requisitos necessários para a vaga" name="inputWage"
            value="<?= $clearFields ? '' : $_POST['inputWage']; ?>">
        <div class="invalid-feedback">
            Este campo não pode ficar vazio!
        </div>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="checkActive" name="checkActive" checked>
        <label class="form-check-label" for="checkActive">Vaga Ativa</label>
    </div>
    <button name="btnExec" value="1" type="submit" class="btn btn-primary">
        Cadastrar
    </button>
</fieldset>