<?php

namespace App\Src\UniversityDomain\Instructor\Request;

use App\Src\UserDomain\Role\Service\RoleChecker;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class SearchInstructorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function searchDesactive(): bool
    {
        return (bool) $this->desactive;
    }

    public function searchTeachingAssistant(): bool
    {

        if (! $this->filled('role_id')) {
            return false;
        }

        $checkerRole = app(RoleChecker::class);

        $role = Role::find($this->role_id);

        return $checkerRole->isTeachingAssistant($role);
    }
}
