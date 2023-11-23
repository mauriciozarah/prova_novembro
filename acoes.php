<?php 

// classe de validações ==============================================
require_once 'classes/Validacoes.php';

// configurações do banco de dados ===================================
require_once 'config/config.php';

// conexão unica com o banco de dados ================================
require_once 'database/Connection.php';

// chamando a model corretor e setando a conexão para as queries =====
require_once 'model/CorretorModel.php';

// regras de negócios para cpf duplicado
require_once 'classes/CorretorRules.php';


if (Validacoes::exists($_REQUEST['acao']) && Validacoes::acao($_REQUEST['acao'])) 
{
	//===================================================================================

	// pegando uma instancia da conexão
	$con = Connection::getInstance();

	// setando a conexão na model CorretorModel
	CorretorModel::setConnection($con);

	// pegando a acão
	$ACAO = $_REQUEST['acao'];


    // ===================================================================================

	// SE FOR GET
	if ($ACAO == 'get') {

		$ret = CorretorModel::get();
		if ($ret) {
			Validacoes::retorno(false, $ret);
		} else {
			Validacoes::retorno(false, []);
		}

	}

	//====================================================================================

	// SE FOR SHOW => mostrar dados
	if ($ACAO == 'show') {

		if (Validacoes::exists($_REQUEST['id']) && Validacoes::id($_REQUEST['id'])) {
			$ret = CorretorModel::show($_REQUEST['id']);
			Validacoes::retorno(false, $ret);
		} else {
			Validacoes::retorno(true, 'Não consta Identificador');
		}
	}

	//====================================================================================

	// SE FOR ADD => inserir dados
	if ($ACAO == 'add') {

		$DADOS_VALIDOS = ( 
			Validacoes::cpf($_REQUEST['cpf']) && 
			Validacoes::nome($_REQUEST['nome']) && 
			Validacoes::creci($_REQUEST['creci'])
		);

		/// Regras do CPF duplicado ----------------------------------------------------------
		$duplicado = CorretorRules::checkAdd($_REQUEST['cpf']);
		if ($duplicado) {
			Validacoes::retorno(true, 'Já existe este CPF cadastrado.');
			die();
		}

		/// Dados Validos e CPF não duplicado ------------------------------------------------
		if ($DADOS_VALIDOS) {
			$corretor = Validacoes::toObject($_REQUEST, 'add');
			$ret = CorretorModel::add($corretor);
			if ($ret) {
				Validacoes::retorno(false, 'Adicionado com Sucesso.');
			} else {
				Validacoes::retorno(true, 'Erro ao Adicionar.');
			}
		} else {
			Validacoes::retorno(true, 'Dados inconsistentes');
		}
	}

	//======================================================================================

	// SE FOR UPDATE => atualizar dados
	if ($ACAO == 'update') {

		$DADOS_VALIDOS = ( 
			Validacoes::cpf($_REQUEST['cpf']) && 
			Validacoes::nome($_REQUEST['nome']) && 
			Validacoes::creci($_REQUEST['creci']) && 
			Validacoes::id($_REQUEST['id'])
		);

		/// Regras do CPF duplicado --------------------------------------------------------
		$duplicado = CorretorRules::checkUpdate($_REQUEST['cpf'], $_REQUEST['old_cpf']);
		if ($duplicado) {
			Validacoes::retorno(true, 'Já existe este CPF cadastrado.');
			die();
		}

		/// Se dados são válidos e cpf não duplicado ---------------------------------------
		if ($DADOS_VALIDOS) {
			if (Validacoes::exists($_REQUEST['id'])) {
				// retorna um standard Object para a variavel
				$corretor = Validacoes::toObject($_REQUEST, 'update');
				// atualiza o banco de dados
				$ret = CorretorModel::update($corretor);
				if ($ret) {
					Validacoes::retorno(false, 'Editado com Sucesso.');
				} else {
					Validacoes::retorno(true, 'Erro ao Editar');
				}
			} else {
				Validacoes::retorno(true, 'Não consta Identificador');
			}
		} else {
			Validacoes::retorno(true, 'Dados Inconsistentes');
		}
	}

	//=============================================================================


	// SE FOR DELETE => atualiza para ativo = 'N' e não apresenta mais na tabela
	if ($ACAO == 'delete') {

		if (Validacoes::exists($_REQUEST['id']) && Validacoes::id($_REQUEST['id'])) {
			$ret = CorretorModel::delete($_REQUEST['id']);
			if ($ret) {
				Validacoes::retorno(false, 'Deletado com Sucesso.');
			} else {
				Validacoes::retorno(true, 'Erro ao deletar');
			}
		} else {
			Validacoes::retorno(true, 'Identificador não Encontrado');
		}
	}

} else {
	Validacoes::retorno(true, 'Ação é necessária');
}



// ===========================================================================================