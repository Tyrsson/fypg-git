<?php
class Page_CommentController extends System_Controller_Action
{
	public $context = array('ajaxpagename' => array('json'));
	public function init()
	{
		parent::init();
		$this->_helper->contextSwitch()->initContext();
	}
	public function postAction()
	{
		$form = new Page_Form_Comment();
		$this->view->form = $form;
	}
	public function processAction()
	{

	}
	public function viewAction()
	{

	}
	public function ajaxpagenameAction()
	{
		$this->_helper->layout->disableLayout();
		$this->getHelper('viewRenderer')->setNoRender(true);
		$pages = new Page_Model_Page();
		$names = $pages->fetchPageNames();

		foreach($names->toArray() as $n)
		{
			foreach($n as $name)
			{
			$entries[] = array('name' => $name);
			}
		}

		$data = new Zend_Dojo_Data('name', $entries);
		echo $data->toJson();
	}
}