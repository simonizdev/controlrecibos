<?php

//clase creada para funciones relacionadas con el modelo de usuario

class UtilidadesUsuario {
   
	public static function adminperfilusuario($id_user, $array) {
		$array_per_selec = array();
		foreach ($array as $clave => $valor) {
		    
		    //se busca el registro para saber si tiene que ser creado 
		    $criteria=new CDbCriteria;
			$criteria->condition='Id_Usuario=:Id_Usuario AND Id_Perfil=:Id_Perfil';
			$criteria->params=array(':Id_Usuario'=>$id_user,':Id_Perfil'=>$valor);
			$modelo_perfil_usuario=PerfilUsuario::model()->find($criteria);

			if(!is_null($modelo_perfil_usuario)){
				//si el estado es inactivo se cambia a activo, si ya esta activo no se realiza ninguna acción
				if($modelo_perfil_usuario->Estado == 0){
					$modelo_perfil_usuario->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$modelo_perfil_usuario->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$modelo_perfil_usuario->Estado = 1;
					if($modelo_perfil_usuario->save()){
						array_push($array_per_selec, intval($valor));
					}	
				}else{
					array_push($array_per_selec, intval($valor));	
				}
			}else{
				//se debe insertar un nuevo registro en la tabla
				$nuevo_perfil_usuario = new PerfilUsuario;
			    $nuevo_perfil_usuario->Id_Usuario = $id_user;
			    $nuevo_perfil_usuario->Id_Perfil = $valor;
				$nuevo_perfil_usuario->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
				$nuevo_perfil_usuario->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
				$nuevo_perfil_usuario->Fecha_Creacion = date('Y-m-d H:i:s');
				$nuevo_perfil_usuario->Fecha_Actualizacion = date('Y-m-d H:i:s');
				$nuevo_perfil_usuario->Estado = 1;
				if($nuevo_perfil_usuario->save()){
					array_push($array_per_selec, intval($valor));
				}
			}
		}

		//se inactivan los perfiles que no vienen en el array
		$perfiles_excluidos = implode(",",$array_per_selec);
		$pe = str_replace("'", "", $perfiles_excluidos);
		$criteria=new CDbCriteria;
		$criteria->condition='Id_Usuario=:Id_Usuario AND Id_Perfil NOT IN ('.$pe.')';
		$criteria->params=array(':Id_Usuario'=>$id_user);
		$modelo_perfil_usuario_inactivar=PerfilUsuario::model()->findAll($criteria);
		if(!is_null($modelo_perfil_usuario_inactivar)){
			foreach ($modelo_perfil_usuario_inactivar as $perfiles_inactivar) {
				//si el estado es activo se cambia a inactivo, si ya esta inactivo no se realiza ninguna acción
				if($perfiles_inactivar->Estado == 1){
					$perfiles_inactivar->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$perfiles_inactivar->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$perfiles_inactivar->Estado = 0;
					$perfiles_inactivar->save();
				}	
			}
		}
	}

	public static function perfilesactivos($id_user) {
		//opciones activas en el combo perfiles
		$criteria=new CDbCriteria;
		$criteria->condition='Id_Usuario=:Id_Usuario AND Estado=:Estado';
		$criteria->params=array(':Id_Usuario'=>$id_user,':Estado'=> 1);
		$array_per_activos = array();
		$perfiles_activos=PerfilUsuario::model()->findAll($criteria);
		foreach ($perfiles_activos as $perf_act) {
			array_push($array_per_activos, $perf_act->Id_Perfil);
		}

		return json_encode($array_per_activos);
	}

}
