<x-filament::page>
    <table class="w-full text-left border-collapse">
        <thead>
        <tr>
            <th class="border-b py-2">User</th>
            <th class="border-b py-2">Email</th>
            <th class="border-b py-2">Roles</th>
            <th class="border-b py-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach (\App\Models\User::all() as $user)
            <tr>
                <td class="py-2">{{ $user->name }}</td>
                <td class="py-2">{{ $user->email }}</td>
                <td class="py-2">{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                <td class="py-2">
                    <form method="POST" action="{{ route('assign.roles', $user) }}">
                        @csrf
                        <select name="role"  class="border rounded px-2 py-1">
                            @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->name }}"
                                        @if(in_array($role->name, $user->getRoleNames()->toArray())) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 shadow">Edit</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-filament::page>