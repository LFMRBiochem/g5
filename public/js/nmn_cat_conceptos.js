Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#manage-vue',
    data: {

    	selectedConcepto:null,
    	conceptos:[],
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
            'id_folio_concepto': '',
            'cve_compania': '',
            'id_concepto': '',
            'descripcion': '',
            'percepcion_deduccion': '',
            'operacion': '',
            'id_conceptofinanciero': '',
            'considerar_recibo': '',
            'considerar_reportes': '',
            'estatus': ''
        },
        fillItem: {
            'id_folio_concepto': '',
            'cve_compania': '',
            'id_concepto': '',
            'descripcion': '',
            'percepcion_deduccion': '',
            'operacion': '',
            'id_conceptofinanciero': '',
            'considerar_recibo': '',
            'considerar_reportes': '',
            'estatus': ''
        },

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
    watch:{

    	selectedConcepto:function(val, oldVal){
        	if(val!=null){
        		this.newItem.descripcion = val.label;
        		this.newItem.id_conceptofinanciero = val.value;
        		var ecsplode = val.value.split(".");
        		var id_concept = ecsplode[1];
        		this.newItem.id_concepto=id_concept;
        	}else{
        		this.newItem.descripcion='';
        		this.newItem.id_concepto='';
        		this.newItem.id_conceptofinanciero = '';
        	}
        }
    },
    ready:function(){
    	// Manda llamar los datos para llenar la tabla
        this.getVueItems(this.pagination.current_page);
        //se obtienen los conceptos de ctb_cat_concepto_financiero
        this.getConceptos();
    },
    methods:{
    	id_conceptofinanciero_search: function (data) {
            if (data !== null || data !== '') {
                this.newItem.id_concepto_financiero = '' + data;
                this.newItem.descripcion = '' + data;
                this.newItem.id_concepto = '' + data.substr(0,1);
            } else {
                this.newItem.id_centrocosto = '';
                this.newItem.descripcion = '';
                this.newItem.id_concepto = '';
            }
        },
    	changePage: function (page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        },
        getVueItems: function (page) {
            this.$http.get('nmn_cat_conceptosC?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },
        getConceptos:function(){
        	this.$http.get('nmn_cat_conceptos/conceptos').then((response) => {
                this.$set('conceptos', response.data);
            });
        },
        // Limpiar los valores de los errores y otros datos
        cleanItem: function () {
            this.newItem = {};
            this.formErrors = {};
            this.selectedConcepto = null;
            this.newItem.cve_compania='019';
        },
        createItem: function () {
            var input = this.newItem;
            this.$http.post('nmn_cat_conceptosC', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'id_folio_concepto': '',
		            'cve_compania': '',
		            'id_concepto': '',
		            'descripcion': '',
		            'percepcion_deduccion': '',
		            'operacion': '',
		            'id_conceptofinanciero': '',
		            'considerar_recibo': '',
		            'considerar_reportes': '',
		            'estatus': ''
                };
                $("#create-item").modal('hide');
                toastr.success('Concepto de nómina creado correctamente', 'Satisfactorio!', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },
        deleteItem: function (item) {
            this.$http.delete('nmn_cat_conceptosC/' + item.id_folio_concepto).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Activado/Cancelado con éxito !!!', 'Concepto de nómina', {timeOut: 5000});
            });
        },
        editItem: function (item) {
            // Limpia los mensajes de errores
            this.formErrors = {};
            this.$http.get('nmn_cat_conceptos/edit/' + item.id_folio_concepto).then((response) => {


                // Manda los datos a sus respectivas variables despues de la consulta a la, base de datos
                this.fillItem.id_folio_concepto = response.data.id_folio_concepto;

                this.fillItem.cve_compania = response.data.cve_compania;

                // Se inicializan las variables con la estructura de vue-select
                this.selectedId_centrocostoEdit = {value: response.data.id_centrocosto, label: response.data.nombre_centrocosto};
                this.selectedBancoEdit = {value: response.data.cve_banco, label: response.data.nom_corto_banco};
                this.selectedEntidadEdit = {value: response.data.Cve_entidad, label: response.data.Estado};

                this.municipio_edit = {value: response.data.Cve_municipio, label: response.data.Nom_municipio};
                this.localida_edit = {value: response.data.Cve_localidad, label: response.data.Nom_localidad};
                this.codigo_postal_edit = {value: item.codigo_postal + '|' + item.tipo_asentamiento + '|' + item.asentamiento, label: '[' + response.data.codigo_postal + '] ' + response.data.tipo_asentamiento + ', ' + response.data.asentamiento};
                //this.codigo_postal_edit = {value: item.codigo_postal + '|' + item.tipo_asentamiento + '|' + item.asentamiento, label: '[' + item.codigo_postal + '] ' + item.tipo_asentamiento + ', ' + item.asentamiento};

                this.conceptos={value:response.data.descripcion, label:response};

                this.fillItem.id_concepto = response.data.id_concepto;
                this.fillItem.descripcion = response.data.descripcion;//item.descripcion;

                this.fillItem.percepcion_deduccion = response.data.percepcion_deduccion;
                this.fillItem.operacion = response.data.operacion;

                this.fillItem.id_conceptofinanciero = response.data.id_conceptofinanciero;
                this.fillItem.considerar_recibo = response.data.considerar_recibo;
                this.fillItem.considerar_reportes = response.data.considerar_reportes;
                this.fillItem.estatus = response.data.estatus; //----------

               
                $("#edit-item").modal('show');

            });
            //$("#edit-item").modal('show');
        },
        updateItem: function (id_folio_concepto) {
            var input = this.fillItem;
            this.$http.put('nmn_cat_conceptosC/' + id_folio_concepto, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'id_folio_concepto': '',
		            'cve_compania': '',
		            'id_concepto': '',
		            'descripcion': '',
		            'percepcion_deduccion': '',
		            'operacion': '',
		            'id_concepto_financiero': '',
		            'considerar_recibo': '',
		            'considerar_reportes': '',
		            'estatus': ''
                };
                $("#edit-item").modal('hide');
                
                toastr.success('Actualizado con éxito !!!', 'Concepto de nómina', {timeOut: 5000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },

    }
});
