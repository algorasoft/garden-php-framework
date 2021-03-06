<?php
namespace algorasoft\garden\form;

/**
 *
 * Class TextareaField
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden\form
 */

class TextareaField extends BaseField {

    public function renderInput(): string {
        return sprintf('<textarea name="%s" rows="4" class="form-control %s">%s</textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->model->{$this->attribute}
        );
    }
}