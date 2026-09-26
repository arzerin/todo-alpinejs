<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($task['body'] ?? 'Task') ?> · Task Manager</title>
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



    /* Phase 7.1 — dedicated task detail, using dashboard shell */
    .task-detail-main{padding-top:34px}
    .task-detail-heading{display:flex;justify-content:space-between;gap:18px;align-items:flex-start;margin-bottom:8px}
    .task-detail-heading h1{margin:0;font-size:27px;line-height:1.25}
    .task-detail-meta{display:flex;gap:7px;align-items:center;flex-wrap:wrap;color:#888;font-size:12px;margin-top:8px}
    .task-detail-description{margin-top:22px;padding:15px 0;border-top:1px solid #e5e5e2;border-bottom:1px solid #e5e5e2;white-space:pre-wrap;font-size:14px;line-height:1.55}
    .task-discussion{margin-top:34px}
    .task-comment{display:grid;grid-template-columns:42px minmax(0,1fr);gap:11px;padding:17px 0;border-bottom:1px solid #ececec}
    .task-comment .person-avatar{width:38px;height:38px}.task-comment-avatar{overflow:hidden;border-radius:50%;flex:none}.task-comment-avatar img{width:100%;height:100%;object-fit:cover;display:block}
    .task-comment-head{font-size:12px}.task-comment-head time{color:#999;margin-left:6px}
    .task-comment-body{font-size:14px;line-height:1.55;white-space:pre-wrap;margin-top:6px}
    .task-comment-files{margin-top:8px;display:flex;flex-direction:column;align-items:flex-start;gap:5px}
    .task-file-link{font-size:12px;color:#4776a8;text-decoration:none}.task-file-link:hover{text-decoration:underline}
    .task-comment-form{margin-top:28px}.task-comment-form textarea{width:100%;min-height:120px}
    .task-comment-actions{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-top:9px}
    .task-attach-label{font-size:12px;font-weight:700;color:#4776a8;cursor:pointer}
    .task-selected-files{font-size:11px;color:#888;margin-top:7px}
    .task-selected-file{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:5px 0;border-bottom:1px solid #eee}
    .task-selected-file button{border:0;background:transparent;color:#a33;cursor:pointer;font-size:11px;padding:0}

    .task-side-block{margin-bottom:30px}.task-side-title{font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#777;border-bottom:1px solid #ddd;padding-bottom:8px;margin:0 0 8px}
    .task-side-file{padding:9px 0;border-bottom:1px solid #e7e7e5}.task-side-file a{display:block;color:#4776a8;font-size:12px;font-weight:700;text-decoration:none;overflow:hidden;text-overflow:ellipsis}.task-side-file a:hover{text-decoration:underline}.task-side-file small{display:block;color:#999;font-size:10px;margin-top:3px}
    .task-side-person{display:flex;align-items:center;gap:8px;padding:6px 0;font-size:12px}.task-side-person .person-avatar{width:32px;height:32px}
    .task-side-detail{font-size:12px;margin:11px 0}.task-side-detail strong{display:block;font-size:10px;text-transform:uppercase;color:#999;margin-bottom:2px}
    .task-upload-direct{display:inline-block;margin-top:10px;font-size:12px;font-weight:700;color:#4776a8;cursor:pointer}
    .task-empty{color:#999;font-size:12px;padding:10px 0}
    @media(max-width:800px){.task-detail-heading{flex-direction:column}.task-comment-actions{align-items:flex-start;flex-direction:column}}
</style>
</head>
<body>
<div class="app" x-data="taskDetail()" x-init="init()" x-cloak>
<header class="topbar">
    <div class="brand">
      <span class="brand-mark">B</span>
      <span>Task Manager</span>
    </div>

    <nav class="topnav" aria-label="Main navigation">
      <a href="<?= site_url('task-manager') ?>">Dashboard</a>
      <a href="<?= site_url('task-manager') ?>">Projects</a>
      <a href="<?= site_url('task-manager') ?>">My Tasks</a>
      <a href="<?= site_url('task-manager') ?>">Schedule</a>
      <a href="<?= site_url('task-manager') ?>">People</a>
      <a href="<?= site_url('task-manager') ?>">Meetings</a>
      <a href="<?= site_url('task-manager') ?>">Activity</a>
      <a href="<?= site_url('task-manager') ?>">Import</a>
    </nav>

    <div class="user-menu">
      <span>Project Manager</span>
      <span class="avatar">PM</span>
    </div>
  </header>

  <nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="<?= site_url('task-manager') ?>">Home</a>
    <span class="sep">›</span>
    <a href="<?= site_url('task-manager') ?>">Projects</a>
    <span class="sep">›</span>
    <strong x-text="project?.name || 'Project'"></strong>
    <span class="sep">›</span>
    <span>Task</span>
  </nav>

  <main class="main task-detail-main">
    <a class="meeting-back" href="<?= site_url('task-manager') ?>">← Back to project</a>

    <div class="task-detail-heading" style="margin-top:14px">
      <div>
        <h1 x-text="task?.body || ''"></h1>
        <div class="task-detail-meta">
          <span class="badge" x-text="task?.priority ? task.priority+' priority' : 'normal priority'"></span>
          <span x-show="category?.name" x-text="category?.name"></span>
          <span x-show="task?.due_date" x-text="'Due '+formatDate(task.due_date)"></span>
        </div>
      </div>
    </div>

    <div class="assignee-stack" x-show="assignees.length">
      <template x-for="person in assignees" :key="'head-'+person.id">
        <span class="mini-avatar" :title="person.name">
          <img x-show="person.photo" :src="photoUrl(person.photo)" :alt="person.name">
          <span x-show="!person.photo" x-text="initials(person.name)"></span>
        </span>
      </template>
      <span class="muted" style="margin-left:7px" x-text="assignees.map(p=>p.name).join(', ')"></span>
    </div>

    <div class="task-detail-description" x-show="task?.description" x-text="task?.description"></div>

    <section class="task-discussion">
      <div class="section-title">Discussion</div>

      <template x-for="comment in comments" :key="'comment-'+comment.id">
        <article class="task-comment">
          <span class="person-avatar small task-comment-avatar">
            <img x-show="comment.person?.photo || comment.person_photo"
                 :src="photoUrl(comment.person?.photo || comment.person_photo || '')"
                 :alt="comment.person?.name || comment.person_name || 'User'">
            <span x-show="!(comment.person?.photo || comment.person_photo)"
                  x-text="initials(comment.person?.name || comment.person_name || 'User')"></span>
          </span>
          <div>
            <div class="task-comment-head">
              <strong x-text="comment.person?.name || comment.person_name || 'User'"></strong>
              <time x-text="formatDateTime(comment.created_at)"></time>
            </div>
            <div class="task-comment-body" x-text="comment.body"></div>
            <div class="task-comment-files">
              <template x-for="file in comment.files || []" :key="'comment-file-'+file.id">
                <a class="task-file-link" :href="downloadUrl(file.id)">📎 <span x-text="file.file_name"></span> · Download</a>
              </template>
            </div>
          </div>
        </article>
      </template>

      <div class="task-empty" x-show="comments.length===0">No comments yet. Start the discussion below.</div>

      <div class="task-comment-form">
        <div class="section-title">Add a comment</div>
        <textarea x-model="commentBody" placeholder="Write a comment…" style="margin-top:12px"></textarea>
        <div class="task-comment-actions">
          <label class="task-attach-label">
            📎 Attach files
            <input type="file" name="comment_files[]" multiple hidden @change="addCommentFiles($event)">
          </label>
          <button class="btn btn-primary" @click="postComment()" :disabled="saving" x-text="saving ? 'Posting…' : 'Post comment'"></button>
        </div>
        <div class="task-selected-files" x-show="commentFiles.length">
          <strong x-text="commentFiles.length + (commentFiles.length === 1 ? ' file selected' : ' files selected')"></strong>
          <template x-for="(file, index) in commentFiles" :key="file.name+'-'+file.size+'-'+file.lastModified">
            <div class="task-selected-file">
              <span>📎 <span x-text="file.name"></span></span>
              <button type="button" @click="removeCommentFile(index)">Remove</button>
            </div>
          </template>
        </div>
      </div>
    </section>
  </main>

  <aside class="sidebar">
    <div class="task-side-block">
      <h2 class="task-side-title">Files</h2>
      <template x-for="file in files" :key="'side-file-'+file.id">
        <div class="task-side-file">
          <a :href="downloadUrl(file.id)" x-text="file.file_name"></a>
          <small>
            <span x-text="file.uploader_name || 'User'"></span>
            <span x-show="file.created_at" x-text="' · '+formatDate(file.created_at)"></span>
          </small>
        </div>
      </template>
      <div class="task-empty" x-show="files.length===0">No files uploaded.</div>
      <label class="task-upload-direct">
        + Upload files
        <input type="file" multiple hidden @change="uploadTaskFiles($event)">
      </label>
    </div>

    <div class="task-side-block">
      <h2 class="task-side-title">People</h2>
      <template x-for="person in assignees" :key="'side-person-'+person.id">
        <div class="task-side-person">
          <span class="person-avatar small">
            <img x-show="person.photo" :src="photoUrl(person.photo)" :alt="person.name">
            <span x-show="!person.photo" x-text="initials(person.name)"></span>
          </span>
          <div><strong x-text="person.name"></strong><div class="muted" x-text="person.job_title || person.email || 'Team member'"></div></div>
        </div>
      </template>
      <div class="task-empty" x-show="assignees.length===0">No assignees.</div>
    </div>

    <div class="task-side-block">
      <h2 class="task-side-title">Details</h2>
      <div class="task-side-detail"><strong>Project</strong><span x-text="project?.name || '—'"></span></div>
      <div class="task-side-detail"><strong>Category</strong><span x-text="category?.name || '—'"></span></div>
      <div class="task-side-detail"><strong>Due</strong><span x-text="task?.due_date ? formatDate(task.due_date) : 'No due date'"></span></div>
      <div class="task-side-detail"><strong>Priority</strong><span x-text="task?.priority || 'normal'"></span></div>
    </div>
  </aside>

  <footer class="footer">Task Manager · Project workspace</footer>
</div>

<script>
let csrfHash=<?= json_encode(csrf_hash()) ?>;
function taskDetail(){
  return {
    task:null,project:null,category:null,assignees:[],comments:[],files:[],
    commentBody:'',commentFiles:[],saving:false,

    async init(){ await this.load(); },

    async load(){
      const response=await fetch(<?= json_encode(site_url('task-manager/tasks/'.$task['id'].'/detail-data')) ?>,{
        headers:{Accept:'application/json','X-Requested-With':'XMLHttpRequest'}
      });
      const data=await response.json();
      if(data.csrfHash)csrfHash=data.csrfHash;
      if(!response.ok || data.success===false)throw new Error(data.message || 'Unable to load task.');
      this.task=data.task;this.project=data.project;this.category=data.category;
      this.assignees=data.assignees || [];this.comments=data.comments || [];this.files=data.files || [];
    },

    addCommentFiles(event){
      const selected=Array.from(event.target.files || []);
      selected.forEach(file=>{
        const duplicate=this.commentFiles.some(existing =>
          existing.name===file.name &&
          existing.size===file.size &&
          existing.lastModified===file.lastModified
        );
        if(!duplicate)this.commentFiles.push(file);
      });

      // Important: clear native input so user can reopen the picker and
      // add more files, including selecting the same filename again later.
      event.target.value='';
    },

    removeCommentFile(index){
      this.commentFiles.splice(index,1);
    },

    async postComment(){
      if(!this.commentBody.trim())return;
      this.saving=true;
      try{
        const fd=new FormData();
        fd.append('body',this.commentBody);
        // Send every selected attachment under the same files[] field.
        this.commentFiles.forEach(file => fd.append('files[]', file));
        fd.append('<?= csrf_token() ?>',csrfHash);
        const response=await fetch(<?= json_encode(site_url('task-manager/tasks/'.$task['id'].'/comments')) ?>,{
          method:'POST',body:fd,headers:{Accept:'application/json','X-Requested-With':'XMLHttpRequest'}
        });
        const data=await response.json();if(data.csrfHash)csrfHash=data.csrfHash;
        if(!response.ok || data.success===false)throw new Error(data.message || 'Unable to post comment.');
        this.commentBody='';this.commentFiles=[];await this.load();
      }catch(error){alert(error.message)}finally{this.saving=false}
    },

    async uploadTaskFiles(event){
      const selected=[...(event.target.files || [])];if(!selected.length)return;
      const fd=new FormData();selected.forEach(file=>fd.append('files[]',file));fd.append('<?= csrf_token() ?>',csrfHash);
      try{
        const response=await fetch(<?= json_encode(site_url('task-manager/tasks/'.$task['id'].'/files')) ?>,{
          method:'POST',body:fd,headers:{Accept:'application/json','X-Requested-With':'XMLHttpRequest'}
        });
        const data=await response.json();if(data.csrfHash)csrfHash=data.csrfHash;
        if(!response.ok || data.success===false)throw new Error(data.message || 'Upload failed.');
        event.target.value='';await this.load();
      }catch(error){alert(error.message)}
    },

    downloadUrl(id){return <?= json_encode(site_url('task-manager/task-files')) ?>+'/'+id+'/download';},
    photoUrl(photo){if(!photo)return '';if(/^https?:\/\//i.test(photo))return photo;return <?= json_encode(base_url()) ?>+String(photo).replace(/^\/+/,'');},
    initials(name){return String(name||'?').trim().split(/\s+/).filter(Boolean).slice(0,2).map(part=>part[0]).join('').toUpperCase();},
    formatDate(value){if(!value)return '';const d=new Date(String(value).replace(' ','T'));return isNaN(d)?value:d.toLocaleDateString(undefined,{month:'short',day:'numeric',year:'numeric'});},
    formatDateTime(value){if(!value)return '';const d=new Date(String(value).replace(' ','T'));return isNaN(d)?value:d.toLocaleString(undefined,{month:'short',day:'numeric',hour:'numeric',minute:'2-digit'});}
  }
}
</script>
</body>
</html>
