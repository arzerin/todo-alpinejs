window.todos = function () {

    return {

            filter: 'all',
            todos: [],
            
            editedTodo: false,
            get active() {
                return this.todos.filter(todo => !todo.completed);
            },

            get completed() {
                return this.todos.filter(todo => todo.completed);
            },

            get filteredTodos() {

                return {
                    all: this.todos,
                    active: this.active,
                    completed: this.completed
                }[this.filter];

                /*
                if (this.filter === 'all'){
                    return this.todos;
                }

                if (this.filter === 'active'){
                    return this.active;
                }


                if (this.filter === 'completed'){
                    return this.completed;
                }
                */
            },

            newTodo: '',

            addTodo() {

                if (! this.newTodo) {
                    return;
                }

                if (! this.newTodo.trim() === '') {
                    return;
                }

                this.todos.push({
                    id: Date.now(), //this.todos.length + 1,
                    body: this.newTodo,
                    completed: false
                });

                this.newTodo = '';
            },

            editTodo(todo) {
                todo.cachedBody = todo.body;
                this.editedTodo  = todo;
            },

            editComplete(todo) {
                if (todo.body.trim() === '')
                {
                    return this.deleteTodo(todo);
                }

                todo.body = todo.body.trim();
                this.editedTodo = null;
                delete todo.cachedBody;
            },
            
            cancelEdit(todo) {
                // Restore original value
                todo.body = todo.cachedBody;
                this.editedTodo = null;
                delete todo.cachedBody;
            },

            deleteTodo(todo) {
                let position = this.todos.indexOf(todo);

                this.todos.splice(position, 1);
            },

            completeTodo (todo) {
                //alert ('hello');
                todo.completed = true;
            }
    }
}