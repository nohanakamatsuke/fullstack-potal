<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  /**
   * The current password being used by the factory.
   */
  protected static ?string $password;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => fake()->name(),
      'user_id' => $this->generateRandomUserId(),
      'email' => fake()->unique()->safeEmail(),
      'phone_number' => fake()->phoneNumber(),
      // 'email_verified_at' => now(),
      // 'password' => static::$password ??= Hash::make('password'),
      'password' => 'password',
      'role_id' => '1',
      // 'remember_token' => Str::random(10),
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   */
  public function unverified(): static
  {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }

  private function generateRandomUserId(): string
  {
    $randomNumber = sprintf('%04d', mt_rand(0, 9999)); // 4桁のランダムな数字を生成

    return "_{$randomNumber}"; // ランダムな数字を文字列として返す
  }

  //パスワードをカスタマイズして、生成できる。デフォルトはpassword
  public function withPassword(string $password): static
  {
    return $this->state(fn(array $attributes) => [
      'password' => $password,
    ]);
  }
}
