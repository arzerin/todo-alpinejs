<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Task Manager</title>
<script defer src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
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
    .modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:20px}.btn{border:1px solid #bbb;background:#fff;border-radius:5px;padding:9px 14px;font-weight:650}.btn-primary{background:#2f7d32;color:#fff;border-color:#2f7d32}.btn-secondary{background:#0000ff;color:#fff;border-color:#2f7d32}
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


    /* ==============================================================
       Phase 4 — Activity feed, following the existing Basecamp style
       ============================================================== */
    .activity-project-filter{border:1px solid #bbb;border-radius:5px;padding:8px 10px;background:#fff;min-width:160px}
    .activity-tabs{display:flex;gap:5px;flex-wrap:wrap;border-bottom:1px solid #ddd;margin-bottom:5px;padding-bottom:9px}
    .activity-tabs button{border:0;background:transparent;color:#666;font-size:12px;font-weight:700;padding:7px 9px;border-radius:4px}
    .activity-tabs button:hover,.activity-tabs button.active{background:#f0f0ee;color:#222}
    .activity-day{margin-top:24px}
    .activity-day-title{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#777;border-bottom:1px solid #ddd;padding-bottom:7px}
    .activity-row{display:grid;grid-template-columns:62px 42px minmax(0,1fr);gap:11px;padding:14px 3px;border-bottom:1px solid #ececec;align-items:start}
    .activity-row>.person-avatar.small{width:38px;height:38px;overflow:hidden}
    .activity-row>.person-avatar.small img{width:100%;height:100%;object-fit:cover;display:block}
    .activity-time{font-size:11px;color:#888;padding-top:7px}
    .activity-content{font-size:13px;line-height:1.45}
    .activity-subject{font-size:14px;font-weight:700;margin-top:3px;color:#333}
    .activity-project{margin-top:2px;font-size:11px}
    .activity-changes{display:inline-block;background:#f5f5f2;border-radius:4px;padding:4px 7px;margin-top:6px;font-size:10px;color:#666}
    .activity-assignment-change{margin-top:9px;display:flex;flex-direction:column;gap:7px}
    .activity-assignment-line{display:flex;align-items:flex-start;gap:8px;min-width:0}
    .activity-assignment-label{width:62px;flex:none;padding-top:5px;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.04em;color:#888}
    .activity-assignment-people{display:flex;align-items:center;gap:6px;flex-wrap:wrap}
    .activity-person-pill{display:inline-flex;align-items:center;gap:6px;border:1px solid #ddd;border-radius:16px;background:#fafafa;padding:3px 8px 3px 3px;font-size:11px;color:#444}
    .activity-person-pill .person-avatar{width:26px;height:26px;overflow:hidden;flex:none}
    .activity-person-pill .person-avatar img{width:100%;height:100%;object-fit:cover;display:block}
    .activity-assignment-arrow{color:#999;font-size:14px;padding-top:3px}
    .activity-load-more{text-align:center;padding:22px 0 4px}
    @media(max-width:800px){
      .activity-row{grid-template-columns:34px minmax(0,1fr)}
      .activity-time{grid-column:2;font-size:10px;padding:0}
      .activity-row>.person-avatar{grid-column:1;grid-row:1 / span 2}
      .activity-content{grid-column:2}
      .activity-project-filter{width:100%}
    }


    /* Phase 4.1 — People / project assignment */
    .person-project-box{margin-top:18px;padding-top:4px;border-top:1px solid #e2e2e2}
    .person-project-box .section-title{margin-top:13px}
    .task-add-person-link{display:inline-block;margin-top:10px;padding:0;border:0;background:transparent;cursor:pointer}


    /* Phase 4.1.1 — Add/Edit Person modal viewport fix */
    .person-modal{
      width:min(560px,calc(100vw - 30px));
      max-height:calc(100vh - 40px);
      display:flex;
      flex-direction:column;
      overflow:hidden;
      padding:0;
    }
    .person-modal-title{
      flex:0 0 auto;
      margin:0;
      padding:22px 24px 16px;
      border-bottom:1px solid #e2e2e2;
      background:#fff;
    }
    .person-modal-body{
      flex:1 1 auto;
      min-height:0;
      overflow-y:auto;
      padding:18px 24px 8px;
      overscroll-behavior:contain;
    }
    .person-modal-actions{
      flex:0 0 auto;
      margin:0;
      padding:14px 24px 18px;
      border-top:1px solid #ddd;
      background:#fff;
      box-shadow:0 -4px 10px rgba(0,0,0,.03);
    }
    @media(max-height:700px){
      .person-modal{max-height:calc(100vh - 20px)}
      .person-modal-title{padding-top:16px;padding-bottom:12px}
      .person-modal-body{padding-top:12px}
      .person-modal-actions{padding-top:10px;padding-bottom:12px}
      .person-photo-preview{margin-bottom:10px}
    }


    /* Phase 4.2 — multi-project people + assignee picker */
    .project-help{margin:4px 0 10px}
    .person-project-list{border-top:1px solid #e5e5e5}
    .person-project-row{padding:10px 0;border-bottom:1px solid #e5e5e5}
    .person-project-check{display:flex;align-items:center;gap:9px;font-weight:600}
    .person-project-role{margin:8px 0 0 25px;width:calc(100% - 25px)}
    .assignee-label-row{display:flex;align-items:center;justify-content:space-between;gap:15px;margin-bottom:6px}
    .assignee-label-row>label{margin:0}
    .assignee-label-actions{display:flex;align-items:center;gap:7px;font-size:12px;white-space:nowrap}
    .assignee-picker-modal{width:min(600px,calc(100vw - 30px));max-height:calc(100vh - 40px);display:flex;flex-direction:column;overflow:hidden}
    .assignee-picker-modal>h3{padding:20px 22px 12px;margin:0}
    .assignee-tabs{display:flex;gap:0;padding:0 22px;border-bottom:1px solid #ddd}
    .assignee-tabs button{border:0;background:none;padding:10px 14px;cursor:pointer;color:#666;border-bottom:2px solid transparent}
    .assignee-tabs button.active{color:#222;border-bottom-color:#222;font-weight:700}
    .assignee-picker-body{overflow-y:auto;min-height:160px;padding:10px 22px;flex:1}
    .assignee-picker-person{display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid #eee}
    .assignee-picker-person>label{display:flex;align-items:center;gap:10px;flex:1;margin:0}
    .assignee-picker-person.all-person{justify-content:space-between}
    .assignee-picker-info{display:flex;flex-direction:column;gap:2px;flex:1}
    .assignee-picker-info small{color:#888;font-size:11px}
    .assignee-picker-modal>.modal-actions{flex:0 0 auto;margin:0;padding:14px 22px;border-top:1px solid #ddd;background:#fff}
    @media(max-width:600px){
      .assignee-label-row{align-items:flex-start;flex-direction:column;gap:4px}
      .assignee-label-actions{white-space:normal}
    }


    /* Phase 4.2.1 — assignee picker avatar + checkbox fix */
    .assignee-picker-person .mini-avatar{
      width:34px;
      height:34px;
      min-width:34px;
      min-height:34px;
      max-width:34px;
      max-height:34px;
      border-radius:50%;
      overflow:hidden;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      background:#edf2f7;
      border:1px solid #d7dce2;
      font-size:11px;
      font-weight:700;
      line-height:1;
      vertical-align:middle;
    }
    .assignee-picker-person .mini-avatar img{
      display:block;
      width:34px !important;
      height:34px !important;
      min-width:34px;
      min-height:34px;
      max-width:34px;
      max-height:34px;
      object-fit:cover;
      object-position:center;
      border-radius:50%;
    }
    .assignee-picker-person input[type="checkbox"]{
      width:16px;
      height:16px;
      min-width:16px;
      cursor:pointer;
      margin:0;
    }
    .assignee-picker-person,
    .assignee-picker-person label{
      cursor:pointer;
    }
    .assignee-membership-note{
      flex:0 0 auto;
      font-size:11px;
      color:#777;
      margin-left:10px;
      white-space:nowrap;
    }
    .assignee-picker-person.all-person{
      gap:12px;
    }
    @media(max-width:560px){
      .assignee-membership-note{
        white-space:normal;
        max-width:110px;
        text-align:right;
      }
    }


    /* Phase 5 — Project Command Center, intentionally restrained/Basecamp-like */
    .command-top{align-items:flex-start}
    .command-actions{display:flex;gap:8px;align-items:center}
    .command-actions select{max-width:220px}
    .health-strip{border:1px solid #ddd;background:#fafafa;padding:16px 18px;margin:20px 0;display:grid;grid-template-columns:minmax(220px,.8fr) minmax(260px,1.2fr);gap:28px;align-items:center}
    .health-main{display:flex;align-items:center;gap:12px}
    .health-main>div{display:flex;flex-direction:column;gap:3px}
    .health-dot{width:12px;height:12px;border-radius:50%;background:#8a8a8a;box-shadow:0 0 0 4px rgba(0,0,0,.04)}
    .health-dot.health-good{background:#4f7f55}.health-dot.health-watch{background:#b18424}.health-dot.health-risk{background:#a84a45}
    .health-progress-head{display:flex;justify-content:space-between;margin-bottom:7px;font-size:12px}
    .progress-track,.mini-progress{height:7px;background:#e7e7e7;border-radius:20px;overflow:hidden}
    .progress-track span,.mini-progress span{display:block;height:100%;background:#6d7784;border-radius:20px}
    .command-metrics{display:grid;grid-template-columns:repeat(4,1fr);border:1px solid #ddd;margin-bottom:22px}
    .command-metric{padding:15px 16px;border-right:1px solid #ddd;display:flex;flex-direction:column;gap:2px;background:#fff}
    .command-metric:last-child{border-right:0}
    .command-metric>span,.command-metric small{font-size:11px;color:#777}.command-metric strong{font-size:24px;font-weight:600;color:#333}
    .command-metric.danger strong{color:#9a403b}.command-metric.warning strong{color:#946e18}
    .command-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px}
    .command-panel{border-top:2px solid #555;background:#fff}
    .command-panel-head{padding:11px 2px 9px;border-bottom:1px solid #ddd;display:flex;align-items:center;justify-content:space-between;gap:12px}
    .command-panel-head>span{font-size:11px}
    .attention-row,.command-upcoming-row{width:100%;border:0;border-bottom:1px solid #eee;background:#fff;padding:11px 2px;display:flex;align-items:center;text-align:left;cursor:pointer}
    .attention-row:hover,.command-upcoming-row:hover{background:#fafafa}
    .attention-copy{display:flex;flex:1;min-width:0;flex-direction:column;gap:3px}.attention-copy strong{white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.attention-copy small{color:#888}
    .attention-date{font-size:11px;color:#777;margin-left:10px}.attention-date.overdue{color:#a33;font-weight:700}
    .category-progress-row{padding:10px 2px;border-bottom:1px solid #eee}
    .category-progress-head{display:flex;justify-content:space-between;gap:12px;font-size:12px;margin-bottom:6px}.category-progress-head small{color:#777}
    .mini-progress{height:5px}
    .workload-row{display:flex;align-items:center;gap:9px;padding:9px 2px;border-bottom:1px solid #eee}
    .workload-person{display:flex;flex:1;min-width:0;flex-direction:column}.workload-person small{font-size:11px;color:#888}.workload-count{font-size:13px}
    .command-upcoming-row{gap:11px}.command-upcoming-row>span:last-child{display:flex;flex-direction:column}.command-upcoming-row small{font-size:11px;color:#888}
    .command-upcoming-date{width:34px;display:flex;flex-direction:column;align-items:center;border-right:1px solid #ddd}.command-upcoming-date strong{font-size:15px}.command-upcoming-date small{font-size:9px;color:#888}
    .command-activity-panel{margin-top:4px}.dashboard-activity-row{display:flex;align-items:center;gap:10px;padding:9px 2px;border-bottom:1px solid #eee}
    .dashboard-activity-copy{display:flex;flex:1;min-width:0;flex-direction:column}.dashboard-activity-copy small{color:#888;font-size:11px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .dashboard-activity-time{font-size:11px}.command-empty{padding:16px 2px;color:#888;font-size:12px}
    @media(max-width:900px){.command-metrics{grid-template-columns:1fr 1fr}.command-metric:nth-child(2){border-right:0}.command-metric:nth-child(-n+2){border-bottom:1px solid #ddd}.command-grid{grid-template-columns:1fr}.health-strip{grid-template-columns:1fr}}
    @media(max-width:560px){.command-actions{align-items:stretch;flex-direction:column}.command-metrics{grid-template-columns:1fr}.command-metric{border-right:0;border-bottom:1px solid #ddd}.command-metric:last-child{border-bottom:0}}


    /* Phase 6 — AI project intelligence + richer people roles */
    .phase6-help{font-size:11px;color:#888;margin-top:5px;line-height:1.45}
    .check-line{display:flex!important;align-items:center;gap:8px;font-size:12px;font-weight:600!important}
    .check-line input{width:auto!important}
    .person-project-intelligence{margin:8px 0 0 25px;width:calc(100% - 25px)}
    .person-project-intelligence textarea{min-height:62px}
    .field-label-actions{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:7px}
    .field-label-actions label{margin:0!important}
    .ai-command-panel{margin-top:18px}
    .ai-brief-body{padding:14px 2px;font-size:13px;line-height:1.55}
    .ai-brief-body h4{margin:0 0 5px;font-size:16px}.ai-brief-body p{margin:0 0 12px}
    .ai-list{margin:7px 0 0;padding-left:20px}.ai-list li{margin:5px 0}
    .ai-question{display:flex;gap:8px;padding:12px 2px;border-bottom:1px solid #eee}
    .ai-question input{flex:1;border:1px solid #bbb;border-radius:5px;padding:10px 11px;font-size:14px}
    .ai-answer{padding:13px 2px;font-size:13px;line-height:1.55;white-space:pre-wrap}
    .ai-subtask-modal{width:min(680px,calc(100vw - 30px));max-height:calc(100vh - 40px);display:flex;flex-direction:column;overflow:hidden}
    .ai-subtask-body{overflow-y:auto;padding:0 24px 10px;flex:1}
    .ai-subtask-row{display:grid;grid-template-columns:22px minmax(0,1fr) auto;gap:10px;align-items:start;padding:12px 0;border-bottom:1px solid #eee}
    .ai-subtask-row input{margin-top:3px}.ai-subtask-copy strong,.ai-subtask-copy small{display:block}.ai-subtask-copy small{color:#777;margin-top:4px}
    .ai-confidence{font-size:10px;color:#777;white-space:nowrap}

    /* Phase 7 — Meetings + AI Meeting Intelligence */
    .meeting-row{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px;align-items:center;padding:14px 4px;border-bottom:1px solid #e7e7e7;cursor:pointer}
    .meeting-row:hover{background:#fafafa}.meeting-copy strong,.meeting-copy small{display:block}.meeting-copy small{color:#777;margin-top:4px}
    .meeting-status{font-size:10px;text-transform:uppercase;letter-spacing:.04em;color:#666;border:1px solid #d7d7d7;border-radius:12px;padding:4px 8px;background:#fafafa}
    .meeting-detail-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:18px}.meeting-detail-actions{display:flex;gap:7px;flex-wrap:wrap}
    .meeting-panel{border-top:1px solid #ddd;padding:16px 2px}.meeting-panel h3{font-size:14px;margin:0 0 9px}.meeting-pre{white-space:pre-wrap;line-height:1.55;color:#444}
    .meeting-participants{display:flex;gap:8px;flex-wrap:wrap}.meeting-person-chip{display:flex;align-items:center;gap:8px;border:1px solid #ddd;border-radius:20px;padding:5px 12px 5px 5px;font-size:11px;background:#fafafa;min-width:170px}.meeting-person-chip .person-avatar.small{width:34px;height:34px;flex:none}
    .meeting-ai-box{border:1px solid #d9d9d9;border-radius:6px;padding:14px 16px;background:#fcfcfb;margin-top:12px}.meeting-ai-box h3{margin:0 0 9px;font-size:14px}
    .meeting-action-row{padding:13px 0;border-bottom:1px solid #e9e9e9}.meeting-action-head{display:flex;justify-content:space-between;gap:12px}.meeting-action-meta{display:flex;gap:7px;flex-wrap:wrap;margin-top:7px}.meeting-action-reason{font-size:11px;color:#777;margin-top:7px;line-height:1.45}.meeting-action-buttons{display:flex;gap:6px;margin-top:9px}
    .meeting-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .meeting-participant-list{
      max-height:280px;overflow-y:auto;display:grid;
      grid-template-columns:repeat(2,minmax(0,1fr));
      border:1px solid #ddd;border-radius:6px;background:#fff
    }
    .meeting-participant-option{
      display:grid;grid-template-columns:20px 38px minmax(0,1fr);
      align-items:center;gap:8px;min-width:0;padding:10px;
      border-bottom:1px solid #eee;border-right:1px solid #eee;
      cursor:pointer;margin:0
    }
    .meeting-participant-option:hover{background:#fafafa}
    .meeting-participant-option input{width:auto!important;margin:0}
    .meeting-participant-option:nth-child(2n){border-right:0}
    @media(min-width:1180px){
      .meeting-participant-list{grid-template-columns:repeat(3,minmax(0,1fr))}
      .meeting-participant-option:nth-child(2n){border-right:1px solid #eee}
      .meeting-participant-option:nth-child(3n){border-right:0}
    }
    @media(max-width:760px){
      .meeting-participant-list{grid-template-columns:1fr}
      .meeting-participant-option,
      .meeting-participant-option:nth-child(2n),
      .meeting-participant-option:nth-child(3n){border-right:0}
    }
    .meeting-participant-avatar{width:38px;height:38px;border-radius:50%;overflow:hidden;border:1px solid #d8d8d8;background:#f1f1f1;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#666;flex:none}
    .meeting-participant-avatar img{width:100%;height:100%;object-fit:cover;display:block}
    .meeting-participant-copy{min-width:0;display:flex;flex-direction:column;line-height:1.25}
    .meeting-participant-name{font-size:13px;font-weight:700;color:#333;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .meeting-participant-role{font-size:11px;color:#777;margin-top:3px;white-space:normal;overflow-wrap:anywhere}
    .meeting-person-chip .person-avatar.small{overflow:hidden}
    .meeting-person-chip .person-avatar.small img{width:100%;height:100%;object-fit:cover;display:block}
    .meeting-transcript-box textarea{min-height:180px}.meeting-empty{padding:22px 2px;color:#888}.meeting-back{border:0;background:transparent;color:#4776a8;padding:0;text-decoration:underline;font:inherit;cursor:pointer}
    @media(max-width:700px){.meeting-form-grid{grid-template-columns:1fr}.meeting-detail-head{flex-direction:column}}

    /* Phase 7.1 — task detail links + meeting attachments */
    .task-detail-link{border:0;background:transparent;padding:0;text-align:left;font:inherit;color:inherit;text-decoration:none;cursor:pointer}
    .task-detail-link:hover{text-decoration:underline}
    .meeting-files-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:8px}
    .meeting-file-upload{display:inline-flex;align-items:center;gap:6px;color:#2f7d32;font-size:12px;font-weight:700;cursor:pointer}
    .meeting-file-row{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:12px;align-items:center;padding:10px 0;border-bottom:1px solid #eee}
    .meeting-file-copy{min-width:0;display:flex;flex-direction:column;gap:3px}
    .meeting-file-copy a{color:#356b9a;text-decoration:none;font-size:13px;font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .meeting-file-copy a:hover{text-decoration:underline}
    .meeting-file-copy small{color:#888;font-size:10px}
    .meeting-file-actions{display:flex;align-items:center;gap:8px}
    .meeting-file-actions a{font-size:11px;color:#356b9a;text-decoration:none}
    .meeting-file-actions button{border:0;background:transparent;color:#a33;font-size:11px;padding:0}
    .meeting-upload-status{font-size:11px;color:#777;margin-top:7px}


    /* Phase 7.2 — Basecamp-style drag sorting */
    .drag-handle{
      border:0;background:transparent;color:#aaa;padding:0 5px 0 0;
      cursor:grab;font-size:17px;line-height:1;opacity:.22;
      user-select:none;touch-action:none
    }
    .category-heading:hover .drag-handle,
    .category-todo:hover .drag-handle{opacity:.85}
    .drag-handle:active{cursor:grabbing}
    .category-heading-left{display:flex;align-items:center;gap:6px;min-width:0}
    .category-sort-handle{font-size:18px}
    .category-todo{grid-template-columns:20px 28px minmax(0,1fr) 105px 66px 82px 24px}
    .task-sort-zone{min-height:7px}
    .task-sort-zone:empty{min-height:32px}
    .sortable-ghost{opacity:.28;background:#f1f1ef}
    .sortable-chosen{background:#fafaf8}
    .sortable-drag{box-shadow:0 4px 14px rgba(0,0,0,.12);background:#fff}
    .drag-saving{font-size:11px;color:#888;margin-left:7px;font-weight:500}
    @media(max-width:800px){
      .category-todo{grid-template-columns:20px 28px minmax(0,1fr) 24px}
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
      <a href="#" @click.prevent="openDashboard()" :class="{active:screen==='dashboard'}">Dashboard</a>
      <a href="#" @click.prevent="screen='projects'" :class="{active:screen==='projects'}">Projects</a>
      <a href="#" @click.prevent="screen='mytasks'" :class="{active:screen==='mytasks'}">My Tasks</a>
      <a href="#" @click.prevent="openSchedule()" :class="{active:screen==='schedule'}">Schedule</a>
      <a href="#" @click.prevent="openPeople()" :class="{active:screen==='people'}">People</a>
      <a href="#" @click.prevent="openMeetings()" :class="{active:screen==='meetings'}">Meetings</a>
      <a href="#" @click.prevent="openActivity()" :class="{active:screen==='activity'}">Activity</a>
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
         PHASE 5 — PROJECT COMMAND CENTER
         Current-state intelligence inside the existing Basecamp shell
         ============================================================ -->
    <section x-show="screen==='dashboard'">
      <div class="top command-top">
        <div>
          <h1>Project Command Center</h1>
          <div class="muted">
            <strong x-text="currentProject.name"></strong>
            · live delivery health, workload and upcoming commitments
          </div>
        </div>
        <div class="command-actions">
          <select x-model.number="currentProjectId" @change="dashboardProjectChanged()">
            <template x-for="project in projects" :key="project.id">
              <option :value="Number(project.id)" x-text="project.name"></option>
            </template>
          </select>
          <button class="btn" @click="refreshDashboard()" :disabled="dashboardLoading"
                  x-text="dashboardLoading ? 'Refreshing…' : 'Refresh'"></button>
        </div>
      </div>

      <div class="health-strip">
        <div class="health-main">
          <span class="health-dot" :class="dashboardHealthClass"></span>
          <div>
            <strong x-text="dashboardHealthLabel"></strong>
            <span class="muted" x-text="dashboardHealthReason"></span>
          </div>
        </div>
        <div class="health-progress">
          <div class="health-progress-head">
            <span>Overall completion</span>
            <strong x-text="dashboardCompletionPercent + '%'"></strong>
          </div>
          <div class="progress-track"><span :style="'width:'+dashboardCompletionPercent+'%'"></span></div>
        </div>
      </div>

      <div class="command-metrics">
        <div class="command-metric">
          <span>Open tasks</span>
          <strong x-text="dashboardOpenTasks.length"></strong>
          <small x-text="dashboardCompletedTasks.length + ' completed'"></small>
        </div>
        <div class="command-metric" :class="{danger:dashboardOverdueTasks.length>0}">
          <span>Overdue</span>
          <strong x-text="dashboardOverdueTasks.length"></strong>
          <small x-text="dashboardOverdueTasks.length ? 'needs attention' : 'nothing overdue'"></small>
        </div>
        <div class="command-metric" :class="{warning:dashboardDueSoonTasks.length>0}">
          <span>Due next 7 days</span>
          <strong x-text="dashboardDueSoonTasks.length"></strong>
          <small>active commitments</small>
        </div>
        <div class="command-metric" :class="{warning:dashboardHighPriorityTasks.length>0}">
          <span>High / urgent</span>
          <strong x-text="dashboardHighPriorityTasks.length"></strong>
          <small>open priority tasks</small>
        </div>
      </div>

      <div class="command-grid">
        <section class="command-panel">
          <div class="command-panel-head">
            <strong>Needs attention</strong>
            <span class="muted">Overdue and priority work</span>
          </div>

          <template x-for="todo in dashboardAttentionTasks" :key="'attention-'+todo.id">
            <button class="attention-row" @click="openTaskModal(todo)">
              <span class="attention-copy">
                <strong x-text="todo.body"></strong>
                <small>
                  <span x-text="dashboardTaskCategory(todo)"></span>
                  <span> · </span>
                  <span x-text="taskPeople(todo.id).map(p=>p.name).join(', ') || todo.assignee || 'Unassigned'"></span>
                </small>
              </span>
              <span class="attention-date"
                    :class="{overdue:isDashboardOverdue(todo)}"
                    x-text="formatDate(todo.due_date)"></span>
            </button>
          </template>

          <div x-show="dashboardAttentionTasks.length===0" class="command-empty">
            No urgent attention items.
          </div>
        </section>

        <section class="command-panel">
          <div class="command-panel-head">
            <strong>Category progress</strong>
            <span class="muted">Delivery by workstream</span>
          </div>

          <template x-for="row in dashboardCategoryProgress" :key="row.key">
            <div class="category-progress-row">
              <div class="category-progress-head">
                <span x-text="row.name"></span>
                <small x-text="row.completed + '/' + row.total + ' · ' + row.percent + '%'"></small>
              </div>
              <div class="mini-progress"><span :style="'width:'+row.percent+'%'"></span></div>
            </div>
          </template>

          <div x-show="dashboardCategoryProgress.length===0" class="command-empty">
            No categories or tasks yet.
          </div>
        </section>

        <section class="command-panel">
          <div class="command-panel-head">
            <strong>Team workload</strong>
            <button class="inline-link" @click="openPeople()">View people</button>
          </div>

          <template x-for="person in dashboardWorkload" :key="'workload-'+person.id">
            <div class="workload-row">
              <span class="person-avatar small">
                <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
                <span x-show="!person.photo" x-text="initials(person.name)"></span>
              </span>
              <span class="workload-person">
                <strong x-text="person.name"></strong>
                <small x-text="person.job_title || 'Team member'"></small>
              </span>
              <strong class="workload-count" x-text="person.open_tasks"></strong>
            </div>
          </template>

          <div x-show="dashboardWorkload.length===0" class="command-empty">
            No assigned open tasks.
          </div>
        </section>

        <section class="command-panel">
          <div class="command-panel-head">
            <strong>Upcoming</strong>
            <button class="inline-link" @click="openSchedule()">Open schedule</button>
          </div>

          <template x-for="item in dashboardUpcoming" :key="'upcoming-'+item.kind+'-'+item.id">
            <button class="command-upcoming-row"
                    @click="item.kind==='task' ? openTaskModal(item) : openSchedule()">
              <span class="command-upcoming-date">
                <strong x-text="scheduleDay(item.date)"></strong>
                <small x-text="scheduleMonthShort(item.date)"></small>
              </span>
              <span>
                <strong x-text="item.title"></strong>
                <small x-text="item.kind==='task' ? 'Task due' : (item.event_type || 'Event')"></small>
              </span>
            </button>
          </template>

          <div x-show="dashboardUpcoming.length===0" class="command-empty">
            Nothing scheduled in the next 30 days.
          </div>
        </section>
      </div>

      <section class="command-panel command-activity-panel">
        <div class="command-panel-head">
          <strong>Recent activity</strong>
          <button class="inline-link" @click="openActivity()">View full activity</button>
        </div>

        <template x-for="item in dashboardRecentActivities" :key="'dash-activity-'+item.id">
          <div class="dashboard-activity-row">
            <span class="person-avatar small">
              <img x-show="item.actor_photo" :src="photoUrl(item.actor_photo)" alt="">
              <span x-show="!item.actor_photo" x-text="initials(item.actor_name || 'System')"></span>
            </span>
            <span class="dashboard-activity-copy">
              <span>
                <strong x-text="item.actor_name || 'System'"></strong>
                <span x-text="' ' + activityDescription(item)"></span>
              </span>
              <small x-text="activitySubject(item) || item.project_name || ''"></small>
            </span>
            <span class="muted dashboard-activity-time" x-text="activityTime(item.created_at)"></span>
          </div>
        </template>

        <div x-show="dashboardRecentActivities.length===0" class="command-empty">
          No recent activity has been recorded.
        </div>
      </section>

      <!-- Phase 6: AI Project Intelligence -->
      <section class="command-panel ai-command-panel">
        <div class="command-panel-head">
          <strong>AI Project Brief</strong>
          <button type="button" class="inline-link" @click="generateProjectBrief()" :disabled="aiBriefLoading"
                  x-text="aiBriefLoading ? 'Analyzing…' : (aiBrief ? 'Regenerate' : 'Generate brief')"></button>
        </div>
        <div class="ai-brief-body" x-show="aiBriefLoading">Analyzing current project…</div>
        <div class="ai-brief-body" x-show="aiBrief && !aiBriefLoading">
          <h4 x-text="aiBrief?.headline || 'Project brief'"></h4>
          <p x-text="aiBrief?.summary || ''"></p>
          <template x-if="(aiBrief?.risks || []).length">
            <div><strong>Risks</strong><ul class="ai-list"><template x-for="(risk,i) in aiBrief.risks" :key="'risk-'+i"><li x-text="risk"></li></template></ul></div>
          </template>
          <template x-if="(aiBrief?.recommended_focus || []).length">
            <div style="margin-top:12px"><strong>Recommended focus</strong><ul class="ai-list"><template x-for="(focus,i) in aiBrief.recommended_focus" :key="'focus-'+i"><li x-text="focus"></li></template></ul></div>
          </template>
        </div>
        <div class="command-empty" x-show="!aiBrief && !aiBriefLoading">Generate an AI briefing from the current project's tasks, people, roles and schedule.</div>
      </section>

      <section class="command-panel ai-command-panel">
        <div class="command-panel-head"><strong>Ask Project AI</strong><span class="muted">Answers from project context</span></div>
        <div class="ai-question">
          <input x-model="aiQuestion" @keydown.enter.prevent="askProjectAi()" placeholder="What should we focus on? Who is best suited for the API work?">
          <button type="button" class="btn" @click="askProjectAi()" :disabled="aiLoading" x-text="aiLoading ? 'Thinking…' : 'Ask AI'"></button>
        </div>
        <div class="ai-answer" x-show="aiAnswer" x-text="aiAnswer?.answer || aiAnswer"></div>
      </section>
    </section>

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
      <div id="category-sort-container">
      <template x-for="category in displayCategories" :key="category.key">
        <section class="category-section"
                 :data-category-id="category.id || null">

          <div class="category-heading">
            <div class="category-heading-left">
              <button x-show="category.id"
                      type="button"
                      class="drag-handle category-sort-handle"
                      title="Drag to reorder category"
                      aria-label="Drag to reorder category">⠿</button>

              <div class="category-name" x-text="category.name"></div>

              <span class="drag-saving"
                    x-show="dragSaving">Saving order…</span>
            </div>

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

          <div class="task-sort-zone"
               :data-category-id="category.id || ''">
          <template x-for="todo in tasksForCategory(category.id)" :key="todo.id">
            <div class="todo category-todo"
                 :data-task-id="todo.id"
                 :class="{completed:isCompleted(todo)}">

              <button type="button"
                      class="drag-handle task-sort-handle"
                      title="Drag to reorder or move task"
                      aria-label="Drag to reorder task">⠿</button>

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
          </div>

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
      </div>

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
          <button type="button"
                       class="title task-title-btn"
                       x-text="todo.body"
                       @click="openTaskModal(todo)"
                       title="Edit task"></button>
          <div class="meta" x-text="taskPeople(todo.id).map(p=>p.name).join(', ') || todo.assignee || 'Unassigned'"></div>
          <div class="meta" x-text="formatDate(todo.due_date)"></div>
          <button class="delete" @click="remove(todo)">×</button>
        </div>
      </template>
    </section>

    <!-- ============================================================
         PHASE 7 — MEETINGS + AI MEETING INTELLIGENCE
         ============================================================ -->
    <section x-show="screen==='meetings'" x-cloak>
      <template x-if="!selectedMeeting">
        <div>
          <div class="top">
            <div>
              <h1>Meetings</h1>
              <div class="muted">Project discussions, decisions and reviewed action items.</div>
            </div>
            <button class="btn btn-primary" @click="openMeetingModal()">+ New meeting</button>
          </div>

          <div x-show="meetingLoading" class="meeting-empty">Loading meetings…</div>
          <div x-show="!meetingLoading && meetings.length===0" class="meeting-empty">No meetings have been added to this project yet.</div>

          <template x-for="meeting in meetings" :key="meeting.id">
            <div class="meeting-row" @click="openMeeting(meeting)">
              <div class="meeting-copy">
                <strong x-text="meeting.title"></strong>
                <small>
                  <span x-text="formatDateTime(meeting.start_at)"></span>
                  <span x-show="meeting.location" x-text="' · '+meeting.location"></span>
                </small>
              </div>
              <span class="meeting-status" x-text="meeting.status || 'scheduled'"></span>
            </div>
          </template>
        </div>
      </template>

      <template x-if="selectedMeeting">
        <div>
          <button class="meeting-back" @click="closeMeetingDetail()">← Back to meetings</button>
          <div class="meeting-detail-head" style="margin-top:14px">
            <div>
              <h1 x-text="selectedMeeting.title"></h1>
              <div class="muted">
                <span x-text="formatDateTime(selectedMeeting.start_at)"></span>
                <span x-show="selectedMeeting.location" x-text="' · '+selectedMeeting.location"></span>
              </div>
            </div>
            <div class="meeting-detail-actions">
              <button class="btn" @click="openMeetingModal(selectedMeeting)">Edit</button>
              <button class="btn" @click="analyzeMeeting()" :disabled="meetingAnalyzing" x-text="meetingAnalyzing ? 'Analyzing…' : '✨ Analyze meeting'"></button>
              <button class="btn danger-btn" @click="deleteMeeting(selectedMeeting)">Delete</button>
            </div>
          </div>

          <div class="meeting-panel" x-show="selectedMeeting.agenda">
            <h3>Agenda</h3><div class="meeting-pre" x-text="selectedMeeting.agenda"></div>
          </div>
          <div class="meeting-panel" x-show="selectedMeeting.notes">
            <h3>Notes</h3><div class="meeting-pre" x-text="selectedMeeting.notes"></div>
          </div>
          <div class="meeting-panel">
            <h3>Participants</h3>
            <div class="meeting-participants">
              <template x-for="participant in meetingParticipants" :key="participant.id">
                <div class="meeting-person-chip">
                  <span class="person-avatar small">
                    <img x-show="meetingParticipantPerson(participant)?.photo"
                         :src="photoUrl(meetingParticipantPerson(participant)?.photo || '')"
                         :alt="meetingParticipantName(participant)">
                    <span x-show="!meetingParticipantPerson(participant)?.photo"
                          x-text="initials(meetingParticipantName(participant))"></span>
                  </span>
                  <span class="meeting-participant-copy">
                    <span class="meeting-participant-name"
                          x-text="meetingParticipantName(participant)"></span>
                    <span class="meeting-participant-role"
                          x-show="meetingParticipantPerson(participant)?.job_title || meetingParticipantPerson(participant)?.role"
                          x-text="meetingParticipantPerson(participant)?.job_title || meetingParticipantPerson(participant)?.role || ''"></span>
                  </span>
                </div>
              </template>
              <span class="muted" x-show="meetingParticipants.length===0">No participants selected.</span>
            </div>
          </div>

          <!-- Phase 7.1 — downloadable meeting attachments -->
          <div class="meeting-panel">
            <div class="meeting-files-head">
              <h3 style="margin:0">Files</h3>
              <label class="meeting-file-upload">
                <span x-text="meetingFileUploading ? 'Uploading…' : '+ Upload files'"></span>
                <input type="file" multiple hidden :disabled="meetingFileUploading" @change="uploadMeetingFiles($event)">
              </label>
            </div>
            <template x-for="file in meetingFiles" :key="'meeting-file-'+file.id">
              <div class="meeting-file-row">
                <div class="meeting-file-copy">
                  <a :href="meetingFileDownloadUrl(file.id)" x-text="file.file_name"></a>
                  <small><span x-text="file.uploader_name || 'User'"></span> · <span x-text="formatFileSize(file.file_size)"></span><span x-show="file.created_at"> · <span x-text="formatDateTime(file.created_at)"></span></span></small>
                </div>
                <div class="meeting-file-actions"><a :href="meetingFileDownloadUrl(file.id)">Download</a><button type="button" @click="deleteMeetingFile(file)">Delete</button></div>
              </div>
            </template>
            <div class="muted" x-show="!meetingFileLoading && meetingFiles.length===0">No files uploaded for this meeting.</div>
            <div class="meeting-upload-status" x-show="meetingFileLoading">Loading files…</div>
          </div>

          <div class="meeting-panel meeting-transcript-box">
            <div class="field-label-actions"><h3>Transcript</h3><button class="inline-link" @click="saveMeetingTranscript()" :disabled="meetingTranscriptSaving" x-text="meetingTranscriptSaving ? 'Saving…' : 'Save transcript'"></button></div>
            <textarea x-model="meetingTranscriptText" placeholder="Paste meeting transcript, minutes, or spoken notes here before AI analysis."></textarea>
          </div>

          <div class="meeting-ai-box">
            <h3>AI Summary</h3>
            <div class="meeting-pre" x-text="selectedMeeting.ai_summary || 'Analyze this meeting to generate a concise project summary.'"></div>
          </div>

          <div class="meeting-ai-box">
            <h3>Decisions</h3>
            <template x-for="decision in meetingDecisions" :key="decision.id"><div class="meeting-action-row" x-text="decision.decision_text"></div></template>
            <div class="muted" x-show="meetingDecisions.length===0">No decisions extracted yet.</div>
          </div>

          <div class="meeting-ai-box">
            <h3>Risks / Blockers</h3>
            <template x-for="(risk,index) in meetingRisks" :key="index"><div class="meeting-action-row" x-text="risk"></div></template>
            <div class="muted" x-show="meetingRisks.length===0">No risks or blockers extracted yet.</div>
          </div>

          <div class="meeting-ai-box">
            <h3>Action Items</h3>
            <div class="phase6-help">AI action items remain proposals until you explicitly create a task.</div>
            <template x-for="action in meetingActionItems" :key="action.id">
              <div class="meeting-action-row">
                <div class="meeting-action-head"><strong x-text="action.body"></strong><span class="mini-badge" x-text="action.status"></span></div>
                <div class="meeting-action-meta">
                  <span class="mini-badge" x-show="action.suggested_assignee_id" x-text="meetingAssigneeName(action)"></span>
                  <span class="mini-badge" x-show="action.due_date" x-text="formatDate(action.due_date)"></span>
                  <span class="mini-badge" x-text="action.priority || 'normal'"></span>
                  <span class="mini-badge" x-show="action.confidence!==null && action.confidence!==''" x-text="meetingConfidence(action.confidence)"></span>
                </div>
                <div class="meeting-action-reason" x-show="action.assignment_reason" x-text="action.assignment_reason"></div>
                <div class="meeting-action-buttons" x-show="action.status==='proposed'">
                  <button class="btn" @click="rejectMeetingAction(action)">Reject</button>
                  <button class="btn btn-primary" @click="acceptMeetingAction(action)">Create task</button>
                </div>
                <div class="phase6-help" x-show="action.created_task_id" x-text="'Created task #'+action.created_task_id"></div>
              </div>
            </template>
            <div class="muted" x-show="meetingActionItems.length===0">No action items extracted yet.</div>
          </div>
        </div>
      </template>
    </section>

    <section x-show="screen==='activity'">
      <div class="top">
        <div>
          <h1>Activity</h1>
          <div class="muted">A chronological record of work across your projects.</div>
        </div>

        <select class="activity-project-filter"
                x-model="activityProjectId"
                @change="loadActivity(true)">
          <option value="">All projects</option>
          <template x-for="project in projects" :key="project.id">
            <option :value="project.id" x-text="project.name"></option>
          </template>
        </select>
      </div>

      <div class="activity-tabs">
        <button :class="{active:activityType===''}"
                @click="activityType='';loadActivity(true)">All activity</button>
        <button :class="{active:activityType==='task'}"
                @click="activityType='task';loadActivity(true)">Tasks</button>
        <button :class="{active:activityType==='category'}"
                @click="activityType='category';loadActivity(true)">Categories</button>
        <button :class="{active:activityType==='person'}"
                @click="activityType='person';loadActivity(true)">People</button>
        <button :class="{active:activityType==='schedule'}"
                @click="activityType='schedule';loadActivity(true)">Schedule</button>
        <button :class="{active:activityType==='import'}"
                @click="activityType='import';loadActivity(true)">Imports</button>
      </div>

      <div x-show="activityLoading && activities.length===0"
           class="muted empty-phase3">
        Loading activity…
      </div>

      <template x-for="group in groupedActivities" :key="group.key">
        <div class="activity-day">
          <div class="activity-day-title" x-text="group.label"></div>

          <template x-for="item in group.items" :key="item.id">
            <div class="activity-row">

              <div class="activity-time" x-text="activityTime(item.created_at)"></div>

              <div class="person-avatar small">
                <img x-show="activityActorPhoto(item)"
                     :src="photoUrl(activityActorPhoto(item))"
                     :alt="activityActorName(item)">
                <span x-show="!activityActorPhoto(item)"
                      x-text="initials(activityActorName(item))"></span>
              </div>

              <div class="activity-content">
                <div>
                  <strong x-text="activityActorName(item)"></strong>
                  <span x-text="' ' + activityDescription(item)"></span>
                </div>

                <div class="activity-subject"
                     x-show="activitySubject(item)"
                     x-text="activitySubject(item)"></div>

                <div class="muted activity-project"
                     x-show="item.project_name"
                     x-text="item.project_name"></div>

                <div class="activity-changes"
                     x-show="activityChanges(item)"
                     x-text="activityChanges(item)"></div>

                <!-- Assignment audit: show exactly who was removed and who was added. -->
                <div class="activity-assignment-change"
                     x-show="item.action==='task.assignment_delta'">

                  <div class="activity-assignment-line"
                       x-show="activityAssignmentPeople(item,'removed').length">
                    <span class="activity-assignment-label">Previous</span>
                    <span class="activity-assignment-people">
                      <template x-for="person in activityAssignmentPeople(item,'removed')"
                                :key="'removed-'+person.id">
                        <span class="activity-person-pill">
                          <span class="person-avatar small">
                            <img x-show="person.photo"
                                 :src="photoUrl(person.photo)"
                                 :alt="person.name">
                            <span x-show="!person.photo"
                                  x-text="initials(person.name)"></span>
                          </span>
                          <span x-text="person.name"></span>
                        </span>
                      </template>
                    </span>
                  </div>

                  <div class="activity-assignment-line"
                       x-show="activityAssignmentPeople(item,'added').length">
                    <span class="activity-assignment-label">Assigned to</span>
                    <span class="activity-assignment-people">
                      <template x-for="person in activityAssignmentPeople(item,'added')"
                                :key="'added-'+person.id">
                        <span class="activity-person-pill">
                          <span class="person-avatar small">
                            <img x-show="person.photo"
                                 :src="photoUrl(person.photo)"
                                 :alt="person.name">
                            <span x-show="!person.photo"
                                  x-text="initials(person.name)"></span>
                          </span>
                          <span x-text="person.name"></span>
                        </span>
                      </template>
                    </span>
                  </div>

                  <div class="activity-assignment-line"
                       x-show="!activityAssignmentPeople(item,'removed').length && !activityAssignmentPeople(item,'added').length">
                    <span class="muted">Assignment list was cleared.</span>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </template>

      <div x-show="!activityLoading && activities.length===0"
           class="muted empty-phase3">
        No activity has been recorded for this filter yet.
      </div>

      <div class="activity-load-more" x-show="activityHasMore">
        <button class="btn"
                @click="loadActivity(false)"
                :disabled="activityLoading"
                x-text="activityLoading ? 'Loading…' : 'Load more'"></button>
      </div>
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
        <div class="assignee-label-row">
          <label>Assignees</label>
          <div class="assignee-label-actions">
            <button type="button" class="inline-link" @click="openAssigneePickerFromTask()">Select people</button>
            <span>·</span>
            <button type="button" class="inline-link" @click="openNewPersonFromTask()">+ Add new person</button>
          </div>
        </div>

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
          </div>


        </div>
      </div>

      <div class="field" x-show="taskForm.id">
        <div class="field-label-actions">
          <label>Subtasks</label>
          <button type="button" class="inline-link" @click="generateAiSubtasks(taskForm.id)" :disabled="aiSubtaskLoading"
                  x-text="aiSubtaskLoading ? 'Generating…' : '✨ Generate subtasks'"></button>
        </div>
        <div class="phase6-help">AI suggestions are reviewed before any subtask is created.</div>
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
        <a x-show="taskForm.id"
           class="btn btn-secondary" 
           style="text-decoration:none;"
           :href="taskDetailUrl(taskForm.id)"
           title="Open task discussion, files and full details">
          View details
        </a>
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
    <div class="modal person-modal">
      <h3 class="person-modal-title" x-text="personForm.id ? 'Edit person' : 'Add person'"></h3>

      <div class="person-modal-body">
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

      <!-- Phase 6: global person intelligence profile -->
      <div class="field">
        <label>Role description</label>
        <textarea x-model="personForm.role_description" placeholder="Describe what this person owns and is expected to handle."></textarea>
      </div>
      <div class="field">
        <label>Skills</label>
        <input type="text" x-model="personForm.skills_text" placeholder="PHP, CodeIgniter, AWS, REST APIs">
        <div class="phase6-help">Separate skills with commas.</div>
      </div>
      <div class="field">
        <label>Responsibilities</label>
        <textarea x-model="personForm.responsibilities_text" placeholder="Backend architecture, API integrations, deployments"></textarea>
        <div class="phase6-help">Use commas or one responsibility per line.</div>
      </div>
      <div class="field checkbox-field">
        <label class="check-line"><input type="checkbox" x-model="personForm.ai_assignment_enabled"> Allow AI to suggest this person for work</label>
      </div>

      <div class="person-project-box">
        <div class="section-title">Project assignments</div>
        <div class="muted project-help">
          A person can belong to multiple projects.
        </div>

        <div class="person-project-list">
          <template x-for="project in projects" :key="project.id">
            <div class="person-project-row">
              <label class="person-project-check">
                <input type="checkbox"
                       :value="Number(project.id)"
                       x-model.number="personForm.project_ids">
                <span x-text="project.name"></span>
              </label>

              <input type="text"
                     class="person-project-role"
                     x-show="personForm.project_ids.includes(Number(project.id))"
                     x-model="personForm.project_roles[project.id]"
                     placeholder="Role (optional)">

              <div class="person-project-intelligence" x-show="personForm.project_ids.includes(Number(project.id))">
                <div class="field">
                  <label>Project role description</label>
                  <textarea x-model="personForm.project_role_descriptions[project.id]" placeholder="What does this person own in this project?"></textarea>
                </div>
                <div class="field">
                  <label>Project responsibilities</label>
                  <textarea x-model="personForm.project_responsibilities[project.id]" placeholder="API architecture, database design, deployment"></textarea>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
      </div><!-- /.person-modal-body -->

      <div class="modal-actions person-modal-actions">
        <button class="btn" @click="closePersonModal()">Cancel</button>
        <button class="btn btn-primary"
                @click="savePerson()"
                x-text="personForm.id ? 'Update person' : 'Add person'"></button>
      </div>
    </div>
  </div>

  <!-- Phase 6: AI subtask review — suggestions are never auto-created -->
  <div class="modal-backdrop" x-show="aiSubtaskModal" x-transition @click.self="closeAiSubtaskModal()" x-cloak>
    <div class="modal ai-subtask-modal">
      <h3 style="padding:22px 24px 8px;margin:0">AI subtask suggestions</h3>
      <div class="muted" style="padding:0 24px 14px" x-text="aiSubtaskSummary || 'Review the suggestions before creating tasks.'"></div>
      <div class="ai-subtask-body">
        <template x-for="item in aiSubtaskSuggestions" :key="item.suggestion_id">
          <label class="ai-subtask-row">
            <input type="checkbox" :value="Number(item.suggestion_id)" x-model.number="selectedAiSuggestionIds">
            <span class="ai-subtask-copy">
              <strong x-text="item.title"></strong>
              <small x-text="[priorityLabel(item.priority), item.assignment_reason].filter(Boolean).join(' · ')"></small>
            </span>
            <span class="ai-confidence" x-show="item.confidence!==null && item.confidence!==undefined" x-text="Math.round(Number(item.confidence)*100)+'% confidence'"></span>
          </label>
        </template>
        <div class="command-empty" x-show="aiSubtaskSuggestions.length===0">No subtask suggestions were returned.</div>
      </div>
      <div class="modal-actions" style="padding:14px 24px;border-top:1px solid #ddd;margin:0">
        <button class="btn" @click="closeAiSubtaskModal()">Cancel</button>
        <button class="btn btn-primary" @click="acceptAiSubtasks()" :disabled="aiSubtaskAccepting || selectedAiSuggestionIds.length===0"
                x-text="aiSubtaskAccepting ? 'Creating…' : 'Create selected ('+selectedAiSuggestionIds.length+')'"></button>
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


  <!-- Phase 4.2: existing-person assignee picker -->
  <div class="modal-backdrop" x-show="assigneePickerModal" x-transition
       @click.self="closeAssigneePicker()" x-cloak>
    <div class="modal assignee-picker-modal">
      <h3>Select assignees</h3>

      <div class="assignee-tabs">
        <button type="button"
                :class="{'active':assigneePickerTab==='project'}"
                @click="assigneePickerTab='project'">
          Project People
        </button>
        <button type="button"
                :class="{'active':assigneePickerTab==='all'}"
                @click="assigneePickerTab='all'">
          All People
        </button>
      </div>

      <div class="assignee-picker-body">
        <template x-if="assigneePickerTab==='project'">
          <div>
            <template x-for="person in projectPeople" :key="'project-'+person.id">
              <label class="assignee-picker-person">
                <input type="checkbox"
                       :checked="isAssigneePickerSelected(person.id)"
                       @change="toggleAssigneePickerPerson(person.id, $event.target.checked)">
                <span class="mini-avatar">
                  <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
                  <span x-show="!person.photo" x-text="initials(person.name)"></span>
                </span>
                <span class="assignee-picker-info">
                  <strong x-text="person.name"></strong>
                  <small x-text="person.job_title || person.email || 'Project member'"></small>
                </span>
              </label>
            </template>

            <div class="muted" x-show="projectPeople.length===0">
              No people are assigned to this project.
            </div>
          </div>
        </template>

        <template x-if="assigneePickerTab==='all'">
          <div>
            <template x-for="person in teamMembers" :key="'all-'+person.id">
              <div class="assignee-picker-person all-person">
                <label>
                  <input type="checkbox"
                         :checked="isAssigneePickerSelected(person.id)"
                         @change="toggleAllPeopleAssignee(person, $event.target.checked)">
                  <span class="mini-avatar">
                    <img x-show="person.photo" :src="photoUrl(person.photo)" alt="">
                    <span x-show="!person.photo" x-text="initials(person.name)"></span>
                  </span>
                  <span class="assignee-picker-info">
                    <strong x-text="person.name"></strong>
                    <small x-text="person.job_title || person.email || 'Team member'"></small>
                  </span>
                </label>

                <span class="assignee-membership-note"
                      x-show="!isProjectPerson(person.id)">
                  Selecting will add to project
                </span>
              </div>
            </template>
          </div>
        </template>
      </div>

      <div class="modal-actions">
        <button class="btn" @click="closeAssigneePicker()">Cancel</button>
        <button class="btn btn-primary" @click="applyAssigneePicker()">Apply</button>
      </div>
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

        <button type="button"
                class="inline-link task-add-person-link"
                @click="openNewPersonFromAssigneeModal()">
          + Add new person
        </button>
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

  <!-- Phase 7 — Add / Edit meeting -->
  <div class="modal-backdrop" x-show="meetingModal" x-transition @click.self="closeMeetingModal()" x-cloak>
    <div class="modal" style="width:min(700px,calc(100vw - 30px));max-height:calc(100vh - 40px);overflow:auto">
      <h3 x-text="meetingForm.id ? 'Edit meeting' : 'New meeting'"></h3>
      <div class="error-box" x-show="meetingError" x-text="meetingError"></div>
      <div class="field"><label>Title</label><input x-model="meetingForm.title" placeholder="e.g. Weekly delivery review"></div>
      <div class="field"><label>Project</label><select x-model.number="meetingForm.project_id"><template x-for="project in projects" :key="project.id"><option :value="Number(project.id)" x-text="project.name"></option></template></select></div>
      <div class="meeting-form-grid">
        <div class="field"><label>Starts</label><input type="datetime-local" x-model="meetingForm.start_at"></div>
        <div class="field"><label>Ends</label><input type="datetime-local" x-model="meetingForm.end_at"></div>
      </div>
      <div class="meeting-form-grid">
        <div class="field"><label>Type</label><select x-model="meetingForm.meeting_type"><option value="project">Project</option><option value="standup">Stand-up</option><option value="planning">Planning</option><option value="review">Review</option><option value="retrospective">Retrospective</option><option value="client">Client</option></select></div>
        <div class="field"><label>Status</label><select x-model="meetingForm.status"><option value="scheduled">Scheduled</option><option value="in_progress">In progress</option><option value="completed">Completed</option><option value="cancelled">Cancelled</option></select></div>
      </div>
      <div class="field"><label>Location / link</label><input x-model="meetingForm.location" placeholder="Room, Google Meet, Zoom, etc."></div>
      <div class="field"><label>Agenda</label><textarea x-model="meetingForm.agenda" placeholder="What should this meeting cover?"></textarea></div>
      <div class="field"><label>Notes</label><textarea x-model="meetingForm.notes" placeholder="Meeting notes and important context"></textarea></div>
      <div class="field">
        <label>Participants</label>
        <div class="meeting-participant-list">
          <template x-for="person in meetingAvailablePeople" :key="person.id">
            <label class="meeting-participant-option">
              <input type="checkbox"
                     :value="Number(person.id)"
                     x-model.number="meetingForm.participant_ids">

              <span class="meeting-participant-avatar">
                <img x-show="person.photo"
                     :src="photoUrl(person.photo)"
                     :alt="person.name">
                <span x-show="!person.photo"
                      x-text="initials(person.name)"></span>
              </span>

              <span class="meeting-participant-copy">
                <span class="meeting-participant-name"
                      x-text="person.name"></span>
                <span class="meeting-participant-role"
                      x-show="person.job_title || person.role"
                      x-text="person.job_title || person.role || ''"></span>
              </span>
            </label>
          </template>
          <div class="muted" x-show="meetingAvailablePeople.length===0">No people are available for this project.</div>
        </div>
      </div>
      <div class="modal-actions"><button class="btn" @click="closeMeetingModal()">Cancel</button><button class="btn btn-primary" @click="saveMeeting()" :disabled="meetingSaving" x-text="meetingSaving ? 'Saving…' : 'Save meeting'"></button></div>
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
    dashboardLoading: false,
    dashboardActivities: [],
    dashboardEvents: [],
    dashboardScheduleTasks: [],
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
    personForm: {id:null,name:'',email:'',job_title:'',phone:'',status:'active',photo:'',role_description:'',skills_text:'',responsibilities_text:'',ai_assignment_enabled:true,project_ids:[],project_roles:{},project_role_descriptions:{},project_responsibilities:{}},
    aiBrief:null, aiBriefLoading:false, aiQuestion:'', aiAnswer:null, aiLoading:false,
    aiSubtaskModal:false, aiSubtaskLoading:false, aiSubtaskAccepting:false, aiSubtaskTaskId:null, aiSubtaskSummary:'', aiSubtaskSuggestions:[], selectedAiSuggestionIds:[],
    personReturnContext: null,
    assigneePickerModal: false,
    assigneePickerTab: 'project',
    assigneePickerIds: [],
    projectMemberForm: {team_member_id:'',role:''},
    assignmentTask: null,
    selectedAssigneeIds: [],
    eventForm: {id:null,project_id:'',title:'',description:'',event_type:'event',start_at:'',end_at:'',all_day:false,location:''},
    importPreview: [],
    activities: [],
    activityType: '',
    activityProjectId: '',
    activityOffset: 0,
    activityHasMore: false,
    activityLoading: false,
    // Phase 7 — meeting state
    meetings: [],
    selectedMeeting: null,
    meetingParticipants: [],
    meetingTranscripts: [],
    meetingDecisions: [],
    meetingActionItems: [],
    meetingFiles: [],
    meetingFileLoading: false,
    meetingFileUploading: false,
    meetingLoading: false,
    meetingAnalyzing: false,
    meetingSaving: false,
    meetingTranscriptSaving: false,
    meetingModal: false,
    meetingError: '',
    meetingTranscriptText: '',
    meetingForm: {id:null,project_id:null,title:'',agenda:'',notes:'',meeting_type:'project',status:'scheduled',start_at:'',end_at:'',location:'',participant_ids:[]},
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
    dragSaving: false,
    categorySortable: null,
    taskSortables: [],

    async init(){
      await this.loadData();
      await Promise.all([this.loadProjectPeople(),this.loadProjectAssignments()]);
      this.$nextTick(()=>this.initDragSorting());
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
      return {dashboard:'Dashboard',mytasks:'My Tasks',schedule:'Schedule',people:'People',meetings:'Meetings',activity:'Activity'}[this.screen] || 'Projects';
    },
    get meetingAvailablePeople(){
      const pid=Number(this.meetingForm.project_id||this.currentProjectId);
      // projectPeople represents the selected project's membership; when editing another project,
      // teamMembers remains a safe fallback and backend membership validation remains authoritative.
      return pid===Number(this.currentProjectId) && this.projectPeople.length ? this.projectPeople : this.teamMembers.filter(p=>p.status==='active');
    },
    get meetingRisks(){
      const raw=this.selectedMeeting?.ai_risks;
      if(!raw)return [];
      if(Array.isArray(raw))return raw;
      try{const parsed=JSON.parse(raw);return Array.isArray(parsed)?parsed:[String(raw)];}catch(e){return [String(raw)];}
    },
    get myVisibleTasks(){ return this.todos; },

    get dashboardProjectTasks(){
      return this.todos.filter(t=>Number(t.project_id)===Number(this.currentProjectId));
    },
    get dashboardOpenTasks(){ return this.dashboardProjectTasks.filter(t=>!this.isCompleted(t)); },
    get dashboardCompletedTasks(){ return this.dashboardProjectTasks.filter(t=>this.isCompleted(t)); },
    get dashboardCompletionPercent(){
      const total=this.dashboardProjectTasks.length;
      return total ? Math.round((this.dashboardCompletedTasks.length/total)*100) : 0;
    },
    get dashboardOverdueTasks(){
      const today=this.isoDate(new Date());
      return this.dashboardOpenTasks.filter(t=>t.due_date && String(t.due_date).slice(0,10)<today);
    },
    get dashboardDueSoonTasks(){
      const today=this.isoDate(new Date());
      const end=new Date(); end.setDate(end.getDate()+7);
      const until=this.isoDate(end);
      return this.dashboardOpenTasks.filter(t=>{
        const due=String(t.due_date||'').slice(0,10);
        return due && due>=today && due<=until;
      });
    },
    get dashboardHighPriorityTasks(){
      return this.dashboardOpenTasks.filter(t=>['high','urgent'].includes(String(t.priority||'normal').toLowerCase()));
    },
    get dashboardAttentionTasks(){
      const rows=[...this.dashboardOpenTasks].filter(t=>
        this.isDashboardOverdue(t) || ['high','urgent'].includes(String(t.priority||'').toLowerCase())
      );
      return rows.sort((a,b)=>{
        const ao=this.isDashboardOverdue(a)?0:1, bo=this.isDashboardOverdue(b)?0:1;
        if(ao!==bo)return ao-bo;
        const rank={urgent:0,high:1,normal:2,low:3};
        const pr=(rank[a.priority]??2)-(rank[b.priority]??2);
        if(pr!==0)return pr;
        return String(a.due_date||'9999-12-31').localeCompare(String(b.due_date||'9999-12-31'));
      }).slice(0,7);
    },
    get dashboardCategoryProgress(){
      const rows=[];
      for(const category of this.displayCategories){
        const tasks=this.tasksForCategory(category.id);
        if(!tasks.length)continue;
        const completed=tasks.filter(t=>this.isCompleted(t)).length;
        rows.push({
          key:category.key,
          name:category.name,
          total:tasks.length,
          completed,
          percent:Math.round((completed/tasks.length)*100)
        });
      }
      return rows;
    },
    get dashboardWorkload(){
      const map=new Map();
      for(const task of this.dashboardOpenTasks){
        for(const person of this.taskPeople(task.id)){
          const id=Number(person.id);
          if(!map.has(id))map.set(id,{...person,id,open_tasks:0});
          map.get(id).open_tasks++;
        }
      }
      return [...map.values()].sort((a,b)=>b.open_tasks-a.open_tasks || String(a.name).localeCompare(String(b.name))).slice(0,8);
    },
    get dashboardUpcoming(){
      const today=this.isoDate(new Date());
      const end=new Date(); end.setDate(end.getDate()+30);
      const until=this.isoDate(end), items=[];
      this.dashboardEvents.forEach(e=>{
        const date=String(e.start_at||'').slice(0,10);
        if(date>=today && date<=until)items.push({...e,kind:'event',date});
      });
      this.dashboardScheduleTasks.forEach(t=>{
        const date=String(t.due_date||'').slice(0,10);
        if(date>=today && date<=until)items.push({...t,kind:'task',title:t.body,date});
      });
      return items.sort((a,b)=>a.date.localeCompare(b.date)).slice(0,8);
    },
    get dashboardRecentActivities(){ return this.dashboardActivities.slice(0,8); },
    get dashboardHealthLabel(){
      if(this.dashboardOverdueTasks.length>=3 || this.dashboardOverdueTasks.length>Math.max(1,Math.floor(this.dashboardOpenTasks.length*.25)))return 'At risk';
      if(this.dashboardOverdueTasks.length>0 || this.dashboardHighPriorityTasks.length>=3)return 'Needs attention';
      return 'On track';
    },
    get dashboardHealthClass(){
      return this.dashboardHealthLabel==='At risk' ? 'health-risk' : (this.dashboardHealthLabel==='Needs attention' ? 'health-watch' : 'health-good');
    },
    get dashboardHealthReason(){
      if(!this.dashboardProjectTasks.length)return 'No tasks have been added yet.';
      if(this.dashboardOverdueTasks.length)return this.dashboardOverdueTasks.length+' overdue task'+(this.dashboardOverdueTasks.length===1?'':'s')+'.';
      if(this.dashboardHighPriorityTasks.length)return this.dashboardHighPriorityTasks.length+' high-priority commitment'+(this.dashboardHighPriorityTasks.length===1?'':'s')+' open.';
      return 'No overdue work detected.';
    },
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
    get groupedActivities(){
      const groups=[];
      const map=new Map();

      for(const item of this.activities){
        const key=String(item.created_at||'').slice(0,10);
        if(!map.has(key)){
          const group={key,label:this.activityDayLabel(key),items:[]};
          map.set(key,group);
          groups.push(group);
        }
        map.get(key).items.push(item);
      }

      return groups;
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
          sort_order:Number(t.sort_order||0),
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
      if(this.screen==='dashboard')this.refreshDashboard();
      this.$nextTick(()=>this.initDragSorting());
    },
    saveCache(){ localStorage.setItem('basecamp-task-manager',JSON.stringify({projects:this.projects,todos:this.todos,currentProjectId:this.currentProjectId})); },

    tasksForCategory(categoryId){
      return this.projectTodos.filter(t=>{
        const sameCategory=categoryId===null
          ? !t.category_id
          : Number(t.category_id)===Number(categoryId);
        return sameCategory;
      }).sort((a,b)=>
        (Number(a.sort_order)||0)-(Number(b.sort_order)||0)
        || Number(a.id)-Number(b.id)
      );
    },

    initDragSorting(){
      if(typeof Sortable==='undefined') return;

      if(this.categorySortable){
        this.categorySortable.destroy();
        this.categorySortable=null;
      }

      this.taskSortables.forEach(instance=>instance.destroy());
      this.taskSortables=[];

      const categoryContainer=document.getElementById('category-sort-container');

      if(categoryContainer){
        this.categorySortable=Sortable.create(categoryContainer,{
          animation:150,
          handle:'.category-sort-handle',
          draggable:'.category-section[data-category-id]',
          ghostClass:'sortable-ghost',
          chosenClass:'sortable-chosen',
          dragClass:'sortable-drag',
          onEnd:()=>this.persistCategoryOrder()
        });
      }

      document.querySelectorAll('.task-sort-zone').forEach(zone=>{
        this.taskSortables.push(Sortable.create(zone,{
          group:'project-tasks',
          animation:150,
          handle:'.task-sort-handle',
          draggable:'.category-todo',
          ghostClass:'sortable-ghost',
          chosenClass:'sortable-chosen',
          dragClass:'sortable-drag',
          emptyInsertThreshold:18,
          onEnd:()=>this.persistTaskOrder()
        }));
      });
    },

    async persistCategoryOrder(){
      const ids=[...document.querySelectorAll(
        '#category-sort-container > .category-section[data-category-id]'
      )]
        .map(section=>Number(section.dataset.categoryId))
        .filter(Boolean);

      if(!ids.length) return;

      this.dragSaving=true;

      try{
        await this.request('<?= site_url('task-manager/categories/reorder') ?>',{
          method:'PUT',
          body:JSON.stringify({
            project_id:this.currentProjectId,
            category_ids:ids
          })
        });

        ids.forEach((id,index)=>{
          const category=this.categories.find(c=>Number(c.id)===id);
          if(category) category.sort_order=(index+1)*10;
        });
      }catch(error){
        alert(error.message || 'Unable to save category order.');
        await this.loadData();
      }finally{
        this.dragSaving=false;
        this.$nextTick(()=>this.initDragSorting());
      }
    },

    async persistTaskOrder(){
      const tasks=[];

      document.querySelectorAll('.task-sort-zone').forEach(zone=>{
        const categoryId=zone.dataset.categoryId
          ? Number(zone.dataset.categoryId)
          : null;

        [...zone.querySelectorAll(':scope > .category-todo[data-task-id]')]
          .forEach((row,index)=>{
            tasks.push({
              id:Number(row.dataset.taskId),
              category_id:categoryId,
              sort_order:(index+1)*10
            });
          });
      });

      if(!tasks.length) return;

      this.dragSaving=true;

      try{
        await this.request('<?= site_url('task-manager/tasks/reorder') ?>',{
          method:'PUT',
          body:JSON.stringify({
            project_id:this.currentProjectId,
            tasks:tasks
          })
        });

        tasks.forEach(item=>{
          const task=this.todos.find(t=>Number(t.id)===Number(item.id));

          if(task){
            task.category_id=item.category_id;
            task.sort_order=item.sort_order;
          }
        });

        this.saveCache();
      }catch(error){
        alert(error.message || 'Unable to save task order.');
        await this.loadData();
      }finally{
        this.dragSaving=false;
        this.$nextTick(()=>this.initDragSorting());
      }
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
        // Filter against current project membership so a person removed from
        // the project cannot remain as a stale selected ID.
        await this.loadProjectPeople();

        const validProjectPersonIds=this.projectPeople.map(
          person=>Number(person.id)
        );

        this.selectedTaskAssigneeIds=this.selectedTaskAssigneeIds.filter(
          id=>validProjectPersonIds.includes(Number(id))
        );

        const assignmentData=await this.request(
          '<?= site_url('task-manager/tasks') ?>/'+task.id+'/assignees',
          {
            method:'PUT',
            body:JSON.stringify({
              team_member_ids:this.selectedTaskAssigneeIds.map(Number)
            })
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
    // PHASE 5 — PROJECT COMMAND CENTER
    // --------------------------------------------------------------
    async openDashboard(){
      this.screen='dashboard';
      await this.refreshDashboard();
    },

    async dashboardProjectChanged(){
      this.currentProjectId=Number(this.currentProjectId);
      this.saveCache();
      await this.refreshDashboard();
    },

    async refreshDashboard(){
      if(!this.currentProjectId)return;
      this.dashboardLoading=true;

      try{
        await Promise.all([
          this.loadProjectPeople(),
          this.loadProjectAssignments(),
          this.loadDashboardSchedule(),
          this.loadDashboardActivity()
        ]);
      }finally{
        this.dashboardLoading=false;
      }
    },

    async loadDashboardSchedule(){
      if(!this.currentProjectId){
        this.dashboardEvents=[];
        this.dashboardScheduleTasks=[];
        return;
      }

      const from=this.isoDate(new Date());
      const toDate=new Date();
      toDate.setDate(toDate.getDate()+30);

      const query=new URLSearchParams({
        from,
        to:this.isoDate(toDate),
        project_id:String(this.currentProjectId)
      });

      try{
        const data=await this.request(
          '<?= site_url('task-manager/schedule') ?>?'+query.toString()
        );
        this.dashboardEvents=data.events||[];
        this.dashboardScheduleTasks=data.tasks||[];
      }catch(e){
        console.error(e);
        this.dashboardEvents=[];
        // The dashboard can still derive task deadlines from loaded tasks.
        this.dashboardScheduleTasks=this.dashboardProjectTasks;
      }
    },

    async loadDashboardActivity(){
      if(!this.currentProjectId){
        this.dashboardActivities=[];
        return;
      }

      const query=new URLSearchParams({
        project_id:String(this.currentProjectId),
        limit:'8',
        offset:'0'
      });

      try{
        const data=await this.request(
          '<?= site_url('task-manager/activity') ?>?'+query.toString()
        );
        this.dashboardActivities=data.activities||[];
      }catch(e){
        console.error(e);
        this.dashboardActivities=[];
      }
    },

    isDashboardOverdue(todo){
      if(!todo?.due_date || this.isCompleted(todo))return false;
      return String(todo.due_date).slice(0,10)<this.isoDate(new Date());
    },

    dashboardTaskCategory(todo){
      if(!todo?.category_id)return 'Uncategorized';
      return this.categories.find(c=>Number(c.id)===Number(todo.category_id))?.name || 'Uncategorized';
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

    openPersonModal(person=null, options={}){
      this.teamError='';
      this.personPhoto=null;

      const memberships=person?.projects || [];
      const projectIds=memberships.map(p=>Number(p.id));
      const projectRoles={};
      const projectRoleDescriptions={};
      const projectResponsibilities={};

      memberships.forEach(p=>{
        const id=Number(p.id);
        projectRoles[id]=p.role||'';
        projectRoleDescriptions[id]=p.role_description||'';
        projectResponsibilities[id]=this.listText(p.responsibilities);
      });

      // When launched from a task, pre-check its current project.
      if(options.project_id && !projectIds.includes(Number(options.project_id))){
        projectIds.push(Number(options.project_id));
      }

      this.personForm=person
        ? {
            id:person.id,
            name:person.name||'',
            email:person.email||'',
            job_title:person.job_title||'',
            phone:person.phone||'',
            status:person.status||'active',
            photo:person.photo||'',
            role_description:person.role_description||'',
            skills_text:this.listText(person.skills),
            responsibilities_text:this.listText(person.responsibilities),
            ai_assignment_enabled:Number(person.ai_assignment_enabled ?? 1)===1,
            project_ids:projectIds,
            project_roles:projectRoles,
            project_role_descriptions:projectRoleDescriptions,
            project_responsibilities:projectResponsibilities
          }
        : {
            id:null,
            name:'',
            email:'',
            job_title:'',
            phone:'',
            status:'active',
            photo:'',
            role_description:'',
            skills_text:'',
            responsibilities_text:'',
            ai_assignment_enabled:true,
            project_ids:options.project_id ? [Number(options.project_id)] : [],
            project_roles:{},
            project_role_descriptions:{},
            project_responsibilities:{}
          };

      this.personPhotoPreview=person?.photo ? this.photoUrl(person.photo) : '';
      this.personReturnContext=options.returnContext || null;
      this.personModal=true;
    },

    closePersonModal(preserveContext=false){
      this.personModal=false;
      this.personPhoto=null;
      this.personPhotoPreview='';

      if(!preserveContext){
        this.personReturnContext=null;
      }
    },

    async openAssigneePickerFromTask(){
      await this.loadTeam();
      await this.loadProjectPeople();

      this.assigneePickerIds=this.selectedTaskAssigneeIds
        .map(Number);

      this.assigneePickerTab='project';
      this.assigneePickerModal=true;
    },

    closeAssigneePicker(){
      this.assigneePickerModal=false;
    },

    isProjectPerson(memberId){
      return this.projectPeople.some(
        person=>Number(person.id)===Number(memberId)
      );
    },

    isAssigneePickerSelected(memberId){
      return this.assigneePickerIds
        .map(Number)
        .includes(Number(memberId));
    },

    toggleAssigneePickerPerson(memberId, checked){
      const id=Number(memberId);
      const ids=this.assigneePickerIds.map(Number);

      if(checked){
        if(!ids.includes(id)){
          this.assigneePickerIds=[...ids,id];
        }
      }else{
        this.assigneePickerIds=ids.filter(existingId=>existingId!==id);
      }
    },

    async toggleAllPeopleAssignee(person, checked){
      const id=Number(person.id);

      if(!checked){
        this.toggleAssigneePickerPerson(id,false);
        return;
      }

      /*
       * In All People, checking someone who is not yet on this project
       * automatically creates project membership, then selects them.
       */
      if(!this.isProjectPerson(id)){
        try{
          await this.addExistingPersonToCurrentProject(person);
        }catch(e){
          // addExistingPersonToCurrentProject already reports the error.
          return;
        }
      }

      this.toggleAssigneePickerPerson(id,true);
    },

    async addExistingPersonToCurrentProject(person){
      try{
        await this.request(
          '<?= site_url('task-manager/projects') ?>/'+this.currentProjectId+'/members',
          {
            method:'POST',
            body:JSON.stringify({
              team_member_id:Number(person.id),
              role:''
            })
          }
        );

        await this.loadTeam();
        await this.loadProjectPeople();

        const id=Number(person.id);
        if(!this.assigneePickerIds.includes(id)){
          this.assigneePickerIds=[...this.assigneePickerIds,id];
        }
      }catch(e){
        alert(e.message);
        throw e;
      }
    },

    applyAssigneePicker(){
      // Only project members may be persisted as task assignees.
      const valid=this.projectPeople.map(p=>Number(p.id));

      this.selectedTaskAssigneeIds=this.assigneePickerIds
        .map(Number)
        .filter(id=>valid.includes(id));

      this.closeAssigneePicker();
    },

    openNewPersonFromTask(){
      // Keep the task modal alive underneath the person modal. This prevents
      // losing task text/category/priority/due-date while creating a person.
      this.openPersonModal(null,{
        project_id:this.currentProjectId,
        returnContext:'task-form'
      });
    },

    openNewPersonFromAssigneeModal(){
      this.openPersonModal(null,{
        project_id:this.currentProjectId,
        returnContext:'assignee-modal'
      });
    },

    selectPersonPhoto(event){
      const file=event.target.files?.[0]; if(!file)return;
      this.personPhoto=file;
      this.personPhotoPreview=URL.createObjectURL(file);
    },

    async savePerson(){
      if(!this.personForm.name.trim()){
        this.teamError='Name is required.';
        return;
      }

      this.teamError='';

      const fd=new FormData();
      ['name','email','job_title','phone','status','role_description'].forEach(
        k=>fd.append(k,this.personForm[k]||'')
      );
      fd.append('skills',JSON.stringify(this.textList(this.personForm.skills_text)));
      fd.append('responsibilities',JSON.stringify(this.textList(this.personForm.responsibilities_text)));
      fd.append('ai_assignment_enabled',this.personForm.ai_assignment_enabled ? '1' : '0');
      if(this.personPhoto)fd.append('photo',this.personPhoto);

      try{
        const editing=!!this.personForm.id;
        const returnContext=this.personReturnContext;
        const url='<?= site_url('task-manager/team') ?>'
          +(editing?'/'+this.personForm.id:'');

        const response=await fetch(url,{
          method:'POST',
          headers:{
            'Accept':'application/json',
            'X-Requested-With':'XMLHttpRequest',
            'X-CSRF-TOKEN':csrfHash
          },
          body:fd
        });

        const data=await response.json();
        if(data.csrfHash)csrfHash=data.csrfHash;

        if(!response.ok||data.success===false){
          throw new Error(data.message||'Unable to save person.');
        }

        const member=data.member;
        const memberId=Number(member.id);

        // Synchronize every checked project in one operation.
        const memberships=this.personForm.project_ids.map(projectId=>({
          project_id:Number(projectId),
          role:this.personForm.project_roles[projectId]||'',
          role_description:this.personForm.project_role_descriptions[projectId]||'',
          responsibilities:this.textList(this.personForm.project_responsibilities[projectId]||'')
        }));

        await this.request(
          '<?= site_url('task-manager/team') ?>/'+memberId+'/projects',
          {
            method:'PUT',
            body:JSON.stringify({projects:memberships})
          }
        );

        this.closePersonModal(true);
        await this.loadTeam();
        await this.loadProjectPeople();
        await this.loadProjectAssignments();

        if(returnContext==='task-form'){
          if(!this.selectedTaskAssigneeIds.includes(memberId)){
            this.selectedTaskAssigneeIds=[
              ...this.selectedTaskAssigneeIds,
              memberId
            ];
          }
          this.taskModal=true;
        }

        if(returnContext==='assignee-modal'){
          if(!this.selectedAssigneeIds.includes(memberId)){
            this.selectedAssigneeIds=[
              ...this.selectedAssigneeIds,
              memberId
            ];
          }
          this.assigneeModal=true;
        }

        this.personReturnContext=null;

      }catch(e){
        this.teamError=e.message;
      }
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
        await this.loadProjectPeople();

        const validProjectPersonIds=this.projectPeople.map(
          person=>Number(person.id)
        );

        // Empty [] is valid and means "remove all assignees".
        const ids=this.selectedAssigneeIds
          .map(Number)
          .filter(id=>validProjectPersonIds.includes(id));

        const data=await this.request(
          '<?= site_url('task-manager/tasks') ?>/'+this.assignmentTask.id+'/assignees',
          {
            method:'PUT',
            body:JSON.stringify({team_member_ids:ids})
          }
        );

        this.taskAssignments={
          ...this.taskAssignments,
          [this.assignmentTask.id]:data.members||[]
        };

        this.closeAssigneeModal();

      }catch(e){
        alert(e.message);
      }
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
    // PHASE 7 — MEETINGS + AI MEETING INTELLIGENCE
    // --------------------------------------------------------------
    async openMeetings(){
      this.screen='meetings';
      this.selectedMeeting=null;

      // Meeting detail needs the People directory so participant IDs can
      // resolve to the real person's name, role and profile photo.
      await Promise.all([
        this.loadTeam(),
        this.loadProjectPeople(),
        this.loadMeetings()
      ]);
    },

    async loadMeetings(){
      this.meetingLoading=true;
      try{
        const suffix=this.currentProjectId ? '?project_id='+encodeURIComponent(this.currentProjectId) : '';
        const data=await this.request('<?= site_url('task-manager/meetings') ?>'+suffix);
        this.meetings=data.meetings||[];
      }catch(e){
        console.error(e); this.meetings=[];
      }finally{this.meetingLoading=false;}
    },

    async openMeeting(meeting){
      this.meetingLoading=true;
      try{
        const data=await this.request('<?= site_url('task-manager/meetings') ?>/'+meeting.id);
        this.applyMeetingDetail(data);
        await this.loadMeetingFiles(meeting.id);
      }catch(e){alert(e.message);}
      finally{this.meetingLoading=false;}
    },

    applyMeetingDetail(data){
      this.selectedMeeting=data.meeting||null;
      this.meetingParticipants=data.participants||[];
      this.meetingTranscripts=data.transcripts||[];
      this.meetingDecisions=data.decisions||[];
      this.meetingActionItems=data.action_items||[];
      this.meetingTranscriptText=this.meetingTranscripts.length ? (this.meetingTranscripts[this.meetingTranscripts.length-1].transcript_text||'') : '';
    },

    closeMeetingDetail(){
      this.selectedMeeting=null; this.meetingParticipants=[]; this.meetingTranscripts=[]; this.meetingDecisions=[]; this.meetingActionItems=[]; this.meetingFiles=[]; this.meetingTranscriptText='';
    },

    async openMeetingModal(meeting=null){
      this.meetingError='';
      let participantIds=[];
      if(meeting && this.selectedMeeting && Number(this.selectedMeeting.id)===Number(meeting.id)) participantIds=this.meetingParticipants.map(p=>Number(p.team_member_id));
      this.meetingForm=meeting ? {
        id:Number(meeting.id),project_id:Number(meeting.project_id),title:meeting.title||'',agenda:meeting.agenda||'',notes:meeting.notes||'',meeting_type:meeting.meeting_type||'project',status:meeting.status||'scheduled',start_at:this.toDateTimeLocal(meeting.start_at),end_at:this.toDateTimeLocal(meeting.end_at),location:meeting.location||'',participant_ids:participantIds
      } : {
        id:null,project_id:Number(this.currentProjectId||this.projects[0]?.id||0),title:'',agenda:'',notes:'',meeting_type:'project',status:'scheduled',start_at:'',end_at:'',location:'',participant_ids:[]
      };
      this.meetingModal=true;
    },

    closeMeetingModal(){this.meetingModal=false;this.meetingError='';},

    async saveMeeting(){
      if(!String(this.meetingForm.title||'').trim() || !Number(this.meetingForm.project_id)){this.meetingError='Project and title are required.';return;}
      this.meetingSaving=true; this.meetingError='';
      try{
        const editing=!!this.meetingForm.id;
        const url='<?= site_url('task-manager/meetings') ?>'+(editing?'/'+this.meetingForm.id:'');
        const payload={...this.meetingForm,start_at:this.meetingForm.start_at||null,end_at:this.meetingForm.end_at||null,participant_ids:this.meetingForm.participant_ids.map(Number)};
        const data=await this.request(url,{method:editing?'PUT':'POST',body:JSON.stringify(payload)});
        this.meetingModal=false;
        await this.loadMeetings();
        if(editing && this.selectedMeeting) await this.openMeeting(data.meeting);
      }catch(e){this.meetingError=e.message;}
      finally{this.meetingSaving=false;}
    },

    async deleteMeeting(meeting){
      if(!meeting || !confirm('Delete this meeting and its Phase 7 meeting records?'))return;
      try{await this.request('<?= site_url('task-manager/meetings') ?>/'+meeting.id,{method:'DELETE'});this.closeMeetingDetail();await this.loadMeetings();}
      catch(e){alert(e.message);}
    },

    async saveMeetingTranscript(){
      if(!this.selectedMeeting)return;
      const transcript=String(this.meetingTranscriptText||'').trim();
      if(!transcript){alert('Transcript is required.');return;}
      this.meetingTranscriptSaving=true;
      try{
        await this.request('<?= site_url('task-manager/meetings') ?>/'+this.selectedMeeting.id+'/transcripts',{method:'POST',body:JSON.stringify({transcript_text:transcript,source_type:'manual'})});
        await this.openMeeting(this.selectedMeeting);
      }catch(e){alert(e.message);}
      finally{this.meetingTranscriptSaving=false;}
    },

    async analyzeMeeting(){
      if(!this.selectedMeeting)return;
      this.meetingAnalyzing=true;
      try{
        await this.request('<?= site_url('task-manager/meetings') ?>/'+this.selectedMeeting.id+'/analyze',{method:'POST',body:JSON.stringify({})});
        await this.openMeeting(this.selectedMeeting);
      }catch(e){alert(e.message);}
      finally{this.meetingAnalyzing=false;}
    },

    async acceptMeetingAction(action,overrides={}){
      if(!this.selectedMeeting || !action)return;
      try{
        await this.request('<?= site_url('task-manager/meetings') ?>/'+this.selectedMeeting.id+'/actions/'+action.id,{method:'PUT',body:JSON.stringify({status:'accepted',...overrides})});
        await Promise.all([this.openMeeting(this.selectedMeeting),this.loadData()]);
      }catch(e){alert(e.message);}
    },

    async rejectMeetingAction(action){
      if(!this.selectedMeeting || !action)return;
      try{
        await this.request('<?= site_url('task-manager/meetings') ?>/'+this.selectedMeeting.id+'/actions/'+action.id,{method:'PUT',body:JSON.stringify({status:'rejected'})});
        await this.openMeeting(this.selectedMeeting);
      }catch(e){alert(e.message);}
    },

    meetingParticipantPerson(participant){
      const memberId=Number(
        participant?.team_member_id ??
        participant?.member_id ??
        participant?.person_id ??
        participant?.id ??
        0
      );

      // Some API responses may already include joined person information.
      // Prefer it when present, then fall back to the project's people list
      // and finally the complete team directory.
      if(participant?.person && typeof participant.person==='object'){
        return participant.person;
      }

      if(participant?.member && typeof participant.member==='object'){
        return participant.member;
      }

      const embeddedName=participant?.name || participant?.team_member_name || participant?.person_name;
      if(embeddedName){
        return {
          id:memberId,
          name:embeddedName,
          photo:participant?.photo || participant?.team_member_photo || participant?.person_photo || '',
          job_title:participant?.job_title || participant?.team_member_job_title || '',
          role:participant?.role || participant?.participant_role || ''
        };
      }

      return this.projectPeople.find(p=>Number(p.id)===memberId)
        || this.teamMembers.find(p=>Number(p.id)===memberId)
        || null;
    },

    meetingParticipantName(participant){
      const person=this.meetingParticipantPerson(participant);
      return person?.name || 'Team member #'+participant.team_member_id;
    },
    taskDetailUrl(taskId){
      return '<?= site_url('task-manager/tasks') ?>/'+Number(taskId)+'/detail';
    },

    async loadMeetingFiles(meetingId=null){
      const id=Number(meetingId || this.selectedMeeting?.id || 0);
      if(!id){this.meetingFiles=[];return;}
      this.meetingFileLoading=true;
      try{
        const data=await this.request('<?= site_url('task-manager/meetings') ?>/'+id+'/files');
        this.meetingFiles=data.files||[];
      }catch(e){console.error(e);this.meetingFiles=[];}
      finally{this.meetingFileLoading=false;}
    },

    async uploadMeetingFiles(event){
      const id=Number(this.selectedMeeting?.id||0);
      const files=[...(event.target.files||[])];
      if(!id || files.length===0)return;
      this.meetingFileUploading=true;
      try{
        const form=new FormData();
        files.forEach(file=>form.append('files[]',file));
        form.append(csrfName,csrfHash);
        const response=await fetch('<?= site_url('task-manager/meetings') ?>/'+id+'/files',{method:'POST',body:form,headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});
        const data=await response.json().catch(()=>({success:false,message:'Invalid server response'}));
        if(data.csrfHash)csrfHash=data.csrfHash;
        if(!response.ok || data.success===false)throw new Error(data.message||('HTTP '+response.status));
        event.target.value='';
        await this.loadMeetingFiles(id);
      }catch(e){alert(e.message);}
      finally{this.meetingFileUploading=false;}
    },

    meetingFileDownloadUrl(fileId){
      return '<?= site_url('task-manager/meeting-files') ?>/'+Number(fileId)+'/download';
    },

    async deleteMeetingFile(file){
      if(!file?.id || !confirm('Delete '+(file.file_name||'this file')+'?'))return;
      try{
        await this.request('<?= site_url('task-manager/meeting-files') ?>/'+file.id,{method:'DELETE',body:JSON.stringify({})});
        await this.loadMeetingFiles();
      }catch(e){alert(e.message);}
    },

    formatFileSize(bytes){
      const n=Number(bytes||0);if(!n)return '0 B';
      const units=['B','KB','MB','GB'];let value=n,index=0;
      while(value>=1024 && index<units.length-1){value/=1024;index++;}
      return (index===0?Math.round(value):value.toFixed(value>=10?0:1))+' '+units[index];
    },

    meetingAssigneeName(action){
      const id=Number(action.explicit_owner_id||action.suggested_assignee_id||0);
      const person=this.teamMembers.find(p=>Number(p.id)===id);
      return person?.name || (id ? 'Person #'+id : 'Unassigned');
    },
    meetingConfidence(value){
      const n=Number(value); if(Number.isNaN(n))return '';
      return Math.round((n<=1?n:n/100)*100)+'% confidence';
    },
    formatDateTime(value){
      if(!value)return 'Date not set';
      const d=new Date(String(value).replace(' ','T')); if(Number.isNaN(d.getTime()))return value;
      return d.toLocaleString([],{year:'numeric',month:'short',day:'numeric',hour:'numeric',minute:'2-digit'});
    },

    // --------------------------------------------------------------
    // ACTIVITY / AUDIT TRAIL
    // --------------------------------------------------------------
    async openActivity(){
      this.screen='activity';

      // Activity is a system-wide audit feed. Load the People directory as
      // well so every actor can be rendered with their real name/photo even
      // when an older activity response only contains an actor/member ID.
      await Promise.all([
        this.loadTeam(),
        this.loadActivity(true)
      ]);
    },

    async loadActivity(reset=true){
      if(this.activityLoading)return;

      if(reset){
        this.activityOffset=0;
        this.activities=[];
      }

      this.activityLoading=true;

      try{
        const query=new URLSearchParams({
          limit:'30',
          offset:String(this.activityOffset)
        });

        if(this.activityProjectId){
          query.set('project_id',this.activityProjectId);
        }

        if(this.activityType){
          query.set('type',this.activityType);
        }

        const data=await this.request(
          '<?= site_url('task-manager/activity') ?>?'+query.toString()
        );

        const rows=data.activities||[];

        this.activities=reset
          ? rows
          : [...this.activities,...rows];

        this.activityHasMore=!!data.has_more;
        this.activityOffset=Number(data.next_offset||this.activities.length);

      }catch(e){
        console.error(e);
        if(reset)this.activities=[];
      }finally{
        this.activityLoading=false;
      }
    },

    activityDate(value){
      if(!value)return null;
      return new Date(String(value).replace(' ','T'));
    },

    activityTime(value){
      const date=this.activityDate(value);
      if(!date || Number.isNaN(date.getTime()))return '';
      return date.toLocaleTimeString([],{
        hour:'numeric',
        minute:'2-digit'
      });
    },

    activityDayLabel(key){
      if(!key)return '';

      const date=new Date(key+'T00:00:00');
      const today=new Date();
      const yesterday=new Date();
      yesterday.setDate(today.getDate()-1);

      if(this.isoDate(date)===this.isoDate(today))return 'Today';
      if(this.isoDate(date)===this.isoDate(yesterday))return 'Yesterday';

      return date.toLocaleDateString(undefined,{
        weekday:'long',
        month:'short',
        day:'numeric',
        year:date.getFullYear()!==today.getFullYear()?'numeric':undefined
      });
    },

    activityActor(item){
      const meta=item?.metadata || {};
      const actorId=Number(
        item?.actor_id ??
        item?.team_member_id ??
        item?.user_id ??
        meta?.actor_id ??
        meta?.team_member_id ??
        0
      );

      // Prefer actor data joined by the Activity API.
      if(item?.actor && typeof item.actor==='object'){
        return item.actor;
      }

      const embeddedName=item?.actor_name || item?.person_name || item?.user_name;
      const embeddedPhoto=item?.actor_photo || item?.person_photo || item?.user_photo;

      if(embeddedName || embeddedPhoto){
        const directoryPerson=this.teamMembers.find(p=>Number(p.id)===actorId);
        return {
          ...(directoryPerson || {}),
          id:actorId || directoryPerson?.id || null,
          name:embeddedName || directoryPerson?.name || 'System',
          photo:embeddedPhoto || directoryPerson?.photo || ''
        };
      }

      return this.teamMembers.find(p=>Number(p.id)===actorId)
        || {id:null,name:'System',photo:''};
    },

    activityActorName(item){
      return this.activityActor(item)?.name || 'System';
    },

    activityActorPhoto(item){
      return this.activityActor(item)?.photo || '';
    },

    activityDescription(item){
      const descriptions={
        'task.created':'created a task',
        'task.updated':'updated a task',
        'task.completed':'completed a task',
        'task.reopened':'reopened a task',
        'task.deleted':'deleted a task',
        'task.assignees_changed':'updated task assignees',
        'task.assignment_delta':'changed task assignment',
        'category.created':'created a category',
        'category.updated':'updated a category',
        'category.deleted':'deleted a category',
        'person.added':'added a person to the project',
        'person.removed':'removed a person from the project',
        'schedule.created':'created a schedule item',
        'schedule.updated':'updated a schedule item',
        'schedule.deleted':'deleted a schedule item',
        'project.created':'created a project',
        'project.updated':'updated a project',
        'project.deleted':'deleted a project',
        'person.created':'created a person',
        'person.updated':'updated a person',
        'person.deleted':'deleted a person',
        'meeting.created':'created a meeting',
        'meeting.updated':'updated a meeting',
        'meeting.deleted':'deleted a meeting',
        'meeting.transcript_created':'added a meeting transcript',
        'meeting.analyzed':'analyzed a meeting with AI',
        'meeting.action_accepted':'accepted a meeting action item',
        'meeting.action_rejected':'rejected a meeting action item',
        'meeting.task_created':'created a task from a meeting',
        'ai.brief_generated':'generated an AI project brief',
        'ai.question_asked':'asked Project Intelligence a question',
        'ai.subtasks_generated':'generated AI subtask suggestions',
        'ai.subtasks_accepted':'created reviewed AI subtasks',
        'import.completed':'imported Markdown tasks'
      };

      return descriptions[item.action] || item.description || item.action || 'made a change';
    },

    activitySubject(item){
      const meta=item.metadata||{};

      if(meta.task)return '“'+meta.task+'”';
      if(meta.category)return '“'+meta.category+'”';
      if(meta.person)return meta.person;
      if(meta.title)return '“'+meta.title+'”';

      if(item.action==='import.completed'){
        return `${meta.imported||0} added · ${meta.skipped||0} skipped`;
      }

      return '';
    },

    activityAssignmentPeople(item,type){
      const raw=Array.isArray(item?.metadata?.[type]) ? item.metadata[type] : [];

      return raw.map(entry=>{
        const id=Number(
          (entry && typeof entry==='object' ? entry.id : entry) || 0
        );

        const directoryPerson=this.teamMembers.find(
          person=>Number(person.id)===id
        );

        const embedded=(entry && typeof entry==='object') ? entry : {};

        return {
          ...(directoryPerson || {}),
          id:id || directoryPerson?.id || embedded.id || 0,
          name:directoryPerson?.name || embedded.name || (id ? 'Person #'+id : 'Unknown person'),
          photo:directoryPerson?.photo || embedded.photo || ''
        };
      });
    },

    activityChanges(item){
      if(item?.action==='task.assignment_delta')return '';

      const changes=item.metadata?.changes;
      if(!changes || typeof changes!=='object')return '';

      return Object.entries(changes)
        .map(([field,value])=>{
          if(value && typeof value==='object' && ('from' in value || 'to' in value)){
            return `${field}: ${value.from ?? '—'} → ${value.to ?? '—'}`;
          }
          return `${field}: ${value ?? '—'}`;
        })
        .join(' · ');
    },

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

    textList(value){
      return String(value||'').split(/[,\n\r]+/).map(v=>v.trim()).filter(Boolean);
    },

    listText(value){
      if(Array.isArray(value))return value.join(', ');
      if(!value)return '';
      if(typeof value==='string'){
        try{const parsed=JSON.parse(value);if(Array.isArray(parsed))return parsed.join(', ');}catch(e){}
        return value;
      }
      return '';
    },

    async generateProjectBrief(){
      if(!this.currentProjectId)return;
      this.aiBriefLoading=true;
      try{
        const data=await this.request(
          `<?= site_url('task-manager/ai/projects') ?>/${this.currentProjectId}/brief`,
          {method:'POST'}
        );
        this.aiBrief=data.brief||null;
      }catch(e){alert(e.message);}
      finally{this.aiBriefLoading=false;}
    },

    async askProjectAi(){
      const question=this.aiQuestion.trim();
      if(!question||!this.currentProjectId)return;
      this.aiLoading=true;this.aiAnswer=null;
      try{
        const data=await this.request(
          `<?= site_url('task-manager/ai/projects') ?>/${this.currentProjectId}/ask`,
          {method:'POST',body:JSON.stringify({question})}
        );
        this.aiAnswer=data.result||null;
      }catch(e){alert(e.message);}
      finally{this.aiLoading=false;}
    },

    async generateAiSubtasks(taskId){
      if(!taskId)return;
      this.aiSubtaskLoading=true;
      try{
        const data=await this.request(
          `<?= site_url('task-manager/ai/tasks') ?>/${Number(taskId)}/breakdown`,
          {method:'POST'}
        );
        this.aiSubtaskTaskId=Number(taskId);
        this.aiSubtaskSummary=data.summary||'';
        this.aiSubtaskSuggestions=data.subtasks||[];
        this.selectedAiSuggestionIds=this.aiSubtaskSuggestions.map(v=>Number(v.suggestion_id));
        this.aiSubtaskModal=true;
      }catch(e){alert(e.message);}
      finally{this.aiSubtaskLoading=false;}
    },

    closeAiSubtaskModal(){
      this.aiSubtaskModal=false;
      this.aiSubtaskTaskId=null;
      this.aiSubtaskSummary='';
      this.aiSubtaskSuggestions=[];
      this.selectedAiSuggestionIds=[];
    },

    async acceptAiSubtasks(){
      if(!this.aiSubtaskTaskId||this.selectedAiSuggestionIds.length===0)return;
      this.aiSubtaskAccepting=true;
      try{
        const data=await this.request(
          `<?= site_url('task-manager/ai/tasks') ?>/${this.aiSubtaskTaskId}/accept-subtasks`,
          {method:'POST',body:JSON.stringify({suggestion_ids:this.selectedAiSuggestionIds.map(Number)})}
        );
        this.closeAiSubtaskModal();
        await this.loadData();
        alert(`${data.created_count||0} subtask(s) created.`);
      }catch(e){alert(e.message);}
      finally{this.aiSubtaskAccepting=false;}
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