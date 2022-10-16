app.component('web-inicio', {
    template: /*html*/ `
    <div class="row justify-content-center animate__animated animate__fadeIn">
      <div class="col-sm-11 col-lg-10 mx-auto my-5">
        <div class="row justify-content-center">
          <div class="col-sm-12 col-md-8 col-lg-8 col-xl-7 mx-auto">

            <div class="card border rounded bg-light p-5">
              <div class="card-body">
                <form @submit.prevent="buscar">
                  <div class="form-group">
                      <label for="">Buscador:</label>
                      <div class="input-group">

                          <input type="text" class="form-control upper" v-model="txtBuscador" placeholder="Buscar..." />
                          <button type="submit" class=" input-group-tex btn btn-primary"><i class="fas fa-search fa-sm me-1"></i>Buscar</button>

                      </div>
                  </div>
              </form>
              </div>
            </div>

            <div v-for="(liDatos, index) in datos">

              <div class="card border rounded bg-light my-3" style="font-size: .8em;">
                <div class="card-body">

                  <div class="text-center mx-auto">
                    <img class="img-fluid rounded" onerror="javascript:this.src='../img/buscador/usr.svg'" :src="'../img/buscador/empleados/' + liDatos.numEmpleadoReal + '.jpg'" style="width: 200px;">
                  </div>
                  
                  <table>
                   
                    <tr>
                      <td>  
                        <p>
                          Número Real:
                          <br>
                          <b>{{liDatos.numEmpleadoReal}}</b>
                          <br>
                          Número de Empleado:
                          <br>
                          <b>{{liDatos.numEmpleado}} - {{liDatos.clv}}</b>
                          <br>
                          Nombre Completo:
                          <br>
                          <b>{{liDatos.nombreCompleto}}</b>
                          <br>
                          Fecha de Nacimiento:
                          <br>
                          <b>{{liDatos.cumplenos}}</b>
                          <br>
                          Área de adscripción:
                          <br>
                          <b>{{liDatos.area}}</b>
                          <br>
                          Cargo:
                          <br>
                          <b>{{liDatos.puesto}}</b>
                          <br>
                          Fecha de adscripción:
                          <br>
                          <b>{{liDatos.fechaAlta}}</b>
                          <br>
                          Horas frente a grupo:
                          <br>
                          Horas no frente a grupo:
                          <br>
                          Total de horas:
                          <br>
                          Motivo:
                          <br>
                          Sueldo neto 15nal:
                          <br>
                          Lugar de residencia:
                          <br>
                          Datos Clínicos:
                          <br>
                          Observaciones:
                        </p>
  
                      </td>
  
                      
                    </tr>
                    
                  </table>
                </div>
              </div>

            </div>


          </div>
        </div>
      </div>
    </div> 
    `,
    data () {
        return {
          datos: [],
          txtBuscador: '',
        }
    },
    computed: {
        ...Vuex.mapState(['titulo']),
        
    },
    methods: {
        buscar () {
            axios.post('../buscador/buscar.app', {
                opcion: 4,
                txtBuscador: this.txtBuscador.toUpperCase(),
              })
              .then(response => {
                this.datos = response.data
                // console.log(response.data)               

            })
        }
    },
    created () {
      
    },
    mounted() {

    },
    
})