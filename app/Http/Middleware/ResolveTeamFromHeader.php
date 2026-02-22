<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTeamFromHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only apply if authenticated (you will place this middleware after auth:sanctum)
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $teamIdHeader = $request->header('X-Team-ID');

        if ($teamIdHeader === null || !ctype_digit((string) $teamIdHeader)) {
            return response()->json([
                'message' => 'X-Team-ID header is required.',
            ], 400);
        }

        $teamId = (int) $teamIdHeader;

        // Ensure user belongs to this team
        $belongs = $user->teams()->whereKey($teamId)->exists();
        if (!$belongs) {
            return response()->json([
                'message' => 'You do not have access to this team.',
            ], 403);
        }

        $team = Team::query()->findOrFail($teamId);

        // Attach to request for controllers/services
        $request->attributes->set('currentTeam', $team);

        // If Laratrust supports setting team context globally, do it here
        if (class_exists(\Laratrust\LaratrustFacade::class) && method_exists(\Laratrust\LaratrustFacade::class, 'setTeam')) {
            \Laratrust::setTeam($team);
        }

        return $next($request);
    }
}
