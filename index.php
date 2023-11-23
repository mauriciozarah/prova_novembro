<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Prova de Ingresso" />
	<meta name="author" content="Mauricio Zaha" />
	<title>Cadastro de Corretor</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
	<link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
	<header>
		<h1 class="text-center mt-5">Cadastro de Corretor</h1>
	</header>
	<main>
		<div class="container text-center mt-5">
			<div class="card card-info mt-5" style="box-shadow:0 0 15px #ddd;">
				<form name="formulario" id="form-send" class="form-horizontal">
					<div class="card-header">
						Cadastrar um Corretor
					</div>
					<div class="card-body text-left">
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<input type="text" name="cpf" id="cpf" maxlength="11" class="form-control" placeholder="CPF"  required="required" pattern="[0-9]+$"/><br />
								<span id="respostaCPF"></span>
							</div>
							<div class="col-md-7 col-sm-12">
								<input type="text" name="creci" id="creci" minlength="2" maxlength="20" class="form-control" placeholder="CRECI" required="required" />
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-12">
								<input type="text" name="nome" id="nome" minlength="2" class="form-control" placeholder="NOME" required="required" />
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-12">
								<button type="submit" class="btn btn-secondary" id="btn-acao">Enviar</button>
								&nbsp;&nbsp;
								<button type="button" class="btn btn-secondary" id="btn-reset">Limpar</button>
							</div>
						</div>	
					</div>
					<input type="hidden" name="acao" id="acao" value="add">
					<input type="hidden" name="id" id="id" value="">
					<input type="hidden" name="old_cpf" id="old_cpf" value="">
				</form>
			</div>
		</div>
		<div class="container mt-5">
			<table class="table" style="border-radius:5px;box-shadow:0 0 15px #ddd">
				<thead>
					<tr>
						<th>NOME</th>
						<th>CPF</th>
						<th>CRECI</th>
						<th>AÇÕES</th>
					</tr>
				</thead>
				<tbody id="table-body"></tbody>
			</table>
		</div>
	</main>
	<footer>
		<div class="text-center">
			Todos os Direitos Reservados &copy;
		</div>
	</footer>
<script src="assets/js/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="assets/js/acoes.js"></script>
</body>
</html>