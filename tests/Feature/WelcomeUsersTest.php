<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{

  /** @test */
  function bienvenida_a_usuarios_sin_nik($value='')
  {
    $this->get('saludo/ray/lucas')
      ->AssertStatus(200)
      ->AssertSee('Bienvenido Ray, tu apodo es lucas');
  }
  /** @test */
  function bienvenida_a_usuarios_con_nik($value='')
  {
    $this->get('saludo/ray')
      ->AssertStatus(200)
      ->AssertSee('Bienvenido Ray');
  }
}
