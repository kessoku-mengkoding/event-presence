@if (Session::has('message') || Session::has('error') || Session::has('info') || Session::has('warning'))
  <script>
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
    }

    @if (Session::has('message'))
      toastr.success("{{ session('message') }}");
    @endif

    @if (Session::has('error'))
      toastr.error("{{ session('error') }}");
    @endif

    @if (Session::has('info'))
      toastr.info("{{ session('info') }}");
    @endif

    @if (Session::has('warning'))
      toastr.warning("{{ session('warning') }}");
    @endif
  </script>
@endif
