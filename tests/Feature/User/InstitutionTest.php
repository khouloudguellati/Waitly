<?php

test('guest cannot view institutions list', function () {
    $this->get(route('user.institutions.index'))
        ->assertRedirect(route('login'));
});

test('user can browse active institutions', function () {
    institution(['name' => 'Mairie Active',    'is_active' => true]);
    institution(['name' => 'Institution Inactive', 'is_active' => false]);

    $this->actingAs(regularUser())
        ->get(route('user.institutions.index'))
        ->assertOk()
        ->assertSee('Mairie Active')
        ->assertDontSee('Institution Inactive');
});

test('user can view institution details', function () {
    $inst = institution(['name' => 'Centre de Santé']);
    service($inst, ['name' => 'Consultation Générale', 'is_active' => true]);

    $this->actingAs(regularUser())
        ->get(route('user.institutions.show', $inst))
        ->assertOk()
        ->assertSee('Centre de Santé')
        ->assertSee('Consultation Générale');
});
