<?php
    $fields = isPostback();
    $searchVacancy = ($fields['searchVacancy']) != null ? "and vacancy LIKE '%".strtolower($fields['searchVacancy'])."%' " : null;
    $checkActive =  ($fields['checkActive']) != null ? $fields['checkActive'] : null;
    switch ($checkActive) {
        case 1:
            $checkActive = 'and active = true';
            break;
        
        default:
            $checkActive = 'and active = false';
            break;
    }
?>

<div class="tab-pane fade <?= $action == 'list' || $action == null ? 'show active' : '' ?>">
    <div class="d-flex justify-content-between mt-3 form-group input-group">
        <input value="<?= $clearFields ? '' : $_POST['searchVacancy']; ?>" type="text" class="form-control me-2"
            id="searchVacancy" placeholder="Realize a pesquisa pelo nome da vaga!" name="searchVacancy">
        <button class="btn btn-outline-success"
            value="<?= $searchVacancy ? "and vacancy like '%".$searchVacancy."%'" : '' ?>" type="submit"
            name="btnSearchVacancy"> Search </button>
    </div>

    <div class="d-flex justify-content-center my-2">
        <div class="mx-4 custom-control custom-radio">
            <input type="radio" name="checkActive" value="1">Ativas
            <input type="radio" name="checkActive" value="0">Desativas
        </div>
    </div>

    <?php
        $sqlQuery = "SELECT *, a.id as id_vacancy, b.id as id_profession FROM vacancy a inner join professions b
        on a.id_profession = b.id
        $searchVacancy 
        $checkActive";
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
                        <span class="badge rounded-pill <?= $vacancys['active'] == 't' ? 'bg-success' : 'bg-danger' ?>">
                        <?= $vacancys['active'] == 't' ? 'Ativa' : 'Inativa' ?></span>
                    </div>
                    <p class="card-text"><b>Função: </b><?= $vacancys['profession'] ?></p>
                    <p class="card-text"><b>Descrição da vaga: </b><?= $vacancys['description'] ?>
                    </p>
                    <p class="card-text"><b>Requisitos para vaga:
                        </b><?= $vacancys['description'] ?></p>
                    <a name="btnEditVacancy" value="<?=$vacancys['id_vacancy']?>" type="submit"
                        href="?action=edit&vacancy=<?=$vacancys['id_vacancy']?>" class="btn btn-success">Editar vaga</a>
                </div>
            </div>
        <?php } 
	?>
</div>