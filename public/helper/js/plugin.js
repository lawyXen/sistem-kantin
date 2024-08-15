$("body").on("contextmenu", "img", function (e) {
    return false;
});
$('img').attr('draggable', false);
$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            // load_list(1);
        }
    });
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function loading(obj) {
    $(obj).prop('disabled', true);
    $(obj).attr('data-kt-indicator', 'on');
    $('#loadingOverlay').show();
}

function loaded(obj) {
    $(obj).prop('disabled', false);
    $(obj).removeAttr('data-kt-indicator');
    $('#loadingOverlay').hide();
}

function success_toastr(msg) {
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr.success(msg);
}

function error_toastr(msg) {
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr.warning(msg);
}

function info_toastr(msg) {
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr.info(msg);
}

function do_login(id_form, id_tombol, route, method) {
    $(document).one('submit', id_form, function (e) {
        e.preventDefault();
        let data = new FormData($(id_form)[0]);
        data.append('_method', method);
        $(id_tombol).prop("disabled", true);
        $(id_tombol).attr("data-kt-indicator", "on");
        loading(id_tombol);
        $.ajax({
            type: 'POST',
            url: route,
            data: data,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                // Jika ada proses sebelum pengiriman data
            },
            success: function (response) {
                loaded(id_tombol);
                if (response.alert === 'success') {
                    toastr.success(response.message, 'Success', {
                        timeOut: 2000
                    });
                    setTimeout(function () {
                        window.location.href = response.redirect_url;
                    }, 1000);
                } else {
                    toastr.error(response.message, 'Error', {
                        timeOut: 2000
                    });
                    setTimeout(function () {
                        $(id_tombol).prop("disabled", false);
                        $(id_tombol).removeAttr("data-kt-indicator");
                    }, 2000);
                }
            },
        });
        return false;
    });
}

function do_logout(id_tombol, route) {
    loading(id_tombol);
    $.ajax({
        type: 'POST',
        url: route,
        dataType: 'json',
        success: function (response) {
            loaded(id_tombol);
            if (response.alert === 'success') {
                toastr.success(response.message, 'Success', {
                    timeOut: 2000
                });
                setTimeout(function () {
                    window.location.href = response.redirect_url;
                }, 2000);
            } else {
                toastr.error(response.message, 'Error', {
                    timeOut: 2000
                });
            }
        }
    });
}

function save_data(id_form, id_tombol, route, method) {
    $(document).one('submit', id_form, function (e) {
        e.preventDefault();
        let data = new FormData($(id_form)[0]);
        data.append('_method', method);
        $(id_tombol).prop("disabled", true);
        $(id_tombol).attr("data-kt-indicator", "on");
        loading(id_tombol);
        $.ajax({
            type: 'POST',
            url: route,
            data: data,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                // Jika ada proses sebelum pengiriman data
            },
            success: function (response) {
                loaded(id_tombol);
                if (response.alert === 'success') {
                    toastr.success(response.message, 'Success', {
                        timeOut: 3000
                    });
                    setTimeout(function () {
                        window.location.href = response.redirect_url;
                    }, 2000);
                } else {
                    toastr.error(response.message, 'Error', {
                        timeOut: 3000
                    });
                    setTimeout(function () {
                        $(id_tombol).prop("disabled", false);
                        $(id_tombol).removeAttr("data-kt-indicator");
                    }, 2000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                loaded(id_tombol);
                toastr.error('Terjadi kesalahan, silakan coba lagi.', 'Error', {
                    timeOut: 3000
                });
                setTimeout(function () {
                    $(id_tombol).prop("disabled", false);
                    $(id_tombol).removeAttr("data-kt-indicator");
                }, 2000);
            }
        });
        return false;
    });
}

function handle_delete(url) {
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Konfirmasi Hapus Data',
        content: 'Apakah Anda Yakin Ingin Menghapus Data Tersebut?',
        theme: 'material',
        closeIcon: true,
        type: 'white',
        autoClose: 'No|5000',
        buttons: {
            Yes: {
                btnClass: 'btn-red any-other-class',
                action: function () {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.alert == 'success') {
                                toastr.success(response.message, 'Success', {
                                    timeOut: 3000
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                error_toastr(response.message);
                                location.reload();
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            error_toastr('Terjadi kesalahan, silakan coba lagi.');
                        }
                    });
                }
            },
            No: {
                btnClass: 'btn-blue' // Tombol No
            }
        }
    });
}

function searchFunction(url, querySelector, targetSelector) {
    var query = $(querySelector).val();
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            search: query
        },
        success: function (response) {
            $(targetSelector).html(response);
        }
    });
};

function cancelForm(route) {
    window.location.href = route;
}

function previewImage(event, selector) {
    var output = document.querySelector(selector);
    var reader = new FileReader();
    reader.onload = function () {
        output.src = reader.result;
        output.classList.remove('d-none');
    }
    reader.readAsDataURL(event.target.files[0]);
}

function handle_add_role(userId, content, url, method) {
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Tambah Role',
        content: content,
        theme: 'material',
        closeIcon: true,
        type: 'white',
        autoClose: 'No|5000',
        buttons: {
            Tambah: {
                btnClass: 'btn-primary any-other-class',
                action: function () {
                    var form = this.$content.find('form')[0];
                    form.user_id.value = userId; // Set the user_id value in the form
                    $.ajax({
                        type: method,
                        url: url, // Set the correct action URL
                        data: $(form).serialize(),
                        dataType: 'json',
                        success: function (response) {
                            if (response.alert == 'success') {
                                toastr.success(response.message, 'Success', {
                                    timeOut: 3000
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr.error(response.message, 'Error', {
                                    timeOut: 3000
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            toastr.error(jqXHR.responseJSON.message, 'Error', {
                                timeOut: 3000
                            });
                        }
                    });
                }
            },
            Batal: {
                btnClass: 'btn-secondary' // Tombol Batal
            }
        }
    });
}

function handle_remove_role(userId, roles, content, url, method) {
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Hapus Role',
        content: content,
        theme: 'material',
        closeIcon: true,
        type: 'white',
        autoClose: 'No|5000',
        onContentReady: function () {
            var form = this.$content.find('form')[0];
            form.user_id.value = userId; // Set the user_id value in the form
            var select = form.querySelector('#remove_role');
            roles.forEach(function (role) {
                var option = document.createElement('option');
                option.value = role;
                option.textContent = role;
                select.appendChild(option);
            });
        },
        buttons: {
            Hapus: {
                btnClass: 'btn-danger any-other-class',
                action: function () {
                    var form = this.$content.find('form')[0];
                    $.ajax({
                        type: method,
                        url: url,
                        data: $(form).serialize(),
                        dataType: 'json',
                        success: function (response) {
                            if (response.alert == 'success') {
                                toastr.success(response.message, 'Success', {
                                    timeOut: 3000
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr.error(response.message, 'Error', {
                                    timeOut: 3000
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            toastr.error(jqXHR.responseJSON.message, 'Error', {
                                timeOut: 3000
                            });
                        }
                    });
                }
            },
            Batal: {
                btnClass: 'btn-secondary' // Tombol Batal
            }
        }
    });
}

function modal_uploads(content, url, method) {
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Upload File',
        content: content,
        theme: 'material',
        closeIcon: true,
        type: 'white',
        autoClose: 'No|5000',
        buttons: {
            Upload: {
                btnClass: 'btn-primary any-other-class',
                action: function () {
                    var form = this.$content.find('form')[0];
                    var formData = new FormData(form);

                    $.ajax({
                        type: method,
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function (response) {
                            if (response.alert == 'success') {
                                toastr.success(response.message, 'Success', {
                                    timeOut: 3000
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr.error(response.message, 'Error', {
                                    timeOut: 3000
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            toastr.error(jqXHR.responseJSON.message, 'Error', {
                                timeOut: 3000
                            });
                        }
                    });
                }
            },
            Batal: {
                btnClass: 'btn-secondary'
            }
        }
    });
}

function modal_upload(content, url, method) {
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Upload File',
        content: content,
        theme: 'material',
        closeIcon: true,
        type: 'white',
        autoClose: 'No|5000',
        buttons: {
            Upload: {
                btnClass: 'btn-primary any-other-class',
                action: function () {
                    var form = this.$content.find('form')[0];
                    var formData = new FormData(form);

                    $.ajax({
                        type: method,
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function (response) {
                            if (response.alert == 'success') {
                                toastr.success(response.message, 'Success', {
                                    timeOut: 3000
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else if (response.alert == 'warning') {
                                toastr.warning(response.message, 'Warning', {
                                    timeOut: 5000
                                });
                            } else {
                                toastr.error(response.message, 'Error', {
                                    timeOut: 3000
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            toastr.error('Upload File Sesuai Template', 'Error', {
                                timeOut: 3000
                            });
                        }
                    });
                }
            },
            Batal: {
                btnClass: 'btn-secondary'
            }
        }
    });
}

function showImageModal(src) {
    var modal = document.getElementById("customModal");
    var modalImg = document.getElementById("modalImage");
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = src;
    captionText.innerHTML = modalImg.alt;
}

function closeImageModal() {
    var modal = document.getElementById("customModal");
    modal.style.display = "none";
}
