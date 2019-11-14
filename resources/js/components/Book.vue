<template>
    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <h5 class="mb-0">{{ book.title }}
                <br><small>by {{ book.author }} ({{ book.published }})</small>
            </h5>
            <div>
                <button class="btn btn-sm btn-info">View</button>
                <button class="btn btn-sm btn-success">Add</button>
            </div>
        </div>
    </a>
</template>

<script>

    export default {

        props: {

            book: {
                type: Object,
                required: true
            }

        },

    }

</script>

<style scoped>

</style>
