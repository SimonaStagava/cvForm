<?php

class Validation 
{
    private $data;
    private $empty = [];
    private $required = ['name', 'day', 'month', 'year', 'email', 'school[]', 'from[]', 'to[]', 'profession[]', 'lang[]', 'level[]'];

    public function __construct($data = [])
    {
        $this->data = $data;

        foreach ($data as $key => $value) {
            if (empty($value) && in_array($key, $this->required)) {
                $this->empty[] = $key;
            } 
        }
    }

    public function validation()
    {
        return $this->empty;
    }
}

?>