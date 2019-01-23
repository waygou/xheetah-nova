<?php

namespace Waygou\GamestageNova;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Waygou\GamestageNova\Resources\Game;
use Waygou\GamestageNova\Resources\User;
use Waygou\GamestageNova\Resources\Genre;
use Waygou\GamestageNova\Resources\Company;

class GamestageNova extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources([
            User::class,
            Game::class,
            Genre::class,
            Company::class
        ]);
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        //return view('xheetah-nova::navigation');
    }
}
