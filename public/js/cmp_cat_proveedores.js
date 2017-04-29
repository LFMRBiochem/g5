Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);

new Vue({
    el: '#manage-vue',
    data: {

        municipio_edit: null,
        localida_edit: null,
        codigo_postal_edit: null,

//Variables que nos ayudan en la verificacion del ---vue-select--- del formulario de crear cuando cambia de valor 
//y con el metodo watch a mandar el valor a su correspondiente variable se usa como variable bandera
//
// Ejemplo : cada que seleccionamos una entidad se nota el cambio en selectedEntidad 
// y con el watch cada que cambia se actualiza la variable newItem.Cve_entidad que 
// es la que se requiere para guardar el formulario
        selectedEntidad: null,
        selectedMunicipio: null,
        selectedLocalidad: null,
        selectedCodigo_postal: null,
        selectedBanco: null,
        selectedRazon_social: null,

//Variables que nos ayudan en la verificacion del ---vue-select--- del formulario de editar cuando cambia de valor 
//y con el metodo watch a mandar el valor a su correspondiente variable se usa como variable bandera
        selectedEntidadEdit: null,
        selectedMunicipioEdit: null,
        selectedLocalidadEdit: null,
        selectedCodigo_postalEdit: null,
        selectedBancoEdit: null,
        selectedRazon_socialEdit: null,

//Variables donde se guardan todas las entidades
        entidad: [],
        municipio: [],
        localidad: [],
        codigo_postal: [],
        banco: [],
        razon_social: [],

//Variable utilizada para el listado de la tabla 
        items: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,

//Variable utilizada para obtener los errores mandados por la validacion de los datos en la funcion de crear 
        formErrors: {},
//Variable utilizada para obtener los errores mandados por la validacion de los datos en la funcion de editar 
        formErrorsUpdate: {},
//Inicializamos los valores del formulario de crear
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
//Inicializamos los valores del formulario de editar       
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
    //El sistema desde el arranque inicia cargando estos metodos 
    ready: function () {
        // Manda llamar los datos para llenar la tabla
        this.getVueItems(this.pagination.current_page);
        // Carga los registros de las entidades
        this.getEntidad();
        // Carga catalago de bancos
        this.getBanco();
        // Carga las razones sociales
        this.getRazon_social();
    },
    // Valores que se estan monitorizados cada que cambia su valor 
    watch: {

        selectedEntidad: function (val, oldVal) {
            //Si el valor de la entidad es direfente a nulo
            if (val !== null) {
                // Mandamos a la variable Cve_entidad el valor que genera la seleccion de la entidad
                this.newItem.Cve_entidad = val.value;
                // Limpiamos el vue-select del municipio cada que cambia la entidad
                this.municipio = [];
                // Limpiamos el valor de la variable que manda el dato a municipio
                this.selectedMunicipio = null;
                // Limpiamos el vue-select del localidad cada que cambia la localidad
                this.localidad = [];
                // Limpiamos el valor de la variable que manda el dato a localidad
                this.selectedLocalidad = null;
                // Limpiamos el vue-select del codigo postal cada que cambia codigo postal
                this.codigo_postal = [];
                // Limpiamos el valor de la variable que manda el dato a codigo postal
                this.selectedCodigo_postal = null;

                // Arrancamos el metodo getMunicipio para traernos solo los municipios referentes a la entidad
                this.getMunicipio(val.value);

                // Si el valor de la entidad es direfente nulo
            } else {
                // Limpiamos el valor de newItem.Cve_entidad porque no se selecciono ninguna entidad
                this.newItem.Cve_entidad = '';
                // Limpiar vue-select del municipio
                this.municipio = [];
                // Limpiamos el valor de la variable que manda el dato a municipio
                this.selectedMunicipio = null;
                // Limpiar vue-select del localidad
                this.localidad = [];
                // Limpiamos el valor de la variable que manda el dato a localidad
                this.selectedLocalidad = null;
                // Limpiar vue-select del codigo postal
                this.codigo_postal = [];
                // Limpiamos el valor de la variable que manda el dato a codigo postal
                this.selectedCodigo_postal = null;
            }

        },

        //Cada que se modifica el municipio 
        selectedMunicipio: function (val, oldVal) {
            if (val !== null) {
                this.newItem.Cve_municipio = val.value;

                // Limpiamos los valores del localidad y codigo postal cuando cambia el muniipio
                this.localidad = [];
                this.selectedLocalidad = null;
                this.codigo_postal = [];
                this.selectedCodigo_postal = null;

                //Mandamos llamar el metodo de getLocalidad referente al municipio
                this.getLocalidad(val.value, this.newItem.Cve_entidad);
                //Mandamos llamar el metodo de getCodigo_postal referente al municipio
                this.getCodigo_postal(val.value, this.newItem.Cve_entidad);
            } else {
                this.newItem.Cve_municipio = '';

                // Limpiamos los valores del localidad y codigo postal cuando cambia el muniipio
                this.localidad = [];
                this.selectedLocalidad = null;
                this.codigo_postal = [];
                this.selectedCodigo_postal = null;

            }
        },

        // Cada que se modifica la localidad
        selectedLocalidad: function (val, oldVal) {
            if (val !== null) {
                this.newItem.Cve_localidad = val.value;
            } else {
                this.newItem.Cve_localidad = '';

            }

        },
        // cada que se modifica el codigo postal
        selectedCodigo_postal: function (val, oldVal) {
            if (val !== null) {
                // Separamos el codigo postal[0] | el tipo de asentamiento[1] | el nombre del asentamiento[2] 
                var data = val.value.split("|");

                // Acomodamos los valores en sus campos correspondientes
                this.newItem.Tipo_asentamiento = data[1];
                this.newItem.Asentamiento = data[2];
                this.newItem.Codigo_postal = data[0];
            } else {
                // Limpiamos los datos si no se tiene seleccionado ningun codigo postal
                this.newItem.Asentamiento = '';
                this.newItem.Tipo_asentamiento = '';
                this.newItem.Codigo_postal = '';

            }

        },
        // Cada que se selecciona una razon social con el vue-select
        selectedRazon_social: function (val, oldVal) {
            if (val !== null) {
                this.newItem.razon_social = val.value;
            } else {
                this.newItem.razon_social = '';
            }

        },
        // Cada que se selecciona un banco con el vue-select
        selectedBanco: function (val, oldVal) {
            if (val !== null) {
                this.newItem.id_banco = val.value;
            } else {
                this.newItem.id_banco = '';
            }

        },

        ///-------------    Variables del formulario editar    -------------///

        selectedEntidadEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.Cve_entidad = val.value;
                // Limpia los datos de los campos cada que se modifica la entidad del edit
                this.municipio = [];
                this.selectedMunicipioEdit = null;
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;

                // Arrancamos el metodo getMunicipio para traernos solo los municipios referentes a la entidad
                this.getMunicipio(val.value);

            } else {
                this.fillItem.Cve_entidad = '';
                // Limpia los datos de los campos cada que el valor de selectedEntidadEdit sea nulo, la entidad del edit
                this.municipio = [];
                this.selectedMunicipioEdit = null;
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;
            }

        },

        // 
        selectedMunicipioEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.Cve_municipio = val.value;

                // Limpiar los vue-select
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;

                //Mandamos llamar el metodo de getLocalidad referente al municipio
                this.getLocalidad(val.value, this.fillItem.Cve_entidad);
                //Mandamos llamar el metodo de getCodigo_postal referente al municipio
                this.getCodigo_postal(val.value, this.fillItem.Cve_entidad);

            } else {
                this.fillItem.Cve_municipio = '';

                // Limpiar los vue-select
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
                // Separamos el codigo postal[0] | el tipo de asentamiento[1] | el nombre del asentamiento[2] 
                var data = val.value.split("|");

                // Acomodamos los valores en sus campos correspondientes
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
        // Funcion para obtener la razon social
        getRazon_social: function () {
            this.$http.get('tabla_recurrente/razon_social').then((response) => {
                this.$set('razon_social', response.data);
            });
        },
        // Obtener el catalogo de bancos
        getBanco: function () {
            this.$http.get('tabla_recurrente/banco').then((response) => {
                this.$set('banco', response.data);
            });
        },
        // Obtener las entidades
        getEntidad: function () {
            this.$http.get('tabla_recurrente/entidad').then((response) => {
                this.$set('entidad', response.data);
            });
        },
        // Obtener los municipios referente a la entidad
        getMunicipio: function (entidad) {
            this.$http.get('tabla_recurrente/municipio/' + entidad).then((response) => {
                this.$set('municipio', response.data);
                this.selectedMunicipioEdit = this.municipio_edit;
            });
        },
        // Obtener las localidades referente a la entidad y el municipio
        getLocalidad: function (municipio, entidad) {
            this.$http.get('tabla_recurrente/localidad/' + municipio + '/' + entidad).then((response) => {
                this.$set('localidad', response.data);
                this.selectedLocalidadEdit = this.localida_edit;
            });
        },
        // Obtener los codigo de postal
        getCodigo_postal: function (municipio, entidad) {
            this.$http.get('tabla_recurrente/codigo_postal/' + municipio + '/' + entidad).then((response) => {
                this.$set('codigo_postal', response.data);
                this.selectedCodigo_postalEdit = this.codigo_postal_edit;
            });
        },
        // Obtener la lista de cmp_cat_proveedores
        getVueItems: function (page) {
            this.$http.get('cmp_cat_proveedoresC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        // Limpiar los valores de los errores y otros datos
        cleanItem: function () {
            this.newItem = {};
            this.formErrors = {};
            this.fillItem.Codigo_pais = '223';
            this.newItem.Codigo_pais = '223';
            this.selectedEntidad = null;
            this.selectedMunicipio = null;
            this.selectedLocalidad = null;
            this.selectedCodigo_postal = null;
            this.selectedBanco = null;
            this.selectedRazon_social = null;
        },
        // Crear nuevo proveedor
        createItem: function () {
            // Obtener los datos del formulario newItem
            var input = this.newItem;
            this.$http.post('cmp_cat_proveedoresC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                // Limpiamos las variables despues de insertar en la base de datos
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
                // Mensaje
                toastr.success('Guardado con éxito !!!', 'Proveedor', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;

            });
        },
        // Metodo para mandar a la funcion de destroy
        deleteItem: function (item) {
            this.$http.delete('cmp_cat_proveedoresC/' + item.id_proveedor).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Cancelado con éxito !!!', 'Proveedor', {timeOut: 5000});
            });
        },
        // Metodo para obtener los datos y mostrarlos en el modal edit
        editItem: function (item) {
            // Limpia los mensajes de errores
            this.formErrors = {};
            this.$http.get('cmp_cat_proveedores/edit/' + item.id_proveedor).then((response) => {

                // Manda los datos a sus respectivas variables despues de la consulta a la, base de datos
                this.fillItem.id_proveedor = response.data.id_proveedor;

                // Se deja por defecto el codigo del pais de mexico que corresponde al 223
                this.fillItem.Codigo_pais = '223';

                // Se inicializan las variables con la estructura de vue-select
                this.selectedRazon_socialEdit = {value: response.data.razon_social, label: response.data.razon_social.replace("|", " ")};
                this.selectedBancoEdit = {value: response.data.id_banco, label: response.data.nom_corto_banco};
                this.selectedEntidadEdit = {value: response.data.Cve_entidad, label: response.data.Estado};

                this.municipio_edit = {value: response.data.Cve_municipio, label: response.data.Nom_municipio};
                this.localida_edit = {value: response.data.Cve_localidad, label: response.data.Nom_localidad};
                this.codigo_postal_edit = {value: response.data.Codigo_postal + '|' + response.data.Tipo_asentamiento + '|' + response.data.Asentamiento, label: '[' + response.data.Codigo_postal + '] ' + response.data.Tipo_asentamiento + ', ' + response.data.Asentamiento};

                this.fillItem.rfc = response.data.rfc;
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

            });
            $("#edit-item").modal('show');
        },
        // Metodo para mandar actualizar 
        updateItem: function (id_proveedor) {
            // Se trae la informacion del formulario editar
            var input = this.fillItem;

            this.$http.put('cmp_cat_proveedoresC/' + id_proveedor, input).then((response) => {
                this.changePage(this.pagination.current_page);
                // Despues de actualizar limpia las variables
                this.newItem = {
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
                    'estatus': ''
                };
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
