(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{37:function(t,e,s){"use strict";var a=s(5);s.n(a).a},41:function(t,e,s){"use strict";var a=s(6);s.n(a).a},48:function(t,e,s){"use strict";s.r(e);var a=s(3),o=s(17),i=s.n(o);const l={key:object_map.key,zoom:object_map.zoom,lat:object_map.lat,lng:object_map.lng,lat2:object_map.lat2,lng2:object_map.lng2,pressingmin:object_map.pressingmin,pressingmax:object_map.pressingmax,free:object_map.free,img:object_map.img,distancemax:object_map.distancemax,urlcart:object_map.urlcart,urlcity:function(){const t=window.location.hostname,e=window.location.protocol;return"localhost"===t?`${e}//${t}:3000/wordpress/wp-content/plugins/woocommerce-address-geolocalization-km/src/frontend/Api/city.php`:`${e}//${t}/wp-content/plugins/woocommerce-address-geolocalization-km/src/frontend/Api/city.php`}()};var r={name:"GoogleGeocode",data:()=>({selectinfo:[]}),async mounted(){const{urlcity:t}=l,e=await i.a.get(t);this.selectinfo=e.data},computed:{address:{get(){return this.$store.state.address},set(t){this.$store.commit("GET_ADDRESS",t)}},city:{get(){return this.$store.state.city},set(t){this.$store.commit("GET_CITY",t)}},disabled:{get(){return this.$store.state.disable}}}},c=(s(37),s(1)),n=Object(c.a)(r,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("section",{staticClass:"row"},[s("div",{staticClass:"col-6 p-2"},[s("b-field",[s("b-input",{staticClass:"input-text-address",attrs:{placeholder:"Dirección",type:"text",icon:"map-marker",disabled:t.disabled},model:{value:t.address,callback:function(e){t.address=e},expression:"address"}})],1)],1),t._v(" "),s("div",{staticClass:"col-6 p-2"},[s("b-field",[s("b-select",{attrs:{icon:"map",disabled:t.disabled,expanded:""},model:{value:t.city,callback:function(e){t.city=e},expression:"city"}},[s("option",{attrs:{value:""}},[t._v("Seleccione la ciudad")]),t._v(" "),t._l(t.selectinfo,(function(e){return s("option",{domProps:{value:e.city}},[t._v(t._s(e.city))])}))],2)],1)],1)])}),[],!1,null,null,null).exports,d=s(2),m=s(18),p=s.n(m),u=s(8),_=s.n(u),h={props:{mapConfig:Object,apiKey:String,submit:!1},data:()=>({google:null,map:null,total_km:null,total_result:null,freestate:!1,coorclient:"",coorreseller:""}),async mounted(){const t=await p()({apiKey:this.apiKey});this.google=t,this.initializeMap()},methods:{initializeMap(){const{lat:t,lng:e,zoom:s}=l,a=this.$refs.googleMap;this.map=new this.google.maps.Map(a,{zoom:Number(s),center:{lat:parseFloat(t),lng:parseFloat(e)},zoomControl:!0,zoomControlOptions:{position:this.google.maps.ControlPosition.RIGHT_CENTER},mapTypeControl:!1,scaleControl:!1,streetViewControl:!1,rotateControl:!1,fullscreenControl:!1})},startCalculate(){this.submit=!0,this.initializeMap(),this.$store.commit("GET_DISABLE",!0);const t=new this.google.maps.Geocoder;this.geocodeAddress(t,this.map)},geocodeAddress(t,e){const{lat2:s,lng2:a,free:o,pressingmin:i,pressingmax:r,distancemax:c}=l,n=`${this.address} ${this.city}`;t.geocode({address:n},(t,e)=>{if("OK"===e){const e=new this.google.maps.DirectionsRenderer,l=new this.google.maps.DirectionsService,n=t[0].geometry.location.lat(),d=t[0].geometry.location.lng(),m=[n,d],p=[parseFloat(s),parseFloat(a)];this.calculateDistance(n,d,parseFloat(s),parseFloat(a),o,i,r,c),e.setMap(this.map),this.calculateAndDisplayRoute(l,e,m,p),this.coorclient=m,this.coorreseller=p}else alert("La dirección es erronea, por favor ingresa de nuevo."),this.$store.commit("GET_DISABLE",!1),this.submit=!1})},calculateAndDisplayRoute(t,e,s,a){t.route({origin:{lat:s[0],lng:s[1]},destination:{lat:a[0],lng:a[1]},travelMode:this.google.maps.TravelMode.DRIVING},(t,s)=>{"OK"==s?e.setDirections(t):(alert("La dirección es erronea, por favor ingresa de nuevo."),this.$store.commit("GET_DISABLE",!1),this.submit=!1)})},calculateDistance(t,e,s,a,o,i,l,r){const c=function(t){return t*Math.PI/180};let n,d,m;let p=c(s-t),u=c(a-e);n=Math.sin(p/2)*Math.sin(p/2)+Math.cos(c(t))*Math.cos(c(s))*Math.sin(u/2)*Math.sin(u/2),d=2*Math.atan2(Math.sqrt(n),Math.sqrt(1-n)),m=6378.137*d,this.total_km=Math.round(m),"on"!=o?(this.freestate=!1,r>=Math.round(m)?this.total_result=i:this.total_result=this.total_km*l):(this.freestate=!0,this.total_result=0)},closeCancel(){this.initializeMap(),this.submit=!1,this.total_km=null,this.$store.commit("GET_ADDRESS",""),this.$store.commit("GET_CITY",""),this.$store.commit("GET_DISABLE",!1)},confirmAddress(){this.$store.commit("GET_LOADER",!0);let t=[this.coorclient,this.coorreseller,this.total_result];_.a.ajax({type:"POST",url:"./../wp-admin/admin-ajax.php",data:{action:"wp_insert_pressing_shipping",resp:t},success:t=>{_()("body").trigger("update_checkout"),localStorage.setItem("city_info",this.$store.state.city),localStorage.setItem("city_address",this.$store.state.address),localStorage.setItem("modal_address","true"),location.reload()},error:function(t){console.log("Error "+t)}})}},computed:{...Object(d.b)(["address","city","loader"]),urlCart:function(){const{urlcart:t}=l;return t}}},g=(s(41),{components:{GoogleMapLoader:Object(c.a)(h,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row"},[s("div",{ref:"googleMap",staticClass:"google-map col-12"}),t._v(" "),null!=t.total_km&&"NaN"!=t.total_km?s("div",{staticClass:"container-sidebar-map"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-xs-12 col-sm-4 p-2"},[t._m(0),t._v(" "),s("p",[t._v("Distancia: "+t._s(t.total_km)+" Km")]),t._v(" "),1!=t.freestate?s("p",[t._v("Costo de envio: $"+t._s(t.total_result))]):s("p",[t._v(" Servicio Gratis ")])]),t._v(" "),s("div",{staticClass:"col-xs-12 col-sm-8 p-2"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-6"},[s("b-button",{staticClass:"btn-submit-map-cancel",on:{click:t.closeCancel}},[t._v("Cancelar")])],1),t._v(" "),s("div",{staticClass:"col-6"},[s("b-button",{staticClass:"btn-submit-map",on:{click:t.confirmAddress}},[t._v("Confirmar")])],1)])])])]):t._e(),t._v(" "),t.submit?t._e():s("div",{staticClass:"col-12"},[s("b-button",{staticClass:"btn-submit-map-send",on:{click:t.startCalculate}},[t._v("Calcular Envio")])],1),t._v(" "),s("a",{staticClass:"btn-back-cart",attrs:{href:t.urlCart}},[t._v("Volver")])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("p",[e("span",{staticClass:"icon-pointers-map"},[this._v("A:")]),this._v(" Yo |\n                    "),e("span",{staticClass:"icon-pointers-map"},[this._v("B:")]),this._v(" Tienda")])}],!1,null,"6737d96e",null).exports},computed:{keyGoogle:function(){const{key:t}=l;return t}}}),v={name:"App",components:{GoogleGeocode:n,TravelMap:Object(c.a)(g,(function(){var t=this.$createElement;return(this._self._c||t)("GoogleMapLoader",{attrs:{apiKey:this.keyGoogle}})}),[],!1,null,null,null).exports},computed:{...Object(d.b)(["address","city","loader"]),disableModal:()=>localStorage.getItem("modal_address"),image_logo:()=>l.img}},b=Object(c.a)(v,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return"true"!=t.disableModal?s("section",{staticClass:"container-map-address"},[s("div",{staticClass:"container-map"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-xs-12 col-sm-4"},[s("img",{staticClass:"img-logo-map",attrs:{src:t.image_logo,alt:"img-logo-map"}})]),t._v(" "),t._m(0)]),t._v(" "),s("GoogleGeocode"),t._v(" "),s("TravelMap",{staticClass:"travel-map"}),t._v(" "),0!=t.loader?s("div",[t._m(1)]):t._e()],1)]):t._e()}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-xs-12 col-sm-8"},[e("h2",{staticClass:"title-map-center"},[this._v("Donde quieres que te entreguemos el pedido.")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"lds-tiplle-container"},[e("div",{staticClass:"lds-ripple"},[e("div"),e("div")]),this._v(" "),e("p",{staticClass:"loader-text"},[this._v("Procesando...")])])}],!1,null,"0c6d639e",null).exports;a.a.use(d.a);var f=new d.a.Store({state:{address:"",city:"",disable:!1,loader:!1},mutations:{GET_ADDRESS(t,e){t.address=e},GET_CITY(t,e){t.city=e},GET_DISABLE(t,e){t.disable=e},GET_LOADER(t,e){t.loader=e}},actions:{}}),C=s(19);s(44);a.a.config.productionTip=!1,a.a.use(C.a),new a.a({el:"#frontend-checkout-map",store:f,render:t=>t(b)})},5:function(t,e,s){},6:function(t,e,s){}},[[48,0,1]]]);