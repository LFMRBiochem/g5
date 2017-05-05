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

        selectedId_centrocosto: null,

//Variables que nos ayudan en la verificacion del ---vue-select--- del formulario de editar cuando cambia de valor
//y con el metodo watch a mandar el valor a su correspondiente variable se usa como variable bandera
        selectedEntidadEdit: null,
        selectedMunicipioEdit: null,
        selectedLocalidadEdit: null,
        selectedCodigo_postalEdit: null,
        selectedBancoEdit: null,
        selectedId_centrocostoEdit: null,

//Variables donde se guardan todas las entidades
        entidad: [],
        municipio: [],
        localidad: [],
        codigo_postal: [],
        banco: [],

        id_centrocosto: [],

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
            'num_empleado': '',
            'nombre_empleado': '',
            'primer_apellido': '',
            'segundo_apellido': '',
            'codigo_pais': '',
            'cve_entidad': '',
            'cve_municipio': '',
            'cve_localidad': '',
            'codigo_postal': '',
            'asentamiento': '',
            'tipo_asentamiento': '',
            'calle_domicilio': '',
            'num_exterior': '',
            'num_interior': '',
            'telefono_casa': '',
            'telefono_celular': '',
            'telefono_otro': '',
            'correo_electronico': '',
            'rfc': '',
            'curp': '',
            'numero_seguro_social': '',
            'id_centrocosto': '',
            'cve_banco': '',
            'cuenta_bancaria': '',
            'estatus': ''
        },
        fillItem: {
            'num_empleado': '',
            'nombre_empleado': '',
            'primer_apellido': '',
            'segundo_apellido': '',
            'codigo_pais': '',
            'cve_entidad': '',
            'cve_municipio': '',
            'cve_localidad': '',
            'codigo_postal': '',
            'asentamiento': '',
            'tipo_asentamiento': '',
            'calle_domicilio': '',
            'num_exterior': '',
            'num_interior': '',
            'telefono_casa': '',
            'telefono_celular': '',
            'telefono_otro': '',
            'correo_electronico': '',
            'rfc': '',
            'curp': '',
            'numero_seguro_social': '',
            'id_centrocosto': '',
            'cve_banco': '',
            'cuenta_bancaria': '',
            'estatus': ''
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
        // Manda llamar los datos para llenar la tabla
        this.getVueItems(this.pagination.current_page);
        // Carga los registros de las entidades
        this.getEntidad();
        // Carga catalago de bancos
        this.getBanco();
        // Carga las razones sociales
        this.getId_centrocosto();
    },

    watch: {

        selectedEntidad: function (val, oldVal) {
            //Si el valor de la entidad es direfente a nulo
            if (val !== null) {
                // Mandamos a la variable Cve_entidad el valor que genera la seleccion de la entidad
                this.newItem.cve_entidad = val.value;
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
                this.newItem.cve_entidad = '';
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
                this.newItem.cve_municipio = val.value;

                // Limpiamos los valores del localidad y codigo postal cuando cambia el muniipio
                this.localidad = [];
                this.selectedLocalidad = null;
                this.codigo_postal = [];
                this.selectedCodigo_postal = null;

                //Mandamos llamar el metodo de getLocalidad referente al municipio
                this.getLocalidad(val.value, this.newItem.cve_entidad);
                //Mandamos llamar el metodo de getCodigo_postal referente al municipio
                this.getCodigo_postal(val.value, this.newItem.cve_entidad);
            } else {
                this.newItem.cve_municipio = '';

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
                this.newItem.cve_localidad = val.value;
            } else {
                this.newItem.cve_localidad = '';

            }

        },
        // cada que se modifica el codigo postal
        selectedCodigo_postal: function (val, oldVal) {
            if (val !== null) {
                // Separamos el codigo postal[0] | el tipo de asentamiento[1] | el nombre del asentamiento[2]
                var data = val.value.split("|");

                // Acomodamos los valores en sus campos correspondientes
                this.newItem.tipo_asentamiento = data[1];
                this.newItem.asentamiento = data[2];
                this.newItem.codigo_postal = data[0];
            } else {
                // Limpiamos los datos si no se tiene seleccionado ningun codigo postal
                this.newItem.asentamiento = '';
                this.newItem.tipo_asentamiento = '';
                this.newItem.codigo_postal = '';

            }

        },
        // Cada que se selecciona una razon social con el vue-select
        selectedId_centrocosto: function (val, oldVal) {
            if (val !== null) {
                var cent_cost=val.value;
                var split_cc=cent_cost.split("@");
                var id_cc=split_cc[0];
                var n_emp=split_cc[1];
                var split_ne=n_emp.split("|");
                var second_apellido='';
                var name_empleado='';
                var first_apellido=split_ne[0];
                if(first_apellido!=''){
                    second_apellido=split_ne[1];
                    name_empleado=split_ne[2];
                }else{
                    first_apellido=split_ne[2];
                    second_apellido=split_ne[3];
                    name_empleado=split_ne[1];
                }
                this.newItem.nombre_empleado=name_empleado;
                this.newItem.primer_apellido=first_apellido;
                this.newItem.segundo_apellido=second_apellido;
                this.newItem.id_centrocosto = id_cc;

                val.label=name_empleado;

                $("#nombre_empleado").val(name_empleado);
                $("#primer_apellido").val(first_apellido);
                $("#segundo_apellido").val(second_apellido);

                this.getId_centrocosto();

            } else {
                this.newItem.id_centrocosto = '';
            }

        },
        // Cada que se selecciona un banco con el vue-select
        selectedBanco: function (val, oldVal) {
            if (val !== null) {
                this.newItem.cve_banco = val.value;
            } else {
                this.newItem.cve_banco = '';
            }

        },

        ///-------------    Variables del formulario editar    -------------///

        selectedEntidadEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.cve_entidad = val.value;
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
                this.fillItem.cve_entidad = '';
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
                this.fillItem.cve_municipio = val.value;

                // Limpiar los vue-select
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;

                //Mandamos llamar el metodo de getLocalidad referente al municipio
                this.getLocalidad(val.value, this.fillItem.cve_entidad);
                //Mandamos llamar el metodo de getCodigo_postal referente al municipio
                this.getCodigo_postal(val.value, this.fillItem.cve_entidad);
                //this.getCodigo_postalEdit(this.fillItem.cve_entidad, val.value, this.fillItem.asentamiento, this.fillItem.tipo_asentamiento);

            } else {
                this.fillItem.cve_municipio = '';

                // Limpiar los vue-select
                this.localidad = [];
                this.selectedLocalidadEdit = null;
                this.codigo_postal = [];
                this.selectedCodigo_postalEdit = null;
            }
        },

        selectedLocalidadEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.cve_localidad = val.value;
            } else {
                this.fillItem.cve_localidad = '';
            }
        },
        selectedCodigo_postalEdit: function (val, oldVal) {
            if (val !== null) {
                // Separamos el codigo postal[0] | el tipo de asentamiento[1] | el nombre del asentamiento[2]
                var data = val.value.split("|");
                // Acomodamos los valores en sus campos correspondientes
                this.fillItem.tipo_asentamiento = data[1];
                this.fillItem.asentamiento = data[2];
                this.fillItem.codigo_postal = data[0];
            } else {
                this.fillItem.asentamiento = '';
                this.fillItem.tipo_asentamiento = '';
                this.fillItem.codigo_postal = '';
            }
        },

        selectedId_centrocostoEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.id_centrocosto = val.value;
            } else {
                this.fillItem.id_centrocosto = '';
            }

        },
        selectedBancoEdit: function (val, oldVal) {
            if (val !== null) {
                this.fillItem.cve_banco = val.value;
            } else {
                this.fillItem.cve_banco = '';
            }
        },
    },

    methods: {
        id_centrocosto_search: function (data) {
            if (data !== null || data !== '') {
                this.newItem.id_centrocosto = '' + data;
                this.newItem.nombre_empleado = '' + data;
            } else {
                this.newItem.id_centrocosto = '';
            }
        },

        id_centrocosto_searchEdit: function (data) {
            if (data !== null || data !== '') {
                this.fillItem.id_centrocosto = '' + data;
            } else {
                this.fillItem.id_centrocosto = '';
            }
        },
        // Funcion para obtener la razon social
        getId_centrocosto: function () {
            this.$http.get('tabla_recurrente/id_centrocosto').then((response) => {
                this.$set('id_centrocosto', response.data);
            });
        },

        // Obtener el catalogo de bancos
        getBanco: function () {
            this.$http.get('tabla_recurrente/sat_banco').then((response) => {
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
         // Obtener los codigo de postal al Editar
        getCodigo_postalEdit: function (entidad,municipio,asentamiento,tipo_asentamiento) {
            this.$http.get('nmn_cat_empleados/cp/' + entidad + '/' + municipio + '/' + asentamiento + '/' + tipo_asentamiento).then((response) => {
                this.$set('codigo_postal', response.data);
                this.selectedCodigo_postalEdit = this.codigo_postal_edit;
            });
        },
        getVueItems: function (page) {
            this.$http.get('nmn_cat_empleadosC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        // Limpiar los valores de los errores y otros datos
        cleanItem: function () {
            this.newItem = {};
            this.formErrors = {};
            this.fillItem.codigo_pais = '223';
            this.newItem.codigo_pais = '223';
            this.selectedEntidad = null;
            this.selectedMunicipio = null;
            this.selectedLocalidad = null;
            this.selectedCodigo_postal = null;
            this.selectedBanco = null;
            this.selectedId_centrocosto = null;
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('nmn_cat_empleadosC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'num_empleado': '',
                    'nombre_empleado': '',
                    'primer_apellido': '',
                    'segundo_apellido': '',
                    'codigo_pais': '223',
                    'cve_entidad': '',
                    'cve_municipio': '',
                    'cve_localidad': '',
                    'codigo_postal': '',
                    'asentamiento': '',
                    'tipo_asentamiento': '',
                    'calle_domicilio': '',
                    'num_exterior': '',
                    'num_interior': '',
                    'telefono_casa': '',
                    'telefono_celular': '',
                    'telefono_otro': '',
                    'correo_electronico': '',
                    'rfc': '',
                    'curp': '',
                    'numero_seguro_social': '',
                    'id_centrocosto': '',
                    'fecha_registro': '',
                    'cve_banco': '',
                    'cuenta_bancaria': '',
                    'estatus': ''
                };
                $("#create-item").modal('hide');
                toastr.success('Empleado creado correctamente', 'Satisfactorio!', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('nmn_cat_empleadosC/' + item.id_empleado).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Cancelado con éxito !!!', 'Empleado', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            // Limpia los mensajes de errores
            this.formErrors = {};
            this.$http.get('nmn_cat_empleados/edit/' + item.id_empleado).then((response) => {


                // Manda los datos a sus respectivas variables despues de la consulta a la, base de datos
                this.fillItem.id_empleado = response.data.id_empleado;

                // Se deja por defecto el codigo del pais de mexico que corresponde al 223
                this.fillItem.codigo_pais = '223';

                // Se inicializan las variables con la estructura de vue-select
                this.selectedId_centrocostoEdit = {value: response.data.id_centrocosto, label: response.data.nombre_centrocosto};
                this.selectedBancoEdit = {value: response.data.cve_banco, label: response.data.nom_corto_banco};
                this.selectedEntidadEdit = {value: response.data.Cve_entidad, label: response.data.Estado};

                this.municipio_edit = {value: response.data.Cve_municipio, label: response.data.Nom_municipio};
                this.localida_edit = {value: response.data.Cve_localidad, label: response.data.Nom_localidad};
                this.codigo_postal_edit = {value: item.codigo_postal + '|' + item.tipo_asentamiento + '|' + item.asentamiento, label: '[' + response.data.codigo_postal + '] ' + response.data.tipo_asentamiento + ', ' + response.data.asentamiento};
                //this.codigo_postal_edit = {value: item.codigo_postal + '|' + item.tipo_asentamiento + '|' + item.asentamiento, label: '[' + item.codigo_postal + '] ' + item.tipo_asentamiento + ', ' + item.asentamiento};

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
                this.fillItem.tipo_asentamiento = item.tipo_asentamiento;



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


                this.fillItem.estatus = item.estatus;

                this.fillItem.id_empleado = item.id_empleado;

                //this.codigo_postal_edit = {value: item.codigo_postal + '|' + item.tipo_asentamiento + '|' + item.asentamiento, label: '[' + item.codigo_postal + '] ' + item.tipo_asentamiento + ', ' + item.asentamiento};
                $("#edit-item").modal('show');

            });
            //$("#edit-item").modal('show');
        },
        updateItem: function (id_empleado) {
            var input = this.fillItem;
            this.$http.put('nmn_cat_empleadosC/' + id_empleado, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'nombre_empleado': '',
                    'primer_apellido': '',
                    'segundo_apellido': '',
                    'codigo_pais': '223',
                    'cve_entidad': '',
                    'cve_municipio': '',
                    'cve_localidad': '',
                    'codigo_postal': '',
                    'asentamiento': '',
                    'tipo_asentamiento': '',
                    'calle_domicilio': '',
                    'num_exterior': '',
                    'num_interior': '',
                    'telefono_casa': '',
                    'telefono_celular': '',
                    'telefono_otro': '',
                    'correo_electronico': '',
                    'rfc': '',
                    'curp': '',
                    'numero_seguro_social': '',
                    'id_centrocosto': '',
                    'cve_banco': '',
                    'cuenta_bancaria': '',
                    'estatus': ''
                };
                $("#edit-item").modal('hide');
                
                toastr.success('Actualizado con éxito !!!', 'Empleado', {timeOut: 5000});
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
