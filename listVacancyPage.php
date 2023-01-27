<?php
    $fields = isPostback();

    $searchVacancy = ($fields['searchVacancy']) != null ? "and vacancy LIKE '%".strtolower($fields['searchVacancy'])."%' " : null;
    $inputProfession = ($fields['inputProfession']) != null ? "and id_profession ='".$fields['inputProfession']."' " : null;
    $inputWage = ($fields['inputWage'])  != null ? "and wage = '".$fields['inputWage']."' " : null;
    $inputContract = ($fields['inputContract']) != null ? "and contract = '".$fields['inputContract']."' " : null;
?>

<div class="tab-pane fade <?= $action == 'list' || $action == null ? 'show active' : '' ?>">
    <div class="d-flex justify-content-between mt-3 form-group input-group">
        <input value="<?= $clearFields ? '' : $_POST['searchVacancy']; ?>" type="text" class="form-control me-2"
            id="searchVacancy" placeholder="Realize a pesquisa pelo nome da vaga!" name="searchVacancy">
        <button class="btn btn-outline-success" type="submit" name="btnSearchVacancy"> Buscar </button>
    </div>

    <div class="d-flex justify-content-between">
        <div class="my-2 d-flex justify-content-between ">
            <span for="inputProfession" class="p-2 text-nowrap">Profissão:</span>
            <select id="inputProfession" class="form-select form-control" name="inputProfession">
                <option value="">selecione</option>
                <?php
                $sqlCode = "SELECT id, profession FROM professions";
                $sqlQuery = pg_query(open_database(), $sqlCode);                
            while($professions = pg_fetch_array($sqlQuery)) {  ?>
                <option class="" value="<?= $professions['id'] ?>"
                    <?= $fields['inputProfession'] == $professions['id'] && !$clearFields ? 'selected' : '' ?>>
                    <?= $professions['profession'] ?>
                </option> <?php }
                                ?>
            </select>
        </div>

        <div class="my-2 d-flex justify-content-between">
            <span for="inputWage" class="p-2 text-nowrap">Faixa Salarial:</span>
            <select id="inputWage" class="form-select form-control" name="inputWage">
                <option value="">selecione</option>
                <?php
                $sqlCode = "SELECT wage FROM vacancy GROUP BY wage";
                $sqlQuery = pg_query(open_database(), $sqlCode);
                while ($wage = pg_fetch_array($sqlQuery)) { ?>
                <option class="" value="<?= $wage['wage'] ?>"
                    <?= $fields['inputWage'] == $wage['wage'] && !$clearFields ? 'selected' : '' ?>>
                    <?= $wage['wage'] ?>
                </option> <?php }
                                ?>
            </select>
        </div>

        <div class="my-2 d-flex justify-content-between">
            <span for="inputContract" class="p-2 text-nowrap">Tipo de Contrato:</span>
            <select id="inputContract" class="form-select form-control" name="inputContract">
                <option value="">selecione</option>
                <?php
                $sqlCode = "SELECT contract FROM vacancy GROUP BY contract";
                $sqlQuery = pg_query(open_database(), $sqlCode);
                while ($contract = pg_fetch_array($sqlQuery)) { ?>
                <option class="" value="<?= $contract['contract'] ?>"
                    <?= $fields['inputContract'] == $contract['contract'] && !$clearFields ? 'selected' : '' ?>>
                    <?= $contract['contract'] ?>
                </option> <?php }
                                ?>
            </select>
        </div>
    </div>

    <?php
    $sqlQuery = "SELECT *, a.id as id_vacancy, b.id as id_profession FROM vacancy a inner join professions b
        on a.id_profession = b.id
        and a.active = '1' 
        $searchVacancy 
        $inputProfession
        $inputWage
        $inputContract";
     $sqlResult = pg_query(open_database(), $sqlQuery); 
     while($vacancys = pg_fetch_array($sqlResult)) { 
    ?>
    <div class="card my-3">
        <h6 class="card-header text-uppercase"><?= $vacancys['vacancy'] ?></h6>
        <div class="card-body">
            <div class="mb-2">
                <span class="badge rounded-pill bg-primary">Salário:
                    <?= $vacancys['wage'] ?></span>
                <span class="badge rounded-pill bg-info">Tipo:
                    <?= $vacancys['contract'] ?></span>
                <span class="badge rounded-pill bg-success">Incritos:
                    <?= $vacancys['n_candidate'] ?></span>
            </div>
            <p class="card-text"><b>Função: </b><?= $vacancys['profession'] ?></p>
            <p class="card-text"><b>Descrição da vaga: </b><?= $vacancys['description'] ?>
            </p>
            <p class="card-text"><b>Requisitos para vaga:
                </b><?= $vacancys['description'] ?></p>
            <a name="btnEditVacancy" value="<?= $vacancys['id_vacancy'] ?>" type="submit"
                href="?action=subscription&vacancy=<?= $vacancys['id_vacancy'] ?>" class="btn btn-success">Inscrever-se
                para a vaga</a>
        </div>
    </div>
    <?php }
    ?>
</div>