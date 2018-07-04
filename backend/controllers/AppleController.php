<?php
namespace backend\controllers;

use backend\models\Apple;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function toHome(){
        $this->redirect('/admin/apple');
    }
    public function actionCreate($color=''){
        $apple=new Apple($color);
        if(!$apple->color)
            $apple->color=sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
        $apple->created=time()+rand(1,100)*60*60;
        $apple->save();
        $this->toHome();
    }
    public function actionEat($id,$percent){
        $apple=Apple::findOne($id);
        $new_size=$apple->size-$percent;
        if($new_size<1){
            $apple->delete();
        }else{
            $apple->size=$new_size;
            $apple->save();
        }
        $this->toHome();
    }
    public function actionDelete($id){
        $apple=Apple::findOne($id);
        if($apple)
            $apple->delete();
    }

    public function actionFallToGround($id){
        $apple=Apple::findOne($id);
        $apple->fallToGround();
        $this->toHome();
    }
    public function actionIndex()
    {

        $query = Apple::find();
        $data = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);
        return $this->render('index',['data'=>$data]);
    }



}
