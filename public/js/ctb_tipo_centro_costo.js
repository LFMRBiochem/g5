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
        newItem: {'tipo_cc': '', 'cve_tipoCentroCosto': ''},
        fillItem: {'tipo_cc': '', 'cve_tipoCentroCosto': ''}
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
            this.$http.get('ctb_tipos_centrosC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('ctb_tipos_centrosC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'tipo_cc': '', 'cve_tipoCentroCosto': ''};
                $("#create-item").modal('hide');
                toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('ctb_tipos_centrosC/' + item.cve_tipoCentroCosto).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.cve_tipoCentroCosto = item.cve_tipoCentroCosto;
            this.fillItem.tipo_cc = item.tipo_cc;
            $("#edit-item").modal('show');
        },
        updateItem: function (cve_tipoCentroCosto) {
            var input = this.fillItem;
            this.$http.put('ctb_tipos_centrosC/' + cve_tipoCentroCosto, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'tipo_cc': '', 'cve_tipoCentroCosto': ''};
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
