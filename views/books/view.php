<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Books */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'year',
            'description:ntext',
            'isbn',
            [
                'attribute' => 'image',
                'value' => $model->image ? $model->imagePath : null,
                'format' => $model->image ? ['image',['width'=>'100','height'=>'150']] : null,
            ],
            [
                'attribute' => 'authors',
                'value' => function($data){
                    $html = "";
                    foreach ($data->authors as $author) {
                        $html .= Html::tag("div", $author->name);
                    }
                    return $html;
                },
                'format' => "html",
            ]

        ],
    ]) ?>

</div>
