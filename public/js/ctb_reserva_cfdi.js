Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
new Vue({
    el: '#manage-vue',
    data: {
        items: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,
        formErrors: {},
        formErrorsUpdate: {},
        newItem: {
            'cve_compania': '', 'UUID': '', 'rfc': '', 'total': '',
            'nombre_proveedor': '', 'folio': '', 'subtotal': '',
            'descuento': '', 'metodo_pago': '', 'cve_moneda': '', 'error_suma': '',
            'descripcion': '', 'asociado': ''
        },
        fillItem: {
            'cve_compania': '', 'UUID': '', 'rfc': '', 'total': '',
            'nombre_proveedor': '', 'folio': '', 'subtotal': '',
            'descuento': '', 'metodo_pago': '', 'cve_moneda': '', 'error_suma': '',
            'descripcion': '', 'asociado': '', 'id_reserva': ''
        }
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    ready: function () {
        this.getVueItems(this.pagination.current_page);
    },
    methods: {
        getVueItems: function (page) {
            this.$http.get('ctb_reserva_cfdiC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('ctb_reserva_cfdiC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'cve_compania': '', 'UUID': '', 'rfc': '', 'total': '',
                    'nombre_proveedor': '', 'folio': '', 'subtotal': '',
                    'descuento': '', 'metodo_pago': '', 'cve_moneda': '', 'error_suma': '',
                    'descripcion': '', 'asociado': ''
                };
                $("#create-item").modal('hide');
                toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('ctb_reserva_cfdiC/' + item.id_reserva).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.UUID = item.UUID;
            this.fillItem.cve_compania = item.cve_compania;
            this.fillItem.id_reserva = item.id_reserva;
            this.fillItem.rfc = item.rfc;

            this.fillItem.total = item.total;
            this.fillItem.nombre_proveedor = item.nombre_proveedor;
            this.fillItem.folio = item.folio;
            this.fillItem.subtotal = item.subtotal;
            this.fillItem.descuento = item.descuento;

            this.fillItem.metodo_pago = item.metodo_pago;
            this.fillItem.cve_moneda = item.cve_moneda;
            this.fillItem.error_suma = item.error_suma;
            this.fillItem.descripcion = item.descripcion;
            this.fillItem.asociado = item.asociado;


            $("#edit-item").modal('show');
        },
        updateItem: function (id_reserva) {
            var input = this.fillItem;
            this.$http.put('ctb_reserva_cfdiC/' + id_reserva, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'cve_compania': '', 'UUID': '', 'rfc': '', 'total': '',
                    'nombre_proveedor': '', 'folio': '', 'subtotal': '',
                    'descuento': '', 'metodo_pago': '', 'cve_moneda': '', 'error_suma': '',
                    'descripcion': '', 'asociado': ''
                };
                $("#edit-item").modal('hide');
                toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        changePage: function (page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }
    }
});
