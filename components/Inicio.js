app.component('web-inicio', {
    template: /*html*/ `
    <div class="row justify-content-center align-items-center vh-100 animate__animated animate__fadeIn">
            
        <div class="col-md-10 mx-auto">
            <div class="row justify-content-center align-items-center vh-100">

                <div class="col-lg-6 mx-auto text-center">
                    <img src="../img/register-image.jpg" class="mx-auto img-fluid d-none d-lg-block">
                    <img src="../img/logoCongreso.png" class="mx-auto img-fluid d-block d-lg-none">
                </div>
                <div class="col-lg-6 mx-auto">

                    <div class="mx-2 mx-md-5 my-md-5 my-3">

                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">¡PRE-REGISTRO!</h1>
                          </div>
                          <form class="user" @submit.prevent="alta">
                            <div class="form-group row">
                              <div class="col-sm-4 col-lg-12 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user mb-3 mayusculas" v-model="nUsr" placeholder="Nombre(s)*" @keypress="soloLetras" required />
                              </div>
                              <div class="col-sm-4 col-lg-12 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user mb-3 mayusculas" v-model="aPat" placeholder="Apellido Paterno*" @keypress="soloLetras" required />
                              </div>
                              <div class="col-sm-4 col-lg-12 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user mb-3 mayusculas" v-model="aMat" placeholder="Apellido Materno*" @keypress="soloLetras" required />
                              </div>
                              <div class="form-group">
                              <input type="text" class="form-control form-control-user mb-3 mayusculas" v-model="nInst" placeholder="Institución*" @keypress="soloLetras" required />
                            </div>
                              <div class="col-md-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user mb-3 mayusculas" v-model="rfc" placeholder="RFC*" @keypress="soloLetras" minlength="10" maxlength="13" required />
                              </div>
                              <div class="col-md-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user mb-3" v-model="tel" placeholder="Teléfono*" pattern="[0-9]+" @keypress="soloNumeros" minlength="10" maxlength="15" required />
                              </div>
                            </div>
                            <div class="form-group">
                              <select class="form-select form-control-user mb-3" v-model="modalidad" required>
                                <option value="" disabled selected hidden>Modalidad*</option>
                                <option value="PRESENCIAL">PRESENCIAL</option>
                                <option value="VIRTUAL">VIRTUAL</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <input type="email" class="form-control form-control-user mb-3" v-model="nCorreo" placeholder="Correo electrónico*" required />
                            </div>
                            <div class="form-group" v-html="datos"></div>
                            <div class="form-group row">
                              <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user mb-3" v-model="passUsr" placeholder="Contraseña*" required />
                              </div>
                              <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user mb-3" v-model="passUsrDos" placeholder="Repetir contraseña*" :disabled="estadoPass" required />
                              </div>
                            </div>
          
                            <div :class="notificaEstadoPass" role="alert">
                              {{validaContrasena}}
                            </div>
                            <button class="btn btn-primary form-control form-control-user my-3" :disabled="this.nUsr != '' && this.aPat != '' && this.aMat != '' && this.rfc != '' && this.tel != '' && this.nInst !='' && this.modalidad != '' && this.nCorreo != '' && this.passUsr != '' && this.passUsrDos != '' && this.validaBtn === true ? this.estadoBtn = flase : this.estadoBtn = true">
                              Registrar cuenta
                            </button>
          
                          </form>
                        <hr>
                        <div class="text-center">
                            <router-link class="a" to="/inicio-estatus">¿Ya tienes una cuenta? ¡Verifica tú estatus!</router-link>
                        </div>

                    </div>
                    
                </div>

            </div>                   

        </div>
    </div>
    `,
    data () {
        return {
            datos: '',            
            nUsr: '',
            aPat: '',
            aMat: '',
            nInst: '',
            rfc: '',
            tel: '',
            modalidad: '',
            nCorreo: '',
            passUsr: '',
            passUsrDos: '',            
            msgAlert: '',
            estadoPass: true,
            notificaEstadoPass: '',
            validaBtn: false,
            estadoBtn: false
        }
    },
    computed: {
        validaContrasena() {
            this.notificaEstadoPass = 'small alert alert-light text-muted'
  
            if (this.passUsr.length >= 6) {
  
              this.estadoPass = false
              this.msgAlert = 'La contraseña debe tener al menos seis (6) caracteres.'
              this.validaBtn = false
  
              if (this.passUsrDos.length >= 6) {
  
                if (this.passUsr === this.passUsrDos) {
  
                  this.notificaEstadoPass = 'small alert alert-success'
                  this.msgAlert = 'Contraseña valida.'
                  this.validaBtn = true
  
                } else {
                  this.notificaEstadoPass = 'small alert alert-danger'
                  this.msgAlert = '¡Error! Las contraseñas no coinciden.'
                  this.validaBtn = false
                }
  
  
  
              } else {
                this.estadoPass = false
                this.validaBtn = false
              }
  
            } else {
              this.msgAlert = 'La contraseña debe tener al menos seis (6) caracteres.'
  
              if (this.passUsrDos != '') {
                this.estadoPass = false
                this.validaBtn = false
              } else {
                this.estadoPass = true
                this.validaBtn = false
              }
  
            }
  
  
  
            return this.msgAlert
          }

    },
    methods: {
        alta () {
            axios.post('../registro/alta.app', {
                opcion: 1,
                nUsr: this.nUsr,
                aPat: this.aPat,
                aMat: this.aMat,
                nInst: this.nInst,
                rfc: this.rfc,
                tel: this.tel,
                modalidad: this.modalidad,
                nCorreo: this.nCorreo,
                passUsr: this.passUsr,                
            })
            .then(response => {
                if (response.data === 'correcto') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Alta exitosa!',
                        showConfirmButton: false,
                        timer: 2000,
                        onClose: () => {  
                          window.location="https://sfpya.edomexico.gob.mx/recaudacion/";
                        }
                    })
                }else{
                    this.datos = response.data
                    // console.log(response.data)
                }
            })
        },
        soloLetras () {
          if (event.keyCode > 32 && event.keyCode < 48 || event.keyCode > 57 && event.keyCode < 65 || event.keyCode > 90 && event.keyCode < 97 || event.keyCode > 122 && event.keyCode < 160 || event.keyCode > 166 && event.keyCode < 190) event.returnValue = false
        },
        soloNumeros () {
          if (event.keyCode >= 32 && event.keyCode < 48 || event.keyCode > 57 && event.keyCode < 190) event.returnValue = false
        },
        
    },
    created () {
        
    },
    mounted() {
        
    },
  })



app.component('inicio-estatus', {
    template: /*html*/ `
    <div class="row justify-content-center align-items-center vh-100 animate__animated animate__fadeIn">
            
        <div class="col-md-10 mx-auto">
            <div class="row justify-content-center align-items-center vh-100">

                <div class="col-lg-6 mx-auto">

                    <div class="mx-2 mx-md-5 my-md-5 my-3">

                        <div class="text-center">
                            <img src="../img/logoCongreso.png" alt="Logo" class="img-fluid mb-3" style="width: 90%;">
                            <h1 class="h4 text-gray-900 mb-4">¡Verifica tu estatus!</h1>
                          </div>
                          <form class="user" @submit.prevent="alta">
                            <div class="form-group row">
                              <div class="mb-3 mb-sm-0">
                                <input type="email" class="form-control form-control-user mb-3" v-model="nCorreo" placeholder="Correo electrónico*" required />
                              </div>
                            </div>
                            <div class="form-group" v-html="datos"></div>
                            <div class="form-group row">
                              <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user mb-3" v-model="passUsr" placeholder="Contraseña*" required />
                              </div>
                              <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user mb-3" v-model="passUsrDos" placeholder="Repetir contraseña*" :disabled="estadoPass" required />
                              </div>
                            </div>
          
                            <div :class="notificaEstadoPass" role="alert">
                              {{validaContrasena}}
                            </div>
                            <button class="btn btn-primary form-control form-control-user my-3" :disabled="this.nCorreo != '' && this.passUsr != '' && this.passUsrDos != '' && this.validaBtn === true ? this.estadoBtn = flase : this.estadoBtn = true">
                              Verificar
                            </button>
          
                          </form>
                        <hr>
                        <div class="text-center">
                            <router-link class="a" to="/">¡Regístrate!</router-link>
                        </div>

                    </div>
                    
                </div>

            </div>                   

        </div>
    </div>
    `,
    data () {
        return {
            datos: '',            
            nUsr: '',
            aPat: '',
            aMat: '',
            nInst: '',
            rfc: '',
            tel: '',
            nCorreo: '',
            passUsr: '',
            passUsrDos: '',            
            msgAlert: '',
            estadoPass: true,
            notificaEstadoPass: '',
            validaBtn: false,
            estadoBtn: false
        }
    },
    computed: {
        validaContrasena() {
            this.notificaEstadoPass = 'small alert alert-light text-muted'
  
            if (this.passUsr.length >= 6) {
  
              this.estadoPass = false
              this.msgAlert = 'La contraseña debe tener al menos seis (6) caracteres.'
              this.validaBtn = false
  
              if (this.passUsrDos.length >= 6) {
  
                if (this.passUsr === this.passUsrDos) {
  
                  this.notificaEstadoPass = 'small alert alert-success'
                  this.msgAlert = 'Contraseña valida.'
                  this.validaBtn = true
  
                } else {
                  this.notificaEstadoPass = 'small alert alert-danger'
                  this.msgAlert = '¡Error! Las contraseñas no coinciden.'
                  this.validaBtn = false
                }
  
  
  
              } else {
                this.estadoPass = false
                this.validaBtn = false
              }
  
            } else {
              this.msgAlert = 'La contraseña debe tener al menos seis (6) caracteres.'
  
              if (this.passUsrDos != '') {
                this.estadoPass = false
                this.validaBtn = false
              } else {
                this.estadoPass = true
                this.validaBtn = false
              }
  
            }
  
  
  
            return this.msgAlert
          }

    },
    methods: {
        alta () {
            axios.post('../verifica/alta.app', {
                opcion: 1,
                nCorreo: this.nCorreo,
                passUsr: this.passUsr,                
            })
            .then(response => {
                if (response.data === 'correcto') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Usuario Activado!',
                        showConfirmButton: false,
                        timer: 2000,
                        onClose: () => {  
                          window.location="http://congreso-nacional-2021.utleon.edu.mx/";
                        }
                    })
                }else{
                    this.datos = response.data
                    // console.log(response.data)
                }
            })
        },
        soloLetras () {
          if (event.keyCode > 32 && event.keyCode < 48 || event.keyCode > 57 && event.keyCode < 65 || event.keyCode > 90 && event.keyCode < 97 || event.keyCode > 122 && event.keyCode < 160 || event.keyCode > 166 && event.keyCode < 190) event.returnValue = false
        },
        soloNumeros () {
          if (event.keyCode >= 32 && event.keyCode < 48 || event.keyCode > 57 && event.keyCode < 190) event.returnValue = false
        },
        
    },
    created () {
        
    },
    mounted() {
        
    },
  })