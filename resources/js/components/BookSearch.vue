<template>
    <div class="d-flex mb-3">
        <div class="flex-grow-1">
            <input v-model="title" @keydown.enter="searchBooks" type="text" class="form-control" placeholder="Find a book...">
        </div>
        <button class="btn btn-primary ml-2" @click="searchBooks">Search</button>
    </div>
</template>

<script>

    export default {

        data() {
            return {
                title: ''
            }
        },

        methods: {

            searchBooks() {
                this.$emit('search', this.title)
            }

        }

    }

</script>

<style scoped>

</style>
