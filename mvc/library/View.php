<?php

class View {

	public function __construct() {

	}

	public function render($file) {

		$path = 'application/views/' . $file . '.php';
		if (file_exists($path)) {

			require_once $path;

		} else {
			die('File not found: ' . $path);
		}
	}
}