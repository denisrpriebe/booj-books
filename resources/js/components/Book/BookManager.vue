<template>
    <div>

        <div v-if="isViewingBook">
            <book-details :book="view" @back="view = {}"></book-details>
        </div>

        <div v-show="!isViewingBook">

            <!-- Book searcher -->
            <book-search @search="search"></book-search>

            <!-- Books are loading -->
            <div v-if="isLoading" class="d-flex justify-content-center text-muted mt-5">
                <i class="fa fa-sync fa-spin books-icon"></i>
            </div>

            <!-- Show our list of books -->
            <div v-if="!isLoading" class="list-group">
                <book v-for="(book, key) in books"
                      :key="key"
                      :book="book"
                      @view="viewBook"
                ></book>
            </div>

            <!-- No books found for search -->
            <div v-if="!booksFound && !isLoading && searchQuery"
                 class="text-center text-muted mt-5">
                <i class="far fa-frown-open books-icon"></i>
                <h5 class="mt-2">No books found</h5>
            </div>

            <!-- Initial search text -->
            <div v-if="!isLoading && !searchQuery" class="text-center text-muted mt-5">
                <i class="fa fa-book books-icon"></i>
                <h5 class="mt-2">Find your next book</h5>
            </div>

        </div>

    </div>
</template>

<script>

    export default {

        data() {
            return {
                view: {},
                books: [],
                searchQuery: '',
                isLoading: false
            }
        },

        computed: {

            endpoint() {
                return `/api/books?search=${this.searchQuery}`
            },

            booksFound() {
                return !_.isEmpty(this.books)
            },

            isViewingBook() {
                return !_.isEmpty(this.view)
            }

        },

        methods: {

            loadBooks() {
                this.isLoading = true
                axios.get(this.endpoint)
                    .then(response => this.books = response.data)
                    .finally(() => this.isLoading = false)
            },

            search(value) {
                this.searchQuery = value
                this.loadBooks()
            },

            viewBook(book) {
                this.view = book
            }

        }

    }

</script>

<style scoped>

    .books-icon {
        font-size: 35px;
    }

</style>
