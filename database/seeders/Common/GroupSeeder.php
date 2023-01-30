<?php

namespace RedRockDigital\Api\Database\Seeders\Common;

use Illuminate\Database\Seeder;
use RedRockDigital\Api\Models\Group;
use RedRockDigital\Api\Models\Scope;
use Illuminate\RedRockDigital\DatabaseSeeder;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $groups = collect(config('base.groups'));
        $scopes = collect();

        // Gather a unique list of scopes
        $groups->each(function ($group) use (&$scopes) {
            $scopes = $scopes->concat($group['scopes'])->unique();
        });

        // Check each of the scopes exists, and if not create it.
        $scopes->each(function ($scope) {
            if (!Scope::where('scope', $scope)->exists()) {
                Scope::create([
                    'scope' => $scope,
                    'name'  => Str::title(str_replace('.', ' ', $scope)),
                ]);
            }
        });

        // For each of the groups check they exist and create if not.
        $groups->each(function ($group) {
            $g = Group::firstOrCreate([
                'name' => $group['name'],
                'ref'  => $group['ref'],
            ], []);

            // Run through and check that the group has the correct scopes
            collect($group['scopes'])->each(function ($scope) use ($g) {
                if (!$g->scopes()->where('scope', $scope)->exists()) {
                    $g->scopes()->attach(Scope::where('scope', $scope)->first());
                }
            });
        });
    }
}
