<?php

# class for rendering the view in controller
class View
{
    protected $data;

    function render($template) {
        ob_start();
        // you can access $this->data in template
        require "views/" . $template . ".php";
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

	function assign($key, $val) {
        $this->data[$key] = $val;
    }
}