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
    .todo{display:grid;grid-template-columns:28px minmax(0,1fr) 105px 66px 82px 24px;gap:8px;align-items:center;padding:12px 4px;border-bottom:1px solid #ececec}
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


    /* ==============================================================
       Phase 3 additions — deliberately follow the Phase 1 visual system
       ============================================================== */
    .phase3-action{padding:9px 15px;min-height:36px}
    .people-row{display:grid;grid-template-columns:48px minmax(0,1fr) 90px 54px;gap:14px;align-items:center;padding:16px 4px;border-bottom:1px solid #ececec}
    .person-avatar{width:42px;height:42px;border-radius:50%;background:#e9f3e8;color:#2f7d32;display:grid;place-items:center;overflow:hidden;font-size:11px;font-weight:800;flex:0 0 auto}
    .person-avatar img{width:100%;height:100%;object-fit:cover}.person-avatar.small{width:30px;height:30px;font-size:9px}.person-avatar.tiny{width:24px;height:24px;font-size:8px;border:1px solid #fff;margin-right:-4px}.person-avatar.large{width:82px;height:82px;font-size:20px}
    .task-assignees{border:0;background:transparent;display:flex;align-items:center;padding:0;min-width:0;color:#777}.task-assignees small{margin-left:6px;color:#777}
    .people-info>strong,.people-info>.muted{display:block}.people-projects{display:flex;gap:5px;flex-wrap:wrap;margin-top:6px}
    .mini-badge{display:inline-block;background:#eee;border-radius:20px;padding:3px 8px;font-size:10px;color:#666}
    .people-count{text-align:center;color:#777;font-size:11px}.people-count strong{display:block;color:#222;font-size:15px}.people-actions{display:flex}
    .empty-phase3{padding:20px 4px}.person-photo-preview{text-align:center;margin-bottom:14px}.person-photo-preview .person-avatar{margin:auto}
    .project-member-add{display:grid;grid-template-columns:1fr 1fr auto;gap:8px;align-items:end}.project-member-add .field{margin-bottom:0}
    .project-person-row{display:grid;grid-template-columns:34px minmax(0,1fr) 24px;gap:10px;align-items:center;padding:11px 2px;border-bottom:1px solid #ececec}
    .assignee-list{margin-top:15px;max-height:330px;overflow:auto}.assignee-option{display:grid!important;grid-template-columns:22px 34px minmax(0,1fr);gap:9px;align-items:center;padding:10px 2px;border-bottom:1px solid #eee;margin:0!important}
    .assignee-option strong,.assignee-option small{display:block}.assignee-option small{color:#777;margin-top:2px}
    .sidebar-team{margin-top:18px;padding-top:17px;border-top:1px solid #ddd}.sidebar-avatars{display:flex;margin:10px 0}.sidebar-avatars .person-avatar{margin-right:-5px;border:2px solid #fafafa}.team-button{margin-top:8px}
    .schedule-toolbar{display:flex;align-items:center;gap:8px;margin:4px 0 20px}.schedule-toolbar strong{min-width:145px;text-align:center}.schedule-toolbar select{margin-left:auto;border:1px solid #bbb;border-radius:5px;padding:8px 9px;background:#fff}
    .calendar{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:1px;background:#ddd;border:1px solid #ddd}
    .calendar-weekday{background:#fafafa;padding:8px 5px;text-align:center;font-size:10px;color:#777;font-weight:800;text-transform:uppercase;letter-spacing:.05em}
    .calendar-day{background:#fff;min-height:105px;padding:7px}.calendar-day.outside{background:#fafafa;color:#aaa}.calendar-day.today{box-shadow:inset 0 0 0 2px #2f7d32}
    .calendar-date{font-size:11px;font-weight:800;margin-bottom:5px}.calendar-item{display:block;width:100%;border:0;background:#e9f3e8;color:#315d35;border-radius:3px;padding:4px 5px;margin:3px 0;text-align:left;font-size:10px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .calendar-item.calendar-task{background:#f2eee4;color:#6b582f}.calendar-more{font-size:9px;color:#888;margin-top:3px}
    .schedule-row{display:grid;grid-template-columns:48px minmax(0,1fr) auto;gap:12px;align-items:center;padding:12px 4px;border-bottom:1px solid #ececec}
    .schedule-date{text-align:center}.schedule-date strong,.schedule-date span{display:block}.schedule-date strong{font-size:17px}.schedule-date span{font-size:9px;color:#777;text-transform:uppercase}
    .schedule-info strong,.schedule-info span{display:block}.checkbox-field label{display:flex!important;align-items:center;gap:8px}.checkbox-field input{width:auto!important}.danger-btn{color:#b42318}.modal textarea{width:100%;border:1px solid #bbb;border-radius:5px;padding:10px 11px;font:inherit;min-height:80px}
    .import-preview{max-height:300px;overflow:auto}.import-group{margin:14px 0}.import-task{padding:4px 8px;color:#555}
    @media(max-width:800px){.people-row{grid-template-columns:42px minmax(0,1fr) 44px}.people-count{display:none}.project-member-add{grid-template-columns:1fr}.calendar{grid-template-columns:repeat(7,minmax(100px,1fr));overflow:auto}.schedule-toolbar{flex-wrap:wrap}.schedule-toolbar select{margin-left:0}}


    /* Phase 3 final: Basecamp-style categories + complete task form */
    .category-section{margin-top:28px}
    .category-heading{display:flex;align-items:center;justify-content:space-between;border-bottom:2px solid #222;padding-bottom:8px}
    .category-name{font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:.055em}
    .category-actions{display:flex;align-items:center;gap:3px}
    .category-empty{padding:12px 4px 4px}
    .category-add-task{border:0;background:transparent;color:#557b56;font-size:12px;font-weight:700;padding:10px 4px 3px}
    .category-add-task:hover{text-decoration:underline}
    .category-footer-actions{margin-top:28px}
    .category-new{width:auto;padding:9px 15px}
    .priority{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.03em;border-radius:12px;padding:3px 6px;text-align:center;white-space:nowrap}
    .priority-low{background:#f1f1ef;color:#777}
    .priority-normal{background:#edf3e9;color:#55734f}
    .priority-high{background:#fff0d9;color:#9a641a}
    .priority-urgent{background:#fce8e6;color:#a6382d}
    .task-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .task-modal-assignees{border:1px solid #ddd;border-radius:5px;max-height:220px;overflow:auto}
    .task-person-option{display:grid!important;grid-template-columns:22px 34px minmax(0,1fr);align-items:center;gap:9px;padding:9px 10px;margin:0!important;border-bottom:1px solid #eee;cursor:pointer}
    .task-person-option:last-child{border-bottom:0}
    .task-person-option input{width:auto!important}
    .task-person-option strong,.task-person-option small{display:block}
    .task-person-option small{font-size:10px;color:#777;margin-top:2px}
    .task-no-people{padding:12px}
    .inline-link{border:0;background:transparent;color:#2f7d32;text-decoration:underline;padding:0;font:inherit}
    @media(max-width:800px){
      .todo{grid-template-columns:28px 1fr 24px}
      .todo .task-assignees,.todo .priority,.todo>.meta{display:none}
      .task-form-grid{grid-template-columns:1fr}
    }

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
      <a href="#" @click.prevent="screen='projects'" :class="{active:screen==='projects'}">Projects</a>
      <a href="#" @click.prevent="screen='mytasks'" :class="{active:screen==='mytasks'}">My Tasks</a>
      <a href="#" @click.prevent="openSchedule()" :class="{active:screen==='schedule'}">Schedule</a>
      <a href="#" @click.prevent="openPeople()" :class="{active:screen==='people'}">People</a>
      <a href="#" @click.prevent="screen='activity'" :class="{active:screen==='activity'}">Activity</a>
      <a href="#" @click.prevent="importModal=true">Import</a>
    </nav>

    <div class="user-menu">
      <span>Project Manager</span>
      <span class="avatar">PM</span>
    </div>
  </header>

  <nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="#" @click.prevent="screen='projects'">Home</a>
    <span class="sep">›</span>
    <template x-if="screen==='projects'">
      <span style="display:flex;align-items:center;gap:7px">
        <a href="#" @click.prevent="screen='projects'">Projects</a>
        <span class="sep">›</span>
        <strong x-text="currentProject.name"></strong>
        <span class="sep">›</span>
        <span>To-dos</span>
      </span>
    </template>
    <template x-if="screen!=='projects'">
      <strong x-text="screenTitle"></strong>
    </template>
  </nav>
  <main class="main">

    <!-- ============================================================
         PROJECTS — Phase 1 Basecamp layout, extended (not redesigned)
         ============================================================ -->
    <section x-show="screen==='projects'">
      <div class="top">
        <div>
          <h1 x-text="currentProject.name"></h1>
          <div class="muted">
            Project to-dos · <span x-text="activeTodos.length"></span> remaining
          </div>
        </div>
        <span class="badge" x-text="completedTodos.length + ' completed'"></span>
      </div>

      <!-- Quick add keeps the original Phase 1 behavior -->
      <div class="add-row">
        <input x-model="newTodo"
               @keyup.enter="addTodo()"
               placeholder="Quick add an uncategorized to-do…">
        <button class="add" @click="addTodo()">Add to-do</button>
      </div>

      <!-- Categories are Basecamp-style section headings, not cards -->
      <template x-for="category in displayCategories" :key="category.key">
        <section class="category-section">

          <div class="category-heading">
            <div class="category-name" x-text="category.name"></div>

            <div class="category-actions" x-show="category.id">
              <button type="button"
                      class="icon-btn"
                      @click="openCategoryModal(category)"
                      title="Edit category">✎</button>

              <button type="button"
                      class="icon-btn"
                      @click="deleteCategory(category)"
                      title="Delete category">×</button>
            </div>
          </div>

          <template x-for="todo in tasksForCategory(category.id)" :key="todo.id">
            <div class="todo category-todo" :class="{completed:isCompleted(todo)}">

              <input type="checkbox"
                     :checked="isCompleted(todo)"
                     @change="toggle(todo)">

              <button type="button"
                      class="title task-title-btn"
                      x-text="todo.body"
                      @click="openTaskModal(todo)"
                      title="Edit task"></button>

              <!-- Assignee avatar stack -->
              <button type="button"
                      class="task-assignees"
                      @click="openAssigneeModal(todo)"
                      title="Assign people">

                <template x-for="person in taskPeople(todo.id).slice(0,2)" :key="person.id">
                  <span class="person-avatar tiny" :title="person.name">
                    <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
                    <span x-show="!person.photo" x-text="initials(person.name)"></span>
                  </span>
                </template>

                <span x-show="taskPeople(todo.id).length===0"
                      class="meta"
                      x-text="todo.assignee || 'Unassigned'"></span>

                <small x-show="taskPeople(todo.id).length>2"
                       x-text="'+'+(taskPeople(todo.id).length-2)"></small>
              </button>

              <span class="priority"
                    :class="'priority-'+(todo.priority || 'normal')"
                    x-text="priorityLabel(todo.priority)"></span>

              <div class="meta" x-text="formatDate(todo.due_date)"></div>

              <button class="delete"
                      @click="remove(todo)"
                      title="Delete">×</button>
            </div>
          </template>

          <div x-show="tasksForCategory(category.id).length===0"
               class="muted category-empty">
            No tasks in this category.
          </div>

          <button type="button"
                  class="category-add-task"
                  @click="openTaskModal(null, category.id)">
            + Add task
          </button>
        </section>
      </template>

      <div class="category-footer-actions">
        <button type="button" class="new-project category-new" @click="openCategoryModal()">
          + Add category
        </button>
      </div>

      <div x-show="projectTodos.length===0 && categoriesForProject.length===0"
           class="muted"
           style="padding:18px 4px">
        No tasks yet. Add a category or create your first to-do.
      </div>
    </section>

    <!-- ============================================================
         PEOPLE — Phase 2B, using the same restrained Basecamp styling
         ============================================================ -->
    <section x-show="screen==='people'">
      <div class="top">
        <div>
          <h1>People</h1>
          <div class="muted">People working across your projects.</div>
        </div>
        <button class="add phase3-action" @click="openPersonModal()">+ Add person</button>
      </div>

      <div class="section-title">Team</div>

      <template x-for="person in teamMembers" :key="person.id">
        <div class="people-row">
          <div class="person-avatar">
            <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
            <span x-show="!person.photo" x-text="initials(person.name)"></span>
          </div>

          <div class="people-info">
            <strong x-text="person.name"></strong>
            <span class="muted" x-text="person.job_title || 'Team member'"></span>
            <div class="people-projects">
              <template x-for="p in (person.projects || [])" :key="p.id">
                <span class="mini-badge" x-text="p.name"></span>
              </template>
            </div>
          </div>

          <div class="people-count">
            <strong x-text="person.active_task_count || 0"></strong>
            <span>open tasks</span>
          </div>

          <div class="people-actions">
            <button class="icon-btn" @click="openPersonModal(person)" title="Edit person">✎</button>
            <button class="icon-btn" @click="deletePerson(person)" title="Delete person">×</button>
          </div>
        </div>
      </template>

      <div x-show="teamMembers.length===0" class="muted empty-phase3">
        No team members yet. Click “+ Add person”.
      </div>
    </section>

    <!-- ============================================================
         SCHEDULE — Phase 3
         ============================================================ -->
    <section x-show="screen==='schedule'">
      <div class="top">
        <div>
          <h1>Schedule</h1>
          <div class="muted">Task deadlines, meetings, milestones, releases and reminders.</div>
        </div>
        <button class="add phase3-action" @click="openEventModal()">+ Add event</button>
      </div>

      <div class="schedule-toolbar">
        <button class="btn" @click="changeScheduleMonth(-1)">‹</button>
        <strong x-text="scheduleMonthLabel"></strong>
        <button class="btn" @click="changeScheduleMonth(1)">›</button>
        <button class="btn" @click="scheduleToday()">Today</button>

        <select x-model="scheduleProjectId" @change="loadSchedule()">
          <option value="">All projects</option>
          <template x-for="project in projects" :key="project.id">
            <option :value="project.id" x-text="project.name"></option>
          </template>
        </select>
      </div>

      <div class="calendar">
        <template x-for="dayName in ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']" :key="dayName">
          <div class="calendar-weekday" x-text="dayName"></div>
        </template>

        <template x-for="day in calendarDays" :key="day.key">
          <div class="calendar-day" :class="{outside:!day.current,today:day.today}">
            <div class="calendar-date" x-text="day.date.getDate()"></div>

            <template x-for="item in day.items.slice(0,4)" :key="item.kind+'-'+item.id">
              <button type="button"
                      class="calendar-item"
                      :class="{'calendar-task':item.kind==='task'}"
                      @click="item.kind==='event' ? openEventModal(item) : openTaskModal(item)">
                <span x-text="item.title"></span>
              </button>
            </template>

            <div class="calendar-more" x-show="day.items.length>4"
                 x-text="'+'+(day.items.length-4)+' more'"></div>
          </div>
        </template>
      </div>

      <div class="completed-wrap">
        <div class="completed-head">
          <strong>Upcoming</strong>
        </div>

        <template x-for="item in upcomingItems" :key="item.kind+'-'+item.id">
          <div class="schedule-row">
            <div class="schedule-date">
              <strong x-text="scheduleDay(item.date)"></strong>
              <span x-text="scheduleMonthShort(item.date)"></span>
            </div>
            <div class="schedule-info">
              <strong x-text="item.title"></strong>
              <span class="muted" x-text="item.project_name || 'General'"></span>
            </div>
            <span class="mini-badge" x-text="item.kind==='task' ? 'Task due' : item.event_type"></span>
          </div>
        </template>

        <div x-show="upcomingItems.length===0" class="muted empty-phase3">Nothing upcoming.</div>
      </div>
    </section>

    <!-- My Tasks placeholder keeps the Phase 1 shell; deeper implementation can follow -->
    <section x-show="screen==='mytasks'">
      <div class="top">
        <div><h1>My Tasks</h1><div class="muted">Tasks assigned to team members.</div></div>
      </div>
      <div class="section-title">Assigned tasks</div>
      <template x-for="todo in myVisibleTasks" :key="todo.id">
        <div class="todo" :class="{completed:isCompleted(todo)}">
          <input type="checkbox" :checked="isCompleted(todo)" @change="toggle(todo)">
          <button type="button" class="title task-title-btn" x-text="todo.body" @click="openTaskModal(todo)"></button>
          <div class="meta" x-text="taskPeople(todo.id).map(p=>p.name).join(', ') || todo.assignee || 'Unassigned'"></div>
          <div class="meta" x-text="formatDate(todo.due_date)"></div>
          <button class="delete" @click="remove(todo)">×</button>
        </div>
      </template>
    </section>

    <section x-show="screen==='activity'">
      <div class="top">
        <div><h1>Activity</h1><div class="muted">Project activity feed will be expanded in Phase 4.</div></div>
      </div>
      <div class="section-title">Recent activity</div>
      <div class="muted empty-phase3">Activity logging foundation is ready for the next phase.</div>
    </section>

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

      <template x-if="currentProjectId">
        <div class="sidebar-team">
          <strong>Project team</strong>
          <div class="sidebar-avatars">
            <template x-for="person in projectPeople.slice(0,6)" :key="person.id">
              <span class="person-avatar small" :title="person.name">
                <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
                <span x-show="!person.photo" x-text="initials(person.name)"></span>
              </span>
            </template>
          </div>
          <button class="new-project team-button" @click="openProjectPeople()">Manage people</button>
        </div>
      </template>
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

  <!-- Full Phase 3 task create/update modal -->
  <div class="modal-backdrop"
       x-show="taskModal"
       x-transition
       @click.self="closeTaskModal()"
       x-cloak>
    <div class="modal">
      <h3 x-text="taskForm.id ? 'Edit task' : 'New task'"></h3>

      <div class="error-box" x-show="formError" x-text="formError"></div>

      <div class="field">
        <label>Task</label>
        <input type="text"
               x-model="taskForm.body"
               @keyup.enter="saveTask()"
               placeholder="What needs to be done?">
      </div>

      <div class="field">
        <label>Category</label>
        <select x-model="taskForm.category_id">
          <option value="">Uncategorized</option>
          <template x-for="category in categoriesForProject" :key="category.id">
            <option :value="category.id" x-text="category.name"></option>
          </template>
        </select>
      </div>

      <div class="field">
        <label>Assignees</label>

        <div class="task-modal-assignees">
          <template x-for="person in projectPeople" :key="person.id">
            <label class="task-person-option">
              <input type="checkbox"
                     :checked="selectedTaskAssigneeIds.includes(Number(person.id))"
                     @change="toggleTaskFormAssignee(person.id)">

              <span class="person-avatar small">
                <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
                <span x-show="!person.photo" x-text="initials(person.name)"></span>
              </span>

              <span>
                <strong x-text="person.name"></strong>
                <small x-text="person.job_title || person.role || 'Team member'"></small>
              </span>
            </label>
          </template>

          <div x-show="projectPeople.length===0" class="muted task-no-people">
            No people have been added to this project yet.
            <button type="button" class="inline-link" @click="taskModal=false; openProjectPeople()">
              Add project people
            </button>
          </div>
        </div>
      </div>

      <div class="task-form-grid">
        <div class="field">
          <label>Priority</label>
          <select x-model="taskForm.priority">
            <option value="low">Low</option>
            <option value="normal">Normal</option>
            <option value="high">High</option>
            <option value="urgent">Urgent</option>
          </select>
        </div>

        <div class="field">
          <label>Due date</label>
          <input type="date" x-model="taskForm.due_date">
        </div>
      </div>

      <div class="field checkbox-field" x-show="taskForm.id">
        <label>
          <input type="checkbox" x-model="taskForm.completed">
          Completed
        </label>
      </div>

      <div class="modal-actions">
        <button class="btn" @click="closeTaskModal()">Cancel</button>
        <button class="btn btn-primary"
                @click="saveTask()"
                :disabled="saving"
                x-text="saving ? 'Saving…' : 'Save task'"></button>
      </div>
    </div>
  </div>

  <!-- Category create/update modal -->
  <div class="modal-backdrop"
       x-show="categoryModal"
       x-transition
       @click.self="closeCategoryModal()"
       x-cloak>
    <div class="modal">
      <h3 x-text="categoryForm.id ? 'Edit category' : 'New category'"></h3>

      <div class="error-box" x-show="categoryError" x-text="categoryError"></div>

      <div class="field">
        <label>Category name</label>
        <input type="text"
               x-model="categoryForm.name"
               @keyup.enter="saveCategory()"
               placeholder="e.g. Design, Backend, Tweakings">
      </div>

      <div class="field">
        <label>Sort order</label>
        <input type="number" min="0" x-model.number="categoryForm.sort_order">
      </div>

      <div class="modal-actions">
        <button class="btn" @click="closeCategoryModal()">Cancel</button>
        <button class="btn btn-primary"
                @click="saveCategory()"
                :disabled="saving"
                x-text="saving ? 'Saving…' : 'Save category'"></button>
      </div>
    </div>
  </div>

  <!-- Add / Edit person -->
  <div class="modal-backdrop" x-show="personModal" x-transition @click.self="closePersonModal()" x-cloak>
    <div class="modal">
      <h3 x-text="personForm.id ? 'Edit person' : 'Add person'"></h3>
      <div class="error-box" x-show="teamError" x-text="teamError"></div>

      <div class="person-photo-preview">
        <div class="person-avatar large">
          <img x-show="personPhotoPreview" :src="personPhotoPreview" alt="">
          <span x-show="!personPhotoPreview" x-text="initials(personForm.name || 'New Person')"></span>
        </div>
      </div>

      <div class="field"><label>Photo</label><input type="file" accept="image/jpeg,image/png,image/webp" @change="selectPersonPhoto($event)"></div>
      <div class="field"><label>Name</label><input type="text" x-model="personForm.name" placeholder="Full name"></div>
      <div class="field"><label>Email</label><input type="email" x-model="personForm.email" placeholder="Email"></div>
      <div class="field"><label>Job title</label><input type="text" x-model="personForm.job_title" placeholder="e.g. UI/UX Designer"></div>
      <div class="field"><label>Phone</label><input type="text" x-model="personForm.phone" placeholder="Phone"></div>
      <div class="field"><label>Status</label><select x-model="personForm.status"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>

      <div class="modal-actions">
        <button class="btn" @click="closePersonModal()">Cancel</button>
        <button class="btn btn-primary" @click="savePerson()">Save person</button>
      </div>
    </div>
  </div>

  <!-- Manage project people -->
  <div class="modal-backdrop" x-show="projectPeopleModal" x-transition @click.self="projectPeopleModal=false" x-cloak>
    <div class="modal">
      <h3>Project people</h3>
      <div class="muted" x-text="currentProject.name"></div>

      <div class="project-member-add">
        <div class="field">
          <label>Person</label>
          <select x-model="projectMemberForm.team_member_id">
            <option value="">Select person…</option>
            <template x-for="person in availableProjectPeople" :key="person.id">
              <option :value="person.id" x-text="person.name"></option>
            </template>
          </select>
        </div>
        <div class="field"><label>Role</label><input x-model="projectMemberForm.role" placeholder="Project role"></div>
        <button class="btn btn-primary" @click="addPersonToProject()">Add</button>
      </div>

      <div class="section-title">Current team</div>
      <template x-for="person in projectPeople" :key="person.id">
        <div class="project-person-row">
          <div class="person-avatar small">
            <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
            <span x-show="!person.photo" x-text="initials(person.name)"></span>
          </div>
          <div>
            <strong x-text="person.name"></strong>
            <div class="muted" x-text="person.role || person.job_title || 'Team member'"></div>
          </div>
          <button class="delete" @click="removePersonFromProject(person)">×</button>
        </div>
      </template>

      <div class="modal-actions"><button class="btn" @click="projectPeopleModal=false">Close</button></div>
    </div>
  </div>

  <!-- Multi-person task assignment -->
  <div class="modal-backdrop" x-show="assigneeModal" x-transition @click.self="closeAssigneeModal()" x-cloak>
    <div class="modal">
      <h3>Assign people</h3>
      <div class="muted" x-text="assignmentTask?.body"></div>

      <div class="assignee-list">
        <template x-for="person in projectPeople" :key="person.id">
          <label class="assignee-option">
            <input type="checkbox"
                   :checked="selectedAssigneeIds.includes(Number(person.id))"
                   @change="toggleAssigneeSelection(person.id)">
            <span class="person-avatar small">
              <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
              <span x-show="!person.photo" x-text="initials(person.name)"></span>
            </span>
            <span>
              <strong x-text="person.name"></strong>
              <small x-text="person.job_title || 'Team member'"></small>
            </span>
          </label>
        </template>
      </div>

      <div class="modal-actions">
        <button class="btn" @click="closeAssigneeModal()">Cancel</button>
        <button class="btn btn-primary" @click="saveTaskAssignees()">Save assignments</button>
      </div>
    </div>
  </div>

  <!-- Schedule event -->
  <div class="modal-backdrop" x-show="eventModal" x-transition @click.self="eventModal=false" x-cloak>
    <div class="modal">
      <h3 x-text="eventForm.id ? 'Edit schedule item' : 'Add schedule item'"></h3>
      <div class="field"><label>Title</label><input x-model="eventForm.title"></div>
      <div class="field"><label>Project</label><select x-model="eventForm.project_id"><option value="">General / no project</option><template x-for="project in projects" :key="project.id"><option :value="project.id" x-text="project.name"></option></template></select></div>
      <div class="field"><label>Type</label><select x-model="eventForm.event_type"><option value="meeting">Meeting</option><option value="milestone">Milestone</option><option value="release">Release</option><option value="reminder">Reminder</option><option value="event">Event</option></select></div>
      <div class="field"><label>Starts</label><input type="datetime-local" x-model="eventForm.start_at"></div>
      <div class="field"><label>Ends</label><input type="datetime-local" x-model="eventForm.end_at"></div>
      <div class="field"><label>Location</label><input x-model="eventForm.location"></div>
      <div class="field"><label>Description</label><textarea x-model="eventForm.description"></textarea></div>
      <div class="field checkbox-field"><label><input type="checkbox" x-model="eventForm.all_day"> All day</label></div>
      <div class="modal-actions">
        <button class="btn danger-btn" x-show="eventForm.id" @click="deleteEvent()">Delete</button>
        <span style="flex:1"></span>
        <button class="btn" @click="eventModal=false">Cancel</button>
        <button class="btn btn-primary" @click="saveEvent()">Save event</button>
      </div>
    </div>
  </div>

  <!-- Markdown Import -->
  <div class="modal-backdrop" x-show="importModal" x-transition @click.self="importModal=false" x-cloak>
    <div class="modal">
      <h3>Import Markdown tasks</h3>
      <div class="field"><label>Markdown file</label><input type="file" accept=".md,.markdown,text/markdown,text/plain" @change="readImport($event)"></div>
      <div class="import-preview">
        <template x-for="(tasks,category) in importGroups" :key="category">
          <div class="import-group">
            <strong x-text="category"></strong>
            <template x-for="task in tasks" :key="task.body">
              <div class="import-task"><span x-text="task.completed ? '☑' : '☐'"></span> <span x-text="task.body"></span></div>
            </template>
          </div>
        </template>
      </div>
      <div class="modal-actions">
        <button class="btn" @click="importModal=false">Cancel</button>
        <button class="btn btn-primary" @click="importTasks()" :disabled="!importPreview.length">Import tasks</button>
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
    screen: 'projects',
    currentProjectId: cached?.currentProjectId ? Number(cached.currentProjectId) : null,
    projects: cached?.projects || [],
    todos: cached?.todos || [],
    categories: [],
    teamMembers: [],
    projectPeople: [],
    taskAssignments: {},
    scheduleEvents: [],
    scheduleTasks: [],
    scheduleCursor: new Date(),
    scheduleProjectId: '',
    newTodo: '',
    loading: false,
    saving: false,
    projectModal: false,
    taskModal: false,
    categoryModal: false,
    personModal: false,
    projectPeopleModal: false,
    assigneeModal: false,
    eventModal: false,
    importModal: false,
    formError: '',
    categoryError: '',
    teamError: '',
    personPhoto: null,
    personPhotoPreview: '',
    selectedTaskAssigneeIds: [],
    personForm: {id:null,name:'',email:'',job_title:'',phone:'',status:'active',photo:''},
    projectMemberForm: {team_member_id:'',role:''},
    assignmentTask: null,
    selectedAssigneeIds: [],
    eventForm: {id:null,project_id:'',title:'',description:'',event_type:'event',start_at:'',end_at:'',all_day:false,location:''},
    importPreview: [],
    projectForm: {id:null,name:'',color:''},
    taskForm: {
      id:null,
      body:'',
      category_id:'',
      assignee:'',
      due_date:'',
      priority:'normal',
      completed:false
    },
    categoryForm: {id:null,name:'',sort_order:0},

    async init(){
      await this.loadData();
      await Promise.all([this.loadProjectPeople(),this.loadProjectAssignments()]);
    },

    get currentProject(){ return this.projects.find(p=>Number(p.id)===Number(this.currentProjectId)) || this.projects[0] || {name:'Projects'}; },
    get projectTodos(){ return this.todos.filter(t=>Number(t.project_id)===Number(this.currentProjectId)); },
    get activeTodos(){ return this.projectTodos.filter(t=>!this.isCompleted(t)); },
    get completedTodos(){ return this.projectTodos.filter(t=>this.isCompleted(t)); },
    get categoriesForProject(){
      return this.categories
        .filter(c=>Number(c.project_id)===Number(this.currentProjectId))
        .sort((a,b)=>(Number(a.sort_order)||0)-(Number(b.sort_order)||0) || String(a.name).localeCompare(String(b.name)));
    },
    get displayCategories(){
      const list=this.categoriesForProject.map(c=>({...c,key:'category-'+c.id}));
      const hasUncategorized=this.projectTodos.some(t=>!t.category_id);
      if(hasUncategorized || list.length===0){
        list.push({id:null,name:'Uncategorized',sort_order:999999,key:'uncategorized'});
      }
      return list;
    },
    get screenTitle(){
      return {mytasks:'My Tasks',schedule:'Schedule',people:'People',activity:'Activity'}[this.screen] || 'Projects';
    },
    get myVisibleTasks(){ return this.todos; },
    get availableProjectPeople(){
      const used=new Set(this.projectPeople.map(p=>Number(p.id)));
      return this.teamMembers.filter(p=>p.status==='active' && !used.has(Number(p.id)));
    },
    get scheduleMonthLabel(){
      return this.scheduleCursor.toLocaleDateString(undefined,{month:'long',year:'numeric'});
    },
    get calendarDays(){
      const year=this.scheduleCursor.getFullYear(), month=this.scheduleCursor.getMonth();
      const first=new Date(year,month,1), offset=(first.getDay()+6)%7;
      const start=new Date(year,month,1-offset), days=[];
      for(let i=0;i<42;i++){
        const date=new Date(start); date.setDate(start.getDate()+i);
        const key=this.isoDate(date), items=[];
        this.scheduleEvents.filter(e=>String(e.start_at||'').slice(0,10)===key)
          .forEach(e=>items.push({...e,kind:'event',date:key}));
        this.scheduleTasks.filter(t=>String(t.due_date||'').slice(0,10)===key)
          .forEach(t=>items.push({...t,kind:'task',title:t.body,date:key}));
        days.push({key,date,current:date.getMonth()===month,today:key===this.isoDate(new Date()),items});
      }
      return days;
    },
    get upcomingItems(){
      const today=this.isoDate(new Date()), items=[];
      this.scheduleEvents.forEach(e=>items.push({...e,kind:'event',date:String(e.start_at||'').slice(0,10)}));
      this.scheduleTasks.forEach(t=>items.push({...t,kind:'task',title:t.body,date:String(t.due_date||'').slice(0,10)}));
      return items.filter(x=>x.date && x.date>=today).sort((a,b)=>a.date.localeCompare(b.date)).slice(0,12);
    },
    get importGroups(){
      return this.importPreview.reduce((out,t)=>{(out[t.category]??=[]).push(t);return out;},{});
    },

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
        this.categories=(data.categories||[]).map(c=>({
          ...c,
          id:Number(c.id),
          project_id:Number(c.project_id),
          sort_order:Number(c.sort_order||0)
        }));
        this.todos=(data.tasks||[]).map(t=>({
          ...t,
          id:Number(t.id),
          project_id:Number(t.project_id),
          category_id:t.category_id ? Number(t.category_id) : null,
          priority:t.priority||'normal',
          completed:this.isCompleted(t)
        }));
        const exists=this.projects.some(p=>Number(p.id)===Number(this.currentProjectId));
        if((!this.currentProjectId || !exists) && this.projects.length) this.currentProjectId=this.projects[0].id;
        this.saveCache();
      }catch(e){ console.error(e); }
      finally{ this.loading=false; }
    },

    selectProject(project){
      this.currentProjectId=Number(project.id);
      this.saveCache();
      this.loadProjectPeople();
      this.loadProjectAssignments();
    },
    saveCache(){ localStorage.setItem('basecamp-task-manager',JSON.stringify({projects:this.projects,todos:this.todos,currentProjectId:this.currentProjectId})); },

    tasksForCategory(categoryId){
      return this.projectTodos.filter(t=>{
        const sameCategory=categoryId===null
          ? !t.category_id
          : Number(t.category_id)===Number(categoryId);
        return sameCategory;
      });
    },

    priorityLabel(priority){
      const value=String(priority||'normal').toLowerCase();
      return {low:'Low',normal:'Normal',high:'High',urgent:'Urgent'}[value] || 'Normal';
    },

    async addTodo(){
      const body=this.newTodo.trim();
      if(!body || !this.currentProjectId)return;

      this.saving=true;
      try{
        const data=await this.request('<?= site_url('task-manager/tasks') ?>',{
          method:'POST',
          body:JSON.stringify({
            project_id:this.currentProjectId,
            category_id:null,
            body,
            priority:'normal'
          })
        });

        this.todos.unshift(this.normalizeTask(data.task));
        this.newTodo='';
        this.saveCache();
      }catch(e){
        alert(e.message);
      }finally{
        this.saving=false;
      }
    },

    async openTaskModal(todo=null, categoryId=null){
      this.formError='';

      // Project members are the allowed assignees.
      await this.loadProjectPeople();
      await this.loadProjectAssignments();

      if(todo){
        this.taskForm={
          id:todo.id,
          body:todo.body||'',
          category_id:todo.category_id ? Number(todo.category_id) : '',
          assignee:todo.assignee||'',
          due_date:todo.due_date||'',
          priority:todo.priority||'normal',
          completed:this.isCompleted(todo)
        };
        this.selectedTaskAssigneeIds=this.taskPeople(todo.id).map(p=>Number(p.id));
      }else{
        this.taskForm={
          id:null,
          body:'',
          category_id:categoryId ? Number(categoryId) : '',
          assignee:'',
          due_date:'',
          priority:'normal',
          completed:false
        };
        this.selectedTaskAssigneeIds=[];
      }

      this.taskModal=true;
    },

    closeTaskModal(){
      this.taskModal=false;
      this.selectedTaskAssigneeIds=[];
    },

    toggleTaskFormAssignee(id){
      id=Number(id);
      this.selectedTaskAssigneeIds=this.selectedTaskAssigneeIds.includes(id)
        ? this.selectedTaskAssigneeIds.filter(v=>v!==id)
        : [...this.selectedTaskAssigneeIds,id];
    },

    async saveTask(){
      if(!this.taskForm.body.trim()){
        this.formError='Task description is required.';
        return;
      }

      this.saving=true;
      this.formError='';

      try{
        const editing=!!this.taskForm.id;
        const url=editing
          ? '<?= site_url('task-manager/tasks') ?>/'+this.taskForm.id
          : '<?= site_url('task-manager/tasks') ?>';

        const payload={
          project_id:this.currentProjectId,
          category_id:this.taskForm.category_id || null,
          body:this.taskForm.body.trim(),
          due_date:this.taskForm.due_date || null,
          priority:this.taskForm.priority || 'normal',
          completed:this.taskForm.completed ? 1 : 0
        };

        const data=await this.request(url,{
          method:editing?'PUT':'POST',
          body:JSON.stringify(payload)
        });

        const task=this.normalizeTask(data.task);

        if(editing){
          this.todos=this.todos.map(t=>Number(t.id)===Number(task.id)?task:t);
        }else{
          this.todos.unshift(task);
        }

        // Save multi-person assignments after the task exists.
        const assignmentData=await this.request(
          '<?= site_url('task-manager/tasks') ?>/'+task.id+'/assignees',
          {
            method:'PUT',
            body:JSON.stringify({team_member_ids:this.selectedTaskAssigneeIds})
          }
        );

        this.taskAssignments={
          ...this.taskAssignments,
          [task.id]:assignmentData.members||[]
        };

        this.taskModal=false;
        this.selectedTaskAssigneeIds=[];
        this.saveCache();

      }catch(e){
        this.formError=e.message;
      }finally{
        this.saving=false;
      }
    },

    // --------------------------------------------------------------
    // CATEGORY CRUD
    // --------------------------------------------------------------
    openCategoryModal(category=null){
      this.categoryError='';
      this.categoryForm=category
        ? {id:category.id,name:category.name||'',sort_order:Number(category.sort_order||0)}
        : {id:null,name:'',sort_order:this.categoriesForProject.length};
      this.categoryModal=true;
    },

    closeCategoryModal(){
      this.categoryModal=false;
      this.categoryError='';
    },

    async saveCategory(){
      if(!this.categoryForm.name.trim()){
        this.categoryError='Category name is required.';
        return;
      }

      this.saving=true;
      this.categoryError='';

      try{
        const editing=!!this.categoryForm.id;
        const url=editing
          ? '<?= site_url('task-manager/categories') ?>/'+this.categoryForm.id
          : '<?= site_url('task-manager/categories') ?>';

        const data=await this.request(url,{
          method:editing?'PUT':'POST',
          body:JSON.stringify({
            project_id:this.currentProjectId,
            name:this.categoryForm.name.trim(),
            sort_order:Number(this.categoryForm.sort_order||0)
          })
        });

        const category={
          ...data.category,
          id:Number(data.category.id),
          project_id:Number(data.category.project_id),
          sort_order:Number(data.category.sort_order||0)
        };

        if(editing){
          this.categories=this.categories.map(c=>Number(c.id)===category.id?category:c);
        }else{
          this.categories.push(category);
        }

        this.closeCategoryModal();

      }catch(e){
        this.categoryError=e.message;
      }finally{
        this.saving=false;
      }
    },

    async deleteCategory(category){
      if(!category?.id)return;

      if(!confirm(`Delete category "${category.name}"? Its tasks will move to Uncategorized.`)){
        return;
      }

      try{
        await this.request('<?= site_url('task-manager/categories') ?>/'+category.id,{
          method:'DELETE'
        });

        this.categories=this.categories.filter(c=>Number(c.id)!==Number(category.id));

        // Database FK uses ON DELETE SET NULL; mirror that immediately in UI.
        this.todos=this.todos.map(t=>
          Number(t.category_id)===Number(category.id)
            ? {...t,category_id:null}
            : t
        );

        this.saveCache();

      }catch(e){
        alert(e.message);
      }
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


    // --------------------------------------------------------------
    // PEOPLE / TEAM
    // --------------------------------------------------------------
    async loadTeam(){
      try{
        const data=await this.request('<?= site_url('task-manager/team') ?>');
        this.teamMembers=data.members||[];
      }catch(e){console.error(e);}
    },

    async openPeople(){
      this.screen='people';
      await this.loadTeam();
    },

    initials(name){
      return String(name||'?').trim().split(/\s+/).slice(0,2).map(v=>v.charAt(0)).join('').toUpperCase();
    },

    photoUrl(path){
      if(!path)return '';
      return '<?= rtrim(base_url(), '/') ?>/' + String(path).replace(/^\/+/,'');
    },

    openPersonModal(person=null){
      this.teamError='';
      this.personPhoto=null;
      this.personForm=person
        ? {id:person.id,name:person.name||'',email:person.email||'',job_title:person.job_title||'',phone:person.phone||'',status:person.status||'active',photo:person.photo||''}
        : {id:null,name:'',email:'',job_title:'',phone:'',status:'active',photo:''};
      this.personPhotoPreview=person?.photo ? this.photoUrl(person.photo) : '';
      this.personModal=true;
    },

    closePersonModal(){
      this.personModal=false; this.personPhoto=null; this.personPhotoPreview='';
    },

    selectPersonPhoto(event){
      const file=event.target.files?.[0]; if(!file)return;
      this.personPhoto=file;
      this.personPhotoPreview=URL.createObjectURL(file);
    },

    async savePerson(){
      if(!this.personForm.name.trim()){this.teamError='Name is required.';return;}
      const fd=new FormData();
      ['name','email','job_title','phone','status'].forEach(k=>fd.append(k,this.personForm[k]||''));
      if(this.personPhoto)fd.append('photo',this.personPhoto);
      try{
        const url='<?= site_url('task-manager/team') ?>'+(this.personForm.id?'/'+this.personForm.id:'');
        const response=await fetch(url,{
          method:'POST',
          headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':csrfHash},
          body:fd
        });
        const data=await response.json();
        if(data.csrfHash)csrfHash=data.csrfHash;
        if(!response.ok||data.success===false)throw new Error(data.message||'Unable to save person.');
        this.closePersonModal();
        await this.loadTeam();
        await this.loadProjectPeople();
      }catch(e){this.teamError=e.message;}
    },

    async deletePerson(person){
      if(!confirm(`Delete "${person.name}"?`))return;
      try{
        await this.request('<?= site_url('task-manager/team') ?>/'+person.id,{method:'DELETE'});
        await Promise.all([this.loadTeam(),this.loadProjectPeople(),this.loadProjectAssignments()]);
      }catch(e){alert(e.message);}
    },

    async loadProjectPeople(){
      if(!this.currentProjectId){this.projectPeople=[];return;}
      try{
        const data=await this.request('<?= site_url('task-manager/projects') ?>/'+this.currentProjectId+'/members');
        this.projectPeople=data.members||[];
      }catch(e){console.error(e);}
    },

    async loadProjectAssignments(){
      if(!this.currentProjectId){this.taskAssignments={};return;}
      try{
        const data=await this.request('<?= site_url('task-manager/projects') ?>/'+this.currentProjectId+'/assignments');
        this.taskAssignments=data.assignments||{};
      }catch(e){console.error(e);}
    },

    taskPeople(taskId){
      return this.taskAssignments[taskId] || this.taskAssignments[String(taskId)] || [];
    },

    async openProjectPeople(){
      await Promise.all([this.loadTeam(),this.loadProjectPeople()]);
      this.projectMemberForm={team_member_id:'',role:''};
      this.projectPeopleModal=true;
    },

    async addPersonToProject(){
      if(!this.projectMemberForm.team_member_id)return;
      try{
        await this.request('<?= site_url('task-manager/projects') ?>/'+this.currentProjectId+'/members',{
          method:'POST',body:JSON.stringify(this.projectMemberForm)
        });
        this.projectMemberForm={team_member_id:'',role:''};
        await Promise.all([this.loadProjectPeople(),this.loadTeam()]);
      }catch(e){alert(e.message);}
    },

    async removePersonFromProject(person){
      if(!confirm(`Remove "${person.name}" from this project?`))return;
      try{
        await this.request('<?= site_url('task-manager/projects') ?>/'+this.currentProjectId+'/members/'+person.id,{method:'DELETE'});
        await Promise.all([this.loadProjectPeople(),this.loadProjectAssignments(),this.loadTeam()]);
      }catch(e){alert(e.message);}
    },

    async openAssigneeModal(todo){
      await this.loadProjectPeople();
      this.assignmentTask=todo;
      this.selectedAssigneeIds=this.taskPeople(todo.id).map(p=>Number(p.id));
      this.assigneeModal=true;
    },

    closeAssigneeModal(){
      this.assigneeModal=false; this.assignmentTask=null; this.selectedAssigneeIds=[];
    },

    toggleAssigneeSelection(id){
      id=Number(id);
      this.selectedAssigneeIds=this.selectedAssigneeIds.includes(id)
        ? this.selectedAssigneeIds.filter(v=>v!==id)
        : [...this.selectedAssigneeIds,id];
    },

    async saveTaskAssignees(){
      if(!this.assignmentTask)return;
      try{
        const data=await this.request('<?= site_url('task-manager/tasks') ?>/'+this.assignmentTask.id+'/assignees',{
          method:'PUT',body:JSON.stringify({team_member_ids:this.selectedAssigneeIds})
        });
        this.taskAssignments={...this.taskAssignments,[this.assignmentTask.id]:data.members||[]};
        this.closeAssigneeModal();
      }catch(e){alert(e.message);}
    },

    // --------------------------------------------------------------
    // SCHEDULE
    // --------------------------------------------------------------
    async openSchedule(){
      this.screen='schedule';
      await this.loadSchedule();
    },

    changeScheduleMonth(amount){
      this.scheduleCursor=new Date(this.scheduleCursor.getFullYear(),this.scheduleCursor.getMonth()+amount,1);
      this.loadSchedule();
    },

    scheduleToday(){
      this.scheduleCursor=new Date();
      this.loadSchedule();
    },

    isoDate(date){
      const y=date.getFullYear(),m=String(date.getMonth()+1).padStart(2,'0'),d=String(date.getDate()).padStart(2,'0');
      return `${y}-${m}-${d}`;
    },

    async loadSchedule(){
      const y=this.scheduleCursor.getFullYear(),m=this.scheduleCursor.getMonth();
      const from=new Date(y,m-1,20),to=new Date(y,m+2,10);
      const query=new URLSearchParams({from:this.isoDate(from),to:this.isoDate(to)});
      if(this.scheduleProjectId)query.set('project_id',this.scheduleProjectId);
      try{
        const data=await this.request('<?= site_url('task-manager/schedule') ?>?'+query.toString());
        this.scheduleEvents=data.events||[];
        this.scheduleTasks=data.tasks||[];
      }catch(e){console.error(e);}
    },

    toDateTimeLocal(value){
      return value ? String(value).replace(' ','T').slice(0,16) : '';
    },

    openEventModal(event=null){
      this.eventForm=event
        ? {id:event.id,project_id:event.project_id||'',title:event.title||'',description:event.description||'',event_type:event.event_type||'event',start_at:this.toDateTimeLocal(event.start_at),end_at:this.toDateTimeLocal(event.end_at),all_day:Number(event.all_day)===1,location:event.location||''}
        : {id:null,project_id:this.scheduleProjectId||this.currentProjectId||'',title:'',description:'',event_type:'event',start_at:'',end_at:'',all_day:false,location:''};
      this.eventModal=true;
    },

    async saveEvent(){
      if(!this.eventForm.title.trim()||!this.eventForm.start_at){alert('Title and start date/time are required.');return;}
      try{
        const editing=!!this.eventForm.id;
        const url='<?= site_url('task-manager/schedule') ?>'+(editing?'/'+this.eventForm.id:'');
        await this.request(url,{method:editing?'PUT':'POST',body:JSON.stringify({...this.eventForm,all_day:this.eventForm.all_day?1:0})});
        this.eventModal=false;
        await this.loadSchedule();
      }catch(e){alert(e.message);}
    },

    async deleteEvent(){
      if(!this.eventForm.id||!confirm('Delete this schedule item?'))return;
      try{
        await this.request('<?= site_url('task-manager/schedule') ?>/'+this.eventForm.id,{method:'DELETE'});
        this.eventModal=false;
        await this.loadSchedule();
      }catch(e){alert(e.message);}
    },

    scheduleDay(date){return new Date(date+'T00:00:00').getDate();},
    scheduleMonthShort(date){return new Date(date+'T00:00:00').toLocaleDateString(undefined,{month:'short'});},

    // --------------------------------------------------------------
    // MARKDOWN IMPORT
    // --------------------------------------------------------------
    parseMarkdownTasks(content){
      const tasks=[]; let currentCategory=null;
      for(const rawLine of content.split(/\r?\n/)){
        const line=rawLine.trimEnd();
        const heading=line.match(/^\s*(#{2,6})\s+(.+?)\s*#*\s*$/);
        if(heading){currentCategory=heading[2].trim();continue;}
        const task=line.match(/^\s*[-*+]\s+\[([ xX])\]\s+(.+?)\s*$/);
        if(!task)continue;
        const body=task[2].trim(); if(!body)continue;
        tasks.push({category:currentCategory||'Uncategorized',body,completed:task[1].toLowerCase()==='x'});
      }
      return tasks;
    },

    readImport(event){
      const file=event.target.files?.[0]; if(!file)return;
      const reader=new FileReader();
      reader.onload=()=>{this.importPreview=this.parseMarkdownTasks(String(reader.result||''));};
      reader.readAsText(file);
    },

    async importTasks(){
      if(!this.currentProjectId){alert('Select a project first.');return;}
      try{
        const data=await this.request('<?= site_url('task-manager/tasks/import') ?>',{
          method:'POST',body:JSON.stringify({project_id:this.currentProjectId,tasks:this.importPreview})
        });
        alert(data.message||`${data.imported||0} task(s) imported.`);
        this.importModal=false; this.importPreview=[];
        await this.loadData();
      }catch(e){alert(e.message);}
    },

    normalizeTask(t){
      return {
        ...t,
        id:Number(t.id),
        project_id:Number(t.project_id),
        category_id:t.category_id ? Number(t.category_id) : null,
        priority:t.priority||'normal',
        completed:this.isCompleted(t)
      };
    },
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