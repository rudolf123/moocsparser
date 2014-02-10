<?php

/**
 * This is the model class for table "courses".
 *
 * The followings are the available columns in table 'courses':
 * @property integer $id
 * @property string $title
 * @property string $schoolname
 * @property string $platform
 * @property string $start
 * @property string $length
 * @property string $estimate
 * @property string $language
 * @property string $subtitles
 * @property string $about
 * @property string $staff
 * @property string $staff_profile
 * @property string $info
 * @property string $similar
 */
class Course extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
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
		return 'courses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, schoolname, platform, start, length, estimate, language, subtitles, about, staff, staff_profile, info, similar', 'required'),
			array('title, schoolname, platform, estimate', 'length', 'max'=>255),
			array('start', 'length', 'max'=>200),
			array('length', 'length', 'max'=>50),
			array('language, subtitles', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, schoolname, platform, start, length, estimate, language, subtitles, about, staff, staff_profile, info, similar', 'safe', 'on'=>'search'),
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
			'id' => '№',
			'title' => 'Название',
			'schoolname' => 'Университет',
			'platform' => 'Платформа',
			'start' => 'Дата начала',
			'length' => 'Продолжительность',
			'estimate' => 'Самоподготовка',
			'language' => 'Язык',
			'subtitles' => 'Субтитры',
			'about' => 'О курсе',
			'staff' => 'Преподаватели',
			'staff_profile' => 'Профайл преподавателей',
			'info' => 'Доп. информация',
			'similar' => 'Похожие курсы',
		);
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('schoolname',$this->schoolname,true);
		$criteria->compare('platform',$this->platform,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('estimate',$this->estimate,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('subtitles',$this->subtitles,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('staff',$this->staff,true);
		$criteria->compare('staff_profile',$this->staff_profile,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('similar',$this->similar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}