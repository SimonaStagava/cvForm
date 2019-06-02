<?php

class Options
{
    public $month = ['janvāris', 'februāris', 'marts', 'aprīlis', 'maijs', 'jūnijs', 'jūlijs', 'augusts', 'septembris', 'oktobris', 
                    'novembris', 'decembris'];

    public $level = ['pamatzināšanas', 'vidēji', 'labi', 'teicami', 'dzimtā valoda'];

    public function addMonth()
    {
        foreach ($this->month as $value) {
            echo "<option value=\"$value\">$value</option>";
        }
    }

    public function addLevel()
    {
        foreach ($this->level as $value) {
            echo "<option value=\"$value\">$value</option>";
        }
    }

    public function addYear()
    {
        for ($i = 2019; $i >= 1919; $i--) {
            echo "<option value=\"$i\">$i</option>";
        }
    }

    public function addDay() 
    {
        for ($i = 1; $i <= 31; $i++) {
            echo "<option value=\"$i\">$i</option>";
        }
    }
}
