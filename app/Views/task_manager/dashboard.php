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
    .project-actions,.category-actions{display:flex;gap:3px;opacity:0;transition:opacity .15s}
    .project:hover .project-actions,.category-head:hover .category-actions{opacity:1}
    .icon-btn{border:0;background:transparent;color:#999;font-size:13px;padding:2px 5px;border-radius:4px}
    .icon-btn:hover{color:#222;background:#eee}
    .task-title-btn{border:0;background:transparent;padding:0;text-align:left;font:inherit;color:inherit;cursor:pointer}
    .task-title-btn:hover{text-decoration:underline}
    .category-block{margin-top:30px}
    .category-head{display:flex;align-items:center;gap:8px;border-bottom:2px solid #222;padding-bottom:8px}
    .category-head strong{font-size:15px;flex:1}
    .category-count{font-size:11px;color:#888;font-weight:500}
    .category-add{border:0;background:transparent;color:#666;font-size:12px;font-weight:650;padding:4px 7px;border-radius:4px}
    .category-add:hover{background:#eee;color:#222}
    .add-category{margin-top:25px;border:1px dashed #aaa;background:#fff;border-radius:5px;padding:9px 12px;color:#555;font-weight:650}
    .modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.40);display:grid;place-items:center;padding:20px;z-index:1000}
    .modal{width:min(540px,100%);max-height:90vh;overflow:auto;background:#fff;border:1px solid #ccc;border-radius:9px;box-shadow:0 20px 60px rgba(0,0,0,.22);padding:25px}
    .modal.modal-wide{width:min(680px,100%)}
    .modal h3{font-size:21px;margin:0 0 7px}.modal-subtitle{font-size:13px;color:#777;margin:0 0 20px}
    .field{margin-bottom:15px}.field label{display:block;font-size:12px;font-weight:750;color:#555;margin-bottom:6px}
    .field input,.field select{width:100%;border:1px solid #bbb;border-radius:5px;padding:10px 11px;font-size:14px;background:#fff}
    .modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:21px}.btn{border:1px solid #bbb;background:#fff;border-radius:5px;padding:9px 14px;font-weight:650}
    .btn-primary{background:#2f7d32;color:#fff;border-color:#2f7d32}.btn:disabled{opacity:.55;cursor:not-allowed}
    .error-box{background:#fff2f0;border:1px solid #e4b6ae;color:#8b2e22;padding:9px 11px;border-radius:5px;font-size:13px;margin:13px 0}
    .import-summary{background:#f7f7f5;border:1px solid #ddd;border-radius:6px;padding:12px;margin-top:14px;font-size:13px}
    .import-preview{border:1px solid #ddd;border-radius:6px;margin-top:14px;max-height:310px;overflow:auto}
    .preview-category{padding:10px 12px 5px;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.05em;background:#fafafa;border-top:1px solid #eee}
    .preview-category:first-child{border-top:0}
    .preview-task{display:flex;gap:8px;padding:7px 12px;font-size:13px;border-top:1px solid #f0f0f0}
    .preview-task.done span:last-child{text-decoration:line-through;color:#999}
    .empty-category{padding:14px 4px;color:#999;font-size:13px}

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
      <a href="#" @click.prevent="openImportModal()">Import</a>
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
    <template x-if="currentProject && currentProject.id">
      <div>
        <div class="top">
          <div>
            <h1 x-text="currentProject.name"></h1>
            <div class="muted">Project to-dos · <span x-text="activeTodos.length"></span> remaining</div>
          </div>
          <span class="badge" x-text="completedTodos.length + ' completed'"></span>
        </div>

        <div class="add-row">
          <input x-model="newTodo" @keyup.enter="addTodo()" placeholder="Add a to-do to selected/default category…">
          <button class="add" @click="addTodo()">Add to-do</button>
        </div>

        <!-- Basecamp-style task lists: category heading, then ordinary task rows -->
        <template x-for="category in displayCategories" :key="category.id">
          <section class="category-block">
            <div class="category-head">
              <strong x-text="category.name"></strong>
              <span class="category-count" x-text="categoryTasks(category.id).length + ' tasks'"></span>
              <div class="category-actions" x-show="category.id !== 0">
                <button class="category-add" @click="openTaskModal(null, category.id)">+ task</button>
                <button class="icon-btn" @click="openCategoryModal(category)" title="Rename category">✎</button>
                <button class="icon-btn" @click="deleteCategory(category)" title="Delete category">×</button>
              </div>
            </div>

            <template x-for="todo in categoryActiveTasks(category.id)" :key="todo.id">
              <div class="todo">
                <input type="checkbox" :checked="isCompleted(todo)" @change="toggle(todo)">
                <button type="button" class="title task-title-btn" x-text="todo.body" @click="openTaskModal(todo)" title="Edit task"></button>
                <div class="meta" x-text="todo.assignee || 'Unassigned'"></div>
                <div class="meta" x-text="formatDate(todo.due_date)"></div>
                <button class="delete" @click="remove(todo)" title="Delete">×</button>
              </div>
            </template>

            <template x-for="todo in categoryCompletedTasks(category.id)" :key="'done-'+todo.id">
              <div class="todo completed">
                <input type="checkbox" :checked="isCompleted(todo)" @change="toggle(todo)">
                <button type="button" class="title task-title-btn" x-text="todo.body" @click="openTaskModal(todo)" title="Edit task"></button>
                <div class="meta" x-text="todo.assignee || 'Unassigned'"></div>
                <div class="meta" x-text="formatDate(todo.due_date)"></div>
                <button class="delete" @click="remove(todo)" title="Delete">×</button>
              </div>
            </template>

            <div class="empty-category" x-show="categoryTasks(category.id).length === 0">No tasks in this category.</div>
          </section>
        </template>

        <button class="add-category" @click="openCategoryModal()">+ Add category</button>
      </div>
    </template>

    <div x-show="loading && projects.length === 0" class="muted">Loading projects and tasks…</div>
    <div x-show="!loading && projects.length === 0" class="muted">No projects yet. Create your first project from the sidebar.</div>
  </main>

  <aside class="sidebar">
    <h2>Projects</h2>
    <template x-for="project in projects" :key="project.id">
      <div class="project" :class="{active: Number(project.id) === Number(currentProjectId)}" @click="selectProject(project)">
        <span class="dot" :class="project.color"></span>
        <span class="project-name" x-text="project.name"></span>
        <span class="project-actions" @click.stop>
          <button class="icon-btn" @click="openProjectModal(project)" title="Edit project">✎</button>
          <button class="icon-btn" @click="deleteProject(project)" title="Delete project">×</button>
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


  <!-- PROJECT MODAL -->
  <div class="modal-backdrop" x-show="projectModal" x-transition @click.self="closeProjectModal()" x-cloak>
    <div class="modal">
      <h3 x-text="projectForm.id ? 'Edit project' : 'New project'"></h3>
      <p class="modal-subtitle">Projects remain in the right sidebar, preserving the Basecamp-style workspace.</p>
      <div class="error-box" x-show="formError" x-text="formError"></div>
      <div class="field"><label>Project name</label><input x-model="projectForm.name" @keyup.enter="saveProject()" placeholder="Project name"></div>
      <div class="field"><label>Color</label><select x-model="projectForm.color"><option value="">Green</option><option value="blue">Blue</option><option value="orange">Orange</option><option value="purple">Purple</option></select></div>
      <div class="modal-actions"><button class="btn" @click="closeProjectModal()">Cancel</button><button class="btn btn-primary" @click="saveProject()" :disabled="saving" x-text="saving?'Saving…':'Save project'"></button></div>
    </div>
  </div>

  <!-- CATEGORY MODAL -->
  <div class="modal-backdrop" x-show="categoryModal" x-transition @click.self="closeCategoryModal()" x-cloak>
    <div class="modal">
      <h3 x-text="categoryForm.id ? 'Rename category' : 'Add category'"></h3>
      <p class="modal-subtitle">Category headings behave like Basecamp task-list sections.</p>
      <div class="error-box" x-show="formError" x-text="formError"></div>
      <div class="field"><label>Category name</label><input x-model="categoryForm.name" @keyup.enter="saveCategory()" placeholder="e.g. Authentication"></div>
      <div class="modal-actions"><button class="btn" @click="closeCategoryModal()">Cancel</button><button class="btn btn-primary" @click="saveCategory()" :disabled="saving" x-text="saving?'Saving…':'Save category'"></button></div>
    </div>
  </div>

  <!-- TASK MODAL -->
  <div class="modal-backdrop" x-show="taskModal" x-transition @click.self="closeTaskModal()" x-cloak>
    <div class="modal">
      <h3 x-text="taskForm.id ? 'Edit task' : 'New task'"></h3>
      <div class="error-box" x-show="formError" x-text="formError"></div>
      <div class="field"><label>Task</label><input x-model="taskForm.body" placeholder="What needs to be done?"></div>
      <div class="field"><label>Category</label><select x-model="taskForm.category_id"><option value="">Uncategorized</option><template x-for="c in projectCategories" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select></div>
      <div class="field"><label>Assignee</label><input x-model="taskForm.assignee" placeholder="Assignee"></div>
      <div class="field"><label>Due date</label><input type="date" x-model="taskForm.due_date"></div>
      <div class="modal-actions"><button class="btn" @click="closeTaskModal()">Cancel</button><button class="btn btn-primary" @click="saveTask()" :disabled="saving" x-text="saving?'Saving…':'Save task'"></button></div>
    </div>
  </div>

  <!-- MARKDOWN IMPORT MODAL -->
  <div class="modal-backdrop" x-show="importModal" x-transition @click.self="closeImportModal()" x-cloak>
    <div class="modal modal-wide">
      <h3>Import TASKS.md</h3>
      <p class="modal-subtitle">Markdown <strong>## headings</strong> become categories. <strong>[ ]</strong> imports pending tasks and <strong>[x]</strong> imports completed tasks into <span x-text="currentProject.name"></span>.</p>
      <div class="error-box" x-show="formError" x-text="formError"></div>
      <div class="field">
        <label>Markdown file</label>
        <input type="file" accept=".md,.markdown,text/markdown,text/plain" @change="selectImportFile($event)">
      </div>
      <div class="import-summary" x-show="importFile">
        <strong x-text="importFile?.name"></strong><br>
        <span class="muted"><span x-text="importPreview.length"></span> tasks detected · <span x-text="importCategoryNames.length"></span> categories detected</span>
      </div>
      <div class="import-preview" x-show="importPreview.length">
        <template x-for="group in importGroups" :key="group.name">
          <div>
            <div class="preview-category" x-text="group.name"></div>
            <template x-for="(task,i) in group.tasks" :key="i">
              <div class="preview-task" :class="{done:task.completed}">
                <span x-text="task.completed ? '☑' : '☐'"></span><span x-text="task.body"></span>
              </div>
            </template>
          </div>
        </template>
      </div>
      <div class="modal-actions"><button class="btn" @click="closeImportModal()">Cancel</button><button class="btn btn-primary" @click="importTasks()" :disabled="saving || !importPreview.length" x-text="saving?'Importing…':'Import tasks'"></button></div>
    </div>
  </div>

  <footer class="footer">
    <p>Task Manager &nbsp;·&nbsp; Basecamp-inspired project workspace</p>
  </footer>
</div>

<script>
function taskManager(){
  let cached=null;
  try{cached=JSON.parse(localStorage.getItem('basecamp-task-manager')||'null')}catch(e){}
  let csrfHash='<?= csrf_hash() ?>';

  return {
    currentProjectId:cached?.currentProjectId?Number(cached.currentProjectId):null,
    projects:cached?.projects||[], categories:cached?.categories||[], todos:cached?.todos||[],
    newTodo:'',loading:false,saving:false,formError:'',
    projectModal:false,categoryModal:false,taskModal:false,importModal:false,
    projectForm:{id:null,name:'',color:''}, categoryForm:{id:null,name:''},
    taskForm:{id:null,body:'',category_id:'',assignee:'',due_date:''},
    importFile:null,importPreview:[],

    async init(){await this.loadData()},
    get currentProject(){return this.projects.find(p=>Number(p.id)===Number(this.currentProjectId))||this.projects[0]||{name:'Projects'}},
    get projectCategories(){return this.categories.filter(c=>Number(c.project_id)===Number(this.currentProjectId))},
    get projectTodos(){return this.todos.filter(t=>Number(t.project_id)===Number(this.currentProjectId))},
    get activeTodos(){return this.projectTodos.filter(t=>!this.isCompleted(t))},
    get completedTodos(){return this.projectTodos.filter(t=>this.isCompleted(t))},
    get displayCategories(){
      const result=[...this.projectCategories];
      if(this.projectTodos.some(t=>!t.category_id)) result.push({id:0,name:'Uncategorized',project_id:this.currentProjectId});
      return result;
    },
    get importCategoryNames(){return [...new Set(this.importPreview.map(t=>t.category).filter(Boolean))]},
    get importGroups(){
      const names=[...new Set(this.importPreview.map(t=>t.category||'Uncategorized'))];
      return names.map(name=>({name,tasks:this.importPreview.filter(t=>(t.category||'Uncategorized')===name)}));
    },

    isCompleted(t){return t.completed===true||t.completed===1||t.completed==='1'},
    categoryTasks(id){return this.projectTodos.filter(t=>id===0?!t.category_id:Number(t.category_id)===Number(id))},
    categoryActiveTasks(id){return this.categoryTasks(id).filter(t=>!this.isCompleted(t))},
    categoryCompletedTasks(id){return this.categoryTasks(id).filter(t=>this.isCompleted(t))},

    async request(url,options={}){
      options.headers={...(options.headers||{}),'Accept':'application/json','X-Requested-With':'XMLHttpRequest'};
      if(options.method&&options.method!=='GET'){options.headers['Content-Type']='application/json';options.headers['X-CSRF-TOKEN']=csrfHash}
      const r=await fetch(url,options),data=await r.json().catch(()=>({success:false,message:'Invalid server response'}));
      if(data.csrfHash)csrfHash=data.csrfHash;
      if(!r.ok||data.success===false)throw new Error(data.message||('HTTP '+r.status));
      return data;
    },

    async loadData(){
      this.loading=true;
      try{
        const d=await this.request('<?= site_url('task-manager/data') ?>');
        this.projects=(d.projects||[]).map(p=>({...p,id:Number(p.id)}));
        this.categories=(d.categories||[]).map(c=>({...c,id:Number(c.id),project_id:Number(c.project_id)}));
        this.todos=(d.tasks||[]).map(t=>this.normalizeTask(t));
        if(!this.projects.some(p=>Number(p.id)===Number(this.currentProjectId)))this.currentProjectId=this.projects[0]?.id||null;
        this.saveCache();
      }catch(e){console.error(e)}
      finally{this.loading=false}
    },
    selectProject(p){this.currentProjectId=Number(p.id);this.saveCache()},
    saveCache(){localStorage.setItem('basecamp-task-manager',JSON.stringify({projects:this.projects,categories:this.categories,todos:this.todos,currentProjectId:this.currentProjectId}))},

    openProjectModal(p=null){this.formError='';this.projectForm=p?{id:p.id,name:p.name,color:p.color||''}:{id:null,name:'',color:''};this.projectModal=true},
    closeProjectModal(){this.projectModal=false},
    async saveProject(){
      if(!this.projectForm.name.trim()){this.formError='Project name is required.';return}
      this.saving=true;this.formError='';
      try{
        const edit=!!this.projectForm.id,url=edit?'<?= site_url('task-manager/projects') ?>/'+this.projectForm.id:'<?= site_url('task-manager/projects') ?>';
        const d=await this.request(url,{method:edit?'PUT':'POST',body:JSON.stringify(this.projectForm)});
        const p={...d.project,id:Number(d.project.id)};
        if(edit)this.projects=this.projects.map(x=>Number(x.id)===p.id?p:x);else{this.projects.push(p);this.currentProjectId=p.id}
        this.projectModal=false;this.saveCache()
      }catch(e){this.formError=e.message}finally{this.saving=false}
    },
    async deleteProject(p){
      if(!confirm(`Delete "${p.name}" and all categories/tasks?`))return;
      try{await this.request('<?= site_url('task-manager/projects') ?>/'+p.id,{method:'DELETE'});await this.loadData()}catch(e){alert(e.message)}
    },

    openCategoryModal(c=null){this.formError='';this.categoryForm=c?{id:c.id,name:c.name}:{id:null,name:''};this.categoryModal=true},
    closeCategoryModal(){this.categoryModal=false},
    async saveCategory(){
      if(!this.categoryForm.name.trim()){this.formError='Category name is required.';return}
      this.saving=true;this.formError='';
      try{
        const edit=!!this.categoryForm.id,url=edit?'<?= site_url('task-manager/categories') ?>/'+this.categoryForm.id:'<?= site_url('task-manager/categories') ?>';
        await this.request(url,{method:edit?'PUT':'POST',body:JSON.stringify({...this.categoryForm,project_id:this.currentProjectId})});
        this.categoryModal=false;await this.loadData()
      }catch(e){this.formError=e.message}finally{this.saving=false}
    },
    async deleteCategory(c){
      if(!confirm(`Delete category "${c.name}"? Its tasks will become Uncategorized.`))return;
      try{await this.request('<?= site_url('task-manager/categories') ?>/'+c.id,{method:'DELETE'});await this.loadData()}catch(e){alert(e.message)}
    },

    async addTodo(){
      const body=this.newTodo.trim();if(!body||!this.currentProjectId)return;
      const category=this.projectCategories[0]?.id||null;
      try{
        const d=await this.request('<?= site_url('task-manager/tasks') ?>',{method:'POST',body:JSON.stringify({project_id:this.currentProjectId,category_id:category,body})});
        this.todos.unshift(this.normalizeTask(d.task));this.newTodo='';this.saveCache()
      }catch(e){alert(e.message)}
    },
    openTaskModal(t=null,categoryId=null){
      this.formError='';this.taskForm=t?{id:t.id,body:t.body,category_id:t.category_id||'',assignee:t.assignee||'',due_date:t.due_date||''}:{id:null,body:'',category_id:categoryId||'',assignee:'',due_date:''};this.taskModal=true
    },
    closeTaskModal(){this.taskModal=false},
    async saveTask(){
      if(!this.taskForm.body.trim()){this.formError='Task description is required.';return}
      this.saving=true;this.formError='';
      try{
        const edit=!!this.taskForm.id,url=edit?'<?= site_url('task-manager/tasks') ?>/'+this.taskForm.id:'<?= site_url('task-manager/tasks') ?>';
        await this.request(url,{method:edit?'PUT':'POST',body:JSON.stringify({...this.taskForm,project_id:this.currentProjectId})});
        this.taskModal=false;await this.loadData()
      }catch(e){this.formError=e.message}finally{this.saving=false}
    },
    async toggle(t){
      const old=this.isCompleted(t);t.completed=!old;this.saveCache();
      try{const d=await this.request('<?= site_url('task-manager/tasks') ?>/'+t.id,{method:'PUT',body:JSON.stringify({completed:t.completed?1:0})});Object.assign(t,this.normalizeTask(d.task));this.saveCache()}
      catch(e){t.completed=old;this.saveCache();alert(e.message)}
    },
    async remove(t){if(!confirm('Delete this task?'))return;try{await this.request('<?= site_url('task-manager/tasks') ?>/'+t.id,{method:'DELETE'});this.todos=this.todos.filter(x=>Number(x.id)!==Number(t.id));this.saveCache()}catch(e){alert(e.message)}},

    openImportModal(){
      if(!this.currentProjectId){alert('Please select a project first.');return}
      this.importFile=null;this.importPreview=[];this.formError='';this.importModal=true
    },
    closeImportModal(){this.importModal=false;this.importFile=null;this.importPreview=[];this.formError=''},
    async selectImportFile(e){
      const f=e.target.files[0];if(!f)return;this.importFile=f;this.formError='';
      try{this.importPreview=this.parseMarkdownTasks(await f.text());if(!this.importPreview.length)this.formError='No Markdown checkbox tasks were found.'}
      catch(err){this.formError='Unable to read the selected file.'}
    },
    parseMarkdownTasks(content){
      const tasks=[];
      let currentCategory=null;

      for(const rawLine of content.split(/\r?\n/)){
        const line=rawLine.trimEnd();

        /*
         * CATEGORY RULE
         * -------------
         * Any Markdown heading from ## through ###### becomes the current
         * category. The nearest heading before a task wins.
         *
         * Example:
         *
         * ## Tourist Spot Hotel Results
         * ### Tweakings
         * - [ ] Mobile Responsive
         *
         * => category = Tweakings
         *
         * A single # heading is treated as the document title and ignored.
         */
        const heading=line.match(/^\s*(#{2,6})\s+(.+?)\s*#*\s*$/);

        if(heading){
          currentCategory=heading[2].trim();
          continue;
        }

        /*
         * Import ONLY standard pending/completed checkboxes:
         *
         * [ ] = pending
         * [x] / [X] = completed
         *
         * Markers such as [~], [?], [later] are intentionally ignored.
         */
        const task=line.match(/^\s*[-*+]\s+\[([ xX])\]\s+(.+?)\s*$/);

        if(!task) continue;

        const body=task[2].trim();
        if(!body) continue;

        tasks.push({
          category:currentCategory || 'Uncategorized',
          body:body,
          completed:task[1].toLowerCase()==='x'
        });
      }

      return tasks;
    },
    async importTasks(){
      if(!this.importPreview.length)return;this.saving=true;this.formError='';
      try{
        const d=await this.request('<?= site_url('task-manager/tasks/import') ?>',{method:'POST',body:JSON.stringify({project_id:this.currentProjectId,tasks:this.importPreview})});
        await this.loadData();this.closeImportModal();alert(`${d.imported} tasks imported successfully.`)
      }catch(e){this.formError=e.message}finally{this.saving=false}
    },

    normalizeTask(t){return {...t,id:Number(t.id),project_id:Number(t.project_id),category_id:t.category_id?Number(t.category_id):null,completed:this.isCompleted(t)}},
    formatDate(d){if(!d)return'No date';const p=String(d).split('-'),m=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];return p.length===3?m[Number(p[1])-1]+' '+Number(p[2]):d}
  }
}
</script>
</body>
</html>