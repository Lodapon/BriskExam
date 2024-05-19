$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click", "#deliver-new-address", function () {
        var newName = $("#newName").val();
        var newTel = $("#newTel").val();
        var newAddr = $("#newAddr").val();

        if (newName === "" || newTel === "" || newAddr === "") {
            Swal.fire({
                title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                icon: 'warning',
                confirmButtonText: `ตรวจสอบ`,
                allowOutsideClick: true
            })
        } else {
            updateAddress(newName, newTel, newAddr);
        }
    });

    $(document).on("click", "#deliver-old-address", function () {
        window.location.href = "/std/bookshop/payment"
    });

});

function updateAddress(name, phone, addr) {
    $.ajax({
        method: "put",
        url: "/std/bookshop/delivery/save",
        data: JSON.stringify({name: name, phone: phone, addr: addr}),
        contentType: 'application/json',
        success: function(response) {
            window.location.href = "/std/bookshop/payment"
        }
    });
}



