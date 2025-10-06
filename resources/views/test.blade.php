<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetLog Notulensi - Ultimate Design</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <style>
        :root { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .modal-container { transition: opacity 0.3s ease; opacity: 0; pointer-events: none; }
        .modal-panel { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .modal-container .modal-panel { transform: scale(0.95); opacity: 0; }
        .modal-container.active { opacity: 1; pointer-events: auto; }
        .modal-container.active .modal-panel { transform: scale(1); opacity: 1; }

        .dropdown-menu { transition: all 0.2s ease; transform-origin: top right; transform: scale(0.95); opacity: 0; pointer-events: none; }
        .dropdown-menu.active { transform: scale(1); opacity: 1; pointer-events: auto; }

        .topic-item .dropdown-toggle { opacity: 0; transition: opacity 0.2s ease; }
        .topic-item:hover .dropdown-toggle, .topic-item.active .dropdown-toggle { opacity: 1; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex min-h-screen">

    <aside id="sidebar" class="bg-white/95 backdrop-blur-sm shadow-lg flex-col fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 z-50 transition-all duration-300 ease-in-out w-64 shrink-0 hidden md:flex">
        <div class="p-4 border-b border-slate-200/80 flex items-center justify-between h-16 shrink-0"><h1 class="text-2xl font-bold text-teal-600 transition-all">MeetLog</h1></div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-teal-700 transition-colors duration-200"><svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg><span class="nav-text">Dashboard</span></a>
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-teal-700 transition-colors duration-200"><svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg><span class="nav-text">Rekap Rapat</span></a>
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg bg-teal-50 text-teal-700 font-semibold transition-colors duration-200"><svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg><span class="nav-text">Rekap Notulensi</span></a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col max-h-screen overflow-hidden">
        <header class="flex items-center justify-between bg-white/80 backdrop-blur-sm shadow-sm px-4 md:px-6 z-30 h-16 shrink-0">
            <button id="back-to-list" class="hidden p-2 text-slate-600 rounded-full hover:bg-slate-100"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
            <h2 class="text-xl font-semibold text-slate-800">Detail Notulensi</h2>
            <div class="flex items-center space-x-6"><button class="flex items-center space-x-2"><img src="https://i.pravatar.cc/32?u=user-xyz" alt="Profile" class="w-9 h-9 rounded-full ring-2 ring-offset-2 ring-teal-400"><span class="font-medium hidden sm:inline text-slate-700">Aldy J. Hutasoit</span></button></div>
        </header>

        <main id="main-content" class="flex-1 grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 overflow-hidden relative">
            <aside id="left-pane" class="col-span-1 bg-white flex flex-col h-full border-r border-slate-200/80 absolute md:static inset-0 w-full md:w-auto z-20 transition-transform duration-300 ease-in-out">
                <div class="p-4">
                     <h3 class="font-bold text-lg text-slate-800">Evaluasi Kinerja Website Polibatam Kuartal 3</h3>
                    <div class="flex items-center mt-2 text-sm text-slate-500 gap-4">
                        <div class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg><span>26 Okt 2025</span></div>
                    </div>
                </div>
                <div class="p-4 border-t border-b border-slate-200/80">
                    <h4 class="text-sm font-semibold text-slate-800">Peserta Rapat (8)</h4>
                    <div class="flex items-center mt-3 -space-x-2"><img src="https://i.pravatar.cc/32?u=user-1" title="User Satu" class="w-8 h-8 rounded-full ring-2 ring-white"><img src="https://i.pravatar.cc/32?u=user-xyz" title="Aldy J. Hutasoit" class="w-8 h-8 rounded-full ring-2 ring-white"><img src="https://i.pravatar.cc/32?u=user-3" title="User Tiga" class="w-8 h-8 rounded-full ring-2 ring-white"><img src="https://i.pravatar.cc/32?u=user-4" title="User Empat" class="w-8 h-8 rounded-full ring-2 ring-white"><a href="#" class="w-8 h-8 rounded-full bg-slate-200 hover:bg-slate-300 ring-2 ring-white flex items-center justify-center text-xs font-bold text-slate-600">+4</a></div>
                </div>
                <div class="flex-1 p-4 overflow-y-auto">
                    <h4 class="text-sm font-semibold text-slate-800">Daftar Pokok Bahasan</h4>
                    <div class="relative mt-2"><input type="text" placeholder="Cari topik..." class="w-full pl-9 pr-4 py-2 text-sm border-slate-200 rounded-lg focus:ring-teal-500 focus:border-teal-500"><svg class="w-5 h-5 text-slate-400 absolute top-1/2 left-2.5 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></div>
                    <nav id="topic-list" class="mt-4 space-y-1 pr-1"></nav>
                </div>
                 <div class="p-4 border-t border-slate-200/80"><button data-modal-target="topicModal" class="w-full bg-teal-600 text-white hover:bg-teal-700 font-semibold p-3 rounded-lg shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5"><svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>Tambah Topik</button></div>
            </aside>

            <div id="right-pane" class="col-span-1 md:col-span-2 xl:col-span-3 overflow-y-auto p-4 md:p-6 bg-slate-50"></div>
        </main>
    </div>

    <div id="topicModal" class="modal-container fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="modal-panel bg-white rounded-xl shadow-2xl w-full max-w-lg">
             <div class="flex items-center justify-between p-5 border-b"><h3 class="text-xl font-semibold text-slate-800">Pokok Bahasan</h3><button type="button" class="modal-close text-slate-400 hover:text-slate-700 text-2xl transition-colors">&times;</button></div>
             <div class="p-6"><textarea rows="4" class="w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="Tuliskan deskripsi pokok bahasan..."></textarea></div>
             <div class="flex items-center justify-end p-4 border-t space-x-3 bg-slate-50 rounded-b-xl"><button type="button" class="modal-close bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</button><button type="submit" class="bg-teal-600 hover:bg-teal-700 py-2 px-4 text-white rounded-md text-sm font-medium">Simpan</button></div>
        </div>
    </div>
    <div id="decisionModal" class="modal-container fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="modal-panel bg-white rounded-xl shadow-2xl w-full max-w-lg">
            <div class="flex items-center justify-between p-5 border-b"><h3 class="text-xl font-semibold text-slate-800">Keputusan</h3><button type="button" class="modal-close text-slate-400 hover:text-slate-700 text-2xl transition-colors">&times;</button></div>
            <div class="p-6"><textarea rows="4" class="w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="Tuliskan keputusan yang diambil..."></textarea></div>
            <div class="flex items-center justify-end p-4 border-t space-x-3 bg-slate-50 rounded-b-xl"><button type="button" class="modal-close bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</button><button type="submit" class="bg-teal-600 hover:bg-teal-700 py-2 px-4 text-white rounded-md text-sm font-medium">Simpan</button></div>
        </div>
    </div>
    <div id="actionModal" class="modal-container fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="modal-panel bg-white rounded-xl shadow-2xl w-full max-w-lg">
            <div class="flex items-center justify-between p-5 border-b"><h3 class="text-xl font-semibold text-slate-800">Tindakan</h3><button type="button" class="modal-close text-slate-400 hover:text-slate-700 text-2xl transition-colors">&times;</button></div>
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <div><label class="text-sm font-medium text-slate-700">Deskripsi Tindakan</label><textarea rows="3" class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="Tindakan spesifik yang harus dilakukan..."></textarea></div>
                <div><label class="text-sm font-medium text-slate-700">Person in Charge (PIC)</label><select class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"><option>Pilih PIC</option><option>Aldy J. Hutasoit</option><option>Tim SEO</option><option>Tim UI/UX</option></select></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium text-slate-700">Tanggal Selesai</label><input type="date" class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"></div>
                    <div><label class="text-sm font-medium text-slate-700">Status</label><select class="mt-1 w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"><option>Belum Mulai</option><option>Dikerjakan</option><option>Selesai</option></select></div>
                </div>
            </div>
            <div class="flex items-center justify-end p-4 border-t space-x-3 bg-slate-50 rounded-b-xl"><button type="button" class="modal-close bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</button><button type="submit" class="bg-teal-600 hover:bg-teal-700 py-2 px-4 text-white rounded-md text-sm font-medium">Simpan</button></div>
        </div>
    </div>
    <div id="deleteModal" class="modal-container fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="modal-panel bg-white rounded-xl shadow-2xl w-full max-w-md">
            <div class="p-6 text-center"><div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100"><svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div><h3 class="text-lg font-semibold text-slate-800 mt-5">Hapus Item Ini?</h3><p class="text-sm text-slate-500 mt-2">Apakah Anda yakin? Tindakan ini tidak dapat diurungkan.</p><div class="mt-6 flex justify-center gap-3"><button type="button" class="modal-close py-2 px-4 bg-white border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 w-24">Batal</button><button type="button" class="py-2 px-4 bg-red-600 hover:bg-red-700 text-white rounded-md shadow-sm text-sm font-medium w-24">Hapus</button></div></div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const data = { topics: [{ id: 1, title: 'Analisis Performa SEO Website', actionCount: 3, decisions: [{ id: 101, text: 'Optimasi kata kunci pada halaman utama dan program studi.', actions: [{ id: 1001, text: 'Riset kata kunci relevan untuk setiap program studi.', pic: 'Tim SEO', due: '10 Nov', status: 'Selesai' },{ id: 1002, text: 'Implementasi hasil riset ke meta title dan description.', pic: 'Aldy J. Hutasoit', due: '17 Nov', status: 'Dikerjakan' },{ id: 1003, text: 'Monitor ranking kata kunci setiap minggu.', pic: 'Tim SEO', due: '24 Nov', status: 'Belum Mulai' }] }] },{ id: 2, title: 'Desain Ulang Halaman Beranda', actionCount: 1, decisions: [{ id: 102, text: 'Membuat 2 alternatif mockup desain baru untuk halaman beranda.', actions: [{ id: 1004, text: 'Membuat wireframe dan user flow untuk desain baru.', pic: 'Tim UI/UX', due: '12 Nov', status: 'Belum Mulai' }] }] },{ id: 3, title: 'Penambahan Fitur Live Chat', actionCount: 2, decisions: [{ id: 103, text: 'Riset dan pilih 3 vendor platform live chat terbaik.', actions: [{ id: 1005, text: 'Buat matriks perbandingan fitur dan harga.', pic: 'Aldy J. Hutasoit', due: '15 Nov', status: 'Belum Mulai' },{ id: 1006, text: 'Jadwalkan demo dengan vendor terpilih.', pic: 'Uuf Brajawidagda', due: '20 Nov', status: 'Belum Mulai' }] }] }]};
        const topicListContainer = document.getElementById('topic-list');
        const rightPane = document.getElementById('right-pane');
        const leftPane = document.getElementById('left-pane');
        const backToListBtn = document.getElementById('back-to-list');

        function renderTopics() {
            topicListContainer.innerHTML = data.topics.map((topic, index) => `
                <a href="#" class="topic-item group flex items-center justify-between p-3 rounded-lg hover:bg-slate-100 border-l-4 border-transparent transition-all duration-200" data-topic-id="${topic.id}">
                    <span class="font-medium text-sm text-slate-600">${index + 1}. ${topic.title}</span>
                    <div class="flex items-center gap-2">
                       <span class="text-xs font-medium text-slate-400 group-hover:text-slate-600">${topic.actionCount} Tindakan</span>
                       <div class="relative dropdown">
                           <button class="dropdown-toggle text-slate-400 hover:text-slate-700 p-1 rounded-md"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg></button>
                           <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 ring-1 ring-black ring-opacity-5"><button data-modal-target="topicModal" class="w-full text-left flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Ubah Detail Topik</button><button data-modal-target="deleteModal" class="w-full text-left flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-slate-100">Hapus Topik</button></div>
                       </div>
                    </div>
                </a>`).join('');
            addEventListenersToTopicItems();
        }

        function renderTopicContent(topicId) {
            const topic = data.topics.find(t => t.id == topicId);
            if (!topic) { renderEmptyState(); return; }
            const statusStyles = { 'Selesai': 'text-green-800 bg-green-100', 'Dikerjakan': 'text-amber-800 bg-amber-100', 'Belum Mulai': 'text-slate-800 bg-slate-200' };
            rightPane.innerHTML = `
                <div class="space-y-6">
                    ${topic.decisions.map((decision, index) => `
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200/80">
                            <div class="p-5 border-b border-slate-200/80 flex justify-between items-start">
                                <div class="flex items-start gap-3">
                                    <div class="bg-teal-50 text-teal-600 rounded-lg w-8 h-8 flex items-center justify-center shrink-0 font-bold text-sm">${index+1}</div>
                                    <div>
                                        <h4 class="font-semibold text-slate-800">Keputusan</h4>
                                        <p class="text-slate-600">${decision.text}</p>
                                    </div>
                                </div>
                                <div class="relative dropdown flex-shrink-0 ml-4">
                                    <button class="dropdown-toggle text-slate-400 hover:text-slate-700 p-1 rounded-md"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg></button>
                                    <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 ring-1 ring-black ring-opacity-5"><button data-modal-target="decisionModal" class="w-full text-left flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Ubah Keputusan</button><button data-modal-target="deleteModal" class="w-full text-left flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-slate-100">Hapus Keputusan</button></div>
                                </div>
                            </div>
                            <div class="p-5 space-y-3">
                                ${decision.actions.map(action => `
                                    <div class="p-3 bg-slate-50 rounded-lg flex flex-col sm:flex-row sm:items-center gap-3">
                                        <p class="text-sm text-slate-700 flex-1">${action.text}</p>
                                        <div class="w-full sm:w-auto flex items-center justify-between sm:justify-end gap-4 flex-shrink-0">
                                            <div class="flex items-center gap-2" title="PIC: ${action.pic}"><svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg><span class="text-sm font-medium hidden md:inline">${action.pic}</span></div>
                                            <div class="flex items-center gap-2" title="Due Date: ${action.due}"><svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><span class="text-sm text-slate-500">${action.due}</span></div>
                                            <div class="px-2.5 py-1 text-xs font-semibold ${statusStyles[action.status]} rounded-full">${action.status}</div>
                                            <div class="relative dropdown">
                                                <button class="dropdown-toggle text-slate-400 hover:text-slate-600 p-1 rounded-md"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg></button>
                                                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 ring-1 ring-black ring-opacity-5"><button data-modal-target="actionModal" class="w-full text-left flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Ubah Tindakan</button><button data-modal-target="deleteModal" class="w-full text-left flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-slate-100">Hapus Tindakan</button></div>
                                            </div>
                                        </div>
                                    </div>`).join('')}
                                 <button data-modal-target="actionModal" class="w-full mt-2 text-sm font-semibold text-teal-600 hover:text-teal-800 flex items-center justify-center gap-2 p-2 rounded-lg hover:bg-teal-50"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>Tambah Tindakan</button>
                            </div>
                        </div>`).join('')}
                    <button data-modal-target="decisionModal" class="w-full mt-6 border-2 border-dashed border-slate-300 hover:border-teal-500 hover:text-teal-600 text-slate-500 font-semibold p-4 rounded-xl transition-all flex items-center justify-center gap-2 text-sm"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>Tambah Keputusan</button>
                </div>`;
            addEventListenersToDropdowns(); addEventListenersToModals();
        }

        function renderEmptyState() {
             rightPane.innerHTML = `<div class="hidden md:flex h-full flex-col items-center justify-center text-center text-slate-500 p-8"><svg class="w-20 h-20 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg><h3 class="mt-4 text-xl font-semibold text-slate-700">Selamat Datang</h3><p class="mt-2 max-w-sm">Pilih salah satu pokok bahasan di panel kiri untuk melihat detailnya di sini.</p></div>`;
        }

        function setActiveTopic(topicItem) {
            document.querySelectorAll('.topic-item').forEach(i => { i.classList.remove('bg-teal-50', 'border-teal-500'); i.querySelector('span:first-child').classList.remove('text-teal-700', 'font-semibold'); i.querySelector('span:first-child').classList.add('text-slate-600', 'font-medium'); });
            topicItem.classList.add('bg-teal-50', 'border-teal-500');
            topicItem.querySelector('span:first-child').classList.add('text-teal-700', 'font-semibold');
            topicItem.querySelector('span:first-child').classList.remove('text-slate-600', 'font-medium');
        }

        function addEventListenersToTopicItems() {
             document.querySelectorAll('.topic-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    if (e.target.closest('.dropdown-toggle')) { e.preventDefault(); return; }
                    e.preventDefault();
                    renderTopicContent(item.dataset.topicId);
                    setActiveTopic(item);
                    if (window.innerWidth < 768) { leftPane.classList.add('-translate-x-full'); backToListBtn.classList.remove('hidden'); }
                });
            });
        }
        
        backToListBtn.addEventListener('click', () => { leftPane.classList.remove('-translate-x-full'); backToListBtn.classList.add('hidden'); });

        let activeDropdown = null;
        function addEventListenersToDropdowns() {
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', (event) => {
                    event.stopPropagation();
                    let menu = toggle.nextElementSibling;
                    if (activeDropdown && activeDropdown !== menu) { activeDropdown.classList.remove('active'); }
                    menu.classList.toggle('active');
                    activeDropdown = menu.classList.contains('active') ? menu : null;
                });
            });
        }

        function addEventListenersToModals() {
            document.querySelectorAll('[data-modal-target]').forEach(button => button.addEventListener('click', () => document.getElementById(button.dataset.modalTarget).classList.add('active')));
        }
        
        window.addEventListener('click', () => { if (activeDropdown) { activeDropdown.classList.remove('active'); activeDropdown = null; } });
        document.querySelectorAll('.modal-close').forEach(button => button.addEventListener('click', () => button.closest('.modal-container').classList.remove('active')));
        document.querySelectorAll('.modal-container').forEach(modal => modal.addEventListener('click', e => { if (e.target === modal) modal.classList.remove('active'); }));
        
        renderTopics();
        renderEmptyState();
    });
    </script>
</body>
</html>