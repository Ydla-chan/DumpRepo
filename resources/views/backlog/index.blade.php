{{-- @extends('layout.app')

@section('content')

@endsection --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Backlog</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for better typography and table control */
        :root {
            font-family: 'Inter', sans-serif;
        }
        .progress-bar-container {
            width: 100%;
            background-color: #e5e7eb;
            border-radius: 9999px;
            overflow: hidden;
            height: 8px;
        }
        .progress-bar {
            height: 100%;
            transition: width 0.3s ease-in-out;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#4f46e5',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 p-4 sm:p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 md:p-10 rounded-xl shadow-2xl">
        <h3 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Daftar Backlog</h3>

        <!-- Filter Form -->
        <form id="filter-form" class="flex flex-col sm:flex-row gap-4 mb-8 p-4 bg-indigo-50 rounded-lg shadow-inner">
            <select id="rapat_id" name="rapat_id" class="p-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary flex-grow text-gray-700">
                <option value="">Filter Rapat</option>
                <!-- Options will be populated by JS -->
            </select>

            <select id="status" name="status" class="p-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary flex-grow text-gray-700">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
            </select>

            <button type="button" onclick="applyFilters()" class="px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md">
                Filter
            </button>
            <button type="button" onclick="resetFilters()" class="px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition duration-150 shadow-md">
                Reset
            </button>
        </form>

        <!-- Backlog Table Container -->
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">PIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Deadline</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Progress</th>
                    </tr>
                </thead>
                <tbody id="backlog-body" class="bg-white divide-y divide-gray-200">
                    <!-- Backlog rows will be populated by JS -->
                </tbody>
            </table>
        </div>

        <!-- Pagination (Simulated) -->
        <div id="pagination-links" class="mt-6 flex justify-center space-x-2">
            <!-- Pagination links will be populated by JS -->
        </div>

    </div>

    <script>
        const mockRapats = [
            { id: 1, judul: 'Rapat Proyek Peluncuran Q4 2025' },
            { id: 2, judul: 'Rapat Tinjauan Fitur Keamanan Sistem' },
            { id: 3, judul: 'Rapat Perencanaan Anggaran 2026' }
        ];

        const mockBacklogs = [
            { id: 1, deskripsi: 'Revisi UI halaman login dan registrasi', pic: 'Andi', deadline: '2025-11-20', status: 'pending', progress: 10, rapat_id: 1 },
            { id: 2, deskripsi: 'Implementasi API otentikasi (JWT)', pic: 'Budi', deadline: '2025-11-25', status: 'in_progress', progress: 50, rapat_id: 1 },
            { id: 3, deskripsi: 'Dokumentasi user manual fitur A', pic: 'Citra', deadline: '2025-11-30', status: 'done', progress: 100, rapat_id: 2 },
            { id: 4, deskripsi: 'Penyesuaian database skema (v2.1)', pic: 'Dewi', deadline: '2025-12-05', status: 'pending', progress: 0, rapat_id: 2 },
            { id: 5, deskripsi: 'Fix bug laporan bulanan (sorting)', pic: 'Eka', deadline: '2025-12-10', status: 'in_progress', progress: 75, rapat_id: 1 },
            { id: 6, deskripsi: 'Integrasi layanan notifikasi email', pic: 'Fajar', deadline: '2025-12-15', status: 'pending', progress: 20, rapat_id: 3 },
            { id: 7, deskripsi: 'Testing performa server v1.2', pic: 'Andi', deadline: '2025-12-20', status: 'done', progress: 100, rapat_id: 3 },
            { id: 8, deskripsi: 'Desain ulang dashboard admin', pic: 'Citra', deadline: '2025-12-25', status: 'in_progress', progress: 60, rapat_id: 1 },
        ];

        document.addEventListener('DOMContentLoaded', () => {
            populateRapatFilters();
            renderTable(mockBacklogs);
            renderPagination(1, 1); // Initial render with dummy pagination
        });

        // Helper to get Tailwind classes for status
        function getStatusClasses(status) {
            switch (status) {
                case 'pending':
                    return {
                        badge: 'bg-red-100 text-red-800',
                        progress: 'bg-red-500'
                    };
                case 'in_progress':
                    return {
                        badge: 'bg-yellow-100 text-yellow-800',
                        progress: 'bg-yellow-500'
                    };
                case 'done':
                    return {
                        badge: 'bg-green-100 text-green-800',
                        progress: 'bg-green-500'
                    };
                default:
                    return {
                        badge: 'bg-gray-100 text-gray-800',
                        progress: 'bg-gray-400'
                    };
            }
        }

        function populateRapatFilters() {
            const select = document.getElementById('rapat_id');
            mockRapats.forEach(rapat => {
                const option = document.createElement('option');
                option.value = rapat.id;
                option.textContent = rapat.judul;
                select.appendChild(option);
            });
        }

        function renderTableRow(backlog) {
            const classes = getStatusClasses(backlog.status);
            const statusText = backlog.status.replace('_', ' ').split(' ').map(s => s.charAt(0).toUpperCase() + s.slice(1)).join(' ');

            return `
                <tr class="hover:bg-gray-50 transition duration-100">
                    <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900">${backlog.deskripsi}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${backlog.pic}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${backlog.deadline}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${classes.badge}">
                            ${statusText}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center space-x-2">
                            <div class="progress-bar-container">
                                <div class="progress-bar ${classes.progress}" style="width: ${backlog.progress}%;"></div>
                            </div>
                            <span>${backlog.progress}%</span>
                        </div>
                    </td>
                </tr>
            `;
        }

        function renderTable(backlogs) {
            const tbody = document.getElementById('backlog-body');
            tbody.innerHTML = ''; // Clear existing rows

            if (backlogs.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada backlog yang sesuai dengan filter.</td></tr>';
                return;
            }

            backlogs.forEach(backlog => {
                tbody.innerHTML += renderTableRow(backlog);
            });
        }

        function renderPagination(currentPage, totalPages) {
            const paginationDiv = document.getElementById('pagination-links');
            paginationDiv.innerHTML = '';
            
            // This is a simple simulation of Laravel's pagination links
            const links = [
                { text: 'Previous', url: '#', active: currentPage > 1, disabled: currentPage === 1 },
                { text: currentPage, url: '#', active: true, disabled: false },
                { text: 'Next', url: '#', active: currentPage < totalPages, disabled: currentPage === totalPages }
            ];

            links.forEach(link => {
                const linkClass = link.active && link.text !== currentPage 
                    ? 'px-4 py-2 text-primary border border-primary rounded-lg hover:bg-indigo-50 transition duration-150'
                    : link.text === currentPage 
                        ? 'px-4 py-2 bg-primary text-white border border-primary rounded-lg font-semibold shadow-md'
                        : 'px-4 py-2 text-gray-500 border border-gray-300 rounded-lg cursor-not-allowed opacity-50';

                const button = document.createElement('a');
                button.href = link.url;
                button.textContent = link.text;
                button.className = linkClass;
                button.onclick = (e) => e.preventDefault();
                paginationDiv.appendChild(button);
            });
        }


        function applyFilters() {
            const rapatId = document.getElementById('rapat_id').value;
            const status = document.getElementById('status').value;

            const filteredBacklogs = mockBacklogs.filter(b => {
                const rapatMatch = rapatId === "" || b.rapat_id === parseInt(rapatId);
                const statusMatch = status === "" || b.status === status;
                return rapatMatch && statusMatch;
            });

            renderTable(filteredBacklogs);

            // Simulate pagination update (assuming 5 items per page max)
            const totalPages = Math.ceil(filteredBacklogs.length / 5);
            renderPagination(1, totalPages > 0 ? totalPages : 1);
        }

        function resetFilters() {
            document.getElementById('rapat_id').value = "";
            document.getElementById('status').value = "";
            applyFilters();
        }

    </script>
</body>
</html>