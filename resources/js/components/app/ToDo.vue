<template>
    <div class="col-lg-6 col-6">
    <div class="card">
        <div class="card-header ui-sortable-handle" >
            <h3 class="card-title text-blue" style="font-size: 22px; font-weight: 900">
                <i class="cap-icon ci-list-ul icolor"></i>
                To Do List
            </h3>

            <div class="card-tools">
                <pagination :data="todos.todos" @pagination-change-page="getResults">
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <ul class="todo-list ui-sortable" data-widget="todo-list" v-for="todo in todos.todos.data" :key="todo.id">

                <li style="" class="">
                    <div class="custom-control custom-checkbox d-inline">
                        <input type="checkbox" class="custom-control-input mousep" :id="todo.id"
                               name="completed" v-model="todo.completed" @click="markCompleted(todo.id, todo)">
                        <label class="custom-control-label mousep" :for="todo.id"></label>
                    </div>
                    <!-- todo text -->
                    <span class="text" :class="{ completed : todo.completed}">{{ todo.title }} </span>
                    <!-- General tools such as edit or delete-->
                    <small class="badge"
                           :class="todo.priority == 'high' ? 'badge-danger' : todo.priority == 'low' ? 'badge-info' : 'badge-warning'">
                        <i class="fas fa-exclamation"></i>
                        {{ todo.priority }}
                    </small>
                    <!-- Emphasis label -->
                    <small class="badge" ><i class="far fa-clock"></i> {{ todo.created_at | customDate }}</small>
                    <div class="tools">
                        <button type="button" class="btn btn-info btn-sm" @click="editModal(todo)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button @click="deleteTodo(todo)" class="btn btn-danger btn-sm"
                                 data-toggle="tooltip" data-placement="top" title="Delete User">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <button type="button" class="btn btn-info float-right" @click="newModal()">
                <i class="fas fa-plus"></i>
                Add item
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode" id="addNewLabel">
                        <i class="cap-icon ci-plus icolor"></i>
                        Add New ToDo
                    </h5>
                    <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                        <i class="cap-icon ci-file-edit icolor"></i>
                        Update ToDo
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- /.modal-header -->
                <form @submit.prevent="editMode ? updateTodo() : createTodo()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input v-model="form.title" type="text" name="title" id="title" placeholder="Title"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="title"></has-error>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea v-model="form.description" type="text" name="description" id="description" placeholder="Description"
                                      class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                            <has-error :form="form" field="description"></has-error>
                        </div>
                        <label >Priority</label>
                        <div class="form-group custom-control custom-radio" v-for="(prio, index) in priorities" :key="index">
                            <input type="radio" class="custom-control-input mousep"
                                   :name="prio.name" :value="prio.name" v-model="form.priority" :id="prio.name">
                            <label class="custom-control-label mousep" :for="prio.name">{{ prio.name }}</label>
                            <has-error :form="form" field="priority"></has-error>
                        </div>
                        <hr>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input mousep" id="customCheck2"
                                   name="completed" v-model="form.completed">
                            <label class="custom-control-label mousep" for="customCheck2">COMPLETED</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close
                            <span><i class="cap-icon ci-times"></i></span>
                        </button>
                        <button type="submit" v-show="!editMode" class="btn btn-success">Create
                            <span><i class="cap-icon ci-check"></i></span>
                        </button>
                        <button type="submit" v-show="editMode" class="btn btn-success">Update
                            <span><i class="cap-icon ci-save"></i></span>
                        </button>
                    </div>
                    <!-- /.modal-body -->
                </form>
                <!-- /.form -->
            </div>
        </div>
    </div>
    <!-- /.Modal -->
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "ToDo",

        data() {
            return {
                todos: {},
                form: new Form({
                    id: '',
                    title: '',
                    description: '',
                    completed: 0,
                    priority: ''
                }),
                priorities: [{name: 'High'}, {name: 'Medium'} , {name: 'Low'}],
                editMode: true
            }
        },

        computed: mapGetters(['allTodos']),

        methods: {
            ...mapActions(['fetchTodos', 'fetchTodosP']),

            loadTodos() {
                if(this.$gate.isAdmin()) {
                    this.fetchTodosP();
                    this.todos = this.$store.state.todos;
                }
            },

            getResults(page = 1) {
                this.fetchTodosP(page);
                this.todos = this.$store.state.todos;
            },

            markCompleted(id, todo) {
                todo.completed = !todo.completed;
                axios.put('api/todoMark/'+id, todo)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        toast.fire({
                            type: 'success',
                            title: 'Todo updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            editModal(todo) {
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(todo);
            },

            createTodo() {
                this.$Progress.start();
                this.form.post('../api/todo')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Todo added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateTodo(id) {
                this.$Progress.start();
                this.form.put('api/todo/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Todo updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            deleteTodo(todo){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/todo/'+todo.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Todo has been deleted.',
                                    'success'
                                );
                                Fire.$emit('AfterCreate');
                            }).catch(()=> {
                            swal("Failed!", "There was something wrong.", "warning");
                        });
                    } else {
                        console.log('qqqqqqqqqqqq');
                    }
                })
            }
        },

        created() {
            this.loadTodos();
            Fire.$on('AfterCreate', () => {
                this.loadTodos();
            });
        }
    }
</script>

<style scoped>
    .mousep {
        cursor: pointer;
    }

    .completed {
        text-decoration: line-through;
        color: gray;
    }
</style>