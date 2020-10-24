<?php
namespace App\HTML;

use App\Model\Category;
use App\Model\Post;

class Form {

    private $post;
    private $errors;

    public function __construct( $data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label)
    {
        $value = $this->getValue($key);
        $inputClass = $this->getInputClass($key);
        $invalidFeedback = $this->getInvalidFeedback($key);
        $type = $key === 'password' ? 'password' : "text";

        return <<<HTML
        <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <input type="{$type}" id="field{$key}" name="{$key}" class="{$inputClass}" value= "{$value}"/>
            {$invalidFeedback}
        </div>
HTML;
    }
    public function select(string $key, string $label, array $options = []): string
    {
        $categoryOption = [];
        $value = $this->getValue($key);

        foreach($options as $k => $v){
            $selected = in_array($k, $value) ? " selected" : "";
            $categoryOption[] = "<option value=\"$k\" {$selected} >$v</option>";
        }
        $inputClass = $this->getInputClass($key);
        $invalidFeedback = $this->getInvalidFeedback($key);
        $categoryOption = implode('', $categoryOption);
        return <<<HTML
        <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <select type="text" id="field{$key}" class="{$inputClass}" name="{$key}[]" required multiple> {$categoryOption} </select>
        </div>
        {$invalidFeedback} 
HTML;
    }

    public function textarea(string $key, string $label)
    {
        $value = $this->getValue($key);
        $inputClass = $this->getInputClass($key);
        $invalidFeedback = $this->getInvalidFeedback($key);
        return <<<HTML
        <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <textarea id="field{$key}" name="{$key}" type="text" class="{$inputClass}">{$value}</textarea>
        </div>
HTML;
    }

    private function getValue(string $key)
    {
        if(is_array($this->data)){
            return $this->data[$key] ?? null;
        }
        $method = 'get' . str_replace(' ', '', ucfirst(str_replace('_', '', $key)));
        $value = $this->data->$method();
        if($value instanceof \DateTimeInterface){
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    private function getInputClass(string $key)
    {
        $inputClass = 'form-control';
        if(isset($this->errors[$key])){
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    private function getInvalidFeedback(string $key)
    {
        $invalidFeedback = '';
        if(isset($this->errors[$key])){
            if(is_array($this->errors[$key])){
                $error = implode('<br>', $this->errors[$key]);
            }
            else {
                $error = $this->errors[$key];
            }
            return $invalidFeedback = '<div class="invalid-feedback">' . $error . '</div>';
        }

        return '';
    }

}