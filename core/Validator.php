<?php

namespace Core;

use Exception;

class Validator
{

    private $errors;

    /**
     * @throws Exception
     */
    public static function validate($input)
	{
		$result = [];
		$errors = [];
		foreach ($input as $key => $value) {
		    $inputValue = $value[0];
			$targetSanitize = $value[1];
			$sanitizedValue = self::sanitize($inputValue, $targetSanitize);
			if ($sanitizedValue) {
				$result[$key] = $sanitizedValue;
			} else {
                $result[$key] = null;
				$errors[] = ['field' => $key, 'message' => "Erro ao validar entrada para o campo {$key}"];
			}
		}
		return ['result' => $result, 'errors' => $errors];
	}

	public static function sanitize($value, $type)
	{
		switch ($type) {
            case "int":
				return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
			case "bool":
				return (bool) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
			default:
				return (string) filter_var($value, FILTER_SANITIZE_STRING);
		}
	}

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
