<template>
    <div>

        <!-- Book searcher -->
        <book-search @search="search"></book-search>

        <!-- Books are loading -->
        <div v-if="isLoading" class="d-flex justify-content-center text-muted mt-3">
            <i class="fa fa-sync fa-spin books-loader"></i>
        </div>

        <!-- Show our list of books -->
        <div v-if="!isLoading" class="list-group">
            <book v-for="(book, key) in books" :key="key" :book="book"></book>
        </div>

        <div v-if="!booksFound && !isLoading" class="text-center text-muted mt-3">
            <i class="fa fa-wind books-empty"></i>
            <h5>No books found</h5>
        </div>

    </div>
</template>

<script>

    export default {

        data() {
            return {
                books: [],
                searchQuery: '',
                isLoading: false
            }
        },

        created() {
            this.loadBooks()
        },

        computed: {

            endpoint() {
                return `/api/books?search=${this.searchQuery}`
            },

            booksFound() {
                return this.books.length > 0
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
            }

        }

    }

</script>

<style scoped>

    .books-loader {
        font-size: 35px;
    }

    .books-empty {
        font-size: 35px;
    }

</style>
