<?php

/**
 * This is the model class for table "requests".
 *
 * The followings are the available columns in table 'requests':
 * @property integer $id
 * @property string $instructor_name_rus
 * @property string $instructor_name_eng
 * @property string $course_name_rus
 * @property string $course_name_eng
 * @property string $course_tags_rus
 * @property string $course_tags_eng
 * @property string $outcomes_rus
 * @property string $outcomes_eng
 * @property string $date
 * @property string $instructor_email
 */
class Request extends CActiveRecord
{
        public $xls_file;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Request the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instructor_name_rus', 'required', 'message'=>Yii::t('Request', 'Поле ФИО преподавателя обязательное!')),
                        array('course_name_rus', 'required', 'message'=>Yii::t('Request', 'Поле Название курса обязательное!')),
                        array('course_tags_rus', 'required', 'message'=>Yii::t('Request', 'Поле Ключевые слова обязательное!')),
                        array('outcomes_rus', 'required', 'message'=>Yii::t('Request', 'Поле Что умеет студент обязательное!')),
                        array('instructor_email', 'required', 'message'=>Yii::t('Request', 'Поле email преподавателя обязательное!')),
                        array('instructor_name_rus, instructor_name_eng, course_name_rus, course_name_eng', 'length', 'max'=>255),
			array('instructor_email', 'length', 'max'=>100),
                        array('instructor_email', 'email', 'message'=>Yii::t('Request', 'Поле email заполено неверно!')),
                        array('xls_file', 'file', 'types'=>'xls, xlsx', 'allowEmpty'=>true),
                        array('url','safe'),
                        array('instructor_name_eng','safe'),
                        array('course_name_eng','safe'),
                        array('course_tags_eng','safe'),
                        array('outcomes_eng','safe'),
			array('id, instructor_name_rus, instructor_name_eng, course_name_rus, course_name_eng, course_tags_rus, course_tags_eng, outcomes_rus, outcomes_eng, date, instructor_email, url', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'instructor_name_rus' => 'ФИО преподавателя',
			'instructor_name_eng' => 'ФИО преподавателя (англ.)',
			'course_name_rus' => 'Наименование курса',
			'course_name_eng' => 'Наименование курса (англ.)',
			'course_tags_rus' => 'Ключевые слова курса',
			'course_tags_eng' => 'Ключевые слова курса (англ.)',
			'outcomes_rus' => 'Компетенции(что умеет студент после окончания курса)',
			'outcomes_eng' => 'Компетенции(что умеет студент после окончания курса)(англ.)',
			'date' => 'Дата заполнения',
			'instructor_email' => 'email преподавателя для связи',
                        'url' => 'Ссылка на курс в системе moodle',
		);
	}
        
        protected function beforeSave()
        {
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/upload/'))
            {
                mkdir($_SERVER['DOCUMENT_ROOT'].'/upload/', 0777);
            }
            $xls_file = CUploadedFile::getInstance($this,'xls_file');
            if ($xls_file)
            {
                $this->xls_file=$imgfile;
                $this->xls_file->saveAs(
                    $_SERVER['DOCUMENT_ROOT'].'/upload/'.$this->xls_file);
            }
            
            return true;
        }

        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('instructor_name_rus',$this->instructor_name_rus,true);
		$criteria->compare('instructor_name_eng',$this->instructor_name_eng,true);
		$criteria->compare('course_name_rus',$this->course_name_rus,true);
		$criteria->compare('course_name_eng',$this->course_name_eng,true);
		$criteria->compare('course_tags_rus',$this->course_tags_rus,true);
		$criteria->compare('course_tags_eng',$this->course_tags_eng,true);
		$criteria->compare('outcomes_rus',$this->outcomes_rus,true);
		$criteria->compare('outcomes_eng',$this->outcomes_eng,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('instructor_email',$this->instructor_email,true);
                $criteria->compare('url',$this->url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}