<template>
  <b-modal v-model="getShow" @ok="handleOk">
    <h4 class="text-center">Input Library Info</h4>
    <form ref="form" @submit.stop.prevent="handleSubmit" class="px-5 my-3">
      <div v-for="item in headers" :key="item.text">
        <div class="d-flex align-items-center justify-content-between my-2">
          <div class="w-50">{{ item.text }} : </div>
          <VueMultiselect v-if="item.text === 'Book Name'" v-model="bookValue" :options="bookOptions" :multiple="true"
            :clear-on-select="false" :preserve-search="true" label="text" track-by="text" @close="checkFormValidity">
          </VueMultiselect>
          <input v-else class="w-100 mx-auto form-control" v-model="currentItem[`${item.value}`]"
            @input="checkFormValidity" required />
        </div>
        <div v-if="errors[`${item.value}`] == false" class="d-block invalid-feedback inputError">
          Field is Required
        </div>
      </div>
    </form>
  </b-modal>
</template>

<script>
import VueMultiselect from 'vue-multiselect'

export default {
  components: {
    VueMultiselect,
  },
  name: 'LibraryModal',
  props: {
    show: {
      type: Boolean,
      default: false
    },
    books: {
      type: Array,
      default: []
    },
    currentItem: {
      type: Object,
      default: {}
    },
  },
  data: function () {
    return {
      bookValue: [],
      headers: [
        { text: 'Library Name', value: "libraryName" },
        { text: 'Library Address', value: "libraryAddress" },
        { text: 'Book Name', value: "bookName" },
      ],
      errors: {
        "libraryName": null,
        "libraryAddress": null,
        "bookName": null
      }
    }
  },

  watch: {
    currentItem(current) {
      if (!Object.keys(current).length) {
        this.bookValue = []
        this.errors = {
          "libraryName": null,
          "libraryAddress": null,
          "bookName": null
        }
      }
    }
  },

  methods: {
    checkFormValidity() {
      this.errors.libraryName = !this.currentItem['libraryName'] ? false : true
      this.errors.libraryAddress = !this.currentItem['libraryAddress'] ? false : true
      this.errors.bookName = !this.bookValue.length ? false : true
      if (this.currentItem.libraryName && this.currentItem.libraryAddress && this.bookValue.length) return true
      return false
    },

    handleOk(bvModalEvent) {
      bvModalEvent.preventDefault()
      this.handleSubmit()
    },

    async handleSubmit() {
      if (!this.checkFormValidity()) {
        return
      }
      const selectedBooks = this.books.filter(book => this.bookValue.map(e => e.value).includes(book.id))
      this.currentItem.books = selectedBooks.map(e => e.id)
      this.$nextTick(() => {
        this.$emit('addItem', this.currentItem)
      })
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
    bookOptions() {
      return this.books?.map(book => ({ value: book.id, text: book.name }))
    },
  }
}
</script>

