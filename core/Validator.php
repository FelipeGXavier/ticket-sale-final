<?php

namespace Core;

class Validator
{

	public static function validate($input, $schema)
	{
		if (is_null($schema) || empty($schema)) throw new \Exception("Invalid schema validation");
		$errors = [];
		$result = [];
		foreach ($input as $key => $value) {
			$targetSanitize = $schema[$key];
			$sanitizedValue = self::sanitize($value, $targetSanitize);
			if ($sanitizedValue) {
				$result[$key] = $sanitizedValue;
			} else {
				$errors[] = ['field' => $key, 'message' => "Erro ao validar entrada para o campo {$key}"];
			}
		}
		if (!empty($errors)) return $errors;
		return $result;
	}

	private static function sanitize($value, $type)
	{
		switch ($type) {
			case "string":
				return (string) filter_var($value, FILTER_SANITIZE_STRING);
				break;
			case "int":
				return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
				break;
			case "bool":
				return (bool) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
				break;
			default:
				return (string) filter_var($value, FILTER_SANITIZE_STRING);
		}
	}
}
