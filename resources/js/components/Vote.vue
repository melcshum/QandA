<template>
  <div>
    <div class="d-fex flex-column vote-controls">
      <a :title="title('up')" @click.prevent="voteUp" class="vote-up" :class="classes">
        <i class="fas fa-caret-up fa-3x"></i>
      </a>

      <span class="vote-count">{{ count }}</span>

      <a :title="title('down')" @click.prevent="voteDown" class="vote-down" :class="classes">
        <i class="fas fa-caret-down fa-3x"></i>
      </a>

      <favorite v-if="name === 'question'" :question="model"></favorite>
      <accept v-if="name === 'answer'" :answer="model"></accept>
    </div>
  </div>
</template>

<script>
import Favorite from "./Favorite.vue";
import Accept from "./Accept.vue";

export default {
  props: ["name", "model"],
  components: {
    Favorite,
    Accept,
  },
  data() {

    return {
      count: this.model.votes_count || 0,
      id: this.model.id,
    };
  },
  methods: {
    title(voteType) {
      let titles = {
        up: `This ${this.name} is useful`,
        down: `This ${this.name} is not useful`,
      };
      return titles[voteType];
    },

    voteUp() {
      this._vote(1);
    },
    voteDown() {
      this._vote(-1);
    },
    _vote(vote) {
      if (!this.signedIn) {
        this.$toast.warning(
          `Please login to vote the ${this.name}`,
          "Warning",
          {
            timout: 3000,
            position: "bottomLeft",
          }
        );
        return;
      }
      axios.post(this.endpoint, { vote }).then((res) => {
        this.$toast.success(res.data.message, "Success", {
          timeout: 3000,
          position: "bottomLeft",
        });

        // this.count += vote;
        this.count = res.data.votesCount;
      });
    },
  },
  computed: {
    classes() {
      return this.signedIn ? "" : "off";
    },
    endpoint() {
      return `/${this.name}s/${this.id}/vote`;
    },
  },
};
</script>

<style>
</style>
