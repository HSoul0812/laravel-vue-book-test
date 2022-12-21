<template>
  <b-modal v-model="getShow" @ok="addAuthor">
    <h4 class="text-center">Input Author Info</h4>
    <form ref="form" @submit.stop.prevent class="px-5">
      <div v-for="(item, index) in headers" :key="item.text">
        <div class="d-flex align-items-center justify-content-between my-2">
          <div class="w-50">{{ item.text }} : </div>
          <Datepicker v-if="index == 2" v-model="currentItem[`${item.value}`]" class="w-100" />
          <b-form-input v-else class="w-50" v-model="currentItem[`${item.value}`]" className='w-50 mx-auto'
            data-test="authorTest" required></b-form-input>
        </div>
      </div>
    </form>
  </b-modal>
</template>

<script>
import Datepicker from 'vue3-datepicker';

export default {
  name: 'AuthorModal',

  props: {
    show: [Boolean],
  },

  data: function () {
    return {
      currentItem: {},
      date: new Date(),
      headers: [
        { text: 'Author Name', value: "authorName" },
        { text: 'Genre', value: "authorGenre" },
        { text: 'Birthday', value: "authorBirth" },
      ],
    }
  },

  components: {
    Datepicker,
  },

  methods: {
    async addAuthor() {
      this.$emit('addItem', this.currentItem);
    },
  },

  computed: {
    getShow: {
      get() {
        return this.show
      },
      set(value) {
        this.$emit('updateShow', value)
      }
    },
  }
}
</script>

