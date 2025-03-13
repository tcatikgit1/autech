import {
    checkFailStatus,
    standardAjaxResponseTimer
} from '@/custom/custom-form-ajax-response.js';
import { initDatatable } from '@/custom/custom-datatable.js';

$(function() {
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
        { data: 'nombre' },
        { data: 'apellidos' },
        { data: 'email' },
        { data: 'telefono' },
        { data: 'is_blocked' },
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
            // Name
            targets: 2,
            render: function (data, type, full, meta) {

                let rutaGateway = 'https://api-gateway.autonomous.tcatik.es';
                let avatar = full.avatar != null ? (rutaGateway + full.avatar) : '/assets/img/icons/forms/user.png'
                let html = `
                <div class="d-flex justify-content-start align-items-center user-name">
                    <div class="avatar-wrapper">
                        <div class="avatar me-2">
                            <img src="${avatar}" alt="Avatar" class="rounded-circle">
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                      <span class="emp_name text-truncate">${data}</span>
<!--                      <small class="emp_post text-truncate text-muted">Cost Accountant</small>-->
                    </div>
                </div>
                `;
                return html;
                // if(data == undefined || data == ''){
                //     return '-'
                // }
                // return data;
            }
        },
        {
            // Lastname
            targets: 3,
            render: function (data, type, full, meta) {
                if(data == undefined || data == '' || data == null){
                    return '-'
                }
                return data;
            }
        },
        {
            // Email
            targets: 4,
            render: function (data, type, full, meta) {
                if(data == undefined || data == '' || data == null){
                    return '-'
                }
                return data;
            }
        },
        {
            // User Role
            targets: 6,
            render: function (data, type, full, meta) {
                var roleBadgeObj = {
                    false: '<i class="ti ti-check ti-md text-success"></i>',
                    true: '<i class="ti ti-x ti-md text-danger"></i>',
                };
                return (
                    `<span class='suspend-record btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill' data-id="${full._id}" data-suspend="${full.is_blocked}">
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
                return (
                    `
                        <div class="d-flex align-items-center">
                        <a href="employees/view/${full._id}" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill"><i class="ti ti-eye ti-md"></i></a>
                        <a href="employees/edit/${full._id}" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill"><i class="ti ti-edit ti-md"></i></a>
                        <a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-md"></i></a>

                        <div class="dropdown-menu dropdown-menu-end m-0">
                        <a href="javascript:;" class="dropdown-item suspend-record text-warning" data-id="${full._id}" data-suspend="${full.is_blocked}"><i class="ti ti-${suspendIcon} ti-md"></i> ${suspendText}</a>
                        <a href="javascript:;" class="dropdown-item delete-record text-danger" data-id="${full._id}"><i class="ti ti-trash ti-md"></i> Delete</a>

                        </div></div>
                        `
                );
            }
        }
    ];

    let options = {
        ajax: {
            url: 'employees/getDataJson',
        },
        filters: [
            {
                column: 2,
                type: 'input',
                selector: '.filter-name',
                placeholder: 'Name',
            },
            {
                column: 3,
                type: 'input',
                selector: '.filter-surname',
                placeholder: 'Surname',
            },
            {
                column: 4,
                type: 'input',
                selector: '.filter-email',
                placeholder: 'Email',
            },
            {
                column: 5,
                type: 'input',
                selector: '.filter-phone',
                placeholder: 'Phone',
            },
            {
                column: 6,
                type: 'select',
                selector: '.filter-active',
                placeholder: 'Select state',
                options: [
                    {
                        value: true,
                        text: 'Inactive',
                    },
                    {
                        value: false,
                        text: 'Active',
                    }
                ]
            },
        ],
        order:{
            column: 2,
            direction: 'asc'
        },
        buttons:{
            add: {
                text: 'Add new employee',
                url: '/board/employees/new'
            }
        }
    }

    initDatatable(columns, columnDefs, datatableClass, options);
    initDeleteButton(datatableClass);   // Delete Record
    initSuspendButton(datatableClass);  // Suspend Record

    function initDeleteButton(datatableClass){
        $('.datatable tbody').on('click', '.delete-record', function () {
            let id = $(this).data('id');
            deleteUser(id);
        });
    }

    function initSuspendButton(datatableClass){
        $('.datatable tbody').on('click', '.suspend-record', function () {
            let id = $(this).data('id');
            let suspend = $(this).data('suspend');
            suspendUser(id, suspend);
        });
    }

    function deleteUser(id){

        Swal.fire({
            title: "Delete record",
            text: "Do you want to delete the record?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete",
            customClass: {
                confirmButton: 'btn btn-danger waves-effect waves-light',
                cancelButton: 'btn btn-secondary waves-effect waves-light'
            },
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `/board/employees/delete/${id}`,
                    method: `POST`,
                })
                    .done((response) => {
                        let dataTable = $(`.datatable`);
                        dataTable.DataTable().ajax.reload();
                        standardAjaxResponseTimer(response.titulo, response.mensaje);
                    })
                    .fail((error) => {
                        checkFailStatus(error);
                    })
                    .always(() => {
                        //$("#spinner-loading").fadeOut();
                    });
            }


        });
    }

    function suspendUser(id, suspend){

        let title, text, btnText;

        if(suspend){    // Empleado desactivado quieren activarlo
            title = 'Activate employee';
            text = 'Do you want to activate the employee?';
            btnText = 'Yes, activate';
        }else{
            title = 'Suspend employee';
            text = 'Do you want to suspend the employee?';
            btnText = 'Yes, suspend';
        }

        Swal.fire({
            title: title,
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: btnText,
            customClass: {
                confirmButton: 'btn btn-warning waves-effect waves-light',
                cancelButton: 'btn btn-secondary waves-effect waves-light'
            },
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `/board/employees/suspend/${id}`,
                    method: `POST`,
                })
                    .done((response) => {
                        let dataTable = $(`.datatable`);
                        dataTable.DataTable().ajax.reload();
                        standardAjaxResponseTimer(response.titulo, response.mensaje);
                    })
                    .fail((error) => {
                        checkFailStatus(error);
                    })
                    .always(() => {
                        //$("#spinner-loading").fadeOut();
                    });
            }


        });
    }
});


