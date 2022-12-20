<template>
  <b-modal v-model="getShow" @ok="addAuthor">
    <h4 class="text-center">Input Author Info</h4>
    <form ref="form" @submit.stop.prevent class="px-5">
      <div v-for="(item, index) in headers" :key="item.text">
        <div class="d-flex align-items-center justify-content-between my-2">
          <div class="w-50">{{ item.text }} : </div>
          <b-form-input class="w-50" v-model="currentItem[`${item.value}`]" className='w-50 mx-auto'
            :disabled="index > 2" data-test="authorTest" required></b-form-input>
        </div>
      </div>
    </form>
  </b-modal>
</template>

<script>
export default {
  name: 'AuthorModal',
  props: {
    show: [Boolean],
  },
  data: function () {
    return {
      currentItem: {},
      headers: [
        { text: 'Author Name', value: "authorName" },
        { text: 'Genre', value: "authorGenre" },
        { text: 'Birthday', value: "authorBirth" },
      ],
    }
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

