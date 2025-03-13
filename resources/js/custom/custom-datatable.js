/**
 * Archivo: custom-datatable.js
 * Versión: 1.1
 * Fecha: 30/08/2024
 * Autor: Juan José
 * Cambios: Se rehizo de 0 a la última versión 10 de datatable con Laravel 11.
 */

export function initDatatable(columns, columnDefs, datatableClass, options = null){

    let datatable = $(`.${datatableClass}`);

    let datatableObj = datatable.DataTable({
        ajax: {
            "url": `${options.ajax.url}`,
            // "headers": {
            //     "Authorization": `${options.ajax.authorization}`
            // },
        },
        serverSide: true,
        deferRender: true,
        columns: columns,
        columnDefs: columnDefs,
        order: [[options.order.column, options.order.direction]],
        dom:
            '<"row"' +
            '<"col-md-2"<"ms-n2"l>>' +
            '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0"fB>>' +
            '>t' +
            '<"row"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: '🔍 Search',
            paginate: {
                next: '<i class="ti ti-chevron-right ti-sm"></i>',
                previous: '<i class="ti ti-chevron-left ti-sm"></i>'
            }
        },
        // Buttons with Dropdown
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-label-secondary dropdown-toggle mx-4 waves-effect waves-light',
                text: '<i class="ti ti-upload me-2 ti-xs"></i>Export',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="ti ti-printer me-2" ></i>Print',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5],
                            // prevent avatar to be print
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        },
                        customize: function(win) {
                            //customize print view for dark
                            $(win.document.body)
                                .css('color', headingColor)
                                .css('border-color', borderColor)
                                .css('background-color', bodyBg);
                            $(win.document.body)
                                .find('table')
                                .addClass('compact')
                                .css('color', 'inherit')
                                .css('border-color', 'inherit')
                                .css('background-color', 'inherit');
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="ti ti-file-text me-2" ></i>Csv',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5],
                            // prevent avatar to be display
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5],
                            // prevent avatar to be display
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5],
                            // prevent avatar to be display
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    },
                    {
                        extend: 'copy',
                        text: '<i class="ti ti-copy me-2" ></i>Copy',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5],
                            // prevent avatar to be display
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                                            result = result + item.lastChild.firstChild.textContent;
                                        } else if (item.innerText === undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    }
                ]
            },
            {
                text: `<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">${options.buttons.add.text}</span>`,
                className: 'add-new btn btn-primary waves-effect waves-light',
                attr: {
                    onclick: `window.location.href='${options.buttons.add.url}'`,
                }
            }
        ],
        // For responsive popup
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return 'Details of ' + data['full_name'];
                    }
                }),
                type: 'column',
                renderer: function(api, rowIdx, columns) {
                    var data = $.map(columns, function(col, i) {
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                            ? '<tr data-dt-row="' +
                            col.rowIndex +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            '<td>' +
                            col.title +
                            ':' +
                            '</td> ' +
                            '<td>' +
                            col.data +
                            '</td>' +
                            '</tr>'
                            : '';
                    }).join('');

                    return data ? $('<table class="table"/><tbody />').append(data) : false;
                }
            }
        },
        initComplete: function() {

            let api = this.api();
            options.filters.forEach((item, index)=> {
                createFilter(api, item);
            });
        }
    });

    function createFilter(api, item){
        api
            .columns(item.column)
            .every(function() {
                var column = this;

                let html = ``;
                let input = null;
                var _changeInterval = null;
                let eventType = '';
                switch(item.type) {
                    case 'input':
                        html = `<input class="form-control" placeholder="${item.placeholder}">`
                        eventType = 'keyup';
                        break;
                    case 'select':
                        html = `<select class="form-select"><option value="">${item.placeholder}</option>`
                        item.options.forEach((item) => {
                            html += `<option value="${item.value}">${item.text}</option>`
                        });
                        html += `</select>`
                        eventType = 'change';
                        break;
                    case 'select2':
                        html = `<select class="form-select"><option value=""> ${item.placeholder} </option></select>`
                        break;
                    // case 'flatpickr':
                    //     html = `<input type="text" value="${defaultValue}" data-default="${defaultValue}" ${inputName}
                    //                         name="${titulo}" data-column="${filtro.column}"
                    //                         class="${filterClass} form-select custom-flatpickr pickatime-es"
                    //                         placeholder="Buscar por ${titulo}">`
                    //     break;
                    default:
                        html = `<input class="form-control"> ${item.placeholder} </input>`
                        break;
                }

                $(html)
                    .appendTo(item.selector)
                    .on(eventType, function() {
                        clearInterval(_changeInterval)
                        _changeInterval = setInterval(() => {
                            let val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val, true, false).draw();
                            clearInterval(_changeInterval)
                        }, 500);
                });
            });
    }

    function filterColumn(i, val) {
        if (i == 5) {
            var startDate = startDateEle.val(),
                endDate = endDateEle.val();
            if (startDate !== '' && endDate !== '') {
                $.fn.dataTableExt.afnFiltering.length = 0; // Reset datatable filter
                datatableObj.dataTable().fnDraw(); // Draw table after filter
                filterByDate(i, startDate, endDate); // We call our filter function
            }
            datatableObj.dataTable().fnDraw();
        } else {
            datatableObj.DataTable().column(i).search(val, false, true).draw();
        }
    }

}


