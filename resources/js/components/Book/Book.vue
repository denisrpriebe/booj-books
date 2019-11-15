<template>
    <div class="list-group-item flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <h5 class="mb-0">{{ book.title }}
                <br><small>by {{ book.author }} ({{ book.published }})</small>
            </h5>
            <div>
                <button class="btn btn-sm btn-info" @click="viewBook">View</button>
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

        methods: {

            viewBook() {
                this.$emit('view', this.book)
            }

        }

    }

</script>

<style scoped>

</style>
