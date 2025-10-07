@extends('layout.app')
@section('title', 'Group Management')

@section('content')
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-xl font-semibold text-slate-700">User Groups List</h2>
            <button onclick="openAddModal()" style="background-color: #4C8C86;"
               class="inline-flex items-center gap-2 px-4 py-2 text-white font-semibold rounded-lg shadow-md hover:opacity-90 transition-opacity">
                + Add New Group
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-100">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Group Name</th>
                        <th class="px-6 py-3">Total Users</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $index => $group)
                    <tr class="bg-white border-b hover:bg-slate-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $group->name }}</td>
                        <td class="px-6 py-4">{{ $group->users->count() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-4">
                                <button 
                                    onclick='openEditModal(
                                        "{{ $group->id }}",
                                        "{{ $group->name }}",
                                        @json($group->users->pluck("id"))
                                    )' 
                                    class="text-amber-600 hover:text-amber-800">✏️
                                </button>
                                <button onclick="openDeleteModal('{{ $group->id }}','{{ $group->name }}')" class="text-red-600 hover:text-red-800">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD GROUP MODAL -->
<div id="add-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold mb-4">Add New Group</h3>
        <form action="{{ route('groups.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Group Name" class="w-full border rounded p-2 mb-4" required>
            
            <label class="font-medium mb-2 block">Assign Users</label>
            <div class="max-h-64 overflow-y-auto border rounded p-2 mb-4">
                @foreach ($users as $user)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="users[]" value="{{ $user->id }}" id="add-user-{{ $user->id }}">
                        <label for="add-user-{{ $user->id }}" class="ml-2">{{ $user->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" style="background-color:#4C8C86;" class="px-4 py-2 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT GROUP MODAL -->
<div id="edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold mb-4">Edit Group</h3>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <input id="edit-group-name" name="name" type="text" placeholder="Group Name" class="w-full border rounded p-2 mb-4" required>

            <label class="font-medium mb-2 block">Assign Users</label>
            <div id="edit-users-container" class="max-h-64 overflow-y-auto border rounded p-2 mb-4">
                @foreach ($users as $user)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="users[]" value="{{ $user->id }}" id="edit-user-{{ $user->id }}">
                        <label for="edit-user-{{ $user->id }}" class="ml-2">{{ $user->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" style="background-color:#4C8C86;" class="px-4 py-2 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE GROUP MODAL -->
<div id="delete-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4">Delete Group</h3>
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            <p class="mb-4">Are you sure you want to delete "<span id="delete-group-name"></span>"?</p>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" style="background-color:#d32f2f;" class="px-4 py-2 text-white rounded">Delete</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add Modal
    function openAddModal() {
        document.getElementById('add-modal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('add-modal').classList.add('hidden');
    }

    // Edit Modal
    function openEditModal(id, name, userIds) {
    document.getElementById('edit-group-name').value = name;
    document.getElementById('edit-form').action = '/groups/' + id;

    const container = document.getElementById('edit-users-container');
    const checkboxes = container.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.checked = userIds.includes(parseInt(checkbox.value));
    });

    document.getElementById('edit-modal').classList.remove('hidden');
}
    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }

    // Delete Modal
    function openDeleteModal(id, name) {
        document.getElementById('delete-group-name').innerText = name;
        document.getElementById('delete-form').action = '/groups/' + id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>
@endpush
