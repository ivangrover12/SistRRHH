<template>
  <v-dialog persistent v-model="dialog" max-width="900px" @keydown.esc="close" scrollable>
    <v-tooltip slot="activator" top v-if="$store.getters.permissions.includes('create-employee')">
      <v-icon large slot="activator" dark color="primary">add_circle</v-icon>
      <span>Nuevo Personal</span>
    </v-tooltip>
    <v-card>
      <v-toolbar dark color="primary">
        <v-toolbar-title class="black--text">Datos del Empleado</v-toolbar-title>
      <v-alert
          :value="true"
          outline color="warning" icon="priority_high"
          v-if="newEmployee == false"
        >
          Sí no sube ningúna foto o archivo se mantendra el anterior
        </v-alert>
      </v-toolbar>
      <v-card-text>
        <form ref="form">
          <v-layout wrap>
            <v-flex xs12 sm6 md6>
              <v-layout wrap>
                <v-flex xs5 sm5 md5 pr-2>
                  <v-text-field
                    v-validate="'required'"
                    :error-messages="errors.collect('Carnet de Identidad')"
                    data-vv-name="Carnet de Identidad"
                    v-model="edit.identity_card"
                    label="C.I."
                  ></v-text-field>
                </v-flex>
                <v-spacer></v-spacer>
                <v-flex xs3 sm3 md3 pl-2 pr-2>
                  <v-select
                    v-validate="'required'"
                    :error-messages="errors.collect('Ciudad de Expedición')"
                    data-vv-name="Ciudad de Expedición"
                    :items="cities"
                    item-text="shortened"
                    item-value="id"
                    label="Ciudad"
                    v-model="edit.city_identity_card_id"
                    single-line
                    :menu-props="{ auto: true, overflowY: true }"
                  ></v-select>
                </v-flex>
                <v-flex xs4 sm4 md4 pl-2>
                  <v-select
                    v-validate="'required'"
                    :error-messages="errors.collect('Género')"
                    data-vv-name="Género"
                    :items="genders"
                    item-text="name"
                    item-value="value"
                    label="Género"
                    v-model="edit.gender"
                    single-line
                    :menu-props="{ auto: true, overflowY: true }"
                  ></v-select>
                </v-flex>
              </v-layout>
              <v-layout wrap>
                <v-flex xs12 sm6 md6 lg6 pr-2>
                  <v-text-field
                    v-validate="'required|alpha_spaces'"
                    :error-messages="errors.collect('Apellido Paterno')"
                    data-vv-name="Apellido Paterno"
                    v-model="edit.last_name"
                    label="Apellido Paterno"
                    autocomplete='last-name'
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6 lg6 pl-2>
                  <v-text-field
                    v-validate="'required|alpha_spaces'"
                    :error-messages="errors.collect('Apellido Materno')"
                    data-vv-name="Apellido Materno"
                    v-model="edit.mothers_last_name"
                    label="Apellido Materno"
                    autocomplete='family-name'
                  ></v-text-field>
                </v-flex>
              </v-layout>
              <v-layout wrap>
                <v-flex xs12 sm6 md6 lg6 pr-2>
                  <v-text-field
                    v-validate="'required|alpha_spaces'"
                    :error-messages="errors.collect('Primer nombre')"
                    data-vv-name="Primer nombre"
                    v-model="edit.first_name"
                    label="Primer nombre"
                    autocomplete='given-name'
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6 lg6 pl-2>
                  <v-text-field
                    v-validate="'alpha_spaces'"
                    :error-messages="errors.collect('Segundo nombre')"
                    data-vv-name="Segundo nombre"
                    v-model="edit.second_name"
                    label="Segundo nombre"
                    autocomplete='given-name'
                  ></v-text-field>
                </v-flex>
              </v-layout>
              <v-layout wrap>
                <v-flex xs6 sm6 md6 pr-2>
                  <v-menu
                    ref="menu"
                    :close-on-content-click="false"
                    v-model="menu"
                    :nudge-right="40"
                    lazy
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="290px"
                  >
                    <v-text-field
                      v-validate="'required'"
                      :error-messages="errors.collect('Fecha de Nacimiento')"
                      data-vv-name="Fecha de Nacimiento"
                      slot="activator"
                      v-model="birth_date_formatted"
                      label="Fecha de Nacimiento"
                      prepend-icon="event"
                      readonly
                    ></v-text-field>
                    <v-date-picker
                      ref="picker"
                      v-model="birth_date"
                      :max="this.maxDate.format('Y-M-D')"
                      :min="this.minDate.format('Y-M-D')"
                      locale="es-bo"
                      @change="saveDate"
                      first-day-of-week="1"
                    ></v-date-picker>
                  </v-menu>
                </v-flex>
                <v-flex xs6 sm6 md6 pl-2>
                  <v-select
                    v-validate="'required'"
                    :error-messages="errors.collect('Lugar de Nacimiento')"
                    data-vv-name="Lugar de Nacimiento"
                    :items="cities"
                    item-text="name"
                    item-value="id"
                    label="Lugar de Nacimiento"
                    v-model="edit.city_birth_id"
                    single-line
                    :menu-props="{ auto: true, overflowY: true }"
                  ></v-select>
                </v-flex>
                <v-flex xs12 sm12 md12 pl-2>
                <v-text-field
                  v-validate="'numeric|min:14|max:14'"
                  :error-messages="errors.collect('Cuenta bancaria')"
                  data-vv-name="Cuenta bancaria"
                  v-model="edit.account_number"
                  :label="`Cuenta bancaria [${edit.account_number ? edit.account_number.length : 0} dígitos]`"
                ></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12 pl-2>
                <v-card-text>  
                <v-text-field
                 color="indigo"
                 label="Subir foto del personal" 
                  @click='onPickFile1'
                  v-model='fileName'
                  prepend-icon="person"
                ></v-text-field>
                <!-- Formulario abstracto para extracción de archivos -->
                <input
                  type="file"
                  style="display: none"
                  ref="fileInput"
                  accept="application/pdf, image/*"
                  @change="onFilePicked1">
              </v-card-text>
                </v-flex>
              </v-layout>
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs12 sm5 md5>
              <v-layout wrap>
                <v-flex xs12 sm8 md8 lg8 pr-2>
                  <v-text-field
                    v-validate="'numeric'"
                    :error-messages="errors.collect('NUA/CUA')"
                    data-vv-name="NUA/CUA"
                    v-model="edit.nua_cua"
                    label="NUA/CUA"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm4 md4 lg4 pl-2>
                  <v-select
                    :items="managementEntities"
                    item-text="name"
                    item-value="id"
                    label="AFP"
                    v-model="edit.management_entity_id"
                    single-line
                    :menu-props="{ auto: true, overflowY: true }"
                    v-validate="'required'"
                    :error-messages="errors.collect('AFP')"
                    data-vv-name="AFP"
                  ></v-select>
                </v-flex>
              </v-layout>
              <v-text-field
                v-validate="'required'"
                :error-messages="errors.collect('Ciudad')"
                data-vv-name="Ciudad"
                v-model="edit.location"
                label="Ciudad"
                autocomplete='address-level1'
              ></v-text-field>
              <v-text-field
                v-validate="'required'"
                :error-messages="errors.collect('Zona')"
                data-vv-name="Zona"
                v-model="edit.zone"
                label="Zona"
              ></v-text-field>
              <v-layout wrap>
                <v-flex xs12 sm8 md8 lg8 pr-2>
                  <v-text-field
                    v-validate="'required'"
                    :error-messages="errors.collect('Calle')"
                    data-vv-name="Calle"
                    v-model="edit.street"
                    label="Calle"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm4 md4 lg4 pl-2>
                  <v-text-field
                    v-validate="'required'"
                    :error-messages="errors.collect('Número de puerta')"
                    data-vv-name="Número de puerta"
                    v-model="edit.address_number"
                    label="# de puerta"
                  ></v-text-field>
                </v-flex>
              </v-layout>
              <v-layout wrap>
                <v-flex xs12 sm6 md6 lg6 pr-2>
                  <v-text-field
                    v-validate="'required|numeric|min:8|max:8'"
                    :error-messages="errors.collect('Celular')"
                    data-vv-name="Celular"
                    v-model="edit.phone_number"
                    label="Celular"
                    autocomplete='tel'
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6 lg6 pr-2>
                  <v-text-field
                    v-validate="'numeric'"
                    :error-messages="errors.collect('Teléfono')"
                    data-vv-name="Teléfono"
                    v-model="edit.landline_number"
                    label="Teléfono"
                    autocomplete='tel'
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12 pl-12>
                <v-card-text>  
                <v-text-field color="indigo"
                label="Subir Curriculum en PDF"
                  @click='onPickFile'
                  v-model='fileName1'
                  prepend-icon="attach_file"
                ></v-text-field>
                <!-- Formulario abstracto para extracción de archivos -->
                <input
                  type="file"
                  style="display: none"
                  ref="fileInput1"
                  accept="application/pdf, image/*"
                  @change="onFilePicked">
              </v-card-text>
                </v-flex>
              </v-layout>
            </v-flex>
          </v-layout>
        </form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" @click.native="close"><v-icon>close</v-icon> Cancelar</v-btn>
        <v-btn color="primary" :disabled="this.errors.any()" @click.native="saveEmployee"><v-icon>check</v-icon> Guardar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "EmployeeEdit",
  props: ["employee", "bus"],
  data() {
    return {
      genders: [
        {
          name: "FEMENINO",
          value: "F"
        },
        {
          name: "MASCULINO",
          value: "M"
        }
      ],
      birth_date: null,
      birth_date_formatted: null,
      edit: {},
      cities: [],
      file: null,
      fileName: '',
      fileObject: null,
      fileName1: '',
      fileObject1: null,
      managementEntities: [],
      dialog: false,
      newEmployee: true,
      date: null,
      menu: false,
      minDate: this.$moment(this.$store.getters.dateNow).subtract(100, 'years') || this.$moment().subtract(150, 'years'),
      maxDate: this.$moment(this.$store.getters.dateNow).subtract(18, 'years') || this.$moment().subtract(18, 'years')
    };
  },
  methods: {
    onPickFile () {
      this.$refs.fileInput.click()
    },
    onFilePicked (event) {
      const files = event.target.files
      if (files[0] !== undefined) {
        this.fileName = files[0].name
        if (this.fileName.lastIndexOf('.') <= 0) {
          return
        }
        // If valid, continue
        const fr = new FileReader()
        fr.readAsDataURL(files[0])
        fr.addEventListener('load', () => {
          this.url = fr.result
          this.fileObject = files[0]
          
        })
      } else {
        this.fileName = ''
        this.fileObject = null
        this.url = ''
      }
    },
    onPickFile1 () {
      this.$refs.fileInput1.click()
    },
    onFilePicked1 (event) {
      const files = event.target.files
      if (files[0] !== undefined) {
        this.fileName1 = files[0].name
        if (this.fileName1.lastIndexOf('.') <= 0) {
          return
        }
        // If valid, continue
        const fr = new FileReader()
        fr.readAsDataURL(files[0])
        fr.addEventListener('load', () => {
          this.url = fr.result
          this.fileObject1 = files[0]
          
        })
      } else {
        this.fileName1 = ''
        this.fileObject1 = null
        this.url = ''
      }
    },
    resetVariables() {
      this.newEmployee = true;
      this.edit = {};
      this.birth_date = null;
      this.birth_date_formatted = null;
    },
    close() {
      this.resetVariables();
      this.dialog = false;
      this.$validator.reset();
      this.bus.$emit("closeDialog");
      this.edit = {}
      this.fileObject = null
    },
    async getCities() {
      try {
        let res = await axios.get(`/city`);
        this.cities = res.data;
      } catch (e) {
        this.dialog = false;
        console.log(e);
      }
    },
    async getManagementEntities() {
      try {
        let res = await axios.get(`/management_entity`);
        this.managementEntities = res.data;
      } catch (e) {
        this.dialog = false;
        console.log(e);
      }
    },
    async saveEmployee() {
      try {
        let valid = await this.$validator.validateAll();
        let res;
        let res1;
        let res2;
        let res3;
        let res4;
        if (valid) {
          if (this.newEmployee) {
            res = await axios.post(`/employee`, this.edit);
            const data1 = new FormData()//envia archivos al servidor
            const data2 = new FormData()//envia archivos al servidor
            data1.append('file1', this.fileObject)
            data2.append('file2', this.fileObject1)
            let res1 = await axios.post('upload/photo', data1)
            let res2 = await axios.post('upload/curriculum', data2)
            this.edit.photo = res1.data
            this.edit.curriculum = res2.data
            await axios.post("/employee", this.edit)
            this.toastr.success('Insertado correctamente')
          } else {
            if(this.fileObject != null){
              const data1 = new FormData()
              data1.append('file1', this.fileObject)
              let res3 = await axios.post('upload/photo', data1)
              this.edit.photo = res3.data
              //await axios.put("/employee/"+this.edit.id, this.edit)
            }
            
            if(this.fileObject1 != null){
              const data2 = new FormData()
              data2.append('file2', this.fileObject1)
              let res4 = await axios.post('upload/curriculum', data2)
              this.edit.curriculum = res4.data
              //await axios.put("/employee/"+this.edit.id, this.edit)
            }
            
            res = await axios.patch(`/employee/${this.edit.id}`, this.edit);
            this.toastr.success('Actualizado correctamente')
          }
          this.close();
        }
      } catch (e) {
        console.log(e);
      }
    },
    async saveDate(date) {
      this.$refs.menu.save(date);
    }
  },
  mounted() {
    this.bus.$on("openDialog", employee => {
      this.edit = employee;
      this.birth_date = this.edit.birth_date;
      this.dialog = true;
      this.newEmployee = employee ? false : true;
      this.maxDate = this.$moment(this.$store.getters.dateNow).subtract(18, 'years')
      this.minDate = this.$moment(this.$store.getters.dateNow).subtract(100, 'years')
    });
    this.getCities();
    this.getManagementEntities();
  },
  watch: {
    menu(val) {
      val && this.$nextTick(() => (this.$refs.picker.activePicker = "YEAR"));
    },
    birth_date(val) {
      this.birth_date_formatted = this.$moment(val).format("DD/MM/YYYY") || this.$moment().format("DD/MM/YYYY");
      this.edit.birth_date = this.$moment(val).format("YYYY-MM-DD");
    }
  }
};
</script>