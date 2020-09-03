<template>
  <v-container fluid>
    <v-toolbar>
      <v-toolbar-title>Usuarios</v-toolbar-title>
      <v-spacer></v-spacer>
      <UserForm :bus="bus" />
        <v-btn
          color="error"
          class="mr-4"
          @click.prevent="addUser()"
          dark
        >
          Añadir usuario
        </v-btn>
      <v-flex xs2>
        <v-select
          :items="sources"
          xs3 md3
          label="Origen"
          v-model="sourceSelected"
        ></v-select>
      </v-flex>
    </v-toolbar>
    <UserRole v-if="sourceSelected == 'Roles'" ref="UserRole"/>
    <RolePermission v-if="sourceSelected == 'Permisos'" ref="RolePermission"/>
  </v-container>
</template>

<script>
import Vue from 'vue'
import UserRole from "./UserRole"
import RolePermission from "./RolePermission"
import { log } from 'util'
import UserForm from './UserForm'
export default {
  name: "userIndex",
  components: {
    UserRole,
    RolePermission,
    UserForm
  },
  computed: {
    zammadSync() {
      return JSON.parse(process.env.MIX_ZAMMAD_SYNC)
    }
  },
  data() {
    return {
      bus: new Vue,
      sources: ["Roles", "Permisos"],
      sourceSelected: "",
      message: {
        employees: {
          total: null,
          new: []
        },
        entries: {
          total: null,
          old: []
        },
        diff: {
          added: null,
          removed: null
        },
        zammad: {
          skipped: null,
          created: null,
          updated: null,
          unchanged: null,
          failed: null,
          deactivated: null,
          sum: null,
          total: null
        }
      },
      dialog: false,
      loading: false
    }
  },
  mounted() {
    this.sourceSelected = this.sources[0]
  },
  methods: {
    addUser(){
      this.bus.$emit('openDialogAddUser')
    }
  }
}
</script>