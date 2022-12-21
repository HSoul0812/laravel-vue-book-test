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
	<EasyDataTable :headers="headers" :items="books" class="px-5" data-test="testTable">
		<template #item-operation="item">
			<div class="operation-wrapper">
				<img src="../assets/image/delete.png" class="operation-icon" @click="deleteItem(item)" />
				<img src="../assets/image/edit.png" class="operation-icon" @click="onEdit(item)" />
			</div>
		</template>
	</EasyDataTable>

	<book-modal :show="bookModalShow" :currentItem="currentItem" :authors="authors" :libraries="libraries"
		@addItem="addBook" @updateItem="updateBook" @updateShow="(v) => bookModalShow = v"></book-modal>

	<author-modal :show="authorModalShow" @addItem="addAuthor" @updateShow="(v) => authorModalShow = v"></author-modal>

	<library-modal :show="libraryModalShow" @addItem="addLibrary"
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
			this.authors = await Service.loadAuthors();
			this.libraries = await Service.loadLibraries();
		},

		async deleteItem(item) {
			this.books = await Service.deleteBook(item.id);
		},

		async addLibrary(item) {
			this.libraries = await Service.addLibrary(item);
		},

		async addAuthor(item) {
			this.authors = await Service.addAuthor({ ...item, authorBirth: formatDate(item.authorBirth) });
		},

		async addBook(item) {
			this.books = await Service.addBook(item);
		},

		async updateBook(item) {
			this.books = await Service.updateBook(item, item.id);
		},
	},

	computed: {
		authorOptions() {
			return this.authors.map(author => ({ value: author.id, text: author.name }))
		},

		authorChange: {
			get() {
				return this.currentItem.author_id;
			},
			set(newValue) {
				const newAuthor = this.authors.find(author => author.id === newValue);

				if (newAuthor) {
					this.currentItem.author_id = newValue;
					this.currentItem.authorName = newAuthor.name;
					this.currentItem.authorGenre = newAuthor.genre;
					this.currentItem.authorBirth = newAuthor.birthday;
				}
			}
		},

		libraryOptions() {
			return this.libraries.map(library => ({ value: library.id, text: library.name }))
		},

		libraryChange: {
			get() {
				return this.currentItem.libraryId;
			},
			set(newValue) {
				const newLibrary = this.libraries.find(library => library.id === newValue);

				if (newLibrary) {
					this.currentItem.libraryId = newValue;
					this.currentItem.libraryName = newLibrary.name;
					this.currentItem.libraryAddress = newLibrary.address;
				}
			}
		},
	},

	created() {
		this.loadItems();
	}
}
</script>
