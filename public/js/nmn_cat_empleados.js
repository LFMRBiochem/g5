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
            'cve_compania': '', 'num_empleado': '', 'nombre_empleado': '', 'primer_apellido': '',
            'segundo_apellido': '', 'codigo_pais': '', 'cve_entidad': '', 'cve_municipio': '',
            'cve_localidad': '', 'asentamiento': '', 'calle_domicilio': '', 'num_exterior': '',
            'num_interior': '', 'telefono_casa': '', 'telefono_celular': '', 'telefono_otro': '',
            'correo_electronico': '', 'rfc': '', 'curp': '', 'numero_seguro_social': '', 'id_centrocosto': '',
            'cve_banco': '', 'cuenta_bancaria': ''
        },
        fillItem: {
            'cve_compania': '', 'num_empleado': '', 'nombre_empleado': '', 'primer_apellido': '',
            'segundo_apellido': '', 'codigo_pais': '', 'cve_entidad': '', 'cve_municipio': '',
            'cve_localidad': '', 'asentamiento': '', 'calle_domicilio': '', 'num_exterior': '',
            'num_interior': '', 'telefono_casa': '', 'telefono_celular': '', 'telefono_otro': '',
            'correo_electronico': '', 'rfc': '', 'curp': '', 'numero_seguro_social': '', 'id_centrocosto': '',
            'cve_banco': '', 'cuenta_bancaria': '', 'id_empleado': ''
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
            this.$http.get('nmn_cat_empleadosC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('nmn_cat_empleadosC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'cve_compania': '', 'num_empleado': '', 'nombre_empleado': '', 'primer_apellido': '',
                    'segundo_apellido': '', 'codigo_pais': '', 'cve_entidad': '', 'cve_municipio': '',
                    'cve_localidad': '', 'asentamiento': '', 'calle_domicilio': '', 'num_exterior': '',
                    'num_interior': '', 'telefono_casa': '', 'telefono_celular': '', 'telefono_otro': '',
                    'correo_electronico': '', 'rfc': '', 'curp': '', 'numero_seguro_social': '', 'id_centrocosto': '',
                    'cve_banco': '', 'cuenta_bancaria': '', 'id_empleado': ''
                };
                $("#create-item").modal('hide');
                toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('nmn_cat_empleadosC/' + item.id_empleado).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.cve_compania = item.cve_compania;
            this.fillItem.num_empleado = item.num_empleado;

            this.fillItem.nombre_empleado = item.nombre_empleado;
            this.fillItem.primer_apellido = item.primer_apellido;

            this.fillItem.segundo_apellido = item.segundo_apellido;
            this.fillItem.codigo_pais = item.codigo_pais;
            this.fillItem.cve_entidad = item.cve_entidad;

            this.fillItem.cve_municipio = item.cve_municipio;
            this.fillItem.cve_localidad = item.cve_localidad;
            this.fillItem.asentamiento = item.asentamiento;

            this.fillItem.calle_domicilio = item.calle_domicilio;
            this.fillItem.num_exterior = item.num_exterior;
            this.fillItem.num_interior = item.num_interior;

            this.fillItem.telefono_casa = item.telefono_casa;
            this.fillItem.telefono_celular = item.telefono_celular;
            this.fillItem.telefono_otro = item.telefono_otro;

            this.fillItem.correo_electronico = item.correo_electronico;
            this.fillItem.rfc = item.rfc;
            this.fillItem.curp = item.curp;

            this.fillItem.numero_seguro_social = item.numero_seguro_social;
            this.fillItem.id_centrocosto = item.id_centrocosto;
            this.fillItem.cve_banco = item.cve_banco;
            this.fillItem.cuenta_bancaria = item.cuenta_bancaria;

            this.fillItem.id_empleado = item.id_empleado;
            $("#edit-item").modal('show');
        },
        updateItem: function (id_empleado) {
            var input = this.fillItem;
            this.$http.put('nmn_cat_empleadosC/' + id_empleado, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'cve_compania': '', 'num_empleado': '', 'nombre_empleado': '', 'primer_apellido': '',
                    'segundo_apellido': '', 'codigo_pais': '', 'cve_entidad': '', 'cve_municipio': '',
                    'cve_localidad': '', 'asentamiento': '', 'calle_domicilio': '', 'num_exterior': '',
                    'num_interior': '', 'telefono_casa': '', 'telefono_celular': '', 'telefono_otro': '',
                    'correo_electronico': '', 'rfc': '', 'curp': '', 'numero_seguro_social': '', 'id_centrocosto': '',
                    'cve_banco': '', 'cuenta_bancaria': ''
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
