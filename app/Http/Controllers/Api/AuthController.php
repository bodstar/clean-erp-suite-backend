<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Revoke old tokens (optional but recommended for security)
        // If you want multi-device tokens, remove this line.
        $user->tokens()->delete();

        $token = $user->createToken('clean-web')->plainTextToken;

        // Load teams user belongs to.
        // Assumes User has teams() relationship.
        $teams = $user->teams()->select('id', 'name')->get();

        if ($teams->isEmpty()) {
            // No tenant/team membership — block login.
            return response()->json([
                'message' => 'User has no team/tenant membership.',
            ], 403);
        }

        // Determine current team (tenant context)
        $currentTeamId = $this->resolveCurrentTeamIdFromHeaderOrDefault($request, $teams);

        $currentTeam = $teams->firstWhere('id', $currentTeamId) ?? $teams->first();
        $permissions = $this->getPermissionNamesForTeam($user, $currentTeam);

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
            'teams' => $teams->values(),
            'current_team_id' => $currentTeam->id,
            'permissions' => $permissions,
        ]);
    }

    /**
     * GET /api/auth/me
     * Headers: Authorization: Bearer <token>
     */
    public function me(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $teams = $user->teams()->select('id', 'name')->get();

        if ($teams->isEmpty()) {
            return response()->json([
                'message' => 'User has no team/tenant membership.',
            ], 403);
        }

        $currentTeamId = $this->resolveCurrentTeamIdFromHeaderOrDefault($request, $teams);
        $currentTeam = $teams->firstWhere('id', $currentTeamId) ?? $teams->first();

        $permissions = $this->getPermissionNamesForTeam($user, $currentTeam);

        return response()->json([
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
            'teams' => $teams->values(),
            'current_team_id' => $currentTeam->id,
            'permissions' => $permissions,
        ]);
    }

    /**
     * POST /api/auth/switch-team
     * Headers: Authorization: Bearer <token>
     * Body: { team_id: number }
     */
    public function switchTeam(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'team_id' => ['required', 'integer', 'exists:teams,id'],
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        $teamId = (int) $validated['team_id'];

        // Ensure user belongs to this team
        $belongs = $user->teams()->where('teams.id', $teamId)->exists();
        if (!$belongs) {
            return response()->json([
                'message' => 'You do not have access to the selected team.',
            ], 403);
        }

        $team = Team::query()->select('id', 'name')->findOrFail($teamId);
        $permissions = $this->getPermissionNamesForTeam($user, $team);

        return response()->json([
            'current_team_id' => $team->id,
            'permissions'     => $permissions,
        ]);
    }

    /**
     * Optional: POST /api/auth/logout
     * Revokes current token.
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Delete only the current token
        $user->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out.']);
    }

    /**
     * Choose current team:
     * - Prefer X-Team-ID header if it matches user's teams
     * - Otherwise default to first team
     */
    private function resolveCurrentTeamIdFromHeaderOrDefault(Request $request, $teams): int
    {
        $headerTeamId = $request->header('X-Team-ID');
        if ($headerTeamId !== null && ctype_digit((string) $headerTeamId)) {
            $headerTeamId = (int) $headerTeamId;
            if ($teams->contains('id', $headerTeamId)) {
                return $headerTeamId;
            }
        }

        return (int) $teams->first()->id;
    }

    /**
     * Get permission names for user within a team (Laratrust Teams).
     *
     * Laratrust provides allPermissions() / permissions methods; with teams enabled,
     * most setups support passing the team context. If your Laratrust version differs,
     * update this one function and everything else stays stable.
     */
    private function getPermissionNamesForTeam($user, Team $team): array
    {
        // Try common Laratrust patterns safely.
        try {
            // Many Laratrust versions support: $user->allPermissions($team)
            $perms = $user->allPermissions($team);
            return $perms->pluck('name')->values()->all();
        } catch (\Throwable $e) {
            // Fallback: if your version uses setTeam() on the Laratrust facade
            try {
                if (class_exists(\Laratrust\LaratrustFacade::class) && method_exists(\Laratrust\LaratrustFacade::class, 'setTeam')) {
                    \Laratrust::setTeam($team);
                }
                $perms = $user->allPermissions();
                return $perms->pluck('name')->values()->all();
            } catch (\Throwable $e2) {
                // Last resort: return empty; you can fix this once you confirm Laratrust API.
                return [];
            }
        }
    }
}
