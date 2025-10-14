@extends('layout.app')
@section('title', 'Group Management')

@push('styles')
<style>
    /* Google Font for a modern look */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc; /* Lighter gray background */
    }

    /* Custom Color Palette */
    :root {
        --color-custom-teal: #4C8C86;
        --color-custom-teal-dark: #3D6F6A;
        --color-custom-teal-light: #eef7f6;
    }

    .bg-custom-teal { background-color: var(--color-custom-teal); }
    .hover\:bg-custom-teal-dark:hover { background-color: var(--color-custom-teal-dark); }
    .bg-custom-teal-light { background-color: var(--color-custom-teal-light); }
    .text-custom-teal { color: var(--color-custom-teal); }
    .border-custom-teal { border-color: var(--color-custom-teal); }
    .ring-custom-teal:focus { 
        --tw-ring-opacity: 1;
        --tw-ring-color: var(--color-custom-teal);
    }
    
    /* Modal Transition */
    .modal-transition {
        transition: opacity 0.3s ease-in-out;
    }

    /* Custom Scrollbar for User List */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #aaa; }
</style>
@endpush

@section('content')
<div class="space-y-6 md:space-y-8">

    {{-- Konten Utama --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200/80">
        <div class="p-4 sm:p-6 md:p-8">
            {{-- Header Konten --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-6 border-b border-slate-200">
                <div class="flex items-center gap-3">
                     <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-custom-teal-light rounded-full">
                        <svg xmlns="http://www.w.org/2000/svg" class="h-6 w-6 text-custom-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">User Groups List</h2>
                </div>
                <button onclick="openAddModal()" class="w-full sm:w-auto bg-custom-teal hover:bg-custom-teal-dark transition-all duration-300 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Add New Group</span>
                </button>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-100/80">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 rounded-l-lg hidden sm:table-cell">#</th>
                            <th class="px-4 sm:px-6 py-4 rounded-l-lg sm:rounded-l-none">Group Name</th>
                            <th class="px-4 sm:px-6 py-4 text-center">Total Users</th>
                            <th class="px-4 sm:px-6 py-4 text-center rounded-r-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($groups as $index => $group)
                        <tr class="bg-white border-b last:border-b-0 hover:bg-custom-teal-light/30 transition-colors duration-200">
                            <td class="px-4 sm:px-6 py-4 font-semibold text-slate-500 hidden sm:table-cell">{{ $loop->iteration }}</td>
                            <td class="px-4 sm:px-6 py-4 font-semibold text-slate-900">{{ $group->name }}</td>
                            <td class="px-4 sm:px-6 py-4 text-center">
                                <span class="bg-slate-200 text-slate-800 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">{{ $group->users->count() }} Users</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center justify-center gap-4">
                                    <button onclick='openEditModal("{{ $group->id }}", "{{ $group->name }}", @json($group->users->pluck("id")))' class="group relative text-yellow-500 hover:text-yellow-700 transition-colors">
                                        <svg xmlns="http://www.w.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                        <span class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-max px-2 py-1 bg-slate-800 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Edit</span>
                                    </button>
                                    <button onclick="openDeleteModal('{{ $group->id }}','{{ $group->name }}')" class="group relative text-red-500 hover:text-red-700 transition-colors">
                                        <svg xmlns="http://www.w.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                        <span class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-max px-2 py-1 bg-slate-800 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="text-center py-16 px-6">
                                    <svg xmlns="http://www.w.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    <p class="font-semibold text-slate-600 mt-3">No groups found</p>
                                    <p class="text-sm text-slate-500 mt-1">Get started by adding a new group.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODALS SECTION --}}

<div id="add-modal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4 pointer-events-none opacity-0 modal-transition">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col transform transition-transform duration-300 scale-95">
        <div class="p-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Add New Group</h3>
        </div>
        <form id="add-form" action="{{ route('groups.store') }}" method="POST" class="flex-grow overflow-y-auto">
            @csrf
            <div class="p-6 space-y-5">
                <div>
                    <label for="add-group-name" class="block text-sm font-semibold text-slate-700 mb-1">Group Name</label>
                    <input id="add-group-name" type="text" name="name" placeholder="e.g., Marketing Team" class="w-full border-slate-300 rounded-lg focus:ring-custom-teal focus:border-custom-teal" required>
                </div>
                <div>
                    <label for="add-user-search" class="block text-sm font-semibold text-slate-700 mb-2">Assign Users</label>
                    <input id="add-user-search" type="text" placeholder="Search for users..." class="w-full border-slate-300 rounded-lg focus:ring-custom-teal focus:border-custom-teal mb-2">
                    <div id="add-users-container" class="max-h-60 overflow-y-auto border border-slate-200 rounded-lg p-3 space-y-2 custom-scrollbar">
                        @foreach ($users as $user)
                        <div class="user-item flex items-center">
                            <input type="checkbox" name="users[]" value="{{ $user->id }}" id="add-user-{{ $user->id }}" class="h-4 w-4 rounded border-slate-300 text-custom-teal focus:ring-custom-teal">
                            <label for="add-user-{{ $user->id }}" class="ml-3 block text-sm text-slate-600">{{ $user->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row-reverse justify-start gap-3 p-5 bg-slate-50 border-t border-slate-200 rounded-b-2xl">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-custom-teal text-sm font-semibold text-white rounded-lg hover:bg-custom-teal-dark">Save Group</button>
                <button type="button" onclick="closeAddModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-300 text-sm font-semibold text-slate-700 rounded-lg hover:bg-slate-100">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4 pointer-events-none opacity-0 modal-transition">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col transform transition-transform duration-300 scale-95">
        <div class="p-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Edit Group</h3>
        </div>
        <form id="edit-form" method="POST" class="flex-grow overflow-y-auto">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-5">
                <div>
                    <label for="edit-group-name" class="block text-sm font-semibold text-slate-700 mb-1">Group Name</label>
                    <input id="edit-group-name" name="name" type="text" class="w-full border-slate-300 rounded-lg focus:ring-custom-teal focus:border-custom-teal" required>
                </div>
                <div>
                    <label for="edit-user-search" class="block text-sm font-semibold text-slate-700 mb-2">Assign Users</label>
                     <input id="edit-user-search" type="text" placeholder="Search for users..." class="w-full border-slate-300 rounded-lg focus:ring-custom-teal focus:border-custom-teal mb-2">
                    <div id="edit-users-container" class="max-h-60 overflow-y-auto border border-slate-200 rounded-lg p-3 space-y-2 custom-scrollbar">
                        @foreach ($users as $user)
                        <div class="user-item flex items-center">
                            <input type="checkbox" name="users[]" value="{{ $user->id }}" id="edit-user-{{ $user->id }}" class="h-4 w-4 rounded border-slate-300 text-custom-teal focus:ring-custom-teal">
                            <label for="edit-user-{{ $user->id }}" class="ml-3 block text-sm text-slate-600">{{ $user->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row-reverse justify-start gap-3 p-5 bg-slate-50 border-t border-slate-200 rounded-b-2xl">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-custom-teal text-sm font-semibold text-white rounded-lg hover:bg-custom-teal-dark">Update Group</button>
                <button type="button" onclick="closeEditModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-300 text-sm font-semibold text-slate-700 rounded-lg hover:bg-slate-100">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4 pointer-events-none opacity-0 modal-transition">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-transform duration-300 scale-95">
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            <div class="p-6 sm:p-8 text-center">
                 <div class="w-16 h-16 bg-red-100 rounded-full mx-auto flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                 </div>
                <h3 class="text-lg font-bold text-slate-800">Delete Group</h3>
                <p class="text-sm text-slate-500 mt-2">Are you sure you want to delete the group "<strong id="delete-group-name" class="text-slate-800"></strong>"? This action cannot be undone.</p>
            </div>
            <div class="flex flex-col sm:flex-row-reverse justify-start gap-3 p-5 bg-slate-50 rounded-b-2xl">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-red-600 text-sm font-semibold text-white rounded-lg hover:bg-red-700">Yes, Delete</button>
                <button type="button" onclick="closeDeleteModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-300 text-sm font-semibold text-slate-700 rounded-lg hover:bg-slate-100">Cancel</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // General Modal Logic
    const modals = ['add-modal', 'edit-modal', 'delete-modal'];
    modals.forEach(id => {
        const modal = document.getElementById(id);
        modal.addEventListener('click', (e) => {
            if (e.target.id === id) { // Click on backdrop
                closeModal(id);
            }
        });
    });

    function openModal(id) {
        const modal = document.getElementById(id);
        const content = modal.querySelector('.transform');
        modal.classList.remove('pointer-events-none', 'opacity-0');
        setTimeout(() => content.classList.remove('scale-95'), 50); // Animate in
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const content = modal.querySelector('.transform');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('pointer-events-none', 'opacity-0'), 200); // Animate out
        document.body.classList.remove('overflow-hidden');
    }

    // Add Modal
    function openAddModal() {
        const form = document.getElementById('add-form');
        form.reset();
        const searchInput = document.getElementById('add-user-search');
        if (searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }
        openModal('add-modal');
    }
    function closeAddModal() { closeModal('add-modal'); }

    // Edit Modal
    function openEditModal(id, name, userIds) {
        const form = document.getElementById('edit-form');
        form.action = `/groups/${id}`;
        document.getElementById('edit-group-name').value = name;
        
        const searchInput = document.getElementById('edit-user-search');
        if (searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }
        
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = userIds.includes(parseInt(checkbox.value));
        });

        openModal('edit-modal');
    }
    function closeEditModal() { closeModal('edit-modal'); }

    // Delete Modal
    function openDeleteModal(id, name) {
        document.getElementById('delete-form').action = `/groups/${id}`;
        document.getElementById('delete-group-name').innerText = name;
        openModal('delete-modal');
    }
    function closeDeleteModal() { closeModal('delete-modal'); }

    // User Search Filter Logic
    function setupUserSearch(inputId, containerId) {
        const searchInput = document.getElementById(inputId);
        const usersContainer = document.getElementById(containerId);
        const userItems = usersContainer.querySelectorAll('.user-item');

        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            userItems.forEach(item => {
                const userName = item.querySelector('label').textContent.toLowerCase();
                if (userName.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Initialize searches for both modals
    document.addEventListener('DOMContentLoaded', () => {
        setupUserSearch('add-user-search', 'add-users-container');
        setupUserSearch('edit-user-search', 'edit-users-container');
    });
</script>
@endpush