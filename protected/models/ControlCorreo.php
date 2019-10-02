<?php

/**
 * This is the model class for table "TH_CONTROL_CORREO".
 *
 * The followings are the available columns in table 'TH_CONTROL_CORREO':
 * @property integer $ROWID
 * @property string $ID
 * @property string $ASUNTO
 * @property string $REMITENTE
 * @property string $ANEXOS
 * @property string $FECHA
 * @property string $REGISTRO
 */


	

class ControlCorreo extends CActiveRecord
{
	
	public $fecha_correo_inicial;
	public $fecha_correo_final;
	public $fecha_registro_inicial;
	public $fecha_registro_final;
	public $orderby;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_CONTROL_CORREO';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID, ASUNTO, REMITENTE, ANEXOS, FECHA', 'length', 'max'=>500),
			array('FECHA, REGISTRO', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ROWID, ID, ASUNTO, REMITENTE, ANEXOS, FECHA, REGISTRO, fecha_correo_inicial, fecha_correo_final, fecha_registro_inicial, fecha_registro_final, orderby', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ROWID' => 'ID',
			'ID' => 'ID Correo',
			'ASUNTO' => 'Asunto de correo',
			'REMITENTE' => 'Remitente de correo',
			'ANEXOS' => 'Adjunto',
			'FECHA' => 'Fecha y hora de correo',
			'REGISTRO' => 'Fecha y hora de registro',
			'fecha_correo_inicial' => 'Fecha de correo inicial',
			'fecha_correo_final' => 'Fecha de correo final',
			'fecha_registro_inicial' => 'Fecha de registro inicial',
			'fecha_registro_final' => 'Fecha de registro final',
			'orderby' => 'Orden de resultados',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->together  =  true;

		$criteria->compare('t.ROWID',$this->ROWID);
		$criteria->compare('t.ID',$this->ID, true);
		$criteria->compare('t.ASUNTO',$this->ASUNTO, true);
		$criteria->compare('t.REMITENTE',$this->REMITENTE, true);
		$criteria->compare('t.ANEXOS',$this->ANEXOS, true);

		if($this->fecha_correo_inicial != "" && $this->fecha_correo_final != ""){
      		$fci = $this->fecha_correo_inicial." 00:00:00";
      		$fcf = $this->fecha_correo_final." 23:59:59";

      		$criteria->addBetweenCondition('t.FECHA', $fci, $fcf);
    	}else{
    		if($this->fecha_correo_inicial != "" && $this->fecha_correo_final == ""){
    			$fci = $this->fecha_correo_inicial." 00:00:00";
      			$fcf = $this->fecha_correo_inicial." 23:59:59";

      			$criteria->addBetweenCondition('t.FECHA', $fci, $fcf);	
    		}
    	}

    	if($this->fecha_registro_inicial != "" && $this->fecha_registro_final != ""){
      		$fci = $this->fecha_registro_inicial." 00:00:00";
      		$fcf = $this->fecha_registro_final." 23:59:59";

      		$criteria->addBetweenCondition('t.REGISTRO', $fci, $fcf);
    	}else{
    		if($this->fecha_registro_inicial != "" && $this->fecha_registro_final == ""){
    			$fci = $this->fecha_registro_inicial." 00:00:00";
      			$fcf = $this->fecha_registro_inicial." 23:59:59";

      			$criteria->addBetweenCondition('t.REGISTRO', $fci, $fcf);	
    		}
    	}

		if(empty($this->orderby)){
			$criteria->order = 't.ROWID DESC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.ROWID ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.ROWID DESC'; 
			        break;
			    case 3:
			        $criteria->order = 't.ID ASC'; 
			        break;
			    case 4:
			        $criteria->order = 't.ID DESC'; 
			        break;
		        case 5:
			        $criteria->order = 't.ASUNTO ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.ASUNTO DESC'; 
			        break;
			    case 7:
			        $criteria->order = 't.REMITENTE ASC'; 
			        break;
			    case 8:
			        $criteria->order = 't.REMITENTE DESC'; 
			        break;
			    case 9:
			        $criteria->order = 't.ANEXOS ASC'; 
			        break;
			    case 10:
			        $criteria->order = 't.ANEXOS DESC'; 
			        break;
				case 11:
			        $criteria->order = 't.FECHA ASC'; 
			        break;
			    case 12:
			        $criteria->order = 't.FECHA DESC'; 
			        break;
			    case 13:
			        $criteria->order = 't.Registro DESC'; 
			        break;
			    case 14:
			        $criteria->order = 't.Registro ASC'; 
			        break;
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize'])),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ControlCorreo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
