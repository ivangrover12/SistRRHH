<template>
  <v-dialog persistent v-model="dialog" max-width="900px" @keydown.esc="close">
    <v-tooltip slot="activator" top>
      <v-icon large slot="activator" dark color="primary">add_circle</v-icon>
      <span>Nuevo</span>
    </v-tooltip>
    <v-card>
      <v-toolbar dark color="primary">
        <v-toolbar-title class="white--text">{{ formTitle }}</v-toolbar-title>
        <v-alert
          :value="true"
          type="warning"
          v-if="selectedIndex != -1"
        >
          Sí no sube ningún archivo se mantendra el anterior
        </v-alert>
      </v-toolbar>
      <v-card-text>        
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-layout wrap>
            <v-flex xs12 sm6 md6>
              <v-card-text>              
                <v-autocomplete
                  :items="employees"
                  :item-text="item => item.first_name+' '+item.last_name+' '+item.second_name"
                  item-value="id"
                  v-model="selectedItem.employee_id"
                  label="Trabajadores"
                  :rules="[v => !!v || 'Requerido']"
                ></v-autocomplete>
                <v-text-field
                  v-model="selectedItem.emision"
                  type="date"
                  label="Fecha de emisión"
                  :rules="[v => !!v || 'Requerido']"
                ></v-text-field>
              </v-card-text>
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs12 sm6 md6>
              <v-card-text>  
                <v-text-field 
                  label="Subir archivo"
                  @click='onPickFile'
                  v-model='fileName'
                  prepend-icon="attach_file"
                ></v-text-field>
                <!-- Formulario abstracto para extracción de archivos -->
                <input
                  type="file"
                  style="display: none"
                  ref="fileInput"
                  accept="application/pdf, image/*"
                  @change="onFilePicked">
                <v-text-field
                  v-model="selectedItem.conclusion"
                  type="date"
                  label="Fecha de conclusión"
                  :rules="[v => !!v || 'Requerido']"
                ></v-text-field>               
              </v-card-text>
            </v-flex>
          </v-layout>
        </v-form>
      </v-card-text>  
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" small @click.native="close"><v-icon>close</v-icon> Cancelar</v-btn>
        <v-btn color="primary" small :disabled="!valid" @click="save()" ><v-icon>check</v-icon> Guardar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import Vue from 'vue'
export default {
  props: ["item", "bus"],  
  data() {
    return {      
      valid: true,
      dialog: false,
      selectedIndex: -1,     
      selectedItem: {},
      error: '',
      employees: [],
      file: null,
      loading: false,
      fileName: '',
      fileObject: null
    };
  },
  created() {},  
  mounted() {
    this.bus.$on("openDialog", item => {
      this.selectedItem = item;
      this.dialog = true;
      this.selectedIndex = item;
    });
    this.getEmployees()
  },
  computed: {
    formTitle() {
      return this.selectedIndex === -1 ? 'Nuevo ' : 'Editar '
    }    
  },
  methods: {
    close() {
      this.dialog = false;
      this.$refs.form.reset()
      this.bus.$emit("closeDialog");
      this.selectedIndex = -1;
      this.selectedItem = {}
      this.fileObject = null
    },
    async save() {
      try {
        if (this.$refs.form.validate()) {
          if (this.selectedIndex != -1) {
            if(this.fileObject != null){
              const data = new FormData()
              data.append('file', this.fileObject)
              let res = await axios.post('upload/file', data)
              this.selectedItem.respaldo = res.data
              await axios.put("/health_card/"+this.selectedItem.id, this.selectedItem)
            }
            else{
              await axios.put("/health_card/"+this.selectedItem.id, this.selectedItem)
            }
          } else {
            const data = new FormData()//envia archivos al servidor
            data.append('file', this.fileObject)
            let res = await axios.post('upload/file', data)
            this.selectedItem.respaldo = res.data
            await axios.post("/health_card", this.selectedItem)
          }
          this.toastr.success('Correcto.')
          this.close();
        }
      } catch(e) {
        console.log(e)
      }
    },
    async getEmployees(){
      try{
        let res = await axios.get('employee')
        this.employees = res.data
      }
      catch(e){
        console.log(e)
      }
    },
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
  },  
};
</script>