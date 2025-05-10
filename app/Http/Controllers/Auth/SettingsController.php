<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    /**
     * Mostrar página de perfil
     */
    public function profile(): Response
    {
        return Inertia::render('settings/Profile');
    }
    
    /**
     * Mostrar página de contraseña
     */
    public function password(): Response
    {
        return Inertia::render('settings/Password');
    }
    
    /**
     * Mostrar página de apariencia
     */
    public function appearance(): Response
    {
        return Inertia::render('settings/Appearance');
    }
} 