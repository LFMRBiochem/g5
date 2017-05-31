Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);

new Vue({
	el: '#manage-vue',
	data:{
        selectedTipoContrato:null,
        tiposContrato:[],
        selectedTipoJornada:null,
        tiposJornada:[],
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
            'cve_tipoContrato': '',
            'cve_compania': '',
            'descripcion_modelo': '',
            'cve_regimen': '',
            'cve_origenRecurso': '',
            'cve_tipoJornada': '',
            'id_tipo_nomina': '',
            'estatus': ''
        },
        fillItem: {
            'cve_tipoContrato': '',
            'cve_compania': '',
            'descripcion_modelo': '',
            'cve_regimen': '',
            'cve_origenRecurso': '',
            'cve_tipoJornada': '',
            'id_tipo_nomina': '',
            'estatus': ''
        }
	},
	computed:{
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
	ready:function(){

	},
	watch:{

	},
	methods:{
		getConceptos:function(){
            this.$http.get('nmn_cat_conceptos/selects/1').then((response) => {
                this.$set('conceptos', response.data);
            });
        }
	}
});