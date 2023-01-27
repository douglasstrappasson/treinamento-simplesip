<?php
$action = $_SESSION['action'] = isset($_GET['action']) ? $_GET['action'] : NULL ;

$btnLogin_1 = $_SESSION['btnLogin_1'] = isset($_GET['btnLogin_1']) ? $_GET['btnLogin_1'] : NULL;	
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
                                <a class="navbar-brand" href="#"><img
                                        src="public/img/logo-simplesip-min.png" alt="logo" width="200"></a>
                            </div>

                            <a name="btnLogin_1" value="" type="submit" href="?id=0"
                                class="btn btn-success navbar-btn">Login</a>
                        </div>
                    </nav>
                    <form method="POST" enctype="multipart/form-data">
                        <nav class="mb-2 ">
                            <div class="d-flex justify-content-between nav nav-tabs" id="nav-tab" role="tablist">

                                <a name="nav_active_tab" value=""
                                    class="nav-link <?= $action == 'list' || $action == null ? 'show active' : '' ?>"
                                    href="?action=list">
                                    Vagas Ativas
                                </a>

                                <a class="nav-link <?= $action == 'subscription' && $action != null ? 'show active' : 'd-none' ?>"
                                    name="nav_subscription_tab"
                                    href="<?= $action == 'subscription' ? '' : '?action=subscription' ?>">
                                    Inscrever
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <!--ABA LISTAR VAGAS-->
                            <?php $action == 'list' || $action == null ? include('listVacancyPage.php') : '' ?>

                            <!--ABA INSCREVA-SE-->
                            <?php $action == 'subscription' ? include('subscriptionPage.php') : '' ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>