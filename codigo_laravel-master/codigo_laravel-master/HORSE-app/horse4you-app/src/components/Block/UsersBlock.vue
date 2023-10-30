<template>
  <section id="usersBlock">
    <div>
      <v-row v-if="users.length == 0">
        <v-col
          cols="12"
          class="colNoUsersBlock"
        >
          <div class="noUsersBlock">
            <h4>Nenhum usuário bloqueado!</h4>
            <div
              class="goBackButton"
              @click="goBack"
            >
              <v-btn>Voltar</v-btn>
            </div>
          </div>
        </v-col>
      </v-row>
      <v-row v-else>
        <v-col
          cols="12"
          class="colUsers"
        >
          <div
            v-for="user in users"
            :key="user.id"
            class="infUser"
          >
            <div class="usersData">
              <v-avatar size="60">
                <img :src="user.avatar">
              </v-avatar>
              <div class="texts">
                <h3>{{ user.name }}</h3>
                <p>{{ user.nick }}</p>
              </div>
            </div>
            <div class="unblockUser">
              <v-btn
                @click="unblock(user.id)"
              >
                Desbloquear
              </v-btn>
            </div>
          </div>
        </v-col>
      </v-row>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    users: {
      type: Array,
      default: null,
    }
  },
  methods: {
    unblock(id) {
      localStorage.setItem("idBlock", id);
      this.$emit("unblock");
    },
    goBack() {
      this.$emit("goBack");
    }
  }
};
</script>