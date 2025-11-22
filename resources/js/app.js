import './bootstrap';

// import Alpine from 'alpinejs'
// import collapse from '@alpinejs/collapse'
import Swal from 'sweetalert2';


// window.Alpine = Alpine

window.addEventListener('swal:modal', event => {
    Swal.fire({
        title: event.detail[0].title,
        text: event.detail[0].text,
        icon: event.detail[0].icon,
        confirmButtonColor: '#3085d6',
    });
});

window.addEventListener('swal:confirm', event => {
    // Check if event.detail is an array (Livewire dispatch) or object (Alpine dispatch)
    const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;

    Swal.fire({
        title: detail.title,
        text: detail.text,
        icon: detail.icon,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch(detail.method, { id: detail.id });
        }
    });
});




