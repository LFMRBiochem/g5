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
        newItem: {'nombre_banco': '', 'razon_social': ''},
        fillItem: {'nombre_banco': '', 'razon_social': '','cve_banco':''}
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
            this.$http.get('nmn_sat_catbancoC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('nmn_sat_catbancoC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'nombre_banco': '', 'razon_social': '','cve_banco':''};
                $("#create-item").modal('hide');
                toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('nmn_sat_catbancoC/' + item.cve_banco).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.cve_banco = item.cve_banco;
            this.fillItem.razon_social = item.razon_social;
            this.fillItem.nombre_banco = item.nombre_banco;
            $("#edit-item").modal('show');
        },
        updateItem: function (cve_banco) {
            var input = this.fillItem;
            this.$http.put('nmn_sat_catbancoC/' + cve_banco, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'nombre_banco': '', 'razon_social': ''};
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
