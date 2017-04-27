Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);

new Vue({
    el: '#manage-vue',
    data: {
        municipio_edit: null,
        localida_edit: null,
        codigo_postal_edit: null,

        selectedEntidad: null,
        selectedMunicipio: null,
        selectedLocalidad: null,
        selectedCodigo_postal: null,
        selectedBanco: null,
        selectedRazon_social: null,

        selectedEntidadEdit: null,
        selectedMunicipioEdit: null,
        selectedLocalidadEdit: null,
        selectedCodigo_postalEdit: null,
        selectedBancoEdit: null,
        selectedRazon_socialEdit: null,

        entidad: [],
        municipio: [],
        localidad: [],
        codigo_postal: [],
        banco: [],
        razon_social: [],

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
            'id_proveedor': '',
            'cve_compania': '',
            'id_centrocosto': '',
            'tipo_persona': '',
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
        fillItem: {
            'id_proveedor': '',
            'cve_compania': '',
            'id_centrocosto': '',
            'rfc': '',
            'tipo_persona': '',
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
        },
    },
    ready: function () {
        this.getVueItems(this.pagination.current_page);
        this.getEntidad();
        this.getBanco();
        this.getRazon_social();
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
                var data = val.value.split("|");

                this.newItem.Tipo_asentamiento = data[1];
                this.newItem.Asentamiento = data[2];
                this.newItem.Codigo_postal = data[0];
            } else {
                this.newItem.Asentamiento = '';
                this.newItem.Tipo_asentamiento = '';
                this.newItem.Codigo_postal = '';

            }

        },

        selectedRazon_social: function (val, oldVal) {
            if (val !== null) {
                this.newItem.razon_social = val.value;
            } else {
                this.newItem.razon_social = '';
            }

        },

        selectedBanco: function (val, oldVal) {
            if (val !== null) {
                this.newItem.id_banco = val.value;
            } else {
                this.newItem.id_banco = '';
            }

        },

///EDIT

        selectedEntidadEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.Cve_entidad = val.value;
// limpiar select
                this.municipio = [];
                this.selectedMunicipioEdit = null;
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;

                this.getMunicipio(val.value);

            } else {
                this.fillItem.Cve_entidad = '';
// limpiar select
                this.municipio = [];
                this.selectedMunicipioEdit = null;
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;
            }

        },

        selectedMunicipioEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.Cve_municipio = val.value;

                // limpiar select
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;

                this.getLocalidad(val.value, this.fillItem.Cve_entidad);
                this.getCodigo_postal(val.value, this.fillItem.Cve_entidad);
            } else {
                this.fillItem.Cve_municipio = '';

                // limpiar select
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;

            }
        },

        selectedLocalidadEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.Cve_localidad = val.value;
            } else {
                this.fillItem.Cve_localidad = '';

            }

        },
        selectedCodigo_postalEdit: function (val, oldVal) {
            if (val !== null) {
                var data = val.value.split("|");

                this.fillItem.Tipo_asentamiento = data[1];
                this.fillItem.Asentamiento = data[2];
                this.fillItem.Codigo_postal = data[0];
            } else {
                this.fillItem.Asentamiento = '';
                this.fillItem.Tipo_asentamiento = '';
                this.fillItem.Codigo_postal = '';

            }

        },

        selectedRazon_socialEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.razon_social = val.value;
            } else {
                this.fillItem.razon_social = '';
            }

        },

        selectedBancoEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.id_banco = val.value;
            } else {
                this.fillItem.id_banco = '';
            }

        },

    },
    methods: {
        razon_social_search: function (data) {
            if (data !== null || data !== '') {
                this.newItem.razon_social = '' + data;
            } else {
                this.newItem.razon_social = '';
            }
        },
        razon_social_searchEdit: function (data) {
            if (data !== null || data !== '') {
                this.fillItem.razon_social = '' + data;
            } else {
                this.fillItem.razon_social = '';
            }
        },

        getRazon_social: function () {
            this.$http.get('tabla_recurrente/razon_social').then((response) => {
                this.$set('razon_social', response.data);
            });
        },
        getBanco: function () {
            this.$http.get('tabla_recurrente/banco').then((response) => {
                this.$set('banco', response.data);
            });
        },
        getEntidad: function () {
            this.$http.get('tabla_recurrente/entidad').then((response) => {
                this.$set('entidad', response.data);
            });
        },
        getMunicipio: function (entidad) {
            this.$http.get('tabla_recurrente/municipio/' + entidad).then((response) => {
                this.$set('municipio', response.data);
                this.selectedMunicipioEdit = this.municipio_edit;
            });
        },
        getLocalidad: function (municipio, entidad) {
            this.$http.get('tabla_recurrente/localidad/' + municipio + '/' + entidad).then((response) => {
                this.$set('localidad', response.data);
                this.selectedLocalidadEdit = this.localida_edit;
            });
        },
        getCodigo_postal: function (municipio, entidad) {
            this.$http.get('tabla_recurrente/codigo_postal/' + municipio + '/' + entidad).then((response) => {
                this.$set('codigo_postal', response.data);
                this.selectedCodigo_postalEdit = this.codigo_postal_edit;
            });
        },
        getVueItems: function (page) {
            this.$http.get('cmp_cat_proveedoresC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        cleanItem: function () {
            this.formErrors = {};
            this.fillItem.Codigo_pais = '223';
            this.newItem.Codigo_pais = '223'
            this.selectedEntidad = null;
            this.selectedMunicipio = null;
            this.selectedLocalidad = null;
            this.selectedCodigo_postal = null;
            this.selectedBanco = null;
            this.selectedRazon_social = null;
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('cmp_cat_proveedoresC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'id_proveedor': '',
                    'cve_compania': '',
                    'id_centrocosto': '',
                    'tipo_persona': '',
                    'rfc': '',
                    'razon_social': '',
                    'Codigo_pais': '223',
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
                toastr.success('Guardado con éxito !!!', 'Proveedor', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;

            });
        },
        deleteItem: function (item) {
            this.$http.delete('cmp_cat_proveedoresC/' + item.id_proveedor).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Cancelado con éxito !!!', 'Proveedor', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            this.formErrors = {};
            this.$http.get('cmp_cat_proveedores/edit/' + item.id_proveedor).then((response) => {
                this.fillItem.id_proveedor = response.data.id_proveedor;
                this.fillItem.Codigo_pais = '223';
                this.selectedRazon_socialEdit = {value: response.data.razon_social, label: response.data.razon_social.replace("|", " ")};
                this.fillItem.rfc = response.data.rfc;
                this.selectedEntidadEdit = {value: response.data.Cve_entidad, label: response.data.Estado};
                this.municipio_edit = {value: response.data.Cve_municipio, label: response.data.Nom_municipio};
                this.localida_edit = {value: response.data.Cve_localidad, label: response.data.Nom_localidad};
                this.codigo_postal_edit = {value: response.data.Codigo_postal + '|' + response.data.Tipo_asentamiento + '|' + response.data.Asentamiento, label: '[' + response.data.Codigo_postal + '] ' + response.data.Tipo_asentamiento + ', ' + response.data.Asentamiento};
                this.fillItem.telefonos = item.telefonos;
                this.fillItem.email = item.email;
                this.fillItem.tipo_persona = item.tipo_persona;
                this.fillItem.limite_credito = item.limite_credito;
                this.fillItem.estatus = item.estatus;
                this.fillItem.origen_bienes = response.data.origen_bienes;
                this.fillItem.dias_credito = item.dias_credito;
                this.fillItem.atencion_pagos = item.atencion_pagos;
                this.fillItem.CLABE = item.CLABE;
                this.fillItem.atencion_ventas = item.atencion_ventas;
                this.selectedBancoEdit = {value: response.data.id_banco, label: response.data.nom_corto_banco};

            });
            $("#edit-item").modal('show');
        },
        updateItem: function (id_proveedor) {
            var input = this.fillItem;
            this.$http.put('cmp_cat_proveedoresC/' + id_proveedor, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {'id_proveedor': '',
                    'cve_compania': '',
                    'id_centrocosto': '',
                    'tipo_persona': '',
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
                $("#edit-item").modal('hide');
                toastr.success('Actualizado con éxito !!!', 'Proveedor', {timeOut: 5000});
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
