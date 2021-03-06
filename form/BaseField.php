<?php
namespace algorasoft\garden\form;

use algorasoft\garden\Model;

/**
 *
 * Class BaseField
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden\form
 */

abstract class BaseField {

    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute) {
        $this->model     = $model;
        $this->attribute = $attribute;
    }

    abstract public function renderInput(): string;

    public function __toString() {
        return sprintf('
           <div class="form-group mb-3">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}