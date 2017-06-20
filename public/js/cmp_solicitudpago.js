Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
Vue.component('v-select', VueSelect.VueSelect);

new Vue({
	el: '#manage-vue',
	data:{
        id_centroscostos: [],
        conceptos_financieros: [],
        rows:[],
        selectedId_centrocosto: null,
        selectedConcepto: null, 
		newItem: {
            'cve_compania':'019',
            'id_solicitudpago':'',
			'fecha_registro':'',
			'cve_moneda':'MXN',
			'tipo_orden':'Seleccione',
			'id_centrocosto':'',
			'cve_usuario_genero':'daguerrerog',
			'cve_usuario_autorizo':'',
			'comentarios':'',
			'instrucciones_pago':'',
			'id_tipo_cambio':'2',
			'estatus':'A',
			'importe_solicitado':'',
			'importe_depositado':''
        }
	},
	created:function(){
		this.getId_centrocosto();
		//this.getConceptosFinancieros();
	},
	mounted:function(){
		
	},
	watch:{
		selectedId_centrocosto:function(val, oldVal){
			if(val !== null){
				this.newItem.id_centrocosto=val.value;				
			}
			else{
				this.newItem.id_centrocosto='';
			}
		},
		selectedConcepto:function(val, oldVal){
			if(val !== null){
				this.rows.push({
					concepto_id:val.value,
					concepto:val.label, 
	        		descrip:'',
	        		cantidad:'0.00',
	        		monto:'0.00'
	        	});
	        	this.selectedConcepto=null;
		        //$('#tableConceptos').append("<tr><td align='center'>"+this.newItemPartidas.concepto+"</td><td align='center'><div contenteditable v-model='newItemPartidas.desc'>Descripci&oacute;n</div></td><td align='center'><div contenteditable>1</div></td><td align='center'><div contenteditable>100</div></td></tr>");
			}
			else{
				this.newItemPartidas.concepto='';
			}
		}
	},
	methods:{
		isNumber: function(evt) {
	      evt = (evt) ? evt : window.event;
	      var charCode = (evt.which) ? evt.which : evt.keyCode;
	      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
	        evt.preventDefault();;
	      } else {
	        return true;
	      }
	    },
		getId_centrocosto: function () {
            this.$http.get('tabla_recurrente/id_centrocosto').then((response) => {
            	//console.log(response.data);
                //this.$set('id_centrocosto', response.data);
                this.id_centroscostos=response.data;
                this.getConceptosFinancieros();
            });
        },
        getConceptosFinancieros: function(){
        	this.$http.get('cmp_solicitud_pago/conceptos').then((response) => {
                this.conceptos_financieros=response.data;                
            });
        },
        removeRow: function(index){
	      this.$delete(this.rows, index);
	    },
	    guardaSolicitudPago:function(index){
	    	//guardar el encabezado y las partidas
	    	var total_cantidad_solicitud=0, total_monto_solicitud=0;
	    	var integer_cantidad=0, integer_monto=0;
	    	var descri="", desc2="";

	    	var tipo_ord=this.newItem.tipo_orden;
	    	var id_cc=this.newItem.id_centrocosto;
	    	var comments=this.newItem.comentarios;
	    	var inst_pago=this.newItem.instrucciones_pago;
	    	var imp_solicitado=0;
	    	var solicitud_Partidas=[];
	    	//guardamos en variables en caso de existir errores
	    	var msjeError="<strong>Error al guardar los cambios:</strong><br/>";
	    	var bandera_errores=0;
	    	var banderazo=4;

	    	if(tipo_ord=="Seleccione"){
	    		bandera_errores++;
	    		banderazo--;
	    		msjeError+="Debe especificar el tipo de solicitud<br/>";
	    	}
	    	if(id_cc==null || id_cc==""){
	    		bandera_errores++;
	    		banderazo--;
	    		msjeError+="Debe especificar el beneficiario de la solicitud<br/>";
	    	}
	    	if(comments==null || comments==""){
	    		bandera_errores++;
	    		banderazo--;
	    		msjeError+="Debe proporcionar comentarios de la solicitud<br/>";
	    	}
	    	if(inst_pago==null || inst_pago==""){
	    		bandera_errores++;
	    		banderazo--;
	    		msjeError+="Debe proporcionar las instrucciones de pago de la solicitud<br/>";
	    	}
	    	if(banderazo==4){
		    	//recorremos el array donde se almacenan las partidas de la solicitud de pago
			  	Object.entries(this.rows).forEach(([key, val]) => {		
			  	  	integer_cantidad=parseFloat(val.cantidad);
			  	  	integer_monto=parseFloat(val.monto);
			  	  	descri=val.descrip;
			  	  	desc2+=val.concepto;
			  	  	num_partida=parseInt(key);
			  	  	if(integer_cantidad<=0){
			  	  		bandera_errores++;
		    			msjeError+="La cantidad del concepto \"<strong>"+val.concepto+"\"</strong> debe ser mayor a cero.<br/>";
			  	  	}
			  	  	if(integer_monto<=0){
			  	  		bandera_errores++;
			  	  		msjeError+="El monto del concepto \"<strong>"+val.concepto+"\"</strong> debe ser mayor a cero.<br/>";
			  	  	}
			  	  	/*if(descri==null || descri==""){
			  	  		bandera_errores++;
			  	  		msjeError+="La descripci&oacute;n del concepto \"<strong>"+val.concepto+"\"</strong> no debe estar vac&iacute;a<br/>";
			  	  	}*/
			  	  	if((val.cantidad == null || val.cantidad == '') || (val.monto == null || val.monto == '')){
			  	  		bandera_errores++;
			  	  		msjeError+="El monto y la cantidad de cada concepto no debe estar vac&iacute;o<br/>";
			  	  	}
			  	  	var importe_concepto = integer_monto * integer_cantidad;
			  	  	imp_solicitado+=importe_concepto;
			  	  	solicitud_Partidas.push({id_solicitudpago:'', cve_compania:this.newItem.cve_compania, id_concepto_financiero: val.concepto_id, num_partida:num_partida+1, descripcion_adicional:val.descrip, importe_concepto:importe_concepto.toFixed(2)});
			  	  	total_cantidad_solicitud+=integer_cantidad;
			  	  	total_monto_solicitud+=integer_monto;
			  	});
			  	// Si existen errores muestra los mensajes de error
			  	if(bandera_errores>0){		  		
				  	$("#modalillo_content").html(msjeError);
				  	$("#modalillo").modal('show');
			  	}
			  	// Valida si existen partidas en la solicitud mediante la union de la cadena de descripciones de los conceptos
			  	else if(desc2===""){
			  		msjeError="Debe agregar conceptos a la solicitud de pago";
			  		$("#modalillo_content").html(msjeError);
				  	$("#modalillo").modal('show');
			  	}
			  	//Si no existen errores se envian los datos al controlador Laravel
			  	if(bandera_errores==0){
			  		this.newItem.importe_solicitado=imp_solicitado;
			  		var input1=this.newItem;
			  		console.log("importe solicitado: "+imp_solicitado);
			  		//se crea el modal que avisa del guardado de la solicitud
			  		msjeError="<div class='container-fluid'><i class='fa fa-cog fa-spin fa-3x fa-fw'></i><span class='sr-only'>Guardando...</span> Guardando solicitud de pago, espere...</div>";
					$("#modalillo_content2").html(msjeError);
					$("#modalillo2").modal('show');
			  		this.$http.post('cmp_solicitud_pagoC',input1).then(/*en caso de exito al insertar el encabezado de la solicitud, inserta las partidas*/(response)=>{			  			
			  			var respuesta=response.data;
			  			
			  			if(respuesta!=(-404)){
				  			var id_sol=response.data;
				  			for(i=0;i<solicitud_Partidas.length;i++){
				  				solicitud_Partidas[i]['id_solicitudpago']=id_sol;
				  			}
				  			console.log(solicitud_Partidas);
				  			var input = solicitud_Partidas;
					  		this.$http.post('cmp_solicitud_pagoC2', input).then((response) => {
					  			if(response.data!=(-404)){
					  				$("#modalillo2").modal('hide');
					  				msjeError="La solicitud de pago se guard&oacute; correctamente con el numero <strong>"+response.data+"</strong>";
									$("#modalillo_content").html(msjeError);
									$("#modalillo").modal('show');
					  			}
					  			else{

					  			}
					  		},(response) => {
				                this.formErrors = response.data;
				            });
				            
			            }else{
			            	msjeError="Ocurri&oacute; un error al guardar la solicitudde pago<br/>Intente nuevamente, si el error persiste contacte al departamento de Sistemas";
					  		$("#modalillo_content").html(msjeError);
						  	$("#modalillo").modal('show');
			            }		  			
			  		},/*en caso de error al insertar el encabezado de la solicitud*/(response)=>{

			  		});
			  	}
	    	}else{
	    		$("#modalillo_content").html(msjeError);
				$("#modalillo").modal('show');
	    	}
	    }
	},

});