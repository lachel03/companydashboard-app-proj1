<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $userSubmoduleIds = $user->submodules->pluck('id')->toArray();

        $systems = System::with(['modules.submodules' => function ($query) use ($userSubmoduleIds) {
            $query->whereIn('id', $userSubmoduleIds);
        }])
        ->get()
        ->map(function ($system) {
            $modules = $system->modules->filter(function ($module) {
                return $module->submodules->isNotEmpty();
            })->map(function ($module) {
                return [
                    'module_id' => $module->id,
                    'module_name' => $module->name,
                    'module_code' => $module->code,
                    'module_icon' => $module->icon,
                    'submodules' => $module->submodules->map(function ($submodule) {
                        return [
                            'id' => $submodule->id,
                            'name' => $submodule->name,
                            'code' => $submodule->code,
                            'route' => $submodule->route,
                        ];
                    })->values(),
                ];
            })->values();

            return [
                'system_id' => $system->id,
                'system_name' => $system->name,
                'system_code' => $system->code,
                'modules' => $modules,
            ];
        })
        ->filter(function ($system) {
            return $system['modules']->isNotEmpty();
        })
        ->values();

        return response()->json($systems, 200);
    }
}