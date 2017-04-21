Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#manage-vue',
    data: {
        selectedEntidad: null,
        selectedMunicipio: null,
        selectedLocalidad: null,
        selectedCodigo_postal: null,
        
        entidad: [],
        municipio: [],
        localidad: [],
        codigo_postal: [],
        
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
        newItem: {'id_proveedor': '',
            'cve_compania': '',
            'id_centrocosto': '',
            'rfc': '',
            'razon_social': '',
            'Codigo_pais': '',
            'Cve_entidad': '',
            'Cve_municipio': '',
            'Cve_localidad': '',
            'Codigo_postal': '',
            'Asentamiento': '',
            'Tipo_asentamiento': '',
            'telefonos': '',
            'email': '',
            'origen_bienes': '',
            'limite_credito': '',
            'dias_credito': '',
            'atencion_pagos': '',
            'atencion_ventas': '',
            'id_banco': '',
            'CLABE': '',
            'estatus': ''},
        fillItem: {'id_proveedor': '',
            'cve_compania': '',
            'id_centrocosto': '',
            'rfc': '',
            'razon_social': '',
            'Codigo_pais': '',
            'Cve_entidad': '',
            'Cve_municipio': '',
            'Cve_localidad': '',
            'Codigo_postal': '',
            'Asentamiento': '',
            'Tipo_asentamiento': '',
            'telefonos': '',
            'email': '',
            'origen_bienes': '',
            'limite_credito': '',
            'dias_credito': '',
            'atencion_pagos': '',
            'atencion_ventas': '',
            'id_banco': '',
            'CLABE': '',
            'estatus': ''}
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
        this.getEntidad();
    },
    watch: {

        selectedEntidad: function (val, oldVal) {
            if (val !== null) {
                this.newItem.Cve_entidad = val.value;
// limpiar select
                this.municipio = [];
                this.selectedMunicipio = null;
                this.localidad = [];
                this.selectedLocalidad = null;
                this.codigo_postal = [];
                this.selectedCodigo_postal = null;

                this.getMunicipio(val.value);
            } else {
                this.newItem.Cve_entidad = '';
// limpiar select
                this.municipio = [];
                this.selectedMunicipio = null;
                this.localidad = [];
                this.selectedLocalidad = null;
                this.codigo_postal = [];
                this.selectedCodigo_postal = null;
            }

        },
        selectedMunicipio: function (val, oldVal) {
            if (val !== null) {
                this.newItem.Cve_municipio = val.value;

                // limpiar select
                this.localidad = [];
                this.selectedLocalidad = null;
                this.codigo_postal = [];
                this.selectedCodigo_postal = null;

                this.getLocalidad(val.value, this.newItem.Cve_entidad);
                this.getCodigo_postal(val.value, this.newItem.Cve_entidad);
            } else {
                this.newItem.Cve_municipio = '';

                // limpiar select
                this.localidad = [];
                this.selectedLocalidad = null;
                this.codigo_postal = [];
                this.selectedCodigo_postal = null;

            }

        },
        selectedLocalidad: function (val, oldVal) {
            if (val !== null) {
                this.newItem.Cve_localidad = val.value;
            } else {
                this.newItem.Cve_localidad = '';

            }

        },
        selectedCodigo_postal: function (val, oldVal) {
            if (val !== null) {
                this.newItem.Codigo_postal = val.value;
            } else {
                this.newItem.Codigo_postal = '';

            }

        }

//        'newItem.Cve_entidad': function (val, oldVal) {
//            console.log(val.label);
//        },
    },
    methods: {
        getEntidad: function () {
            this.$http.get('cmp_cat_proveedores/entidad').then((response) => {
                this.$set('entidad', response.data);
            });
        },
        getMunicipio: function (entidad) {
            this.$http.get('cmp_cat_proveedores/municipio/' + entidad).then((response) => {
                this.$set('municipio', response.data);
            });
        },
        getLocalidad: function (municipio, entidad) {
            this.$http.get('cmp_cat_proveedores/localidad/' + municipio + '/' + entidad).then((response) => {
                this.$set('localidad', response.data);
            });
        },
        getCodigo_postal: function (municipio, entidad) {
            this.$http.get('cmp_cat_proveedores/codigo_postal/' + municipio + '/' + entidad).then((response) => {
                this.$set('codigo_postal', response.data);
            });
        },

        getVueItems: function (page) {
            this.$http.get('cmp_cat_proveedoresC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('cmp_cat_proveedoresC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'id_proveedor': '',
                    'cve_compania': '',
                    'id_centrocosto': '',
                    'rfc': '',
                    'razon_social': '',
                    'Codigo_pais': '',
                    'Cve_entidad': '',
                    'Cve_municipio': '',
                    'Cve_localidad': '',
                    'Codigo_postal': '',
                    'Asentamiento': '',
                    'Tipo_asentamiento': '',
                    'telefonos': '',
                    'email': '',
                    'origen_bienes': '',
                    'limite_credito': '',
                    'dias_credito': '',
                    'atencion_pagos': '',
                    'atencion_ventas': '',
                    'id_banco': '',
                    'CLABE': '',
                    'estatus': ''};
                $("#create-item").modal('hide');
                toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('cmp_cat_proveedoresC/' + item.id_proveedor).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.fillItem.id_proveedor = item.id_proveedor;
            this.fillItem.cve_compania = item.cve_compania;
            this.fillItem.id_centrocosto = item.id_centrocosto;
            this.fillItem.rfc = item.rfc;
            this.fillItem.razon_social = item.razon_social;
            this.fillItem.Codigo_pais = item.Codigo_pais;

            this.fillItem.Cve_entidad = item.Cve_entidad;
            this.fillItem.Cve_municipio = item.Cve_municipio;
            this.fillItem.Cve_localidad = item.Cve_localidad;
            this.fillItem.Codigo_postal = item.Codigo_postal;
            this.fillItem.Asentamiento = item.Asentamiento;
            this.fillItem.Tipo_asentamiento = item.Tipo_asentamiento;

            this.fillItem.telefonos = item.telefonos;
            this.fillItem.email = item.email;
            this.fillItem.origen_bienes = item.origen_bienes;
            this.fillItem.limite_credito = item.limite_credito;
            this.fillItem.dias_credito = item.dias_credito;
            this.fillItem.atencion_pagos = item.atencion_pagos;

            this.fillItem.atencion_ventas = item.atencion_ventas;
            this.fillItem.id_banco = item.id_banco;
            this.fillItem.CLABE = item.CLABE;
            $("#edit-item").modal('show');
        },
        updateItem: function (id_proveedor) {
            var input = this.fillItem;
            this.$http.put('cmp_cat_proveedoresC/' + id_proveedor, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'id_proveedor': '',
                    'cve_compania': '',
                    'id_centrocosto': '',
                    'rfc': '',
                    'razon_social': '',
                    'Codigo_pais': '',
                    'Cve_entidad': '',
                    'Cve_municipio': '',
                    'Cve_localidad': '',
                    'Codigo_postal': '',
                    'Asentamiento': '',
                    'Tipo_asentamiento': '',
                    'telefonos': '',
                    'email': '',
                    'origen_bienes': '',
                    'limite_credito': '',
                    'dias_credito': '',
                    'atencion_pagos': '',
                    'atencion_ventas': '',
                    'id_banco': '',
                    'CLABE': '',
                    'estatus': '', };
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
