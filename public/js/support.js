document.addEventListener('DOMContentLoaded', function () {
    // --- ELEMENT SELECTORS ---
    const calendarEl = document.getElementById('calendar');
    const eventListContainer = document.getElementById("event-list-container");
    const eventListTitle = document.getElementById("event-list-title");
    const eventListSubtitle = document.getElementById("event-list-subtitle");
    const filterButtonsContainer = document.getElementById("event-filter-buttons");
    const backToUpcomingBtn = document.getElementById("back-to-upcoming");

    // --- CONFIG ---
    // 'events' variable is expected to be defined in the HTML before this script is loaded.
    const today = new Date();
    let currentFilter = '7days';

    // --- HELPER FUNCTIONS ---
    const formatDate = date => {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [year, month, day].join('-');
    };
    const todayStr = formatDate(today);

    // UPDATED: More compact event card for "mini detail" view
    const eventCardHTML = event => `
      <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
          <p class="font-semibold text-slate-800 text-sm truncate pr-4">${event.title}</p>
          <p class="text-sm text-[#4C8C86] font-medium whitespace-nowrap">${new Date(event.start).toLocaleTimeString("id-ID", { hour: "2-digit", minute: "2-digit", hour12: false })} WIB</p>
      </div>`;

    // --- MAIN DISPLAY FUNCTIONS ---
    const displayEventsForDate = date => {
        const dateStr = formatDate(date);
        const filteredEvents = events.filter(event => event.start.startsWith(dateStr));

        eventListTitle.textContent = 'Detail Acara';
        eventListSubtitle.textContent = new Date(date).toLocaleDateString("id-ID", { weekday: "long", day: "numeric", month: "long" });
        filterButtonsContainer.classList.add('hidden');
        backToUpcomingBtn.classList.remove('hidden');

        eventListContainer.innerHTML = filteredEvents.length > 0 ? filteredEvents.map(eventCardHTML).join("") : `<p class="text-center py-8 text-slate-400">Tidak ada acara pada tanggal ini.</p>`;
    };

    const displayUpcomingEvents = (filter) => {
        currentFilter = filter;
        eventListTitle.textContent = 'Acara Terdekat';
        eventListSubtitle.textContent = '';
        filterButtonsContainer.classList.remove('hidden');
        backToUpcomingBtn.classList.add('hidden');

        const startDate = new Date(today);
        startDate.setHours(0, 0, 0, 0);

        const endDate = new Date(startDate);
        if (filter === 'today') {
            endDate.setHours(23, 59, 59, 999);
        } else if (filter === '3days') {
            endDate.setDate(endDate.getDate() + 2);
            endDate.setHours(23, 59, 59, 999);
        } else { // 7days
            endDate.setDate(endDate.getDate() + 6);
            endDate.setHours(23, 59, 59, 999);
        }

        const filteredEvents = events
            .filter(event => {
                const eventDate = new Date(event.start);
                return eventDate >= startDate && eventDate <= endDate;
            })
            .sort((a, b) => new Date(a.start) - new Date(b.start));

        if (filteredEvents.length === 0) {
            eventListContainer.innerHTML = `<p class="text-center py-8 text-slate-400">Tidak ada acara dalam rentang waktu ini.</p>`;
            return;
        }

        const groupedEvents = filteredEvents.reduce((acc, event) => {
            const dateKey = formatDate(new Date(event.start));
            if (!acc[dateKey]) acc[dateKey] = [];
            acc[dateKey].push(event);
            return acc;
        }, {});

        let content = "";
        for (const dateKey in groupedEvents) {
            let dayLabel = new Date(dateKey + "T00:00:00").toLocaleDateString("id-ID", { weekday: "long", day: "numeric", month: "short" });
            if (dateKey === todayStr) {
                dayLabel = "Hari Ini";
            } else if (formatDate(new Date(today.getTime() + 86400000)) === dateKey) {
                dayLabel = "Besok";
            }
            content += `<div class="day-group"><p class="font-semibold text-slate-600 mb-2 text-sm">${dayLabel}</p><div class="space-y-2">${groupedEvents[dateKey].map(eventCardHTML).join("")}</div></div>`;
        }
        eventListContainer.innerHTML = content;
    };

    // --- CALENDAR & INITIALIZATION ---
   if (calendarEl) {
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: events, // Menggunakan data dari controller
        locale: "id",
        height: "auto",
        dateClick: (info) => displayEventsForDate(info.date),
        eventClick: async function(info) {
            const rapatId = info.event.id; // pastikan event.id berisi ID rapat
            if (!rapatId || !detailModal) return;

            // Tampilkan modal dan spinner
            detailModal.classList.remove('hidden');
            modalSpinner.style.display = 'block';
            modalContent.style.display = 'none';

            try {
                const response = await fetch(`/rapat/${rapatId}/details`);
                if (!response.ok) throw new Error('Gagal mengambil data rapat.');

                const data = await response.json();
                populateModal(data); // isi modal dengan data
            } catch (error) {
                console.error(error);
                modalContent.innerHTML = '<p class="text-red-500 text-center">Terjadi kesalahan saat memuat data.</p>';
            } finally {
                modalSpinner.style.display = 'none';
                modalContent.style.display = 'block';
            }
        },
        initialDate: today,
        dayMaxEvents: true,
    });
    calendar.render();
}


// ================= DSS GLOBAL =================
async function loadDssGlobal() {
    try {
        const response = await fetch('/rapat/rekomendasi-global', {
            headers: { 'Accept': 'application/json' }
        });

        const data = await response.json();
        if (!data.success) return;

        document.getElementById('dss-tanggal').textContent = data.rekomendasi.tanggal;
        document.getElementById('dss-jam').textContent = data.rekomendasi.jam;
        document.getElementById('dss-alasan').textContent = data.rekomendasi.alasan;

        document.getElementById('dss-box').classList.remove('hidden');

        document.getElementById('dss-apply').onclick = () => {
            document.getElementById('tanggal').value = data.rekomendasi.tanggal;
            document.getElementById('jam').value = data.rekomendasi.jam;
        };

    } catch (error) {
        console.error('DSS GLOBAL ERROR:', error);
    }
}


    // --- EVENT LISTENERS ---
    filterButtonsContainer.addEventListener('click', (e) => {
        if (e.target.matches('.event-filter-btn')) {
            filterButtonsContainer.querySelector('.active').classList.remove('active');
            e.target.classList.add('active');
            displayUpcomingEvents(e.target.dataset.filter);
        }
    });
    backToUpcomingBtn.addEventListener('click', () => displayUpcomingEvents(currentFilter));

    // --- MODAL LOGIC ---
    const modal = document.getElementById('newMeetModal');
    const openModalBtn = document.getElementById('buatRapatBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const newMeetForm = document.getElementById('newMeetForm');

    const openModal = () => modal.classList.remove('hidden');

    const OnlineBtn = document.getElementById('OnlineBtn'), OfflineBtn = document.getElementById('OfflineBtn'), OnlineFields = document.getElementById('OnlineFields'), OfflineFields = document.getElementById('OfflineFields');
    OnlineBtn.addEventListener('click', () => { OnlineFields.classList.remove('hidden'); OfflineFields.classList.add('hidden'); OnlineBtn.classList.add('bg-white', 'text-slate-900', 'shadow'); OfflineBtn.classList.remove('bg-white', 'text-slate-900', 'shadow'); });
    OfflineBtn.addEventListener('click', () => { OfflineFields.classList.remove('hidden'); OnlineFields.classList.add('hidden'); OfflineBtn.classList.add('bg-white', 'text-slate-900', 'shadow'); OnlineBtn.classList.remove('bg-white', 'text-slate-900', 'shadow'); });

    const attachLinkRadio = document.getElementById('attachLinkRadio'), generateZoomRadio = document.getElementById('generateZoomRadio'), attachLinkContainer = document.getElementById('attachLinkContainer'), generateZoomContainer = document.getElementById('generateZoomContainer');
    attachLinkRadio.addEventListener('change', () => { if (attachLinkRadio.checked) { attachLinkContainer.classList.remove('hidden'); generateZoomContainer.classList.add('hidden'); } });
    generateZoomRadio.addEventListener('change', () => { if (generateZoomRadio.checked) { generateZoomContainer.classList.remove('hidden'); attachLinkContainer.classList.add('hidden'); } });

    // --- LOGIKA UNTUK INPUT EMAIL DENGAN TAGS ---
    let selectedEmails = [];
    const anggotaContainer = document.getElementById('anggota-container');
    const tagsContainer = document.getElementById('anggota-tags');
    const searchInput = document.getElementById('anggota-search');
    const dropdown = document.getElementById('anggota-dropdown');

    const renderTags = () => {
        tagsContainer.innerHTML = selectedEmails.map(email => `
            <span class="flex items-center gap-1 bg-[#E5F2F1] text-[#3D706B] text-sm font-medium px-2 py-1 rounded-full">
                ${email}
                <button type="button" class="remove-tag-btn focus:outline-none" data-email="${email}">&times;</button>
            </span>
        `).join('');
    };

    const renderDropdown = () => {
        const query = searchInput.value.toLowerCase();
        const availableGroups = Object.keys(memberGroups).filter(group => group.toLowerCase().includes(query));
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isEmailQuery = emailRegex.test(query);

        if (availableGroups.length === 0 && !isEmailQuery) {
            dropdown.classList.add('hidden');
            return;
        }

        let dropdownHTML = availableGroups.map(group => `<div class="cursor-pointer hover:bg-slate-100 p-2 text-sm" data-group="${group}"><strong>${group}</strong> <span class="text-slate-500 text-xs">(${memberGroups[group].length} anggota)</span></div>`).join('');

        if (isEmailQuery && !selectedEmails.includes(query)) {
            dropdownHTML += `<div class="cursor-pointer hover:bg-slate-100 p-2 text-sm" data-email-add="${query}">Tambah email: <strong>${query}</strong></div>`;
        }

        if (dropdownHTML) {
            dropdown.innerHTML = dropdownHTML;
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
    };

    anggotaContainer.addEventListener('click', () => searchInput.focus());
    searchInput.addEventListener('focus', renderDropdown);
    searchInput.addEventListener('input', renderDropdown);
    document.addEventListener('click', (e) => { if (!anggotaContainer.contains(e.target)) dropdown.classList.add('hidden'); });

    dropdown.addEventListener('click', (e) => {
        const groupTarget = e.target.closest('[data-group]');
        const emailTarget = e.target.closest('[data-email-add]');

        if (groupTarget) {
            const groupName = groupTarget.dataset.group;
            const emailsToAdd = memberGroups[groupName];
            selectedEmails = [...new Set([...selectedEmails, ...emailsToAdd])];
        } else if (emailTarget) {
            const emailToAdd = emailTarget.dataset.emailAdd;
            if (!selectedEmails.includes(emailToAdd)) selectedEmails.push(emailToAdd);
        }

        if (groupTarget || emailTarget) {
            searchInput.value = '';
            renderTags();
            dropdown.classList.add('hidden');
            searchInput.focus();
        }
    });

    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const email = searchInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(email) && !selectedEmails.includes(email)) {
                selectedEmails.push(email);
                searchInput.value = '';
                renderTags();
                renderDropdown();
            }
        }
    });

    tagsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-tag-btn')) {
            selectedEmails = selectedEmails.filter(email => email !== e.target.dataset.email);
            renderTags();
            renderDropdown();
        }
    });

    const resetEmailInput = () => {
        selectedEmails = [];
        renderTags();
        searchInput.value = '';
        dropdown.classList.add('hidden');
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        resetEmailInput();
    };

document.addEventListener('click', function (e) {
    if (e.target.closest('#buatRapatBtn')) {
        openModal();
        loadDssGlobal(); // 🔥 PASTI TERPANGGIL
    }
});
    closeModalBtn.addEventListener('click', closeModal);
    cancelModalBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

    newMeetForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitButton = newMeetForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;

        submitButton.disabled = true;
        submitButton.innerHTML = `
            Menyimpan...
        `;

        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

        const formData = new FormData(newMeetForm);

        if (Array.isArray(selectedEmails) && selectedEmails.length) {
            selectedEmails.forEach(email => formData.append('undangan[]', email));
        }

        const locationType = document.getElementById('OnlineFields').classList.contains('hidden') ? 'offline' : 'online';
        formData.append('tipe_lokasi', locationType);

        // --- FIX: Tambahkan field 'lokasi' secara manual ke FormData ---
        if (locationType === 'online') {
            // Jika online, ambil nilai dari input 'link'
            formData.append('lokasi', document.getElementById('link').value);
        } else {
            // Jika offline, ambil nilai dari input 'ruangan'
            formData.append('lokasi', document.getElementById('ruangan').value);
        }
        // --- AKHIR PERBAIKAN ---

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(newMeetForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    console.error('Validation errors:', data.errors);
                    Object.entries(data.errors).forEach(([field, messages]) => {
                        const fieldName = field.split('.')[0];
                        const input = document.getElementById(fieldName) || newMeetForm.querySelector(`[name="${fieldName}"]`);
                        if (input) {
                            const parentDiv = input.closest('div');
                            input.classList.add('border-red-500');
                            const errorMessage = `<p class="error-message text-sm text-red-600 mt-1">${messages.join(', ')}</p>`;
                            parentDiv.insertAdjacentHTML('beforeend', errorMessage);
                        } else if (fieldName === 'undangan') {
                            const container = document.getElementById('anggota-container');
                            container.classList.add('border-red-500');
                            const errorMessage = `<p class="error-message text-sm text-red-600 mt-1">${messages.join(', ')}</p>`;
                            container.parentElement.insertAdjacentHTML('beforeend', errorMessage);
                        }
                    });
                } else {
                    throw new Error(data.message || 'An unknown error occurred.');
                }
            } else {
                closeModal();
                location.reload();
            }
        } catch (error) {
            console.error('Submission failed:', error);
            alert('Gagal membuat rapat. Silakan coba lagi.');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        }
    });


    // --- LOGIKA UNTUK MODAL DETAIL RAPAT ---
    const detailModal = document.getElementById('detailRapatModal');
    const closeDetailBtn = document.getElementById('closeDetailModalBtn');
    const modalSpinner = document.getElementById('modalSpinner');
    const modalContent = document.getElementById('modalContent');
    
    // Fungsi untuk menutup modal
    const closeDetailModal = () => {
        if (detailModal) detailModal.classList.add('hidden');
    };

    if(detailModal) {
        // Event listener untuk tombol close
        closeDetailBtn.addEventListener('click', closeDetailModal);
        // Event listener untuk klik di luar modal
        detailModal.addEventListener('click', (e) => {
            if (e.target === detailModal) {
                closeDetailModal();
            }
        });
    }

    // Menggunakan event delegation untuk semua tombol 'Lihat Detail'
    document.body.addEventListener('click', async function(e) {
        if (e.target.closest('.open-detail-modal-btn')) {
            const button = e.target.closest('.open-detail-modal-btn');
            const rapatId = button.dataset.id;

            if (!rapatId || !detailModal) return;

            // Tampilkan modal dan spinner
            detailModal.classList.remove('hidden');
            modalSpinner.style.display = 'block';
            modalContent.style.display = 'none';

            try {
                // Ambil data dari API yang sudah kita buat
                const response = await fetch(`/rapat/${rapatId}/details`);
                if (!response.ok) {
                    throw new Error('Gagal mengambil data rapat.');
                }
                const data = await response.json();

                // Panggil fungsi untuk mengisi modal dengan data
                populateModal(data);

            } catch (error) {
                console.error(error);
                modalContent.innerHTML = '<p class="text-red-500 text-center">Terjadi kesalahan saat memuat data.</p>';
            } finally {
                // Sembunyikan spinner dan tampilkan konten
                modalSpinner.style.display = 'none';
                modalContent.style.display = 'block';
            }
        }
    });

    // Fungsi untuk mengisi data ke dalam modal
    function populateModal(data) {
         const detailJudul = document.getElementById('detailJudul');
        const detailAgenda = document.getElementById('detailAgenda');
        const detailStatus = document.getElementById('detailStatus');
        const detailTanggalWaktu = document.getElementById('detailTanggalWaktu');
        const detailLokasi = document.getElementById('detailLokasi');
        const detailPesertaList = document.getElementById('detailPesertaList');

        // Mengisi Judul
        detailJudul.textContent = data.judul;
        // Mengisi Agenda
        detailAgenda.textContent = data.agenda;

        // Mengisi Status
        const tglRapat = new Date(data.tanggal);
        if (tglRapat > new Date()) {
            detailStatus.innerHTML = `<span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Terjadwal</span>`;
        } else {
            detailStatus.innerHTML = `<span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Selesai</span>`;
        }
        
        // Mengisi Tanggal & Waktu
        const jam = data.jam.substring(0, 5); // Ambil HH:mm
        detailTanggalWaktu.textContent = `${tglRapat.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}, ${jam} WIB`;

        // Mengisi Lokasi
        if (data.tipe_lokasi === 'Online') {
            detailLokasi.innerHTML = `<a href="${data.link}" target="_blank" class="text-blue-600 hover:underline">Buka Link Meeting</a>`;
        } else {
            detailLokasi.textContent = data.ruangan || 'N/A';
        }

        // Mengisi Daftar Peserta
        detailPesertaList.innerHTML = ''; // Kosongkan dulu
        if (data.undangan && data.undangan.length > 0) {
            data.undangan.forEach(email => {
                const li = document.createElement('li');
                li.textContent = email;
                detailPesertaList.appendChild(li);
            });
        } else {
            detailPesertaList.innerHTML = '<li>Tidak ada peserta yang diundang secara spesifik.</li>';
        }
    }
});
