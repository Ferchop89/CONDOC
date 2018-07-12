<?php

namespace Tests\Feature\Administrador;

use App\Models\User;
use App\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admins_can_visit_the_admin_dashboard(){
        $admin = factory(User::class)->create([
        ]);
        $role =new Role();
        $role->nombre = 'Admin';
        $role->descripcion = 'Administrador';
        $role->save();
        $admin->roles()->attach($role->id);
        $this->actingAs($admin)
            ->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Admin Panel');
    }

    /** @test */
    function non_admin_users_cannot_visit_the_admin_dashboard(){
        $user = factory(User::class)->create([
        ]);
        $role = new Role();
        $role->nombre = 'Invit';
        $role->descripcion = 'Invitado';
        $role->save();
        $user->roles()->attach($role->id);
        $this->actingAs($user)
            ->get(route('admin_dashboard'))
            ->assertStatus(403);
    }

    /** @test */
    function guest_cannot_visit_the_admin_dashboard(){
        $this->get(route('admin_dashboard'))
            ->assertStatus(302)
            ->assertRedirect('login');

    }
}
