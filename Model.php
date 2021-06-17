<?php
namespace app\core;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

/**
 *
 * Class Model
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package app\core
 */

abstract class Model {
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL    = 'email';
    const RULE_MIN      = 'min';
    const RULE_MAX      = 'max';
    const RULE_MATCH    = 'match';
    const RULE_UNIQUE   = 'unique';

    public function loadData($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function labels(): array{
        return [];
    }

    public function getLabel($attribute) {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public array $errors = [];

    public function validate() {
        $emailValidator      = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation(),
        ]);
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if (self::RULE_REQUIRED === $ruleName && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if (self::RULE_EMAIL === $ruleName && $emailValidator->isValid($value, $multipleValidations) == false) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                // OLD
                // if (self::RULE_EMAIL === $ruleName && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                //     $this->addErrorForRule($attribute, self::RULE_EMAIL);
                // }
                if (self::RULE_MIN === $ruleName && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if (self::RULE_MAX === $ruleName && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if (self::RULE_MATCH === $ruleName && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if (self::RULE_UNIQUE === $ruleName) {
                    $className  = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName  = $className::tableName();
                    $stmt       = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $stmt->bindValue(":attr", $value);
                    $stmt->execute();
                    $record = $stmt->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = []) {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message) {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages() {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL    => 'This field must be a valid email address',
            self::RULE_MIN      => 'Min length of this field must be {min}',
            self::RULE_MAX      => 'Max length of this field must be {max}',
            self::RULE_MATCH    => 'This field must be the same as {match}',
            self::RULE_UNIQUE   => 'Record with this {field} already exists',
        ];
    }

    public function hasError($attribute) {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute) {
        return $this->errors[$attribute][0] ?? false;
    }
}