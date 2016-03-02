<?php

class Start {

	private $_url = null;
	private $_controller = null;


	public $controllerPath = 'controllers/';
	public $modelPath = 'models/';

	public $defaultFileIndex = 'home';
	public $defaultFileError = 'error';


	public function __construct() {
		$this->getUrl();

		// Se não for passado nada como controlador
		if (empty($this->_url[0])) {
			// Então chama o controlador padrão
			$this->defaultController();

			// E retorna falso pra evitar problemas
			return false;
		}

		$this->setController();
		$this->setAction();
	}

	public function setControllerPath($file) {
		// controllerPath recebe o arquivo sem barra tanto no final quanto no inicio
		$this->controllerPath = trim($file . '/') . '/';
	}

	public function setModelPath($file) {
		$this->modelPath = trim($file . '/') . '/';
	}

	private function getUrl() {
		// Se existir o $_GET['url'] então vai ser o que for 
		// passado na url $_GET['url'] se não retorna nulo
		$url = isset($_GET['url']) ? $_GET['url'] : null;

		// "Limpa" a ultima barra do final
		$url = rtrim($url, '/');

		// Filtra a váriavel
		$url = filter_var($url, FILTER_SANITIZE_URL);
		
		// Explode na / (LAST)
		$this->_url = explode('/', $url);

		//print_r($this->_url);
	}

	private function defaultController() {
		// Define o caminho do controlador padrão
		require 'application/' . $this->controllerPath . $this->defaultFileIndex . '.php';
		// Instância o controlador padrão
		$this->_controller = new Home;
		// Chama o método index do indexController.php
		$this->_controller->index();
	}

	private function setController() {
		// Define o caminho para o arquivo
		$file_folder = 'application/' . $this->controllerPath . $this->_url[0] . '.php';

		// Verifica se o arquivo existe
		if (file_exists($file_folder)) {
			// Requer o arquivo
			require_once $file_folder;
			// Instância o controlador passado na url
			$this->_controller = new $this->_url[0];

			// Faz a chamada do modelLoad, passa como controlador e chama o "models/ pasta"
			$this->_controller->modelLoad($this->_url[0], $this->modelPath);
		} else {
			// Caso não exista chama o método de erro
			$this->error();
			return false;
		}
	}

	private function setAction() {
		$length = count($this->_url);

		// Certifique-se o método que estamos chamando existe
		if ($length > 1) {
			// Se o método que estamos chamando, não existir,
			// então chama o controlador de erros (errorController.php)
			if (!method_exists($this->_controller, $this->_url[1])) {
				$this->error();
			}
		}

		// Determina o que vai ser carregado

		switch ($length) {
			case 5:
				//Controlador->Método(Param1, Param2, Param3, Param4)
				$this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
				break;

			case 4:
				//Controlador->Método(Param1, Param2)
				$this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
				break;

			case 3:
				//Controlador->Método(Param1, Param2)
				$this->_controller->{$this->_url[1]}($this->_url[2]);
				break;

			case 2:
				//Controlador->Método(Param1)
				$this->_controller->{$this->_url[1]}();
				break;

			default:
				// Padrão
				$this->_controller->index();
				break;
		}
	}

	private function error() {
		// Requer o arquivo
		require 'application/' . $this->controllerPath . $this->defaultFileError . '.php';

		// Instância error
		$this->_controller = new Error;

		// chama o método index do controlador de errorController.php
		$this->_controller->index();

		// Da um exit
		exit();
	}

}