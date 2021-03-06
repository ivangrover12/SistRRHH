<template>
  <v-container fluid>
    <v-toolbar>
      <v-toolbar-title>
        Configuración de Permisos
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-flex xs2>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Buscar"
          single-line
          hide-details
          full-width
          clearable
        ></v-text-field>
      </v-flex>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="reasons"
      :search="search"
      :loading="loading"
      :rows-per-page-items="[{ text: 'TODO', value: -1 }, 10, 20, 30]"
      disable-initial-sort
    >
      <template slot="items" slot-scope="props">
        <tr>
          <td class="text-md-center">
            <v-tooltip right>
              <template slot="activator">
                {{ props.item.name }}
              </template>
              <span>{{ props.item.description }}</span>
            </v-tooltip>
          </td>
          <td class="text-md-center">
            <v-select
              :items="groups"
              item-text="name"
              item-value="id"
              v-model="props.item.departure_group_id"
              @change="updateDeparture(props.item)"
            ></v-select>
          </td>
          <td class="text-md-center">
            <v-checkbox
              v-model="props.item.note"
              @change="updateDeparture(props.item)"
            ></v-checkbox>
          </td>
          <td class="text-md-center">
            <v-checkbox
              v-model="props.item.description_needed"
              @change="updateDeparture(props.item)"
            ></v-checkbox>
          </td>
          <td class="text-md-center">
            <v-checkbox
              v-model="props.item.payable"
              @change="updateDeparture(props.item)"
            ></v-checkbox>
          </td>
          <td class="text-md-center">
            <v-select
              :items="reset"
              item-text="name"
              item-value="value"
              v-model="props.item.reset"
              @change="updateDeparture(props.item)"
            ></v-select>
          </td>
          <td class="text-md-center">
            <v-text-field
              class="centered-input"
              mask="##"
              v-model="props.item.days"
              @keyup.enter="updateDeparture(props.item)"
            ></v-text-field>
          </td>
          <td class="text-md-center">
            <v-text-field
              class="centered-input"
              mask="##"
              v-model="props.item.hours"
              @keyup.enter="updateDeparture(props.item)"
            ></v-text-field>
          </td>
          <td class="text-md-center">
            <v-text-field
              class="centered-input"
              mask="##"
              v-model="props.item.count"
              @keyup.enter="updateDeparture(props.item)"
            ></v-text-field>
          </td>
        </tr>
      </template>
      <v-alert slot="no-results" :value="true" color="error">
        La búsqueda de "{{ search }}" no encontró resultados.
      </v-alert>
      <template slot="no-data">
        <v-container fluid fill-height>
          <v-layout align-center justify-center>
            <v-progress-circular
              :width="1"
              :size="50"
              color="primary"
              indeterminate
              class="pa-5 ma-5"
            ></v-progress-circular>
          </v-layout>
        </v-container>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
export default {
  name: 'DepartureConfig',
  data: () => ({
    loading: true,
    search: '',
    reasons: [],
    groups: [],
    reset: [
      {
        name: 'No reiniciar',
        value: null
      }, {
        name: 'Mensualmente',
        value: 'monthly'
      }, {
        name: 'Anualmente',
        value: 'annually'
      }
    ],
    headers: [
      { align: "center", text: "Razón", class: ["ma-0", "pa-0"], value: "name", width: "35%" },
      { align: "center", text: "Grupo", class: ["ma-0", "pa-0"], value: "departure_group_id", width: "15%" },
      { align: "center", text: "Mediante nota", class: ["ma-0", "pa-0"], value: "note", width: "5%" },
      { align: "center", text: "Con descripción", class: ["ma-0", "pa-0"], value: "description_needed", width: "5%" },
      { align: "center", sortable: false, text: "Pagable", class: ["ma-0", "pa-0"], value: "pay", width: "5%" },
      { align: "center", sortable: false, text: "Reiniciar", class: ["ma-0", "pa-0"], value: "each", width: "10%" },
      { align: "center", sortable: false, text: "Días", class: ["ma-0", "pa-0"], value: "day", width: "5%" },
      { align: "center", sortable: false, text: "Horas", class: ["ma-0", "pa-0"], value: "hour", width: "5%" },
      { align: "center", sortable: false, text: "Nro", class: ["ma-0", "pa-0"], value: "count", width: "5%" }
    ]
  }),
  mounted() {
    this.getDepartureReasons()
    this.getDepartureGroups()
  },
  methods: {
    async getDepartureReasons() {
      try {
        let res = await axios.get(`departure_reason`)
        this.reasons = res.data
        this.loading = false
      } catch (e) {
        console.log(e)
      }
    },
    async getDepartureGroups() {
      try {
        let res = await axios.get(`departure_group`)
        this.groups = res.data
      } catch (e) {
        console.log(e)
      }
    },
    async updateDeparture(item) {
      try {
        let res = await axios.patch(`departure_reason/${item.id}`, item)
        this.toastr.success('Registro actualizado')
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>

<style>
.centered-input input {
  text-align: center;
  margin-bottom: -5px;
  padding-top: 15px;
}
</style>