<?php

class InitList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('View/list_init.html');
    }

    public function show()
    {
        echo $this->html;
    }
}
