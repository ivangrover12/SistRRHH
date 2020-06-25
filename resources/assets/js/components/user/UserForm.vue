<template>
  <v-dialog persistent v-model="dialog" max-width="900px" @keydown.esc="close">
    <v-card>
      <v-toolbar dark color="secondary">
        <v-toolbar-title class="white--text">Agregar usuario</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-form ref="form">
          <v-layout wrap>
            <v-flex xs12 sm12 md12>
              <v-card-text>
                <v-autocomplete
                  v-model="selectedItem.employee_id"
                  :items="employees"
                  :item-text="item => item.first_name+' '+item.second_name+' '+item.last_name+' '+item.mothers_last_name"
                  item-value="id"
                  label="Seleccione al trabajador"
                  :rules="[v => !!v || 'Requerido']">
                ></v-autocomplete>
              </v-card-text>
            </v-flex>
          </v-layout>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" @click.native="close"><v-icon>close</v-icon> Cancelar</v-btn>
        <v-btn color="success" :disabled="!valid" @click="addUser()" ><v-icon>check</v-icon> Agregar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: ["item", "bus"],
  data() {
    return {
      valid: true,
      dialog: false,
      selectedIndex:  -1,
      selectedItem:   {
        employee_id: 0
      },
      employees: []
    };
  },
  methods: {
    async getEmployees() {
      try {
        let employees = []
        let users = []
        let list = []
        let sw = false
        let res = await axios.get('/employee')
        employees = res.data
        let res2 = await axios.get('/user')
        users = res2.data
        employees.forEach(employee => {
          users.forEach(user => {
            if(user.employee_id == employee.id){
              sw = true
            }
          })
          if(!sw){
            this.employees.push(employee)
          }
          sw = false
        })
      } catch(e) {
        console.log(e)
      }
    },
    close() {
      this.dialog = false;
      this.$validator.reset();
      this.bus.$emit("closeDialog");
      this.selectedItem = {}
    },
    async addUser() {
        try {
          if (this.$refs.form.validate()) {
            let res = await axios.post('/user', this.selectedItem)
            this.close()
            this.toastr.success('Usuario creado correctamente')
          }
        } catch(e) {
          console.log(e)
        }
    }
  },
  mounted() {
    this.bus.$on("openDialogAddUser", () => {
      this.dialog = true;
      this.getEmployees()
    });
  },
};
</script>