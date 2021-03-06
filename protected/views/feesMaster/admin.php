<?php
$this->breadcrumbs=array(
	'Fees Category'=>array('admin'),
	'Manage',
);

$this->menu=array(
/*	array('label'=>'List FeesMaster', 'url'=>array('index')),*/
	array('label'=>'', 'url'=>array('previousFeesData'),'linkOptions'=>array('class'=>'previous-fees','title'=>'Show Previous Fees')),
	array('label'=>'', 'url'=>array('GenerateMultipleFees'),'linkOptions'=>array('class'=>'multiplefees','title'=>'Generate Multiple Fees')),
	array('label'=>'', 'url'=>array('assignFeesStudent'),'linkOptions'=>array('class'=>'assign-fees-student','title'=>'Assign Fees to Student')),
	array('label'=>'', 'url'=>array('ExportToPDFExcel/FeesMasterExportPdf'),'linkOptions'=>array('class'=>'export-pdf','title'=>'Export To PDF','target'=>'_blank')),
	array('label'=>'', 'url'=>array('ExportToPDFExcel/FeesMasterExportToExcel'),'linkOptions'=>array('class'=>'export-excel','title'=>'Export To Excel','target'=>'_blank')),
	
);

/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('fees-master-grid', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<h1>Manage Fees Category</h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div>


<?php
$dataProvider = $model->search();
if(Yii::app()->user->getState("pageSize",@$_GET["pageSize"]))
$pageSize = Yii::app()->user->getState("pageSize",@$_GET["pageSize"]);
else
$pageSize = Yii::app()->params['pageSize'];
$dataProvider->getPagination()->setPageSize($pageSize);
?>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fees-master-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		array(
		'header'=>'SI No',
		'class'=>'IndexColumn',
		),
		//'fees_master_id',
		'fees_master_name',
		/*
		array(
                'name'=>'branch_name',
//                'type'=>'raw',		
                'value'=> '$data->Rel_fees_branch->branch_name',
	          ),*/
		
		array('name'=>'fees_quota_id',
			'value'=>'Quota::model()->findByPk($data->fees_quota_id)->quota_name',
			'filter' =>CHtml::listData(Quota::model()->findAll(array('condition'=>'quota_organization_id='.Yii::app()->user->getState('org_id'))),'quota_id','quota_name'),

		),		
		/*'fees_master_created_by',
		'fees_master_created_date',
		'fees_master_tally_id',
		'fees_organization_id',
		'fees_branch_id',
		'fees_academic_term_id',
		'fees_quota_id',
		*/
		array(
			'class'=>'MyCButtonColumn',
			'template' => '{view}{delete}',
	                'buttons'=>array(
                        'Add Fees' => array(
                                'label'=>'Add Fees Details', // text label of the button
//                                'url'=>"CHtml::normalizeUrl(array('feesMasterTransaction/create','id'=>model->fees_master_id))",
				  'url'=>'Yii::app()->createUrl("feesMasterTransaction/create", array("id"=>$data->fees_master_id))',
                                'imageUrl'=> Yii::app()->baseUrl.'/images/add.jpeg',  // image URL of the button. If not set or false, a text link is used
                               'options' => array('class'=>'fees'), // HTML options for the button
                        ),
                ),

		),
	),
	'pager'=>array(
			'class'=>'AjaxList',
			//'maxButtonCount'=>25,
			'maxButtonCount'=>$model->count(),
			'header'=>''
	),

)); ?>
