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