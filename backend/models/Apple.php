<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property string $created
 * @property string $date_fall
 * @property int $status
 * @property double $eat_percent
 */
class Apple extends \yii\db\ActiveRecord
{
    public $status;
    public $day_fall;
    /**
     * {@inheritdoc}
     */


    public function __construct($color='')
    {
        $this->color = $color;
         parent::__construct();
    }



    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'created'], 'required'],
            [['size'], 'integer'],
            [['color'], 'string', 'max' => 20],
        ];
    }
    public function fallToGround(){
        $this->date_fall=$this->created+rand(1,10)*60*60;
        $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'created' => 'Создано',
            'date_fall' => 'Упало',
            'size' => 'Размер',
        ];
    }

    public function afterFind()
    {
        if(!$this->date_fall){
            $this->status= 1;
        }else{
            $this->day_fall=floor(($this->date_fall-$this->created)/(60*60));
            if($this-> day_fall>5){
                $this->status= 3;
            }else{
                $this->status= 2;
            }
        }
    }
}
