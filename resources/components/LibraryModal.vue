<template>
  <b-modal v-model="getShow" @ok="addLibrary">
    <h4 class="text-center">Input Library Info</h4>
    <form ref="form" @submit.stop.prevent class="px-5">
      <div v-for="(item, index) in headers" :key="item.text">
        <div class="d-flex align-items-center justify-content-between my-2">
          <div class="w-50">{{ item.text }} : </div>
          <b-form-input class="w-50" v-model="currentItem[`${item.value}`]" className='w-50 mx-auto'
            :disabled="index > 2" data-test="libraryTest" required></b-form-input>
        </div>
      </div>
    </form>
  </b-modal>
</template>

<script>
export default {
  name: 'LibraryModal',
  props: {
    show: [Boolean],
  },
  data: function () {
    return {
      currentItem: {},
      headers: [
        { text: 'Library Name', value: "libraryName" },
        { text: 'Library Address', value: "libraryAddress" },
      ],
    }
  },

  methods: {
    addLibrary() {
      this.$emit('addItem', this.currentItem)
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

