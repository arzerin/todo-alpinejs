/*
 * Phase 2 Alpine.js additions
 *
 * Merge these properties/methods into the object returned by taskManager().
 *
 * Also add to the top navigation:
 * <a href="#" @click.prevent="openPeople()">People</a>
 *
 * Add to the project header:
 * <button @click="openProjectPeople()">People</button>
 *
 * In each task row replace the old assignee text with:
 *
 * <div class="avatar-stack" @click="openAssigneeModal(todo)" title="Assign people">
 *   <template x-for="person in taskPeople(todo.id).slice(0,3)" :key="person.id">
 *     <div class="mini-avatar">
 *       <img x-show="person.photo" :src="photoUrl(person.photo)">
 *       <span x-show="!person.photo" x-text="initials(person.name)"></span>
 *     </div>
 *   </template>
 *   <span class="avatar-more" x-show="taskPeople(todo.id).length > 3"
 *         x-text="'+'+(taskPeople(todo.id).length-3)"></span>
 *   <span class="avatar-empty" x-show="taskPeople(todo.id).length === 0">Assign</span>
 * </div>
 */

// --------------------------- STATE -------------------------------------------
// screen:'projects',
// teamMembers:[],
// projectPeople:[],
// taskAssignments:{},
// personModal:false,
// projectPeopleModal:false,
// assigneeModal:false,
// teamSaving:false,
// teamError:'',
// personPhoto:null,
// personPhotoPreview:'',
// personForm:{id:null,name:'',email:'',job_title:'',phone:'',status:'active',photo:''},
// projectMemberForm:{team_member_id:'',role:''},
// assignmentTask:null,
// selectedAssigneeIds:[],

// --------------------------- METHODS -----------------------------------------

async function loadTeam(){
    const d=await this.request('TEAM_INDEX_URL');
    this.teamMembers=d.members||[];
}

async function loadProjectPeople(){
    if(!this.currentProjectId){this.projectPeople=[];return}
    const d=await this.request('PROJECT_MEMBERS_URL/'+this.currentProjectId+'/members');
    this.projectPeople=d.members||[];
}

async function loadProjectAssignments(){
    if(!this.currentProjectId){this.taskAssignments={};return}
    const d=await this.request('PROJECT_ASSIGNMENTS_URL/'+this.currentProjectId+'/assignments');
    this.taskAssignments=d.assignments||{};
}

function taskPeople(taskId){
    return this.taskAssignments[Number(taskId)]||this.taskAssignments[String(taskId)]||[];
}

function initials(name){
    return String(name||'?').trim().split(/\s+/).slice(0,2).map(x=>x[0]||'').join('').toUpperCase();
}

function photoUrl(path){
    if(!path)return '';
    return SITE_BASE_URL+'/'+String(path).replace(/^\/+/,'');
}

async function openPeople(){
    this.screen='people';
    await this.loadTeam();
}

function openPersonModal(person=null){
    this.teamError='';
    this.personPhoto=null;
    this.personForm=person?{
        id:person.id,name:person.name||'',email:person.email||'',
        job_title:person.job_title||'',phone:person.phone||'',
        status:person.status||'active',photo:person.photo||''
    }:{id:null,name:'',email:'',job_title:'',phone:'',status:'active',photo:''};
    this.personPhotoPreview=person?.photo?this.photoUrl(person.photo):'';
    this.personModal=true;
}

function closePersonModal(){
    this.personModal=false;
    this.personPhoto=null;
    this.personPhotoPreview='';
}

function selectPersonPhoto(e){
    const file=e.target.files[0];
    if(!file)return;
    this.personPhoto=file;
    this.personPhotoPreview=URL.createObjectURL(file);
}

async function savePerson(){
    if(!this.personForm.name.trim()){this.teamError='Name is required.';return}
    this.teamSaving=true;this.teamError='';

    try{
        const fd=new FormData();
        ['name','email','job_title','phone','status'].forEach(k=>fd.append(k,this.personForm[k]||''));
        if(this.personPhoto)fd.append('photo',this.personPhoto);

        const edit=!!this.personForm.id;
        const url=TEAM_INDEX_URL+(edit?'/'+this.personForm.id:'');
        const r=await fetch(url,{
            method:'POST',
            headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':csrfHash},
            body:fd
        });
        const d=await r.json();
        if(d.csrfHash)csrfHash=d.csrfHash;
        if(!r.ok||d.success===false)throw new Error(d.message||'Unable to save person.');

        this.closePersonModal();
        await this.loadTeam();
        if(this.currentProjectId)await this.loadProjectPeople();
    }catch(e){this.teamError=e.message}
    finally{this.teamSaving=false}
}

async function deletePerson(person){
    if(!confirm(`Delete ${person.name}? Their project memberships and task assignments will also be removed.`))return;
    await this.request(TEAM_INDEX_URL+'/'+person.id,{method:'DELETE'});
    await this.loadTeam();
    if(this.currentProjectId){
        await this.loadProjectPeople();
        await this.loadProjectAssignments();
    }
}

async function openProjectPeople(){
    await Promise.all([this.loadTeam(),this.loadProjectPeople()]);
    this.projectMemberForm={team_member_id:'',role:''};
    this.projectPeopleModal=true;
}

function availableProjectPeople(){
    const used=new Set(this.projectPeople.map(p=>Number(p.id)));
    return this.teamMembers.filter(p=>p.status==='active'&&!used.has(Number(p.id)));
}

async function addPersonToProject(){
    if(!this.projectMemberForm.team_member_id)return;
    await this.request(PROJECT_MEMBERS_URL+'/'+this.currentProjectId+'/members',{
        method:'POST',
        body:JSON.stringify(this.projectMemberForm)
    });
    this.projectMemberForm={team_member_id:'',role:''};
    await Promise.all([this.loadProjectPeople(),this.loadTeam()]);
}

async function removePersonFromProject(person){
    if(!confirm(`Remove ${person.name} from ${this.currentProject.name}?`))return;
    await this.request(PROJECT_MEMBERS_URL+'/'+this.currentProjectId+'/members/'+person.id,{method:'DELETE'});
    await Promise.all([this.loadProjectPeople(),this.loadProjectAssignments(),this.loadTeam()]);
}

async function openAssigneeModal(task){
    await this.loadProjectPeople();
    this.assignmentTask=task;
    this.selectedAssigneeIds=this.taskPeople(task.id).map(p=>Number(p.id));
    this.assigneeModal=true;
}

function closeAssigneeModal(){
    this.assigneeModal=false;
    this.assignmentTask=null;
    this.selectedAssigneeIds=[];
}

function toggleAssigneeSelection(id){
    id=Number(id);
    this.selectedAssigneeIds=this.selectedAssigneeIds.includes(id)
        ?this.selectedAssigneeIds.filter(x=>x!==id)
        :[...this.selectedAssigneeIds,id];
}

async function saveTaskAssignees(){
    if(!this.assignmentTask)return;
    const d=await this.request(TASK_ASSIGNEE_URL+'/'+this.assignmentTask.id+'/assignees',{
        method:'PUT',
        body:JSON.stringify({team_member_ids:this.selectedAssigneeIds})
    });
    this.taskAssignments={...this.taskAssignments,[this.assignmentTask.id]:d.members||[]};
    this.closeAssigneeModal();
}
