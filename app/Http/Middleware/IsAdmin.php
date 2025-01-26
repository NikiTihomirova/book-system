<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Проверява дали потребителят е администратор.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Проверка дали потребителят е логнат и има администраторски права
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Пренасочване, ако потребителят не е администратор
        return redirect('/')->with('error', 'Нямате права за достъп.');
    }
}
