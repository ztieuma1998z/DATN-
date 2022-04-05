$(document).ready(function(){
    $("#filter-table").click(function(){
        $("#form-filter-table").toggle("slow");
    });

    $('#example').DataTable( {
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu hiển thị",
            "info":           "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
            "infoEmpty":      "Đang xem 0 đến 0 trong tổng số 0 mục",
            "infoFiltered":   "(Lọc từ tổng số _MAX_ mục)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Xem _MENU_ mục",
            "loadingRecords": "Loading...",
            "processing":     "Processing...",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp",
                "previous":   "Trước"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    } );

    $('.display').DataTable( {
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu hiển thị",
            "info":           "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
            "infoEmpty":      "Đang xem 0 đến 0 trong tổng số 0 mục",
            "infoFiltered":   "(Lọc từ tổng số _MAX_ mục)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Xem _MENU_ mục",
            "loadingRecords": "Loading...",
            "processing":     "Processing...",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp",
                "previous":   "Trước"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    } );

});
