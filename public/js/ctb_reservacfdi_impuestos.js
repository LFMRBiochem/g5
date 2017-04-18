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
        newItem: {'impuesto': '', 'porcentaje': '', 'descripcion': '', 'id_reserva': ''},
        fillItem: {'impuesto': '', 'porcentaje': '', 'descripcion': '', 'id_reserva': '', 'id_impuesto': ''}
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
            this.$http.get('ctb_reservacfdiC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('ctb_reservacfdiC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'impuesto': '', 'porcentaje': '', 'descripcion': '', 'id_reserva': '', 'id_impuesto': ''};
                $("#create-item").modal('hide');
                toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('ctb_reservacfdiC/' + item.id_impuesto).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.id_impuesto = item.id_impuesto;
            this.fillItem.id_reserva = item.id_reserva;
            this.fillItem.descripcion = item.descripcion;
            this.fillItem.porcentaje = item.porcentaje;
            this.fillItem.impuesto = item.impuesto;
            $("#edit-item").modal('show');
        },
        updateItem: function (id_impuesto) {
            var input = this.fillItem;
            this.$http.put('ctb_reservacfdiC/' + id_impuesto, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'impuesto': '', 'porcentaje': '', 'descripcion': '', 'id_reserva': ''};
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
