<?php

class Controller {

	public function __construct() {

		$this->view = new View();
	}

	/**
	 * modelLoad, tem como objetivo carregar todos os
	 * arquivos de models.
	 * 
	 * @param string $file Nome do model
	 * @param string $path Local dos models
	 */
	public function modelLoad($file, $modelFolder = 'models/') {
		$folder = 'application/' . $modelFolder . $file . '_Model.php';

		if (file_exists($folder)) {
			require 'application/' . $modelFolder . $file . '_Model.php';

			$modelName = $file . '_Model';
			$this->model = new $modelName();
		}
	}
}