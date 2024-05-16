<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testSubmittingBIN()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://stat.gov.kz/ru/juridical/by/bin/')
                    ->type('bin', '000105650462')  // Замените 'input-selector' на фактический селектор для поля ввода BIN.
                    ->press('.form-global-btn')  // Нажатие на кнопку отправки, используя класс кнопки 'form-global-btn'.
                    ->assertSee('Результаты');// Что вы ожидаете увидеть после отправки.
        });
    }
}
