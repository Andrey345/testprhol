<h2><a href="/admin/apple/create">Добавить яблоко</a></h2>
<br>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $data,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'color',

        [
            'attribute'=>'created',
            'value'=>function($model){
                return gmdate("Y-m-d H:i:s ", $model->created);
            }
        ],
        [
            'attribute'=>'date_fall',
            'value'=>function($model){
                if($model->date_fall)
                return gmdate("Y-m-d H:i:s ", $model->date_fall);
                return '';
            }
        ],
        [
            'label'=>'Состояние',
            'value'=>function($model){
                switch($model->status){
                    case 1: return 'Висит на дереве';
                    break;
                    case 2: return 'Упало('.$model->day_fall.' часов)';
                        break;
                    case 3: return  'Сгнило('.$model->day_fall.' часов)';
                        break;
                }
            }

        ],
        [
            'label'=>'Сьели',
            'value'=>function($model){
                return 100-$model->size.'%';
            }
        ],


        [
            'label' => 'Функции',
            'format' => 'raw',
            'value' => function($model){
                $html='';
                if($model->status==2){
                    $html.=' 
                    <form method="get" action="/admin/apple/eat/'.$model->id.'">
                    <input name="percent" type="number" max="'.$model->size.'">
                    <button type="submit">Сьесть</button>
                    </form>
                    <br>
                    ';
                }
                if($model->status==1) {
                    $html.= '
                <a href="/admin/apple/fall-to-ground/' . $model->id . '">Упасть</a> 
                 <br>
                
                ' ;
                }

                $html.=' <a href="/admin/apple/delete/' . $model->id . '">Удалить</a>';

                return $html;
            },
        ],
    ],
]); ?>