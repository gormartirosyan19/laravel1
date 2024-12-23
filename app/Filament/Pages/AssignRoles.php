<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Filament\Notifications\Notification;

class AssignRoles extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static string $view = 'filament.pages.assign-roles';

    public function assignRole(Request $request, User $user)
    {
        $roleName = $request->input('role');

        if (!$roleName) {
            Notification::make()
                ->title('Error')
                ->body('Role is required.')
                ->danger()
                ->send();

            return redirect()->back();
        }


        if (!is_string($roleName)) {
            Notification::make()
                ->title('Error')
                ->body('Invalid role name.')
                ->danger()
                ->send();

            return redirect()->back();
        }

        $role = Role::findByName($roleName);

        if (!$role) {
            Notification::make()
                ->title('Error')
                ->body('Role not found.')
                ->danger()
                ->send();

            return redirect()->back();
        }

        $user->syncRoles([$roleName]);

        Notification::make()
            ->title('Success')
            ->body('Role updated successfully.')
            ->success()
            ->send();

        return back();
    }
}
