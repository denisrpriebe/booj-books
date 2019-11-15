<template>
    <div>

        <!-- Book details are loading -->
        <div v-if="isLoading" class="d-flex justify-content-center text-muted mt-5">
            <i class="fa fa-sync fa-spin books-icon"></i>
        </div>

        <!-- Action buttons -->
        <div v-if="!isLoading" class="d-flex justify-content-between align-items-center mb-3">

            <button class="btn btn-sm btn-primary" @click="$emit('back')">
                <i class="fas fa-chevron-left"></i>
                Back
            </button>

            <button v-if="!details.on_list && isSignedIn" @click="addToList"
                    class="btn btn-sm btn-success">
                <i class="fas fa-plus-circle"></i>
                Add to my list
            </button>

            <button v-if="details.on_list && isSignedIn" @click="removeFromList"
                    class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i>
                Remove from my list
            </button>

            <p v-if="!isSignedIn" href="/register" class="text-info mb-0">
                <i class="fas fa-info-circle"></i>
                Login or register to save this book.
            </p>

        </div>

        <!-- Book details -->
        <div v-if="!isLoading" class="row">

            <!-- Cover photo, if available -->
            <div class="col-md-4"><img class="img-thumbnail cover" :src="details.image"></div>

            <!-- Title and description -->
            <div class="col-md-8">
                <h2>{{ book.title }}
                    <br><small>by {{ book.author }} ({{ book.published }})</small>
                </h2>
                <p class="mt-3">{{ details.description }}</p>
            </div>

        </div>

    </div>
</template>

<script>

    export default {

        props: {

            book: {
                type: Object,
                required: true
            }

        },

        data() {
            return {
                details: {},
                isLoading: false
            }
        },

        created() {
            this.loadDetails()
        },

        computed: {

            endpoint() {
                return `/api/books/${this.book.olid}`
            },

            isSignedIn() {
                return BoojBooks.isSignedIn
            }

        },

        methods: {

            loadDetails() {
                this.isLoading = true
                axios.get(this.endpoint)
                    .then(response => this.details = response.data)
                    .finally(() => this.isLoading = false)
            },

            addToList() {
                axios.post('/api/list', {...this.book, ...this.details})
                    .then(() => this.loadDetails())
            },

            removeFromList() {
                axios.delete(`/api/list/${this.book.olid}`)
                    .then(() => this.loadDetails())
            }

        }

    }

</script>

<style scoped>

    .books-icon {
        font-size: 35px;
    }

    .cover {
        min-width: 200px;
    }

</style>
