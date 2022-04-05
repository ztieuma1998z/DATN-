<script>window.jQuery || document.write('<script src="{{ asset('admins/src/js/vendor/jquery-3.3.1.min.js')}}"><\/script>')</script>
<script src="{{ asset('admins/plugins/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{ asset('admins/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('admins/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
<script src="{{ asset('admins/plugins/screenfull/dist/screenfull.js')}}"></script>
<script src="{{ asset('admins/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('admins/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('admins/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('admins/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('admins/plugins/moment/moment.js')}}"></script>
<script src="{{ asset('admins/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{ asset('admins/plugins/d3/dist/d3.min.js')}}"></script>
<script src="{{ asset('admins/plugins/c3/c3.min.js')}}"></script>
<script src="{{ asset('admins/js/tables.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('admins/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script src="{{ asset('admins/js/charts.js')}}"></script>
<script src="{{ asset('admins/dist/js/theme.min.js')}}"></script>
<script src="{{ asset('admins/dist/js/main.js')}}"></script>
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script src="{{ asset('admins/plugins/datedropper/datedropper.min.js')}}"></script>
<script src="{{ asset('admins/js/form-picker.js')}}"></script>

{{--jquery repeater--}}
<script src="{{ asset('admins/dist/js/jquery.repeater.js') }}"></script>
{{--notification--}}
<script src="{{ asset('admins/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
<script src="{{ asset('admins/js/alerts.js')}}"></script>
{{--end-notification--}}
{{--sweetalert2--}}
<script src="{{ asset('admins/dist/js/sweetalert2@9.min.js') }}"></script>
<script src="{{ asset('admins/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<script>
    $(function () {
        // Summernote
        $('.textarea').summernote()
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    })

    $(function () {
        @if(Session::has('success'))
            $.toast({
                text : "{{ Session::get('success') }}",
                showHideTransition : 'slide',
                bgColor : '#2dce89',
                textColor : '#fff',
                allowToastClose : true,
                hideAfter : 3000,
                textAlign : 'left',
                position : 'top-right',
                icon: "success"
            })
            {{ Session::put('success', null) }}
        @endif
        @if(Session::has('error'))
            $.toast({
                text : "{{ Session::get('error') }}",
                showHideTransition : 'slide',
                bgColor : '#f5365c',
                textColor : '#fff',
                allowToastClose : true,
                hideAfter : 3000,
                textAlign : 'left',
                position : 'top-right',
                icon: "error"
            })
            {{ Session::put('error', null) }}
        @endif
        @if(Session::has('warning'))
        $.toast({
            text : "{{ Session::get('warning') }}",
            showHideTransition : 'slide',
            bgColor : '#F7CA18',
            textColor : '#fff',
            allowToastClose : true,
            hideAfter : 3000,
            textAlign : 'left',
            position : 'top-right',
            icon: "warning"
        })
        {{ Session::put('warning', null) }}
        @endif
    })

</script>



