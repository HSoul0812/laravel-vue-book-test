<template>
  <b-modal v-model="getShow" @ok="handleOk">
    <h4 class="text-center">{{ handleTitle }}</h4>
    <form ref="form" @submit.stop.prevent @submit="handleSubmit" class="px-5">
      <div v-for="(item, index) in headers" :key="item.text">
        <div class="d-flex align-items-center justify-content-between my-2" v-if="index < headers.length - 2">
          <div class="w-50">{{ item.text }} : </div>
          <b-form-select v-if="item.text === 'Author Name'" v-model="authorChange" class="w-50"
            @input="checkFormValidity" :options="authorOptions"></b-form-select>
          <VueMultiselect v-else-if="item.text === 'Library Name'" v-model="libraryValue" :options="libraryOptions"
            :multiple="true" :clear-on-select="false" :preserve-search="true" label="text" track-by="text">
          </VueMultiselect>
          <input v-else-if="item.text === 'Year'" class="w-50 mx-auto form-control"
            @input="(e) => { onKeydown(e.target); checkFormValidity() }" v-model="currentItem[`${item.value}`]"
            placeholder="1902" type="number" required />
          <input v-else class="w-50 mx-auto form-control" v-model="currentItem[`${item.value}`]" :disabled="index > 2"
            @input="checkFormValidity" required />
        </div>
        <div v-if="index < 3 && errors[`${item.value}`] == false" class="d-block invalid-feedback inputError">
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
  data() {
    return {
      libraryValue: [],
      errors: {
        "name": null,
        "year": null,
        "authorName": null,
      }
    }
  },
  name: 'BookModal',
  props: {
    show: {
      type: Boolean,
      default: false
    },
    currentItem: {
      type: Object,
      default: {}
    },
    authors: {
      type: Array,
      default: []
    },
    libraries: {
      type: Array,
      default: []
    },
    headers: {
      typs: Array,
      default: []
    }
  },

  watch: {
    currentItem(current) {
      if (Object.keys(current).length) {
        this.libraryValue = current.libraries.map(library => ({ value: library.id, text: library.name }))
      } else {
        this.libraryValue = []
        this.errors = {
          "name": null,
          "year": null,
          "authorName": null,
        }
      }
    }
  },
  methods: {
    checkFormValidity() {
      this.errors.name = !this.currentItem['name'] ? false : true
      this.errors.year = !this.currentItem['year'] ? false : true
      this.errors.authorName = !this.currentItem['authorName'] ? false : true
      if (this.currentItem.name && this.currentItem.year && this.currentItem.authorName) return true
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
      const selectedLibraries = this.libraries.filter(library => this.libraryValue.map(e => e.value).includes(library.id))
      this.currentItem.libraries = selectedLibraries
      this.$nextTick(() => {
        if (!this.currentItem.id) {
          this.$emit('addItem', this.currentItem)
        } else {
          this.$emit('updateItem', this.currentItem)
        }
      })
    },

    onKeydown(target) {
      target.value = target.value.substr(0, 4)
      this.currentItem['year'] = target.value
    },

  },

  computed: {
    authorOptions() {
      return this.authors?.map(author => ({ value: author.id, text: author.name }))
    },

    authorChange: {
      get() {
        return this.currentItem?.author_id;
      },
      set(newValue) {
        const newAuthor = this.authors?.find(author => author.id === newValue);
        if (newAuthor) {
          this.currentItem.author_id = newValue;
          this.currentItem.authorName = newAuthor.name;
          this.currentItem.authorGenre = newAuthor.genre;
          this.currentItem.authorBirth = newAuthor.birthday;
        }
      }
    },

    libraryOptions() {
      return this.libraries?.map(library => ({ value: library.id, text: library.name }))
    },

    getShow: {
      get() {
        return this.show
      },

      set(value) {
        this.$emit('updateShow', value)
      }
    },

    handleTitle() {
      return Object.keys(this.currentItem).length ? 'Edit Book' : 'Add Book'
    }
  }
}
</script>

