<div class="col-md-3">
                    <h4 class="card-title">Add New Department</h4>
                    <hr class="bg-white">
                    <form action="" method="post" id="newDepartmentForm">
                       <!-- {{csrfkey}} -->
                        <div v-if="errors.length" class="alert alert-danger" role="alert">
                            <strong v-for="(erorr, key) in errors" :key="key">
                                <p>{{`${key}: ${erorr}`}}</p>
                            </strong>
                        </div>
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input type="text" v-model="deptData.department" name="department" id="department" class="form-control form-control-sm" placeholder="Department">
                        </div>

                        <div class="form-group">
                            <label for="department_code">Department Code</label>
                            <input type="text" v-model="deptData.department_code" name="department_code" id="department_code" class="form-control form-control-sm" placeholder="Department Code">
                        </div>
                        
                        <div class="form-group">
                           <button type="button" class="btn btn-danger btn-sm btn-block" 
                           @click.prevent="newDepartment">Create</button>
                        </div>
                    </form>
                </div>





                