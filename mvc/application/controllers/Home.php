<?php

class Home extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->view->title = 'home';

		$this->view->render('home/index');
	}
}