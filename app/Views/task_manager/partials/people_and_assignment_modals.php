<!--
Phase 2 People Directory partial.
Include inside the existing dashboard layout or use as the body for a dedicated
People view. It expects the Alpine methods/state from phase2_team_alpine.js.
-->

<section class="people-page" x-show="screen === 'people'" x-cloak>
    <div class="people-header">
        <div>
            <h1>People</h1>
            <p>Everyone working across your projects.</p>
        </div>
        <button class="people-primary" @click="openPersonModal()">+ Add person</button>
    </div>

    <div class="people-grid">
        <template x-for="person in teamMembers" :key="person.id">
            <article class="person-card">
                <div class="person-card-actions">
                    <button @click="openPersonModal(person)" title="Edit">✎</button>
                    <button @click="deletePerson(person)" title="Delete">×</button>
                </div>

                <div class="person-photo">
                    <img x-show="person.photo" :src="photoUrl(person.photo)" :alt="person.name">
                    <span x-show="!person.photo" x-text="initials(person.name)"></span>
                </div>

                <h3 x-text="person.name"></h3>
                <div class="person-role" x-text="person.job_title || 'Team member'"></div>

                <div class="person-stats">
                    <div><strong x-text="person.active_task_count || 0"></strong><span>Active tasks</span></div>
                    <div><strong x-text="person.projects?.length || 0"></strong><span>Projects</span></div>
                </div>

                <div class="person-projects">
                    <template x-for="p in (person.projects || []).slice(0,3)" :key="p.id">
                        <span x-text="p.name"></span>
                    </template>
                </div>
            </article>
        </template>
    </div>
</section>

<!-- Add/Edit Person -->
<div class="modal-backdrop" x-show="personModal" @click.self="closePersonModal()" x-cloak>
    <div class="modal">
        <h3 x-text="personForm.id ? 'Edit person' : 'Add person'"></h3>

        <div class="person-upload-preview">
            <img x-show="personPhotoPreview" :src="personPhotoPreview">
            <span x-show="!personPhotoPreview" x-text="initials(personForm.name || 'New Person')"></span>
        </div>

        <div class="field">
            <label>Profile picture</label>
            <input type="file" accept="image/jpeg,image/png,image/webp"
                   @change="selectPersonPhoto($event)">
        </div>

        <div class="field"><label>Name</label><input x-model="personForm.name"></div>
        <div class="field"><label>Email</label><input type="email" x-model="personForm.email"></div>
        <div class="field"><label>Job title</label><input x-model="personForm.job_title"></div>
        <div class="field"><label>Phone</label><input x-model="personForm.phone"></div>

        <div class="field">
            <label>Status</label>
            <select x-model="personForm.status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="error-box" x-show="teamError" x-text="teamError"></div>

        <div class="modal-actions">
            <button class="btn" @click="closePersonModal()">Cancel</button>
            <button class="btn btn-primary" @click="savePerson()" :disabled="teamSaving">
                <span x-text="teamSaving ? 'Saving…' : 'Save person'"></span>
            </button>
        </div>
    </div>
</div>

<!-- Project People -->
<div class="modal-backdrop" x-show="projectPeopleModal" @click.self="projectPeopleModal=false" x-cloak>
    <div class="modal modal-wide">
        <h3>Project team</h3>
        <p class="modal-subtitle" x-text="currentProject.name"></p>

        <div class="project-member-add">
            <select x-model="projectMemberForm.team_member_id">
                <option value="">Select a person…</option>
                <template x-for="person in availableProjectPeople" :key="person.id">
                    <option :value="person.id" x-text="person.name + (person.job_title ? ' · '+person.job_title : '')"></option>
                </template>
            </select>
            <input x-model="projectMemberForm.role" placeholder="Role on project">
            <button class="btn btn-primary" @click="addPersonToProject()">Add</button>
        </div>

        <div class="project-member-list">
            <template x-for="person in projectPeople" :key="person.id">
                <div class="project-member-row">
                    <div class="mini-avatar">
                        <img x-show="person.photo" :src="photoUrl(person.photo)">
                        <span x-show="!person.photo" x-text="initials(person.name)"></span>
                    </div>
                    <div class="project-member-info">
                        <strong x-text="person.name"></strong>
                        <small x-text="person.role || person.job_title || 'Team member'"></small>
                    </div>
                    <button class="delete" @click="removePersonFromProject(person)">×</button>
                </div>
            </template>
        </div>

        <div class="modal-actions">
            <button class="btn" @click="projectPeopleModal=false">Close</button>
        </div>
    </div>
</div>

<!-- Task Assignee Picker -->
<div class="modal-backdrop" x-show="assigneeModal" @click.self="closeAssigneeModal()" x-cloak>
    <div class="modal">
        <h3>Assign people</h3>
        <p class="modal-subtitle" x-text="assignmentTask?.body || ''"></p>

        <div class="assignee-list">
            <template x-for="person in projectPeople" :key="person.id">
                <label class="assignee-option">
                    <input type="checkbox"
                           :value="person.id"
                           :checked="selectedAssigneeIds.includes(Number(person.id))"
                           @change="toggleAssigneeSelection(person.id)">
                    <div class="mini-avatar">
                        <img x-show="person.photo" :src="photoUrl(person.photo)">
                        <span x-show="!person.photo" x-text="initials(person.name)"></span>
                    </div>
                    <div>
                        <strong x-text="person.name"></strong>
                        <small x-text="person.job_title || 'Team member'"></small>
                    </div>
                </label>
            </template>
        </div>

        <div class="modal-actions">
            <button class="btn" @click="closeAssigneeModal()">Cancel</button>
            <button class="btn btn-primary" @click="saveTaskAssignees()">Save assignments</button>
        </div>
    </div>
</div>
