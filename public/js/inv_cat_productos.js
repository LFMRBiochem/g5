Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);

var evento = new Vue({
    el: '#evento',
    methods: {
        iniciarCrear: function () {
            this.$emit('iniciarCrear');
        }
    }
});


var crear = new Vue({
    el: '#crear',
    data: {
        posicion_identificador_comercial: [],
        selectedUnidad_medida: [],
        unidad_medida: '',

        productos_segmento: [],
        productos_familia: [],
        productos_clase: [],
        productos_bloque: [],

//        completo: [],

        cve: {
            segmento: [],
            familia: [],
            clase: [],
            bloque: [],
        },
        nombre: {
            segmento: [],
            familia: [],
            clase: [],
            bloque: [],
        },
        formErrors: {},
        formErrorsUpdate: {},
        newItem: {
            contador: 0,
            guardar: [],

            cve_producto: '',
            nombre_producto: '',
            usos: '',
            dosis: '',
            ventajas: '',
            formula: '',

            gtin: [],
            precio_unitario: [],
            piezas_por_paquete: [],
            venta_minima: [],
            peso_unitario: [],
            es_venta: [],
            considerar_margen: [],
            cve_unidad_medida: [],
        },
    },
    mounted: function () {
        evento.$on('iniciarCrear', () => {
            this.limpiarDatos();
            this.addContador();
        });
        this.getUnidad_medida();
    },

    methods: {
        limpiarDatos: function () {
            this.newItem.contador = 0;

            this.posicion_identificador_comercial = [];

            this.unidad_medida = [];

            this.productos_segmento = [];
            this.productos_familia = [];
            this.productos_clase = [];
            this.productos_bloque = [];

//            this.completo = [];

            this.cve.segmento = [];
            this.cve.familia = [];
            this.cve.clase = [];
            this.cve.bloque = [];

            this.cve.segmento = [];
            this.cve.familia = [];
            this.cve.clase = [];
            this.cve.bloque = [];

            this.formErrors = {};
            this.newItem.cve_producto = '';
            this.newItem.nombre_producto = '';
            this.newItem.usos = '';
            this.newItem.dosis = '';
            this.newItem.ventajas = '';
            this.newItem.formula = '';

            this.newItem.gtin = [''];
            this.newItem.precio_unitario = [''];
            this.newItem.piezas_por_paquete = [''];
            this.newItem.venta_minima = [''];
            this.newItem.peso_unitario = [''];
            this.newItem.es_venta = [''];
            this.newItem.considerar_margen = [''];
            this.newItem.cve_unidad_medida = [''];

            this.getUnidad_medida();
        },
        getUnidad_medida: function () {
            this.$http.get('tabla_recurrente/unidad_medida').then((response) => {
                this.unidad_medida = response.data;
            });
        },
        addContador: function () {
            this.newItem.contador = this.newItem.contador + 1;

            this.newItem.cve_producto[this.newItem.contador] = "";
            this.newItem.nombre_producto[this.newItem.contador] = "";
            this.newItem.usos[this.newItem.contador] = "";
            this.newItem.dosis[this.newItem.contador] = "";
            this.newItem.ventajas[this.newItem.contador] = "";
            this.newItem.formula[this.newItem.contador] = "";

            this.newItem.gtin[this.newItem.contador] = "";
            this.newItem.precio_unitario[this.newItem.contador] = "";
            this.newItem.piezas_por_paquete[this.newItem.contador] = "";
            this.newItem.venta_minima[this.newItem.contador] = "";
            this.newItem.peso_unitario[this.newItem.contador] = "";
            this.newItem.es_venta[this.newItem.contador] = 0;
            this.newItem.considerar_margen[this.newItem.contador] = 0;
            this.newItem.cve_unidad_medida[this.newItem.contador] = "";

            this.newItem.guardar[this.newItem.contador] = true;

//            Vue.set(this.newItem.cve_unidad_medida, this.newItem.contador, "");

            this.getSegmento(this.newItem.contador);
        },
        noGuardar: function (cont) {
            Vue.set(this.newItem.guardar, cont, false);
        },
        getSegmento: function (cont) {
            Vue.set(this.posicion_identificador_comercial, cont, 1);

            // borramos el valor newItem.gtin para decirle que no esta terminada la rutina
            Vue.set(this.newItem.gtin, cont, '');

            // Borramos los datos que puedan estar guarados
            Vue.set(this.cve.segmento, cont, '');
            Vue.set(this.nombre.segmento, cont, '');
            Vue.set(this.cve.familia, cont, '');
            Vue.set(this.nombre.familia, cont, '');
            Vue.set(this.cve.clase, cont, '');
            Vue.set(this.nombre.clase, cont, '');
            Vue.set(this.cve.bloque, cont, '');
            Vue.set(this.nombre.bloque, cont, '');

            this.$http.get('inv_cat_productos/segmento').then((response) => {
                Vue.set(this.productos_segmento, cont, response.data);
            });
        },
        getFamilia: function (cont, cve_segmento, nombre_segmento) {
            Vue.set(this.posicion_identificador_comercial, cont, 2);

            // borramos el valor newItem.gtin para decirle que no esta terminada la rutina
            Vue.set(this.newItem.gtin, cont, '');

            // Borramos los datos que puedan estar guarados
            Vue.set(this.cve.familia, cont, '');
            Vue.set(this.nombre.familia, cont, '');
            Vue.set(this.cve.clase, cont, '');
            Vue.set(this.nombre.clase, cont, '');
            Vue.set(this.cve.bloque, cont, '');
            Vue.set(this.nombre.bloque, cont, '');

            Vue.set(this.cve.segmento, cont, cve_segmento);
            Vue.set(this.nombre.segmento, cont, nombre_segmento);

            this.$http.get('inv_cat_productos/familia/' + cve_segmento).then((response) => {
                Vue.set(this.productos_familia, cont, response.data);
            });
        },
        getClase: function (cont, cve_familia, nombre_familia) {
            Vue.set(this.posicion_identificador_comercial, cont, 3);

            // borramos el valor newItem.gtin para decirle que no esta terminada la rutina
            Vue.set(this.newItem.gtin, cont, '');

            //            Borramos los datos que puedan estar guarados
            Vue.set(this.cve.clase, cont, '');
            Vue.set(this.nombre.clase, cont, '');
            Vue.set(this.cve.bloque, cont, '');
            Vue.set(this.nombre.bloque, cont, '');

            Vue.set(this.cve.familia, cont, cve_familia);
            Vue.set(this.nombre.familia, cont, nombre_familia);

            this.$http.get('inv_cat_productos/clase/' + this.cve.segmento[cont] + '/' + cve_familia).then((response) => {
                Vue.set(this.productos_clase, cont, response.data);
            });
        },
        getBloque: function (cont, cve_clase, nombre_clase) {
            Vue.set(this.posicion_identificador_comercial, cont, 4);

            // borramos el valor newItem.gtin para decirle que no esta terminada la rutina
            Vue.set(this.newItem.gtin, cont, '');

            // Borramos los datos que puedan estar guarados
            Vue.set(this.cve.bloque, cont, '');
            Vue.set(this.nombre.bloque, cont, '');

            Vue.set(this.cve.clase, cont, cve_clase);
            Vue.set(this.nombre.clase, cont, nombre_clase);

            this.$http.get('inv_cat_productos/bloque/' + this.cve.segmento[cont] + '/' + this.cve.familia[cont] + '/' + cve_clase).then((response) => {
                Vue.set(this.productos_bloque, cont, response.data);
            });
        },
        getAll: function (cont, cve_bloque, nombre_bloque) {
            Vue.set(this.cve.bloque, cont, cve_bloque);
            Vue.set(this.nombre.bloque, cont, nombre_bloque);

            Vue.set(this.newItem.gtin, cont, this.cve.segmento[cont] + '|' + this.cve.familia[cont] + '|' + this.cve.clase[cont] + '|' + this.cve.bloque[cont]);

        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('inv_cat_productosC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                $("#create-item").modal('hide');
                toastr.success('Creado con éxito !!!', 'Producto', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
    }
});


var listar = new Vue({
    el: '#listar',
    data: {

        posicion_identificador_comercial: [],
        selectedUnidad_medida: [],
        unidad_medida: '',

        productos_segmento: [],
        productos_familia: [],
        productos_clase: [],
        productos_bloque: [],

//        completo: [],

        cve: {
            segmento: [],
            familia: [],
            clase: [],
            bloque: [],
        },
        nombre: {
            segmento: [],
            familia: [],
            clase: [],
            bloque: [],
        },
        formErrors: {},
        formErrorsUpdate: {},
        fillItem: {
            contador: 0,
            guardar: [],

            folio_GTIN: [],
            estatus: [],

            cve_producto: '',
            nombre_producto: '',
            usos: '',
            dosis: '',
            ventajas: '',
            formula: '',

            gtin: [],
            precio_unitario: [],
            piezas_por_paquete: [],
            venta_minima: [],
            peso_unitario: [],
            es_venta: [],
            considerar_margen: [],
            cve_unidad_medida: [],
        },

        items: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },

        offset: 4,
        cont: 0,

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
    mounted: function () {

        this.limpiarDatos();
        this.addContador();

        this.getUnidad_medida();

        this.getVueItems(this.pagination.current_page);
    },
    methods: {
        getVueItems: function (page) {
            this.$http.get('inv_cat_productosC?page=' + page).then((response) => {
                this.items = response.data.data.data;
                this.pagination = response.data.pagination;
            });
        },

        editItem: function (item) {
            // Limpia los mensajes de errores
            this.formErrors = {};

            this.$http.get('inv_cat_productos/edit/' + item.cve_cat_producto).then((response) => {
                var estatus = '';
                this.fillItem.contador = response.data.length;
                this.contador = response.data.length;

                for (var index = 0; index < this.fillItem.contador; ++index) {

                    this.fillItem.cve_cat_producto = response.data[index].cve_cat_producto;

                    this.fillItem.cve_producto = response.data[index].cve_producto;
                    this.fillItem.nombre_producto = response.data[index].nombre_producto;
                    this.fillItem.usos = response.data[index].usos;
                    this.fillItem.dosis = response.data[index].dosis;
                    this.fillItem.ventajas = response.data[index].ventajas;
                    this.fillItem.formula = response.data[index].formula;

                    Vue.set(this.fillItem.folio_GTIN, index + 1, response.data[index].folio_GTIN);

                    Vue.set(this.fillItem.guardar, index + 1, 1);

                    Vue.set(this.fillItem.gtin, index + 1, response.data[index].gtin);
                    Vue.set(this.fillItem.precio_unitario, index + 1, response.data[index].precio_unitario);
                    Vue.set(this.fillItem.piezas_por_paquete, index + 1, response.data[index].piezas_por_paquete);
                    Vue.set(this.fillItem.venta_minima, index + 1, response.data[index].venta_minima);
                    Vue.set(this.fillItem.peso_unitario, index + 1, response.data[index].peso_unitario);
                    Vue.set(this.fillItem.es_venta, index + 1, response.data[index].es_venta);
                    Vue.set(this.fillItem.considerar_margen, index + 1, response.data[index].considerar_margen);

                    Vue.set(this.fillItem.estatus, index + 1, (response.data[index].estatus === 'A') ? true : false);

                    this.get_unidad_medida(index, response.data[index].cve_unidad_medida);
//
//                    Vue.set(this.fillItem.cve_unidad_medida, index + 1, response.data[index].cve_unidad_medida);

                    var cve = response.data[index].gtin.split("|");

                    Vue.set(this.cve.segmento, index + 1, cve[0]);
                    Vue.set(this.cve.familia, index + 1, cve[1]);
                    Vue.set(this.cve.clase, index + 1, cve[2]);
                    Vue.set(this.cve.bloque, index + 1, cve[3]);

                    this.get_nombre_segmento(index, cve[0]);
                    this.get_nombre_familia(index, cve[0], cve[1]);
                    this.get_nombre_clase(index, cve[0], cve[1], cve[2]);
                    this.get_nombre_bloque(index, cve[0], cve[1], cve[2], cve[3]);

                }


            });
            $("#edit-item").modal('show');
        },

        cambiar_estatus: function (cont, estatus) {

            if (estatus === true) {
                Vue.set(this.fillItem.estatus, cont, false);
            } else {
                Vue.set(this.fillItem.estatus, cont, true);
            }
        },

        get_unidad_medida: function (index, cve_unidad_medida) {
            this.$http.get('inv_cat_productos/unidad_medida/' + cve_unidad_medida).then((response) => {
                Vue.set(this.fillItem.cve_unidad_medida, index + 1, {value: response.data.cve_unidad_medida, label: response.data.nom_unidad_medida});
            });
        },

        get_nombre_segmento: function (index, cve_segmento) {
            this.$http.get('inv_cat_productos/segmento/' + cve_segmento).then((response) => {
                Vue.set(this.nombre.segmento, index + 1, response.data.nombre_segmento);
            });
        },
        get_nombre_familia: function (index, cve_segmento, cve_familia) {
            this.$http.get('inv_cat_productos/familia/' + cve_segmento + '/' + cve_familia).then((response) => {
                Vue.set(this.nombre.familia, index + 1, response.data.nombre_familia);
            });
        },
        get_nombre_clase: function (index, cve_segmento, cve_familia, cve_clase) {
            this.$http.get('inv_cat_productos/clase/' + cve_segmento + '/' + cve_familia + '/' + cve_clase).then((response) => {
                Vue.set(this.nombre.clase, index + 1, response.data.nombre_clase);
            });
        },
        get_nombre_bloque: function (index, cve_segmento, cve_familia, cve_clase, cve_bloque) {
            this.$http.get('inv_cat_productos/bloque/' + cve_segmento + '/' + cve_familia + '/' + cve_clase + '/' + cve_bloque).then((response) => {
                Vue.set(this.nombre.bloque, index + 1, response.data.nombre_bloque);
            });
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        },

        limpiarDatos: function () {
            this.fillItem.contador = 0;

            this.posicion_identificador_comercial = [];

            this.unidad_medida = [];

            this.productos_segmento = [];
            this.productos_familia = [];
            this.productos_clase = [];
            this.productos_bloque = [];

//            this.completo = [];

            this.cve.segmento = [];
            this.cve.familia = [];
            this.cve.clase = [];
            this.cve.bloque = [];

            this.cve.segmento = [];
            this.cve.familia = [];
            this.cve.clase = [];
            this.cve.bloque = [];

            this.fillItem.folio_GTIN=[''],
                    this.formErrors = {};
            this.fillItem.cve_producto = '';
            this.fillItem.nombre_producto = '';
            this.fillItem.usos = '';
            this.fillItem.dosis = '';
            this.fillItem.ventajas = '';
            this.fillItem.formula = '';

            this.fillItem.gtin = [''];
            this.fillItem.precio_unitario = [''];
            this.fillItem.piezas_por_paquete = [''];
            this.fillItem.venta_minima = [''];
            this.fillItem.peso_unitario = [''];
            this.fillItem.es_venta = [''];
            this.fillItem.considerar_margen = [''];
            this.fillItem.cve_unidad_medida = [''];

            this.getUnidad_medida();
        },

        getUnidad_medida: function () {
            this.$http.get('tabla_recurrente/unidad_medida').then((response) => {
                this.unidad_medida = response.data;
            });
        },

        addContador: function () {

            this.fillItem.contador = this.fillItem.contador + 1;

//this.fillItem.cve_producto[this.fillItem.contador] = true;

            this.fillItem.cve_producto[this.fillItem.contador] = "";
            this.fillItem.nombre_producto[this.fillItem.contador] = "";
            this.fillItem.usos[this.fillItem.contador] = "";
            this.fillItem.dosis[this.fillItem.contador] = "";
            this.fillItem.ventajas[this.fillItem.contador] = "";
            this.fillItem.formula[this.fillItem.contador] = "";

            this.fillItem.gtin[this.fillItem.estatus] = "";

            this.fillItem.gtin[this.fillItem.contador] = "";
            this.fillItem.precio_unitario[this.fillItem.contador] = "";
            this.fillItem.piezas_por_paquete[this.fillItem.contador] = "";
            this.fillItem.venta_minima[this.fillItem.contador] = "";
            this.fillItem.peso_unitario[this.fillItem.contador] = "";
            this.fillItem.es_venta[this.fillItem.contador] = 0;
            this.fillItem.considerar_margen[this.fillItem.contador] = 0;
            this.fillItem.cve_unidad_medida[this.fillItem.contador] = "";

            this.fillItem.guardar[this.fillItem.contador] = 1;
            this.fillItem.estatus[this.fillItem.contador] = true;
            this.fillItem.folio_GTIN[this.fillItem.contador] = 'no';

//            Vue.set(this.fillItem.cve_unidad_medida, this.fillItem.contador, "");

            this.getSegmento(this.fillItem.contador);
        },
        noGuardar: function (cont) {
            Vue.set(this.fillItem.guardar, cont, false);
        },
        getSegmento: function (cont) {
            Vue.set(this.posicion_identificador_comercial, cont, 1);

            // borramos el valor fillItem.gtin para decirle que no esta terminada la rutina
            Vue.set(this.fillItem.gtin, cont, '');

            // Borramos los datos que puedan estar guarados
            Vue.set(this.cve.segmento, cont, '');
            Vue.set(this.nombre.segmento, cont, '');
            Vue.set(this.cve.familia, cont, '');
            Vue.set(this.nombre.familia, cont, '');
            Vue.set(this.cve.clase, cont, '');
            Vue.set(this.nombre.clase, cont, '');
            Vue.set(this.cve.bloque, cont, '');
            Vue.set(this.nombre.bloque, cont, '');

            this.$http.get('inv_cat_productos/segmento').then((response) => {
                Vue.set(this.productos_segmento, cont, response.data);
            });
        },
        getFamilia: function (cont, cve_segmento, nombre_segmento) {
            Vue.set(this.posicion_identificador_comercial, cont, 2);

            // borramos el valor fillItem.gtin para decirle que no esta terminada la rutina
            Vue.set(this.fillItem.gtin, cont, '');

            // Borramos los datos que puedan estar guarados
            Vue.set(this.cve.familia, cont, '');
            Vue.set(this.nombre.familia, cont, '');
            Vue.set(this.cve.clase, cont, '');
            Vue.set(this.nombre.clase, cont, '');
            Vue.set(this.cve.bloque, cont, '');
            Vue.set(this.nombre.bloque, cont, '');

            Vue.set(this.cve.segmento, cont, cve_segmento);
            Vue.set(this.nombre.segmento, cont, nombre_segmento);

            this.$http.get('inv_cat_productos/familia/' + cve_segmento).then((response) => {
                Vue.set(this.productos_familia, cont, response.data);
            });
        },
        getClase: function (cont, cve_familia, nombre_familia) {
            Vue.set(this.posicion_identificador_comercial, cont, 3);

            // borramos el valor fillItem.gtin para decirle que no esta terminada la rutina
            Vue.set(this.fillItem.gtin, cont, '');

            //            Borramos los datos que puedan estar guarados
            Vue.set(this.cve.clase, cont, '');
            Vue.set(this.nombre.clase, cont, '');
            Vue.set(this.cve.bloque, cont, '');
            Vue.set(this.nombre.bloque, cont, '');

            Vue.set(this.cve.familia, cont, cve_familia);
            Vue.set(this.nombre.familia, cont, nombre_familia);

            this.$http.get('inv_cat_productos/clase/' + this.cve.segmento[cont] + '/' + cve_familia).then((response) => {
                Vue.set(this.productos_clase, cont, response.data);
            });
        },
        getBloque: function (cont, cve_clase, nombre_clase) {
            Vue.set(this.posicion_identificador_comercial, cont, 4);

            // borramos el valor fillItem.gtin para decirle que no esta terminada la rutina
            Vue.set(this.fillItem.gtin, cont, '');

            // Borramos los datos que puedan estar guarados
            Vue.set(this.cve.bloque, cont, '');
            Vue.set(this.nombre.bloque, cont, '');

            Vue.set(this.cve.clase, cont, cve_clase);
            Vue.set(this.nombre.clase, cont, nombre_clase);

            this.$http.get('inv_cat_productos/bloque/' + this.cve.segmento[cont] + '/' + this.cve.familia[cont] + '/' + cve_clase).then((response) => {
                Vue.set(this.productos_bloque, cont, response.data);
            });
        },
        getAll: function (cont, cve_bloque, nombre_bloque) {
            Vue.set(this.cve.bloque, cont, cve_bloque);
            Vue.set(this.nombre.bloque, cont, nombre_bloque);

            Vue.set(this.fillItem.gtin, cont, this.cve.segmento[cont] + '|' + this.cve.familia[cont] + '|' + this.cve.clase[cont] + '|' + this.cve.bloque[cont]);
        },
        // Metodo para mandar actualizar 
        updateItem: function (cve_unidad_medida) {
            // Se trae la informacion del formulario editar
            var input = this.fillItem;

            this.$http.put('inv_cat_productosC/' + cve_unidad_medida, input).then((response) => {
                this.changePage(this.pagination.current_page);

                $("#edit-item").modal('hide');
                toastr.success('Actualizado con éxito !!!', 'Producto', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });

        },
    }
}); 