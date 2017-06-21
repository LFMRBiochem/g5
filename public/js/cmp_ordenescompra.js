Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);

new Vue({
	el: '#manage-vue',
	data:{
		providers:[],
		products:[],
		selectedProvider:null,
		selectedProduct:null,
		OrdenEncabezado:{
			'cve_compania':'019',
			'id_proveedor':'',
			'comentarios':'',
			'lugar_entrega':'',
			'condiciones_entrega':'',
			'condiciones_pago':'',
			'cve_moneda':'MXN',
			'tipo_cambio':'2'
		},
		rows:[]

	},
	created:function(){
		this.getProviders();
	},
	mounted:function(){
		var vue_selects=".our_loops";
		$(vue_selects).css({
			"outline":"none !important",
			"border":"0px solid blue",
			"box-shadow":"0 0 0px #719ECE",
			"background-color":"white",
		});
	},
	watch:{
		selectedProvider:function(val, oldVal){
			if(val !== null){
				this.OrdenEncabezado.id_proveedor=val.value;				
			}
			else{
				this.OrdenEncabezado.id_proveedor='';
			}
		},
		selectedProduct:function(val, oldVal){
			if(val !== null){
				this.rows.push({
					cve_compania:this.OrdenEncabezado.cve_compania,
					folio_GTIN:val.value,
					folio_GTIN_label:val.value,
					descripcion_complementaria:'',
					cantidad:'0.00',
					precio_unitario:'0.00',
					porcentaje_impuesto:'0.00',
					cantidad_recibida:'0.00',
					cve_unidad_medida:val.cve_medida,
					cve_unidad_medida_label:val.cve_medida_label,
					estatus:'A'
	        	});
	        }
			else{
				//this.OrdenEncabezado.id_proveedor='';
			}
		}
	},
	methods:{
		inputGood:function(element){
			$(element).css({
				"outline":"none !important",
				"border":"1px solid red",
				"box-shadow":"0 0 10px #719ECE",
				"background-color":"#f2dede",
			});
		},
		inputBad:function(element){
			$(element).removeAttr( 'style' );
		},
		inputBadvueSelect:function(element){
				$(element).css({
				"outline":"none !important",
			    "border":"0px solid blue",
			    "box-shadow":"0 0 0px #719ECE",
			    "background-color":"white",
			});
		},
		isNumber: function(evt){
	      evt = (evt) ? evt : window.event;
	      var charCode = (evt.which) ? evt.which : evt.keyCode;
	      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46){
	        evt.preventDefault();
	      } else {
	        return true;
	      }
	    },
	    getProviders: function (){
            this.$http.get('tabla_recurrente/providers').then((response) => {
                this.providers=response.data;
                this.getProducts();
            });
        },
        getProducts:function(){
        	this.$http.get('cmp_orden_compra/products').then((response) => {
                this.products=response.data;
            });
        },
        removeRow: function(index){
	      this.$delete(this.rows, index);
	    },
	    guardaOrden:function(){
	    	var provider = this.OrdenEncabezado.id_proveedor;
	    	var comentarios = this.OrdenEncabezado.comentarios;
	    	var lugar_entrega = this.OrdenEncabezado.lugar_entrega;
	    	var condiciones_entrega = this.OrdenEncabezado.condiciones_entrega;
	    	var condiciones_pago = this.OrdenEncabezado.condiciones_pago;

	    	//banderas para mostrar inputs en rojo
	    	var flag_provider="#provIder";
	    	var flag_comentarios="#comentarios";
	    	var flag_lugar_entrega="#lugar_entrega";
	    	var flag_condiciones_entrega="#condiciones_entrega";
	    	var flag_condiciones_pago="#condiciones_pago";

	    	//guardamos en variables en caso de existir errores
	    	var msjeError="";
	    	var bandera_errores=0;
	    	var banderazo_partidas=0;

	    	//variables para el total de la orden de compra
	    	var total_partida=0;
	    	var total_orden=0;

	    	msjeError+="<strong>Error al guardar los cambios:</strong><br/>";
	    	if(provider==null || provider==''){
	    		bandera_errores+=1;
	    		msjeError+="Debe proporcionar el proveedor de la orden de compra<br/>";
	    		this.inputGood(flag_provider);
	    	}else{
	    		this.inputBadvueSelect(flag_provider);
	    	}
	    	if(condiciones_entrega==null || condiciones_entrega==''){
	    		bandera_errores+=1;
	    		msjeError+="Debe proporcionar las condiciones de entrega de la orden de compra<br/>";
	    		this.inputGood(flag_condiciones_entrega);
	    	}else{
	    		this.inputBad(flag_condiciones_entrega);
	    	}
	    	if(condiciones_pago==null || condiciones_pago==''){
	    		bandera_errores+=1;
	    		msjeError+="Debe proporcionar las condiciones de pago de la orden de compra<br/>";
	    		this.inputGood(flag_condiciones_pago);
	    	}else{
	    		this.inputBad(flag_condiciones_pago);
	    	}
	    	if(comentarios==null || comentarios==''){
	    		bandera_errores++;
	    		msjeError+="Debe proporcionar comentarios de la orden de compra<br/>";
	    		this.inputGood(flag_comentarios);
	    	}else{
	    		this.inputBad(flag_comentarios);
	    	}
	    	if(lugar_entrega==null || lugar_entrega==''){
	    		bandera_errores++;
	    		msjeError+="Debe proporcionar el lugar de entrega de la orden de compra<br/>";
	    		this.inputGood(flag_lugar_entrega);
	    	}else{
	    		this.inputBad(flag_lugar_entrega);
	    	}
	    	

	    	// Si existen errores al validar el encabezado de la orden de compra muestra los mensajes de error
			if(bandera_errores>0){	
				if(bandera_errores==1){
					console.log("Errores: "+bandera_errores);
				  	$("#modalillo_content").html(msjeError);
				  	$("#modalillo").modal('show');
				}else{
					console.log("Errores: "+bandera_errores);
				  	$("#modalillo_content").html(msjeError);
				  	$("#modalillo").modal('show');
				}	  		
			}else{
				// convierte las cantidades numericas de cada partida
				var float_cantidad=0;
				var float_precio_unitario=0;
				var float_porcentaje_impuesto=0;
				// se crea un array para almacenar cada partida
				var OrdenPartidas=[];
				// seccion para mostrar el modal
				var msjeError="";
				// se almacena el numero de partida actual a evaluar
				var num_partida=0;
				//se crea variable paras detectar si fueron agregadas las partidas en la orden
				var existen_partidas=0;
				msjeError+="<strong>Error al guardar los cambios:</strong><br/>";
				if(this.rows.length==0){
					msjeError+="Debe ingresar partidas a la orden de compra para poder completar la operaci&oacute;n.<br/>"
					$("#modalillo_content").html(msjeError);
				  	$("#modalillo").modal('show');
				  	banderazo_partidas=929;
				}else{					
					Object.entries(this.rows).forEach(([key, val]) => {
						if(val.cantidad=="" || val.precio_unitario=="" || val.porcentaje_impuesto==""){
							banderazo_partidas=404;
						}
						float_cantidad=parseFloat(val.cantidad);
						float_precio_unitario=parseFloat(val.precio_unitario);
						float_porcentaje_impuesto=parseFloat(val.porcentaje_impuesto);
						num_partida=parseInt(key);
						num_partida=num_partida+1;
						existen_partidas+=float_cantidad;

						//si se ingresan cantidades menores o iguales a cero
						if(float_cantidad<=0 || float_precio_unitario<=0){
							banderazo_partidas=221;
						}
						total_partida=float_cantidad*float_precio_unitario;
						total_orden+=total_partida;
						// se almacena la partida en el array "OrdenPartidas"
						OrdenPartidas.push({cve_compania:this.OrdenEncabezado.cve_compania, num_orden:'', num_partida:num_partida, folio_GTIN:val.folio_GTIN, descripcion_complementaria:val.descripcion_complementaria, cantidad:float_cantidad.toFixed(2), precio_unitario:float_precio_unitario.toFixed(2),porcentaje_impuesto:float_porcentaje_impuesto.toFixed(2), cantidad_recibida:'0.00', cve_unidad_medida:val.cve_unidad_medida, estatus:val.estatus});

					});
					//Si no existen errores tanto en el encabezado como en las partidas de la orde de compra se hace lo siguiente
					if(banderazo_partidas==0){
						this.OrdenEncabezado
						var encabezadoOrden=this.OrdenEncabezado;
						console.log("encabezao: "+encabezadoOrden+"\n banderazo_partidas:"+banderazo_partidas);
						//se crea el modal que avisa del guardado de la orden
				  		msjeError="<div class='container-fluid'><i class='fa fa-cog fa-spin fa-3x fa-fw'></i><span class='sr-only'>Guardando...</span> Guardando orden de compra, espere...</div>";
						$("#modalillo_content2").html(msjeError);
						$("#modalillo2").modal('show');
						//se envia mediante post, la peticion para el guardado de la orden
						this.$http.post('orden_compraE',encabezadoOrden).then(response => {
							var respuesta=response.data;
				  			
				  			if(respuesta!=(-404)){
					  			var num_ord=response.data;
					  			for(i=0;i<OrdenPartidas.length;i++){
					  				OrdenPartidas[i]['num_orden']=num_ord;
					  			}
					  			console.log(solicitud_Partidas);
					  			var input = solicitud_Partidas;
						  		this.$http.post('orden_compraP', input).then((response) => {
						  			if(response.data!=(-404)){
						  				$("#modalillo2").modal('hide');
						  				msjeError="La solicitud de pago se guard&oacute; correctamente con el n&uacute;mero <strong>"+response.data+"</strong>";
										$("#modalillo_content").html(msjeError);
										$("#modalillo").modal('show');
						  			}
						  			else{

						  			}
						  		},(response) => {
					                this.formErrors = response.data;
					            });
					            
				            }else{
				            	msjeError="Ocurri&oacute; un error al guardar la orden de compra<br/>Intente nuevamente, si el error persiste contacte al departamento de Sistemas";
						  		$("#modalillo_content").html(msjeError);
							  	$("#modalillo").modal('show');
				            }	
						});
					}else{
						//si existen errores, se detecta el tipo de error y después se muestra en el modal
						switch(banderazo_partidas){
							case 221:msjeError+="No puede ingresar cantidades menores o iguales a cero en los campos <strong>cantidad</strong> y <strong>precio unitario</strong><br/>";
							break;
							case 404:msjeError+="Los campos <strong>cantidad</strong>, <strong>precio unitario</strong> y <strong>porcentaje de impuesto</strong> no pueden estar vac&iacute;os<br/>";
							break;
						}
						$("#modalillo_content").html(msjeError);
					  	$("#modalillo").modal('show');
					}
				}
			}
	    },

	}
});