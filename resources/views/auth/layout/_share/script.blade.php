<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>window.jQuery || document.write('<script src="{{asset('../admins/src/js/vendor/jquery-3.3.1.min.js')}}"><\/script>')</script>
<script src="{{asset('../admins/plugins/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('../admins/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('../admins/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('../admins/plugins/screenfull/dist/screenfull.js')}}"></script>
<script src="{{asset('../admins/dist/js/theme.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
