<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Konfigurasi default untuk semua notifikasi
  const Toast = Swal.mixin({
    toast: true
    , position: 'bottom-start'
    , showConfirmButton: false
    , timer: 3000
    , timerProgressBar: true
    , didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

  // Success notification
  @if(session('success'))
  Toast.fire({
    icon: 'success'
    , title: '{{ session('
    success ') }}'
  });
  @endif

  // Error notification
  @if(session('error'))
  Toast.fire({
    icon: 'error'
    , title: '{{ session('
    error ') }}'
  });
  @endif

  // Warning notification
  @if(session('warning'))
  Toast.fire({
    icon: 'warning'
    , title: '{{ session('
    warning ') }}'
  });
  @endif

  // Info notification
  @if(session('info'))
  Toast.fire({
    icon: 'info'
    , title: '{{ session('
    info ') }}'
  });
  @endif

  // Validation errors
  @if($errors->any())
  Toast.fire({
    icon: 'error'
    , title: 'Terdapat kesalahan!'
    , html: '<ul style="text-align: left; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>'
  });
  @endif

</script>

<script>
  // Global function untuk konfirmasi delete
  function confirmDelete(formId) {
    event.preventDefault();
    Swal.fire({
      title: 'Apakah Anda yakin?'
      , text: "Data yang dihapus tidak dapat dikembalikan!"
      , icon: 'warning'
      , showCancelButton: true
      , confirmButtonColor: '#dc2626'
      , cancelButtonColor: '#6b7280'
      , confirmButtonText: 'Ya, Hapus!'
      , cancelButtonText: 'Batal'
      , position: 'center'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(formId).submit();
      }
    });
  }

  // Global function untuk konfirmasi approve
  function confirmApprove(formId) {
    event.preventDefault();
    Swal.fire({
      title: 'Setujui UMKM ini?'
      , text: "UMKM akan dapat mengakses dashboard setelah disetujui"
      , icon: 'question'
      , showCancelButton: true
      , confirmButtonColor: '#16a34a'
      , cancelButtonColor: '#6b7280'
      , confirmButtonText: 'Ya, Setujui!'
      , cancelButtonText: 'Batal'
      , position: 'center'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(formId).submit();
      }
    });
  }

  // Global function untuk konfirmasi reject
  function confirmReject(formId) {
    event.preventDefault();
    Swal.fire({
      title: 'Tolak UMKM ini?'
      , text: "UMKM yang ditolak tidak dapat mengakses dashboard"
      , icon: 'warning'
      , showCancelButton: true
      , confirmButtonColor: '#dc2626'
      , cancelButtonColor: '#6b7280'
      , confirmButtonText: 'Ya, Tolak!'
      , cancelButtonText: 'Batal'
      , position: 'center'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(formId).submit();
      }
    });
  }

  // Global function untuk notifikasi validasi form
  function showValidationError(message) {
    Toast.fire({
      icon: 'error'
      , title: message
    });
  }

  // Global function untuk konfirmasi logout
  function confirmLogout(url) {
    event.preventDefault();
    Swal.fire({
      title: 'Keluar?'
      , text: "Anda akan keluar dari admin panel ini"
      , icon: 'question'
      , showCancelButton: true
      , confirmButtonColor: '#dc2626'
      , cancelButtonColor: '#6b7280'
      , confirmButtonText: 'Ya, Keluar!'
      , cancelButtonText: 'Batal'
      , position: 'center'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

</script>
