<template>
  <v-container fluid>
    <v-toolbar>
        <v-toolbar-title>Carnets Sanitarios</v-toolbar-title>
        <v-spacer></v-spacer>        
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
        <v-toolbar-title>
          <v-text-field
              v-model="search"
              append-icon="search"
              label="Buscar"
              single-line
              hide-details
              width="20px"
            ></v-text-field>
        </v-toolbar-title>
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
        <Form :bus="bus"/>
        <RemoveItem :bus="bus"/>
    </v-toolbar>
    <v-data-table
        :headers="headers"
        :items="table"
        :search="search"
        :rows-per-page-items="[10,20,30,{text:'TODO',value:-1}]"
        disable-initial-sort
        class="elevation-1">
        <template slot="items" slot-scope="props">
          <tr>
            <td class="text-xs-center"> {{ props.item.employee.first_name+' '+props.item.employee.second_name+' '+props.item.employee.last_name }} </td>
            <td class="text-xs-center"> {{ format_date(props.item.emision) }}</td>
            <td class="text-xs-center"> {{ format_date(props.item.conclusion) }} </td>
            <td class="text-xs-center">
              <a :href="props.item.respaldo" target="_blank">
                <v-icon
                  color="error">
                    picture_as_pdf
                </v-icon>
              </a>
            </td>
            <td class="justify-center layout">              
              <v-tooltip top>
                <v-btn slot="activator" flat icon color="indigo" @click="editItem(props.item)">
                  <v-icon>edit</v-icon>
                </v-btn>
                <span>Editar</span>
              </v-tooltip>
              <v-tooltip top>
                <v-btn slot="activator" flat icon color="red darken-3" @click="removeItem(props.item)">
                  <v-icon>delete</v-icon>
                </v-btn>
                <span>Eliminar</span>
              </v-tooltip>
            </td>
          </tr>
        </template>        
        <v-alert slot="no-results" :value="true" color="error" icon="fa fa-times">
          Tu Busqueda de "{{ search }}" no encontró resultados.
        </v-alert>
        <template slot="no-data">
          <v-alert slot="no-results" :value="true" color="info" icon="fa fa-times">
            Sin resultados.
          </v-alert>
        </template>
    </v-data-table>
  </v-container>
</template>
<script type="text/javascript">
import Vue from "vue";
import RemoveItem from "../RemoveItem";
import Form from "./HealthCardForm";
export default {
  components: {
    RemoveItem,
    Form,
  },
  data: () => ({
    bus: new Vue(),
    headers: [
      {
        text: "Trabajador",
        value: "employee.first_name",
        align: "center"
      },
      {
        text: "Fecha de emisión",
        value: "emision",
        align: "center"
      },
      {
        text: "Fecha de conclusión",
        value: "conclusion",
        align: "center"
      },
      {
        text: "Archivo",
        value: "respaldo",
        align: "center"
      },
      {
        text: "Opciones",
        align: "center",
        sortable: false
      }
    ],
    table: [],
    search: "",
  }),
  computed: {},
  mounted() {
    this.getTable();
    this.bus.$on("closeDialog", () => {
      this.getTable();
    });
  },
  methods: {
    async getTable() {
      try {
        let res = await axios.get("/health_card")
        this.table = res.data;
      } catch (e) {
        console.log(e);
      }
    },
    editItem(item) {
      this.bus.$emit("openDialog", item);
    },
    async removeItem(item) {
      this.bus.$emit("openDialogRemove", `health_card/${item.id}`);      
    },
    format_date(fecha){
      return this.$moment(fecha).format('DD-MM-YYYY')
    }
  }
};
</script>