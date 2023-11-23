// toaster
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

// variável geral para verificar validade de CPF
var validCPF = true;

//==========================================================================================

// validação do formulário
let validate = () => {
	let cpf = $("#cpf").val();
	let creci = $("#creci").val();
	let nome = $("#nome").val();


	if (cpf.length != 11 || isNaN(cpf) || validCPF == false) {
		toastr.error("Insira um CPF Válido","CPF Inválido");
		return false;
	}

	if (creci.length < 2) {
		toastr.error("CRECI deve conter pelo menos 2 caracteres.", "CRECI Errado");
		return false;
	}

	if ( nome.length < 2 ) {
		toastr.error("Nome deve conter pelo menos 2 caracteres.", "Nome Errado.");
		return false;
	}

	return true;
}

//===============================================================================================

// função para validar CPF
function CPF() {"user_strict";function r(r){for(var t=null,n=0;9>n;++n)t+=r.toString().charAt(n)*(10-n);var i=t%11;return i=2>i?0:11-i}function t(r){for(var t=null,n=0;10>n;++n)t+=r.toString().charAt(n)*(11-n);var i=t%11;return i=2>i?0:11-i}var n="CPF Invalido",i="CPF Valido";this.gera=function(){for(var n="",i=0;9>i;++i)n+=Math.floor(9*Math.random())+"";var o=r(n),a=n+"-"+o+t(n+""+o);return a},this.valida=function(o){for(var a=o.replace(/\D/g,""),u=a.substring(0,9),f=a.substring(9,11),v=0;10>v;v++)if(""+u+f==""+v+v+v+v+v+v+v+v+v+v+v)return n;var c=r(u),e=t(u+""+c);return f.toString()===c.toString()+e.toString()?i:n}}

//===============================================================================================

// instanciando a classe
var cpf = new CPF;


//===============================================================================================

// VALIDANDO CPF

$("#cpf").keypress(function(){
	$("#respostaCPF").html("<small class='cpf'>" + cpf.valida($(this).val() + "<small>"));
	let str = cpf.valida($(this).val());
	if (str === 'CPF Invalido') {
		validCPF = false;
	}
	if (str === 'CPF Valido') {
		validCPF = true;
	}
});
$("#cpf").blur(function(){
	$("#respostaCPF").html("<small class='cpf'>" + cpf.valida($(this).val() + "<small>"));
	let str = cpf.valida($(this).val());
	if (str === 'CPF Invalido') {
		validCPF = false;
	}
	if (str === 'CPF Valido') {
		validCPF = true;
	}
});
$("#cpf").keyup(function(){
	let cpfVal = $(this).val();
	if (cpfVal === "") {
		$("#respostaCPF").html("");
	}
});

// =============================================================================================

// CADASTRAR ou EDITAR REGISTRO

$("#form-send").submit(async function(e) {
	
	e.preventDefault();
	
	var acao = $("#acao").val();

	let right = validate();

	if (right) {
		let campos = $("#form-send").serialize();
		await $.ajax({
			url:'acoes.php',
			type:'POST',
			data:campos,
			success:function(data){

				data = JSON.parse(data);

				if(acao == "update" && !data.error) {
					toastr.success(data.message, "Editado com Sucesso.");
				}

				if(acao == "add" && !data.error) {
					toastr.success(data.message, "Salvo com Sucesso.");
				}

				if (data.error) {
					toastr.error(data.message, 'Erro ao inseir ou editar');
				}

				$("#respostaCPF").html("");


				$("#btn-acao").text("Salvar");

				$("#cpf").val("");
				$("#old_cpf").val("");
				$("#creci").val("");
				$("#nome").val("");
				$("#id").val("");
				$("#acao").val("add");
				//$("#cpf").focus();

				validCPF = true;

				// f5 na tabela
				printTable();
				
			},
			error:function(xhr, error) {
				console.log("xhr:"+xhr+", error:"+error.toString());
			}
		});
	} else {
		toastr("Erro ao inserir ou editar", "Houve um erro");
		return false;
	}
});

//====================================================================================

// CARREGAR A TABELA

const printTable = async () => {
	await $.ajax({
		url:'acoes.php',
		method:'GET',
		data:{acao:'get'},
		success:function(data) {

			data = JSON.parse(data);

			if (!data.error) {
				
				var html = ``;	

				if (data.message !== "" && data.message !== undefined) {
						
						data.message.forEach(item => {
							html += `<tr>
										<td>${item.nome}</td>
										<td>${item.cpf}</td>
										<td>${item.creci}</td>
										<td style="width:20%">
											<a href="#" class="btn btn-warning" onClick="show(${item.id})">Editar</a>
											<a href="#" class="btn btn-danger" onClick="remove(${item.id})">Deletar</a>
										</td>
									</tr>`;
						});
					
				} else {
						html += `<tr><td colspan="4">Tabela Vazia</td></tr>`;
				}

				$("#table-body").html(html);

			} 
		},
		error:function(xhr, error) {
			console.log("xhr:"+xhr+", error:"+error.toString());
		}
	});
}

//=============================================================================================

// CARREGAR TABELA ASSIM QUE A PÁGINA INICIA

$(document).ready(function(){
	printTable();
});

//=============================================================================================

// BUSCAR PARA EDITAR

const show = async (id) => {
		await $.ajax({
				url:'acoes.php',
				type:'GET',
				data:{id:id,acao:'show'},
				success:function(data) {
					  data = JSON.parse(data);

					  if (!data.error) {
							 	$("#acao").val('update');
								$("#cpf").val(data.message.cpf);
								$("#old_cpf").val(data.message.cpf);
								$("#creci").val(data.message.creci);
								$("#nome").val(data.message.nome);
								$("#id").val(data.message.id);

								$("#btn-acao").text("Editar");
								$("#respostaCPF").html("");


								validCPF = true;
					  }


				},
				error:function(xhr, error) {
					console.log("xhr:" + xhr + ", error:" + error.toString());
				}
		});
}

//=========================================================================================

// DELETAR REGISTRO

const remove = async (id) => {

	let conf = confirm("Confirma deletar este registro?");

	if (conf) {
		
		await $.ajax({
				url:'acoes.php',
				type:'GET',
				data:{id:id,acao:'delete'},
				success:function(data) {
					data = JSON.parse(data);

					if (data.error) {
						toastr.error(data.message, "Houve um erro.");
						return false;
					}

					toastr.success(data.message, 'Deletado com sucesso.');
					printTable();
				},
				error:function(xhr, error) {
					console.log("xhr: " + xhr + ", error: " + error.toString());
				}
		});

	} else {
		return false;
	}

}

//=======================================================================

// RESETAR FORMULÁRIO
$("#btn-reset").on('click', function (){
		$("#respostaCPF").html("");
		$("#btn-acao").text("Salvar");
		$("#cpf").val("");
		$("#old_cpf").val("");
		$("#creci").val("");
		$("#nome").val("");
		$("#id").val("");
		$("#acao").val("add");
});

