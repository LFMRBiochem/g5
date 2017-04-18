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
        newItem: {'cve_compania': '', 'id_centrocosto': '', 'nombre_centrocosto': '', 'id_centrocosto_padre': '', 'cve_tipoCentroCosto': '', 'catalogo_sat': ''},
        fillItem: {'cve_compania': '', 'id_centrocosto': '', 'nombre_centrocosto': '', 'id_centrocosto_padre': '', 'cve_tipoCentroCosto': '', 'catalogo_sat': ''}
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
            this.$http.get('ctb_cat_centros_costoC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('ctb_cat_centros_costoC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem ={'cve_compania': '', 'id_centrocosto': '', 'nombre_centrocosto': '', 'id_centrocosto_padre': '', 'cve_tipoCentroCosto': '', 'catalogo_sat': ''};
                $("#create-item").modal('hide');
                toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('ctb_cat_centros_costoC/' + item.cve_compania).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.id_centrocosto = item.id_centrocosto;
            this.fillItem.nombre_centrocosto = item.nombre_centrocosto;
            this.fillItem.id_centrocosto_padre = item.id_centrocosto_padre;
            this.fillItem.cve_tipoCentroCosto = item.cve_tipoCentroCosto;
            this.fillItem.catalogo_sat = item.catalogo_sat;
            this.fillItem.cve_compania = item.cve_compania;
            $("#edit-item").modal('show');
        },
        updateItem: function (cve_compania) {
            var input = this.fillItem;
            this.$http.put('ctb_cat_centros_costoC/' + cve_compania, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = { 'id_centrocosto': '', 'nombre_centrocosto': '', 'id_centrocosto_padre': '', 'cve_tipoCentroCosto': '', 'catalogo_sat': ''};
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
