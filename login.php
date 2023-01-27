<?php
	//print_r($_POST);
	$btnLogin = addslashes(trim($_POST['btn-login']));
	//unset($message);
	if (!empty($btnLogin)){
		$login = addslashes(trim($_POST['login']));
		$password = addslashes(trim($_POST['password']));
		$message = '';
	//unset($message);
		$message = '';
		if (isset($login) && empty($login)){
			$message = 'Você deve digitar seu login e senha!';
		} elseif (isset($password) && empty($password)){
			$message = 'Você deve digitar sua senha!';
		} elseif (isset($login) && !empty($login) && isset($password) && !empty($password)){
			$sqlCode = "SELECT * FROM users WHERE email = '$login' AND  password = '$password'";
			$sqlQuery = pg_query(open_database(), $sqlCode) or $message = 'Falha na execuçã do código SQL!';
			$nRows = pg_num_rows($sqlQuery);
			//existsOnDB($sqlCode);

			if($nRows == 1){
				//echo 'Deu certo por enquanto!';
				$sessionUser = pg_fetch_assoc($sqlQuery);
				$_SESSION['id'] = $sessionUser['id'];
				$_SESSION['username'] = $sessionUser['username'];
				$_SESSION['logged'] = true; 
				header("Location: index.php?id=1");
			} else {
				$message = 'Falha ao logar! Login ou senha inválidos!';
			}
		}
	}
?>		
		<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-9">
						<div class="text-center my-5 ">
							<img src="public/img/logo-simplesip-min.png" alt="logo" width="200">
						</div>
						<div class="card shadow-lg">
							<div class="card-body px-5">
								<h1 class="fs-4 fw-bold mb-4">
									Login
								</h1>
								<form method="POST" class="needs-validation"  novalidate="" autocomplete="off">
									<div class="mb-3">
										<label class="text-muted" for="email">Endereço de E-Mail</label>
										<input id="email" type="email" class="form-control" name="login" value="<?php echo $_POST['login'] ?? ''; ?>" autofocus>									
									</div>

									<div class="mb-3">
										<div class="mb-2 w-100">
											<label class="mb-1 text-muted" for="password">
												Senha
											</label>
											<input id="password" type="password" class="form-control" name="password">
										</div>
									</div>

									<div class="d-flex justify-content-between">
									<a href="#" class="mb-2 primary-color text-decoration-none">
												Esqueceu sua senha?
											</a>
										<div class="form-check">
											<input type="checkbox" name="remember" id="remember" class="form-check-input">
											<label for="remember" class="form-check-label">Lembrar-se de mim</label>
										</div>
									</div>
									
										<?php if (isset($message) && !empty($message)){
											echo '<div class="mt-2 alert alert-danger" role="alert">'.$message.'</div>';
										}
										?>
									

									<div class="d-flex justify-content-center">
										<button name="btn-login" value="1" type="submit" class="btn d-flex btn-primary ms-auto mt-4">
											Login
										</button>
										
									</div>
								</form>
							</div>
							<div class="card-footer py-3 border-0">
								<div class="text-center">
									Ainda não possui conta? <a href="register.html" class="text-dark">Cadastre-se</a>
								</div>
							</div>
						</div>
						<div class="text-center mt-5 text-muted">
							Copyright &copy; 2023 &mdash; Simples.ip 
						</div>
					</div>
				</div>
			</div>
	</section>