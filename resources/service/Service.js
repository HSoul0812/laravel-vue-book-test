import axios from 'axios'
import { formatBook } from '../utils/common'

class Service {
  constructor() {}

  async loadBooks() {
    try {
      const { books } = await axios.get(`api/books`).then((res) => res.data)
      return formatBook(books)
    } catch (e) {
      console.error(e)
      if (e.response.status == 422) {
        window.alert(e.response.data.message)
      } else {
        window.alert(e.toString())
      }
    }
  }

  async addBook(data) {
    try {
      const payload = {
        name: data.name,
        year: parseInt(data.year),
        author_id: data.author_id,
        libraries: [data.libraryId],
      }

      const { books } = await axios
        .post(`api/books`, { ...payload })
        .then((res) => res.data)
      return formatBook(books)
    } catch (e) {
      console.error(e)
      if (e.response.status == 422) {
        window.alert(e.response.data.message)
      } else {
        window.alert(e.toString())
      }
    }
  }

  async updateBook(data, id) {
    try {
      const payload = {
        name: data.name,
        year: parseInt(data.year),
        author_id: data.author_id,
        libraries: [data.libraryId],
      }

      const { books } = await axios
        .put(`api/books/${id}`, {
          ...payload,
        })
        .then((res) => res.data)

      return formatBook(books)
    } catch (e) {
      console.error(e)
      if (e.response.status == 422) {
        window.alert(e.response.data.message)
      } else {
        window.alert(e.toString())
      }
    }
  }

  async deleteBook(id) {
    try {
      const { books } = await axios
        .delete(`api/books/${id}`)
        .then((res) => res.data)
      return formatBook(books)
    } catch (e) {
      console.error(e)
      if (e.response.status == 422) {
        window.alert(e.response.data.message)
      } else {
        window.alert(e.toString())
      }
    }
  }

  async loadAuthors() {
    try {
      const result = await axios.get(`api/authors`)
      return result.data.authors
    } catch (e) {
      console.error(e)
      if (e.response.status == 422) {
        window.alert(e.response.data.message)
      } else {
        window.alert(e.toString())
      }
    }
  }

  async addAuthor(data) {
    try {
      const payload = {
        name: data.authorName,
        birthday: data.authorBirth,
        genre: data.authorGenre,
      }
      const result = await axios
        .post(`api/authors`, { ...payload })
        .then((res) => res.data)
      return result.authors
    } catch (e) {
      console.error(e)
      if (e.response.status == 422) {
        window.alert(e.response.data.message)
      } else {
        window.alert(e.toString())
      }
    }
  }

  async loadLibraries() {
    try {
      const result = await axios.get(`api/libraries`).then((res) => res.data)
      return result.libraries
    } catch (e) {
      console.error(e)
      if (e.response.status == 422) {
        window.alert(e.response.data.message)
      } else {
        window.alert(e.toString())
      }
    }
  }

  async addLibrary(data) {
    try {
      const payload = {
        name: data.libraryName,
        address: data.libraryAddress,
      }
      const result = await axios
        .post(`api/libraries`, { ...payload })
        .then((res) => res.data)
      return result.libraries
    } catch (e) {
      console.error(e)
      if (e.response.status == 422) {
        window.alert(e.response.data.message)
      } else {
        window.alert(e.toString())
      }
    }
  }
}

export default new Service()
