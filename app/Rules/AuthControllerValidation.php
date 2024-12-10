<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AuthControllerValidation implements Rule
{
  protected int $maxLength;
  protected string $message = "パスワードは:max文字以内で入力してください。";

  public function __construct(int $maxLength = 255)
  {
    $this->maxLength = $maxLength;
  }

  public function passes($attribute, $value)
  {
    return is_string($value) && mb_strlen($value) <= $this->maxLength;
  }

  public function message()
  {
    return str_replace(':max', $this->maxLength, $this->message);
  }

  public function setMessage(string $message): self
  {
    $this->message = $message;
    return $this;
  }
}
