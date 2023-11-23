<?php 

class CorretorRules extends CorretorModel
{
	// Ao adicionar registro, checa se já não há um cpf igual
	public static function checkAdd ($cpf) 
	{
		return parent::cpfReadyExists($cpf);
	}

	// Ao atualizar registro, checa se o cpf informado já não existe na base
	public static function checkUpdate ($cpf, $old_cpf)
	{
		if ($cpf != $old_cpf) {
			return parent::cpfReadyExists($cpf);
		} else {
			return false;
		}
	}	
}