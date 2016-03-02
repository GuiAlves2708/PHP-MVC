<?php

class Val 
{
    public function __construct()
    {
        
    }

    public function required($data) {
        if (empty($data)) {
            return "é obrigatório.";
        }
    }
    
    public function minlength($data, $arg)
    {
        if (strlen($data) < $arg) {
            return "Mínimo de caracteres deve conter $arg.";
        }
    }
    
    public function maxlength($data, $arg)
    {
        if (strlen($data) > $arg) {
            return "Máximo de caracteres deve conter $arg.";
        }
    }

    public function digit($data)
    {
        if (ctype_digit($data) == false) {
            return "Sua seqüência deve ser um dígito.";
        }
    }
    
    public function __call($name, $arguments) 
    {
        throw new Exception("$name não existe dentro de: " . __CLASS__);
    }
    
}