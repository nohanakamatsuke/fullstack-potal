<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \Route;
use App\User;

class RouteAndViewIsTest extends TestCase
{
  /**
   * 指定したルートのステータスコードを確認するテスト
   */
  public function test_route_status()
  {
    $response = $this->get('/login');
    $response->assertStatus(200)
      ->assertViewIs('login');
  }
}
