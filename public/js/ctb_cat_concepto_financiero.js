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
        newItem: {'cve_compania': '', 'cve_concepto_financiero': '','catalogo_sat': '','nombre_concepto': '', 'naturaleza':'', 'estatus':''},
        fillItem: {'cve_compania': '', 'cve_concepto_financiero': '','catalogo_sat': '','nombre_concepto': '', 'naturaleza':'', 'estatus':'', 'id_concepto_financiero':''}
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
            this.$http.get('ctb_cat_concepto_financieroC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('ctb_cat_concepto_financieroC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem =  {'cve_compania': '', 'cve_concepto_financiero': '','catalogo_sat': '','nombre_concepto': '', 'naturaleza':'', 'estatus':''};
                $("#create-item").modal('hide');
                toastr.success('Concepto financiero creado correctamente', 'Cambio realizado!', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('ctb_cat_concepto_financieroC/' + item.id_concepto_financiero).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Concepto financiero eliminado correctamente.', 'Cambio realizado!', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.cve_compania = item.cve_compania;
            this.fillItem.cve_concepto_financiero = item.cve_concepto_financiero;
            this.fillItem.catalogo_sat = item.catalogo_sat;
            this.fillItem.nombre_concepto = item.nombre_concepto;
            this.fillItem.naturaleza = item.naturaleza;
            this.fillItem.estatus = item.estatus;
            $("#edit-item").modal('show');
        },
        updateItem: function (cve_moneda) {
            var input = this.fillItem;
            this.$http.put('ctb_cat_concepto_financieroC/' + id_concepto_financiero, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem =  {'cve_compania': '', 'cve_concepto_financiero': '','catalogo_sat': '','nombre_concepto': '', 'naturaleza':'', 'estatus':''};
                $("#edit-item").modal('hide');
                toastr.success('Concepto financiero actualizado correctamente', 'Cambio realizado!', {timeOut: 5000});
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
