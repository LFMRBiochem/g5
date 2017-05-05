Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);

new Vue({
    el: '#manage-vue',
    data: {

        unidad_medida: [],

        selectedUnidad_medida: null,

        productos_segmento: {},
        productos_familia: {},
        productos_clase: {},
        productos_bloque: {},

        activo_ps: true,
        activo_pf: false,
        activo_pc: false,
        activo_pb: false,

        selectedSegmento: null,
        selectedFamilia: null,
        selectedClase: null,
        selectedBloque: null,

        cve_segmento: null,
        cve_familia: null,
        cve_clase: null,
        cve_bloque: null,

        full: '',

        //Variable utilizada para obtener los errores mandados por la validacion de los datos en la funcion de crear 
        formErrors: {},
//Variable utilizada para obtener los errores mandados por la validacion de los datos en la funcion de editar 
        formErrorsUpdate: {},

        newItem: {
            'cve_producto': '',
            'nombre_producto': '',
            'usos': '',
            'dosis': '',
            'ventajas': '',
            'formula': '',
            'fecha_creacion': '',

            'cve_cat_producto': '',
            'gtin': [],
            'precio_unitario': [],
            'piezas_por_paquete': [],
            'venta_minima': [],
            'peso_unitario': [],
            'es_venta': [],
            'considerar_margen': [],
            'cve_unidad_medida': [],
            'estatus': [],

        },
    },
    ready: function () {
        this.getSegmento();
        this.getUnidad_medida();
    },
    watch: {

    },

    methods: {
        getUnidad_medida: function () {
            this.$http.get('tabla_recurrente/unidad_medida').then((response) => {
//                console.log(response.data);
                this.$set('unidad_medida', response.data);


            });
        },

        getSegmento: function () {

            this.productos_segmento = {};
            this.productos_familia = {};
            this.productos_clase = {};
            this.productos_bloque = {};

            this.selectedSegmento = null;
            this.selectedFamilia = null;
            this.selectedClase = null;
            this.selectedBloque = null;

            this.activo_ps = true;
            this.activo_pf = false;
            this.activo_pc = false;
            this.activo_pb = false;

            this.cve_segmento = null;
            this.cve_familia = null;
            this.cve_clase = null;
            this.cve_bloque = null;

            this.$http.get('inv_cat_productos/segmento').then((response) => {
                this.$set('productos_segmento', response.data);
            });
        },
        getFamilia: function (cve_segmento, nombre_segmento) {

            this.productos_familia = {};
            this.productos_clase = {};
            this.productos_bloque = {};

            this.selectedFamilia = null;
            this.selectedClase = null;
            this.selectedBloque = null;

            this.activo_ps = false;
            this.activo_pf = true;
            this.activo_pc = false;
            this.activo_pb = false;

            this.cve_familia = null;
            this.cve_clase = null;
            this.cve_bloque = null;

            this.$http.get('inv_cat_productos/familia/' + cve_segmento).then((response) => {
                this.$set('productos_familia', response.data);
                this.selectedSegmento = nombre_segmento;
                this.cve_segmento = cve_segmento;
            });
        },
        getClase: function (cve_familia, nombre_familia) {

            this.productos_clase = {};
            this.productos_bloque = {};

            this.selectedClase = null;
            this.selectedBloque = null;

            this.activo_ps = false;
            this.activo_pf = false;
            this.activo_pc = true;
            this.activo_pb = false;

            this.cve_clase = null;
            this.cve_bloque = null;

            this.$http.get('inv_cat_productos/clase/' + this.cve_segmento + '/' + cve_familia).then((response) => {
                this.$set('productos_clase', response.data);
                this.selectedFamilia = nombre_familia;
                this.cve_familia = cve_familia;
            });
        },

        getBloque: function (cve_clase, nombre_clase) {

            this.productos_bloque = {};

            this.selectedBloque = null;

            this.activo_ps = false;
            this.activo_pf = false;
            this.activo_pc = false;
            this.activo_pb = true;

            this.cve_bloque = null;

            this.$http.get('inv_cat_productos/bloque/' + this.cve_segmento + '/' + this.cve_familia + '/' + cve_clase).then((response) => {
                this.$set('productos_bloque', response.data);
                this.selectedClase = nombre_clase;
                this.cve_clase = cve_clase;
            });
        },

        getAll: function (cve_bloque, nombre_bloque) {
            this.activo_ps = false;
            this.activo_pf = false;
            this.activo_pc = false;
            this.activo_pb = false;

            this.selectedBloque = nombre_bloque;
            this.cve_bloque = cve_bloque;

            this.full = this.selectedSegmento + ' » ' + this.selectedFamilia + ' » ' + this.selectedClase + ' » ' + this.selectedBloque;

            this.selectedSegmento = '';
            this.selectedFamilia = '';
            this.selectedClase = '';
            this.selectedBloque = '';

//            $("#formulario").collapse("hide");
        }
    }
});

