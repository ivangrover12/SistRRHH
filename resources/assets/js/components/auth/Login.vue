<template>
  <v-container fluid fill-height id="background-page">
    <v-layout row align-center justify-center v-if="!$store.getters.user">
      <v-flex d-flex xs12 lg4 md6>
        <v-card class="pa-4">
          <v-img
            src="/img/logo1.jpg"
            aspect-ratio="3.6"
            contain
          ></v-img>
          <v-card-title primary-title class="justify-center">
            <div class="display-1 font-weight-thin text-md-center">PLATAFORMA VIRTUAL ADMINISTRATIVA</div>
          </v-card-title>
          <v-form>
            <v-text-field
              class="pl-5 pr-5"
              v-validate="'required|min:4|max:255'"
              @keyup.enter="focusPassword()"
              v-model="auth.username"
              prepend-icon="person"
              name="usuario"
              :error-messages="errors.collect('usuario')"
              label="Usuario"
              autocomplete="on"
              autofocus
              required
            ></v-text-field>
            <v-text-field
              class="pl-5 pr-5 mb-3"
              v-validate="'required|min:4|max:255'"
              @keyup.enter="authenticate(auth)"
              v-model="auth.password"
              prepend-icon="lock"
              label="Contraseña"
              type="password"
              autocomplete="on"
              ref="password"
              name="contraseña"
              :error-messages="errors.collect('contraseña')"
              required
            ></v-text-field>
            <v-card-actions>
              <v-btn
                @click.stop="authenticate(auth)"
                primary
                large
                block
                color="blue"
              > Ingresar </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'login',
  data() {
    return {
      auth: {
        username: '',
        password: ''
      },
      error: null
    }
  },
  methods: {
    focusPassword() {
      this.$refs.password.focus()
    },
    async authenticate(auth) {
      try {
        if (await this.$validator.validateAll()) {
          let res = await axios.post(`auth`, auth)
          this.$store.commit('login', res.data)
          this.$router.go({
            name: 'dashboard'
          })
        }
        console.log("aqui en try")
      } catch (e) {
        auth.password = ''
        this.focusPassword()
        console.log("aqui en catch")
      }
    }
  }
}
</script>

<style>
#background-page {
  background: rgba(103, 188, 130, 1);
  background: -moz-linear-gradient(
    top,
    rgba(103, 188, 130, 1) 0%,
    rgba(169, 169, 169, 1) 47%,
    rgba(0, 139, 139, 1) 90%
  );
  background: -webkit-gradient(
    left top,
    left bottom,
    color-stop(0%, rgba(103, 188, 130, 1)),
    color-stop(47%, rgba(169, 169, 169, 1)),
    color-stop(90%, rgba(0, 139, 139, 1))
  );
  background: -webkit-linear-gradient(
    top,
    rgba(103, 188, 130, 1) 0%,
    rgba(169, 169, 169, 1) 47%,
    rgba(0, 139, 139, 1) 90%
  );
  background: -o-linear-gradient(
    top,
    rgba(103, 188, 130, 1) 0%,
    rgba(169, 169, 169, 1) 47%,
    rgba(0, 139, 139, 1) 90%
  );
  background: -ms-linear-gradient(
    top,
    rgba(103, 188, 130, 1) 0%,
    rgba(169, 169, 169, 1) 47%,
    rgba(0, 139, 139, 1) 90%
  );
  background: linear-gradient(
    to bottom,
    rgba(103, 188, 130, 1) 0%,
    rgba(169, 169, 169, 1) 47%,
    rgba(0, 139, 139, 1) 90%
  );
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6ba872', endColorstr='#07540f', GradientType=0 );
}
</style>