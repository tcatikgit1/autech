import {
    checkFailStatus,
    standardAjaxResponse,
    standardAjaxResponseTimer
} from '@/custom/custom-form-ajax-response.js';
import { initDatatable } from '@/custom/custom-datatable.js';

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let datatableClass = 'datatable';
    let columns = [
        // columns according to JSON
        { data: '_id' },
        { data: '_id' },
        { data: 'titulo' },
        { data: 'updated_at' },
        { data: 'estado' },
        { data: 'action' }
    ];

    let columnDefs = [
        {
            // For Responsive
            className: 'control',
            searchable: false,
            orderable: false,
            responsivePriority: 2,
            targets: 0,
            render: function (data, type, full, meta) {
                return '';
            }
        },
        {
            // For Checkboxes
            targets: 1,
            orderable: false,
            checkboxes: {
                selectAllRender: '<input type="checkbox" class="form-check-input">'
            },
            render: function () {
                return '<input type="checkbox" class="dt-checkboxes form-check-input" >';
            },
            searchable: false
        },
        {
            // title
            targets: 2,
            render: function (data, type, full, meta) {
                if (data == undefined || data == '' || data == null) {
                    return '-';
                }

                let rutaGateway = 'https://api-gateway.autonomous.tcatik.es';
                let fullImg = full.imagen != null ? `${rutaGateway}${full.imagen}` : 'https://placehold.co/80x80';
                let html = `
                <div class="d-flex justify-content-start align-items-center user-name">
                    <div class="avatar-wrapper me-2">
                        <div class="avatar me-2">
                            <img src="${fullImg}"
                                alt="Avatar"
                                class="rounded-circle border border-2 ${full.estado ? "border-primary" : "border-danger" }">
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                      <span class="emp_name text-truncate">${data}</span>
                    </div>
                </div>
                `;

                return html;
            }
        },
        {
            // updated_at
            targets: 3,
            render: function (data, type, full, meta) {
                if (data == undefined || data == '' || data == null) {
                    return '-';
                }

                let formatedDate = new Date(data).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    timeZoneName: 'short'
                });
                return formatedDate;
            }
        },
        {
            // Status
            targets: 4,
            render: function (data, type, full, meta) {
                var roleBadgeObj = {
                    true: '<i class="ti ti-check ti-md text-success"></i>',
                    false: '<i class="ti ti-x ti-md text-danger"></i>',
                };
                return (
                    `<span class='suspend-record btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill' data-id="${full._id}" data-suspend="${full.estado}">
                    ${roleBadgeObj[data]}
                    </span>`
                );
            }
        },
        {
            // Actions
            targets: -1,
            title: 'Actions',
            searchable: false,
            orderable: false,
            render: function (data, type, full, meta) {
                let suspendText = full.is_blocked ? 'Activate' : 'Suspend';
                let suspendIcon = full.is_blocked ? 'lock-open' : 'lock';
                return `
                        <div class="d-flex align-items-center">
                            <a href="professions/view/${full._id}" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill">
                                <i class="ti ti-eye ti-md"></i>
                            </a>
                            <a href="professions/edit/${full._id}" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill">
                                <i class="ti ti-edit ti-md"></i>
                            </a>
                            <a href="javascript:;"
                                class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end m-0">
                                <a href="javascript:;" class="dropdown-item suspend-record text-warning" data-id="${full._id}"
                                data-suspend="${full.estado}">
                                    <i class="ti ti-${suspendIcon} ti-md"></i> ${suspendText}
                                </a>
                                <a href="javascript:;" class="dropdown-item delete-record text-danger" data-id="${full._id}">
                                    <i class="ti ti-trash ti-md"></i> Delete
                                </a>
                            </div>
                        </div>
                        `;
            }
        }
    ];

    let options = {
        ajax: {
            url: '/professions/getDataJson'
        },
        filters: [
            {
                column: 2,
                type: 'input',
                selector: '.filter-titulo',
                placeholder: 'Title'
            },
            {
                column: 3,
                type: 'input',
                selector: '.filter-status',
                placeholder: 'Status'
            },
            {
                column: 6,
                type: 'select',
                selector: '.filter-active',
                placeholder: 'Select state',
                options: [
                    {
                        value: true,
                        text: 'Inactive'
                    },
                    {
                        value: false,
                        text: 'Active'
                    }
                ]
            }
        ],
        order: {
            column: 2,
            direction: 'asc'
        },
        buttons: {
            add: {
                text: 'Add new profession',
                url: '/professions/new'
            }
        }
    };

    initDatatable(columns, columnDefs, datatableClass, options);
    initDeleteButton(datatableClass); // Delete Record

    function initDeleteButton(datatableClass) {
        $('.datatable tbody').on('click', '.delete-record', function () {
            let id = $(this).data('id');
            deleteProfession(id);
        });
    }

    function initSuspendButton(datatableClass) {
        $('.datatable tbody').on('click', '.suspend-record', function () {
            let id = $(this).data('id');
            let suspend = $(this).data('suspend');
            suspendProfession(id, suspend);
        });
    }

    function deleteProfession(id) {
        Swal.fire({
            title: 'Delete record',
            text: 'Do you want to delete the record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            customClass: {
                confirmButton: 'btn btn-danger waves-effect waves-light',
                cancelButton: 'btn btn-secondary waves-effect waves-light'
            }
        }).then(result => {

            if (result.isConfirmed) {
                $.ajax({
                    url: `/professions/delete/${id}`,
                    method: `DELETE`
                })
                    .done(response => {
                        if (!response.done) {
                            Swal.fire({
                                title: 'Error',
                                text: response.mensaje,
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-danger waves-effect waves-light',
                                }
                            });
                            return;
                        }
                        let dataTable = $(`.datatable`);
                        dataTable.DataTable().ajax.reload();
                        standardAjaxResponseTimer(response.titulo, response.mensaje);
                    })
                    .fail(error => {
                        checkFailStatus(error);
                    })
                    .always(() => {
                        //$("#spinner-loading").fadeOut();
                    });
            }
        });
    }

    function suspendProfession(id, suspend) {
        let title, text, btnText;

        if (suspend) {
            title = 'Suspend profession';
            text = 'Do you want to suspend the profession?';
            btnText = 'Yes, suspend';
        } else {
            title = 'Activate profession';
            text = 'Do you want to activate the profession?';
            btnText = 'Yes, activate';
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: btnText,
            customClass: {
                confirmButton: 'btn btn-warning waves-effect waves-light',
                cancelButton: 'btn btn-secondary waves-effect waves-light'
            }
        }).then(result => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `/professions/suspend/${id}`,
                    method: `POST`
                })
                    .done(response => {
                        let dataTable = $(`.datatable`);
                        dataTable.DataTable().ajax.reload();
                        standardAjaxResponseTimer(response.titulo, response.mensaje);
                    })
                    .fail(error => {
                        checkFailStatus(error);
                    })
                    .always(() => {
                        //$("#spinner-loading").fadeOut();
                    });
            }
        });
    }

    initSuspendButton(datatableClass); // Delete Record
});
