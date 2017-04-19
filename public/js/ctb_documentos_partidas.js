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
        newItem: {'descripcion_complementaria': '', 'id_conceptofinanciero': '', 'num_partida': '','cantidad': '','cve_unidad_medida': '','precio_unitario': '','porcentaje_impuesto': '','porcentaje_descuento': '','subtotal': '','total_partida': ''},
        fillItem: {'descripcion_complementaria': '', 'id_conceptofinanciero': '', 'num_partida': '','cantidad': '','cve_unidad_medida': '','precio_unitario': '','porcentaje_impuesto': '','porcentaje_descuento': '','subtotal': '','total_partida': '', 'folio_documento': ''}
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
            this.$http.get('ctb_documentos_partidasC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('ctb_documentos_partidasC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'descripcion_complementaria': '', 'id_conceptofinanciero': '', 'num_partida': '','cantidad': '','cve_unidad_medida': '','precio_unitario': '','porcentaje_impuesto': '','porcentaje_descuento': '','subtotal': '','total_partida': '', 'folio_documento': ''};
                $("#create-item").modal('hide');
                toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('ctb_documentos_partidasC/' + item.folio_documento).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.folio_documento = item.folio_documento;
            this.fillItem.num_partida = item.num_partida;
            this.fillItem.id_conceptofinanciero = item.id_conceptofinanciero;
            this.fillItem.descripcion_complementaria = item.descripcion_complementaria;
            this.fillItem.cantidad = item.cantidad;
            this.fillItem.cve_unidad_medida = item.cve_unidad_medida;
            this.fillItem.precio_unitario = item.precio_unitario;
            this.fillItem.porcentaje_impuesto = item.porcentaje_impuesto;
            this.fillItem.porcentaje_descuento = item.porcentaje_descuento;
            this.fillItem.subtotal = item.subtotal;
            this.fillItem.total_partida = item.total_partida;
            
            $("#edit-item").modal('show');
        },
        updateItem: function (folio_documento) {
            var input = this.fillItem;
            this.$http.put('ctb_documentos_partidasC/' + folio_documento, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'descripcion_complementaria': '', 'id_conceptofinanciero': '', 'num_partida': '','cantidad': '','cve_unidad_medida': '','precio_unitario': '','porcentaje_impuesto': '','porcentaje_descuento': '','subtotal': '','total_partida': ''};
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
