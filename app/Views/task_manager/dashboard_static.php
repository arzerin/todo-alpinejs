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

    [x-cloak]{display:none!important}
    .project-name{flex:1}
    .project-actions{display:flex;gap:3px;opacity:0}.project:hover .project-actions{opacity:1}
    .icon-btn{border:0;background:transparent;color:#999;font-size:13px;padding:2px 4px}.icon-btn:hover{color:#222}
    .task-title-btn{border:0;background:transparent;padding:0;text-align:left;font:inherit;color:inherit;cursor:pointer}
    .task-title-btn:hover{text-decoration:underline}
    .modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.38);display:grid;place-items:center;padding:20px;z-index:1000}
    .modal{width:min(520px,100%);background:#fff;border-radius:8px;border:1px solid #ccc;box-shadow:0 18px 55px rgba(0,0,0,.2);padding:24px}
    .modal h3{margin:0 0 20px;font-size:20px}.field{margin-bottom:15px}.field label{display:block;font-size:12px;font-weight:700;margin-bottom:6px;color:#555}
    .field input,.field select{width:100%;border:1px solid #bbb;border-radius:5px;padding:10px 11px;font-size:14px}
    .modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:20px}.btn{border:1px solid #bbb;background:#fff;border-radius:5px;padding:9px 14px;font-weight:650}.btn-primary{background:#2f7d32;color:#fff;border-color:#2f7d32}
    .error-box{background:#fff2f0;border:1px solid #e4b6ae;color:#8b2e22;padding:9px 11px;border-radius:5px;font-size:13px;margin-bottom:15px}

</style>

</head>
<body>
<div class="app" x-data="taskManager()" x-init="init()" x-cloak>
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
        <input type="checkbox" :checked="isCompleted(todo)" @change="toggle(todo)">
        <button type="button" class="title task-title-btn" x-text="todo.body" @click="openTaskModal(todo)" title="Edit task"></button>
        <div class="meta" x-text="todo.assignee || 'Unassigned'"></div>
        <div class="meta" x-text="formatDate(todo.due_date)"></div>
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
          <input type="checkbox" :checked="isCompleted(todo)" @change="toggle(todo)">
          <button type="button" class="title task-title-btn" x-text="todo.body" @click="openTaskModal(todo)" title="Edit task"></button>
          <div class="meta" x-text="todo.assignee || 'Unassigned'"></div>
          <div class="meta" x-text="formatDate(todo.due_date)"></div>
          <button class="delete" @click="remove(todo)">×</button>
        </div>
      </template>
    </div>
  </main>

  <aside class="sidebar">
    <h2>Projects</h2>
    <template x-for="project in projects" :key="project.id">
      <div class="project" :class="{active: Number(project.id) === Number(currentProjectId)}" @click="selectProject(project)">
        <span class="dot" :class="project.color"></span>
        <span class="project-name" x-text="project.name"></span>
        <span class="project-actions" @click.stop>
          <button type="button" class="icon-btn" @click="openProjectModal(project)" title="Edit project">✎</button>
          <button type="button" class="icon-btn" @click="deleteProject(project)" title="Delete project">×</button>
        </span>
      </div>
    </template>
    <button class="new-project" @click="openProjectModal()">+ New Project</button>

    <div class="stats">
      <strong>Project summary</strong><br>
      <span x-text="activeTodos.length"></span> open to-dos<br>
      <span x-text="completedTodos.length"></span> completed
    </div>
  </aside>


  <!-- Project create/update modal -->
  <div class="modal-backdrop" x-show="projectModal" x-transition @click.self="closeProjectModal()" x-cloak>
    <div class="modal">
      <h3 x-text="projectForm.id ? 'Edit project' : 'New project'"></h3>
      <div class="error-box" x-show="formError" x-text="formError"></div>
      <div class="field">
        <label>Project name</label>
        <input type="text" x-model="projectForm.name" @keyup.enter="saveProject()" placeholder="Project name">
      </div>
      <div class="field">
        <label>Color</label>
        <select x-model="projectForm.color">
          <option value="">Green</option><option value="blue">Blue</option>
          <option value="orange">Orange</option><option value="purple">Purple</option>
        </select>
      </div>
      <div class="modal-actions">
        <button class="btn" @click="closeProjectModal()">Cancel</button>
        <button class="btn btn-primary" @click="saveProject()" :disabled="saving" x-text="saving ? 'Saving…' : 'Save project'"></button>
      </div>
    </div>
  </div>

  <!-- Task create/update modal; quick add row still creates a simple task -->
  <div class="modal-backdrop" x-show="taskModal" x-transition @click.self="closeTaskModal()" x-cloak>
    <div class="modal">
      <h3 x-text="taskForm.id ? 'Edit task' : 'New task'"></h3>
      <div class="error-box" x-show="formError" x-text="formError"></div>
      <div class="field"><label>Task</label><input type="text" x-model="taskForm.body" placeholder="What needs to be done?"></div>
      <div class="field"><label>Assignee</label><input type="text" x-model="taskForm.assignee" placeholder="Assignee"></div>
      <div class="field"><label>Due date</label><input type="date" x-model="taskForm.due_date"></div>
      <div class="modal-actions">
        <button class="btn" @click="closeTaskModal()">Cancel</button>
        <button class="btn btn-primary" @click="saveTask()" :disabled="saving" x-text="saving ? 'Saving…' : 'Save task'"></button>
      </div>
    </div>
  </div>

  <footer class="footer">
    <p>Task Manager &nbsp;·&nbsp; Basecamp-inspired project workspace</p>
  </footer>
</div>

<script>
function taskManager(){
  let cached = null;
  try { cached = JSON.parse(localStorage.getItem('basecamp-task-manager') || 'null'); } catch(e) {}

  const csrfName = '<?= csrf_token() ?>';
  let csrfHash = '<?= csrf_hash() ?>';

  return {
    currentProjectId: cached?.currentProjectId ? Number(cached.currentProjectId) : null,
    projects: cached?.projects || [],
    todos: cached?.todos || [],
    newTodo: '',
    loading: false,
    saving: false,
    projectModal: false,
    taskModal: false,
    formError: '',
    projectForm: {id:null,name:'',color:''},
    taskForm: {id:null,body:'',assignee:'',due_date:''},

    async init(){ await this.loadData(); },

    get currentProject(){ return this.projects.find(p=>Number(p.id)===Number(this.currentProjectId)) || this.projects[0] || {name:'Projects'}; },
    get projectTodos(){ return this.todos.filter(t=>Number(t.project_id)===Number(this.currentProjectId)); },
    get activeTodos(){ return this.projectTodos.filter(t=>!this.isCompleted(t)); },
    get completedTodos(){ return this.projectTodos.filter(t=>this.isCompleted(t)); },

    isCompleted(t){ return t.completed===true || t.completed===1 || t.completed==='1'; },

    async request(url, options={}){
      options.headers = {...(options.headers||{}), 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest'};
      if (options.method && options.method !== 'GET') {
        options.headers['Content-Type'] = 'application/json';
        options.headers['X-CSRF-TOKEN'] = csrfHash;
      }
      const r = await fetch(url, options);
      const data = await r.json().catch(()=>({success:false,message:'Invalid server response'}));
      if (data.csrfHash) csrfHash = data.csrfHash;
      if (!r.ok || data.success===false) throw new Error(data.message || ('HTTP '+r.status));
      return data;
    },

    async loadData(){
      this.loading=true;
      try{
        const data=await this.request('<?= site_url('task-manager/data') ?>');
        this.projects=(data.projects||[]).map(p=>({...p,id:Number(p.id)}));
        this.todos=(data.tasks||[]).map(t=>({...t,id:Number(t.id),project_id:Number(t.project_id),completed:this.isCompleted(t)}));
        const exists=this.projects.some(p=>Number(p.id)===Number(this.currentProjectId));
        if((!this.currentProjectId || !exists) && this.projects.length) this.currentProjectId=this.projects[0].id;
        this.saveCache();
      }catch(e){ console.error(e); }
      finally{ this.loading=false; }
    },

    selectProject(project){ this.currentProjectId=Number(project.id); this.saveCache(); },
    saveCache(){ localStorage.setItem('basecamp-task-manager',JSON.stringify({projects:this.projects,todos:this.todos,currentProjectId:this.currentProjectId})); },

    async addTodo(){
      const body=this.newTodo.trim(); if(!body || !this.currentProjectId) return;
      this.saving=true;
      try{
        const data=await this.request('<?= site_url('task-manager/tasks') ?>',{
          method:'POST', body:JSON.stringify({project_id:this.currentProjectId,body})
        });
        this.todos.unshift(this.normalizeTask(data.task));
        this.newTodo=''; this.saveCache();
      }catch(e){ alert(e.message); }
      finally{ this.saving=false; }
    },

    openTaskModal(todo=null){
      this.formError='';
      this.taskForm=todo ? {id:todo.id,body:todo.body,assignee:todo.assignee||'',due_date:todo.due_date||''}
                         : {id:null,body:'',assignee:'',due_date:''};
      this.taskModal=true;
    },
    closeTaskModal(){ this.taskModal=false; },

    async saveTask(){
      if(!this.taskForm.body.trim()){this.formError='Task description is required.';return;}
      this.saving=true; this.formError='';
      try{
        const editing=!!this.taskForm.id;
        const url=editing ? '<?= site_url('task-manager/tasks') ?>/'+this.taskForm.id : '<?= site_url('task-manager/tasks') ?>';
        const data=await this.request(url,{
          method:editing?'PUT':'POST',
          body:JSON.stringify({...this.taskForm,project_id:this.currentProjectId})
        });
        const task=this.normalizeTask(data.task);
        if(editing) this.todos=this.todos.map(t=>Number(t.id)===Number(task.id)?task:t);
        else this.todos.unshift(task);
        this.taskModal=false; this.saveCache();
      }catch(e){this.formError=e.message;}
      finally{this.saving=false;}
    },

    async toggle(todo){
      const previous=this.isCompleted(todo);
      todo.completed=!previous; this.saveCache();
      try{
        const data=await this.request('<?= site_url('task-manager/tasks') ?>/'+todo.id,{
          method:'PUT',body:JSON.stringify({completed:todo.completed?1:0})
        });
        Object.assign(todo,this.normalizeTask(data.task)); this.saveCache();
      }catch(e){todo.completed=previous;this.saveCache();alert(e.message);}
    },

    async remove(todo){
      if(!confirm('Delete this task?')) return;
      try{
        await this.request('<?= site_url('task-manager/tasks') ?>/'+todo.id,{method:'DELETE'});
        this.todos=this.todos.filter(t=>Number(t.id)!==Number(todo.id)); this.saveCache();
      }catch(e){alert(e.message);}
    },

    async clearCompleted(){
      const list=[...this.completedTodos];
      if(!list.length || !confirm('Delete all completed tasks in this project?')) return;
      for(const todo of list){
        try{ await this.request('<?= site_url('task-manager/tasks') ?>/'+todo.id,{method:'DELETE'}); }
        catch(e){ alert(e.message); break; }
      }
      await this.loadData();
    },

    openProjectModal(project=null){
      this.formError='';
      this.projectForm=project ? {id:project.id,name:project.name,color:project.color||''} : {id:null,name:'',color:''};
      this.projectModal=true;
    },
    closeProjectModal(){this.projectModal=false;},

    async saveProject(){
      if(!this.projectForm.name.trim()){this.formError='Project name is required.';return;}
      this.saving=true;this.formError='';
      try{
        const editing=!!this.projectForm.id;
        const url=editing ? '<?= site_url('task-manager/projects') ?>/'+this.projectForm.id : '<?= site_url('task-manager/projects') ?>';
        const data=await this.request(url,{method:editing?'PUT':'POST',body:JSON.stringify(this.projectForm)});
        const project={...data.project,id:Number(data.project.id)};
        if(editing) this.projects=this.projects.map(p=>Number(p.id)===project.id?project:p);
        else {this.projects.push(project);this.currentProjectId=project.id;}
        this.projectModal=false;this.saveCache();
      }catch(e){this.formError=e.message;}
      finally{this.saving=false;}
    },

    async deleteProject(project){
      if(!confirm(`Delete "${project.name}" and all its tasks?`)) return;
      try{
        await this.request('<?= site_url('task-manager/projects') ?>/'+project.id,{method:'DELETE'});
        this.projects=this.projects.filter(p=>Number(p.id)!==Number(project.id));
        this.todos=this.todos.filter(t=>Number(t.project_id)!==Number(project.id));
        this.currentProjectId=this.projects[0]?.id || null; this.saveCache();
      }catch(e){alert(e.message);}
    },

    normalizeTask(t){return {...t,id:Number(t.id),project_id:Number(t.project_id),completed:this.isCompleted(t)};},
    formatDate(date){
      if(!date)return 'No date';
      const p=String(date).split('-');if(p.length!==3)return date;
      const m=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
      return m[Number(p[1])-1]+' '+Number(p[2]);
    }
  }
}
</script>
</body>
</html>