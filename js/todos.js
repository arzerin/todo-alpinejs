window.todoStore = {
    todos: JSON.parse(localStorage.getItem('todo-store') || '[]'),

    save() {
        localStorage.setItem('todo-store', JSON.stringify(this.todos));
    },
};

/*
window.Todo = function (body) {
    this.id = Date.now();
    this.body = body;
    this.completed = false;

    return new Proxy(this, {
        set(obj, prop, val) {
            obj[prop] = val;
        }
    });
}
    */

window.todos = function () {

    return {
            ...todoStore,
            filter: 'all',
            newTodo: '',
            editedTodo: null,

            get active() {
                return this.todos.filter(todo => !todo.completed);
            },

            get completed() {
                return this.todos.filter(todo => todo.completed);
            },

            get allComplete() {
                return this.todos.length > 0 &&
                        this.todos.length === this.completed.length;
                //return this.todos.length === this.completed.length;        
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
                
               //this.todos.push(new Todo(this.newTodo));

                this.save();
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

                this.save();
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
                this.save();
            },

            completeTodo (todo) {
                //alert ('hello');
                todo.completed = true;
            },

            toggleTodoCompletion(todo) {
                todo.completed = !todo.completed;

                this.save();
            },

            toggleAllComplete() {
                let allComplete = this.allComplete;

                this.todos.forEach(todo => {
                    todo.completed = !allComplete;
                });
                this.save();
            },

            clearCompletedTodos() {
                this.todos = this.active;
                this.save();
            },
            
    }
}