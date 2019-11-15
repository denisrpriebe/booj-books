<template>
    <div>

        <div v-if="isViewingBook">
            <book-details :book="view" @back="goBack"></book-details>
        </div>

        <div v-show="!isViewingBook">

            <!-- Books are loading -->
            <div v-if="isLoading" class="d-flex justify-content-center text-muted mt-5">
                <i class="fa fa-sync fa-spin books-icon"></i>
            </div>

            <!-- Sort list of books -->
            <div v-if="listHasBooks" class="form-group">
                <label for="sort-list">Sort by</label>
                <select v-model="sortBy" class="form-control" id="sort-list" @change="sortList">
                    <option value="position">Position (Default)</option>
                    <option value="title-asc">Title (A - Z)</option>
                    <option value="title-desc">Title (Z - A)</option>
                    <option value="author-asc">Author (A - Z)</option>
                    <option value="author-desc">Author (Z - A)</option>
                </select>
            </div>

            <!-- Show our list of books -->
            <div v-if="!isLoading" class="list-group">
                <draggable v-model="list" v-bind="dragOptions" group="goals" @start="drag=true" @end="saveList">
                    <transition-group type="transition" :name="!drag ? 'flip-list' : null">
                        <book v-for="book in list"
                              :key="book.position"
                              :book="book"
                              @view="viewBook"
                        ></book>
                    </transition-group>
                </draggable>
            </div>

            <!-- No book on list -->
            <div v-if="!isLoading && !listHasBooks" class="text-center text-muted mt-5">
                <i class="fa fa-wind books-icon"></i>
                <h5 class="mt-2">You don't have any books on your list</h5>
                <a href="/books">Find a book</a>
            </div>

        </div>

    </div>
</template>

<script>

    import draggable from 'vuedraggable'

    export default {

        components: {
            draggable
        },

        data() {
            return {
                sortBy: 'position',
                drag: false,
                view: {},
                list: [],
                isLoading: false
            }
        },

        created() {
            this.loadList()
        },

        computed: {

            listHasBooks() {
                return !_.isEmpty(this.list)
            },

            isViewingBook() {
                return !_.isEmpty(this.view)
            },

            dragOptions() {
                return {
                    animation: 100,
                    group: 'description',
                    ghostClass: 'ghost'
                };
            },

        },

        methods: {

            loadList() {
                this.isLoading = true
                this.sortBy = 'position'
                axios.get('/api/list')
                    .then(response => this.list = response.data)
                    .finally(() => this.isLoading = false)
            },

            saveList() {
                this.drag = false
                this.updateList()
                this.list.forEach((book) => {
                    axios.put(`/api/list/${book.olid}`, book)
                })
            },

            updateList() {
                this.list.map((book, key) => {
                    book.position = (key + 1)
                    return book
                })
            },

            sortList() {
                switch (this.sortBy) {
                    case 'title-asc':
                        this.list.sort((a, b) => a.title > b.title ? 1 : -1)
                        break
                    case 'title-desc':
                        this.list.sort((a, b) => a.title < b.title ? 1 : -1)
                        break
                    case 'author-asc':
                        this.list.sort((a, b) => a.author > b.author ? 1 : -1)
                        break
                    case 'author-desc':
                        this.list.sort((a, b) => a.author < b.author ? 1 : -1)
                        break
                    default:
                        this.list.sort((a, b) => a.position > b.position ? 1 : -1)
                }
            },

            viewBook(book) {
                this.view = book
            },

            goBack() {
                this.loadList()
                this.view = {}
            }

        }

    }

</script>

<style scoped>

    .books-icon {
        font-size: 35px;
    }

    .flip-list-move {
        transition: transform 0s;
    }

    .no-move {
        transition: transform 0s;
    }

    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }

</style>
