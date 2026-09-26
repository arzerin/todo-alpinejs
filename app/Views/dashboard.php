<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Task Manager</title>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>

    *{box-sizing:border-box}
    body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;background:#f7f7f5;color:#222}
    .app{max-width:1180px;margin:38px auto;background:#fff;border:1px solid #ddd;border-radius:8px;min-height:720px;display:grid;grid-template-columns:minmax(0,1fr) 285px;box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden}
    .main{padding:42px 55px}
    .sidebar{border-left:1px solid #ddd;background:#fafafa;padding:34px 26px}
    .top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:30px}
    h1{font-size:30px;margin:0 0 7px}.muted{color:#777;font-size:14px}
    .add-row{display:flex;gap:8px;margin:24px 0 28px}
    .add-row input{flex:1;border:1px solid #bbb;border-radius:5px;padding:11px 12px;font-size:15px}
    button{cursor:pointer}
    .add{background:#2f7d32;color:#fff;border:0;border-radius:5px;padding:0 18px;font-weight:700}
    .section-title{font-size:15px;font-weight:800;border-bottom:2px solid #222;padding-bottom:8px;margin:25px 0 0}
    .todo{display:grid;grid-template-columns:28px minmax(0,1fr) 105px 82px 24px;gap:8px;align-items:center;padding:12px 4px;border-bottom:1px solid #ececec}
    .todo input[type=checkbox]{width:18px;height:18px;accent-color:#27853a}
    .title{font-size:15px;line-height:1.35}.completed .title{text-decoration:line-through;color:#999}
    .meta{font-size:12px;color:#777}.delete{border:0;background:none;color:#aaa;font-size:20px}.delete:hover{color:#b42318}
    .completed-wrap{margin-top:34px}.completed-head{display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #ddd;padding-bottom:8px}
    .completed-head strong{font-size:14px}.clear{border:0;background:none;color:#777;text-decoration:underline;font-size:12px}
    .sidebar h2{font-size:13px;text-transform:uppercase;letter-spacing:.08em;color:#777;margin:0 0 14px}
    .project{display:flex;align-items:center;gap:10px;padding:10px 10px;border-radius:6px;margin-bottom:4px;font-size:14px;cursor:pointer}
    .project:hover{background:#eee}.project.active{background:#e9f3e8;font-weight:700}
    .dot{width:10px;height:10px;border-radius:50%;background:#3b7d3b;flex:0 0 auto}
    .dot.blue{background:#4878bd}.dot.orange{background:#c4772b}.dot.purple{background:#7b5ca7}
    .new-project{margin-top:18px;border:1px solid #bbb;background:white;border-radius:5px;padding:9px 12px;width:100%;font-weight:600}
    .stats{margin-top:34px;padding-top:20px;border-top:1px solid #ddd;font-size:13px;color:#666;line-height:1.8}
    .badge{display:inline-block;background:#eee;border-radius:20px;padding:2px 8px;font-size:12px}
    .footer{grid-column:1 / -1;border-top:1px solid #ddd;background:#fafafa;padding:16px 28px;text-align:center;font-size:12px;color:#888}.footer p{margin:0}

    .topbar{
        grid-column:1 / -1;
        height:58px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:0 28px;
        background:#fff;
        border-bottom:1px solid #ddd;
    }
    .brand{display:flex;align-items:center;gap:12px;font-weight:800;font-size:17px}
    .brand-mark{
        width:31px;height:31px;border-radius:7px;background:#2f7d32;color:#fff;
        display:grid;place-items:center;font-size:16px;font-weight:900
    }
    .topnav{display:flex;align-items:center;gap:6px}
    .topnav a{
        color:#555;text-decoration:none;font-size:14px;font-weight:600;
        padding:8px 11px;border-radius:5px
    }
    .topnav a:hover,.topnav a.active{background:#f0f0ee;color:#222}
    .user-menu{display:flex;align-items:center;gap:9px;font-size:13px;font-weight:600}
    .avatar{
        width:30px;height:30px;border-radius:50%;background:#e5e5e2;
        display:grid;place-items:center;font-size:12px
    }
    .breadcrumb{
        grid-column:1 / -1;
        display:flex;align-items:center;gap:7px;
        padding:11px 28px;
        border-bottom:1px solid #e7e7e5;
        background:#fafaf8;
        color:#777;font-size:13px
    }
    .breadcrumb a{color:#555;text-decoration:none}
    .breadcrumb a:hover{text-decoration:underline}
    .breadcrumb .sep{color:#aaa}

    @media(max-width:800px){.app{margin:0;border:0;border-radius:0;display:block}.topbar{height:auto;padding:12px 18px;gap:12px;flex-wrap:wrap}.topnav{order:3;width:100%;overflow-x:auto}.user-menu span{display:none}.breadcrumb{padding:10px 18px}.sidebar{border-left:0;border-top:1px solid #ddd}.main{padding:28px 20px}.todo{grid-template-columns:28px 1fr 24px}.meta{display:none}}
</style>

</head>
<body>
<div class="app" x-data="taskManager()">
  <header class="topbar">
    <div class="brand">
      <span class="brand-mark">B</span>
      <span>Task Manager</span>
    </div>

    <nav class="topnav" aria-label="Main navigation">
      <a href="#" class="active">Projects</a>
      <a href="#">My Tasks</a>
      <a href="#">Schedule</a>
      <a href="#">Activity</a>
    </nav>

    <div class="user-menu">
      <span>Project Manager</span>
      <span class="avatar">PM</span>
    </div>
  </header>

  <nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="#">Home</a>
    <span class="sep">›</span>
    <a href="#">Projects</a>
    <span class="sep">›</span>
    <strong x-text="currentProject.name"></strong>
    <span class="sep">›</span>
    <span>To-dos</span>
  </nav>
  <main class="main">
    <div class="top">
      <div>
        <h1 x-text="currentProject.name"></h1>
        <div class="muted">Project to-dos · <span x-text="activeTodos.length"></span> remaining</div>
      </div>
      <span class="badge" x-text="completedTodos.length + ' completed'"></span>
    </div>

    <div class="add-row">
      <input x-model="newTodo" @keyup.enter="addTodo()" placeholder="Add a to-do…">
      <button class="add" @click="addTodo()">Add to-do</button>
    </div>

    <div class="section-title">To-dos</div>
    <template x-for="todo in activeTodos" :key="todo.id">
      <div class="todo">
        <input type="checkbox" :checked="todo.completed" @change="toggle(todo)">
        <div class="title" x-text="todo.body"></div>
        <div class="meta" x-text="todo.assignee || 'Unassigned'"></div>
        <div class="meta" x-text="todo.due || 'No date'"></div>
        <button class="delete" @click="remove(todo)" title="Delete">×</button>
      </div>
    </template>
    <div x-show="activeTodos.length === 0" class="muted" style="padding:18px 4px">Everything is complete.</div>

    <div class="completed-wrap" x-show="completedTodos.length">
      <div class="completed-head">
        <strong>Completed</strong>
        <button class="clear" @click="clearCompleted()">Clear completed</button>
      </div>
      <template x-for="todo in completedTodos" :key="todo.id">
        <div class="todo completed">
          <input type="checkbox" :checked="todo.completed" @change="toggle(todo)">
          <div class="title" x-text="todo.body"></div>
          <div class="meta" x-text="todo.assignee || 'Unassigned'"></div>
          <div class="meta" x-text="todo.due || 'No date'"></div>
          <button class="delete" @click="remove(todo)">×</button>
        </div>
      </template>
    </div>
  </main>

  <aside class="sidebar">
    <h2>Projects</h2>
    <template x-for="project in projects" :key="project.id">
      <div class="project" :class="{active: project.id === currentProjectId}" @click="currentProjectId=project.id">
        <span class="dot" :class="project.color"></span>
        <span x-text="project.name"></span>
      </div>
    </template>
    <button class="new-project" @click="addProject()">+ New Project</button>

    <div class="stats">
      <strong>Project summary</strong><br>
      <span x-text="activeTodos.length"></span> open to-dos<br>
      <span x-text="completedTodos.length"></span> completed
    </div>
  </aside>

  <footer class="footer">
    <p>Task Manager &nbsp;·&nbsp; Basecamp-inspired project workspace</p>
  </footer>
</div>

<script>
function taskManager(){
  const saved = JSON.parse(localStorage.getItem('basecamp-task-manager') || 'null');
  return {
    currentProjectId: saved?.currentProjectId || 1,
    newTodo: '',
    projects: saved?.projects || [
      {id:1,name:'Website Redesign',color:''},
      {id:2,name:'CRM Development',color:'blue'},
      {id:3,name:'Mobile App',color:'orange'},
      {id:4,name:'BD Booking',color:'purple'}
    ],
    todos: saved?.todos || [
      {id:1,projectId:1,body:'Design homepage',completed:false,assignee:'John',due:'Sep 26'},
      {id:2,projectId:1,body:'Build login API',completed:false,assignee:'Alex',due:'Sep 27'},
      {id:3,projectId:1,body:'Mobile responsive layout',completed:false,assignee:'Sarah',due:'Sep 28'},
      {id:4,projectId:1,body:'Create database schema',completed:true,assignee:'John',due:'Sep 22'},
      {id:5,projectId:1,body:'Configure development server',completed:true,assignee:'Alex',due:'Sep 23'},
      {id:6,projectId:2,body:'Create customer pipeline',completed:false,assignee:'Zerin',due:'Sep 30'}
    ],
    get currentProject(){ return this.projects.find(p=>p.id===this.currentProjectId) || this.projects[0]; },
    get projectTodos(){ return this.todos.filter(t=>t.projectId===this.currentProjectId); },
    get activeTodos(){ return this.projectTodos.filter(t=>!t.completed); },
    get completedTodos(){ return this.projectTodos.filter(t=>t.completed); },
    save(){ localStorage.setItem('basecamp-task-manager',JSON.stringify({projects:this.projects,todos:this.todos,currentProjectId:this.currentProjectId})); },
    addTodo(){
      const body=this.newTodo.trim(); if(!body) return;
      this.todos.push({id:Date.now(),projectId:this.currentProjectId,body,completed:false,assignee:'Unassigned',due:'No date'});
      this.newTodo=''; this.save();
    },
    toggle(todo){ todo.completed=!todo.completed; this.save(); },
    remove(todo){ this.todos=this.todos.filter(t=>t.id!==todo.id); this.save(); },
    clearCompleted(){ this.todos=this.todos.filter(t=>!(t.projectId===this.currentProjectId && t.completed)); this.save(); },
    addProject(){
      const name=prompt('Project name:'); if(!name?.trim()) return;
      const id=Date.now(); this.projects.push({id,name:name.trim(),color:'blue'}); this.currentProjectId=id; this.save();
    }
  }
}
</script>
</body>
</html>