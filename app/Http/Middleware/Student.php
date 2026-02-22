<?php

namespace App\Http\Middleware;

use App\Traits\ApiStatusTrait;
use Closure;
use Illuminate\Http\Request;

class Student
{
    use ApiStatusTrait;
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * role 2 instructor
         * role 3 student
         * role 4 organization
         * instructor & student & organization both can access student panel
         */

        if (file_exists(storage_path('installed'))) {
            $user = auth()->user();
            
            if (in_array($user->role, [USER_ROLE_STUDENT, USER_ROLE_INSTRUCTOR, USER_ROLE_ORGANIZATION])) {
                $allowed = false;
                
                // Check based on user role
                if ($user->role == USER_ROLE_STUDENT) {
                    // Students must have an approved student record
                    $allowed = $user->student && $user->student->status == STATUS_APPROVED;
                } elseif ($user->role == USER_ROLE_INSTRUCTOR) {
                    // Instructors must have an approved instructor record
                    $allowed = $user->instructor && $user->instructor->status == STATUS_APPROVED;
                } elseif ($user->role == USER_ROLE_ORGANIZATION) {
                    // Organizations must have an approved organization record
                    $allowed = $user->organization && $user->organization->status == STATUS_APPROVED;
                }
                
                if ($allowed) {
                    return $next($request);
                } else {
                    if ($request->wantsJson()) {
                        $msg = __("Unauthorize route");
                        return $this->error([], $msg, 403);
                    } else {
                        abort('403');
                    }
                }
            } else {
                if ($request->wantsJson()) {
                    $msg = __("Unauthorize route");
                    return $this->error([], $msg, 403);
                } else {
                    abort('403');
                }
            }
        } else {
            if ($request->wantsJson()) {
                $msg = __("Application is not installed");
                return $this->error([], $msg, 404);
            } else {
                return redirect()->to('/install');
            }

        }
    }
}
