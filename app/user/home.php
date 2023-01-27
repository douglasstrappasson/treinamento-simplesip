<?php
	$action = $_SESSION['action'] = isset($_GET['action']) ? $_GET['action'] : NULL ;
?>


<div class=" container">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="col-xxl-10 col-xl-10 col-lg-10 mb-5 p-4 bg-light rounded">
                    <nav class="navbar navbar-default mb-3">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="#"><img src="public/img/logo-simplesip-min.png"
                                        alt="logo" width="200"></a>
                            </div>
                            <a href="./index.php?id=2" class="btn btn-danger navbar-btn">
                                Logout
                            </a>
                        </div>
                    </nav>
                    <form method="POST">
                        <nav class="mb-2 ">
                            <div class="d-flex justify-content-between nav nav-tabs" id="nav-tab" role="tablist">

                                <a name="nav_active_tab" value=""
                                    class="nav-link <?= $action == 'list' || $action == null ? 'show active' : '' ?>"
                                    href="?action=list">
                                    Vagas Ativas
                                </a>

                                <a class="nav-link <?= $action == 'edit' || $action == 'register'? 'show active' : '' ?>"
                                    name="nav_register_tab" href="<?= $action == 'edit' ? '' : '?action=register' ?>">
                                    <?= $action == 'edit' ? 'Editar' : 'Cadastrar' ?>
                                    Vagas
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content">
                            <!--ABA LISTAR VAGAS-->
                            <?php  $action == 'list' || $action == null ? include('listVacancy.php') : '' ?>

                            <!--ABA EDITAR VAGAS-->
                            <?php $action == 'edit' ? include('editVacancy.php') : '' ?>

                            <!--ABA CADASTRO-->
                            <?php $action == 'register' ? include('registerVacancy.php') : '' ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
