<?php namespace App\Html;

class FormBuilder extends \Illuminate\Html\FormBuilder
{
    /**
    * Get the check state for a checkbox input.
    *
    * @param string $name
    * @param mixed $value
    * @param bool $checked
    * @return bool
    */
    protected function getCheckboxCheckedState($name, $value, $checked)
    {
        //dd($name);
        //dd($checked);
        if (isset($this->session) && ! $this->oldInputIsEmpty() && is_null($this->old($name))) {
            return false;
        }
        if ($this->missingOldAndModel($name)) {
            return $checked;
        }
        $posted = $this->getValueAttribute($name);
        if ($posted instanceof \Illuminate\Database\Eloquent\Collection) {
            $posted = $this->checkRelationship($posted, $value);
        } elseif (is_string($posted)) {
            $posted = explode(',', $posted);
        }

        return is_array($posted) ? in_array($value, $posted) : (bool) $posted;
    }
    /**
    * Cycle through the Eloquent Collection to see if any relationship models
    * include the given input value as the model ID.
    *
    * @param \Illuminate\Database\Eloquent\Collection $collection
    * @param string $value
    * @return bool
    */
    protected function checkRelationship($collection, $value)
    {
        foreach ($collection as $relation) {
            if ($relation->getKey() == $value) {
                return true;
            }
        }
        return false;
    }
}
