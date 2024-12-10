<?php

namespace Tests\Unit\Rules;

use App\Rules\AuthControllerValidation;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\TestCase;

class AuthControllerRuleTest extends TestCase
{
  /**
   * パスワードが255文字以内の場合、バリデーションが通るかテスト
   */
  public function test_password_validationOk()
  {
    $trans = $this->getTranslator();
    $rules = ['password' => new AuthControllerValidation(255)];

    // 255文字のパスワード
    $password = str_repeat('a', 255);
    $this->passes(new Validator($trans, ['password' => $password], $rules));
  }

  /**
   * パスワードが256文字以上の場合、バリデーションにかかるかのテスト
   */
  public function test_password_validationFails()
  {
    $trans = $this->getTranslator();
    $rules = ['password' => new AuthControllerValidation(255)];

    // 256文字のパスワード
    $password = str_repeat('a', 256);
    $this->fails(new Validator($trans, ['password' => $password], $rules));
  }

  /**
   * パスワードのバリデーションメッセージ
   */
  public function test_validation_message()
  {
    $trans = $this->getTranslator();
    $rules = ['password' => (new AuthControllerValidation(255))->setMessage('パスワードは:max文字以内で入力してください。')];

    $validator = new Validator($trans, ['password' => str_repeat('a', 256)], $rules);

    $this->assertSame(
      ['password' => ['パスワードは255文字以内で入力してください。']],
      $validator->messages()->toArray()
    );
  }

  /**
   * IDとパスワードの入力が空の時のバリデーション
   */
  public function test_empty_id_and_password_validationFails()
  {
    $trans = $this->getTranslator();
    $rules = [
      'id' => 'required|string',
      'password' => 'required|string',
    ];

    // カスタムエラーメッセージを指定
    $messages = [
      'id.required' => 'IDを入力してください。',
      'password.required' => 'パスワードを入力してください。',
    ];

    // 入力データ（空のIDとパスワード）
    $data = [
      'id' => '',
      'password' => '',
    ];

    // Validatorインスタンスの作成（カスタムメッセージを含む）
    $validator = new Validator($trans, $data, $rules, $messages);

    // バリデーションエラーの確認
    $this->assertSame(
      [
        'id' => ['IDを入力してください。'],
        'password' => ['パスワードを入力してください。']
      ],
      $validator->messages()->toArray()
    );
  }

  protected function passes($validator)
  {
    $this->assertTrue($validator->passes());
  }

  protected function fails($validator)
  {
    $this->assertFalse($validator->passes());
  }

  protected function getTranslator()
  {
    $loader = new ArrayLoader();

    // 日本語の翻訳メッセージを追加
    $loader->addMessages('ja', 'validation', [
      'required' => ':attributeを入力してください。',
    ]);

    return new Translator($loader, 'ja');
  }
}
