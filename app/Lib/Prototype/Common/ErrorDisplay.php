<?php

namespace App\Lib\Prototype\Common;

class ErrorDisplay {

    private static $instance;

    private function __construct() {
        \View::addLocation(app_path() . '/Lib/Prototype/Views');
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function DisplayAll($errors) {
        return \View::make('layouts.elements.displays.all_errors', compact("errors"));
    }

    public function DisplayIndividual($errors, $field) {
        return \View::make('layouts.elements.displays.field_errors', compact("errors", "field"));
    }
}