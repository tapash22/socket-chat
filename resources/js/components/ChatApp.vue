<template>
  <div class="chat-app">
    <div class="container clearfix">
      <div class="people-list" id="people-list">
        <div class="search">
          <input type="text" placeholder="search" />
          <i class="fa fa-search"></i>
        </div>
        <ul class="list">
          <li
            @click.prevent="selectedId(user.id)"
            class="clearfix"
            v-for="user in userList"
            :key="user.id"
          >
            <img
              src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01.jpg"
              alt="avatar"
            />
            <div class="about">
              <div class="name">{{ user.name }}</div>
              <div class="status"><i class="fa fa-circle online"></i> online</div>
            </div>
          </li>
        </ul>
      </div>

      <div class="chat">
        <div class="chat-header clearfix">
          <img
            src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01_green.jpg"
            alt="avatar"
          />

          <div class="chat-about">
            <div class="chat-with" v-if="userMessage.user">
              {{ userMessage.user.name }}
            </div>
            <!-- <div class="chat-num-messages">already 1 902 messages</div> -->
          </div>
          <i class="fa fa-star"></i>
        </div>
        <!-- end chat-header -->

        <div class="chat-history" v-chat-scroll>
          <ul class="ul">
            <li
              class="clearfix"
              v-for="message in userMessage.messages"
              :key="message.id"
            >
              <div class="message-data align-right">
                <span class="message-data-time">{{
                  message.created_at | timeformate
                }}</span>
                &nbsp; &nbsp;
                <span class="message-data-name"> {{ userMessage.user.name }}</span>
                <i class="fa fa-circle me"></i>
              </div>
              <div
                class="`message float-right ${message.user.id==userMessage.user.id ? 'other-message' : 'my-message'}`"
              >
                {{ message.message }}
              </div>
            </li>
          </ul>
        </div>
        <!-- end chat-history -->

        <div class="chat-message clearfix">
          <textarea
            @keydown.enter="sendMessage"
            v-model="message"
            name="message-to-send"
            id="message-to-send"
            placeholder="Type your message"
            rows="3"
          ></textarea>
          <!-- 
          <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
          <i class="fa fa-file-image-o"></i>

          <button>Send</button> -->
        </div>
        <!-- end chat-message -->
      </div>
      <!-- end chat -->
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      message: "",
      user: [],
      user_id: 0,
    };
  },
  mounted() {
    this.$store.dispatch("userList");
  },

  computed: {
    userList() {
      return this.$store.getters.userList;
    },

    userMessage() {
      return this.$store.getters.userMessage;
    },
  },

  methods: {
    selectedId(id) {
      this.$store.dispatch("userMessage", id);
    },

    sendMessage(e) {
      e.preventDefault();
      // console.log(this.message);
      if (this.message != "") {
        axios
          .post("/sendmessage", {
            message: this.message,
            user_id: this.userMessage.user.id,
          })
          .then((response) => {
            this.selectedId(this.userMessage.user.id);
          });
        this.message = "";
      }
    },
  },
};
</script>

<style lang="scss">
@import "../../sass/app.scss";
.list {
  height: 400px !important;
  overflow-y: scroll;
  overflow-x: hidden;
}
.ul {
  height: 250px !important;
}
</style>
