<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
  /**
   * Authenticates a user.
   * The example implementation makes sure if the username and password
   * are both 'demo'.
   * In practical applications, this should be changed to authenticate
   * against some persistent user identity storage (e.g. database).
   * @return boolean whether authentication succeeds.
   */

  const ERROR_USERNAME_NOT_FOUND = 3;
  const ERROR_USERNAME_INACTIVE = 4;
  const ERROR_PASSWORD_NO_VALID = 5;
  const ERROR_PERFILES_NOT_FOUND = 6;

  public function authenticate()
  {
    //se busca el registro en usuarios
    $modelousuario=Usuario::model()->findByAttributes(array('Usuario'=>$this->username));

    if (is_null($modelousuario)) {
      //no se encontro usuario
        $this->errorCode=self::ERROR_USERNAME_NOT_FOUND;
    } else if ($modelousuario->Estado == 0) {
        //usuario inactivo
        $this->errorCode=self::ERROR_USERNAME_INACTIVE;
    } else if ($modelousuario->Password !== sha1($this->password)) {
        //password incorrecto
        $this->errorCode=self::ERROR_PASSWORD_NO_VALID;
    } else {
      //usuario valido

      //permisos para actualizar registros
      $permiso_act = false;

      //se verifica cuantos perfiles tiene asociado el usuario
      $criteria = new CDbCriteria;
      $criteria->join ='LEFT JOIN TH_PERFIL p ON t.Id_Perfil = p.Id_Perfil';
      $criteria->condition = 't.Id_Usuario = :Id_Usuario AND t.Estado = :Estado';
      $criteria->order = 'p.Descripcion';
      $criteria->params = array(":Id_Usuario" => $modelousuario->Id_Usuario, ":Estado" => 1);
      $perfiles_usuario=PerfilUsuario::model()->findAll($criteria);

      $num_perf=0;
      foreach ($perfiles_usuario as $pu) {
        if($pu->idperfil->Estado != 0){
          $num_perf++;
        }
      }
      
      if ($num_perf == 0){
        //usuario sin perfiles asociados o perfiles asociados inactivos
        $this->errorCode=self::ERROR_PERFILES_NOT_FOUND;
      } else {

        $array_perfiles = array();
        foreach ($perfiles_usuario as $p) {
          if($p->idperfil->Estado != 0){
              array_push($array_perfiles, $p->Id_Perfil);
              if($p->idperfil->Modificacion_Reg != 0){
                $permiso_act = true; 
              }
          } 
        }

        $this->setState('id_user', $modelousuario->Id_Usuario);
        $this->setState('name_user', $modelousuario->Nombres);
        $this->setState('username_user', $modelousuario->Usuario);
        $this->setState('email_user', $modelousuario->Correo);
        $this->setState('array_perfiles', $array_perfiles);
        $this->setState('permiso_act', $permiso_act);
        $this->errorCode=self::ERROR_NONE;

      }
    }

    return $this->errorCode;
  }
}