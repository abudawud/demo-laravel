<div>
    <x-adminlte-modal id="modalCRU" theme="primary" title="Loading...">
        <div>
            <div class="content-loading">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%"></div>
                </div>
            </div>
            <div class="content-main">
                <div style="display: none" class="content-error rounded bg-danger py-1 px-2 mb-2">
                </div>
                <div class="content-html"></div>
            </div>
        </div>
        <x-slot name="footerSlot">
        </x-slot>
    </x-adminlte-modal>

    <x-adminlte-modal id="modalD" theme="danger" title="Hapus {{ $title }}">
        <div id="modal-body">
            <div style="display: none" class="error-hint rounded bg-danger py-1 px-2 mb-2">
            </div>
            <form action="" method="post">
                {!! Form::token() !!}
                {!! Form::hidden('_method', 'DELETE') !!}
            </form>
            Apakah anda yakin ingin menghapus data ini ?
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button type="submit" theme="danger" label="Hapus" />
        </x-slot>
    </x-adminlte-modal>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('div.container-fluid').on('click', '.btn.modal-remote', function(e) {
                e.preventDefault();
                doXHR($(this).attr('href'), $(this).data());
            })

            function doXHR(url, data = []) {
                $.ajax({
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#modalCRU').find('.modal-title').html("Loading...");
                        $('#modalCRU').find('.content-loading').show();
                        $('#modalCRU').find('.content-html,.content-error,.modal-footer').empty();
                        $('#modalCRU').find('.modal-footer,.content-error').hide();
                        $('#modalCRU').find('.content-main').hide();
                        $('#modalCRU').modal('show');
                    },
                    success: function(data) {
                        $('#modalCRU').find('.modal-title').html(data.title);
                        $('#modalCRU').find('.content-loading').slideUp(200, function() {
                            $('#modalCRU').find('.content-html').html(data.content).slideDown();
                            if (data.footer != undefined) {
                                $('#modalCRU').find('.modal-footer').html(data.footer).show();
                            }
                            $('#modalCRU').find('.content-main').slideDown();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status == 401) {
                            window.location.reload();
                        } else {
                            $('#modalCRU').find('.modal-title').html(`Error ${xhr.status}`);
                            $('#modalCRU').find('.content-loading').slideUp(200, function() {
                                $('#modalCRU').find('.content-error').html(
                                    `<b>${xhr.statusText} (${xhr.status})</b><p>${xhr.responseText}</p>`
                                    ).show();
                                $('#modalCRU').find('.content-main').slideDown();
                            });
                        }
                    }
                });
            }

            $('#btn-reset').on('click', function() {
                $('#datatable thead tr.filter th input').val('').change();
                $('{{ $tableId }}').DataTable().search('').draw();
            });

            $('#modalCRU').on('click', 'button[type=submit]', function() {
                $('#modalCRU').find('form').submit();
            })

            $('{{ $tableId }} tbody,div.need-delete').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                $('#modalD').find('form').attr('action', $(this).attr('href'));
                $('#modalD').find('.error-hint').hide().empty();
                $('#modalD').modal('show');
            });


            $('#modalD').on('click', 'button[type=submit]', function(e) {
                e.preventDefault();
                const form = $('#modalD').find('form');
                const data = form.serialize();
                $.ajax({
                    url: form[0].action,
                    method: form[0].method,
                    data: data,
                    success: function(data) {
                        if (!$('{{ $tableId }}').DataTable) {
                            const redirect = $('div.need-delete').find('.btn-delete').data(
                                'redirect');
                            $('div.card-body,div.card-footer').slideUp();
                            if (!redirect) { // if no redirect url
                                alert("Berhasil menghapus record");
                            } else {
                                window.location = redirect;
                            }
                        } else {
                            $('{{ $tableId }}').DataTable().draw(false);
                            if (data.notification) {
                                toastr[data.notification.type](data.notification.message, data.notification.title);
                            }
                        }
                        $('#modalD').modal('hide');
                    },
                    beforeSend: function() {
                        $('#modalD').find('button[type=submit]').attr('disabled', true);
                        $('#modalD').find('.error-hint').hide().empty();
                    },
                    complete: function() {
                        $('#modalD').find('button[type=submit]').attr('disabled', false);
                    },
                    error: function(data) {
                        if (data.status == 401) {
                            window.location.reload();
                        } else {
                            $('#modalD').find('.error-hint').append(
                                `<b>${data.statusText} (${data.status})</b><br/><p>${data.responseText}`
                                );
                            $('#modalD').find('.error-hint').slideDown();
                        }
                    }
                });
            });

            $('#modalCRU').on('submit', 'form', function(e) {
                e.preventDefault();
                const form = $('#modalCRU').find('form');
                const data = form.serialize();

                $.ajax({
                    url: form[0].action,
                    method: form[0].method,
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        $('#modalCRU').modal('hide');
                        if (data.pjax) {
                            $.pjax.reload(data.pjax.container);
                        } else {
                            $('{{ $tableId }}').DataTable().draw(false);
                        }
                        if (data.notification) {
                            toastr[data.notification.type](data.notification.message, data.notification.title);
                        }
                    },
                    beforeSend: function() {
                        $('#modalCRU').find('.content-main').hide();
                        $('#modalCRU').find('.content-loading').show();
                        $('#modalCRU').find('button[type=submit]').attr('disabled', true);
                    },
                    error: function(data) {
                        $('#modalCRU div.content-error').empty();
                        if (data.status == 401) {
                            window.location.reload();
                        } else if (data.status == 422) {
                            const json = data.responseJSON;
                            $('#modalCRU div.content-error').append(`<b>Data tidak valid:</b>`);
                            $('#modalCRU div.content-error').append('<ul></ul>');
                            Object.values(json.errors)
                                .forEach(function(error) {
                                    error.forEach(function(item) {
                                        $('#modalCRU div.content-error > ul')
                                            .append(`<li>${item}</li>`)
                                    })
                                })
                        } else {
                            $('#modalCRU div.content-error').append(
                                `<b>(${data.status}) ${data.statusText}</b><br/><p>${data.responseText}`
                                );
                        }
                        $('#modalCRU').find('.content-loading').slideUp(200, function() {
                            $('#modalCRU').find(".content-main").slideDown();
                        });
                        $('#modalCRU').find('button[type=submit]').attr('disabled', false);
                        $('#modalCRU').stop().animate({
                            scrollTop: 0
                        }, 500, 'swing', function() {
                            $('#modalCRU div.content-error').slideDown();
                        });
                    }
                });
            });
        })
    </script>
@endpush
