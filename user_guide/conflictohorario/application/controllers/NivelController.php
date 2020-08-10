<?php

class NivelController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Nivel_model', '', TRUE);
	}
	
	public function crear()
	{	
		if($this->validar()) {
			$data = array('niv_descripcion' => $this->input->post('descripcion'));
			$this->Nivel_model->insert($data);
			echo "se ha insertado<br>";
		}
		else
			$data = array('accion'=>'crear');
			print_r($data);
			$this->load->view('nivelform', $data);
	}
	
	public function actualizar($id)
	{	
		echo "id $id<br>";
		if($this->validar()) {
			//$id = $this->input->post('id');
			$data = array('niv_descripcion' => $this->input->post('descripcion'));
			$this->Nivel_model->update($id, $data);
			echo "se ha actualizado<br>";
		}	
		else {
			$datas = $this->Nivel_model->get_x_id($id);
			$accion = array('accion'=>'actualizar');
			foreach($datas as $data) {
				$data = array_merge((array)$data, $accion);
				print_r($data);
				$this->load->view('nivelform', $data);
			}			
		}
	}
	
	public function validar()
	{
		$this->form_validation->set_rules('descripcion', 'descripcion', 'required');
		return $this->form_validation->run();
	}
	   
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Nivel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nivel']))
		{
			$model->attributes=$_POST['Nivel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->niv_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nivel']))
		{
			$model->attributes=$_POST['Nivel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->niv_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Nivel');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Nivel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Nivel']))
			$model->attributes=$_GET['Nivel'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Nivel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nivel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
