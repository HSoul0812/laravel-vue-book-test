<template>
	<h1 class="text-center mt-5">Laravel Vue Book List</h1>
	<div class="mx-5 d-flex align-items-end my-5">
		<div class="ms-auto">
			<b-button class="mx-1" variant="outline-primary" @click="onAddBook">Add
				Book</b-button>
			<b-button class="mx-1" variant="outline-primary" @click="onAddAuthor">Add
				Author</b-button>
			<b-button class="mx-1 " variant="outline-primary" @click="onAddLibrary">Add
				Library</b-button>
		</div>
	</div>
	<EasyDataTable :headers="headers" :items="books" class="px-5">
		<template #item-operation="item">
			<div v-if="!item.duplicated" class="operation-wrapper">
				<img src="../assets/image/delete.png" class="operation-icon" @click="deleteItem(item)" />
				<img src="../assets/image/edit.png" class="operation-icon" @click="onEdit(item)" />
			</div>
		</template>
	</EasyDataTable>

	<book-modal :show="bookModalShow" :currentItem="currentItem" :authors="authors" :libraries="libraries"
		:headers="headers" @addItem="addBook" @updateItem="updateBook"
		@updateShow="(v) => bookModalShow = v"></book-modal>

	<author-modal :show="authorModalShow" :currentItem="currentItem" @addItem="addAuthor"
		@updateShow="(v) => authorModalShow = v"></author-modal>

	<library-modal :show="libraryModalShow" @addItem="addLibrary" :currentItem="currentItem" :books="bookList"
		@updateShow="(v) => libraryModalShow = v"></library-modal>
</template>
<script>

import Service from '../service/Service';
import BookModal from './BookModal.vue';
import AuthorModal from './AuthorModal.vue';
import LibraryModal from './LibraryModal.vue';
import { formatDate } from '../utils/common';

export default {
	name: 'App',
	components: {
		BookModal,
		AuthorModal,
		LibraryModal
	},
	data: function () {
		return {
			books: [],
			authors: [],
			libraries: [],
			currentItem: {},
			bookList: [],
			bookModalShow: false,
			authorModalShow: false,
			libraryModalShow: false,
			addClicked: false,
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
		onAddBook() {
			this.bookModalShow = !this.bookModalShow;
			this.currentItem = {};
		},

		onAddAuthor() {
			this.authorModalShow = !this.authorModalShow;
			this.currentItem = {};
		},

		onAddLibrary() {
			this.libraryModalShow = !this.libraryModalShow;
			this.currentItem = {};
		},

		onEdit(item) {
			this.bookModalShow = !this.bookModalShow;
			this.currentItem = item;
		},

		async loadItems() {
			this.books = await Service.loadBooks();
			this.bookList = Service.bookList;
			this.authors = await Service.loadAuthors();
			this.libraries = await Service.loadLibraries();
		},

		async deleteItem(item) {
			this.books = await Service.deleteBook(item.id);
			this.bookList = Service.bookList;
		},

		async addLibrary(item) {
			this.libraryModalShow = !this.libraryModalShow;
			this.libraries = await Service.addLibrary(item);
			this.books = await Service.loadBooks();
			this.bookList = Service.bookList;
		},

		async addAuthor(item) {
			this.authorModalShow = !this.authorModalShow;
			this.authors = await Service.addAuthor({ ...item, authorBirth: formatDate(item.authorBirth) });
		},

		async addBook(item) {
			this.bookModalShow = !this.bookModalShow;
			this.books = await Service.addBook(item);
			this.bookList = Service.bookList;
		},

		async updateBook(item) {
			this.bookModalShow = !this.bookModalShow;
			this.books = await Service.updateBook(item, item.id);
			this.bookList = Service.bookList;
		},
	},
	created() {
		this.loadItems();
	}
}
</script>
