<?php
class JBridgeDAO {
	
	/**
	 * Obtém o objeto do joomla que controla a interação com a base de dados
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @version 1.0 <2011-02-04>
	 * @since 1.0
	 * 
	 * @return JDatabaseMySQL DBO do Joomla!
	 */
	public function getDBO() {
		$db =& JFactory::getDBO();
		FIncludeHelper::loadClass('fwPackage.joomla15Bridge.class.JBridgeMySQL');
		
		return new JBridgeMySQL($db);
	}
	
	/**
	 * Verifica se um usuário do joomla existe
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @version 1.0 <2011-11-20>
	 * @since 1.0
	 * 
	 * @return bool
	 */
	public function checaExistenciaUsuario($intUserId){
		$objDb = self::getDBO();
		$objDb->setQuery( 'SELECT `username` FROM #__users WHERE id=' . $objDb->quote( $intUserId ));
		    
		return !is_null($objDb->loadResult());
	}
	
	/**
	 * Ativa o usuário na tabela do CB e do joomla
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @version 1.0 <2011-11-20>
	 * @since 1.0
	 * 
	 * @return JDatabaseMySQL DBO do Joomla!
	 */
	public function ativarUsuario($strCBActivation){
		$objDb = self::getDBO();
		
		$objDb->setQuery( 'SELECT `user_id` FROM #__comprofiler WHERE cbactivation=' . $objDb->quote( $strCBActivation ));
		$intUserId = $objDb->loadResult();
		if(is_null($intUserId))
			throw new Exception('ERRO. O usuário não existe para ser ativo.');
		
		//ativar o user no CB
		$objDb->setQuery( 'UPDATE #__comprofiler SET confirmed = 1 WHERE cbactivation=' . $objDb->quote( $strCBActivation ));
		$objDb->query();
		
		//desbloquear o user do joomla
		$objDb->setQuery( 'UPDATE #__users SET block = 0 WHERE id=' . $objDb->quote( $intUserId ));
		$objDb->query();
		
		return $intUserId;
	}
}
?>