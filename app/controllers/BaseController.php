<?php

namespace App\controllers;

class BaseController
{
	
   protected function view($view, $data = []): void
    {
        $filePath = "./views/" . $view . ".php";
		
        if (file_exists($filePath)) {
            extract($data);
            require_once $filePath;
        } else {
            echo "View file does not exist at: " . $filePath;
            die("View does not exist.");
        }
    }
}