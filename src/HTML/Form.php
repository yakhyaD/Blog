<?php
namespace App\HTML;

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


        return <<<HTML
        <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <input type="text" id="field{$key}" name="{$key}" class="{$inputClass}" value= "{$value}"/>
            {$invalidFeedback}
        </div>
HTML;
    }

    public function textarea(string $key, string $label)
    {
        $value = $this->getValue($key);
        return <<<HTML
        <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <textarea id="field{$key}" name="{$key}" type="text" class="form-control ">{$value}</textarea>
        </div>
HTML;
    }

    private function getValue(string $key): ?string
    {
        if(is_array($this->data)){
            return $this->data[$key] ?? null;
        }
        $method = 'get' . ucfirst($key);
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
            $invalidFeedback = '<div class="invalid-feedback">' . implode('<br>', $this->errors[$key]) . '</div>';
        }

        return $invalidFeedback;
    }

}