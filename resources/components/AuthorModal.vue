<template>
  <b-modal v-model="getShow" @ok="handleOk">
    <h4 class="text-center">Input Author Info</h4>
    <form ref="form" @submit.stop.prevent class="px-5 my-3">
      <div v-for="item in headers" :key="item.text">
        <div class="d-flex align-items-center justify-content-between my-2">
          <div class="w-50">{{ item.text }} : </div>
          <Datepicker v-if="item.text == 'Birthday*'" class="w-100" auto-apply v-model="currentItem[`${item.value}`]"
            :format="dateFormat" @update:modelValue="checkFormValidity" required />
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
import Datepicker from '@vuepic/vue-datepicker';

export default {
  name: 'AuthorModal',

  props: {
    show: {
      type: Boolean,
      default: false
    },
    currentItem: {
      type: Object,
      default: {}
    },
  },

  data: function () {
    return {
      date: new Date(),
      headers: [
        { text: 'Author Name*', value: "authorName" },
        { text: 'Genre*', value: "authorGenre" },
        { text: 'Birthday*', value: "authorBirth" },
      ],
      errors: {
        "authorName": null,
        "authorGenre": null,
        "authorBirth": null
      }
    }
  },

  components: {
    Datepicker,
  },

  watch: {
    currentItem(current) {
      if (!Object.keys(current).length) {
        this.errors = {
          "authorName": null,
          "authorGenre": null,
          "authorBirth": null
        }
      }
    }
  },
  methods: {
    checkFormValidity() {
      this.errors.authorName = !this.currentItem['authorName'] ? false : true
      this.errors.authorGenre = !this.currentItem['authorGenre'] ? false : true
      this.errors.authorBirth = !this.currentItem['authorBirth'] ? false : true
      if (this.currentItem.authorName && this.currentItem.authorGenre && this.currentItem.authorBirth) return true
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

      this.$nextTick(() => {
        this.$emit('addItem', this.currentItem);
      })
    },

    dateFormat(date) {
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    }
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

