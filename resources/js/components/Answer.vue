<template>
  <div class="media post">
    <vote :model="answer" name="answer"></vote>

    <div class="media-body">
      <form v-if="editing" @submit.prevent="update">
        <div class="form-group">
          <textarea class="form-control" v-model="body" cols="80" rows="10" required></textarea>
        </div>
        <button class="btn btn-primary" :disabled="isInvalid">Update</button>
        <button class="btn btn-outline-secondary" type="button" @click="cancel">Cancal</button>
      </form>
      <div v-if="editing===false">
        <div v-html="bodyHtml"></div>

        <div class="row">
          <div class="col-4">
            <div class="ml-auto">
              <a
                v-if="authorize('modify', answer)"
                @click.prevent="edit"
                class="btn btn-sm btn-outline-info"
              >Edit</a>
              <button
                v-if="authorize('modify', answer)"
                @click="destory"
                class="btn btn-sm btn-outline-danger"
              >Delete</button>
            </div>
          </div>
          <div class="col-4"></div>
          <div class="col-4">
            <user-info :model="answer" label="Answered" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vote from "./Vote.vue";
import UserInfo from "./UserInfo.vue";
import modification from "../mixins/modification.js";

export default {
  props: ["answer"],

  mixins: [modification],

  components: {
    Vote,
    UserInfo,
  },
  data() {
    return {
      //      editing: false,
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      id: this.answer.id,
      questionId: this.answer.question_id,
      beforeEditCache: null,
    };
  },
  methods: {
    setEditCache() {
      this.beforeEditCache = this.body;
    },
    restoreFromCache() {
      this.body = this.beforeEditCache;
      this.editing = false;
    },
    payload() {
      return { body: this.body };
    },

    delete() {
      axios
        .delete(this.endpoint)
        .then((res) => {
          this.toast.success(res.data.message, "Success", {
            timeout: 2000,
          });
          this.$emit("deleted");
        })
        .catch((err) => {
            console.log(err);
          alert("delete error");
        });
    },
  },
  computed: {
    isInvalid() {
      return this.body.length < 10;
    },
    endpoint() {
      return `/questions/${this.questionId}/answers/${this.id}`;
    },
  },
};
</script>
