<?php

namespace Tests\Feature\Administrador;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HideAdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_does_not_allow_guests_to_discover_admin_urls(){
        $this->get('admin/invalid-url')
            ->assertStatus(302)
            ->assertRedirect('login');
    }

    /** @test */
    function id_does_not_allow_guests_to_discover_admin_urls_using_post(){
        $this->post('admin/invalid-url')
            ->assertStatus(302)
            ->assertRedirect('login');
    }

    /** @test */
    function it_displays_404s_when_admins_visit_invalid_urls(){
        $admin = factory(User::class)->create([
        ]);
        $role =new Role();
        $role->nombre = 'Admin';
        $role->descripcion = 'Administrador';
        $role->save();
        $admin->roles()->attach($role->id);
        $this->actingAs($admin)
            ->get('admin/invalid-url')
            ->assertStatus(404);
            //->assertRedirect('login');
    }
}
