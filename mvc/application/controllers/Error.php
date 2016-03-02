<?php

class Error extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->view->title = 'error';

		$this->view->render('error/index');
	}
}