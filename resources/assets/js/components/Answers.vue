<template>
  <div class="row mt-4" v-cloak v-if="count > 0">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h2>{{ title }}</h2>
          </div>
          <hr />
          <answer v-for="answer in answers" :answer="answer" :key="answer.id"></answer>

          <div class="text-center mt-3" v-if="nextUrl">
            <button
              @click.prevent="fetch(nextUrl)"
              class="btn btn-outline-secondary"
            >Load more answers</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Answer from "./Answer.vue";

export default {
  props: ["question"],

  components: {
    Answer,
  },
  data() {
    return {
      questionId: this.question.id,
      count: this.question.answers_count,
      answers: [],
      nextUrl: null,
    };
  },
  created() {
    // this method is called after the instance is created
    this.fetch(`/questions/${this.questionId}/answers`);
  },
  methods: {
    fetch(endpoint) {
      axios.get(endpoint).then(({ data }) => {
        // this ... is pushing every element of an array into array
        this.answers.push(...data.data);
        console.log(data);
        this.nextUrl= data.next_page_url;

      });
    },
  },
  computed: {
    title() {
      return this.count + " " + (this.count > 1 ? "Answers" : "Answer");
    },
  },
};
</script>
