<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chat</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex"
          style="min-height: 400px; max-height: 400px"
        >
          <!-- List users -->
          <div
            class="
              w-3/12
              bg-gray-200 bg-opacity-25
              border-r border-gray-200
              overflow-y-auto
            "
          >
            <ul>
              <li
                v-for="user in users"
                :key="user.id"
                @click="
                  () => {
                    LoadMessages(user.id);
                  }
                "
                :class="
                  userActive && userActive.id == user.id
                    ? 'bg-gray-200 bg-opacity-50'
                    : ''
                "
                class="
                  p-6
                  text-lg text-gray-600
                  leading-7
                  font-semibold
                  border-b border-gray-200
                  hover:bg-opacity-50
                  hover:cursor-pointer
                  hover:bg-gray-200
                "
              >
                <p class="flex itens-center">
                  {{ user.name }}
                  <span class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                </p>
              </li>
            </ul>
          </div>

          <!-- Box message -->
          <div class="w-9/12 flex flex-col justify-between">
            <!-- message -->
            <div class="w-full p-6 flex flex-col overflow-y-auto">
              <div
                v-for="message in messages"
                :key="message.id"
                :class="message.from != idTo ? 'text-right' : ''"
                class="w-full mb-3 mensagens"
              >
                <p
                  :class="
                    message.from != idTo ? ' messageToMe' : 'messageFromMe'
                  "
                  class="inline-block p-2 rounded-mb"
                  style="max-width: 75%"
                >
                  {{ message.content }}
                </p>
                <span class="block mt-1 text-xs text-gray-500">{{
                  message.created_at
                }}</span>
              </div>
            </div>

            <!-- form -->
            <div
              v-if="userActive"
              class="
                w-full
                bg-gray-200 bg-opacity-25
                p-6
                border-t border-gray-200
              "
            >
              <form v-on:submit.prevent="sendMenssage">
                <div
                  class="flex rounded-mb overflow-hidden border border-gray-300"
                >
                  <input
                    v-model="message"
                    type="text"
                    class="flex-1 px-4 py-2 text-sm focus:outline-none b-none"
                  />
                  <button
                    type="submit"
                    class="
                      bg-indigo-500
                      hover:bg-indigo-600
                      text-white
                      px-4
                      py-2
                    "
                  >
                    Enviar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "../Jetstream/Input.vue";
import Button from "../Jetstream/Button.vue";

export default {
  components: {
    AppLayout,
    Input,
    Button,
  },
  data() {
    return {
      users: [],
      messages: [],
      idTo: null,
      userActive: null,
      message: "",
    };
  },
  methods: {
    scrolToBottom: function () {
      if (this.messages.length) {
        document.querySelectorAll(".mensagens:last-child")[0].scrollIntoView();
      }
    },
    LoadMessages: async function (id) {
      axios.get(`api/users/${id}`).then((response) => {
        this.userActive = response.data.user;
      });

      await axios.get(`api/mensages/${id}`).then((response) => {
        this.idTo = id;
        this.messages = response.data[0];
      });
      this.scrolToBottom();
    },
    sendMenssage: async function () {
      await axios
        .post("api/mensages/store", {
          content: this.message,
          to: this.idTo,
        })
        .then((response) => {
          this.messages = this.messages.concat(response.data[0]);
          console.log(response.data[0]);
          console.log(this.messages);
        });
      this.message = "";
      this.scrolToBottom();
    },
  },
  mounted() {
    axios.get("api/users").then((response) => {
      this.users = response.data.users;
    });
  },
};
</script>
<style>
.messageFromMe {
  background: rgba(76, 0, 130, 0.25);
}
.messageToMe {
  background: rgba(128, 128, 128, 0.25);
}
</style>
