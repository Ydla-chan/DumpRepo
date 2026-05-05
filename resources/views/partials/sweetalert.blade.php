<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
/* Custom SweetAlert button styling to match project teal */
.swal2-confirm-custom {
    background-color: #4C8C86 !important;
    color: #ffffff !important;
    border-radius: 8px !important;
    padding: 8px 18px !important;
    box-shadow: 0 6px 18px rgba(76,140,134,0.16) !important;
}
.swal2-cancel-custom {
    background-color: #f3f4f6 !important;
    color: #374151 !important;
    border-radius: 8px !important;
    padding: 8px 18px !important;
}
</style>

<script>
(function () {
    const DEFAULT_CONFIRM_COLOR = '#4C8C86';

    const Base = Swal.mixin({
        customClass: {
            confirmButton: 'swal2-confirm-custom',
            cancelButton: 'swal2-cancel-custom'
        },
        buttonsStyling: false
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#ffffff',
        iconColor: DEFAULT_CONFIRM_COLOR
    });

    // Session-based notifications
    @if(session('success'))
        Base.fire({ icon: 'success', title: {!! json_encode(session('success')) !!} });
    @endif

    @if(session('error'))
        Base.fire({ icon: 'error', title: {!! json_encode(session('error')) !!} });
    @endif

    @if(session('status'))
        Base.fire({ icon: 'info', title: {!! json_encode(session('status')) !!} });
    @endif

    @if(session('warning'))
        Base.fire({ icon: 'warning', title: {!! json_encode(session('warning')) !!} });
    @endif

    @if($errors->any())
        Base.fire({ icon: 'error', title: 'Terjadi Kesalahan', html: {!! json_encode($errors->first()) !!} });
    @endif

    // Override native alert -> use Toast for non-blocking notices
    window.alert = function(message){
        if (typeof Swal !== 'undefined') {
            Toast.fire({ icon: 'info', title: String(message) });
        } else {
            console.log('Alert:', message);
        }
    };

    // Data-driven confirm handler for elements with `data-sw-confirm`
    document.addEventListener('click', function(e){
        const btn = e.target.closest('[data-sw-confirm]');
        if (!btn) return;
        e.preventDefault();

        const title = btn.getAttribute('data-sw-title') || 'Apakah Anda yakin?';
        const text = btn.getAttribute('data-sw-text') || '';
        const confirmText = btn.getAttribute('data-sw-confirm-text') || 'Ya, Lanjutkan';
        const cancelText = btn.getAttribute('data-sw-cancel-text') || 'Batal';
        const formSelector = btn.getAttribute('data-sw-form');
        const href = btn.getAttribute('href');

        Base.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText
        }).then((result) => {
            if (result.isConfirmed) {
                if (formSelector) {
                    const form = document.querySelector(formSelector);
                    if (form) form.submit();
                } else if (href) {
                    window.location.href = href;
                } else {
                    const action = btn.getAttribute('data-sw-action');
                    if (action && typeof window[action] === 'function') {
                        window[action](btn);
                    }
                }
            }
        });
    });
})();
</script>
