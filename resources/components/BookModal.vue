<template>
  <b-modal v-model="getShow" @ok="onOk">
    <h4 class="text-center">Edit Book</h4>
    <form ref="form" @submit.stop.prevent class="px-5">
      <div v-for="(item, index) in headers" :key="item.text">
        <div class="d-flex align-items-center justify-content-between my-2" v-if="index != headers.length - 1">
          <div class="w-50">{{ item.text }} : </div>
          <b-form-select v-if="item.text === 'Author Name'" v-model="authorChange" class="w-50"
            :options="authorOptions"></b-form-select>
          <b-form-select v-else-if="item.text === 'Library Name'" v-model="libraryChange" class="w-50"
            :options="libraryOptions"></b-form-select>
          <b-form-input v-else class="w-50 mx-auto" v-model="currentItem[`${item.value}`]" data-test="bookTest"
            :disabled="index > 2" required></b-form-input>
        </div>
      </div>
    </form>
  </b-modal>
</template>

<script>
export default {
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
  },
  data: function () {
    return {
      headers: [
        { text: 'Book Name', value: "name" },
        { text: 'Year', value: "year" },
        { text: 'Author Name', value: "authorName" },
        { text: 'Genre', value: "authorGenre" },
        { text: 'Library Name', value: "libraryName" },
        { text: 'Address', value: "libraryAddress" },
        { text: "Operation", value: "operation" },
      ],
    }
  },

  methods: {
    onOk() {
      if (!this.currentItem.id) {
        this.$emit('addItem', this.currentItem)
      } else {
        this.$emit('updateItem', this.currentItem)
      }
    }
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

    libraryChange: {
      get() {
        return this.currentItem?.libraryId;
      },

      set(newValue) {
        const newLibrary = this.libraries?.find(library => library.id === newValue);
        if (newLibrary) {
          this.currentItem.libraryId = newValue;
          this.currentItem.libraryName = newLibrary.name;
          this.currentItem.libraryAddress = newLibrary.address;
        }
      }
    },

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

